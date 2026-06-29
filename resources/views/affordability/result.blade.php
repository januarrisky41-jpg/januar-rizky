@extends('layouts.app')

@section('content')

<section class="affordability-result">

    <div class="container">

        {{-- HEADER --}}

        <div class="text-center mb-5">

            <h1 class="main-title">
                Hitung Harga Properti Maksimal
            </h1>

            <p class="main-subtitle">
                Masukkan penghasilan, pengeluaran, dan jangka waktu untuk mengetahui estimasi harga properti ideal.
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

                                {{ $tenor }} Tahun

                            </div>

                        </div>

                        {{-- BUTTON --}}

                        <a
                            href="/affordability"
                            class="main-button"
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
                            action="/properties"
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
                                    Estimasi Cicilan Maksimal
                                </h5>

                                <p>
                                    Rp {{ number_format($maxInstallment, 0, ',', '.') }}
                                </p>

                            </div>

                        </div>

                    </div>

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

    color: #dc2626;;

    background: #fff;
}

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

.result-area {

    text-align: center;
}

.result-title {

    font-size: 38px;

    font-weight: 800;

    margin-bottom: 35px;
}

.result-price {

    font-size: 48px;

    font-weight: 900;

    color: #dc2626;;

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

    background: #dc2626;;

    color: white;

    font-size: 24px;
}

.analysis-info {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 20px;
}

.info-card {

    background: #f9fbff;

    border-radius: 18px;

    padding: 25px;
}

.info-card h5 {

    color: #666;

    margin-bottom: 15px;
}

.info-card p {

    font-size: 24px;

    font-weight: 800;

    color: #dc2626;;
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

        grid-template-columns: 1fr;
    }

    .content-box {

        padding: 30px;
    }

    .result-price {

        font-size: 34px;
    }
}

</style>

@endsection