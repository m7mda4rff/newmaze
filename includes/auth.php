<?php
/**
 * ملف التحقق من الصلاحيات
 */

// منع الوصول المباشر للملف
if (!defined('BASEPATH')) {
    exit('لا يمكن الوصول المباشر لهذا الملف');
}

/**
 * التحقق من تسجيل دخول المستخدم
 * 
 * @return bool
 */
function is_logged_in() {
    $user = User::getCurrentUser();
    return ($user !== null && $user->isLoggedIn());
}

/**
 * التحقق من صلاحيات المستخدم
 * 
 * @param string|array $roles الأدوار المطلوبة
 * @return bool
 */
function has_permission($roles) {
    $user = User::getCurrentUser();
    
    if ($user === null || !$user->isLoggedIn()) {
        return false;
    }
    
    return $user->hasPermission($roles);
}

/**
 * التحقق من صلاحيات المستخدم وإعادة التوجيه إذا لم تكن لديه الصلاحية
 * 
 * @param string|array $roles الأدوار المطلوبة
 * @return void
 */
function require_permission($roles) {
    if (!has_permission($roles)) {
        // تخزين رسالة الخطأ في الجلسة
        $_SESSION[SESSION_NAME]['error'] = 'ليس لديك صلاحية للوصول إلى هذه الصفحة';
        
        // إعادة التوجيه إلى لوحة التحكم
        header('Location: ' . BASE_URL . '/public/index.php?page=dashboard');
        exit;
    }
}

/**
 * الحصول على دور المستخدم الحالي
 * 
 * @return string|null
 */
function get_current_user_role() {
    $user = User::getCurrentUser();
    
    if ($user === null || !$user->isLoggedIn()) {
        return null;
    }
    
    return $user->getRole();
}

/**
 * إنشاء زر إجراء مع التحقق من الصلاحيات
 * 
 * @param string $label نص الزر
 * @param string $url رابط الزر
 * @param string $class فئة CSS للزر
 * @param string|array $required_roles الأدوار المطلوبة
 * @return string كود HTML للزر
 */
function action_button($label, $url, $class = 'btn btn-primary', $required_roles = null) {
    // التحقق من الصلاحيات إذا تم تحديد الأدوار المطلوبة
    if ($required_roles !== null && !has_permission($required_roles)) {
        return '';
    }
    
    return '<a href="' . $url . '" class="' . $class . '">' . $label . '</a>';
}