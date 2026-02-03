<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Users - Admin Merchansuki</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8b5cf6',
                        secondary: '#a78bfa',
                        accent: '#c084fc',
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glow-effect {
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.5);
        }

        .glow-effect:hover {
            box-shadow: 0 0 30px rgba(139, 92, 246, 0.8);
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1e1b4b;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #8b5cf6, #a78bfa);
            border-radius: 10px;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        .table-row {
            transition: all 0.3s ease;
        }

        .table-row:hover {
            background: rgba(139, 92, 246, 0.1);
            transform: scale(1.01);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen text-white">

    <!-- HEADER -->
    <header class="sticky top-0 z-50 glass-effect border-b border-purple-500/30 shadow-lg">
        <?php if(isset($_SESSION['error'])): ?>
    <div class="bg-red-500/30 text-red-100 p-3 rounded mb-4">
        <?= $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>
    <div class="bg-green-500/30 text-green-100 p-3 rounded mb-4">
        <?= $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

        <div class="container mx-auto px-4 sm:px-6 py-4">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <a href="/admin/dashboard" class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center glow-effect hover:scale-110 transition-transform">
                        <i class="fas fa-arrow-left text-white"></i>
                    </a>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent">
                            User Management
                        </h1>
                        <p class="text-purple-300 text-xs sm:text-sm">Kelola Data Pengguna</p>
                    </div>
                </div>
                
                <a href="/admin/dashboard" class="glass-effect px-4 py-2 rounded-full text-sm font-medium hover:bg-white/10 transition-all flex items-center gap-2">
                    <i class="fas fa-home text-purple-400"></i>
                    <span>Dashboard</span>
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="container mx-auto px-4 sm:px-6 py-8 lg:py-12">

        <!-- Stats & Actions Bar -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 slide-in">
            <!-- Total Users -->
            <div class="glass-effect rounded-xl p-4 sm:p-6 border border-blue-500/30">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center glow-effect">
                        <i class="fas fa-users text-white text-xl sm:text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-purple-300 text-xs sm:text-sm">Total Users</p>
                        <p class="text-2xl sm:text-3xl font-bold"><?= count($users) ?></p>
                    </div>
                </div>
            </div>

            <!-- Admin Users -->
            <div class="glass-effect rounded-xl p-4 sm:p-6 border border-pink-500/30">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-pink-500 to-rose-500 rounded-lg flex items-center justify-center glow-effect">
                        <i class="fas fa-crown text-white text-xl sm:text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-purple-300 text-xs sm:text-sm">Admin</p>
                        <p class="text-2xl sm:text-3xl font-bold">
                            <?= count(array_filter($users, fn($u) => $u['role'] === 'admin')) ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Regular Users -->
            <div class="glass-effect rounded-xl p-4 sm:p-6 border border-green-500/30">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center glow-effect">
                        <i class="fas fa-user text-white text-xl sm:text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-purple-300 text-xs sm:text-sm">Customer</p>
                        <p class="text-2xl sm:text-3xl font-bold">
                            <?= count(array_filter($users, fn($u) => $u['role'] === 'customer')) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="glass-effect rounded-xl p-4 sm:p-6 mb-6 border border-purple-500/30 slide-in" style="animation-delay: 0.1s;">
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                <div class="relative w-full sm:w-96">
                    <input 
                        type="text" 
                        id="searchInput"
                        placeholder="Cari nama atau email..." 
                        class="w-full pl-10 pr-4 py-3 glass-effect rounded-lg text-white placeholder-purple-300 focus:outline-none border border-purple-500/30 focus:border-purple-500 transition-all text-sm"
                    >
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-purple-400"></i>
                </div>
                
                <div class="flex gap-2 sm:gap-3 w-full sm:w-auto">
                    <select id="roleFilter" class="flex-1 sm:flex-none glass-effect px-4 py-3 rounded-lg text-white border border-purple-500/30 focus:outline-none focus:border-purple-500 transition-all text-sm">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="customer">Customer</option>
                    </select>
                    
                    <button class="flex-1 sm:flex-none bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 px-4 sm:px-6 py-3 rounded-lg font-semibold transition-all glow-effect flex items-center justify-center gap-2 text-sm" onclick="openAddModal()" type="button">
                        <i class="fas fa-plus"></i>
                        <span class="hidden sm:inline">Add User</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="glass-effect rounded-xl border border-purple-500/30 overflow-hidden slide-in" style="animation-delay: 0.2s;">
            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full bg-white/10 text-white">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border-b border-purple-500">ID</th>
                            <th class="px-4 py-2 border-b border-purple-500">Nama</th>
                            <th class="px-4 py-2 border-b border-purple-500">Email</th>
                            <th class="px-4 py-2 border-b border-purple-500">Role</th>
                            <th class="px-4 py-2 border-b border-purple-500">Dibuat</th>
                            <th class="px-4 py-2 border-b border-purple-500">Aksi</th>
                        </tr>
                    </thead>
      <tbody id="userTableBody">
<?php if (!empty($users)): ?>
    <?php foreach ($users as $user): ?>
        <tr class="hover:bg-purple-800/20 transition"
            data-name="<?= strtolower(htmlspecialchars($user['name'])) ?>"
            data-email="<?= strtolower(htmlspecialchars($user['email'])) ?>"
            data-role="<?= $user['role'] ?>">
            <td class="px-4 py-2 border-b border-purple-700 text-center"><?= $user['id'] ?></td>
            <td class="px-4 py-2 border-b border-purple-700"><?= htmlspecialchars($user['name']) ?></td>
            <td class="px-4 py-2 border-b border-purple-700"><?= htmlspecialchars($user['email']) ?></td>
            <td class="px-4 py-2 border-b border-purple-700 text-center">
                <span class="px-2 py-1 rounded-full text-xs font-semibold <?= $user['role'] === 'admin' ? 'bg-pink-500' : 'bg-blue-500' ?>">
                    <?= $user['role'] ?>
                </span>
            </td>
            <td class="px-4 py-2 border-b border-purple-700 text-center"><?= $user['created_at'] ?></td>
            <td class="px-4 py-2 border-b border-purple-700 text-center">
                <button onclick='openEditModal(<?= json_encode($user) ?>)'><i class="fas fa-edit"></i></button>
                <a href="/admin/users/delete/<?= $user['id'] ?>" class="text-red-400 hover:text-red-300" onclick="return confirm('Yakin hapus user ini?')"><i class="fas fa-trash"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="6" class="text-center py-6 text-purple-200">Belum ada user.</td></tr>
<?php endif; ?>
</tbody>

                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-4 p-4" id="userCards">
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <div class="glass-effect rounded-xl p-4 border border-purple-500/30" data-name="<?= strtolower(htmlspecialchars($user['name'])) ?>" data-email="<?= strtolower(htmlspecialchars($user['email'])) ?>" data-role="<?= $user['role'] ?>">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center font-bold">
                                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-sm"><?= htmlspecialchars($user['name']) ?></h3>
                                        <p class="text-xs text-purple-300">ID: #<?= $user['id'] ?></p>
                                    </div>
                                </div>
                                <?php if ($user['role'] === 'admin'): ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-pink-500 to-rose-500">
                                        <i class="fas fa-crown text-[10px]"></i>Admi
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-500 to-indigo-500">
                                        <i class="fas fa-user text-[10px]"></i>User
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="space-y-2 mb-3 text-xs">
                                <div class="flex items-center gap-2 text-purple-200">
                                    <i class="fas fa-envelope w-4"></i>
                                    <span><?= htmlspecialchars($user['email']) ?></span>
                                </div>
                                <div class="flex items-center gap-2 text-purple-200">
                                    <i class="fas fa-calendar w-4"></i>
                                    <span><?= date('d M Y', strtotime($user['created_at'])) ?></span>
                                </div>
                            </div>
                            
                            <div class="flex gap-2">
                                <button 
                                    onclick='openEditModal(<?= json_encode($user) ?>)''
                                    class="flex-1 bg-yellow-500/20 hover:bg-yellow-500/30 py-2 rounded-lg flex items-center justify-center gap-2 transition-all text-sm">
                                    <i class="fas fa-edit text-yellow-400"></i>
                                    <span class="text-yellow-400 font-medium">Edit</span>
                                </button>
                                <a href="/admin/users/delete/<?= $user['id'] ?>" 
                                   class="flex-1 bg-red-500/20 hover:bg-red-500/30 py-2 rounded-lg flex items-center justify-center gap-2 transition-all text-sm"
                                   onclick="return confirm('Yakin hapus user ini?')">
                                    <i class="fas fa-trash text-red-400"></i>
                                    <span class="text-red-400 font-medium">Delete</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-12">
                        <i class="fas fa-users text-6xl text-purple-400/30 mb-4"></i>
                        <p class="text-purple-200">Belum ada user terdaftar</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>



        <!-- Modal Add User -->
        <div id="addUserModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden px-2 sm:px-0">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-4 sm:p-6 relative text-gray-900">
                <button onclick="closeAddModal()" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-xl">&times;</button>
                <h2 class="text-xl font-bold mb-4">Tambah User</h2>
                <form id="addUserForm" action="/admin/users/add" method="POST" class="space-y-4">
                    <div>
                        <label for="addUserName" class="block mb-1 font-semibold">Nama</label>
                        <input type="text" name="name" id="addUserName" class="w-full px-3 py-2 rounded border border-purple-400 focus:outline-none" required>
                    </div>
                    <div>
                        <label for="addUserEmail" class="block mb-1 font-semibold">Email</label>
                        <input type="email" name="email" id="addUserEmail" class="w-full px-3 py-2 rounded border border-purple-400 focus:outline-none" required>
                    </div>
                    <div>
                        <label for="addUserPassword" class="block mb-1 font-semibold">Password</label>
                        <input type="password" name="password" id="addUserPassword" class="w-full px-3 py-2 rounded border border-purple-400 focus:outline-none" required>
                    </div>
                    <div>
                        <label for="addUserRole" class="block mb-1 font-semibold">Role</label>
                        <select name="role" id="addUserRole" class="w-full px-3 py-2 rounded border border-purple-400 focus:outline-none">
                            <option value="customer">Customer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 py-2 rounded font-bold text-white hover:from-purple-700 hover:to-pink-700 transition">Tambah User</button>
                </form>
            </div>
        </div>

        <!-- Modal Edit User -->
        <div id="editUserModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden px-2 sm:px-0">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-4 sm:p-6 relative text-gray-900">
        <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-xl">&times;</button>
        <h2 class="text-xl font-bold mb-4">Edit User</h2>
        <form id="editUserForm" action="/admin/users/edit" method="POST" class="space-y-4">
            <input type="hidden" name="id" id="editUserId">
            <div>
                <label for="editUserName" class="block mb-1 font-semibold">Nama</label>
                <input type="text" name="name" id="editUserName" class="w-full px-3 py-2 rounded border border-purple-400 focus:outline-none" required>
            </div>
            <div>
                <label for="editUserEmail" class="block mb-1 font-semibold">Email</label>
                <input type="email" name="email" id="editUserEmail" class="w-full px-3 py-2 rounded border border-purple-400 focus:outline-none" required>
            </div>
            <div>
                <label for="editUserRole" class="block mb-1 font-semibold">Role</label>
                <select name="role" id="editUserRole" class="w-full px-3 py-2 rounded border border-purple-400 focus:outline-none">
                    <option value="customer">Customer</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 py-2 rounded font-bold text-white hover:from-purple-700 hover:to-pink-700 transition">Simpan Perubahan</button>
        </form>
    </div>
</div>


    </main>

    <script>
        // Search Functionality
        const searchInput = document.getElementById('searchInput');
        const roleFilter = document.getElementById('roleFilter');

        function filterUsers() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedRole = roleFilter.value;

            // Table rows (desktop)
            document.querySelectorAll('#userTableBody tr[data-name]').forEach(row => {
                const name = row.getAttribute('data-name');
                const email = row.getAttribute('data-email');
                const role = row.getAttribute('data-role');
                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                const matchesRole = !selectedRole || role === selectedRole;
                row.style.display = (matchesSearch && matchesRole) ? '' : 'none';
            });

            // Card items (mobile)
            document.querySelectorAll('#userCards > div[data-name]').forEach(card => {
                const name = card.getAttribute('data-name');
                const email = card.getAttribute('data-email');
                const role = card.getAttribute('data-role');
                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                const matchesRole = !selectedRole || role === selectedRole;
                card.style.display = (matchesSearch && matchesRole) ? '' : 'none';
            });
        }

        if (searchInput && roleFilter) {
            searchInput.addEventListener('input', filterUsers);
            roleFilter.addEventListener('change', filterUsers);
        }

        // Edit User Modal
        function openEditModal(user) {
    // Debug: pastikan id ada
    if(!user.id){
        alert('User ID kosong! Tidak bisa edit.');
        return;
    }

    document.getElementById('editUserId').value = user.id;
    document.getElementById('editUserName').value = user.name;
    document.getElementById('editUserEmail').value = user.email;
    document.getElementById('editUserRole').value = user.role;
    document.getElementById('editUserModal').classList.remove('hidden');

    setTimeout(() => {
        document.getElementById('editUserName').focus();
    }, 100);
}

function closeEditModal() {
    document.getElementById('editUserModal').classList.add('hidden');
}

// Add User Modal
function openAddModal() {
    document.getElementById('addUserModal').classList.remove('hidden');
    setTimeout(() => {
        document.getElementById('addUserName').focus();
    }, 100);
}
function closeAddModal() {
    document.getElementById('addUserModal').classList.add('hidden');
}

        // Optional: Show feedback after submit
        document.getElementById('editUserForm').onsubmit = function() {
            // Optionally show a loading indicator or disable button
            // The form will submit normally (POST) and reload the page
            // You can add AJAX here if you want to update without reload
            return true;
        };
    </script>

</body>
</html>