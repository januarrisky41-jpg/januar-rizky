@extends('layouts.app')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">

        <h1 class="fw-bold">
            Komparasi Properti
        </h1>

        <p class="text-muted">
            Bandingkan dua properti untuk menemukan pilihan terbaik
        </p>

    </div>

    <form
        action="{{ route('compare') }}"
        method="GET"
        class="bg-white shadow-sm rounded-4 p-4 mb-5"
    >

        <div class="row g-3">

            <div class="col-md-5">

                <select
                    name="property_a"
                    id="property_a"
                    class="form-select property-search"
                    required
                >

                    <option value="">
                        Cari Properti A
                    </option>

                    @foreach($properties as $property)

                    <option
                        value="{{ $property->id }}"
                        {{ request('property_a') == $property->id ? 'selected' : '' }}
                    >

                        {{ $property->title }}

                    </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-5">

                <select
                    name="property_b"
                    id="property_b"
                    class="form-select property-search"
                    required
                >

                    <option value="">
                        Cari Properti B
                    </option>

                    @foreach($properties as $property)

                    <option
                        value="{{ $property->id }}"
                        {{ request('property_b') == $property->id ? 'selected' : '' }}
                    >

                        {{ $property->title }}

                    </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-2">

                <button
                    class="btn btn-danger w-100"
                    type="submit"
                >

                    Bandingkan

                </button>

            </div>

        </div>

    </form>

    @if(isset($propertyA) && isset($propertyB) && $propertyA && $propertyB)

    {{-- CARD PROPERTI --}}
    <div class="row mb-5">

        <div class="col-md-6">

            <div class="card border-0 shadow rounded-4 overflow-hidden h-100">

                <img
                    src="{{ Str::startsWith($propertyA->image, 'http') ? $propertyA->image : asset('storage/'.$propertyA->image) }}"
                    class="card-img-top"
                    style="height:320px; object-fit:cover;"
                    alt="{{ $propertyA->title }}"
                >

                <div class="card-body p-4">

                    <h4 class="fw-bold">

                        {{ $propertyA->title }}

                    </h4>

                    <h3 class="text-danger fw-bold">

                        Rp {{ number_format($propertyA->price,0,',','.') }}

                    </h3>

                    <hr>

                    <p>
                        📍 <strong>Lokasi :</strong>
                        {{ $propertyA->location }}
                    </p>

                    <p>
                        🛏 <strong>Kamar Tidur :</strong>
                        {{ $propertyA->bedroom }}
                    </p>

                    <p>
                        🚿 <strong>Kamar Mandi :</strong>
                        {{ $propertyA->bathroom }}
                    </p>

                    <p>
                        📐 <strong>Luas Bangunan :</strong>
                        {{ $propertyA->building_area }} m²
                    </p>

                    <p>
                        📏 <strong>Luas Tanah :</strong>
                        {{ $propertyA->land_area ?? '-' }} m²
                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card border-0 shadow rounded-4 overflow-hidden h-100">

                <img
                    src="{{ Str::startsWith($propertyB->image, 'http') ? $propertyB->image : asset('storage/'.$propertyB->image) }}"
                    class="card-img-top"
                    style="height:320px; object-fit:cover;"
                    alt="{{ $propertyB->title }}"
                >

                <div class="card-body p-4">

                    <h4 class="fw-bold">

                        {{ $propertyB->title }}

                    </h4>

                    <h3 class="text-danger fw-bold">

                        Rp {{ number_format($propertyB->price,0,',','.') }}

                    </h3>

                    <hr>

                    <p>
                        📍 <strong>Lokasi :</strong>
                        {{ $propertyB->location }}
                    </p>

                    <p>
                        🛏 <strong>Kamar Tidur :</strong>
                        {{ $propertyB->bedroom }}
                    </p>

                    <p>
                        🚿 <strong>Kamar Mandi :</strong>
                        {{ $propertyB->bathroom }}
                    </p>

                    <p>
                        📐 <strong>Luas Bangunan :</strong>
                        {{ $propertyB->building_area }} m²
                    </p>

                    <p>
                        📏 <strong>Luas Tanah :</strong>
                        {{ $propertyB->land_area ?? '-' }} m²
                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- TABEL PERBANDINGAN DETAIL --}}
    <div class="card border-0 shadow rounded-4">

        <div class="card-header bg-danger text-white">

            <h4 class="mb-0">
                Perbandingan Detail
            </h4>

        </div>

        <div class="card-body p-0">

            <table class="table table-bordered mb-0">

                <thead>

                    <tr>

                        <th width="25%">
                            Kriteria
                        </th>

                        <th>
                            {{ $propertyA->title }}
                        </th>

                        <th>
                            {{ $propertyB->title }}
                        </th>

                    </tr>

                </thead>

                <tbody>

                    {{-- HARGA --}}
                    <tr>

                        <td><strong>Harga</strong></td>

                        <td>
                            Rp {{ number_format($propertyA->price,0,',','.') }}
                        </td>

                        <td>
                            Rp {{ number_format($propertyB->price,0,',','.') }}
                        </td>

                    </tr>

                    {{-- LOKASI --}}
                    <tr>

                        <td><strong>Lokasi</strong></td>

                        <td>{{ $propertyA->location }}</td>

                        <td>{{ $propertyB->location }}</td>

                    </tr>

                    {{-- KAMAR TIDUR --}}
                    <tr>

                        <td><strong>Kamar Tidur</strong></td>

                        <td>{{ $propertyA->bedroom }}</td>

                        <td>{{ $propertyB->bedroom }}</td>

                    </tr>

                    {{-- KAMAR MANDI --}}
                    <tr>

                        <td><strong>Kamar Mandi</strong></td>

                        <td>{{ $propertyA->bathroom }}</td>

                        <td>{{ $propertyB->bathroom }}</td>

                    </tr>

                    {{-- LUAS BANGUNAN --}}
                    <tr>

                        <td><strong>Luas Bangunan</strong></td>

                        <td>{{ $propertyA->building_area }} m²</td>

                        <td>{{ $propertyB->building_area }} m²</td>

                    </tr>

                    {{-- LUAS TANAH --}}
                    <tr>

                        <td><strong>Luas Tanah</strong></td>

                        <td>{{ $propertyA->land_area ?? '-' }} m²</td>

                        <td>{{ $propertyB->land_area ?? '-' }} m²</td>

                    </tr>

                    {{-- FASILITAS UMUM (DETAIL) --}}
                    <tr>

                        <td><strong>Fasilitas Umum</strong></td>

                        <td>
                            @if($propertyA->facility_details)
                                <ul class="mb-0 ps-3">
                                    @foreach(explode('|', $propertyA->facility_details) as $item)
                                        <li class="small">{{ $item }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">{{ $propertyA->facility_score ?? '-' }}/5</span>
                            @endif
                        </td>

                        <td>
                            @if($propertyB->facility_details)
                                <ul class="mb-0 ps-3">
                                    @foreach(explode('|', $propertyB->facility_details) as $item)
                                        <li class="small">{{ $item }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">{{ $propertyB->facility_score ?? '-' }}/5</span>
                            @endif
                        </td>

                    </tr>

                    {{-- KEAMANAN LINGKUNGAN (DETAIL) --}}
                    <tr>

                        <td><strong>Keamanan Lingkungan</strong></td>

                        <td>
                            @if($propertyA->security_details)
                                <ul class="mb-0 ps-3">
                                    @foreach(explode('|', $propertyA->security_details) as $item)
                                        <li class="small">🔒 {{ $item }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">{{ $propertyA->security_score ?? '-' }}/5</span>
                            @endif
                        </td>

                        <td>
                            @if($propertyB->security_details)
                                <ul class="mb-0 ps-3">
                                    @foreach(explode('|', $propertyB->security_details) as $item)
                                        <li class="small">🔒 {{ $item }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">{{ $propertyB->security_score ?? '-' }}/5</span>
                            @endif
                        </td>

                    </tr>

                    {{-- KONDISI BANGUNAN --}}
                    <tr>

                        <td><strong>Kondisi Bangunan</strong></td>

                        <td>
                            {{ $propertyA->condition_score }}%
                            <div class="progress" style="height:8px;width:100px;display:inline-block;">
                                <div class="progress-bar bg-{{ $propertyA->condition_score >= 80 ? 'success' : ($propertyA->condition_score >= 60 ? 'warning' : 'danger') }}"
                                     style="width: {{ $propertyA->condition_score }}%;">
                                </div>
                            </div>
                        </td>

                        <td>
                            {{ $propertyB->condition_score }}%
                            <div class="progress" style="height:8px;width:100px;display:inline-block;">
                                <div class="progress-bar bg-{{ $propertyB->condition_score >= 80 ? 'success' : ($propertyB->condition_score >= 60 ? 'warning' : 'danger') }}"
                                     style="width: {{ $propertyB->condition_score }}%;">
                                </div>
                            </div>
                        </td>

                    </tr>

                    {{-- SERTIFIKAT TANAH --}}
                    <tr>

                        <td><strong>Sertifikat Tanah</strong></td>

                        <td>
                            @if($propertyA->certificate_type)
                                <span class="badge bg-{{ $propertyA->certificate_type == 'SHM' ? 'success' : ($propertyA->certificate_type == 'SHGB' ? 'warning' : 'secondary') }}">
                                    {{ $propertyA->certificate_type }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>
                            @if($propertyB->certificate_type)
                                <span class="badge bg-{{ $propertyB->certificate_type == 'SHM' ? 'success' : ($propertyB->certificate_type == 'SHGB' ? 'warning' : 'secondary') }}">
                                    {{ $propertyB->certificate_type }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                    </tr>

                    {{-- TIPE PROPERTI --}}
                    <tr>

                        <td><strong>Tipe Properti</strong></td>

                        <td>{{ $propertyA->property_type ?? '-' }}</td>

                        <td>{{ $propertyB->property_type ?? '-' }}</td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    {{-- SKOR KESESUAIAN SAW --}}
    @if(isset($scoreA) && isset($scoreB))

    <div class="row mt-5">

        <div class="col-md-6">

            <div class="card border-0 shadow rounded-4 h-100">

                <div class="card-body p-4 text-center">

                    <h4 class="fw-bold text-danger">
                        {{ $propertyA->title }}
                    </h4>

                    <h2 class="fw-bold display-5 text-success">
                        {{ $percentageA }}%
                    </h2>

                    <div class="progress mt-3" style="height:25px;">
                        <div
                            class="progress-bar bg-success"
                            style="width: {{ $percentageA }}%;"
                        >
                            {{ $percentageA }}%
                        </div>
                    </div>

                    <p class="text-muted mt-3">
                        Tingkat Kesesuaian Properti Berdasarkan Metode SAW
                    </p>

                    <hr>

                    <h5 class="fw-bold">Keunggulan Properti</h5>

                    <ul class="mt-3 text-start">

                        @forelse($advantagesA as $item)
                            <li>✅ {{ $item }}</li>
                        @empty
                            <li>Tidak ada keunggulan dominan</li>
                        @endforelse

                    </ul>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card border-0 shadow rounded-4 h-100">

                <div class="card-body p-4 text-center">

                    <h4 class="fw-bold text-danger">
                        {{ $propertyB->title }}
                    </h4>

                    <h2 class="fw-bold display-5 text-primary">
                        {{ $percentageB }}%
                    </h2>

                    <div class="progress mt-3" style="height:25px;">
                        <div
                            class="progress-bar bg-primary"
                            style="width: {{ $percentageB }}%;"
                        >
                            {{ $percentageB }}%
                        </div>
                    </div>

                    <p class="text-muted mt-3">
                        Tingkat Kesesuaian Properti Berdasarkan Metode SAW
                    </p>

                    <hr>

                    <h5 class="fw-bold">Keunggulan Properti</h5>

                    <ul class="mt-3 text-start">

                        @forelse($advantagesB as $item)
                            <li>✅ {{ $item }}</li>
                        @empty
                            <li>Tidak ada keunggulan dominan</li>
                        @endforelse

                    </ul>

                </div>

            </div>

        </div>

    </div>

    @endif

    @endif

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function(){
    $('.property-search').select2({
        placeholder: "Ketik nama properti...",
        allowClear: true,
        width: '100%'
    });
});
</script>

@endsection