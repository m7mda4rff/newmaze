<?php
/**
 * صفحة عرض تفاصيل العميل
 */

// منع الوصول المباشر للملف
if (!defined('BASEPATH')) {
    exit('لا يمكن الوصول المباشر لهذا الملف');
}

// التحقق من وجود معرف العميل
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION[SESSION_NAME]['error'] = 'معرف العميل غير صحيح';
    header('Location: ' . create_url('customers'));
    exit;
}

// الحصول على معرف العميل
$customer_id = (int) $_GET['id'];

// تضمين فئة العميل فقط
require_once CLASSES_PATH . '/Customer.php';

// إنشاء كائن العميل
$customer = new Customer();

// تحميل بيانات العميل
if (!$customer->loadCustomerById($customer_id)) {
    $_SESSION[SESSION_NAME]['error'] = 'العميل غير موجود';
    header('Location: ' . create_url('customers'));
    exit;
}

// تعيين عنوان الصفحة
$page_title = 'تفاصيل العميل: ' . $customer->getName();

// الحصول على اسم مصدر العميل
$source_name = '';
if ($customer->getSourceId()) {
    $source_name = $customer->getSourceName($customer->getSourceId());
}

// الحصول على اسم العميل المُوصي
$referral_customer_name = '';
if ($customer->getReferralCustomerId()) {
    $referral_customer = new Customer();
    if ($referral_customer->loadCustomerById($customer->getReferralCustomerId())) {
        $referral_customer_name = $referral_customer->getName();
    }
}

// تصنيف العميل
$category_labels = [
    'VIP' => '<span class="badge bg-danger">VIP</span>',
    'regular' => '<span class="badge bg-success">منتظم</span>',
    'new' => '<span class="badge bg-info">جديد</span>'
];
$category_label = isset($category_labels[$customer->getCategory()]) ? $category_labels[$customer->getCategory()] : '<span class="badge bg-secondary">غير محدد</span>';
?>

<div class="container-fluid py-4">
    <!-- ترويسة الصفحة -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">تفاصيل العميل</h1>
        <div>
            <a href="<?php echo create_url('customers', 'edit', ['id' => $customer_id]); ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> تعديل العميل
            </a>
            <a href="<?php echo create_url('customers'); ?>" class="btn btn-secondary ms-2">
                <i class="fas fa-list"></i> قائمة العملاء
            </a>
        </div>
    </div>
    
    <!-- معلومات العميل -->
    <div class="row">
        <div class="col-md-6">
            <!-- البطاقة الرئيسية للعميل -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">معلومات العميل</h5>
                        <?php echo $category_label; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h3 class="mb-0"><?php echo $customer->getName(); ?></h3>
                        <?php if ($customer->getPhone()): ?>
                            <p class="text-muted mb-0">
                                <i class="fas fa-phone me-2"></i>
                                <a href="tel:<?php echo $customer->getPhone(); ?>" class="text-decoration-none"><?php echo $customer->getPhone(); ?></a>
                            </p>
                        <?php endif; ?>
                        <?php if ($customer->getAltPhone()): ?>
                            <p class="text-muted mb-0">
                                <i class="fas fa-phone-alt me-2"></i>
                                <a href="tel:<?php echo $customer->getAltPhone(); ?>" class="text-decoration-none"><?php echo $customer->getAltPhone(); ?></a>
                            </p>
                        <?php endif; ?>
                        <?php if ($customer->getEmail()): ?>
                            <p class="text-muted mb-0">
                                <i class="fas fa-envelope me-2"></i>
                                <a href="mailto:<?php echo $customer->getEmail(); ?>" class="text-decoration-none"><?php echo $customer->getEmail(); ?></a>
                            </p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-info-circle me-2"></i>معلومات المصدر</h6>
                            <p class="text-muted mb-0">المصدر: <?php echo $source_name ? $source_name : 'غير محدد'; ?></p>
                            <?php if ($referral_customer_name): ?>
                                <p class="text-muted mb-0">العميل المُوصي: <?php echo $referral_customer_name; ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-map-marker-alt me-2"></i>العنوان</h6>
                            <p class="text-muted mb-0">
                                <?php echo $customer->getAddress() ? $customer->getAddress() : 'غير محدد'; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <small class="text-muted">تاريخ الإضافة: <?php echo date('Y-m-d H:i:s'); ?></small>
                </div>
            </div>
            
            <!-- ملاحظات العميل -->
            <?php if ($customer->getNotes()): ?>
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">ملاحظات</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0"><?php echo nl2br($customer->getNotes()); ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- فعاليات العميل (سنضيفها لاحقًا) -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">فعاليات العميل</h5>
                        <div>
                            <a href="<?php echo create_url('events', 'add', ['customer_id' => $customer_id]); ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus-circle"></i> إضافة فعالية
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-alt text-muted fa-3x mb-3"></i>
                        <h5 class="text-muted">لم يتم تفعيل وحدة الفعاليات بعد</h5>
                        <p class="text-muted mb-3">سيتم إظهار فعاليات العميل هنا بعد تفعيل وحدة الفعاليات</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- أزرار إضافية -->
    <div class="text-end mt-4">
        <a href="<?php echo create_url('customers'); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-right"></i> العودة إلى قائمة العملاء
        </a>
    </div>
</div>