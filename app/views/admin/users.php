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
            background-color: #f9fafb; /* Light Gray */
            color: #1f2937; /* Gray-800 */
        }

        /* Glass Effect (now white card style) */
        .glass-effect {
            background: #ffffff;
            border: 1px solid #e5e7eb; /* Gray-200 */
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .glow-effect {
            transition: all 0.3s ease;
        }

        .glow-effect:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        .table-row {
            transition: all 0.2s ease;
        }

        .table-row:hover {
            background-color: #f9fafb;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen text-gray-800">

    <!-- HEADER -->
    <header class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
        <?php if(isset($_SESSION['error'])): ?>
            <div class="bg-red-50 text-red-700 p-3 text-sm text-center border-b border-red-100">
                <?= $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['success'])): ?>
            <div class="bg-green-50 text-green-700 p-3 text-sm text-center border-b border-green-100">
                <?= $_SESSION['success']; ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="container mx-auto px-4 sm:px-6 py-4">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <a href="/admin/dashboard" class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white hover:scale-110 transition-transform shadow-md">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
                            User Management
                        </h1>
                        <p class="text-gray-500 text-xs sm:text-sm">Kelola Data Pengguna</p>
                    </div>
                </div>
                
                <a href="/admin/dashboard" class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 transition-all flex items-center gap-2">
                    <i class="fas fa-home text-purple-500"></i>
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
            <div class="bg-white rounded-xl p-4 sm:p-6 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-xl sm:text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs sm:text-sm">Total Users</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900"><?= count($users) ?></p>
                    </div>
                </div>
            </div>

            <!-- Admin Users -->
            <div class="bg-white rounded-xl p-4 sm:p-6 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-pink-50 text-pink-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-crown text-xl sm:text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs sm:text-sm">Admin</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">
                            <?= count(array_filter($users, fn($u) => $u['role'] === 'admin')) ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Regular Users -->
            <div class="bg-white rounded-xl p-4 sm:p-6 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-green-50 text-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-xl sm:text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs sm:text-sm">Customer</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">
                            <?= count(array_filter($users, fn($u) => $u['role'] === 'customer')) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-xl p-4 sm:p-6 mb-6 border border-gray-200 shadow-sm slide-in" style="animation-delay: 0.1s;">
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                <div class="relative w-full sm:w-96">
                    <input 
                        type="text" 
                        id="searchInput"
                        placeholder="Cari nama atau email..." 
                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm"
                    >
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
                
                <div class="flex gap-2 sm:gap-3 w-full sm:w-auto">
                    <select id="roleFilter" class="flex-1 sm:flex-none bg-gray-50 border border-gray-300 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all text-sm cursor-pointer">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="customer">Customer</option>
                    </select>
                    
                    <button class="flex-1 sm:flex-none bg-indigo-600 hover:bg-indigo-700 text-white px-4 sm:px-6 py-3 rounded-lg font-semibold transition-all shadow-sm flex items-center justify-center gap-2 text-sm" onclick="openAddModal()" type="button">
                        <i class="fas fa-plus"></i>
                        <span class="hidden sm:inline">Add User</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden slide-in" style="animation-delay: 0.2s;">
            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold border-b border-gray-200">
                            <th class="px-6 py-3 text-center border-r border-gray-100">ID</th>
                            <th class="px-6 py-3 text-left">Nama</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-center">Role</th>
                            <th class="px-6 py-3 text-center">Dibuat</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody" class="divide-y divide-gray-100">
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50 transition"
                                data-name="<?= strtolower(htmlspecialchars($user['name'])) ?>"
                                data-email="<?= strtolower(htmlspecialchars($user['email'])) ?>"
                                data-role="<?= $user['role'] ?>">
                                <td class="px-6 py-4 text-center text-gray-500 border-r border-gray-100 font-mono text-xs"><?= $user['id'] ?></td>
                                <td class="px-6 py-4 font-medium text-gray-900"><?= htmlspecialchars($user['name']) ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?= $user['role'] === 'admin' ? 'bg-pink-100 text-pink-700 border border-pink-200' : 'bg-blue-100 text-blue-700 border border-blue-200' ?>">
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500"><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button onclick='openEditModal(<?= json_encode($user) ?>)' class="w-8 h-8 flex items-center justify-center rounded bg-yellow-50 text-yellow-600 hover:bg-yellow-100 border border-yellow-200 transition-colors" title="Edit">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        
                                        <a href="/admin/users/delete/<?= $user['id'] ?>" 
                                           class="w-8 h-8 flex items-center justify-center rounded bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 transition-colors" 
                                           onclick="return confirm('Yakin hapus user ini?')"
                                           title="Delete">
                                            <i class="fas fa-trash text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-8 text-gray-400">Belum ada user.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-4 p-4" id="userCards">
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm" data-name="<?= strtolower(htmlspecialchars($user['name'])) ?>" data-email="<?= strtolower(htmlspecialchars($user['email'])) ?>" data-role="<?= $user['role'] ?>">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center font-bold text-sm border border-gray-200">
                                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-sm text-gray-900"><?= htmlspecialchars($user['name']) ?></h3>
                                        <p class="text-xs text-gray-400">ID: #<?= $user['id'] ?></p>
                                    </div>
                                </div>
                                <?php if ($user['role'] === 'admin'): ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-semibold bg-pink-100 text-pink-700 border border-pink-200">
                                        <i class="fas fa-crown text-[8px]"></i> Admin
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                        <i class="fas fa-user text-[8px]"></i> User
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="space-y-2 mb-4 text-xs">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <i class="fas fa-envelope w-4 text-gray-400"></i>
                                    <span><?= htmlspecialchars($user['email']) ?></span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-600">
                                    <i class="fas fa-calendar w-4 text-gray-400"></i>
                                    <span><?= date('d M Y', strtotime($user['created_at'])) ?></span>
                                </div>
                            </div>
                            
                            <div class="flex gap-2">
                                <button 
                                    onclick='openEditModal(<?= json_encode($user) ?>)'
                                    class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 rounded-lg flex items-center justify-center gap-2 transition-all text-xs font-medium">
                                    <i class="fas fa-edit text-gray-500"></i> Edit
                                </button>
                                <a href="/admin/users/delete/<?= $user['id'] ?>" 
                                   class="flex-1 bg-white border border-red-200 hover:bg-red-50 text-red-600 py-2 rounded-lg flex items-center justify-center gap-2 transition-all text-xs font-medium"
                                   onclick="return confirm('Yakin hapus user ini?')">
                                    <i class="fas fa-trash text-red-400"></i> Delete
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-12">
                        <i class="fas fa-users text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 text-sm">Belum ada user terdaftar</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Modal Add User -->
        <div id="addUserModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 hidden backdrop-blur-sm px-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative text-gray-900 border border-gray-200 transform transition-all scale-100">
                <button onclick="closeAddModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
                <h2 class="text-lg font-bold mb-1 text-gray-900">Tambah User</h2>
                <p class="text-xs text-gray-500 mb-6">Masukkan data pengguna baru sistem.</p>
                
                <form id="addUserForm" action="/admin/users/add" method="POST" class="space-y-4">
                    <div>
                        <label for="addUserName" class="block mb-1.5 text-xs font-bold text-gray-600 uppercase tracking-wide">Nama</label>
                        <input type="text" name="name" id="addUserName" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm" placeholder="Nama Lengkap" required>
                    </div>
                    <div>
                        <label for="addUserEmail" class="block mb-1.5 text-xs font-bold text-gray-600 uppercase tracking-wide">Email</label>
                        <input type="email" name="email" id="addUserEmail" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm" placeholder="email@contoh.com" required>
                    </div>
                    <div>
                        <label for="addUserPassword" class="block mb-1.5 text-xs font-bold text-gray-600 uppercase tracking-wide">Password</label>
                        <input type="password" name="password" id="addUserPassword" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm" placeholder="••••••••" required>
                    </div>
                    <div>
                        <label for="addUserRole" class="block mb-1.5 text-xs font-bold text-gray-600 uppercase tracking-wide">Role</label>
                        <div class="relative">
                            <select name="role" id="addUserRole" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm appearance-none">
                                <option value="customer">Customer</option>
                                <option value="admin">Admin</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg shadow-sm hover:shadow transition-all text-sm">Simpan User</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit User -->
        <div id="editUserModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 hidden backdrop-blur-sm px-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative text-gray-900 border border-gray-200">
                <button onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
                <h2 class="text-lg font-bold mb-1 text-gray-900">Edit User</h2>
                <p class="text-xs text-gray-500 mb-6">Perbarui informasi pengguna.</p>

                <form id="editUserForm" action="/admin/users/edit" method="POST" class="space-y-4">
                    <input type="hidden" name="id" id="editUserId">
                    <div>
                        <label for="editUserName" class="block mb-1.5 text-xs font-bold text-gray-600 uppercase tracking-wide">Nama</label>
                        <input type="text" name="name" id="editUserName" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm" required>
                    </div>
                    <div>
                        <label for="editUserEmail" class="block mb-1.5 text-xs font-bold text-gray-600 uppercase tracking-wide">Email</label>
                        <input type="email" name="email" id="editUserEmail" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm" required>
                    </div>
                    <div>
                        <label for="editUserRole" class="block mb-1.5 text-xs font-bold text-gray-600 uppercase tracking-wide">Role</label>
                        <div class="relative">
                            <select name="role" id="editUserRole" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm appearance-none">
                                <option value="customer">Customer</option>
                                <option value="admin">Admin</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg shadow-sm hover:shadow transition-all text-sm">Simpan Perubahan</button>
                    </div>
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
            if(!user.id){
                alert('User ID kosong! Tidak bisa edit.');
                return;
            }

            document.getElementById('editUserId').value = user.id;
            document.getElementById('editUserName').value = user.name;
            document.getElementById('editUserEmail').value = user.email;
            document.getElementById('editUserRole').value = user.role;
            document.getElementById('editUserModal').classList.remove('hidden');
            document.getElementById('editUserModal').classList.add('flex'); // Centering

            setTimeout(() => {
                document.getElementById('editUserName').focus();
            }, 100);
        }

        function closeEditModal() {
            document.getElementById('editUserModal').classList.add('hidden');
            document.getElementById('editUserModal').classList.remove('flex');
        }

        // Add User Modal
        function openAddModal() {
            document.getElementById('addUserModal').classList.remove('hidden');
            document.getElementById('addUserModal').classList.add('flex');
            setTimeout(() => {
                document.getElementById('addUserName').focus();
            }, 100);
        }
        function closeAddModal() {
            document.getElementById('addUserModal').classList.add('hidden');
            document.getElementById('addUserModal').classList.remove('flex');
        }

    </script>

</body>
</html>