{{-- resources/views/recommendation/index.blade.php --}}

@extends('layouts.app')

@section('content')

<section class="recommendation-section">
    <div class="container">

        {{-- HEADER --}}
        <div class="text-center mb-5">
            <h1 class="main-title">Properti yang Direkomendasikan Untuk Anda</h1>
            <p class="main-subtitle">
                Rekomendasi properti disesuaikan dengan kemampuan finansial yang telah Anda input,
                sehingga hasil yang ditampilkan lebih relevan dan sesuai dengan kondisi keuangan Anda.
            </p>

            @if($budget)
                <div class="budget-alert">
                    <i class="bi bi-wallet2"></i>
                    <strong>Budget Maksimal Properti Anda :</strong>
                    Rp {{ number_format($budget, 0, ',', '.') }}
                </div>
            @else
                <div class="budget-alert warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Belum ada budget.</strong>
                    Silakan <a href="{{ route('affordability.index') }}">hitung analisis finansial</a> terlebih dahulu.
                </div>
            @endif
        </div>

        @if($topProperties->count() > 0)

        {{-- TOP 3 PROPERTI --}}
        <div class="row g-4 mb-5">
            @foreach($topProperties->take(3) as $index => $property)
            <div class="col-lg-4">
                <div class="top-card {{ $index == 0 ? 'top-1' : ($index == 1 ? 'top-2' : 'top-3') }}">
                    <div class="top-badge">
                        @if($index == 0) 🥇 Pilihan Terbaik
                        @elseif($index == 1) 🥈 Pilihan Kedua
                        @else 🥉 Pilihan Ketiga
                        @endif
                    </div>
                    <img src="{{ $property->image }}" alt="{{ $property->title }}" class="top-image">
                    <div class="top-body">
                        <h3 class="top-title">{{ $property->title }}</h3>
                        <p class="top-location"><i class="bi bi-geo-alt-fill text-danger"></i> {{ $property->location }}</p>
                        <div class="top-details">
                            <span>🛏 {{ $property->bedroom }} KT</span>
                            <span>🚿 {{ $property->bathroom }} KM</span>
                            <span>📐 {{ $property->building_area }} m²</span>
                        </div>
                        <div class="top-price">Rp {{ number_format($property->price, 0, ',', '.') }}</div>
                        <div class="top-rating">
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $property->rating)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @else
                                        <i class="bi bi-star text-muted"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-score">{{ $property->percentage }}%</span>
                        </div>
                        <div class="top-status">
                            <span class="status-badge status-{{ $property->recommendation_class }}">
                                {{ $property->recommendation_status }}
                            </span>
                        </div>
                        <a href="{{ route('properties.show', $property->id) }}" class="top-button">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- TABEL REKOMENDASI --}}
        <div class="table-card">
            <div class="table-header">
                <h4 class="table-title">📋 Daftar Properti Berdasarkan Tingkat Rekomendasi</h4>
                <span class="table-count">{{ $properties->count() }} Properti</span>
            </div>
            <div class="table-responsive">
                <table class="recommendation-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Properti</th>
                            <th>Lokasi</th>
                            <th>Harga</th>
                            <th>Luas Bangunan</th>
                            <th>Rekomendasi</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($properties as $index => $property)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $property->title }}</strong>
                                <small class="d-block text-muted">{{ $property->property_type ?? 'Properti' }}</small>
                            </td>
                            <td>{{ $property->location }}</td>
                            <td>Rp {{ number_format($property->price, 0, ',', '.') }}</td>
                            <td>{{ $property->building_area }} m²</td>
                            <td>
                                <div class="td-status">
                                    <div class="td-progress">
                                        <div class="td-progress-bar" style="width: {{ $property->percentage }}%; background: {{ $property->percentage >= 80 ? '#1a5e3a' : ($property->percentage >= 50 ? '#b45309' : '#991b1b') }};">
                                            {{ $property->percentage }}%
                                        </div>
                                    </div>
                                    <span class="status-badge-sm status-{{ $property->recommendation_class }}">
                                        {{ $property->recommendation_status }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('properties.show', $property->id) }}" class="btn-detail-sm" title="Lihat Detail Properti">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button class="btn-score-sm" onclick="toggleScore({{ $property->id }})" title="Lihat Detail Penilaian">
                                    <i class="bi bi-graph-up"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- DETAIL PENILAIAN (Hidden) --}}
                        <tr id="score-{{ $property->id }}" class="score-detail-row" style="display: none;">
                            <td colspan="7">
                                <div class="score-detail">
                                    <h5 class="score-detail-title">📊 Detail Penilaian Properti</h5>
                                    <p class="score-detail-sub">Penilaian berdasarkan 10 kriteria dengan pembobotan</p>

                                    <div class="score-detail-grid">
                                        @php
                                            $criteriaList = [
                                                'price' => ['label' => 'Harga Properti', 'weight' => 20, 'type' => 'Cost'],
                                                'distance_to_center' => ['label' => 'Lokasi & Aksesibilitas', 'weight' => 18, 'type' => 'Cost'],
                                                'building_area' => ['label' => 'Luas Bangunan', 'weight' => 12, 'type' => 'Benefit'],
                                                'land_area' => ['label' => 'Luas Tanah', 'weight' => 10, 'type' => 'Benefit'],
                                                'facility_score' => ['label' => 'Fasilitas Umum', 'weight' => 10, 'type' => 'Benefit'],
                                                'security_score' => ['label' => 'Keamanan Lingkungan', 'weight' => 8, 'type' => 'Benefit'],
                                                'bedroom' => ['label' => 'Jumlah Kamar Tidur', 'weight' => 8, 'type' => 'Benefit'],
                                                'condition_score' => ['label' => 'Kondisi Fisik Bangunan', 'weight' => 6, 'type' => 'Benefit'],
                                                'certificate_score' => ['label' => 'Sertifikat Tanah', 'weight' => 4, 'type' => 'Benefit'],
                                                'investment_score' => ['label' => 'Potensi Investasi', 'weight' => 4, 'type' => 'Benefit'],
                                            ];
                                            $totalScore = 0;
                                        @endphp

                                        @foreach($criteriaList as $key => $criterion)
                                            @php
                                                $score = $property->normalized_scores[$key] ?? 0;
                                                $contribution = $score * $criterion['weight'];
                                                $totalScore += $contribution;
                                                $scorePercent = round($score * 100, 1);
                                                $contributionRounded = round($contribution, 1);
                                            @endphp
                                            <div class="score-detail-item">
                                                <span class="criteria-name">{{ $criterion['label'] }} <span class="criteria-weight">{{ $criterion['weight'] }}%</span> <span class="criteria-type {{ strtolower($criterion['type']) }}">{{ $criterion['type'] }}</span></span>
                                                <div class="criteria-values">
                                                    <span>
                                                        @if($key === 'price')
                                                            Rp {{ number_format($property->price, 0, ',', '.') }}
                                                        @elseif($key === 'distance_to_center')
                                                            {{ $property->distance_to_center ?? '-' }} km
                                                        @elseif($key === 'building_area')
                                                            {{ $property->building_area }} m²
                                                        @elseif($key === 'land_area')
                                                            {{ $property->land_area ?? '-' }} m²
                                                        @elseif($key === 'facility_score')
                                                            {{ $property->facility_score ?? '-' }}/5
                                                        @elseif($key === 'security_score')
                                                            {{ $property->security_score ?? '-' }}/5
                                                        @elseif($key === 'bedroom')
                                                            {{ $property->bedroom }}
                                                        @elseif($key === 'condition_score')
                                                            {{ $property->condition_score }}%
                                                        @elseif($key === 'certificate_score')
                                                            {{ $property->certificate_type ?? '-' }}
                                                        @elseif($key === 'investment_score')
                                                            {{ $property->investment_score ?? '-' }}/5
                                                        @endif
                                                    </span>
                                                    <span>Skor: {{ $scorePercent }}%</span>
                                                    <span class="contribution">× {{ $criterion['weight'] }}% = {{ $contributionRounded }}%</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- PERHITUNGAN TOTAL --}}
                                    <div class="score-calculation">
                                        <h6 class="calculation-title">🧮 Perhitungan Total Skor</h6>
                                        <div class="calculation-row">
                                            @foreach($criteriaList as $key => $criterion)
                                                @php
                                                    $score = $property->normalized_scores[$key] ?? 0;
                                                    $contribution = round($score * $criterion['weight'], 1);
                                                @endphp
                                                <span class="calc-item">{{ $criterion['label'] }}: {{ round($score * 100, 1) }}% × {{ $criterion['weight'] }}% = {{ $contribution }}%</span>
                                            @endforeach
                                        </div>
                                        <div class="calculation-result">
                                            <strong>Total = {{ round($totalScore, 1) }}%</strong>
                                            <span class="status-badge-sm status-{{ $property->recommendation_class }}">
                                                {{ $property->recommendation_status }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="score-note">
                                        <small>
                                            <i class="bi bi-info-circle"></i>
                                            <strong>Keterangan:</strong>
                                            <span class="badge-cost">Cost</span> = Semakin rendah nilai semakin baik &nbsp;|&nbsp;
                                            <span class="badge-benefit">Benefit</span> = Semakin tinggi nilai semakin baik
                                        </small>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PENJELASAN  --}}
        <div class="explanation-simple">
            <h4 class="explanation-title">💡 Bagaimana Rekomendasi Dihasilkan?</h4>
            <p class="explanation-text">
                Sistem menganalisis kemampuan finansial pengguna (penghasilan, pengeluaran, tenor), lalu mengevaluasi setiap properti berdasarkan 10 kriteria dengan sistem pembobotan yang terdiri dari Harga Properti (20%), Lokasi & Aksesibilitas (18%), Luas Bangunan (12%), Luas Tanah (10%), Fasilitas Umum (10%), Keamanan Lingkungan (8%), Jumlah Kamar Tidur (8%), Kondisi Fisik Bangunan (6%), Sertifikat Tanah (4%), dan Potensi Investasi (4%). Hasil evaluasi menentukan tingkat kecocokan sehingga pengguna dapat menemukan properti paling sesuai.
            </p>
        </div>

        @else

        {{-- EMPTY STATE --}}
        <div class="empty-state">
            <i class="bi bi-house-slash"></i>
            <h3>Tidak Ada Properti yang Sesuai</h3>
            <p>Berdasarkan kemampuan finansial yang Anda input, belum ditemukan properti yang sesuai. Coba tingkatkan tenor atau sesuaikan kembali data finansial Anda.</p>
            <a href="{{ route('affordability.index') }}" class="empty-button">Hitung Ulang Analisis Finansial</a>
        </div>

        @endif

    </div>
