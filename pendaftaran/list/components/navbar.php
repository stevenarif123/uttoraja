<?php
$currentUser = $auth->currentUser();
?>
<header class="bg-white shadow-sm py-4 px-6 sticky top-0 z-30">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800"><?php echo $pageTitle ?? 'Dashboard'; ?></h2>
        
        <div class="flex items-center">
            <div class="mr-4 text-sm text-gray-600">
                <i class="fas fa-user-circle mr-1"></i>
                <?php echo htmlspecialchars($currentUser['name']); ?>
            </div>
            <a href="/uttoraja/login.php?logout=1" class="text-red-500 hover:text-red-700">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</header>
