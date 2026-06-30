<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AffordabilityController extends Controller
{
    public function index()
    {
        return view('affordability.index');
    }

    public function calculate(Request $request)
    {
        // ============================================================
        // 1. AMBIL DATA DARI FORM
        // ============================================================

        $income = (float) str_replace(['.', ','], '', $request->income);
        $expense = (float) str_replace(['.', ','], '', $request->expense);
        $tenor = (int) $request->tenor;

        // ============================================================
        // 2. VALIDASI
        // ============================================================

        if ($income <= 0) $income = 15000000;
        if ($expense <= 0) $expense = 2000000;
        if ($tenor <= 0) $tenor = 10;

        // ============================================================
        // 3. HITUNG SISA PENGHASILAN
        // ============================================================

        $remainingIncome = $income - $expense;

        // ============================================================
        // 4. ESTIMASI CICILAN MAKSIMAL (30% dari sisa penghasilan)
        // ============================================================

        $maxInstallment = $remainingIncome * 0.30;

        // ============================================================
        // 5. HITUNG HARGA PROPERTI MAKSIMAL
        // ============================================================

        $months = $tenor * 12;
        $estimatedPropertyPrice = $maxInstallment * $months;

        // ============================================================
        // 6. REKOMENDASI DP (20%)
        // ============================================================

        $recommendedDp = $estimatedPropertyPrice * 0.20;

        // ============================================================
        // 7. SIMPAN BUDGET KE SESSION (UNTUK REKOMENDASI)
        // ============================================================

        Session::put('estimated_property_price', $estimatedPropertyPrice);

        // ============================================================
        // 8. BUAT DETAIL PER BULAN (SEDERHANA)
        // ============================================================

        $monthlyDetails = [];
        $totalSaved = 0;

        for ($i = 1; $i <= $months; $i++) {
            $totalSaved += $maxInstallment;
            $monthlyDetails[] = [
                'month' => $i,
                'installment' => $maxInstallment,
                'total_saved' => $totalSaved
            ];
        }

        // Ambil 12 bulan pertama untuk ditampilkan
        $monthlyDetailsDisplay = array_slice($monthlyDetails, 0, 12);
    
        // ============================================================
        // 9. RETURN VIEW
        // ============================================================

        return view('affordability.result', compact(
            'income',
            'expense',
            'tenor',
            'remainingIncome',
            'maxInstallment',
            'estimatedPropertyPrice',
            'recommendedDp',
            'monthlyDetailsDisplay',
            'months'
        ));
    }
}