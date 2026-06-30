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

        {{-- 3 KARTU UTAMA --}}
        <div class="row g-4">

            <div class="col-md-4">
                <div class="result-card">
                    <p class="result-label">Estimasi Cicilan</p>
                    <h2 class="result-value" style="color:#dc2626; font-weight:bold;">
                        Rp {{ number_format($displayInstallment, 0, ',', '.') }}
                    </h2>
                    <span class="result-small">/ bulan</span>
                    @if($fixMonths > 0)
                        <small class="d-block text-muted mt-1">
                            <span class="text-success">Fix: Rp {{ number_format($installmentFix, 0, ',', '.') }}</span> | 
                            <span class="text-danger">Floating: Rp {{ number_format($installmentFloat, 0, ',', '.') }}</span>
                        </small>
                    @endif
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
                        <div class="progress-bar bg-{{ $statusClass }}" 
                             style="width: {{ min($installmentPercentage, 100) }}%; border-radius:10px;">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- DETAIL PERHITUNGAN --}}
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
                        <strong>{{ $fixYears }} Tahun ({{ $fixMonths }} Bulan)</strong>
                    </div>

                    <div class="analysis-item">
                        <span>Suku Bunga Fixed</span>
                        <strong class="text-success">{{ $interestFix * 100 }}%</strong>
                    </div>

                    @if($fixMonths > 0 && $installmentFix > 0)
                    <div class="analysis-item" style="background:#f0fdf4; border-radius:8px; padding:12px 18px;">
                        <span><i class="bi bi-check-circle-fill text-success"></i> Cicilan Fixed</span>
                        <strong class="text-success">Rp {{ number_format($installmentFix, 0, ',', '.') }}</strong>
                    </div>
                    @endif

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

                    @if($floatMonths > 0 && $installmentFloat > 0)
                    <div class="analysis-item" style="background:#fef2f2; border-radius:8px; padding:12px 18px;">
                        <span><i class="bi bi-exclamation-triangle-fill text-danger"></i> Cicilan Floating</span>
                        <strong class="text-danger">Rp {{ number_format($installmentFloat, 0, ',', '.') }}</strong>
                    </div>
                    @endif

                    <div class="analysis-item">
                        <span>Penghasilan / Bulan</span>
                        <strong>Rp {{ number_format($income, 0, ',', '.') }}</strong>
                    </div>

                </div>

            </div>

        </div>

        {{-- ANALISIS & REKOMENDASI --}}
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

        {{-- TABEL AMORTISASI --}}
        <div class="analysis-card mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h3 class="analysis-title mb-0">
                    📋 Detail Cicilan ({{ $months }} Bulan)
                </h3>

                <a href="/simulation/pdf" class="btn btn-danger">
                    📄 Download PDF
                </a>

            </div>

            {{-- INFORMASI PERIODE --}}
            @if($fixMonths > 0)
            <div class="alert alert-info py-2 small">
                <i class="bi bi-info-circle"></i>
                <strong>Periode Fix:</strong> Bulan 1-{{ $fixMonths }} ({{ $fixYears }} Tahun) dengan bunga <span class="text-success fw-bold">{{ $interestFix * 100 }}%</span> &nbsp;|&nbsp;
                <strong>Periode Floating:</strong> Bulan {{ $fixMonths+1 }}-{{ $months }} dengan bunga <span class="text-danger fw-bold">{{ $interestFloat * 100 }}%</span>
            </div>
            @else
            <div class="alert alert-warning py-2 small">
                <i class="bi bi-exclamation-triangle"></i>
                <strong>Semua periode Floating</strong> dengan bunga <span class="text-danger fw-bold">{{ $interestFloat * 100 }}%</span>
            </div>
            @endif

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
                            <th style="min-width: 100px;">Periode</th>
                            <th style="min-width: 150px;">Sisa Pinjaman</th>
                            <th style="min-width: 150px;">Porsi Pokok</th>
                            <th style="min-width: 150px;">Porsi Bunga</th>
                            <th style="min-width: 150px;">Angsuran</th>
                            <th style="min-width: 80px;">Bunga</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($amortizationSchedule as $item)

                        <tr>
                            <td>{{ $item['month'] }}</td>
                            <td>
                                @if(str_contains($item['period'], 'Fix'))
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
                                @if(str_contains($item['period'], 'Fix'))
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

        {{-- REKOMENDASI PROPERTI --}}
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

                        <div class="property-body" style="padding:20px;">

                            <h5>{{ $property->title }}</h5>
                            <p class="location" style="color:#777;">{{ $property->location }}</p>
                            <h6 class="price" style="color:#dc2626; font-weight:bold;">
                                Rp {{ number_format($property->price, 0, ',', '.') }}
                            </h6>

                            <div class="property-info" style="display:flex; gap:15px; margin-top:10px; color:#555;">
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
    background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)),
        url('https://images.unsplash.com/photo-1560518883-ce09059eeffa');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
}

.overlay { position: absolute; inset: 0; }
.hero-title { font-size: 52px; font-weight: 800; }
.hero-subtitle { font-size: 18px; margin-top: 15px; }

.result-section { padding: 80px 0; background: #f4f7fb; }

.result-card {
    background: white;
    border-radius: 22px;
    padding: 35px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    height: 100%;
}

.result-label { color: #666; font-size: 15px; }
.result-value { font-size: 34px; font-weight: 800; margin-top: 10px; }
.result-small { color: #888; }

.status {
    display: inline-block;
    padding: 12px 25px;
    border-radius: 30px;
    font-weight: bold;
    margin-top: 20px;
}

.success { background: #d4edda; color: #155724; }
.warning { background: #fff3cd; color: #856404; }
.danger { background: #f8d7da; color: #721c24; }

.analysis-card {
    background: white;
    border-radius: 25px;
    padding: 40px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.analysis-title { font-weight: 800; color: #222; }

.analysis-item {
    display: flex;
    justify-content: space-between;
    padding: 18px 0;
    border-bottom: 1px solid #eee;
}

.section-title { font-size: 32px; font-weight: 800; }

.property-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: 0.3s;
    height: 100%;
}

.property-card:hover { transform: translateY(-6px); }

.progress { background-color: #e9ecef; }

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