<?php

class ProfileController extends Controller
{
    /**
     * Helper: Pastikan user sudah login
     */
    private function requireLogin()
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu.';
            header('Location: /auth/login');
            exit;
        }
    }

    /**
     * Tampilkan halaman profile
     */
    public function index()
    {
        $this->requireLogin();

        $userId = $_SESSION['user']['id'];
        $profileModel = $this->model('Profile');
        $userModel = $this->model('User');

        $profile = $profileModel->findByUserId($userId);
        $user = $userModel->findById($userId);

        $isComplete = $profileModel->isComplete($profile);

        $this->view('profile/index', [
            'user' => $user,
            'profile' => $profile,
            'isComplete' => $isComplete
        ]);
    }

    /**
     * Tampilkan form edit profile
     */
    public function edit()
    {
        $this->requireLogin();

        $userId = $_SESSION['user']['id'];
        $profileModel = $this->model('Profile');
        $userModel = $this->model('User');

        $profile = $profileModel->findByUserId($userId);
        $user = $userModel->findById($userId);

        $this->view('profile/edit', [
            'user' => $user,
            'profile' => $profile
        ]);
    }

    /**
     * Update profile
     */
    public function update()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /profile');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $profileModel = $this->model('Profile');

        // Ambil data dari POST
        $data = [
            'phone' => trim($_POST['phone'] ?? ''),
            'birth_place' => trim($_POST['birth_place'] ?? ''),
            'birth_date' => $_POST['birth_date'] ?? null,
            'gender' => $_POST['gender'] ?? null,
            'address' => trim($_POST['address'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'province' => trim($_POST['province'] ?? ''),
            'postal_code' => trim($_POST['postal_code'] ?? ''),
            'country' => trim($_POST['country'] ?? 'Indonesia')
        ];

        // Validasi (opsional, bisa ditambah)
        if (empty($data['phone'])) {
            $_SESSION['error'] = 'Nomor telepon wajib diisi.';
            header('Location: /profile/edit');
            exit;
        }

        // Simpan ke database
        $saved = $profileModel->save($userId, $data);

        if ($saved) {
            $_SESSION['success'] = 'Profile berhasil diperbarui.';
            header('Location: /profile');
        } else {
            $_SESSION['error'] = 'Gagal memperbarui profile.';
            header('Location: /profile/edit');
        }
        exit;
    }
}
