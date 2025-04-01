<!-- Sidebar -->
<nav class="w-64 min-h-screen bg-gray-800 text-white p-4">
    <?php
    // Get the current page name
    $current_page = basename($_SERVER['PHP_SELF']);
    
    // Define menu structure for easier management
    $menu_items = [
        'admin.php' => ['title' => 'Dashboard', 'parent' => null],
        'register.php' => ['title' => 'Register User', 'parent' => 'Manage Users'],
        'view_users.php' => ['title' => 'View User', 'parent' => 'Manage Users'],
        'branch.php' => ['title' => 'Register Branch', 'parent' => 'Manage Branches'],
        'branches_view.php' => ['title' => 'View Branches', 'parent' => 'Manage Branches'],
        'item.php' => ['title' => 'Add Items', 'parent' => 'Manage Items'],
        'item_view.php' => ['title' => 'View Items', 'parent' => 'Manage Items'],
        'report.php' => ['title' => 'Sales Details', 'parent' => 'Sales']
    ];
    
    // Function to check if a menu item is active
    function isActive($page, $current_page, $menu_items) {
        if ($page === $current_page) return true;
        if (isset($menu_items[$page]['parent']) && isset($menu_items[$current_page]['parent'])) {
            return $menu_items[$page]['parent'] === $menu_items[$current_page]['parent'];
        }
        return false;
    }
    ?>
    <ul>
        <li class="py-2">
            <a href="admin.php" class="block hover:bg-gray-700 p-2 rounded <?php echo isActive('admin.php', $current_page, $menu_items) ? 'bg-green-600' : ''; ?>">Dashboard</a>
        </li>
        <li class="py-2 group">
            <a href="#" class="block hover:bg-gray-700 p-2 rounded <?php echo isActive('register.php', $current_page, $menu_items) ? 'bg-green-600' : ''; ?>">Manage Users</a>
            <ul class="hidden group-hover:block pl-4">
                <li><a href="register.php" class="block hover:bg-gray-700 p-2 rounded <?php echo isActive('register.php', $current_page, $menu_items) ? 'bg-green-600' : ''; ?>">Register User</a></li>
                <li><a href="view_users.php" class="block hover:bg-gray-700 p-2 rounded <?php echo isActive('view_users.php', $current_page, $menu_items) ? 'bg-green-600' : ''; ?>">View User</a></li>
            </ul>
        </li>
        <li class="py-2 group">
            <a href="#" class="block hover:bg-gray-700 p-2 rounded <?php echo isActive('branch.php', $current_page, $menu_items) ? 'bg-green-600' : ''; ?>">Manage Branches</a>
            <ul class="hidden group-hover:block pl-4">
                <li><a href="branch.php" class="block hover:bg-gray-700 p-2 rounded <?php echo isActive('branch.php', $current_page, $menu_items) ? 'bg-green-600' : ''; ?>">Register Branch</a></li>
                <li><a href="branches_view.php" class="block hover:bg-gray-700 p-2 rounded <?php echo isActive('branches_view.php', $current_page, $menu_items) ? 'bg-green-600' : ''; ?>">View Branches</a></li>
            </ul>
        </li>
        <li class="py-2 group">
            <a href="#" class="block hover:bg-gray-700 p-2 rounded <?php echo isActive('item.php', $current_page, $menu_items) ? 'bg-green-600' : ''; ?>">Manage Items</a>
            <ul class="hidden group-hover:block pl-4">
                <li><a href="item.php" class="block hover:bg-gray-700 p-2 rounded <?php echo isActive('item.php', $current_page, $menu_items) ? 'bg-green-600' : ''; ?>">Add Items</a></li>
                <li><a href="item_view.php" class="block hover:bg-gray-700 p-2 rounded <?php echo isActive('item_view.php', $current_page, $menu_items) ? 'bg-green-600' : ''; ?>">View Items</a></li>
            </ul>
        </li>
        <li class="py-2 group">
            <a href="#" class="block hover:bg-gray-700 p-2 rounded <?php echo isActive('report.php', $current_page, $menu_items) ? 'bg-green-600' : ''; ?>">Sales</a>
            <ul class="hidden group-hover:block pl-4">
                <li><a href="report.php" class="block hover:bg-gray-700 p-2 rounded <?php echo isActive('report.php', $current_page, $menu_items) ? 'bg-green-600' : ''; ?>">Sales Details</a></li>
            </ul>
        </li>
    </ul>
</nav> 