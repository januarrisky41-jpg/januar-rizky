@extends('layouts.app')

@section('content')

<section class="result-hero">

    <div class="overlay"></div>

    <div class="container position-relative text-center text-white">

        <h1 class="hero-title">
            Hasil Simulasi KPR
        </h1>

        <p class="hero-subtitle">
            Analisis pembiayaan hunian berdasarkan data yang Anda masukkan.
        </p>

    </div>

</section>

<section class="result-section">

    <div class="container">

        <div class="text-center mb-5">

            <p style="color:#6b7280; font-size:16px; margin-bottom:8px;">
                Properti yang Disimulasikan
            </p>

            <h2 style="color:#dc2626; font-weight:800; margin:0;">
                {{ $propertyTitle }}
            </h2>

        </div>

        {{-- ============================================================ --}}
        {{-- 3 KARTU UTAMA --}}
        {{-- ============================================================ --}}

        <div class="row g-4">

            <div class="col-md-4">
                <div class="result-card">
                    <p class="result-label">Estimasi Cicilan</p>
                    <h2 class="result-value" style="color:#dc2626; font-weight:bold;">
                        Rp {{ number_format($installment, 0, ',', '.') }}
                    </h2>
                    <span class="result-small">/ bulan (Fix)</span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="result-card">
                    <p class="result-label">Status Kelayakan</p>
                    @if($status == 'Layak')
                        <div class="status success">✅ {{ $status }}</div>
                    @elseif($status == 'Dipertimbangkan')
                        <div class="status warning">⚠️ {{ $status }}</div>
                    @else
                        <div class="status danger">❌ {{ $status }}</div>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="result-card">
                    <p class="result-label">Rasio Cicilan</p>
                    <h2 class="result-value">{{ round($installmentPercentage) }}%</h2>
                    <span class="result-small">dari penghasilan bulanan</span>
                    <div class="progress mt-3" style="height:8px; border-radius:10px;">
                        <div class="progress-bar bg-{{ $status == 'Layak' ? 'success' : ($status == 'Dipertimbangkan' ? 'warning' : 'danger') }}" 
                             style="width: {{ min($installmentPercentage, 100) }}%; border-radius:10px;">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- DETAIL PERHITUNGAN --}}
        {{-- ============================================================ --}}

        <div class="analysis-card mt-4">

            <h3 class="analysis-title">📊 Detail Perhitungan KPR</h3>

            <div class="row mt-4">

                <div class="col-md-6">

                    <div class="analysis-item">
                        <span>Harga Properti</span>
                        <strong>Rp {{ number_format($price, 0, ',', '.') }}</strong>
                    </div>

                    <div class="analysis-item">
                        <span>Uang Muka (DP)</span>
                        <strong>Rp {{ number_format($dp, 0, ',', '.') }} ({{ round($dpPercentage) }}%)</strong>
                    </div>

                    <div class="analysis-item">
                        <span>Pokok Kredit</span>
                        <strong>Rp {{ number_format($principal, 0, ',', '.') }}</strong>
                    </div>

                    <div class="analysis-item">
                        <span>Masa Kredit Fixed</span>
                        <strong>{{ $fixYears }} Tahun</strong>
                    </div>

                    <div class="analysis-item">
                        <span>Suku Bunga Fixed</span>
                        <strong class="text-success">{{ $interestFix * 100 }}%</strong>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="analysis-item">
                        <span>Tenor</span>
                        <strong>{{ $tenorYears }} Tahun ({{ $months }} Bulan)</strong>
                    </div>

                    <div class="analysis-item">
                        <span>Total Angsuran</span>
                        <strong>Rp {{ number_format($totalPayment, 0, ',', '.') }}</strong>
                    </div>

                    <div class="analysis-item">
                        <span>Total Bunga</span>
                        <strong>Rp {{ number_format($totalInterest, 0, ',', '.') }}</strong>
                    </div>

                    <div class="analysis-item">
                        <span>Suku Bunga Floating</span>
                        <strong class="text-danger">{{ $interestFloat * 100 }}%</strong>
                    </div>

                    <div class="analysis-item">
                        <span>Penghasilan / Bulan</span>
                        <strong>Rp {{ number_format($income, 0, ',', '.') }}</strong>
                    </div>

                </div>

            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- ANALISIS & REKOMENDASI --}}
        {{-- ============================================================ --}}

        <div class="analysis-card mt-4">

            <h3 class="analysis-title">💡 Analisis & Rekomendasi</h3>

            <div class="alert alert-{{ $statusClass }} mt-3">
                <strong>{{ $statusIcon }} Status: {{ $status }}</strong>
                <br>
                {{ $statusMessage }}
            </div>

            <div class="row mt-4">

                <div class="col-md-6">

                    <div class="analysis-item">
                        <span>Rekomendasi Budget Properti</span>
                        <strong>Rp {{ number_format($recommendedBudget, 0, ',', '.') }}</strong>
                    </div>

                    <div class="analysis-item">
                        <span>Estimasi DP Ideal (20%)</span>
                        <strong>Rp {{ number_format($dpIdeal, 0, ',', '.') }}</strong>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="analysis-item">
                        <span>Rekomendasi Tenor</span>
                        <strong>{{ $recommendedTenor }}</strong>
                    </div>

                    <div class="analysis-item">
                        <span>Catatan Tenor</span>
                        <strong>{{ $tenorMessage }}</strong>
                    </div>

                </div>

            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- SIMULASI ALTERNATIF (Jika Tidak Layak) --}}
        {{-- ============================================================ --}}

        @if($status != 'Layak')
        <div class="analysis-card mt-4" style="border-left: 5px solid #ffc107;">

            <h3 class="analysis-title">🔄 Simulasi Alternatif</h3>

            <div class="row mt-4">

                <div class="col-md-6">

                    <div class="analysis-item">
                        <span>Jika Tenor {{ $alternativeTenor }} Tahun</span>
                        <strong style="color:#dc2626;">Rp {{ number_format($altInstallmentFloat, 0, ',', '.') }}/bulan</strong>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="analysis-item">
                        <span>Jika DP 30%</span>
                        <strong style="color:#dc2626;">Rp {{ number_format($installmentHigherDp, 0, ',', '.') }}/bulan</strong>
                    </div>

                </div>

            </div>

            <div class="mt-3 text-muted small">
                💡 Tips: Perpanjang tenor atau tambah DP untuk menurunkan cicilan bulanan.
            </div>

        </div>
        @endif

        {{-- ============================================================ --}}
        {{-- TABEL AMORTISASI (DETAIL CICILAN) --}}
        {{-- LETAKKAN DI SINI --}}
        {{-- ============================================================ --}}

        <div class="analysis-card mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h3 class="analysis-title mb-0">
                    📋 Detail Cicilan ({{ $months }} Bulan)
                </h3>

                <a href="/simulation/pdf" class="btn btn-danger">
                    📄 Download PDF
                </a>

            </div>

            {{-- STATISTIK RINGKASAN --}}
            <div class="row g-3 mb-4">

                <div class="col-md-3">
                    <div class="bg-light p-3 rounded text-center">
                        <small class="text-muted">Total Pokok</small>
                        <h6 class="mb-0">Rp {{ number_format($totalPrincipalPaid, 0, ',', '.') }}</h6>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="bg-light p-3 rounded text-center">
                        <small class="text-muted">Total Bunga</small>
                        <h6 class="mb-0 text-danger">Rp {{ number_format($totalInterestPaidAll, 0, ',', '.') }}</h6>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="bg-light p-3 rounded text-center">
                        <small class="text-muted">Total Angsuran</small>
                        <h6 class="mb-0">Rp {{ number_format($totalInstallmentAll, 0, ',', '.') }}</h6>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="bg-light p-3 rounded text-center">
                        <small class="text-muted">Jumlah Bulan</small>
                        <h6 class="mb-0">{{ count($amortizationSchedule) }} Bulan</h6>
                    </div>
                </div>

            </div>

            {{-- SCROLLABLE TABLE --}}
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto; border-radius: 10px; border: 1px solid #dee2e6;">

                <table class="table table-bordered table-hover mb-0">

                    <thead class="table-danger" style="position: sticky; top: 0; z-index: 10;">

                        <tr>

                            <th style="min-width: 70px;">Bulan</th>

                            <th style="min-width: 120px;">Periode</th>

                            <th style="min-width: 150px;">Sisa Pinjaman</th>

                            <th style="min-width: 150px;">Porsi Pokok</th>

                            <th style="min-width: 150px;">Porsi Bunga</th>

                            <th style="min-width: 150px;">Angsuran</th>

                            <th style="min-width: 100px;">Bunga</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($amortizationSchedule as $item)

                        <tr>

                            <td>{{ $item['month'] }}</td>

                            <td>
                                @if($item['period'] == 'Fix')
                                    <span class="badge bg-success">Fix {{ $fixYears }} Tahun</span>
                                @else
                                    <span class="badge bg-warning text-dark">Floating</span>
                                @endif
                            </td>

                            <td>Rp {{ number_format($item['remaining_balance'], 0, ',', '.') }}</td>

                            <td>Rp {{ number_format($item['principal_paid'], 0, ',', '.') }}</td>

                            <td>Rp {{ number_format($item['interest_paid'], 0, ',', '.') }}</td>

                            <td>Rp {{ number_format($item['installment'], 0, ',', '.') }}</td>

                            <td>
                                @if($item['period'] == 'Fix')
                                    <span class="text-success fw-bold">{{ $item['interest_rate'] }}%</span>
                                @else
                                    <span class="text-danger fw-bold">{{ $item['interest_rate'] }}%</span>
                                @endif
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3 text-muted small">

                <i class="bi bi-info-circle"></i>

                Menampilkan semua {{ count($amortizationSchedule) }} bulan.
                Total bunga yang dibayarkan: <strong>Rp {{ number_format($totalInterestPaidAll, 0, ',', '.') }}</strong>

            </div>

            <div class="mt-3 alert alert-warning small">

                <i class="bi bi-exclamation-triangle"></i>

                <strong>Catatan:</strong> Perhitungan ini adalah hasil perkiraan aplikasi KPR secara umum.
                Data perhitungan di atas dapat berbeda dengan perhitungan bank.
                Untuk perhitungan yang akurat, silakan hubungi kantor cabang kami.

            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- REKOMENDASI PROPERTY --}}
        {{-- ============================================================ --}}

        <div class="recommendation-section mt-5">

            <h3 class="section-title">🏠 Rekomendasi Properti</h3>

            <p class="text-muted">
                Properti dengan harga sesuai dengan rekomendasi budget Anda.
            </p>

            <div class="row g-4 mt-2">

                @forelse($recommendedProperties as $property)

                <div class="col-md-4">

                    <div class="property-card">

                        <img src="{{ $property->image }}" alt="Property" style="width:100%; height:200px; object-fit:cover;">

                        <div class="property-body">

                            <h5>{{ $property->title }}</h5>
                            <p class="location">{{ $property->location }}</p>
                            <h6 class="price" style="color:#dc2626; font-weight:bold;">
                                Rp {{ number_format($property->price, 0, ',', '.') }}
                            </h6>

                            <div class="property-info">
                                <span>🛏 {{ $property->bedroom }} KT</span>
                                <span>🚿 {{ $property->bathroom }} KM</span>
                            </div>

                        </div>

                    </div>

                </div>

                @empty

                <div class="col-12">
                    <div class="alert alert-warning">Tidak ada properti yang sesuai dengan hasil analisis.</div>
                </div>

                @endforelse

            </div>

        </div>

    </div>

