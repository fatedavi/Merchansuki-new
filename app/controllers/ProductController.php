<?php
class ProductController extends Controller {

public function index() {
    $productModel = $this->model('Product');
    $categoryModel = $this->model('Category');

    // DATA LAMA (JANGAN DIUBAH)
    $products = $productModel->getAllWithVariants();

    // DATA TAMBAHAN
    $productsWithCategory = $productModel->getAllWithCategory();
    $categories = $categoryModel->getAll();

    // 🔥 INJECT category_name ke $products
    $categoryMap = [];
    foreach ($productsWithCategory as $pwc) {
        $categoryMap[$pwc['id']] = $pwc['category_name'];
    }

    foreach ($products as &$product) {
        $product['category_name'] = $categoryMap[$product['id']] ?? '-';
    }
    unset($product); // safety reference

    $this->view('product.index', [
        'products' => $products,
        'categories' => $categories
    ]);
}

public function detail($id)
{
    // Validasi ID
    if (!$id || !is_numeric($id)) {
        http_response_code(404);
        $this->view('errors.404');
        return;
    }

    // Load model
    $productModel = $this->model('Product');

    // Ambil detail lengkap (product + category + variants)
    $product = $productModel->getDetail($id);

    if (!$product) {
        http_response_code(404);
        $this->view('errors.404');
        return;
    }

    // Kirim ke view
    $this->view('product.detail', [
        'product' => $product
    ]);
}



    public function create() {
        $this->view('product.create');
    }

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

    // VALIDASI MINIMAL
    if (empty($_POST['name']) || empty($_POST['category_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Nama produk & kategori wajib diisi'
        ]);
        exit;
    }

    $data = [
        'category_id' => (int) $_POST['category_id'],
        'name'        => trim($_POST['name']),
        'description' => trim($_POST['description'] ?? ''),
        'highlight'   => isset($_POST['highlight']) ? 1 : 0,
        'status'      => $_POST['status'] ?? 'active'
    ];

    try {
        $productModel = $this->model('Product');

        // SIMPAN PRODUCT
        $productId = $productModel->create($data);

        echo json_encode([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan',
            'product_id' => $productId
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }

    exit;
}


    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }

        header('Content-Type: application/json');

