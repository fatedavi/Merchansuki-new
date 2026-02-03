<h1>Edit Produk</h1>
<form action="/admin/products/update/<?= $product['id'] ?>" method="POST">
    <label>Nama Produk</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br>
    <label>Deskripsi</label><br>
    <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea><br>
    <label>Harga</label><br>
    <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" required><br>
    <label>Status</label><br>
    <select name="status">
        <option value="active" <?= $product['status']==='active'?'selected':'' ?>>Active</option>
        <option value="inactive" <?= $product['status']==='inactive'?'selected':'' ?>>Inactive</option>
    </select><br>
    <button type="submit">Update</button>
</form>
