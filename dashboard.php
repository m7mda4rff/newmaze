<?php
/**
 * صفحة لوحة التحكم الرئيسية - بتصميم مودرن
 */

// منع الوصول المباشر للملف
if (!defined('BASEPATH')) {
    exit('لا يمكن الوصول المباشر لهذا الملف');
}

// تعيين عنوان الصفحة
$page_title = 'لوحة التحكم';

// الحصول على معلومات المستخدم الحالي
$current_user = User::getCurrentUser();
$user_name = $current_user ? $current_user->getName() : 'زائر';

// في المستقبل سيتم استرجاع هذه البيانات من قاعدة البيانات
// بيانات إحصائية مؤقتة للعرض
$stats = [
    'customers' => [
        'total' => 0,
        'new' => 0
    ],
    'events' => [
        'total' => 0,
        'upcoming' => 0,
        'today' => 0
    ],
    'payments' => [
        'total' => 0,
        'pending' => 0
    ]
];

// الفعاليات القادمة (مؤقتة)
$upcoming_events = [];
?>

<!-- CSS إضافي للوحة التحكم -->
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        padding: 2rem;
        border-radius: 12px;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    .stats-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .stats-icon {
        font-size: 3rem;
        opacity: 0.2;
        position: absolute;
        bottom: -10px;
        right: 10px;
    }
    
    .stats-value {
        font-size: 2.5rem;
        font-weight: 700;
    }
    
    .quick-link-card {
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        height: 100%;
    }
    
    .quick-link-card:hover {
        transform: translateY(-5px);
    }
    
    .quick-link-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .card-header {
        font-weight: 600;
        padding: 1rem 1.5rem;
    }
    
    .activity-item {
        padding: 1rem;
        border-bottom: 1px solid #f1f1f1;
        transition: background-color 0.2s;
    }
    
    .activity-item:hover {
        background-color: #f8f9fa;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .welcome-text {
        font-size: 1.8rem;
        font-weight: 700;
    }
    
    .welcome-subtext {
        opacity: 0.8;
        font-size: 1.1rem;
    }
</style>

