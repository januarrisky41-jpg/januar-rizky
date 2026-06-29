<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class AffordabilityController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN ANALISIS FINANSIAL
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view('affordability.index');
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES PERHITUNGAN
    |--------------------------------------------------------------------------
    */

    public function calculate(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FORMAT INPUT
        |--------------------------------------------------------------------------
        */

        $income =
            (int) str_replace(
                '.',
                '',
                $request->income
            );

        $expense =
            (int) str_replace(
                '.',
                '',
                $request->expense
            );

        $tenor =
            (int) $request->tenor;

        /*
        |--------------------------------------------------------------------------
        | VALIDASI SEDERHANA
        |--------------------------------------------------------------------------
        */

        if ($income <= $expense) {

            return back()->with(
                'error',
                'Penghasilan harus lebih besar dari pengeluaran.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SISA PENDAPATAN
        |--------------------------------------------------------------------------
        */

        $remainingIncome =
            $income - $expense;

        /*
        |--------------------------------------------------------------------------
        | MAKSIMAL CICILAN
        |--------------------------------------------------------------------------
        | Maksimal 40% dari sisa pendapatan
        */

        $maxInstallment =
            $remainingIncome * 0.40;

        /*
        |--------------------------------------------------------------------------
        | ASUMSI KPR
        |--------------------------------------------------------------------------
        */

        $annualInterest = 0.08; // 8% per tahun

        $monthlyInterest =
            $annualInterest / 12;

        $totalMonths =
            $tenor * 12;

        /*
        |--------------------------------------------------------------------------
        | ESTIMASI HARGA PROPERTI
        |--------------------------------------------------------------------------
        | Rumus Present Value Anuitas
        */

        $estimatedPropertyPrice =

            $maxInstallment *

            (

                (
                    1 -
                    pow(
                        1 + $monthlyInterest,
                        -$totalMonths
                    )
                )

                /

                $monthlyInterest

            );

        /*
        |--------------------------------------------------------------------------
        | ASUMSI DP 20%
        |--------------------------------------------------------------------------
        */

        $estimatedPropertyPrice =
            $estimatedPropertyPrice / 0.8;

        /*
        |--------------------------------------------------------------------------
        | BULATKAN
        |--------------------------------------------------------------------------
        */

        $estimatedPropertyPrice =
            round($estimatedPropertyPrice);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE SESSION
        |--------------------------------------------------------------------------
        */

        session([

            'income' =>
                $income,

            'expense' =>
                $expense,

            'tenor' =>
                $tenor,

            'remaining_income' =>
                $remainingIncome,

            'max_installment' =>
                $maxInstallment,

            'estimated_property_price' =>
                $estimatedPropertyPrice

        ]);

        /*
        |--------------------------------------------------------------------------
        | REKOMENDASI AWAL
        |--------------------------------------------------------------------------
        */

        $recommendedProperties =

            Property::where(

                'price',

                '<=',

                $estimatedPropertyPrice

            )

            ->orderByDesc('price')

            ->take(6)

            ->get();

        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return view(

            'affordability.result',

            compact(

                'income',

                'expense',

                'remainingIncome',

                'maxInstallment',

                'estimatedPropertyPrice',

                'recommendedProperties',

                'tenor'

            )

        );
    }
}