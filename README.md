majlis_catering/
├── classes/                  # فئات النظام
│   ├── Database.php          # فئة الاتصال بقاعدة البيانات
│   ├── User.php              # فئة المستخدمين
│   ├── Customer.php          # فئة العملاء
│   ├── Event.php             # فئة الفعاليات
│   ├── ExternalCost.php      # فئة التكاليف الخارجية
│   ├── Payment.php           # فئة المدفوعات
│   └── Task.php              # فئة المهام
│
├── config/                   # ملفات الإعدادات
│   ├── database.php          # إعدادات قاعدة البيانات
│   └── config.php            # إعدادات عامة للنظام
│
├── includes/                 # ملفات مشتركة
│   ├── functions.php         # دوال مساعدة
│   ├── auth.php              # التحقق من الصلاحيات
│   └── session.php           # إدارة الجلسات
│
├── templates/                # قوالب متكررة
│   ├── header.php            # رأس الصفحة
│   ├── footer.php            # تذييل الصفحة
│   └── sidebar.php           # القائمة الجانبية
│
├── views/                    # صفحات العرض
│   ├── login.php             # صفحة تسجيل الدخول
│   ├── dashboard.php         # لوحة التحكم الرئيسية
│   ├── customers/            # صفحات العملاء (index, add, edit, view)
│   ├── events/               # صفحات الفعاليات (index, add, edit, view)
│   ├── costs/                # صفحات التكاليف (index, add, edit)
│   ├── payments/             # صفحات المدفوعات (index, add, receipt)
│   ├── tasks/                # صفحات المهام (index, add, edit)
│   ├── reports/              # صفحات التقارير
│   └── settings/             # صفحات الإعدادات
│
├── public/                   # الملفات العامة
│   ├── index.php             # نقطة دخول النظام
│   ├── .htaccess             # إعدادات توجيه الطلبات
│   └── assets/               # ملفات الأصول (CSS, JS, images)
│
├── database/                 # ملفات قاعدة البيانات
│   ├── schema.sql            # هيكل قاعدة البيانات
│   └── seed.sql              # بيانات أولية
│
└── logs/                     # ملفات السجلات
