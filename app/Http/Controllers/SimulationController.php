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

        $price = (float) str_replace('.', '', $request->harga_properti);
        $propertyTitle = $request->property_title;
        $income = (float) str_replace('.', '', $request->income);
        $dp = (float) str_replace('.', '', $request->dp);
        $interestFix = (float) $request->interest / 100;
        $interestFloat = (float) $request->interest_floating / 100;
        $tenorYears = (int) $request->tenor;
        $fixYears = (int) $request->fix_years;
        $months = $tenorYears * 12;
        $fixMonths = $fixYears * 12;
        $floatMonths = $months - $fixMonths;

        // ============================================================
        // 2. VALIDASI
        // ============================================================

        if ($fixMonths <= 0) $fixMonths = 1;
        if ($floatMonths <= 0) $floatMonths = 1;

        // ============================================================
        // 3. HITUNG POKOK KREDIT
        // ============================================================

        $principal = $price - $dp;

        // ============================================================
        // 4. HITUNG ANGSURAN FIX
        // ============================================================

        $monthlyInterestFix = $interestFix / 12;
        $monthlyInterestFloat = $interestFloat / 12;

        if ($monthlyInterestFix > 0 && $fixMonths > 0) {
            $powFix = pow(1 + $monthlyInterestFix, $fixMonths);
            $remainingPrincipal = $principal - ($principal * (1 - (1 / $powFix)));
            $installment = $principal * ($monthlyInterestFix * $powFix) / ($powFix - 1);
        } else {
            $installment = $principal / $fixMonths;
            $remainingPrincipal = $principal;
        }

        // ============================================================
        // 5. HITUNG ANGSURAN FLOATING
        // ============================================================

        if ($monthlyInterestFloat > 0 && $floatMonths > 0) {
            $powFloat = pow(1 + $monthlyInterestFloat, $floatMonths);
            $installmentFloat = $remainingPrincipal * ($monthlyInterestFloat * $powFloat) / ($powFloat - 1);
        } else {
            $installmentFloat = $remainingPrincipal / $floatMonths;
        }

        if (!is_finite($installmentFloat) || $installmentFloat < 0) {
            $installmentFloat = $remainingPrincipal / $floatMonths;
        }

        // ============================================================
        // 6. TOTAL BUNGA & TOTAL PEMBAYARAN
        // ============================================================

        $totalFixPayment = $installment * $fixMonths;
        $totalFloatPayment = $installmentFloat * $floatMonths;
        $totalPayment = $totalFixPayment + $totalFloatPayment;
        $totalInterest = $totalPayment - $principal;
        $dpPercentage = $price > 0 ? ($dp / $price) * 100 : 0;

        // ============================================================
        // 7. RASIO CICILAN
        // ============================================================

        $installmentPercentage = $income > 0 ? ($installmentFloat / $income) * 100 : 0;

        // ============================================================
        // 8. STATUS KELAYAKAN
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
        // 9. REKOMENDASI BUDGET PROPERTI (FIX)
        // ============================================================

        $maxInstallment = $income * 0.30;

        if ($monthlyInterestFix > 0 && $fixMonths > 0) {
            $recommendedBudget = $maxInstallment * ($powFix - 1) / ($monthlyInterestFix * $powFix) + $dp;
        } else {
            $recommendedBudget = $maxInstallment * $months + $dp;
        }

        if ($recommendedBudget < 0) {
            $recommendedBudget = $price;
        }

        // ============================================================
        // 10. REKOMENDASI DP IDEAL
        // ============================================================

        $dpIdeal = $price * 0.20;
        $dpBetter = $price * 0.30;

        // ============================================================
        // 11. REKOMENDASI TENOR
        // ============================================================

        if ($installmentPercentage > 40) {
            if ($tenorYears < 15) {
                $recommendedTenor = '20 Tahun';
                $tenorMessage = 'Perpanjang tenor menjadi 20 tahun untuk menurunkan cicilan.';
            } elseif ($tenorYears < 20) {
                $recommendedTenor = '25 Tahun';
                $tenorMessage = 'Perpanjang tenor menjadi 25 tahun untuk menurunkan cicilan.';
            } else {
                $recommendedTenor = '30 Tahun';
                $tenorMessage = 'Perpanjang tenor menjadi 30 tahun untuk menurunkan cicilan.';
            }
        } elseif ($installmentPercentage > 30) {
            $recommendedTenor = '15 Tahun';
            $tenorMessage = 'Tenor 15 tahun dengan DP lebih besar untuk hasil optimal.';
        } else {
            $recommendedTenor = $tenorYears . ' Tahun';
            $tenorMessage = 'Tenor saat ini sudah sesuai dengan kemampuan finansial.';
        }

        // ============================================================
        // 12. SIMULASI ALTERNATIF
        // ============================================================

        $alternativeTenor = 20;
        $altMonths = $alternativeTenor * 12;
        $altFixMonths = $fixYears * 12;
        $altFloatMonths = $altMonths - $altFixMonths;

        if ($altFixMonths <= 0) $altFixMonths = 1;
        if ($altFloatMonths <= 0) $altFloatMonths = 1;

        if ($monthlyInterestFix > 0 && $altFixMonths > 0) {
            $altPowFix = pow(1 + $monthlyInterestFix, $altFixMonths);
            $altRemaining = $principal - ($principal * (1 - (1 / $altPowFix)));
            $altInstallment = $principal * ($monthlyInterestFix * $altPowFix) / ($altPowFix - 1);
        } else {
            $altInstallment = $principal / $altFixMonths;
            $altRemaining = $principal;
        }

        if ($monthlyInterestFloat > 0 && $altFloatMonths > 0) {
            $altPowFloat = pow(1 + $monthlyInterestFloat, $altFloatMonths);
            $altInstallmentFloat = $altRemaining * ($monthlyInterestFloat * $altPowFloat) / ($altPowFloat - 1);
        } else {
            $altInstallmentFloat = $altRemaining / $altFloatMonths;
        }

        // ============================================================
        // 13. TABEL AMORTISASI
        // ============================================================

        $amortizationSchedule = [];
        $remainingBalance = $principal;
        $totalInterestPaid = 0;

        for ($i = 1; $i <= $fixMonths; $i++) {
            $interestPaid = $remainingBalance * $monthlyInterestFix;
            $principalPaid = $installment - $interestPaid;
            
            if ($i == $fixMonths) {
                $principalPaid = $remainingBalance;
                $installment = $remainingBalance + $interestPaid;
            }
            
            $remainingBalance -= $principalPaid;
            $totalInterestPaid += $interestPaid;

            $amortizationSchedule[] = [
                'month' => $i,
                'remaining_balance' => max(0, $remainingBalance),
                'principal_paid' => $principalPaid,
                'interest_paid' => $interestPaid,
                'installment' => $installment,
                'interest_rate' => round($interestFix * 100, 2),
                'period' => 'Fix'
            ];

            if ($remainingBalance <= 0) break;
        }

        $floatStartMonth = $fixMonths + 1;
        for ($i = $floatStartMonth; $i <= $months; $i++) {
            $interestPaid = $remainingBalance * $monthlyInterestFloat;
            $principalPaid = $installmentFloat - $interestPaid;
            
            if ($i == $months) {
                $principalPaid = $remainingBalance;
                $installmentFloat = $remainingBalance + $interestPaid;
            }
            
            $remainingBalance -= $principalPaid;
            $totalInterestPaid += $interestPaid;

            $amortizationSchedule[] = [
                'month' => $i,
                'remaining_balance' => max(0, $remainingBalance),
                'principal_paid' => $principalPaid,
                'interest_paid' => $interestPaid,
                'installment' => $installmentFloat,
                'interest_rate' => round($interestFloat * 100, 2),
                'period' => 'Floating'
            ];

            if ($remainingBalance <= 0) break;
        }

        // ============================================================
        // 14. STATISTIK AMORTISASI
        // ============================================================

        $totalPrincipalPaid = array_sum(array_column($amortizationSchedule, 'principal_paid'));
        $totalInterestPaidAll = array_sum(array_column($amortizationSchedule, 'interest_paid'));
        $totalInstallmentAll = array_sum(array_column($amortizationSchedule, 'installment'));

        // ============================================================
        // 15. REKOMENDASI PROPERTI
        // ============================================================

        $recommendedProperties = Property::where('price', '<=', $recommendedBudget)
            ->orderBy('price', 'desc')
            ->take(3)
            ->get();

        // ============================================================
        // 16. SIMPAN KE DATABASE
        // ============================================================

        Simulation::create([
            'name' => 'User Simulation',
            'income' => $income,
            'house_price' => $price,
            'down_payment' => $dp,
            'tenor' => $tenorYears,
            'interest' => $request->interest,
            'monthly_installment' => $installment,
            'status' => $status
        ]);

        // ============================================================
        // 17. RETURN VIEW
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
            'interestFix',
            'interestFloat',
            'installment',
            'installmentFloat',
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
            'alternativeTenor',
            'altInstallmentFloat',
            'amortizationSchedule',
            'totalInterestPaid',
            'totalPrincipalPaid',
            'totalInstallmentAll',
            'totalInterestPaidAll'
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