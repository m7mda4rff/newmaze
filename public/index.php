<?php
/**
 * نقطة الدخول الرئيسية لنظام ميز للضيافة
 */

// تحديد مسار القاعدة للنظام
define('BASEPATH', dirname(__DIR__));


// تحميل ملفات الإعدادات
require_once BASEPATH . '/config/config.php';
require_once BASEPATH . '/includes/functions.php';
require_once BASEPATH . '/includes/session.php';

// تحميل الفئات المطلوبة
require_once CLASSES_PATH . '/Database.php';
require_once CLASSES_PATH . '/User.php';
// تحميل ملف التحقق من الصلاحيات
require_once INCLUDES_PATH . '/auth.php';


// تحميل وتهيئة الجلسة
session_start();
if (!isset($_SESSION[SESSION_NAME])) {
    $_SESSION[SESSION_NAME] = [];
}

// تهيئة المتغيرات العامة
$errors = [];
$success = [];

// التعامل مع الطلبات
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// التحقق من تسجيل الدخول
$user = User::getCurrentUser();
$is_logged_in = ($user !== null && $user->isLoggedIn());

// توجيه المستخدم إلى صفحة تسجيل الدخول إذا لم يكن مسجل الدخول
if (!$is_logged_in && $page != 'login') {
    header('Location: ' . BASE_URL . '/public/index.php?page=login');
    exit;
}

// تحديد المسار الصحيح للصفحة
switch ($page) {
    case 'login':
        $page_path = VIEWS_PATH . '/login.php';
        break;
    case 'dashboard':
        $page_path = VIEWS_PATH . '/dashboard_fixed.php';
        break;
    case 'customers':
        $page_path = VIEWS_PATH . '/customers/' . $action . '.php';
        break;
    case 'events':
        $page_path = VIEWS_PATH . '/events/' . $action . '.php';
        break;
    case 'costs':
        $page_path = VIEWS_PATH . '/costs/' . $action . '.php';
        break;
    case 'payments':
        $page_path = VIEWS_PATH . '/payments/' . $action . '.php';
        break;
    case 'tasks':
        $page_path = VIEWS_PATH . '/tasks/' . $action . '.php';
        break;
    case 'reports':
        $page_path = VIEWS_PATH . '/reports/' . $action . '.php';
        break;
    case 'settings':
        $page_path = VIEWS_PATH . '/settings/' . $action . '.php';
        break;
    case 'logout':
        // تسجيل الخروج وإعادة التوجيه
        if ($user) {
            $user->logout();
        }
        header('Location: ' . BASE_URL . '/public/index.php?page=login');
        exit;
    default:
        $page_path = VIEWS_PATH . '/dashboard.php';
}

// التأكد من وجود الصفحة
if (!file_exists($page_path)) {
    // إذا لم يتم العثور على الصفحة، توجيه إلى لوحة التحكم
    header('Location: ' . BASE_URL . '/public/index.php?page=dashboard');
    exit;
}

// في حالة تسجيل الدخول، تحميل القالب مع الصفحة
if ($page == 'login') {
    include $page_path;
} else {
    // تحميل قالب الرأس
    include TEMPLATES_PATH . '/header.php';
    
    // تحميل القائمة الجانبية
    include TEMPLATES_PATH . '/sidebar.php';
    
    // تحميل المحتوى الرئيسي
    include $page_path;
    
    // تحميل قالب التذييل
    include TEMPLATES_PATH . '/footer.php';
}