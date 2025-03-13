<?php
// تحديد مسار القاعدة
define('BASEPATH', dirname(__DIR__));

// تهيئة الجلسة
session_start();
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم المستقلة</title>
    
    <!-- CDN لـ Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    
    <!-- CDN لـ Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f5f5f5;
        }
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
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .sidebar {
            background-color: #fff;
            height: 100vh;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: #333;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
        }
        .sidebar .nav-link.active {
            background-color: #007bff;
            color: white;
        }
        .main-content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- شريط التنقل العلوي -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ميز للضيافة</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> مدير النظام
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">الملف الشخصي</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="index.php?page=logout">تسجيل الخروج</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- القائمة الجانبية -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-tachometer-alt me-2"></i> لوحة التحكم
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-users me-2"></i> العملاء
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-calendar-alt me-2"></i> الفعاليات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-money-bill-wave me-2"></i> التكاليف
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-credit-card me-2"></i> المدفوعات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-tasks me-2"></i> المهام
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-bar me-2"></i> التقارير
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog me-2"></i> الإعدادات
                        </a>
                    </li>
                </ul>
            </div>

            <!-- المحتوى الرئيسي -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- ترويسة لوحة التحكم -->
                <div class="dashboard-header mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h1>أهلاً بك في نظام ميز للضيافة</h1>
                            <p>لوحة التحكم الرئيسية</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p><?php echo date('l, d F Y'); ?></p>
                            <p>الإصدار: 1.0.0</p>
                        </div>
                    </div>
                </div>
                
                <!-- بطاقات الإحصائيات -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-4">
                        <div class="stats-card bg-primary text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">العملاء</h5>
                                <p class="card-text display-4">0</p>
                                <p class="card-text">عملاء جدد: 0</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <div class="stats-card bg-success text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">الفعاليات</h5>
                                <p class="card-text display-4">0</p>
                                <p class="card-text">قادمة: 0 | اليوم: 0</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <div class="stats-card bg-info text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">المدفوعات</h5>
                                <p class="card-text display-4">0 ريال</p>
                                <p class="card-text">مستحقة: 0 ريال</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <div class="stats-card bg-warning text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">التكاليف</h5>
                                <p class="card-text display-4">0</p>
                                <p class="card-text">هذا الشهر: 0 ريال</p>
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
                                        <a href="#" class="btn btn-primary btn-lg w-100">
                                            <i class="fas fa-user-plus"></i> إضافة عميل
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="#" class="btn btn-success btn-lg w-100">
                                            <i class="fas fa-calendar-plus"></i> إضافة فعالية
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="#" class="btn btn-info btn-lg w-100 text-white">
                                            <i class="fas fa-money-bill-wave"></i> تسجيل دفعة
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="#" class="btn btn-warning btn-lg w-100">
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
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">الفعاليات القادمة</h5>
                                    <a href="#" class="btn btn-sm btn-primary">عرض الكل</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="text-center py-5">
                                    <i class="fas fa-calendar-day text-muted fa-4x mb-3"></i>
                                    <h5 class="text-muted">لا توجد فعاليات قادمة</h5>
                                    <a href="#" class="btn btn-sm btn-primary mt-2">
                                        <i class="fas fa-plus-circle me-1"></i>
                                        إضافة فعالية جديدة
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">آخر النشاطات</h5>
                                    <a href="#" class="btn btn-sm btn-primary">المهام</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="text-center py-5">
                                    <i class="fas fa-tasks text-muted fa-4x mb-3"></i>
                                    <h5 class="text-muted">لا توجد نشاطات حديثة</h5>
                                    <p class="text-muted">ستظهر هنا آخر النشاطات في النظام</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>