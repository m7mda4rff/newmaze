<?php
/**
 * صفحة تسجيل الدخول
 */

// منع الوصول المباشر للملف
if (!defined('BASEPATH')) {
    exit('لا يمكن الوصول المباشر لهذا الملف');
}

// معالجة نموذج تسجيل الدخول
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // التحقق من CSRF
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        $error = 'خطأ في التحقق من الطلب. يرجى إعادة المحاولة.';
    } else {
        // الحصول على بيانات النموذج
        $username = isset($_POST['username']) ? clean_input($_POST['username']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        
        // التحقق من البيانات
        if (empty($username) || empty($password)) {
            $error = 'يرجى إدخال اسم المستخدم وكلمة المرور';
        } else {
            // محاولة تسجيل الدخول
            $user = new User();
            
            if ($user->login($username, $password)) {
                // تسجيل الدخول بنجاح، إعادة التوجيه إلى لوحة التحكم
                header('Location: ' . BASE_URL . '/public/index.php?page=dashboard');
                exit;
            } else {
                $error = 'اسم المستخدم أو كلمة المرور غير صحيحة';
            }
        }
    }
}

// إنشاء توكن CSRF جديد
$csrf_token = generate_csrf_token();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - <?php echo APP_NAME; ?></title>
    
    <!-- CSS Bootstrap RTL -->
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/css/bootstrap.rtl.min.css">
    
    <!-- CSS الخاص بالنظام -->
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/css/style.css">
    
    <style>
        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
            height: 100vh;
        }
        
        .form-signin {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            margin: auto;
        }
        
        .form-signin .form-floating:focus-within {
            z-index: 2;
        }
        
        .form-signin input[type="text"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        
        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
        
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <main class="form-signin text-center">
        <form method="post" action="<?php echo BASE_URL; ?>/public/index.php?page=login">
            <img class="logo" src="<?php echo ASSETS_PATH; ?>/images/logo.png" alt="<?php echo APP_NAME; ?>">
            <h1 class="h3 mb-3 fw-normal">تسجيل الدخول</h1>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="form-floating">
                <input type="text" class="form-control" id="username" name="username" placeholder="اسم المستخدم" required>
                <label for="username">اسم المستخدم</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="كلمة المرور" required>
                <label for="password">كلمة المرور</label>
            </div>
            
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <button class="w-100 btn btn-lg btn-primary" type="submit">تسجيل الدخول</button>
            <p class="mt-5 mb-3 text-muted">&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?></p>
        </form>
    </main>
    
    <!-- جافاسكريبت Bootstrap -->
    <script src="<?php echo ASSETS_PATH; ?>/js/bootstrap.bundle.min.js"></script>
</body>
</html>