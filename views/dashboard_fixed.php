<?php
// منع الوصول المباشر للملف
if (!defined('BASEPATH')) {
    exit('لا يمكن الوصول المباشر لهذا الملف');
}

// تعيين عنوان الصفحة
$page_title = 'لوحة التحكم';
?>

<div class="container-fluid py-4">
    <!-- ترويسة الصفحة -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">لوحة التحكم</h1>
        <div>
            <span class="text-muted"><?php echo date('l, d F Y'); ?></span>
        </div>
    </div>
    
    <!-- بطاقات الإحصائيات -->
    <div class="row mb-4">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">العملاء</h5>
                    <p class="card-text display-4">0</p>
                    <p class="card-text">عملاء جدد: 0</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">الفعاليات</h5>
                    <p class="card-text display-4">0</p>
                    <p class="card-text">قادمة: 0 | اليوم: 0</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">المدفوعات</h5>
                    <p class="card-text display-4">0 ريال</p>
                    <p class="card-text">مستحقة: 0 ريال</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">نبذة سريعة</h5>
                    <ul class="list-unstyled">
                        <li>عدد المستخدمين: 0</li>
                        <li>آخر تسجيل دخول: <?php echo date('Y-m-d H:i:s'); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- روابط سريعة -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">روابط سريعة</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="<?php echo create_url('customers', 'add'); ?>" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-user-plus"></i> إضافة عميل
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?php echo create_url('events', 'add'); ?>" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-calendar-plus"></i> إضافة فعالية
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?php echo create_url('payments', 'add'); ?>" class="btn btn-info btn-lg w-100">
                                <i class="fas fa-money-bill-wave"></i> تسجيل دفعة
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?php echo create_url('reports'); ?>" class="btn btn-warning btn-lg w-100">
                                <i class="fas fa-chart-bar"></i> التقارير
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- الفعاليات القادمة وآخر المهام -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">الفعاليات القادمة</h5>
                </div>
                <div class="card-body">
                    <p class="text-center py-5 text-muted">
                        <i class="fas fa-calendar fa-3x mb-3"></i><br>
                        لا توجد فعاليات قادمة في الوقت الحالي.
                    </p>
                    <a href="<?php echo create_url('events'); ?>" class="btn btn-sm btn-primary">عرض جميع الفعاليات</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">آخر المهام</h5>
                </div>
                <div class="card-body">
                    <p class="text-center py-5 text-muted">
                        <i class="fas fa-tasks fa-3x mb-3"></i><br>
                        لا توجد مهام في الوقت الحالي.
                    </p>
                    <a href="<?php echo create_url('tasks'); ?>" class="btn btn-sm btn-primary">عرض جميع المهام</a>
                </div>
            </div>
        </div>
    </div>
</div>