        $data = [
            'category_id' => $_POST['category_id'] ?? null,
            'name'        => trim($_POST['name'] ?? ''),
            'slug'        => trim($_POST['slug'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'price'       => (float) ($_POST['price'] ?? 0),
            'stock'       => (int) ($_POST['stock'] ?? 0),
            'rating'      => (float) ($_POST['rating'] ?? 0),
            'highlight'   => isset($_POST['highlight']) ? 1 : 0,
            'status'      => $_POST['status'] ?? 'active',
        ];

        try {
            $productModel = $this->model('Product');
            $productModel->update($id, $data);
            
            echo json_encode(['success' => true, 'message' => 'Produk berhasil diupdate']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
    public function delete($id) {
        $productModel = $this->model('Product');
        $productModel->delete($id);
        header('Location: /admin/products');
        exit;
    }
public function variants($productId)
{
    header('Content-Type: application/json');

    $productModel = $this->model('Product');
    echo json_encode(
        $productModel->getVariants($productId)
    );
}
public function deleteVariant($id)
{
    header('Content-Type: application/json');

    try {
        $variantModel = $this->model('ProductVariant');
        $variantModel->delete($id);

        echo json_encode([
            'success' => true,
            'message' => 'Variant berhasil dihapus'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    exit;
}
public function catalog()
{
    $productModel = $this->model('Product');
    $categoryModel = $this->model('Category');

    // Get filters from URL parameters
    $categoryId = isset($_GET['category']) ? (int) $_GET['category'] : null;
    $priceMin = isset($_GET['price_min']) ? (int) $_GET['price_min'] : 0;
    $priceMax = isset($_GET['price_max']) ? (int) $_GET['price_max'] : 999999999;
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

    // Get all categories for filter dropdown
    $categories = $categoryModel->getAll();

    // Get filtered products
    $products = $productModel->getFilteredProducts([
        'category_id' => $categoryId,
        'price_min' => $priceMin,
        'price_max' => $priceMax,
        'search' => $search,
        'sort' => $sort
    ]);

    // Get price range for filter hints
    $priceRange = $productModel->getPriceRange();

    $this->view('catalog.index', [
        'products' => $products,
        'categories' => $categories,
        'priceRange' => $priceRange,
        'filters' => [
            'category' => $categoryId,
            'price_min' => $priceMin,
            'price_max' => $priceMax,
            'search' => $search,
            'sort' => $sort
        ]
    ]);
}
public function ajaxGetFiltered()
{
    try {
        $productModel = $this->model('Product');

        // Get filters from URL parameters
        $categoryId = isset($_GET['category']) && !empty($_GET['category']) ? (int) $_GET['category'] : null;
        $priceMin = isset($_GET['price_min']) && !empty($_GET['price_min']) ? (int) $_GET['price_min'] : 0;
        $priceMax = isset($_GET['price_max']) && !empty($_GET['price_max']) ? (int) $_GET['price_max'] : 999999999;
        $search = isset($_GET['search']) && !empty($_GET['search']) ? trim($_GET['search']) : '';
        $sort = isset($_GET['sort']) && !empty($_GET['sort']) ? $_GET['sort'] : 'newest';

        // Debug log ke file
        $debug = [
            'category' => $categoryId,
            'price_min' => $priceMin,
            'price_max' => $priceMax,
            'search' => $search,
            'sort' => $sort,
            'time' => date('Y-m-d H:i:s')
        ];
        file_put_contents(__DIR__.'/../../debug_filter.log', json_encode($debug)."\n", FILE_APPEND);
        header('X-Debug-Filter: '.json_encode($debug));

        // Get filtered products
        $products = $productModel->getFilteredProducts([
            'category_id' => $categoryId,
            'price_min' => $priceMin,
            'price_max' => $priceMax,
            'search' => $search,
            'sort' => $sort
        ]);

        // Generate HTML for products
        $html = '';

        if (empty($products)) {
            $html = '
                <div class="col-span-full bg-white border rounded-lg p-12 text-center">
                    <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Produk tidak ditemukan</p>
                    <button onclick="resetFilters()" class="mt-4 inline-block bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">
                        Reset Filter
                    </button>
                </div>
            ';
        } else {
            foreach ($products as $product) {
                $totalStock = 0;
                foreach ($product['variants'] as $v) {
                    $totalStock += $v['stock'];
                }
                $inStock = $totalStock > 0;

                $image = !empty($product['image']) 
                    ? '/assets/images/images_save/' . $product['image']
                    : '/assets/images/no-image.png';

                $priceHTML = '';
                if (!empty($product['variants'])) {
                    if ($product['min_price'] != $product['max_price']) {
                        $priceHTML = 'Rp ' . number_format($product['min_price'], 0, ',', '.') . ' - Rp ' . number_format($product['max_price'], 0, ',', '.');
                    } else {
                        $priceHTML = 'Rp ' . number_format($product['min_price'], 0, ',', '.');
                    }
                } else {
                    $priceHTML = '<span class="text-gray-400">Harga tidak tersedia</span>';
                }

                $ratingHTML = '';
                if (!empty($product['rating']) && $product['rating'] > 0) {
                    $ratingHTML = '
                        <div class="absolute top-2 right-2 bg-orange-500 text-white px-2 py-1 rounded text-sm font-bold">
                            <i class="fas fa-star"></i> ' . number_format($product['rating'], 1) . '
                        </div>
                    ';
                }

                $categoryHTML = '';
                if (!empty($product['category_name'])) {
                    $categoryHTML = '
                        <span class="inline-block text-xs bg-orange-100 text-orange-600 px-2 py-1 rounded mb-2 font-semibold">
                            ' . htmlspecialchars($product['category_name']) . '
                        </span>
                    ';
                }

                $stockHTML = '';
                if ($inStock) {
                    $stockHTML = '
                        <span class="text-sm text-green-600 font-semibold">
                            <i class="fas fa-check-circle"></i> Tersedia (' . $totalStock . ' item)
                        </span>
                    ';
                } else {
                    $stockHTML = '
                        <span class="text-sm text-red-600 font-semibold">
                            <i class="fas fa-times-circle"></i> Stok Habis
                        </span>
                    ';
                }

                $html .= '
                    <div class="bg-white border rounded-lg overflow-hidden hover:shadow-lg transition">
                        <div class="relative bg-gray-100 h-48 overflow-hidden">
                            <img src="' . $image . '" 
                                alt="' . htmlspecialchars($product['name']) . '"
                                class="w-full h-full object-cover hover:scale-110 transition">
                            ' . $ratingHTML . '
                        </div>
                        <div class="p-4">
                            ' . $categoryHTML . '
                            <h3 class="font-bold text-lg mb-2 line-clamp-2 h-14">
                                ' . htmlspecialchars($product['name']) . '
                            </h3>
                            <div class="mb-4">
                                <p class="text-orange-500 font-black text-lg">
                                    ' . $priceHTML . '
                                </p>
                            </div>
                            <div class="mb-4">
                                ' . $stockHTML . '
                            </div>
                            <a href="/products/detail/' . $product['id'] . '" 
                                class="block w-full text-center bg-orange-500 text-white py-2 rounded font-bold hover:bg-orange-600 transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                ';
            }
        }

        // Return count di response header
        header('X-Product-Count: ' . count($products));
        echo $html;

    } catch (Exception $e) {
        echo '
            <div class="col-span-full bg-white border rounded-lg p-12 text-center">
                <i class="fas fa-exclamation-circle text-6xl text-red-300 mb-4"></i>
                <p class="text-red-500 text-lg">Error: ' . $e->getMessage() . '</p>
            </div>
        ';
    }

    exit;
}
}