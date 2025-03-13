<?php
// تحديد مسار القاعدة للنظام
define('BASEPATH', dirname(__DIR__));

// تحميل ملفات الإعدادات
require_once BASEPATH . '/config/config.php';
require_once BASEPATH . '/includes/session.php';

// بدء الجلسة
session_start();

// إنشاء جلسة وهمية لتسجيل الدخول (للاختبار فقط)
$_SESSION[SESSION_NAME]['user_id'] = 1;
$_SESSION[SESSION_NAME]['username'] = 'admin';
$_SESSION[SESSION_NAME]['name'] = 'مدير النظام';
$_SESSION[SESSION_NAME]['role'] = 'admin';
$_SESSION[SESSION_NAME]['login_time'] = time();

echo "<h2>تم إنشاء جلسة تسجيل دخول مؤقتة!</h2>";
echo "<p>انتقل إلى <a href='index.php'>لوحة التحكم</a></p>";