<?php
/**
 * ملف إدارة الجلسات
 */

// منع الوصول المباشر للملف
if (!defined('BASEPATH')) {
    exit('لا يمكن الوصول المباشر لهذا الملف');
}

// تعيين معلمات الجلسة
ini_set('session.cookie_httponly', 1);   // منع الوصول لملف تعريف الارتباط عبر JavaScript
ini_set('session.use_only_cookies', 1);  // استخدام ملفات تعريف الارتباط فقط لتخزين معرف الجلسة
ini_set('session.cookie_secure', 0);     // تعيين إلى 1 إذا كان الموقع يستخدم HTTPS

// تعيين مدة الجلسة
ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
ini_set('session.cookie_lifetime', SESSION_LIFETIME);

/**
 * إنشاء جلسة جديدة
 * 
 * @return void
 */
function create_session() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION[SESSION_NAME])) {
        $_SESSION[SESSION_NAME] = [];
    }
}

/**
 * إنهاء الجلسة الحالية
 * 
 * @return void
 */
function destroy_session() {
    // تفريغ مصفوفة الجلسة
    $_SESSION[SESSION_NAME] = [];
    
    // إلغاء ملف تعريف الارتباط للجلسة
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // تدمير الجلسة
    session_destroy();
}

/**
 * التحقق من نشاط الجلسة وتحديث وقت آخر نشاط
 * 
 * @return bool
 */
function check_session_activity() {
    if (!isset($_SESSION[SESSION_NAME]) || empty($_SESSION[SESSION_NAME]['user_id'])) {
        return false;
    }
    
    // التحقق مما إذا كان المستخدم غير نشط لفترة طويلة
    if (isset($_SESSION[SESSION_NAME]['last_activity'])) {
        $inactive_time = time() - $_SESSION[SESSION_NAME]['last_activity'];
        
        if ($inactive_time > SESSION_LIFETIME) {
            destroy_session();
            return false;
        }
    }
    
    // تحديث وقت آخر نشاط
    $_SESSION[SESSION_NAME]['last_activity'] = time();
    
    return true;
}

// تهيئة الجلسة
create_session();

// التحقق من نشاط الجلسة
check_session_activity();