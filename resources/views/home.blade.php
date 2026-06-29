@extends('layouts.app')

@section('content')

<!-- HERO -->

<section class="hero-section">

    <div class="overlay"></div>

    <div class="container hero-content">

        <div class="row align-items-center">

            <div class="col-lg-7">

                <span class="hero-tag">
                    Platform Analisis Pembiayaan Hunian
                </span>

                <h1 class="hero-title">

                    Temukan Properti
                    Sesuai Kemampuan Finansial Anda

                </h1>

                <p class="hero-subtitle">

                    Cari properti berdasarkan lokasi,
                    lakukan simulasi KPR, dan analisis
                    kemampuan finansial sebelum mengambil
                    keputusan pembelian rumah.

                </p>

                <form
                    action="/properties"
                    method="GET"
                    class="search-box"
                >

                    <input
                        type="text"
                        name="keyword"
                        placeholder="Cari lokasi atau nama properti..."
                    >

                    <button type="submit">

                        <i class="bi bi-search"></i>

                    </button>

                </form>

                <div class="hero-buttons">

                    <a
                        href="/properties"
                        class="btn-primary-custom"
                    >
                        Jelajahi Properti
                    </a>

                    <a
                        href="/simulation"
                        class="btn-secondary-custom"
                    >
                        Simulasi KPR
                    </a>

                </div>

            </div>

            <div class="col-lg-5">

                <div class="hero-info-card">

                    <h4>
                        Fitur Utama
                    </h4>

                    <div class="feature-item">

                        <i class="bi bi-house-door-fill"></i>

                        <span>
                            Pencarian Properti
                        </span>

                    </div>

                    <div class="feature-item">

                        <i class="bi bi-calculator-fill"></i>

                        <span>
                            Simulasi Kredit KPR
                        </span>

                    </div>

                    <div class="feature-item">

                        <i class="bi bi-graph-up-arrow"></i>

                        <span>
                            Analisis Kemampuan Finansial
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- KEUNGGULAN -->

<section class="advantage-section">

    <div class="container">

        <div class="section-title">

            <h2>
                Kenapa Memilih Properti Merah Putih?
            </h2>

            <p>
                Membantu pengguna mengambil keputusan pembelian rumah dengan lebih terukur.
            </p>

        </div>

        <div class="row g-4">

            <div class="col-md-4">

                <div class="advantage-card">

                    <i class="bi bi-search"></i>

                    <h4>
                        Pencarian Mudah
                    </h4>

                    <p>
                        Temukan properti berdasarkan lokasi dan kebutuhan Anda.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="advantage-card">

                    <i class="bi bi-calculator"></i>

                    <h4>
                        Simulasi KPR
                    </h4>

                    <p>
                        Hitung estimasi cicilan dan tenor dengan cepat.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="advantage-card">

                    <i class="bi bi-bar-chart"></i>

                    <h4>
                        Analisis Finansial
                    </h4>

                    <p>
                        Ketahui kemampuan membeli rumah sesuai pendapatan Anda.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- PROPERTY -->

<section class="property-preview">

    <div class="container">

        <div class="section-title">

            <h2>
                Properti Pilihan
            </h2>

            <p>
                Beberapa properti yang tersedia pada sistem.
            </p>

        </div>

        <div class="row g-4">

            @foreach($properties as $property)

            <div class="col-lg-3 col-md-6">

                <a
                    href="/properties/{{ $property->id }}"
                    class="text-decoration-none"
                >

                    <div class="property-card">

                        <img
                            src="{{ $property->image }}"
                            alt="{{ $property->title }}"
                        >

                        <div class="property-body">

                            <h5>
                                {{ $property->title }}
                            </h5>

                            <p>
                                📍 {{ $property->location }}
                            </p>

                            <h4>
                                Rp{{ number_format($property->price,0,',','.') }}
                            </h4>

                        </div>

                    </div>

                </a>

            </div>

            @endforeach

        </div>

    </div>

</section>

<style>

.hero-section{
    min-height:90vh;
    display:flex;
    align-items:center;
    background:
    linear-gradient(rgba(0,0,0,.55),rgba(0,0,0,.55)),
    url('https://images.unsplash.com/photo-1560518883-ce09059eeffa');
    background-size:cover;
    background-position:center;
}

.hero-tag{
    background:#fee2e2;
    color:#b91c1c;
    padding:8px 16px;
    border-radius:50px;
    font-weight:600;
}

.hero-title{
    color:white;
    font-size:60px;
    font-weight:800;
    margin-top:20px;
}

.hero-subtitle{
    color:rgba(255,255,255,.85);
    margin-top:20px;
    line-height:1.8;
}

.search-box{
    margin-top:30px;
    display:flex;
    background:white;
    border-radius:14px;
    overflow:hidden;
}

.search-box input{
    flex:1;
    border:none;
    padding:18px;
    outline:none;
}

.search-box button{
    border:none;
    background:#dc2626;
    color:white;
    width:70px;
}

.hero-buttons{
    display:flex;
    gap:15px;
    margin-top:25px;
}

.btn-primary-custom{
    background:#dc2626;
    color:white;
    padding:14px 28px;
    border-radius:12px;
}

.btn-secondary-custom{
    border:2px solid white;
    color:white;
    padding:14px 28px;
    border-radius:12px;
}

.hero-info-card{
    background:rgba(255,255,255,.15);
    backdrop-filter:blur(10px);
    padding:35px;
    border-radius:20px;
    color:white;
}

.feature-item{
    margin-top:20px;
    display:flex;
    gap:15px;
    align-items:center;
}

.advantage-section{
    padding:90px 0;
}

.advantage-card{
    background:white;
    padding:35px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.advantage-card i{
    font-size:45px;
    color:#dc2626;
}

.property-preview{
    padding:90px 0;
    background:#f8fafc;
}

.section-title{
    text-align:center;
    margin-bottom:50px;
}

.property-card{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
    transition:.3s;
}

.property-card:hover{
    transform:translateY(-8px);
}

.property-card img{
    width:100%;
    height:220px;
    object-fit:cover;
}

.property-body{
    padding:20px;
}

.property-body h5{
    color:#111827;
    font-weight:700;
}

.property-body h4{
    color:#dc2626;
    font-weight:800;
}

@media(max-width:768px){

    .hero-title{
        font-size:42px;
    }

    .hero-buttons{
        flex-direction:column;
    }

    .hero-info-card{
        margin-top:30px;
    }
}

</style>

@endsection