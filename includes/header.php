<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WaitLess - نظام حجز المطاعم الاحترافي</title>
    <?php
    $base_path = (str_contains($_SERVER['PHP_SELF'], '/admin/') || str_contains($_SERVER['PHP_SELF'], '/staff/') || str_contains($_SERVER['PHP_SELF'], '/reservations/')) ? '../' : '';
    ?>
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<header class="main-header">
    <a href="<?php echo $base_path; ?>index.php" class="logo">
        <i class="fas fa-utensils"></i>
        <span>WaitLess</span>
    </a>

    <nav>
        <ul>
            <li><a href="<?php echo $base_path; ?>index.php">الرئيسية</a></li>
            <li><a href="<?php echo $base_path; ?>restaurant_orders.php">نشاط المطاعم</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['role'] === 'customer'): ?>
                    <li><a href="<?php echo $base_path; ?>dashboard.php">لوحتي</a></li>
                    <li><a href="<?php echo $base_path; ?>reservations/add.php" class="btn-primary" style="padding: 10px 20px; font-size: 0.9rem; box-shadow: none;">حجز جديد</a></li>
                <?php elseif ($_SESSION['role'] === 'admin'): ?>
                    <li><a href="<?php echo $base_path; ?>admin/dashboard.php">لوحة الإدارة</a></li>
                <?php elseif ($_SESSION['role'] === 'receptionist'): ?>
                    <li><a href="<?php echo $base_path; ?>staff/dashboard.php">لوحة الموظف</a></li>
                <?php endif; ?>
                <li><a href="<?php echo $base_path; ?>logout.php" style="color: #ff4d4d;"><i class="fas fa-sign-out-alt"></i> خروج</a></li>
            <?php else: ?>
                <li><a href="login.php">دخول</a></li>
                <li><a href="register.php" class="btn-primary" style="padding: 10px 20px; font-size: 0.9rem; box-shadow: none;">انضم إلينا</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main class="content-wrapper" style="min-height: 70vh; padding-top: 40px;">