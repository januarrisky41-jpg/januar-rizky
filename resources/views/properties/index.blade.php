@extends('layouts.app')

@section('content')

<section class="property-section">

    <div class="container">

        <div class="section-header">

            <h2>
                <span style="color:#000000; font-weight:bold;">
                Katalog Properti
            </h2>

            <p>
                <span style="color:#000000; font-weight:">
                Temukan berbagai pilihan hunian terbaik sesuai kebutuhan dan kemampuan finansial Anda.
            </p>

        </div>

        <div class="row g-4">

            @foreach($properties as $property)

            <div class="col-lg-2-4 col-md-4 col-sm-6">

                <div class="property-card">

                    {{-- IMAGE --}}

                    <div class="property-image">

                        <a href="/properties/{{ $property->id }}">

                            <img
                                src="{{ $property->image }}"
                                alt="{{ $property->title }}"
                            >

                        </a>

                        {{-- FAVORITE BUTTON TOGGLE --}}

                        <button
                            type="button"
                            class="favorite-btn {{ $property->is_favorited ? 'active' : '' }}"
                            onclick="toggleFavorite({{ $property->id }}, this)"
                            id="favorite-btn-{{ $property->id }}"
                        >

                            <i class="bi {{ $property->is_favorited ? 'bi-heart-fill' : 'bi-heart' }}" 
                               id="heart-icon-{{ $property->id }}">
                            </i>

                        </button>

                        <span class="property-badge">

                            {{ $property->property_type ?? 'Hunian' }}

                        </span>

                    </div>

                    {{-- BODY --}}

                    <div class="property-body">

                        <h5 class="property-title">

                            {{ $property->title }}

                        </h5>

                        <p class="property-location">

                            📍 {{ $property->location }}

                        </p>

                        <div class="property-price">

                            Rp{{ number_format($property->price,0,',','.') }}

                        </div>

                        <div class="property-feature">

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

                        <div class="property-action">

                            <a
                                href="/properties/{{ $property->id }}"
                                class="btn-detail"
                            >

                                Lihat Detail

                            </a>

                        </div>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

        <div class="pagination-wrapper">

            {{ $properties->links() }}

        </div>

    </div>

</section>

<style>

body{
    background:#f8fafc;
}

.property-section{
    padding:80px 0;
}

.section-header{
    text-align:center;
    margin-bottom:50px;
}

.section-header h2{
    font-size:42px;
    font-weight:800;
    color:#991b1b;
}

.section-header p{
    color:#7f1d1d;
    max-width:700px;
    margin:auto;
}

/* 5 KOLOM */

.col-lg-2-4{
    width:20%;
}

@media(max-width:992px){

    .col-lg-2-4{
        width:33.333%;
    }
}

@media(max-width:768px){

    .col-lg-2-4{
        width:50%;
    }
}

@media(max-width:576px){

    .col-lg-2-4{
        width:100%;
    }
}

/* CARD */

.property-card{

    background:white;

    border-radius:20px;

    overflow:hidden;

    box-shadow:0 5px 20px rgba(220,38,38,.12);

    transition:.3s;

    height:100%;

    border:1px solid #ffffff;
}

.property-card:hover{

    transform:translateY(-8px);

    box-shadow:0 15px 40px rgba(220,38,38,.20);
}

/* IMAGE */

.property-image{
    position:relative;
}

.property-image img{

    width:100%;

    height:190px;

    object-fit:cover;
}

/* FAVORITE */

.favorite-btn{

    position:absolute;

    top:12px;

    right:12px;

    width:42px;

    height:42px;

    border:none;

    border-radius:50%;

    background:white;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:22px;

    cursor:pointer;

    box-shadow:0 3px 12px rgba(220,38,38,.15);

    transition:all 0.3s ease;

    z-index:10;

    padding:0;
}

.favorite-btn:hover{

    transform:scale(1.15);
    
    box-shadow:0 4px 20px rgba(220,38,38,.30);
}