</section>

<style>

.result-hero {

    position: relative;

    min-height: 320px;

    background:
        linear-gradient(
            rgba(0,0,0,0.55),
            rgba(0,0,0,0.55)
        ),
        url('https://images.unsplash.com/photo-1560518883-ce09059eeffa');

    background-size: cover;

    background-position: center;

    display: flex;

    align-items: center;
}

.overlay {

    position: absolute;

    inset: 0;
}

.hero-title {

    font-size: 52px;

    font-weight: 800;
}

.hero-subtitle {

    font-size: 18px;

    margin-top: 15px;
}

.result-section {

    padding: 80px 0;

    background: #f4f7fb;
}

.result-card {

    background: white;

    border-radius: 22px;

    padding: 35px;

    text-align: center;

    box-shadow: 0 5px 20px rgba(0,0,0,0.08);

    height: 100%;
}

.result-label {

    color: #666;

    font-size: 15px;
}

.result-value {

    font-size: 34px;

    font-weight: 800;

    margin-top: 10px;
}

.result-small {

    color: #888;
}

.status {

    display: inline-block;

    padding: 12px 25px;

    border-radius: 30px;

    font-weight: bold;

    margin-top: 20px;
}

.success {

    background: #d4edda;

    color: #155724;
}

.warning {

    background: #fff3cd;

    color: #856404;
}

