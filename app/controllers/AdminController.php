<?php

class AdminController extends Controller
{
    /**
     * @var User
     */
    private $userModel;

    public function __construct()
    {
        // Pastikan session aktif
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Load model SEKALI
        $this->userModel = new User();
    }

    /**
     * 🔐 Helper: Pastikan user login & admin
     */
    private function ensureAdmin()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            http_response_code(403);
            exit('Akses ditolak');
        }
    }

    /**
     * 📊 Dashboard Admin
     */
public function dashboard()
{
    $this->ensureAdmin();

    $productModel = $this->model('Product');
    $userModel    = $this->model('User');

    $products = $productModel->getAll();
    $users    = $userModel->getAll();

    $data = [
        'products'  => $products,
        'users'     => $users,
        'adminName' => $_SESSION['user']['name'] ?? 'Admin'
    ];

    $this->view('admin/dashboard', $data);
}



    /**
     * 👤 Manajemen User
     */
    public function users()
    {
        $this->ensureAdmin();

        $users = $this->userModel->getAll();

        $data = [
            'title' => 'Manajemen User',
            'users' => $users
        ];

        $this->view('admin/users', $data);
    }

    /**
     * ➕ Simpan User Baru
     */
    public function store()
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/users');
            exit;
        }

        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role     = $_POST['role'] ?? 'user';

        if ($name === '' || $email === '' || $password === '') {
            $_SESSION['error'] = 'Nama, email, dan password wajib diisi.';
            header('Location: /admin/users');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Format email tidak valid.';
            header('Location: /admin/users');
            exit;
        }

        // Cek email unik
        if ($this->userModel->findByEmail($email)) {
            $_SESSION['error'] = 'Email sudah digunakan.';
            header('Location: /admin/users');
            exit;
        }

        $this->userModel->create([
            'name'     => $name,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => $role
        ]);

        $_SESSION['success'] = 'User berhasil ditambahkan.';
        header('Location: /admin/users');
        exit;
    }

    /**
     * ✏️ Update User
     */
    public function edit()
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/users');
            exit;
        }

        $id    = $_POST['id'] ?? null;
        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role  = $_POST['role'] ?? 'user';

        if (!$id || $name === '' || $email === '') {
            $_SESSION['error'] = 'ID, nama, dan email wajib diisi.';
            header('Location: /admin/users');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Format email tidak valid.';
            header('Location: /admin/users');
            exit;
        }

        $user = $this->userModel->findById($id);
        if (!$user) {
            $_SESSION['error'] = 'User tidak ditemukan.';
            header('Location: /admin/users');
            exit;
        }

        $emailOwner = $this->userModel->findByEmail($email);
        if ($emailOwner && $emailOwner['id'] != $id) {
            $_SESSION['error'] = 'Email sudah digunakan user lain.';
            header('Location: /admin/users');
            exit;
        }

        $updated = $this->userModel->update([
            'id'    => $id,
            'name'  => $name,
            'email' => $email,
            'role'  => $role
        ]);

        $_SESSION[$updated ? 'success' : 'error'] = $updated
            ? 'User berhasil diperbarui.'
            : 'Gagal memperbarui user.';

        header('Location: /admin/users');
        exit;
    }

    /**
     * 🗑️ Hapus User
     */
    public function delete($id)
    {
        $this->ensureAdmin();

        $user = $this->userModel->findById($id);
        if (!$user) {
            $_SESSION['error'] = 'User tidak ditemukan.';
            header('Location: /admin/users');
            exit;
        }

        if ($_SESSION['user']['id'] == $id) {
            $_SESSION['error'] = 'Tidak bisa menghapus akun sendiri.';
            header('Location: /admin/users');
            exit;
        }

        $this->userModel->delete($id);

        $_SESSION['success'] = 'User berhasil dihapus.';
        header('Location: /admin/users');
        exit;
    }
}
