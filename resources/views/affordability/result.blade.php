{{-- resources/views/affordability/result.blade.php --}}

@extends('layouts.app')

@section('content')

<section class="affordability-result">

    <div class="container">

        {{-- HEADER --}}
        <div class="text-center mb-5">

            <h1 class="main-title">
                Hasil Analisis Finansial
            </h1>

            <p class="main-subtitle">
                Berdasarkan penghasilan, pengeluaran, dan jangka waktu yang Anda pilih.
            </p>

        </div>

        {{-- CARD RESULT --}}
        <div class="result-wrapper">

            <div class="row g-0">

                {{-- LEFT SIDE --}}
                <div class="col-lg-6 left-side">

                    <div class="content-box">

                        {{-- PENGHASILAN --}}
                        <div class="mb-4">

                            <label class="custom-label">
                                Penghasilan Total
                                <span>Per Bulan</span>
                            </label>

                            <div class="custom-input">

                                Rp {{ number_format($income, 0, ',', '.') }}

                            </div>

                        </div>

                        {{-- PENGELUARAN --}}
                        <div class="mb-4">

                            <label class="custom-label">
                                Pengeluaran
                                <span>Per Bulan</span>
                            </label>

                            <div class="custom-input">

                                Rp {{ number_format($expense, 0, ',', '.') }}

                            </div>

                        </div>

                        {{-- JANGKA WAKTU --}}
                        <div class="mb-5">

                            <label class="custom-label">
                                Jangka Waktu
                            </label>

                            <div class="custom-input">

                                {{ $tenor }} Tahun ({{ $months }} Bulan)

                            </div>

                        </div>

                        {{-- DETAIL PERHITUNGAN --}}
                        <div class="calculation-detail">

                            <h4 class="calculation-title">
                                📊 Detail Perhitungan
                            </h4>

                            <div class="calculation-item">
                                <span>Penghasilan</span>
                                <strong>Rp {{ number_format($income, 0, ',', '.') }}</strong>
                            </div>

                            <div class="calculation-item">
                                <span>Pengeluaran</span>
                                <strong class="text-danger">- Rp {{ number_format($expense, 0, ',', '.') }}</strong>
                            </div>

                            <div class="calculation-item total">
                                <span>Sisa Pendapatan</span>
                                <strong class="text-success">Rp {{ number_format($remainingIncome, 0, ',', '.') }}</strong>
                            </div>

                            <div class="calculation-item">
                                <span>Cicilan Maksimal (30%)</span>
                                <strong>Rp {{ number_format($maxInstallment, 0, ',', '.') }}</strong>
                            </div>

                            <div class="calculation-item total">
                                <span>Jangka Waktu</span>
                                <strong>{{ $tenor }} Tahun × 12 = {{ $months }} Bulan</strong>
                            </div>

                            <div class="calculation-item result">
                                <span>Harga Properti Maksimal</span>
                                <strong class="text-danger">Rp {{ number_format($estimatedPropertyPrice, 0, ',', '.') }}</strong>
                            </div>

                            <div class="calculation-item">
                                <span>Rekomendasi DP (20%)</span>
                                <strong>Rp {{ number_format($recommendedDp, 0, ',', '.') }}</strong>
                            </div>

                        </div>

                        {{-- BUTTON --}}
                        <a
                            href="{{ route('affordability.index') }}"
                            class="main-button mt-3"
                        >
                            Hitung Ulang
                        </a>

                    </div>

                </div>

                {{-- RIGHT SIDE --}}
                <div class="col-lg-6 right-side">

                    <div class="content-box result-area">

                        <h2 class="result-title">
                            Harga Properti Maksimal Kamu
                        </h2>

                        <div class="result-price">

                            Rp {{ number_format($estimatedPropertyPrice, 0, ',', '.') }}

                        </div>

                        <p class="result-text">
                            Langsung cari properti sesuai budget kamu
                        </p>

                        {{-- SEARCH PROPERTY --}}
                        <form
                            action="{{ route('properties.index') }}"
                            method="GET"
                        >

                            <div class="search-property">

                                <input
                                    type="text"
                                    name="city"
                                    placeholder="Cari lokasi property"
                                >

                                <button type="submit">
                                    🔍
                                </button>

                            </div>

                        </form>

                        {{-- INFO --}}
                        <div class="analysis-info">

                            <div class="info-card">

                                <h5>
                                    Sisa Pendapatan
                                </h5>

                                <p>
                                    Rp {{ number_format($remainingIncome, 0, ',', '.') }}
                                </p>

                            </div>

                            <div class="info-card">

                                <h5>
                                    Cicilan Maksimal
                                </h5>

                                <p>
                                    Rp {{ number_format($maxInstallment, 0, ',', '.') }}
                                </p>

                            </div>

                            <div class="info-card">

                                <h5>
                                    Rekomendasi DP (20%)
                                </h5>

                                <p>
                                    Rp {{ number_format($recommendedDp, 0, ',', '.') }}
                                </p>

                            </div>

                            <div class="info-card">

                                <h5>
                                    Jangka Waktu
                                </h5>

                                <p>
                                    {{ $tenor }} Tahun
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- DETAIL PER BULAN --}}
        <div class="card shadow border-0 rounded-4 mt-5">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">📋 Detail Cicilan Per Bulan (12 Bulan Pertama)</h5>
            </div>
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Bulan ke-</th>
                                <th>Cicilan Per Bulan</th>
                                <th>Total Terkumpul</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyDetailsDisplay as $item)
                            <tr>
                                <td>{{ $item['month'] }}</td>
                                <td>Rp {{ number_format($item['installment'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item['total_saved'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3 bg-light">
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i>
                        Menampilkan 12 bulan pertama dari {{ $months }} bulan.
                        Total harga properti maksimal: <strong>Rp {{ number_format($estimatedPropertyPrice, 0, ',', '.') }}</strong>
                    </small>
                </div>

            </div>
        </div>

    </div>

</section>

<style>

body {

    background: #f5f7fb;
}

.affordability-result {

    padding: 120px 0;
}

.main-title {

    font-size: 52px;

    font-weight: 800;

    color: #111827;
}

.main-subtitle {

    color: #666;

    font-size: 18px;

    margin-top: 15px;
}

.result-wrapper {

    background: white;

    border-radius: 30px;

    overflow: hidden;

    box-shadow: 0 10px 35px rgba(0,0,0,0.08);
}

.left-side {

    border-right: 1px solid #e5e7eb;
}

.content-box {

    padding: 50px;
}

.custom-label {

    display: block;

    font-weight: 700;

    margin-bottom: 12px;

    color: #111827;
}

.custom-label span {

    font-size: 14px;

    color: #666;

    font-weight: 400;
}

.custom-input {

    border: 1px solid #d1d5db;

    border-radius: 12px;

    padding: 18px;

    font-size: 20px;

    font-weight: 700;

    color: #dc2626;

    background: #fff;
}

/* ============================================================
   DETAIL PERHITUNGAN
   ============================================================ */

.calculation-detail {
    background: #f8fafc;
    border-radius: 16px;
    padding: 20px 24px;
    margin-top: 16px;
    border: 1px solid #e5e7eb;
}

.calculation-title {
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 16px;
}

.calculation-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 14px;
    color: #4b5563;
}

.calculation-item:last-child {
    border-bottom: none;
}

.calculation-item.total {
    font-weight: 700;
    color: #1f2937;
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 10px;
}

.calculation-item.total:last-child {
    border-bottom: none;
    padding-bottom: 8px;
}

.calculation-item.result {
    background: #fef2f2;
    border-radius: 8px;
    padding: 10px 14px;
    margin-top: 8px;
    border-bottom: none;
}

.calculation-item.result span {
    font-weight: 700;
    color: #1f2937;
}

.calculation-item.result strong {
    font-size: 18px;
}

/* ============================================================
   MAIN BUTTON
   ============================================================ */

.main-button {

    background: linear-gradient(
        135deg,
        #dc2626,
         #b91c1c
    );

    color: white;

    text-decoration: none;

    padding: 16px 35px;

    border-radius: 15px;

    font-weight: 700;

    display: inline-block;

    transition: 0.3s;
}

.main-button:hover {

    transform: translateY(-3px);

    color: white;
}

/* ============================================================
   RESULT AREA
   ============================================================ */

.result-area {

    text-align: center;
}

.result-title {

    font-size: 32px;

    font-weight: 800;

    margin-bottom: 20px;
}

.result-price {

    font-size: 48px;

    font-weight: 900;

    color: #dc2626;

    margin-bottom: 25px;
}

.result-text {

    color: #666;

    margin-bottom: 30px;
}

.search-property {

    display: flex;

    border: 1px solid #d1d5db;

    border-radius: 15px;

    overflow: hidden;

    margin-bottom: 35px;
}

.search-property input {

    flex: 1;

    border: none;

    padding: 18px;

    outline: none;
}

.search-property button {

    width: 70px;

    border: none;

    background: #dc2626;

    color: white;

    font-size: 24px;
}

.analysis-info {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 16px;
}

.info-card {

    background: #f9fbff;

    border-radius: 18px;

    padding: 20px;
}

.info-card h5 {

    color: #666;

    font-size: 13px;

    margin-bottom: 8px;
}

.info-card p {

    font-size: 18px;

    font-weight: 800;

    color: #dc2626;
}

.card-header {
    border-radius: 16px 16px 0 0 !important;
}

.table th, .table td {
    vertical-align: middle;
    padding: 12px 16px;
}

@media(max-width: 768px) {

    .main-title {

        font-size: 38px;
    }

    .left-side {

        border-right: none;

        border-bottom: 1px solid #e5e7eb;
    }

    .analysis-info {

        grid-template-columns: 1fr 1fr;
    }

    .content-box {

        padding: 30px;
    }

    .result-price {

        font-size: 34px;
    }

    .calculation-detail {
        padding: 16px;
    }
}

@media(max-width: 480px) {

    .analysis-info {

        grid-template-columns: 1fr;
    }

    .main-title {

        font-size: 28px;
    }

    .result-title {

        font-size: 24px;
    }

    .result-price {

        font-size: 28px;
    }

    .content-box {

        padding: 20px;
    }

    .calculation-item {
        font-size: 13px;
        flex-wrap: wrap;
    }

    .calculation-item.result strong {
        font-size: 16px;
    }
}

</style>

@endsection