<div class="container-fluid py-4">
    <!-- ترويسة لوحة التحكم -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="welcome-text mb-2">مرحباً، <?php echo $user_name; ?></h1>
                <p class="welcome-subtext mb-0">
                    مرحباً بك في نظام ميز للضيافة - لوحة التحكم الرئيسية
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0"><?php echo date('l, d F Y'); ?></p>
                <p class="mb-0"><?php echo APP_VERSION; ?></p>
            </div>
        </div>
    </div>
    
    <!-- بطاقات الإحصائيات -->
    <div class="row mb-4">
        <div class="col-md-3 mb-4">
            <div class="stats-card bg-primary text-white">
                <div class="card-body p-4 position-relative">
                    <h6 class="card-title mb-3">إجمالي العملاء</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="stats-value mb-1"><?php echo $stats['customers']['total']; ?></h2>
                            <p class="mb-0">عملاء جدد: <?php echo $stats['customers']['new']; ?></p>
                        </div>
                    </div>
                    <i class="fas fa-users stats-icon"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="stats-card bg-success text-white">
                <div class="card-body p-4 position-relative">
                    <h6 class="card-title mb-3">الفعاليات</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="stats-value mb-1"><?php echo $stats['events']['total']; ?></h2>
                            <p class="mb-0">
                                قادمة: <?php echo $stats['events']['upcoming']; ?> | 
                                اليوم: <?php echo $stats['events']['today']; ?>
                            </p>
                        </div>
                    </div>
                    <i class="fas fa-calendar-alt stats-icon"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="stats-card bg-info text-white">
                <div class="card-body p-4 position-relative">
                    <h6 class="card-title mb-3">الإيرادات</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="stats-value mb-1"><?php echo format_amount($stats['payments']['total']); ?></h2>
                            <p class="mb-0">مستحقة: <?php echo format_amount($stats['payments']['pending']); ?></p>
                        </div>
                    </div>
                    <i class="fas fa-money-bill-wave stats-icon"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="stats-card bg-warning text-white">
                <div class="card-body p-4 position-relative">
                    <h6 class="card-title mb-3">التكاليف</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="stats-value mb-1">0</h2>
                            <p class="mb-0">هذا الشهر</p>
                        </div>
                    </div>
                    <i class="fas fa-receipt stats-icon"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- روابط سريعة -->
    <div class="row mb-4">
        <div class="col-12 mb-4">
            <h5 class="mb-3">روابط سريعة</h5>
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <div class="quick-link-card">
                        <a href="<?php echo create_url('customers', 'add'); ?>" class="text-decoration-none">
                            <div class="card-body p-4">
                                <div class="quick-link-icon text-primary">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <h6 class="mb-0">إضافة عميل</h6>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="col-md-3 col-6">
                    <div class="quick-link-card">
                        <a href="<?php echo create_url('events', 'add'); ?>" class="text-decoration-none">
                            <div class="card-body p-4">
                                <div class="quick-link-icon text-success">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <h6 class="mb-0">إضافة فعالية</h6>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="col-md-3 col-6">
                    <div class="quick-link-card">
                        <a href="<?php echo create_url('payments', 'add'); ?>" class="text-decoration-none">
                            <div class="card-body p-4">
                                <div class="quick-link-icon text-info">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <h6 class="mb-0">تسجيل مدفوعات</h6>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="col-md-3 col-6">
                    <div class="quick-link-card">
                        <a href="<?php echo create_url('reports', 'financial'); ?>" class="text-decoration-none">
                            <div class="card-body p-4">
                                <div class="quick-link-icon text-warning">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                                <h6 class="mb-0">التقارير</h6>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- الفعاليات القادمة وآخر المهام -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">الفعاليات القادمة</h5>
                        <a href="<?php echo create_url('events'); ?>" class="btn btn-sm btn-primary">
                            عرض الكل
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($upcoming_events)): ?>
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-calendar-day text-muted fa-4x"></i>
                            </div>
                            <h5 class="text-muted">لا توجد فعاليات قادمة</h5>
                            <a href="<?php echo create_url('events', 'add'); ?>" class="btn btn-sm btn-primary mt-2">
                                <i class="fas fa-plus-circle me-1"></i>
                                إضافة فعالية جديدة
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($upcoming_events as $event): ?>
                                <div class="activity-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="mb-1"><?php echo $event['title']; ?></h6>
                                            <small class="text-muted mb-0">
                                                <i class="fas fa-user me-1"></i> <?php echo $event['customer_name']; ?>
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <div class="mb-1">
                                                <span class="badge bg-primary"><?php echo $event['status_name']; ?></span>
                                            </div>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i> 
                                                <?php echo format_date($event['date']); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">آخر النشاطات</h5>
                        <a href="<?php echo create_url('tasks'); ?>" class="btn btn-sm btn-primary">
                            المهام
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-tasks text-muted fa-4x"></i>
                        </div>
                        <h5 class="text-muted">لا توجد نشاطات حديثة</h5>
                        <p class="text-muted">ستظهر هنا آخر النشاطات في النظام</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- إحصائيات إضافية -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">نظرة عامة على الأداء</h5>
                        <div>
                            <select class="form-select form-select-sm">
                                <option selected>آخر 30 يوم</option>
                                <option>هذا الشهر</option>
                                <option>هذا العام</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-chart-line text-muted fa-4x"></i>
                    </div>
                    <h5 class="text-muted">البيانات غير متوفرة</h5>
                    <p class="text-muted mb-4">ستظهر إحصائيات الأداء هنا بمجرد توفر البيانات</p>
                    <a href="<?php echo create_url('reports', 'financial'); ?>" class="btn btn-primary">
                        <i class="fas fa-chart-bar me-1"></i>
                        عرض التقارير التفصيلية
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</div>

<!-- إضافة المخططات (في المستقبل) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // هنا يمكن إضافة كود لإنشاء المخططات باستخدام Chart.js عندما تتوفر البيانات
});
</script>