<?php
/**
 * قالب القائمة الجانبية
 */

// منع الوصول المباشر للملف
if (!defined('BASEPATH')) {
    exit('لا يمكن الوصول المباشر لهذا الملف');
}

// الحصول على الصفحة الحالية
$current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!-- القائمة الجانبية -->
<div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>" href="<?php echo create_url('dashboard'); ?>">
                    <i class="fas fa-tachometer-alt"></i> لوحة التحكم
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'customers') ? 'active' : ''; ?>" href="<?php echo create_url('customers'); ?>">
                    <i class="fas fa-users"></i> العملاء
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'events') ? 'active' : ''; ?>" href="<?php echo create_url('events'); ?>">
                    <i class="fas fa-calendar-alt"></i> الفعاليات
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'costs') ? 'active' : ''; ?>" href="<?php echo create_url('costs'); ?>">
                    <i class="fas fa-money-bill-wave"></i> التكاليف
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'payments') ? 'active' : ''; ?>" href="<?php echo create_url('payments'); ?>">
                    <i class="fas fa-credit-card"></i> المدفوعات
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'tasks') ? 'active' : ''; ?>" href="<?php echo create_url('tasks'); ?>">
                    <i class="fas fa-tasks"></i> المهام
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'reports') ? 'active' : ''; ?>" href="<?php echo create_url('reports'); ?>">
                    <i class="fas fa-chart-bar"></i> التقارير
                </a>
            </li>
            
            <?php if (has_permission(['admin', 'manager'])): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'settings') ? 'active' : ''; ?>" href="<?php echo create_url('settings'); ?>">
                    <i class="fas fa-cog"></i> الإعدادات
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<!-- المحتوى الرئيسي -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php
    // عرض رسائل النجاح
    if (isset($_SESSION[SESSION_NAME]['success'])) {
        echo success_message($_SESSION[SESSION_NAME]['success']);
        unset($_SESSION[SESSION_NAME]['success']);
    }
    
    // عرض رسائل الخطأ
    if (isset($_SESSION[SESSION_NAME]['error'])) {
        echo error_message($_SESSION[SESSION_NAME]['error']);
        unset($_SESSION[SESSION_NAME]['error']);
    }
    ?>