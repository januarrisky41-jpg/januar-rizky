@extends('layouts.app')

@section('content')

<section class="py-5 bg-light">

    <div class="container">

        <div class="text-center mb-5">

            <h1 class="fw-bold display-5">
                Properti yang Direkomendasikan Untuk Anda
            </h1>

            <p
                class="text-muted mx-auto"
                style="max-width:700px;"
            >
                Rekomendasi properti disesuaikan dengan
                kemampuan finansial yang telah Anda input,
                sehingga hasil yang ditampilkan lebih relevan
                dan sesuai dengan kondisi keuangan Anda.
            </p>

            @if($budget)
            <div
                class="alert alert-success mt-4 mx-auto"
                style="max-width:700px;"
            >
                <strong>
                    Budget Maksimal Properti Anda :
                </strong>
                Rp{{ number_format($budget,0,',','.') }}
            </div>
            @endif

        </div>

        @if($topProperties->count() > 0)

        {{-- TOP 3 PROPERTI --}}
        <div class="row g-4 mb-5">

            @foreach($topProperties->take(3) as $property)

            <div class="col-lg-4">

                {{--
                |--------------------------------------------------------------------------
                | SELURUH CARD DIBUNGKUS LINK KE DETAIL
                |--------------------------------------------------------------------------
                --}}

                <a
                    href="{{ route('properties.show', $property->id) }}"
                    class="text-decoration-none text-dark"
                >

                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden hover-card">

                        <img
                            src="{{ $property->image }}"
                            class="card-img-top"
                            style="height:260px;object-fit:cover;"
                            alt="{{ $property->title }}"
                        >

                        <div class="card-body p-4">

                            @if($loop->iteration == 1)
                            <span class="badge bg-warning text-dark mb-3">
                                🥇 Pilihan Terbaik
                            </span>
                            @elseif($loop->iteration == 2)
                            <span class="badge bg-secondary mb-3">
                                🥈 Pilihan Kedua
                            </span>
                            @else
                            <span class="badge bg-dark mb-3">
                                🥉 Pilihan Ketiga
                            </span>
                            @endif

                            <h4 class="fw-bold">
                                {{ $property->title }}
                            </h4>

                            <p class="text-muted">
                                <i class="bi bi-geo-alt-fill"></i>
                                {{ $property->location }}
                            </p>

                            <div class="d-flex justify-content-between mb-3">
                                <span>🛏 {{ $property->bedroom }} KT</span>
                                <span>🚿 {{ $property->bathroom }} KM</span>
                                <span>📐 {{ $property->building_area }} m²</span>
                            </div>

                            <h3 class="fw-bold text-danger">
                                Rp{{ number_format($property->price,0,',','.') }}
                            </h3>

                            <hr>

                            <small class="text-muted">
                                Tingkat Rekomendasi
                            </small>

                            <div class="fs-4 mt-2">
                                @for($i = 1; $i <= $property->rating; $i++)
                                    ⭐
                                @endfor
                            </div>

                            <div class="fw-semibold text-success mt-2">
                                @if($property->rating == 5)
                                    Sangat Direkomendasikan
                                @elseif($property->rating == 4)
                                    Direkomendasikan
                                @elseif($property->rating == 3)
                                    Cukup Direkomendasikan
                                @elseif($property->rating == 2)
                                    Perlu Dipertimbangkan
                                @else
                                    Kurang Direkomendasikan
                                @endif
                            </div>

                        </div>

                    </div>

                </a>

            </div>

            @endforeach

        </div>

        {{-- TABEL REKOMENDASI --}}
        <div class="card border-0 shadow rounded-4">

            <div class="card-header bg-danger text-white py-3">

                <h4 class="mb-0">
                    Daftar Properti Berdasarkan Tingkat Rekomendasi
                </h4>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Properti</th>
                                <th>Lokasi</th>
                                <th>Harga</th>
                                <th>Luas Bangunan</th>
                                <th>Rekomendasi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($properties as $property)

                            <tr style="cursor:pointer;" onclick="window.location='{{ route('properties.show', $property->id) }}'">

                                <td>
                                    <strong>
                                        {{ $loop->iteration }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $property->title }}
                                </td>

                                <td>
                                    {{ $property->location }}
                                </td>

                                <td>
                                    Rp{{ number_format($property->price,0,',','.') }}
                                </td>

                                <td>
                                    {{ $property->building_area }} m²
                                </td>

                                <td width="220">

                                    <div class="progress" style="height:28px;">

                                        <div
                                            class="progress-bar bg-success"
                                            role="progressbar"
                                            style="width: {{ $property->percentage }}%;"
                                        >
                                            {{ $property->percentage }}%
                                        </div>

                                    </div>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        @else

        <div class="alert alert-warning text-center">

            <h5>
                Tidak Ada Properti yang Sesuai
            </h5>

            <p class="mb-0">
                Berdasarkan kemampuan finansial yang Anda input,
                belum ditemukan properti yang sesuai.
                Coba tingkatkan tenor atau sesuaikan kembali
                data finansial Anda.
            </p>

        </div>

        @endif

        {{-- PENJELASAN --}}
        <div class="card border-0 shadow-sm mt-5 rounded-4">

            <div class="card-body p-4">

                <h4 class="fw-bold mb-3">
                    Bagaimana Rekomendasi Dihasilkan?
                </h4>

                <p class="text-muted mb-0">
                    Sistem terlebih dahulu menganalisis kemampuan
                    finansial pengguna berdasarkan penghasilan,
                    pengeluaran bulanan, dan tenor kredit yang dipilih.
                    Selanjutnya sistem mengevaluasi setiap properti
                    berdasarkan harga, luas bangunan, jumlah kamar tidur,
                    jumlah kamar mandi, kondisi bangunan, dan kualitas properti.
                    Hasil evaluasi tersebut digunakan untuk menentukan
                    tingkat kecocokan sehingga pengguna dapat menemukan
                    properti yang paling sesuai dengan kebutuhan dan
                    kemampuan finansialnya.
                </p>

            </div>

        </div>

    </div>

</section>

@endsection

@push('styles')
<style>
    .hover-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }
    .table tbody tr:hover {
        background-color: rgba(220, 53, 69, 0.05);
    }
</style>
@endpush