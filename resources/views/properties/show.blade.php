@extends('layouts.app')

@section('content')

<section class="property-detail-section">
    <div class="container py-5">

        {{-- BREADCRUMB --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('properties.index') }}" class="text-decoration-none text-danger">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('properties.index') }}" class="text-decoration-none text-danger">Properti</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($property->title, 30) }}</li>
            </ol>
        </nav>

        <div class="row g-4">

            {{-- GAMBAR --}}
            <div class="col-lg-7">
                <div class="property-image-wrapper">
                    <img src="{{ $property->image }}" alt="{{ $property->title }}" class="img-fluid">
                    <div class="property-badge-group">
                        <span class="property-badge">{{ $property->property_type ?? 'Properti' }}</span>
                        @if($property->condition_score >= 80)
                            <span class="property-badge bg-success">Kondisi Baik</span>
                        @elseif($property->condition_score >= 60)
                            <span class="property-badge bg-warning text-dark">Kondisi Cukup</span>
                        @else
                            <span class="property-badge bg-secondary">Perlu Renovasi</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- INFO PROPERTI --}}
            <div class="col-lg-5">
                <div class="property-info-card">

                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h1 class="property-title">{{ $property->title }}</h1>
                            <p class="property-location">
                                <i class="bi bi-geo-alt-fill"></i>
                                {{ $property->location }}
                            </p>
                        </div>
                        <span class="property-type-badge">{{ $property->property_type ?? 'Properti' }}</span>
                    </div>

                    <div class="property-price">
                        Rp {{ number_format($property->price, 0, ',', '.') }}
                    </div>

                    <div class="property-details-grid">
                        <div class="detail-item">
                            <span class="icon">🛏</span>
                            <span class="value">{{ $property->bedroom }}</span>
                            <span class="label">Kamar Tidur</span>
                        </div>
                        <div class="detail-item">
                            <span class="icon">🚿</span>
                            <span class="value">{{ $property->bathroom }}</span>
                            <span class="label">Kamar Mandi</span>
                        </div>
                        <div class="detail-item">
                            <span class="icon">📐</span>
                            <span class="value">{{ $property->building_area }}</span>
                            <span class="label">Luas Bangunan</span>
                        </div>
                        <div class="detail-item">
                            <span class="icon">📏</span>
                            <span class="value">{{ $property->land_area ?? '-' }}</span>
                            <span class="label">Luas Tanah</span>
                        </div>
                        <div class="detail-item">
                            <span class="icon">📍</span>
                            <span class="value">{{ $property->distance_to_center ?? '-' }}</span>
                            <span class="label">Jarak ke Pusat</span>
                        </div>
                        <div class="detail-item">
                            <span class="icon">📄</span>
                            <span class="value">
                                <span class="badge bg-{{ $property->certificate_type == 'SHM' ? 'success' : ($property->certificate_type == 'SHGB' ? 'warning' : 'secondary') }}">
                                    {{ $property->certificate_type ?? '-' }}
                                </span>
                            </span>
                            <span class="label">Sertifikat</span>
                        </div>
                    </div>

                    <div class="property-description">
                        <p>{{ $property->description }}</p>
                    </div>

                    {{-- TOMBOL --}}
                    <div class="d-flex gap-3 mt-3">
                        <a href="{{ route('simulation.property', $property->id) }}" class="btn btn-danger btn-lg flex-grow-1">
                            <i class="bi bi-calculator"></i> Simulasi KPR
                        </a>
                        <button class="btn btn-outline-danger btn-lg" onclick="window.history.back()">
                            <i class="bi bi-arrow-left"></i>
                        </button>
                    </div>

                </div>
            </div>

        </div>

        {{-- FASILITAS & KEAMANAN --}}
        <div class="row mt-5 g-4">
            <div class="col-md-6">
                <div class="feature-card">
                    <div class="feature-header">
                        <i class="bi bi-shop feature-icon text-success"></i>
                        <h5 class="feature-title">Fasilitas Umum</h5>
                    </div>
                    <div class="feature-body">
                        @if($property->facility_details)
                            <ul class="feature-list">
                                @foreach(explode('|', $property->facility_details) as $item)
                                    <li><i class="bi bi-check-circle-fill text-success"></i> {{ $item }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted text-center py-4">Informasi fasilitas belum tersedia</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="feature-card">
                    <div class="feature-header">
                        <i class="bi bi-shield-lock feature-icon text-warning"></i>
                        <h5 class="feature-title">Keamanan Lingkungan</h5>
                    </div>
                    <div class="feature-body">
                        @if($property->security_details)
                            <ul class="feature-list">
                                @foreach(explode('|', $property->security_details) as $item)
                                    <li><i class="bi bi-shield-check text-warning"></i> {{ $item }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted text-center py-4">Informasi keamanan belum tersedia</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- PROPERTI LAINNYA --}}
        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="section-title">🏠 Properti Lainnya</h3>
                <a href="{{ route('properties.index') }}" class="text-danger text-decoration-none">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="row g-4">
                @php
                    $otherProperties = App\Models\Property::where('id', '!=', $property->id)
                        ->where('is_active', true)
                        ->inRandomOrder()
                        ->limit(4)
                        ->get();
                @endphp

                @foreach($otherProperties as $other)
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('properties.show', $other->id) }}" class="text-decoration-none text-dark">
                        <div class="property-mini-card">
                            <div class="mini-image">
                                <img src="{{ $other->image }}" alt="{{ $other->title }}">
                                <span class="mini-badge">{{ $other->property_type ?? 'Properti' }}</span>
                            </div>
                            <div class="mini-body">
                                <h6 class="mini-title">{{ $other->title }}</h6>
                                <p class="mini-location">{{ $other->location }}</p>
                                <span class="mini-price">Rp {{ number_format($other->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

<style>

/* ============================================================
   SECTION
   ============================================================ */

.property-detail-section {
    background: #f8fafc;
    min-height: 100vh;
}

/* ============================================================
   BREADCRUMB
   ============================================================ */

.breadcrumb {
    background: transparent;
    padding: 0;
    margin-bottom: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: #6b7280;
    font-size: 18px;
}

.breadcrumb-item a {
    font-weight: 500;
}

.breadcrumb-item.active {
    color: #6b7280;
}

/* ============================================================
   GAMBAR
   ============================================================ */

.property-image-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
}

.property-image-wrapper img {
    width: 100%;
    height: 500px;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.property-image-wrapper:hover img {
    transform: scale(1.02);
}

.property-badge-group {
    position: absolute;
    top: 20px;
    left: 20px;
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.property-badge {
    padding: 6px 16px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: #dc2626;
    color: #fff;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

.property-badge.bg-success {
    background: #059669 !important;
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
}

.property-badge.bg-warning {
    background: #f59e0b !important;
    color: #1f2937 !important;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.property-badge.bg-secondary {
    background: #6b7280 !important;
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
}

/* ============================================================
   INFO CARD
   ============================================================ */

.property-info-card {
    background: #fff;
    border-radius: 20px;
    padding: 32px;
    height: 100%;
    box-shadow: 0 10px 40px rgba(0,0,0,0.06);
}

.property-title {
    font-size: 24px;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 4px;
    line-height: 1.3;
}

.property-location {
    color: #6b7280;
    font-size: 14px;
    margin-bottom: 16px;
}

.property-location i {
    color: #dc2626;
    margin-right: 4px;
}

.property-type-badge {
    background: #f1f5f9;
    color: #1f2937;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.property-price {
    font-size: 30px;
    font-weight: 800;
    color: #dc2626;
    margin-bottom: 20px;
}

/* ============================================================
   DETAIL GRID
   ============================================================ */

.property-details-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}

.detail-item {
    background: #f8fafc;
    padding: 12px 10px;
    border-radius: 12px;
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.detail-item:hover {
    background: #f1f5f9;
    border-color: #e5e7eb;
}

.detail-item .icon {
    font-size: 16px;
    display: block;
    margin-bottom: 2px;
}

.detail-item .value {
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
    display: block;
}

.detail-item .value .badge {
    font-size: 11px;
}

.detail-item .label {
    font-size: 10px;
    color: #6b7280;
    display: block;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    font-weight: 600;
    margin-top: 2px;
}

/* ============================================================
   DESKRIPSI
   ============================================================ */

.property-description {
    padding: 16px 0;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
}

.property-description p {
    color: #4b5563;
    font-size: 14px;
    line-height: 1.8;
    margin-bottom: 0;
}

/* ============================================================
   FEATURE CARD (Fasilitas & Keamanan)
   ============================================================ */

.feature-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    overflow: hidden;
    height: 100%;
}

.feature-header {
    padding: 16px 24px;
    background: #f8fafc;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 12px;
}

.feature-icon {
    font-size: 22px;
}

.feature-title {
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0;
}

.feature-body {
    padding: 20px 24px;
}

.feature-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.feature-list li {
    padding: 8px 0;
    color: #1f2937;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 1px solid #f8fafc;
}

.feature-list li:last-child {
    border-bottom: none;
}

.feature-list i {
    font-size: 16px;
    flex-shrink: 0;
}

/* ============================================================
   SECTION TITLE
   ============================================================ */

.section-title {
    font-size: 24px;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 0;
}

/* ============================================================
   MINI CARD
   ============================================================ */

.property-mini-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    transition: all 0.4s ease;
    height: 100%;
}

.property-mini-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.12);
}

.mini-image {
    position: relative;
    overflow: hidden;
    height: 180px;
}

.mini-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.property-mini-card:hover .mini-image img {
    transform: scale(1.05);
}

.mini-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: #dc2626;
    color: #fff;
    padding: 2px 12px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.mini-body {
    padding: 16px 18px;
}

.mini-title {
    font-size: 14px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 2px;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.mini-location {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 8px;
}

.mini-price {
    font-size: 15px;
    font-weight: 700;
    color: #dc2626;
}

/* ============================================================
   RESPONSIVE
   ============================================================ */

@media (max-width: 992px) {
    .property-details-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    .property-image-wrapper img {
        height: 380px;
    }
}

@media (max-width: 768px) {
    .property-details-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .property-image-wrapper img {
        height: 280px;
    }
    .property-info-card {
        padding: 24px 20px;
    }
    .property-title {
        font-size: 20px;
    }
    .property-price {
        font-size: 24px;
    }
    .section-title {
        font-size: 20px;
    }
}

@media (max-width: 480px) {
    .property-details-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }
    .detail-item {
        padding: 10px 8px;
    }
    .detail-item .value {
        font-size: 14px;
    }
    .property-info-card {
        padding: 16px;
    }
    .feature-body {
        padding: 16px;
    }
}

</style>

@endsection