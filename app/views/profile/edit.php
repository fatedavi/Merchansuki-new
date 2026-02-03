<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Merchansuki</title>
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
                <i class="fas fa-edit"></i>
            </span>
            Edit Profile
        </h1>
        <a href="/profile"
           class="px-4 py-2 bg-gray-500 text-white rounded-lg font-semibold hover:bg-gray-600 transition shadow-md">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
                <p class="text-red-700 font-semibold"><?= htmlspecialchars($_SESSION['error']) ?></p>
            </div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Form Edit Profile -->
    <form method="POST" action="/profile/update" class="bg-white border rounded-xl p-6 md:p-8 shadow-sm">
        <div class="space-y-6">
            <!-- Informasi Akun (Read-only) -->
            <div>
                <h2 class="text-lg font-bold mb-4 text-gray-800 border-b pb-2">
                    <i class="fas fa-user-circle mr-2 text-orange-500"></i> Informasi Akun
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
                        <input type="text" value="<?= htmlspecialchars($user['name'] ?? '') ?>" 
                               class="w-full px-4 py-2 border rounded-lg bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input type="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" 
                               class="w-full px-4 py-2 border rounded-lg bg-gray-100" disabled>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-info-circle mr-1"></i> Untuk mengubah nama dan email, hubungi admin.
                </p>
            </div>

            <!-- Data Pribadi -->
            <div>
                <h2 class="text-lg font-bold mb-4 text-gray-800 border-b pb-2">
                    <i class="fas fa-id-card mr-2 text-orange-500"></i> Data Pribadi
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="phone" 
                               value="<?= htmlspecialchars($profile['phone'] ?? '') ?>"
                               placeholder="081234567890"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kelamin</label>
                        <select name="gender" 
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Pilih...</option>
                            <option value="male" <?= isset($profile['gender']) && $profile['gender'] === 'male' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="female" <?= isset($profile['gender']) && $profile['gender'] === 'female' ? 'selected' : '' ?>>Perempuan</option>
                            <option value="other" <?= isset($profile['gender']) && $profile['gender'] === 'other' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Tempat Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="birth_place" 
                               value="<?= htmlspecialchars($profile['birth_place'] ?? '') ?>"
                               placeholder="Jakarta"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="birth_date" 
                               value="<?= !empty($profile['birth_date']) ? htmlspecialchars($profile['birth_date']) : '' ?>"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               required>
                    </div>
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <h2 class="text-lg font-bold mb-4 text-gray-800 border-b pb-2">
                    <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i> Alamat
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address" rows="3" 
                                  placeholder="Jl. Contoh No. 123, RT/RW 001/002"
                                  class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                  required><?= htmlspecialchars($profile['address'] ?? '') ?></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Kota/Kabupaten <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="city" 
                                   value="<?= htmlspecialchars($profile['city'] ?? '') ?>"
                                   placeholder="Jakarta Selatan"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                   required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Provinsi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="province" 
                                   value="<?= htmlspecialchars($profile['province'] ?? '') ?>"
                                   placeholder="DKI Jakarta"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                   required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Kode Pos <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="postal_code" 
                                   value="<?= htmlspecialchars($profile['postal_code'] ?? '') ?>"
                                   placeholder="12345"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                   required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Negara</label>
                            <input type="text" name="country" 
                                   value="<?= htmlspecialchars($profile['country'] ?? 'Indonesia') ?>"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button Actions -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t">
                <a href="/profile"
                   class="px-6 py-2 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition shadow-md">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
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
