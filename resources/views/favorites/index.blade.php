{{-- resources/views/favorites/index.blade.php --}}

@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">

        <h1 class="fw-bold">Properti Favorit Saya</h1>
        <p class="text-muted">Daftar properti yang Anda simpan.</p>

    </div>

    <div class="row">

        @forelse($favorites as $property)

        <div class="col-lg-4 mb-4" id="favorite-card-{{ $property->id }}">

            <div class="card shadow border-0 h-100">

                <div class="position-relative">

                    <img src="{{ $property->image }}" 
                         class="card-img-top" 
                         style="height:250px; object-fit:cover;" 
                         alt="{{ $property->title }}">

                    <span class="badge bg-danger position-absolute top-0 start-0 m-2" 
                          style="font-size: 14px; padding: 8px 15px; border-radius: 30px;">
                        ❤️ Favorit
                    </span>

                    <button 
                        onclick="removeFavorite({{ $property->id }})"
                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
                        style="border-radius: 50%; width: 36px; height: 36px; padding: 0; font-size: 14px;"
                    >
                        <i class="bi bi-x-lg"></i>
                    </button>

                </div>

                <div class="card-body">

                    <h5 class="card-title">{{ $property->title }}</h5>

                    <p class="card-text text-muted">
                        <i class="bi bi-geo-alt-fill"></i> {{ $property->location }}
                    </p>

                    <h5 class="text-danger fw-bold">
                        Rp{{ number_format($property->price, 0, ',', '.') }}
                    </h5>

                    <div class="d-flex justify-content-between mt-3 text-muted small">
                        <span>🛏 {{ $property->bedroom }} KT</span>
                        <span>🚿 {{ $property->bathroom }} KM</span>
                        <span>📐 {{ $property->building_area }} m²</span>
                    </div>

                </div>

                <div class="card-footer bg-white border-0">

                    <a href="/properties/{{ $property->id }}" class="btn btn-primary w-100">
                        Lihat Detail
                    </a>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">

            <div class="alert alert-info text-center py-5">

                <h4><i class="bi bi-heart"></i> Belum Ada Properti Favorit</h4>

                <p class="mb-0">
                    Anda belum menyimpan properti apapun.
                    <a href="/properties">Lihat katalog properti</a> dan tambahkan ke favorit.
                </p>

            </div>

        </div>

        @endforelse

    </div>

</div>

@endsection

@push('scripts')
<script>
function removeFavorite(propertyId) {
    if (!confirm('Apakah Anda yakin ingin menghapus properti ini dari favorit?')) {
        return;
    }

    fetch(`/favorites/${propertyId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const card = document.getElementById('favorite-card-' + propertyId);
            if (card) {
                card.style.transition = 'opacity 0.3s';
                card.style.opacity = '0';
                setTimeout(() => {
                    card.remove();
                    const remaining = document.querySelectorAll('[id^="favorite-card-"]');
                    if (remaining.length === 0) {
                        location.reload();
                    }
                }, 300);
            }
        } else {
            alert('Gagal menghapus: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}
</script>
@endpush