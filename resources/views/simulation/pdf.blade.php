<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<title>Laporan Simulasi KPR</title>

<style>

body{
    font-family: DejaVu Sans, sans-serif;
    padding:20px;
}

h1{
    text-align:center;
}

.card{
    border:1px solid #ddd;
    padding:20px;
    margin-bottom:20px;
}

.item{
    margin-bottom:10px;
}

.label{
    font-weight:bold;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

table th,
table td{
    border:1px solid #ddd;
    padding:8px;
}

table th{
    background:#f3f3f3;
}

</style>

</head>

<body>

<h1>
    LAPORAN SIMULASI KPR
</h1>

<div class="card">

    <div class="item">
        <span class="label">Nama :</span>
        {{ $simulation->name }}
    </div>

    <div class="item">
        <span class="label">Penghasilan :</span>
        Rp {{ number_format($simulation->income,0,',','.') }}
    </div>

    <div class="item">
        <span class="label">Harga Rumah :</span>
        Rp {{ number_format($simulation->house_price,0,',','.') }}
    </div>

    <div class="item">
        <span class="label">DP :</span>
        Rp {{ number_format($simulation->down_payment,0,',','.') }}
    </div>

    <div class="item">
        <span class="label">Tenor :</span>
        {{ $simulation->tenor }} Tahun
    </div>

    <div class="item">
        <span class="label">Bunga :</span>
        {{ $simulation->interest }} %
    </div>

    <div class="item">
        <span class="label">Cicilan Bulanan :</span>
        Rp {{ number_format($simulation->monthly_installment,0,',','.') }}
    </div>

    <div class="item">
        <span class="label">Status :</span>
        {{ $simulation->status }}
    </div>

</div>

<h2>
    Rekomendasi Properti
</h2>

@if($recommendedProperties->count())

<table>

    <thead>

        <tr>

            <th>Nama Properti</th>
            <th>Kota</th>
            <th>Harga</th>

        </tr>

    </thead>

    <tbody>

        @foreach($recommendedProperties as $property)

        <tr>

            <td>
                {{ $property->title }}
            </td>

            <td>
                {{ $property->location }}
            </td>

            <td>
                Rp {{ number_format($property->price,0,',','.') }}
            </td>

        </tr>

        @endforeach

    </tbody>

</table>

@else

<p>
    Tidak ada properti yang sesuai dengan kemampuan finansial.
</p>

@endif

</body>
</html>