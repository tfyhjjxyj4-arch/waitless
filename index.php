<?php 
include 'includes/auth.php';
include 'includes/header.php'; 
?>

<section class="hero">
    <div class="hero-content">
        <h1>مرحباً بك في <span style="color: var(--accent);">WaitLess</span> 🍽️</h1>
        <p>انسَ الانتظار.. احجز طاولتك في أفضل المطاعم بضغطة زر واحدة 🚀</p>
        <div class="hero-btns">
            <?php if (isLoggedIn()): ?>
                <a href="reservations/add.php" class="btn-primary">احجز طاولتك الآن</a>
            <?php else: ?>
                <a href="register.php" class="btn-primary">ابدأ الآن - مجاناً</a>
            <?php endif; ?>
        </div>
        <div style="margin-top: 25px; animation: fadeInUp 1s ease-out;">
            <a href="restaurant_orders.php" style="color: rgba(255, 255, 255, 0.7); font-size: 0.9rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <span style="display: inline-block; width: 8px; height: 8px; background: #10b981; border-radius: 50%; box-shadow: 0 0 8px #10b981;"></span>
                عرض نشاط المطاعم المباشر الآن
            </a>
        </div>
    </div>
</section>

<section class="features container">
    <h2 style="text-align: center; margin-bottom: 10px;">لماذا تختار WaitLess؟</h2>
    <p style="text-align: center; color: var(--text-muted); margin-bottom: 50px;">نحن نغير طريقتك في اكتشاف وحجز المطاعم</p>
    
    <div class="feature-grid">
        <div class="card">
            <i class="fas fa-clock"></i>
            <h3>توفير الوقت</h3>
            <p>لا داعي للوقوف في طوابير الانتظار الطويلة أمام المطعم. احجز مسبقاً واضمن مكانك.</p>
        </div>
        <div class="card">
            <i class="fas fa-mobile-alt"></i>
            <h3>سهولة الاستخدام</h3>
            <p>واجهة بسيطة وعصرية تتيح لك العثور على أفضل المطاعم والحجز في ثوانٍ معدودة.</p>
        </div>
        <div class="card">
            <i class="fas fa-check-circle"></i>
            <h3>تأكيد فوري</h3>
            <p>احصل على تأكيد حجزك وإشعارات فورية على حسابك لضمان تجربة سلسة.</p>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>