<?php
include 'includes/db.php';
include 'includes/auth.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "كلمات المرور غير متطابقة";
    } else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "هذا البريد الإلكتروني مسجل بالفعل";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, 'customer')");
            if ($stmt->execute([$name, $email, $phone, $hashed_password])) {
                $success = "تم إنشاء الحساب بنجاح! يمكنك الآن تسجيل الدخول.";
            } else {
                $error = "حدث خطأ أثناء التسجيل، يرجى المحاولة لاحقاً.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب - WaitLess</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('assets/images/hero-bg.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        .register-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            width: 100%;
            max-width: 550px;
        }
    </style>
</head>
<body>

<div class="register-card">
    <div style="text-align: center; margin-bottom: 2rem;">
        <a href="index.php" style="font-size: 2rem; font-weight: 700; color: var(--primary); display: block; margin-bottom: 10px;">
            <i class="fas fa-utensils" style="color: var(--accent);"></i> WaitLess
        </a>
        <h2 style="color: var(--primary); font-size: 1.5rem;">إنشاء حساب جديد</h2>
        <p style="color: var(--text-muted);">انضم إلينا واستمتع بتجربة حجز فريدة</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label><i class="fas fa-user"></i> الاسم الكامل</label>
            <input type="text" name="name" class="form-control" placeholder="أدخل اسمك الكامل" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-phone"></i> رقم الجوال</label>
            <input type="text" name="phone" class="form-control" placeholder="05xxxxxxxx" required>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div class="form-group">
                <label><i class="fas fa-lock"></i> كلمة المرور</label>
                <input type="password" name="password" class="form-control" placeholder="********" required>
            </div>
            <div class="form-group">
                <label><i class="fas fa-shield-alt"></i> التأكيد</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="********" required>
            </div>
        </div>
        <button type="submit" class="btn-primary" style="width: 100%; margin-top: 10px;">إنشاء الحساب</button>
    </form>
    
    <div style="text-align: center; margin-top: 2rem; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
        <p style="color: var(--text-muted);">لديك حساب بالفعل؟ <a href="login.php" style="color: var(--accent); font-weight: 700;">سجل دخولك</a></p>
        <p style="margin-top: 1rem;"><a href="index.php" style="color: var(--primary); font-weight: 500; font-size: 0.9rem;"><i class="fas fa-arrow-right"></i> العودة للرئيسية</a></p>
    </div>
</div>

</body>
</html>