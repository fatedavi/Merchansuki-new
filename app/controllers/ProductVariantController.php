<?php

class ProductVariantController extends Controller
{
    /* =====================
       STORE (CREATE)
    ===================== */
    public function store()
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request');
            }

            $variantModel = new ProductVariant();
            $imageName = null;

            // ✅ UPLOAD IMAGE
            if (!empty($_FILES['image']['name'])) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('variant_') . '.' . $ext;

                $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/images_save/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath . $imageName)) {
                    throw new Exception('Gagal upload gambar');
                }
            }

            $variantModel->create([
                'product_id'   => $_POST['product_id'],
                'variant_name' => $_POST['variant_name'],
                'price'        => $_POST['price'],
                'stock'        => $_POST['stock'],
                'status'       => $_POST['status'],
                'image'        => $imageName
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Variant berhasil ditambahkan'
            ]);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        exit;
    }

    /* =====================
       UPDATE (AJAX)
    ===================== */
    public function update($id)
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request');
            }

            $variantModel = new ProductVariant();
            $variant = $variantModel->find($id);

            if (!$variant) {
                throw new Exception('Variant tidak ditemukan');
            }

            $imageName = $variant['image'];

            // ✅ UPDATE IMAGE JIKA ADA
            if (!empty($_FILES['image']['name'])) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('variant_') . '.' . $ext;

                $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/images_save/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath . $imageName);
            }

            $variantModel->update($id, [
                'variant_name' => $_POST['variant_name'],
                'price'        => $_POST['price'],
                'stock'        => $_POST['stock'],
                'status'       => $_POST['status'],
                'image'        => $imageName
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Variant berhasil diperbarui'
            ]);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        exit;
    }

    /* =====================
       DELETE
    ===================== */
    public function delete($id)
    {
        header('Content-Type: application/json; charset=utf-8');

        $variantModel = new ProductVariant();
        $variant = $variantModel->find($id);

        if (!$variant) {
            echo json_encode([
                'success' => false,
                'message' => 'Variant tidak ditemukan'
            ]);
            exit;
        }

        $variantModel->delete($id);

        echo json_encode([
            'success' => true,
            'message' => 'Variant berhasil dihapus',
            'product_id' => $variant['product_id']
        ]);

        exit;
    }
}
