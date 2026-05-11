<?php
include 'includes/db.php';
include 'includes/auth.php';
requireLogin();

if (hasRole('admin')) {
    header("Location: admin/dashboard.php");
    exit();
} elseif (hasRole('receptionist')) {
    header("Location: staff/dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch reservations
$stmt = $pdo->prepare("
    SELECT r.*, rest.name as restaurant_name 
    FROM reservations r 
    JOIN restaurants rest ON r.restaurant_id = rest.restaurant_id 
    WHERE r.user_id = ? 
    ORDER BY r.reservation_date DESC, r.reservation_time DESC
");
$stmt->execute([$user_id]);
$reservations = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="container">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error" style="margin-bottom: 20px;">
            <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" style="margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1>لوحة التحكم</h1>
            <p style="color: var(--text-muted);">مرحباً بك مجدداً، <?php echo $_SESSION['user_name']; ?> 👋</p>
        </div>
        <a href="reservations/add.php" class="btn-primary"><i class="fas fa-plus"></i> حجز جديد</a>
    </div>

    <div class="card" style="margin-bottom: 40px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white;">
        <h3 style="color: white; margin-bottom: 10px;">نظرة عامة</h3>
        <p style="color: rgba(255,255,255,0.8);">لديك إجمالي <?php echo count($reservations); ?> حجوزات في سجلاتنا.</p>
    </div>

    <div class="card">
        <h3 style="margin-bottom: 25px;"><i class="fas fa-calendar-alt" style="color: var(--accent);"></i> حجوزاتي الأخيرة</h3>
        <?php if (empty($reservations)): ?>
            <div style="text-align: center; padding: 40px;">
                <i class="fas fa-calendar-times fa-4x" style="color: #cbd5e1; margin-bottom: 20px;"></i>
                <p>ليس لديك أي حجوزات حالياً.</p>
                <a href="reservations/add.php" style="color: var(--accent); font-weight: 600; margin-top: 10px; display: inline-block;">احجز طاولتك الأولى الآن!</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>المطعم</th>
                            <th>التاريخ</th>
                            <th>الوقت</th>
                            <th>عدد الأفراد</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $res): ?>
                            <tr>
                                <td style="font-weight: 600;"><?php echo $res['restaurant_name']; ?></td>
                                <td><?php echo $res['reservation_date']; ?></td>
                                <td><?php echo $res['reservation_time']; ?></td>
                                <td><?php echo $res['number_of_people']; ?> فرد</td>
                                <td>
                                    <?php 
                                    $status_class = "status-" . $res['status'];
                                    $status_text = [
                                        'pending' => 'قيد الانتظار',
                                        'confirmed' => 'مؤكد',
                                        'cancelled' => 'ملغي',
                                        'completed' => 'مكتمل'
                                    ][$res['status']];
                                    echo "<span class='status {$status_class}'>{$status_text}</span>";
                                    ?>
                                </td>
                                <td>
                                    <?php if ($res['status'] == 'pending'): ?>
                                        <a href="reservations/cancel.php?id=<?php echo $res['reservation_id']; ?>" 
                                           style="color: #ef4444; font-weight: 600;" 
                                           onclick="return confirm('هل أنت متأكد من إلغاء الحجز؟')">
                                           <i class="fas fa-times-circle"></i> إلغاء
                                        </a>
                                    <?php else: ?>
                                        <span style="color: #cbd5e1;">--</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>