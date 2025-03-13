<?php
/**
 * ملف الدوال المساعدة العامة للنظام
 */

// منع الوصول المباشر للملف
if (!defined('BASEPATH')) {
    exit('لا يمكن الوصول المباشر لهذا الملف');
}

/**
 * تنقية المدخلات من المحتوى الضار
 * 
 * @param string $input النص المراد تنقيته
 * @return string النص بعد التنقية
 */
 
function clean_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

/**
 * تحويل التاريخ إلى الصيغة المطلوبة
 * 
 * @param string $date التاريخ المراد تحويله
 * @param string $format صيغة التاريخ الجديدة
 * @return string التاريخ بالصيغة الجديدة
 */
function format_date($date, $format = DATE_FORMAT) {
    if (empty($date)) {
        return '';
    }
    
    $timestamp = strtotime($date);
    return date($format, $timestamp);
}

/**
 * تنسيق المبلغ المالي حسب إعدادات النظام
 * 
 * @param float $amount المبلغ المراد تنسيقه
 * @param bool $with_currency إضافة رمز العملة
 * @return string المبلغ منسقاً
 */
function format_amount($amount, $with_currency = true) {
    global $config;
    
    // تقريب المبلغ إلى العدد المحدد من الخانات العشرية
    $amount = round($amount, $config['decimal_places']);
    
    // تنسيق المبلغ
    $formatted = number_format($amount, $config['decimal_places'], $config['decimal_separator'], $config['thousand_separator']);
    
    // إضافة رمز العملة
    if ($with_currency) {
        if ($config['currency_position'] == 'before') {
            $formatted = $config['currency'] . ' ' . $formatted;
        } else {
            $formatted = $formatted . ' ' . $config['currency'];
        }
    }
    
    return $formatted;
}

/**
 * إنشاء رابط URL كامل
 * 
 * @param string $page اسم الصفحة
 * @param string $action الإجراء
 * @param array $params معلمات إضافية
 * @return string رابط URL كامل
 */
function create_url($page, $action = 'index', $params = []) {
    $url = BASE_URL . '/public/index.php?page=' . urlencode($page);
    
    if ($action != 'index') {
        $url .= '&action=' . urlencode($action);
    }
    
    if (!empty($params)) {
        foreach ($params as $key => $value) {
            $url .= '&' . urlencode($key) . '=' . urlencode($value);
        }
    }
    
    return $url;
}

/**
 * عرض رسالة نجاح
 * 
 * @param string $message نص الرسالة
 * @return string كود HTML للرسالة
 */
function success_message($message) {
    return '<div class="alert alert-success alert-dismissible fade show" role="alert">
              ' . $message . '
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>';
}

/**
 * عرض رسالة خطأ
 * 
 * @param string $message نص الرسالة
 * @return string كود HTML للرسالة
 */
function error_message($message) {
    return '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              ' . $message . '
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>';
}

/**
 * التحقق من صحة رقم الهاتف
 * 
 * @param string $phone رقم الهاتف
 * @return bool
 */
function is_valid_phone($phone) {
    // تنقية الرقم من أي حروف غير رقمية
    $clean_phone = preg_replace('/[^0-9]/', '', $phone);
    
    // التحقق من طول الرقم (يفترض أن رقم الهاتف السعودي 10 أرقام)
    return (strlen($clean_phone) >= 10 && strlen($clean_phone) <= 12);
}

/**
 * التحقق من صحة البريد الإلكتروني
 * 
 * @param string $email البريد الإلكتروني
 * @return bool
 */
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * إنشاء توكن CSRF للحماية
 * 
 * @return string
 */
function generate_csrf_token() {
    if (!isset($_SESSION[SESSION_NAME][CSRF_TOKEN_NAME])) {
        $_SESSION[SESSION_NAME][CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION[SESSION_NAME][CSRF_TOKEN_NAME];
}

/**
 * التحقق من صحة توكن CSRF
 * 
 * @param string $token التوكن المراد التحقق منه
 * @return bool
 */
function verify_csrf_token($token) {
    if (!isset($_SESSION[SESSION_NAME][CSRF_TOKEN_NAME])) {
        return false;
    }
    
    return hash_equals($_SESSION[SESSION_NAME][CSRF_TOKEN_NAME], $token);
}

/**
 * تسجيل خطأ في ملف السجل
 * 
 * @param string $message نص الرسالة
 * @param string $type نوع الخطأ
 * @return void
 */
function log_error($message, $type = 'ERROR') {
    if (defined('ENABLE_ERROR_LOG') && ENABLE_ERROR_LOG) {
        $log_message = '[' . date('Y-m-d H:i:s') . '] ' . $type . ': ' . $message . PHP_EOL;
        
        // إنشاء مجلد السجلات إذا لم يكن موجوداً
        if (!file_exists(LOG_PATH)) {
            mkdir(LOG_PATH, 0755, true);
        }
        
        // كتابة الخطأ في ملف السجل
        file_put_contents(LOG_PATH . '/error.log', $log_message, FILE_APPEND);
    }
}