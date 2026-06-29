@extends('layouts.app')

@section('content')

<section class="dashboard-section">

    <div class="container">

        <div class="dashboard-header text-center">

            <h1>

                Dashboard Properti

            </h1>

            <p>

                Statistik dan informasi properti dalam sistem
                Properti Merah Putih

            </p>

        </div>

        {{-- SUMMARY CARD --}}

        <div class="row g-4 mb-5">

            <div class="col-lg-2 col-md-4">

                <div class="analytics-card">

                    <small>Total Properti</small>

                    <h2>

                        {{ $totalProperties }}

                    </h2>

                </div>

            </div>

            <div class="col-lg-2 col-md-4">

                <div class="analytics-card success">

                    <small>Total Kota</small>

                    <h2>

                        {{ $totalCities }}

                    </h2>

                </div>

            </div>

            <div class="col-lg-2 col-md-4">

                <div class="analytics-card primary">

                    <small>Harga Rata-rata</small>

                    <h2>

                        {{ number_format($averagePrice/1000000,0,',','.') }} JT

                    </h2>

                </div>

            </div>

            <div class="col-lg-2 col-md-4">

                <div class="analytics-card warning">

                    <small>Harga Termurah</small>

                    <h2>

                        {{ number_format($minPrice/1000000,0,',','.') }} JT

                    </h2>

                </div>

            </div>

            <div class="col-lg-2 col-md-4">

                <div class="analytics-card danger">

                    <small>Harga Tertinggi</small>

                    <h2>

                        {{ number_format($maxPrice/1000000,0,',','.') }} JT

                    </h2>

                </div>

            </div>

            <div class="col-lg-2 col-md-4">

                <div class="analytics-card dark">

                    <small>Total Favorit</small>

                    <h2>

                        {{ \App\Models\Favorite::count() }}

                    </h2>

                </div>

            </div>

        </div>

        {{-- STATISTIK KOTA --}}

        <div class="card shadow border-0 mb-5">

            <div class="card-header bg-danger text-white">

                <h4 class="mb-0">

                    Statistik Properti Per Kota

                </h4>

            </div>

            <div class="card-body p-0">

                <table class="table table-striped mb-0">

                    <thead>

                        <tr>

                            <th>Kota</th>

                            <th>Jumlah Properti</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($cityStatistics as $city)

                        <tr>

                            <td>

                                {{ $city->location }}

                            </td>

                            <td>

                                {{ $city->total }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        {{-- PROPERTI TERBARU --}}

        <div class="card shadow border-0">

            <div class="card-header text-white" style="background:#dc2626;">

                <h4 class="mb-0">

                    Properti Terbaru

                </h4>

            </div>

            <div class="card-body">

                <div class="row g-4">

                    @foreach($latestProperties as $property)

                    <div class="col-lg-4">

                        <div class="property-card">

                            <img
                                src="{{ $property->image }}"
                                class="img-fluid rounded-top"
                                style="height:220px;width:100%;object-fit:cover;"
                            >

                            <div class="p-3">

                                <h5>

                                    {{ $property->title }}

                                </h5>

                                <p class="text-muted">

                                    📍 {{ $property->location }}

                                </p>

                                <h6 class="text-danger fw-bold">

                                    Rp{{ number_format($property->price,0,',','.') }}

                                </h6>

                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</section>

<style>

body{
    background:#f5f7fb;
}

.dashboard-section{
    padding:80px 0;
}

.dashboard-header{
    margin-bottom:50px;
}

.dashboard-header h1{
    font-size:48px;
    font-weight:800;
    color:#1f2937;
}

.dashboard-header p{
    color:#64748b;
}

.analytics-card{

    background:white;

    padding:25px;

    border-radius:20px;

    box-shadow:0 4px 15px rgba(0,0,0,.08);

    text-align:center;

    height:100%;
}

.analytics-card small{

    color:#64748b;

    font-weight:600;
}

.analytics-card h2{

    margin-top:10px;

    font-size:28px;

    font-weight:800;
}

.analytics-card.success{
    background:#ecfdf3;
}

.analytics-card.primary{
    background:#eef4ff;
}

.analytics-card.warning{
    background:#fff7ed;
}

.analytics-card.danger{
    background:#fef2f2;
}

.analytics-card.dark{
    background:#1f2937;
    color:white;
}

.analytics-card.dark small{
    color:#d1d5db;
}

.property-card{

    background:white;

    border-radius:20px;

    overflow:hidden;

    box-shadow:0 5px 15px rgba(251, 9, 9, 0.08);

    transition:.3s;
}

.property-card:hover{

    transform:translateY(-5px);
}

.card{
    border-radius:20px;
}

.card-header{
    border-radius:20px 20px 0 0 !important;
}

.table th{
    background:#f8fafc;
}

@media(max-width:768px){

    .dashboard-header h1{
        font-size:32px;
    }

    .analytics-card h2{
        font-size:22px;
    }

}

</style>

@endsection