.favorite-btn i{

    color:#d1d5db;
    
    transition:all 0.3s ease;
}

.favorite-btn.active i{

    color:#dc2626;
}

.favorite-btn.active i.bi-heart-fill {
    animation: heartPulse 0.4s ease;
}

/* Animasi Pulse */
@keyframes heartPulse {
    0% { transform: scale(1); }
    30% { transform: scale(1.5); }
    60% { transform: scale(0.9); }
    100% { transform: scale(1); }
}

/* BADGE */

.property-badge{

    position:absolute;

    top:12px;

    left:12px;

    background:#dc2626;

    color:white;

    padding:6px 12px;

    border-radius:30px;

    font-size:11px;

    font-weight:700;
}

/* BODY */

.property-body{
    padding:18px;
}

.property-title{

    font-size:18px;

    font-weight:700;

    color:#991b1b;

    margin-bottom:8px;
}

.property-location{

    color:#7f1d1d;

    font-size:14px;

    margin-bottom:12px;
}

.property-price{

    color:#dc2626;

    font-size:22px;

    font-weight:800;

    margin-bottom:15px;
}

/* FEATURE */

.property-feature{

    display:flex;

    flex-direction:column;

    gap:6px;

    color:#991b1b;

    font-size:13px;

    margin-bottom:18px;
}

/* BUTTON */

.btn-detail{

    width:100%;

    display:block;

    text-align:center;

    background:#dc2626;

    color:white;

    padding:10px;

    border-radius:10px;

    text-decoration:none;

    font-weight:600;

    transition:.3s;
}

.btn-detail:hover{

    background:#991b1b;

    color:white;
}

/* PAGINATION */

.pagination-wrapper{

    display:flex;

    justify-content:center;

    margin-top:60px;
}

.pagination svg{
    width:18px;
}

/* PAGINATION BTN */

.page-link{

    color:#dc2626 !important;

    border-color:#fecaca !important;
}

.page-item.active .page-link{

    background:#dc2626 !important;

    border-color:#fecaca !important;

    color:white !important;
}

.page-link:hover{

    color:#991b1b !important;

    background:#fee2e2 !important;
}

</style>

@endsection

@push('scripts')
<script>
function toggleFavorite(propertyId, button) {
    const heartIcon = document.getElementById('heart-icon-' + propertyId);
    const isCurrentlyActive = button.classList.contains('active');
    
    // Tampilkan loading
    if (heartIcon) {
        heartIcon.className = 'bi bi-hourglass-split text-warning';
    }
    
    fetch(`/favorites/toggle/${propertyId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.isFavorite) {
                // Tambah favorite
                button.classList.add('active');
                if (heartIcon) {
                    heartIcon.className = 'bi bi-heart-fill';
                    // Trigger animasi pulse
                    heartIcon.style.animation = 'none';
                    setTimeout(() => {
                        heartIcon.style.animation = 'heartPulse 0.4s ease';
                    }, 10);
                }
            } else {
                // Hapus favorite
                button.classList.remove('active');
                if (heartIcon) {
                    heartIcon.className = 'bi bi-heart';
                }
            }
        } else {
            alert('Gagal: ' + data.message);
            // Kembalikan ke state sebelumnya
            if (isCurrentlyActive) {
                button.classList.add('active');
                if (heartIcon) {
                    heartIcon.className = 'bi bi-heart-fill';
                }
            } else {
                button.classList.remove('active');
                if (heartIcon) {
                    heartIcon.className = 'bi bi-heart';
                }
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
        // Kembalikan ke state sebelumnya
        if (isCurrentlyActive) {
            button.classList.add('active');
            if (heartIcon) {
                heartIcon.className = 'bi bi-heart-fill';
            }
        } else {
            button.classList.remove('active');
            if (heartIcon) {
                heartIcon.className = 'bi bi-heart';
            }
        }
    });
}
</script>
@endpush