.danger {

    background: #f8d7da;

    color: #721c24;
}

.analysis-card {

    background: white;

    border-radius: 25px;

    padding: 40px;

    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.analysis-title {

    font-weight: 800;

    color: #222;
}

.analysis-item {

    display: flex;

    justify-content: space-between;

    padding: 18px 0;

    border-bottom: 1px solid #eee;
}

.section-title {

    font-size: 32px;

    font-weight: 800;
}

.property-card {

    background: white;

    border-radius: 20px;

    overflow: hidden;

    box-shadow: 0 5px 20px rgba(0,0,0,0.08);

    transition: 0.3s;

    height: 100%;
}

.property-card:hover {

    transform: translateY(-6px);
}

.property-card img {

    width: 100%;

    height: 220px;

    object-fit: cover;
}

.property-body {

    padding: 22px;
}

.location {

    color: #777;
}

.price {

    color: #0056ff;

    font-weight: 800;

    margin-top: 10px;
}

.property-info {

    display: flex;

    gap: 20px;

    margin-top: 15px;

    color: #555;
}

.progress {
    background-color: #e9ecef;
}

.table-responsive {
    overflow-x: auto;
}

.table-responsive::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #dc2626;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #991b1b;
}

.table thead th {
    white-space: nowrap;
}

</style>

@endsection