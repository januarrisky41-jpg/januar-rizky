<h1>Tambah Properti</h1>

<form action="{{ route('properties.store') }}" method="POST">
    @csrf

    <input type="text" name="title" placeholder="Nama Properti">
    <br><br>

    <input type="text" name="location" placeholder="Lokasi">
    <br><br>

    <input type="number" name="price" placeholder="Harga">
    <br><br>

    <input type="number" name="bedroom" placeholder="Kamar Tidur">
    <br><br>

    <input type="number" name="bathroom" placeholder="Kamar Mandi">
    <br><br>

    <textarea name="description" placeholder="Deskripsi"></textarea>
    <br><br>

    <button type="submit">Simpan</button>
</form>