<?php

class HomeController extends Controller
{
    public function index()
{
    $productModel = new Product();

    // Ambil semua produk highlighted dengan varian
    $allHighlighted = $productModel->getAllWithVariants();

    // Filter hanya yang highlight = 1
    $products = array_filter($allHighlighted, fn($p) => $p['highlight'] == 1);

    $this->view('home/index', [
        'products' => $products
    ]);
}

}
