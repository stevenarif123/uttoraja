<div class="sidebar bg-blue-800 text-white w-64 py-4 px-6">
    <div class="mb-8">
        <h1 class="text-2xl font-bold">UT Toraja</h1>
        <p class="text-blue-200 text-sm">Admin Panel</p>
    </div>
    
    <nav>
        <ul>
            <li class="mb-2">
                <a href="./" class="flex items-center p-2 rounded-lg <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'bg-blue-900 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white'; ?> transition duration-200">
                    <i class="fas fa-tachometer-alt w-6"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="pendaftar.php" class="flex items-center p-2 rounded-lg <?php echo basename($_SERVER['PHP_SELF']) === 'pendaftar.php' ? 'bg-blue-900 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white'; ?> transition duration-200">
                    <i class="fas fa-users w-6"></i>
                    <span>Pendaftar</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="change-password.php" class="flex items-center p-2 rounded-lg <?php echo basename($_SERVER['PHP_SELF']) === 'change-password.php' ? 'bg-blue-900 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white'; ?> transition duration-200">
                    <i class="fas fa-key w-6"></i>
                    <span>Ubah Password</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="login.php?logout=1" class="flex items-center p-2 rounded-lg hover:bg-red-600 text-blue-200 hover:text-white transition duration-200">
                    <i class="fas fa-sign-out-alt w-6"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