</section>

<script>
function toggleScore(id) {
    const row = document.getElementById('score-' + id);
    if (row.style.display === 'none' || row.style.display === '') {
        row.style.display = 'table-row';
    } else {
        row.style.display = 'none';
    }
}
</script>

<style>
/* ============================================================
   MAIN - WARNA MERAH TEMA
   ============================================================ */

.recommendation-section {
    padding: 60px 0 80px;
    background: #f8f9fa;
    min-height: 100vh;
}

.main-title {
    font-size: 38px;
    font-weight: 900;
    color: #1a1a2e;
    margin-bottom: 12px;
}

.main-subtitle {
    font-size: 16px;
    color: #4a4a6a;
    max-width: 700px;
    margin: 0 auto 20px;
}

/* ============================================================
   BUDGET ALERT
   ============================================================ */

.budget-alert {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #fee2e2;
    color: #991b1b;
    padding: 12px 28px;
    border-radius: 12px;
    font-size: 16px;
    border: 1px solid #fca5a5;
}

.budget-alert i { font-size: 20px; }

.budget-alert.warning {
    background: #fef3c7;
    color: #78350f;
    border-color: #f59e0b;
}

.budget-alert a {
    color: #dc2626;
    font-weight: 700;
    text-decoration: none;
}

/* ============================================================
   TOP 3 CARDS
   ============================================================ */

