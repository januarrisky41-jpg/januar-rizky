```php
@extends('layouts.app')

@section('content')

<section class="py-5">

    <div class="container">

        <div class="row g-5">

            <div class="col-lg-7">

                <img
                    src="{{ $property->image }}"
                    class="img-fluid rounded-4 shadow-sm w-100"
                >

            </div>

            <div class="col-lg-5">

                <div class="property-detail-card">

                    <div class="badge-property">

                        {{ $property->property_type }}

                    </div>

                    <h1 class="property-title">

                        {{ $property->title }}

                    </h1>

                    <p class="property-location">

                        📍 {{ $property->location }}

                    </p>

                    <h2 class="property-price">

                        Rp {{ number_format($property->price,0,',','.') }}

                    </h2>

                    <div class="property-features">

                        <span>
                            🛏 {{ $property->bedroom }} KT
                        </span>

                        <span>
                            🚿 {{ $property->bathroom }} KM
                        </span>

                        <span>
                            📐 {{ $property->building_area }} m²
                        </span>

                    </div>

                    <hr>

                    <p class="property-description">

                        {{ $property->description }}

                    </p>

                    <a
                        href="/simulation/{{ $property->id }}"
                        class="btn btn-danger"
                        style="background:#dc2626;"
                    >
                        Simulasi KPR
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

<style>

.property-detail-card {

    background: white;

    padding: 35px;

    border-radius: 24px;

    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.badge-property {

    display: inline-block;

    background: #eaf2ff;

    color: #0d6efd;

    padding: 8px 15px;

    border-radius: 30px;

    font-size: 14px;

    font-weight: 700;

    margin-bottom: 20px;
}

.property-title {

    font-size: 42px;

    font-weight: 800;

    margin-bottom: 15px;
}

.property-location {

    color: #666;

    margin-bottom: 20px;
}

.property-price {

    color: #dc2626;

    font-size: 38px;

    font-weight: 800;

    margin-bottom: 25px;
}

.property-features {

    display: flex;

    gap: 20px;

    flex-wrap: wrap;

    margin-bottom: 20px;

    font-weight: 600;
}

.property-description {

    color: #666;

    line-height: 1.8;
}

</style>

@endsection
```
