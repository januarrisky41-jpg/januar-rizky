@extends('layouts.app')

@section('content')

<section class="afford-section">

    <div class="container">

        <div class="text-center mb-5">

            <h1 class="fw-bold">
                Hitung Harga Properti Maksimal
            </h1>

            <p class="text-muted">
                Ketahui estimasi kemampuan membeli rumah berdasarkan kondisi finansial Anda.
                <br>Cukup masukkan penghasilan, pengeluaran, dan jangka waktu.
            </p>

            <div class="afford-features">
                <span><i class="bi bi-check-circle-fill text-success"></i> Hasil instan & akurat</span>
                <span><i class="bi bi-check-circle-fill text-success"></i> Perhitungan sederhana</span>
                <span><i class="bi bi-check-circle-fill text-success"></i> Rekomendasi properti</span>
            </div>

        </div>

        <div class="afford-card">

            <form
                action="{{ route('affordability.calculate') }}"
                method="POST"
            >

                @csrf

                <div class="row g-4">

                    {{-- PENGHASILAN --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Penghasilan per Bulan
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input
                                type="text"
                                name="income"
                                class="form-control rupiah"
                                placeholder="10.000.000"
                                required
                            >

                        </div>

                    </div>

                    {{-- PENGELUARAN --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Pengeluaran per Bulan
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input
                                type="text"
                                name="expense"
                                class="form-control rupiah"
                                placeholder="3.000.000"
                                required
                            >

                        </div>

                    </div>

                    {{-- JANGKA WAKTU --}}
                    <div class="col-md-12">

                        <label class="form-label">
                            Jangka Waktu
                        </label>

                        <select
                            name="tenor"
                            class="form-select"
                        >

                            <option value="5">5 Tahun</option>
                            <option value="10" selected>10 Tahun</option>
                            <option value="15">15 Tahun</option>
                            <option value="20">20 Tahun</option>
                            <option value="25">25 Tahun</option>
                            <option value="30">30 Tahun</option>

                        </select>

                    </div>

                    {{-- BUTTON --}}
                    <div class="col-12 text-center">

                        <button
                            type="submit"
                            class="btn btn-red"
                        >
                            Hitung Sekarang
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</section>

<script>

document.querySelectorAll('.rupiah').forEach(input => {

    input.addEventListener('input', function(e) {

        let value = this.value.replace(/\D/g, '');

        this.value = new Intl.NumberFormat('id-ID').format(value);

    });

});

</script>

<style>

.afford-section {

    padding: 80px 0;

    background: #f5f7fb;

    min-height: 100vh;
}

.afford-features {
    display: flex;
    justify-content: center;
    gap: 28px;
    margin-top: 16px;
    flex-wrap: wrap;
}

.afford-features span {
    font-size: 14px;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 6px;
}

.afford-features i {
    font-size: 16px;
}

.afford-card {

    background: white;

    padding: 40px;

    border-radius: 25px;

    box-shadow: 0 5px 20px rgba(0,0,0,0.08);

    max-width: 900px;

    margin: auto;
}

.form-label {
    font-weight: 600;
    margin-bottom: 8px;
    color: #1f2937;
}

.form-control,
.form-select {

    height: 55px;

    border-radius: 12px;

    border: 1.5px solid #e5e7eb;

    background: #fafafa;

    transition: all 0.3s ease;
}

.form-control:focus,
.form-select:focus {
    border-color: #dc2626;
    box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.10);
    background: #fff;
}

.input-group-text {
    border-radius: 12px 0 0 12px;
    border: 1.5px solid #e5e7eb;
    background: #f8fafc;
    font-weight: 600;
    color: #4b5563;
}

.form-control {
    border-radius: 0 12px 12px 0;
}

.btn-red {
    background: #dc2626;
    color: white;
    border: none;
    padding: 14px 50px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    transition: all 0.3s ease;
}

.btn-red:hover {
    background: #b91c1c;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(220, 38, 38, 0.30);
    color: white;
}

@media (max-width: 768px) {

    .afford-section {
        padding: 50px 0;
    }

    .afford-card {
        padding: 24px 20px;
    }

    .btn-red {
        width: 100%;
        padding: 14px;
    }

    .afford-features {
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .afford-features span {
        font-size: 13px;
    }
}

</style>

@endsection