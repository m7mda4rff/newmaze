<?php
// منع الوصول المباشر للملف
if (!defined('BASEPATH')) {
    exit('لا يمكن الوصول المباشر لهذا الملف');
}

// تعيين عنوان الصفحة
$page_title = 'لوحة التحكم';

// الحصول على معلومات المستخدم الحالي
$current_user = User::getCurrentUser();
$user_name = $current_user ? $current_user->getName() : 'زائر';
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">مرحباً بك في نظام ميز للضيافة</h5>
                </div>
                <div class="card-body">
                    <p>مرحباً <?php echo $user_name; ?>!</p>
                    <p>أنت الآن في لوحة التحكم الرئيسية للنظام.</p>
                    
                    <h4>معلومات النظام:</h4>
                    <ul>
                        <li>الإصدار: <?php echo APP_VERSION; ?></li>
                        <li>تاريخ تسجيل الدخول: <?php echo date(DATETIME_FORMAT); ?></li>
                    </ul>
                    
                    <h4>روابط سريعة:</h4>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="<?php echo create_url('customers'); ?>" class="btn btn-outline-primary w-100">
                                <i class="fas fa-users"></i> إدارة العملاء
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?php echo create_url('events'); ?>" class="btn btn-outline-success w-100">
                                <i class="fas fa-calendar-alt"></i> إدارة الفعاليات
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?php echo create_url('costs'); ?>" class="btn btn-outline-info w-100">
                                <i class="fas fa-money-bill-wave"></i> إدارة التكاليف
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?php echo create_url('reports'); ?>" class="btn btn-outline-warning w-100">
                                <i class="fas fa-chart-bar"></i> التقارير
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>