.top-card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    height: 100%;
    transition: all 0.3s ease;
    position: relative;
    border: 2px solid #e5e7eb;
}

.top-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.12);
}

.top-card.top-1 { border-color: #dc2626; }
.top-card.top-2 { border-color: #9ca3af; }
.top-card.top-3 { border-color: #b45309; }

.top-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 4px 14px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 700;
    z-index: 5;
    box-shadow: 0 2px 10px rgba(0,0,0,0.15);
    background: #dc2626;
    color: #ffffff;
}

.top-card.top-1 .top-badge { background: #dc2626; }
.top-card.top-2 .top-badge { background: #6b7280; }
.top-card.top-3 .top-badge { background: #b45309; }

.top-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.top-body { padding: 20px 24px 24px; }

.top-title {
    font-size: 18px;
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 4px;
}

.top-location {
    font-size: 14px;
    color: #4a4a6a;
    margin-bottom: 12px;
}

.top-details {
    display: flex;
    gap: 16px;
    font-size: 13px;
    color: #4a4a6a;
    margin-bottom: 12px;
}

.top-price {
    font-size: 22px;
    font-weight: 800;
    color: #dc2626;
    margin-bottom: 12px;
}

.top-rating {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}

.rating-stars { font-size: 16px; }
.rating-score { font-size: 16px; font-weight: 700; color: #1a1a2e; }

.top-status { margin-bottom: 16px; }

/* ============================================================
   STATUS BADGE - KONTRAS TINGGI
   ============================================================ */

.status-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 700;
    color: #ffffff;
}

.status-badge.status-success { background: #059669; }
.status-badge.status-primary { background: #2563eb; }
.status-badge.status-warning { background: #d97706; }
.status-badge.status-secondary { background: #6b7280; }
.status-badge.status-danger { background: #dc2626; }

/* ============================================================
   TOP BUTTON
   ============================================================ */

.top-button {
    display: block;
    width: 100%;
    text-align: center;
    background: #dc2626;
    color: #ffffff;
    padding: 10px;
    border-radius: 10px;
    font-weight: 700;
    text-decoration: none;
    transition: 0.3s;
    font-size: 14px;
}

.top-button:hover {
    background: #b91c1c;
    color: #ffffff;
}

/* ============================================================
   TABLE
   ============================================================ */

.table-card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-top: 40px;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 24px;
    background: #dc2626;
    color: #ffffff;
}

.table-title { font-size: 18px; font-weight: 700; margin: 0; }
.table-count { font-size: 14px; background: rgba(255,255,255,0.2); padding: 4px 14px; border-radius: 30px; }

.recommendation-table {
    width: 100%;
    border-collapse: collapse;
}

.recommendation-table thead { background: #f1f4f8; }
.recommendation-table th { padding: 12px 16px; text-align: left; font-size: 13px; font-weight: 700; color: #1a1a2e; border-bottom: 2px solid #d1d5db; }
.recommendation-table td { padding: 12px 16px; border-bottom: 1px solid #e5e7eb; vertical-align: middle; font-size: 14px; color: #1a1a2e; }
.recommendation-table tr:hover { background: #f8fafc; }
.recommendation-table tr.score-detail-row { background: #f8fafc; }
.recommendation-table tr.score-detail-row:hover { background: #f1f4f8; }

.td-status {
    display: flex;
    flex-direction: column;
    gap: 6px;
    min-width: 140px;
}

.td-progress {
    width: 100%;
    height: 20px;
    background: #e5e7eb;
    border-radius: 30px;
    overflow: hidden;
}

.td-progress-bar {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: #ffffff;
    border-radius: 30px;
    transition: width 0.6s ease;
}

/* ============================================================
   STATUS BADGE SMALL - KONTRAS TINGGI
   ============================================================ */

.status-badge-sm {
    display: inline-block;
    padding: 2px 12px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 700;
    color: #ffffff;
}

.status-badge-sm.status-success { background: #059669; }
.status-badge-sm.status-primary { background: #2563eb; }
.status-badge-sm.status-warning { background: #d97706; }
.status-badge-sm.status-secondary { background: #6b7280; }
.status-badge-sm.status-danger { background: #dc2626; }

/* ============================================================
   BUTTONS
   ============================================================ */

.btn-detail-sm, .btn-score-sm {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: #f1f4f8;
    color: #4a4a6a;
    border: none;
    text-decoration: none;
    transition: 0.3s;
    cursor: pointer;
}

.btn-detail-sm:hover { background: #dc2626; color: #ffffff; }
.btn-score-sm:hover { background: #d97706; color: #ffffff; }

/* ============================================================
   SCORE DETAIL
   ============================================================ */

.score-detail {
    padding: 20px 24px;
    background: #ffffff;
    border-top: 2px solid #e5e7eb;
}

.score-detail-title {
    font-size: 16px;
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 2px;
}

.score-detail-sub {
    font-size: 13px;
    color: #4a4a6a;
    margin-bottom: 16px;
}

.score-detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

.score-detail-item {
    background: #f8fafc;
    padding: 10px 14px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
}

.score-detail-item .criteria-name {
    font-weight: 700;
    color: #1a1a2e;
    display: block;
    margin-bottom: 4px;
    font-size: 13px;
}

.score-detail-item .criteria-weight { font-weight: 700; color: #dc2626; }
.score-detail-item .criteria-type {
    font-size: 10px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 20px;
    margin-left: 4px;
}

.score-detail-item .criteria-type.cost { background: #fecaca; color: #991b1b; }
.score-detail-item .criteria-type.benefit { background: #bbf7d0; color: #166534; }

.criteria-values {
    display: flex;
    gap: 12px;
    font-size: 13px;
    color: #4a4a6a;
    flex-wrap: wrap;
}

.criteria-values span {
    background: #ffffff;
    padding: 2px 10px;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
    color: #1a1a2e;
}

.criteria-values .contribution {
    background: #fee2e2;
    border-color: #fca5a5;
    color: #991b1b;
    font-weight: 600;
}

/* ============================================================
   SCORE CALCULATION
   ============================================================ */

.score-calculation {
    margin-top: 14px;
    padding-top: 14px;
    border-top: 2px solid #e5e7eb;
}

.calculation-title {
    font-size: 14px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 8px;
}

.calculation-row {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 10px;
}

.calc-item {
    background: #f1f4f8;
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 12px;
    color: #1a1a2e;
    border: 1px solid #e5e7eb;
}

.calculation-result {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 10px 16px;
    background: #fee2e2;
    border-radius: 10px;
    border: 1px solid #fca5a5;
}

.calculation-result strong {
    font-size: 18px;
    color: #991b1b;
}

/* ============================================================
   SCORE NOTE
   ============================================================ */

.score-note {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid #f1f5f9;
}

.score-note small {
    color: #4a4a6a;
    font-size: 12px;
}

.badge-cost {
    display: inline-block;
    background: #fecaca;
    color: #991b1b;
    padding: 0 8px;
    border-radius: 4px;
    font-weight: 700;
    font-size: 11px;
}

.badge-benefit {
    display: inline-block;
    background: #bbf7d0;
    color: #166534;
    padding: 0 8px;
    border-radius: 4px;
    font-weight: 700;
    font-size: 11px;
}

/* ============================================================
   EXPLANATION
   ============================================================ */

.explanation-simple {
    background: #ffffff;
    border-radius: 20px;
    padding: 28px 32px;
    margin-top: 40px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}

.explanation-title {
    font-size: 20px;
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 10px;
}

.explanation-text {
    font-size: 15px;
    color: #4a4a6a;
    line-height: 1.8;
    margin-bottom: 16px;
}

.criteria-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 16px;
}

.criteria-tag {
    background: #f1f4f8;
    padding: 4px 14px;
    border-radius: 30px;
    font-size: 13px;
    color: #1a1a2e;
    border: 1px solid #e5e7eb;
}

.criteria-tag .criteria-weight {
    font-weight: 700;
    color: #dc2626;
    margin-right: 4px;
}

.explanation-footer {
    font-size: 14px;
    color: #4a4a6a;
    line-height: 1.7;
    margin-top: 8px;
    padding-top: 14px;
    border-top: 1px solid #e5e7eb;
}

/* ============================================================
   EMPTY STATE
   ============================================================ */

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}

.empty-state i { font-size: 56px; color: #d1d5db; }
.empty-state h3 { margin: 16px 0 8px; font-size: 24px; color: #1a1a2e; }
.empty-state p { color: #4a4a6a; max-width: 500px; margin: 0 auto 24px; }

.empty-button {
    display: inline-block;
    background: #dc2626;
    color: #ffffff;
    padding: 12px 32px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 700;
    transition: 0.3s;
}

.empty-button:hover { background: #b91c1c; color: #ffffff; }

/* ============================================================
   RESPONSIVE
   ============================================================ */

@media (max-width: 992px) {
    .criteria-list { gap: 6px; }
    .score-detail-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .main-title { font-size: 28px; }
    .main-subtitle { font-size: 14px; }
    .budget-alert { font-size: 14px; padding: 10px 20px; flex-wrap: wrap; justify-content: center; }
    .score-detail-grid { grid-template-columns: 1fr; }
    .explanation-simple { padding: 20px; }
    .table-header { flex-direction: column; align-items: flex-start; gap: 8px; }
    .recommendation-table th, .recommendation-table td { padding: 10px 12px; font-size: 13px; }
    .top-image { height: 160px; }
    .score-detail { padding: 14px 16px; }
    .criteria-values { flex-direction: column; gap: 4px; }
    .calculation-row { flex-direction: column; gap: 4px; }
    .calculation-result { flex-wrap: wrap; }
}

@media (max-width: 480px) {
    .criteria-list { flex-direction: column; align-items: flex-start; }
    .score-detail-grid { grid-template-columns: 1fr; }
    .recommendation-table { font-size: 12px; }
    .recommendation-table th, .recommendation-table td { padding: 8px 10px; }
    .top-card { border-radius: 14px; }
    .top-body { padding: 16px; }
    .top-price { font-size: 18px; }
    .explanation-simple { padding: 16px; }
}

</style>

@endsection