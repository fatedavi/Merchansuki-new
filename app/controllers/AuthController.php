<?php

class AuthController extends Controller
{
    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if (!$user) {
                $error = 'Email tidak ditemukan.';
            } elseif (!password_verify($password, $user['password'])) {
                $error = 'Password salah.';
            } else {
                // ✅ SET SESSION LOGIN
                $_SESSION['user'] = [
                    'id'    => $user['id'],
                    'name'  => $user['name'],
                    'email' => $user['email'],
                    'role'  => $user['role']
                ];

                header('Location: /');
                exit;
            }
        }

        $this->view('auth.login', compact('error'));
    }

    public function register()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = trim($_POST['name'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';

            $userModel = $this->model('User');

            if ($userModel->findByEmail($email)) {
                $error = 'Email sudah terdaftar.';
            } elseif ($password !== $confirm) {
                $error = 'Konfirmasi password tidak cocok.';
            } elseif (strlen($password) < 6) {
                $error = 'Password minimal 6 karakter.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $userModel->create([
                    'name'     => $name,
                    'email'    => $email,
                    'password' => $hashedPassword,
                    'role'     => 'customer'
                ]);

                header('Location: /auth/login');
                exit;
            }
        }

        $this->view('auth/register', compact('error'));
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

        header('Location: /auth/login');
        exit;
    }
    /**
     * Form Lupa Password
     */
    public function forgotPassword()
    {
        $this->view('auth.forgot-password');
    }

    /**
     * Kirim Email Reset Password
     */
public function sendResetLink()
{
    // Pastikan session aktif
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Ambil & validasi email
    $email = trim($_POST['email'] ?? '');
    if ($email === '') {
        $_SESSION['error'] = 'Email wajib diisi.';
        header('Location: /auth/forgot-password');
        exit;
    }

    // Ambil user
    $userModel = $this->model('User');
    $user = $userModel->findByEmail($email);

    if (!$user) {
        $_SESSION['error'] = 'Email tidak terdaftar.';
        header('Location: /auth/forgot-password');
        exit;
    }

    // Generate token & expiry (1 jam)
    $token   = bin2hex(random_bytes(16));
    $expires = date('Y-m-d H:i:s', time() + 3600);

    // Simpan token ke DB
    $userModel->setResetToken($user['id'], $token, $expires);

    // Load helper email
    require_once __DIR__ . '/../helpers/mail_helper.php';

    // === AUTO DETECT DOMAIN (LOCAL & SERVER) ===
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        ? 'https'
        : 'http';

    $host = $_SERVER['HTTP_HOST'];

    $resetLink = $protocol . '://' . $host . "/reset-password/$token";

    // Email body
    $body = "
        <h3>Reset Password</h3>
        <p>Klik link berikut untuk reset password Anda:</p>
        <p><a href='{$resetLink}'>{$resetLink}</a></p>
        <p><small>Link ini berlaku selama 1 jam.</small></p>
    ";

    // Kirim email
    $sent = send_mail($email, 'Reset Password Akun Anda', $body);

    // Flash message
    $_SESSION['success'] = $sent
        ? 'Link reset password telah dikirim ke email Anda.'
        : 'Gagal mengirim email. Silakan coba lagi.';

    // Redirect balik ke form
    header('Location: /auth/forgot-password');
    exit;
}


public function resetPassword($token)
{
    $userModel = $this->model('User');
    $user = $userModel->findByResetToken($token);

    if (!$user) {
        $this->view('auth.reset-password', ['error' => 'Token tidak valid atau sudah kadaluarsa']);
        return;
    }

    // Hitung sisa waktu dalam detik
    $expiresTimestamp = strtotime($user['reset_expires']);
    $remainingSeconds = $expiresTimestamp - time();
    if ($remainingSeconds <= 0) {
        $this->view('auth.reset-password', ['error' => 'Token sudah kadaluarsa']);
        return;
    }

    $this->view('auth.reset-password', [
        'token' => $token,
        'remainingSeconds' => $remainingSeconds
    ]);
}

public function updatePassword()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (!$token || !$password || !$confirm) {
        $_SESSION['error'] = "Semua field wajib diisi.";
        header("Location: /reset-password/$token");
        exit;
    }

    if ($password !== $confirm) {
        $_SESSION['error'] = "Password tidak sama.";
        header("Location: /reset-password/$token");
        exit;
    }

    $userModel = $this->model('User');
    $user = $userModel->findByResetToken($token);
    if (!$user) {
        $_SESSION['error'] = "Token tidak valid atau kadaluarsa.";
        header('/auth/forgot-password');
        exit;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $userModel->updatePassword($user['id'], $hashed);

    $_SESSION['success'] = "Password berhasil diubah. Silakan login.";
    header('Location: /auth/login');
    exit;
}

}
