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
            </p>

        </div>

        <div class="afford-card">

            <form
                action="/affordability/calculate"
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

                    {{-- TENOR --}}

                    <div class="col-md-12">

                        <label class="form-label">
                            Jangka Waktu
                        </label>

                        <select
                            name="tenor"
                            class="form-select"
                        >

                            <option value="5">
                                5 Tahun
                            </option>

                            <option value="10">
                                10 Tahun
                            </option>

                            <option value="15">
                                15 Tahun
                            </option>

                            <option value="20">
                                20 Tahun
                            </option>

                        </select>

                    </div>

                    {{-- BUTTON --}}

                    <div class="col-12 text-center">

                        <button
                        type="submit"
                        class="btn btn-red"
                     style="background:#dc2626; color:white; border:none;"
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

    padding: 100px 0;

    background: #f5f7fb;

    min-height: 100vh;
}

.afford-card {

    background: white;

    padding: 40px;

    border-radius: 25px;

    box-shadow: 0 5px 20px rgba(0,0,0,0.08);

    max-width: 900px;

    margin: auto;
}

.form-control,
.form-select {

    height: 55px;

    border-radius: 12px;
}

</style>

@endsection