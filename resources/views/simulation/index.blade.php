@extends('layouts.app')

@section('content')

<section class="simulation-hero">

    <div class="overlay"></div>

    <div class="container position-relative text-white text-center">

        <h1 class="hero-title">
            Simulasi KPR
        </h1>

        <p class="hero-subtitle">
            Hitung estimasi cicilan rumah impian Anda dengan cepat dan profesional.
        </p>

    </div>

</section>

<section class="simulation-section">

    <div class="container">

        <div class="simulation-card">

            <form
                action="{{ route('simulation.calculate') }}"
                method="POST"
            >

                @csrf

                <div class="row g-4">

                    @if($property)
                    <div class="text-center mb-5">
                        <p class="text-muted">
                            Properti yang Disimulasikan
                        </p>

                        <h2 class="fw-bold text-danger">
                            {{ $property->title }}
                        </h2>
                    </div>
                    @endif

                    {{-- HARGA PROPERTY --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Harga Properti
                        </label>

                        <div class="input-rp">

                            <span>Rp</span>

                            @if($property)

                                <input
                                    type="text"
                                    value="{{ number_format($property->price,0,',','.') }}"
                                    readonly
                                >

                                <input
                                    type="hidden"
                                    name="harga_properti"
                                    value="{{ $property->price }}"
                                >

                            @else

                                <input
                                    type="text"
                                    id="harga_properti_display"
                                    placeholder="500.000.000"
                                    required
                                >

                                <input
                                    type="hidden"
                                    id="harga_properti"
                                    name="harga_properti"
                                >

                            @endif

                            <input
                                type="hidden"
                                name="property_title"
                                value="{{ $property->title ?? 'Simulasi Umum' }}"
                            >

                        </div>

                    </div>

                    {{-- PENGHASILAN --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Penghasilan per Bulan
                        </label>

                        <div class="input-rp">

                            <span>Rp</span>

                            <input
                                type="text"
                                id="income"
                                name="income"
                                placeholder="10.000.000"
                                required
                            >

                        </div>

                    </div>

                    {{-- DP --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Uang Muka (DP)
                        </label>

                        <div class="input-rp">

                            <span>Rp</span>

                            <input
                                type="text"
                                id="dp"
                                name="dp"
                                placeholder="100.000.000"
                                required
                            >

                        </div>

                    </div>

                    {{-- TENOR --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Tenor
                        </label>

                        <select
                            name="tenor"
                            class="form-select"
                            required
                        >

                            <option value="5">5 Tahun</option>
                            <option value="10">10 Tahun</option>
                            <option value="15">15 Tahun</option>
                            <option value="20" selected>20 Tahun</option>
                            <option value="25">25 Tahun</option>
                            <option value="30">30 Tahun</option>

                        </select>

                    </div>

                    {{-- JENIS KPR --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Jenis KPR
                        </label>

                        <select
                            name="jenis_kpr"
                            class="form-select"
                            required
                        >

                            <option value="konvensional">
                                KPR Konvensional
                            </option>

                            <option value="syariah">
                                KPR Syariah
                            </option>

                            <option value="subsidi">
                                KPR Subsidi
                            </option>

                        </select>

                    </div>

                    {{-- SUKU BUNGA FIXED --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Suku Bunga per Tahun (Fixed)
                        </label>

                        <div class="input-percent">

                            <input
                                type="number"
                                step="0.1"
                                name="interest"
                                placeholder="5"
                                value="6"
                                required
                            >

                            <span>%</span>

                        </div>

                    </div>

                    {{-- MASA KREDIT FIXED --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Masa Kredit Fixed
                        </label>

                        <select
                            name="fix_years"
                            class="form-select"
                        >

                            <option value="0">0 Tahun (Tidak Ada)</option>
                            <option value="1">1 Tahun</option>
                            <option value="2">2 Tahun</option>
                            <option value="3" selected>3 Tahun</option>
                            <option value="5">5 Tahun</option>
                            <option value="7">7 Tahun</option>
                            <option value="10">10 Tahun</option>

                        </select>
                        <small class="text-muted">Pilih 0 jika tidak ada masa fixed</small>

                    </div>

                    {{-- SUKU BUNGA FLOATING --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Suku Bunga Floating
                        </label>

                        <div class="input-percent">

                            <input
                                type="number"
                                step="0.1"
                                name="interest_floating"
                                placeholder="10"
                                value="10"
                            >

                            <span>%</span>

                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <div class="col-12 text-center">

                        <button
                            type="submit"
                            class="btn btn-red"
                            style="background:#dc2626; color:white; border:none; padding:16px 60px; border-radius:14px; font-size:18px; font-weight:bold;"
                        >
                            Hitung Simulasi
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</section>

<style>

body {

    background: #f4f7fb;
}

.simulation-hero {

    position: relative;

    min-height: 420px;

    background:
        linear-gradient(
            rgba(0,0,0,0.45),
            rgba(0,0,0,0.45)
        ),
        url('https://images.unsplash.com/photo-1560518883-ce09059eeffa');

    background-size: cover;

    background-position: center;

    display: flex;

    align-items: center;
}

.hero-title {

    font-size: 58px;

    font-weight: 800;
}

.hero-subtitle {

    font-size: 20px;

    margin-top: 15px;
}

.simulation-section {

    padding: 80px 0;
}

.simulation-card {

    background: white;

    padding: 45px;

    border-radius: 28px;

    box-shadow: 0 10px 35px rgba(0,0,0,0.08);

    max-width: 1050px;

    margin: auto;
}

.form-label {

    font-weight: 700;

    margin-bottom: 12px;
}

.input-rp,
.input-percent {

    display: flex;

    align-items: center;

    border: 1px solid #ddd;

    border-radius: 14px;

    overflow: hidden;

    height: 58px;

    background: white;
}

.input-rp span,
.input-percent span {

    background: #f5f7fb;

    padding: 0 18px;

    height: 100%;

    display: flex;

    align-items: center;

    font-weight: bold;
}

.input-rp input,
.input-percent input {

    border: none;

    outline: none;

    width: 100%;

    padding: 0 15px;
}

.form-select {

    height: 58px;

    border-radius: 14px;
}

</style>

<script>

function formatRupiah(input) {

    let value = input.value.replace(/[^,\d]/g, '');

    let split = value.split(',');

    let sisa = split[0].length % 3;

    let rupiah = split[0].substr(0, sisa);

    let ribuan = split[0]
        .substr(sisa)
        .match(/\d{3}/gi);

    if (ribuan) {

        let separator = sisa ? '.' : '';

        rupiah += separator + ribuan.join('.');
    }

    input.value = rupiah;
}


const incomeInput = document.getElementById('income');

if (incomeInput) {
    incomeInput.addEventListener('keyup', function () {
        formatRupiah(this);
    });
}

const dpInput = document.getElementById('dp');

if (dpInput) {
    dpInput.addEventListener('keyup', function () {
        formatRupiah(this);
    });
}

const hargaInput = document.getElementById('harga_properti_display');

if (hargaInput) {

    hargaInput.addEventListener('keyup', function () {

        formatRupiah(this);

        document.getElementById('harga_properti').value =
            this.value.replace(/\./g, '');

    });

}

</script>

@endsection