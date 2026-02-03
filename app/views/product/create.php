<h1>Tambah Produk</h1>
<form action="/admin/products/store" method="POST">
    <label>Nama Produk</label><br>
    <input type="text" name="name" required><br>
    <label>Deskripsi</label><br>
    <textarea name="description" required></textarea><br>
    <label>Harga</label><br>
    <input type="number" name="price" required><br>
    <label>Status</label><br>
    <select name="status">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select><br>
    <button type="submit">Simpan</button>
</form>
