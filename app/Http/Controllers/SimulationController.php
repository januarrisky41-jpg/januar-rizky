<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Simulation;
use Barryvdh\DomPDF\Facade\Pdf;

class SimulationController extends Controller
{
    public function general()
    {
        $property = null;
        return view('simulation.index', compact('property'));
    }

    public function index($id)
    {
        $property = Property::findOrFail($id);
        return view('simulation.index', compact('property'));
    }

    public function calculate(Request $request)
    {
        // ============================================================
        // 1. AMBIL DATA DARI FORM
        // ============================================================

        $price = (float) str_replace(['.', ','], '', $request->harga_properti);
        $income = (float) str_replace(['.', ','], '', $request->income);
        $dp = (float) str_replace(['.', ','], '', $request->dp);
        $propertyTitle = $request->property_title ?? 'Simulasi Umum';
        $interestFix = (float) $request->interest / 100;
        $interestFloat = (float) $request->interest_floating / 100;
        $tenorYears = (int) $request->tenor;
        $fixYears = (int) $request->fix_years;

        // ============================================================
        // 2. VALIDASI
        // ============================================================

        if ($price <= 0) $price = 400000000;
        if ($income <= 0) $income = 15000000;
        if ($dp <= 0) $dp = $price * 0.25;
        if ($interestFix <= 0) $interestFix = 0.06;
        if ($interestFloat <= 0) $interestFloat = 0.13;
        if ($tenorYears <= 0) $tenorYears = 5;
        if ($fixYears < 0) $fixYears = 3;

        // ============================================================
        // 3. HITUNG PERIODE
        // ============================================================

        $months = $tenorYears * 12;        // 60 bulan
        $fixMonths = $fixYears * 12;       // 36 bulan
        $floatMonths = $months - $fixMonths; // 24 bulan

        if ($floatMonths < 0) $floatMonths = 0;

        // ============================================================
        // 4. HITUNG POKOK KREDIT
        // ============================================================

        $principal = $price - $dp;
        $monthlyInterestFix = $interestFix / 12;
        $monthlyInterestFloat = $interestFloat / 12;

        // ============================================================
        // 5. KRITIKAL: HITUNG ANGSURAN FIX DENGAN TENOR 60 BULAN!
        // ============================================================
        // Gunakan seluruh tenor (60 bulan) untuk menghitung angsuran fix
        // ============================================================

        if ($monthlyInterestFix > 0 && $months > 0) {
            $powTotal = pow(1 + $monthlyInterestFix, $months);
            $installmentFix = $principal * ($monthlyInterestFix * $powTotal) / ($powTotal - 1);
        } else {
            $installmentFix = $principal / $months;
        }

        // ============================================================
        // 6. HITUNG SISA POKOK SETELAH 36 BULAN
        // ============================================================
        // Loop untuk menghitung sisa pokok setelah 36 bulan
        // ============================================================

        $remainingPrincipal = $principal;

        if ($fixMonths > 0 && $installmentFix > 0) {
            $tempBalance = $principal;
            for ($i = 1; $i <= $fixMonths; $i++) {
                $interestPaid = $tempBalance * $monthlyInterestFix;
                $principalPaid = $installmentFix - $interestPaid;
                if ($principalPaid > $tempBalance) {
                    $principalPaid = $tempBalance;
                }
                $tempBalance -= $principalPaid;
                if ($tempBalance < 0) $tempBalance = 0;
            }
            $remainingPrincipal = max(0, $tempBalance);
        }

        // ============================================================
        // 7. HITUNG ANGSURAN FLOATING (SISA 24 BULAN)
        // ============================================================

        if ($floatMonths > 0 && $monthlyInterestFloat > 0) {
            $powFloat = pow(1 + $monthlyInterestFloat, $floatMonths);
            $installmentFloat = $remainingPrincipal * ($monthlyInterestFloat * $powFloat) / ($powFloat - 1);
        } elseif ($floatMonths > 0) {
            $installmentFloat = $remainingPrincipal / $floatMonths;
        } else {
            $installmentFloat = 0;
        }

        // ============================================================
        // 8. JIKA TIDAK ADA MASA FIX
        // ============================================================

        if ($fixMonths == 0) {
            if ($monthlyInterestFloat > 0 && $months > 0) {
                $powAll = pow(1 + $monthlyInterestFloat, $months);
                $installmentFloat = $principal * ($monthlyInterestFloat * $powAll) / ($powAll - 1);
            } else {
                $installmentFloat = $principal / $months;
            }
            $installmentFix = $installmentFloat;
            $remainingPrincipal = $principal;
        }

        // ============================================================
        // 9. ANGSURAN YANG DITAMPILKAN
        // ============================================================

        $displayInstallment = $installmentFix;

        // ============================================================
        // 10. TOTAL BUNGA & TOTAL PEMBAYARAN
        // ============================================================

        $totalFixPayment = $installmentFix * $fixMonths;
        $totalFloatPayment = $installmentFloat * $floatMonths;
        $totalPayment = $totalFixPayment + $totalFloatPayment;
        $totalInterest = max(0, $totalPayment - $principal);

        $dpPercentage = $price > 0 ? ($dp / $price) * 100 : 0;

        // ============================================================
        // 11. RASIO CICILAN
        // ============================================================

        $installmentPercentage = $income > 0 ? ($displayInstallment / $income) * 100 : 0;

        // ============================================================
        // 12. STATUS KELAYAKAN
        // ============================================================

        if ($installmentPercentage <= 30) {
            $status = 'Layak';
            $statusClass = 'success';
            $statusIcon = '✅';
            $statusMessage = 'Cicilan Anda masih dalam batas wajar (≤ 30% dari penghasilan).';
        } elseif ($installmentPercentage <= 40) {
            $status = 'Dipertimbangkan';
            $statusClass = 'warning';
            $statusIcon = '⚠️';
            $statusMessage = 'Cicilan Anda berada di ambang batas (30-40% dari penghasilan).';
        } else {
            $status = 'Tidak Layak';
            $statusClass = 'danger';
            $statusIcon = '❌';
            $statusMessage = 'Cicilan Anda terlalu tinggi (> 40% dari penghasilan). Risiko gagal bayar.';
        }

        // ============================================================
        // 13. REKOMENDASI
        // ============================================================

        $maxInstallment = $income * 0.30;

        $usedRate = max($interestFix, $interestFloat);
        $usedMonthlyRate = $usedRate / 12;

        if ($usedMonthlyRate > 0 && $months > 0) {
            $powRec = pow(1 + $usedMonthlyRate, $months);
            $recommendedBudget = $maxInstallment * ($powRec - 1) / ($usedMonthlyRate * $powRec) + $dp;
        } else {
            $recommendedBudget = $maxInstallment * $months + $dp;
        }

        if ($recommendedBudget < 0 || !is_finite($recommendedBudget)) {
            $recommendedBudget = $price;
        }

        $dpIdeal = $price * 0.20;
        $dpBetter = $price * 0.30;

        if ($installmentPercentage > 40) {
            $recommendedTenor = '20 Tahun';
            $tenorMessage = 'Perpanjang tenor untuk menurunkan cicilan.';
        } elseif ($installmentPercentage > 30) {
            $recommendedTenor = '15 Tahun';
            $tenorMessage = 'Tenor 15 tahun dengan DP lebih besar untuk hasil optimal.';
        } else {
            $recommendedTenor = $tenorYears . ' Tahun';
            $tenorMessage = 'Tenor saat ini sudah sesuai dengan kemampuan finansial.';
        }

        // ============================================================
        // 14. TABEL AMORTISASI - 60 BULAN LENGKAP
        // ============================================================

        $amortizationSchedule = [];
        $tempBalance = $principal;
        $totalInterestPaid = 0;

        for ($i = 1; $i <= $months; $i++) {
            // Tentukan periode
            if ($fixMonths > 0 && $i <= $fixMonths) {
                $period = 'Fix ' . $fixYears . ' Tahun';
                $currentMonthlyRate = $monthlyInterestFix;
                $currentAnnualRate = $interestFix;
                $currentInstallment = $installmentFix;
            } else {
                $period = 'Floating';
                $currentMonthlyRate = $monthlyInterestFloat;
                $currentAnnualRate = $interestFloat;
                $currentInstallment = $installmentFloat;
            }

            // Hitung bunga dan pokok
            $interestPaid = $tempBalance * $currentMonthlyRate;
            $principalPaid = $currentInstallment - $interestPaid;

            // Bulan terakhir atau sisa pinjaman lunas
            if ($i == $months || $tempBalance <= 0.01) {
                $principalPaid = $tempBalance;
                $currentInstallment = $tempBalance + $interestPaid;
            }

            // Pastikan tidak negatif
            if ($principalPaid < 0) $principalPaid = 0;
            if ($interestPaid < 0) $interestPaid = 0;
            if ($currentInstallment < 0) $currentInstallment = 0;

            $tempBalance -= $principalPaid;
            if ($tempBalance < 0) $tempBalance = 0;
            $totalInterestPaid += $interestPaid;

            $amortizationSchedule[] = [
                'month' => $i,
                'remaining_balance' => $tempBalance,
                'principal_paid' => $principalPaid,
                'interest_paid' => $interestPaid,
                'installment' => $currentInstallment,
                'interest_rate' => round($currentAnnualRate * 100, 2),
                'period' => $period
            ];

            if ($tempBalance <= 0) {
                break;
            }
        }

        // ============================================================
        // 15. STATISTIK
        // ============================================================

        $totalPrincipalPaid = array_sum(array_column($amortizationSchedule, 'principal_paid'));
        $totalInterestPaidAll = array_sum(array_column($amortizationSchedule, 'interest_paid'));
        $totalInstallmentAll = array_sum(array_column($amortizationSchedule, 'installment'));

        // ============================================================
        // 16. REKOMENDASI PROPERTI
        // ============================================================

        $recommendedProperties = Property::where('price', '<=', $recommendedBudget)
            ->orderBy('price', 'desc')
            ->take(3)
            ->get();

        // ============================================================
        // 17. SIMPAN KE DATABASE
        // ============================================================

        Simulation::create([
            'name' => 'User Simulation',
            'income' => $income,
            'house_price' => $price,
            'down_payment' => $dp,
            'tenor' => $tenorYears,
            'interest' => $request->interest,
            'monthly_installment' => $displayInstallment,
            'status' => $status
        ]);

        // ============================================================
        // 18. RETURN VIEW
        // ============================================================

        return view('simulation.result', compact(
            'propertyTitle',
            'price',
            'dp',
            'dpPercentage',
            'principal',
            'tenorYears',
            'months',
            'fixYears',
            'fixMonths',
            'floatMonths',
            'interestFix',
            'interestFloat',
            'monthlyInterestFix',
            'monthlyInterestFloat',
            'installmentFix',
            'installmentFloat',
            'displayInstallment',
            'totalPayment',
            'totalInterest',
            'income',
            'installmentPercentage',
            'status',
            'statusClass',
            'statusIcon',
            'statusMessage',
            'recommendedBudget',
            'dpIdeal',
            'dpBetter',
            'recommendedTenor',
            'tenorMessage',
            'recommendedProperties',
            'amortizationSchedule',
            'totalInterestPaid',
            'totalPrincipalPaid',
            'totalInstallmentAll',
            'totalInterestPaidAll',
            'remainingPrincipal'
        ));
    }

    public function downloadPdf()
    {
        $simulation = Simulation::latest()->first();

        if (!$simulation) {
            return redirect('/simulation');
        }

        $recommendedProperties = Property::where('price', '<=', $simulation->house_price)
            ->orderBy('price', 'desc')
            ->take(3)
            ->get();

        $pdf = Pdf::loadView('simulation.pdf', compact('simulation', 'recommendedProperties'));
        return $pdf->download('laporan-simulasi-kpr.pdf');
    }
}