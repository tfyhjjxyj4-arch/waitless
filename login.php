<?php
include 'includes/db.php';
include 'includes/auth.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['restaurant_id'] = $user['restaurant_id'];

        if ($user['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } elseif ($user['role'] == 'receptionist') {
            header("Location: staff/dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    } else {
        $error = "بيانات الدخول غير صحيحة";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - WaitLess</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('assets/images/hero-bg.png');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            width: 100%;
            max-width: 450px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div style="text-align: center; margin-bottom: 2.5rem;">
        <a href="index.php" style="font-size: 2rem; font-weight: 700; color: var(--primary); display: block; margin-bottom: 10px;">
            <i class="fas fa-utensils" style="color: var(--accent);"></i> WaitLess
        </a>
        <h2 style="color: var(--primary); font-size: 1.5rem;">تسجيل الدخول</h2>
        <p style="color: var(--text-muted);">مرحباً بك مجدداً في نظامنا الذكي</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-lock"></i> كلمة المرور</label>
            <input type="password" name="password" class="form-control" placeholder="********" required>
        </div>
        <button type="submit" class="btn-primary" style="width: 100%; margin-top: 10px;">دخول آمن</button>
    </form>
    
    <div style="text-align: center; margin-top: 2rem; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
        <p style="color: var(--text-muted);">ليس لديك حساب؟ <a href="register.php" style="color: var(--accent); font-weight: 700;">سجل الآن مجاناً</a></p>
        <p style="margin-top: 1rem;"><a href="index.php" style="color: var(--primary); font-weight: 500; font-size: 0.9rem;"><i class="fas fa-arrow-right"></i> العودة للرئيسية</a></p>
    </div>
</div>

</body>
</html>