<?php

class ProductWholesaleController extends Controller
{
    protected $variantWholesale;

    public function __construct()
    {
        $this->variantWholesale = $this->model('VariantWholesale');
    }

public function index()
{
    $model = new VariantWholesale();

    // Debug sementara
    $data = $model->getAllVariantsWithWholesale(); 

    // die; sudah ada di model
    $this->view('variant_wholesale/index', [
        'wholesales' => $data
    ]);
}


    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/wholesale-prices');
            exit;
        }

        $data = [
            'variant_id'      => $_POST['variant_id'] ?? null,
            'min_unit'        => $_POST['min_unit'] ?? null,
            'wholesale_price' => $_POST['wholesale_price'] ?? null,
        ];

        if (in_array(null, $data, true)) {
            $_SESSION['error'] = 'Data tidak lengkap';
            header('Location: /admin/wholesale-prices');
            exit;
        }

        $wholesaleModel = new VariantWholesale();
        $wholesaleModel->create($data);

        $_SESSION['success'] = 'Harga grosir berhasil disimpan';
        header('Location: /admin/variant-wholesale');
        exit;
    }

    public function delete($variantId)
    {
        $model = new VariantWholesale();
        $deleted = $model->deleteByVariant($variantId); // Hapus harga grosir berdasarkan variant

        if ($deleted) {
            $_SESSION['success'] = 'Harga grosir berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus harga grosir';
        }

        header('Location: /admin/variant-wholesale'); // redirect ke daftar
        exit;
    }

public function update()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /admin/variant-wholesale');
        exit;
    }

    $id = $_POST['id'] ?? null;

    if (!$id || $id === 'undefined') {
        $_SESSION['error'] = 'ID wholesale tidak valid';
        header('Location: /admin/variant-wholesale');
        exit;
    }

    $data = [
        'min_unit' => $_POST['min_unit'],
        'wholesale_price' => $_POST['wholesale_price'],
        'status' => $_POST['status']
    ];

    $this->variantWholesale->update($id, $data);

    $_SESSION['success'] = 'Harga grosir berhasil diupdate';
    header('Location: /admin/variant-wholesale');
    exit;
}






}
