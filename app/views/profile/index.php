<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Saya - Merchansuki</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

<?php include __DIR__ . '/../home/partials/navbar.php'; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl md:text-3xl font-black flex items-center gap-3">
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-orange-500 text-white">
                <i class="fas fa-user"></i>
            </span>
            Profile Saya
        </h1>
        <a href="/profile/edit"
           class="px-4 py-2 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition shadow-md">
            <i class="fas fa-edit mr-2"></i> Edit Profile
        </a>
    </div>

    <!-- Alert jika profile belum lengkap -->
    <?php if (!$isComplete): ?>
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mr-3 mt-1"></i>
                <div class="flex-1">
                    <h3 class="font-bold text-yellow-800 mb-1">Profile Belum Lengkap</h3>
                    <p class="text-yellow-700 text-sm">
                        Silakan lengkapi data profile Anda untuk pengalaman belanja yang lebih baik.
                        <a href="/profile/edit" class="underline font-semibold ml-1">Lengkapi Sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                <p class="text-green-700 font-semibold"><?= htmlspecialchars($_SESSION['success']) ?></p>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
                <p class="text-red-700 font-semibold"><?= htmlspecialchars($_SESSION['error']) ?></p>
            </div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Profile Card -->
    <div class="bg-white border rounded-xl p-6 md:p-8 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Informasi Akun -->
            <div>
                <h2 class="text-lg font-bold mb-4 text-gray-800 border-b pb-2">
                    <i class="fas fa-user-circle mr-2 text-orange-500"></i> Informasi Akun
                </h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-semibold text-gray-500">Nama</label>
                        <p class="text-gray-800 font-medium"><?= htmlspecialchars($user['name'] ?? '-') ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-500">Email</label>
                        <p class="text-gray-800 font-medium"><?= htmlspecialchars($user['email'] ?? '-') ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-500">Role</label>
                        <p class="text-gray-800 font-medium">
                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-bold uppercase">
                                <?= htmlspecialchars($user['role'] ?? 'customer') ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Data Pribadi -->
            <div>
                <h2 class="text-lg font-bold mb-4 text-gray-800 border-b pb-2">
                    <i class="fas fa-id-card mr-2 text-orange-500"></i> Data Pribadi
                </h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-semibold text-gray-500">Nomor Telepon</label>
                        <p class="text-gray-800 font-medium">
                            <?= !empty($profile['phone']) ? htmlspecialchars($profile['phone']) : '<span class="text-gray-400 italic">Belum diisi</span>' ?>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-500">Tempat, Tanggal Lahir</label>
                        <p class="text-gray-800 font-medium">
                            <?php if (!empty($profile['birth_place']) && !empty($profile['birth_date'])): ?>
                                <?= htmlspecialchars($profile['birth_place']) ?>, 
                                <?= date('d F Y', strtotime($profile['birth_date'])) ?>
                            <?php else: ?>
                                <span class="text-gray-400 italic">Belum diisi</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-500">Jenis Kelamin</label>
                        <p class="text-gray-800 font-medium">
                            <?php if (!empty($profile['gender'])): ?>
                                <?php
                                $genderLabels = [
                                    'male' => 'Laki-laki',
                                    'female' => 'Perempuan',
                                    'other' => 'Lainnya'
                                ];
                                echo htmlspecialchars($genderLabels[$profile['gender']] ?? $profile['gender']);
                                ?>
                            <?php else: ?>
                                <span class="text-gray-400 italic">Belum diisi</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alamat -->
        <div class="mt-6 pt-6 border-t">
            <h2 class="text-lg font-bold mb-4 text-gray-800">
                <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i> Alamat
            </h2>
            <?php if (!empty($profile['address'])): ?>
                <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                    <p class="text-gray-800 font-medium">
                        <?= nl2br(htmlspecialchars($profile['address'])) ?>
                    </p>
                    <div class="flex flex-wrap gap-2 text-sm text-gray-600">
                        <?php if (!empty($profile['city'])): ?>
                            <span><?= htmlspecialchars($profile['city']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($profile['province'])): ?>
                            <span>• <?= htmlspecialchars($profile['province']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($profile['postal_code'])): ?>
                            <span>• <?= htmlspecialchars($profile['postal_code']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($profile['country'])): ?>
                            <span>• <?= htmlspecialchars($profile['country']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-gray-400 italic">Alamat belum diisi</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../home/partials/footer.php'; ?>

<script>
    // Mobile Menu Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const burger = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        if (burger && menu) {
            burger.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });
        }
    });
</script>

</body>
</html>
