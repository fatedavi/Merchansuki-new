<?php   
class CategoryController extends Controller {
public function store()
{
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'success' => false,
            'message' => 'Method not allowed'
        ]);
        exit;
    }

    $name = trim($_POST['name'] ?? '');

    if ($name === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Nama category wajib diisi'
        ]);
        exit;
    }

    try {
        $categoryModel = $this->model('Category');
        $categoryModel->create([
            'name' => $name
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'Category berhasil ditambahkan'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }

    exit; // 🔥 WAJIB
}
public function all() {
     header('Content-Type: application/json'); // HARUS

    try {
        $categoryModel = $this->model('Category');
        $categories = $categoryModel->getAll(); // harus return array

        echo json_encode($categories); // HARUS JSON
    } catch (Exception $e) {
        echo json_encode([]); // fallback kosong
    }
    exit;
}

public function delete($id)
{
    // Header JSON wajib
    header('Content-Type: application/json');

    try {
        $categoryModel = $this->model('Category');

        // Validasi ID
        if (!$id || !is_numeric($id)) {
            echo json_encode([
                'success' => false,
                'message' => 'ID kategori tidak valid'
            ]);
            exit;
        }

        // Cek apakah kategori punya produk
        if ($categoryModel->hasProducts($id)) {
            echo json_encode([
                'success' => false,
                'message' => 'Kategori masih digunakan oleh produk'
            ]);
            exit;
        }

        // Hapus kategori
        $deleted = $categoryModel->delete($id);

        if ($deleted) {
            echo json_encode([
                'success' => true,
                'message' => 'Kategori berhasil dihapus'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal menghapus kategori'
            ]);
        }

    } catch (Throwable $e) { // tangkap semua error & exception
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }

    exit; // 🔥 Penting, jangan ada output lain
}




}



