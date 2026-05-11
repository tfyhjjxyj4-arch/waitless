<?php
include 'includes/db.php';
include 'includes/auth.php';
include 'includes/header.php';

// Fetch restaurant stats dynamically from the database
try {
    $stmt = $pdo->query("SELECT name, current_orders as orders, opening_time, closing_time FROM restaurants ORDER BY current_orders DESC");
    $restaurants_db = $stmt->fetchAll();
    
    // Mapping icons and colors (since these aren't in DB yet, we'll map them by name or just use defaults)
    $design_meta = [
        "مطعم السدة" => ["icon" => "fa-utensils", "color" => "#f59e0b", "trend" => "up"],
        "مطعم المجلس الخليجي" => ["icon" => "fa-bowl-food", "color" => "#10b981", "trend" => "stable"],
        "مطعم النخلة" => ["icon" => "fa-leaf", "color" => "#3b82f6", "trend" => "down"],
        "مطعم دار التمر" => ["icon" => "fa-seedling", "color" => "#8b5cf6", "trend" => "up"],
    ];

    $restaurants = [];
    foreach ($restaurants_db as $r) {
        $meta = $design_meta[$r['name']] ?? ["icon" => "fa-store", "color" => "#64748b", "trend" => "stable"];
        $restaurants[] = array_merge($r, $meta);
    }
} catch (PDOException $e) {
    $restaurants = []; // Fallback
}

$update_msg = false;
if (isset($_POST['update'])) {
    $update_msg = true;
}
?>

<div class="container" style="max-width: 900px; padding: 40px 20px;">
    <!-- Header Section -->
    <div style="text-align: center; margin-bottom: 50px;" data-aos="fade-up">
        <span style="background: rgba(245, 158, 11, 0.1); color: var(--accent); padding: 8px 20px; border-radius: var(--radius-full); font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 15px;">Live Statistics</span>
        <h2 style="font-size: clamp(2rem, 5vw, 2.8rem); margin-top: 0; margin-bottom: 10px; color: var(--primary);">📊 حالة الطلبات المباشرة</h2>
        <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">نظرة عامة على نشاط المطاعم في الوقت الحالي وتحديثات فورية لعدد الطلبات.</p>
    </div>

    <!-- Feedback Message -->
    <?php if ($update_msg): ?>
        <div class="alert alert-success" id="success-alert" style="animation: slideIn 0.5s ease-out;">
            <i class="fas fa-check-circle"></i>
            <span>تم تحديث البيانات اللحظية بنجاح! يتم الآن عرض أحدث الأرقام.</span>
        </div>
        <script>
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if(alert) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    alert.style.transition = 'all 0.5s ease';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 4000);
        </script>
    <?php endif; ?>

    <!-- Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 25px; margin-bottom: 50px;">
        <?php foreach($restaurants as $index => $r): ?>
            <div class="card stats-card" style="animation: fadeInUp 0.5s ease forwards; animation-delay: <?php echo $index * 0.1; ?>s; opacity: 0;">
                <div class="card-header-flex">
                    <div class="icon-box" style="background: <?php echo $r['color']; ?>15; color: <?php echo $r['color']; ?>;">
                        <i class="fas <?php echo $r['icon']; ?>"></i>
                    </div>
                    <div class="trend-badge <?php echo $r['trend']; ?>" title="اتجاه الطلبات">
                        <i class="fas <?php echo $r['trend'] == 'up' ? 'fa-arrow-trend-up' : ($r['trend'] == 'down' ? 'fa-arrow-trend-down' : 'fa-minus'); ?>"></i>
                        <span><?php echo $r['trend'] == 'up' ? 'متزايد' : ($r['trend'] == 'down' ? 'متناقص' : 'مستقر'); ?></span>
                    </div>
                </div>
                
                <div class="card-body-content">
                    <h3 style="font-size: 1.5rem; margin-bottom: 5px; color: var(--primary);"><?php echo $r["name"]; ?></h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 25px;">تحديث تلقائي كل 5 دقائق</p>
                    
                    <div class="stats-data">
                        <div class="stat-item">
                            <span class="stat-value"><?php echo $r["orders"]; ?></span>
                            <span class="stat-label">طلب نشط</span>
                        </div>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: <?php echo min(($r['orders'] / 20) * 100, 100); ?>%; background: <?php echo $r['color']; ?>;"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Action Buttons -->
    <div class="action-footer">
        <form method="post" style="flex: 1; max-width: 350px;">
            <button type="submit" name="update" class="btn-primary" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 12px; height: 55px;">
                <i class="fas fa-sync-alt rotate-icon"></i>
                تحديث البيانات اللحظية
            </button>
        </form>

        <a href="index.php" class="btn-secondary-outline">
            <i class="fas fa-home"></i>
            العودة للرئيسية
        </a>
    </div>
</div>

<style>
/* Animations */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
    from { transform: translateX(50px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

/* Card Styling */
.stats-card {
    text-align: right;
    padding: 30px;
    border: 1px solid rgba(0,0,0,0.05);
    background: var(--white);
    display: flex;
    flex-direction: column;
    gap: 15px;
    position: relative;
    overflow: hidden;
    transition: var(--transition);
}

.stats-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
    border-color: rgba(245, 158, 11, 0.2);
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 5px;
    height: 100%;
    background: transparent;
    transition: var(--transition);
}

.stats-card:hover::before {
    background: var(--accent);
}

.card-header-flex {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.icon-box {
    width: 65px;
    height: 65px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    box-shadow: inset 0 0 15px rgba(0,0,0,0.02);
}

.trend-badge {
    padding: 6px 14px;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
}
.trend-badge.up { background: #ecfdf5; color: #10b981; }
.trend-badge.down { background: #fef2f2; color: #ef4444; }
.trend-badge.stable { background: #eff6ff; color: #3b82f6; }

.stats-data {
    margin-top: 10px;
}

.stat-item {
    display: flex;
    align-items: baseline;
    gap: 10px;
    margin-bottom: 15px;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1;
}

.stat-label {
    color: var(--text-muted);
    font-weight: 600;
    font-size: 1.1rem;
}

.stat-progress {
    width: 100%;
    height: 10px;
    background: #f1f5f9;
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    border-radius: 10px;
    transition: width 1.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* Footer Actions */
.action-footer {
    display: flex; 
    gap: 20px; 
    justify-content: center; 
    flex-wrap: wrap;
    margin-top: 20px;
}

.btn-secondary-outline {
    flex: 1;
    max-width: 350px;
    padding: 0 40px;
    height: 55px;
    border-radius: var(--radius-full);
    border: 2px solid #e2e8f0;
    font-weight: 700;
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: var(--transition);
}

.btn-secondary-outline:hover {
    background: #f8fafc;
    border-color: var(--accent);
    color: var(--accent);
    transform: translateY(-3px);
}

.rotate-icon {
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

button:hover .rotate-icon {
    transform: rotate(360deg);
}

@media (max-width: 768px) {
    .action-footer {
        flex-direction: column;
        align-items: center;
    }
    .action-footer form, .btn-secondary-outline {
        max-width: 100%;
        width: 100%;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
