<?php
/**
 * صفحة إضافة عميل جديد
 */

// منع الوصول المباشر للملف
if (!defined('BASEPATH')) {
    exit('لا يمكن الوصول المباشر لهذا الملف');
}

// تعيين عنوان الصفحة
$page_title = 'إضافة عميل جديد';

// تضمين فئة العميل
require_once CLASSES_PATH . '/Customer.php';

// إنشاء كائن العميل
$customer = new Customer();

// الحصول على مصادر العملاء
$customer_sources = $customer->getCustomerSources();

// الحصول على قائمة العملاء للاختيار في حالة التوصية
$customers_list = $customer->getCustomersForDropdown();

// تهيئة متغيرات النموذج
$name = '';
$phone = '';
$alt_phone = '';
$email = '';
$address = '';
$source_id = '';
$referral_customer_id = '';
$category = 'new'; // القيمة الافتراضية هي "جديد"
$notes = '';

// معالجة النموذج عند الإرسال
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // التحقق من CSRF
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        $error = 'خطأ في التحقق من الطلب. يرجى إعادة المحاولة.';
    } else {
        // الحصول على بيانات النموذج
        $name = isset($_POST['name']) ? clean_input($_POST['name']) : '';
        $phone = isset($_POST['phone']) ? clean_input($_POST['phone']) : '';
        $alt_phone = isset($_POST['alt_phone']) ? clean_input($_POST['alt_phone']) : '';
        $email = isset($_POST['email']) ? clean_input($_POST['email']) : '';
        $address = isset($_POST['address']) ? clean_input($_POST['address']) : '';
        $source_id = isset($_POST['source_id']) ? (int) $_POST['source_id'] : 0;
        $referral_customer_id = isset($_POST['referral_customer_id']) ? (int) $_POST['referral_customer_id'] : 0;
        $category = isset($_POST['category']) ? clean_input($_POST['category']) : 'new';
        $notes = isset($_POST['notes']) ? clean_input($_POST['notes']) : '';
        
        // التحقق من البيانات المطلوبة
        $errors = [];
        
        // التحقق من الاسم
        if (empty($name)) {
            $errors[] = 'يرجى إدخال اسم العميل';
        }
        
        // التحقق من رقم الهاتف
        if (empty($phone)) {
            $errors[] = 'يرجى إدخال رقم الهاتف';
        } elseif (!is_valid_phone($phone)) {
            $errors[] = 'رقم الهاتف غير صالح';
        } elseif ($customer->phoneExists($phone)) {
            $errors[] = 'رقم الهاتف مستخدم بالفعل. يرجى إدخال رقم آخر.';
        }
        
        // التحقق من البريد الإلكتروني إذا تم توفيره
        if (!empty($email) && !is_valid_email($email)) {
            $errors[] = 'البريد الإلكتروني غير صالح';
        }
        
        // التحقق من مصدر العميل
        if ($source_id == 0) {
            $errors[] = 'يرجى اختيار مصدر العميل';
        }
        
        // التحقق من العميل المُوصي إذا كان المصدر توصية
        if ($source_id == 2 && $referral_customer_id == 0) { // افتراض أن معرف مصدر "توصية" هو 2
            $errors[] = 'يرجى تحديد العميل المُوصي';
        }
        
        // إذا لم تكن هناك أخطاء، قم بإنشاء العميل
        if (empty($errors)) {
            // إعداد بيانات العميل
            $customerData = [
                'name' => $name,
                'phone' => $phone,
                'alt_phone' => $alt_phone,
                'email' => $email,
                'address' => $address,
                'source_id' => ($source_id > 0) ? $source_id : null,
                'category' => $category,
                'notes' => $notes
            ];
            
            // إضافة العميل المُوصي إذا كان المصدر توصية
            if ($source_id == 2 && $referral_customer_id > 0) {
                $customerData['referral_customer_id'] = $referral_customer_id;
            }
            
            // إنشاء العميل في قاعدة البيانات
            $result = $customer->create($customerData);
            
            if ($result) {
                // إعادة التوجيه إلى صفحة العميل مع رسالة نجاح
                $_SESSION[SESSION_NAME]['success'] = 'تم إضافة العميل بنجاح';
                header('Location: ' . create_url('customers', 'view', ['id' => $result]));
                exit;
            } else {
                $error = 'حدث خطأ أثناء إضافة العميل. يرجى المحاولة مرة أخرى.';
            }
        }
    }
}

// إنشاء توكن CSRF جديد
$csrf_token = generate_csrf_token();
?>

<div class="container-fluid py-4">
    <!-- ترويسة الصفحة -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">إضافة عميل جديد</h1>
        <a href="<?php echo create_url('customers'); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-right"></i> العودة إلى قائمة العملاء
        </a>
    </div>
    
    <!-- عرض رسائل الخطأ -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                <?php foreach ($errors as $error_msg): ?>
                    <li><?php echo $error_msg; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <!-- بطاقة النموذج -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">بيانات العميل</h5>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo create_url('customers', 'add'); ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                
                <div class="row">
                    <!-- المعلومات الأساسية -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">المعلومات الأساسية</h6>
                            </div>
                            <div class="card-body">
                                <!-- اسم العميل -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">اسم العميل <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                                </div>
                                
                                <!-- رقم الهاتف -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                                    <small class="form-text text-muted">أدخل رقم الهاتف بصيغة صحيحة. مثال: 05xxxxxxxx</small>
                                </div>
                                
                                <!-- رقم هاتف بديل -->
                                <div class="mb-3">
                                    <label for="alt_phone" class="form-label">رقم هاتف بديل</label>
                                    <input type="tel" class="form-control" id="alt_phone" name="alt_phone" value="<?php echo $alt_phone; ?>">
                                </div>
                                
                                <!-- البريد الإلكتروني -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- معلومات إضافية -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">معلومات إضافية</h6>
                            </div>
                            <div class="card-body">
                                <!-- العنوان -->
                                <div class="mb-3">
                                    <label for="address" class="form-label">العنوان</label>
                                    <textarea class="form-control" id="address" name="address" rows="2"><?php echo $address; ?></textarea>
                                </div>
                                
                                <!-- مصدر العميل -->
                                <div class="mb-3">
                                    <label for="source_id" class="form-label">مصدر العميل <span class="text-danger">*</span></label>
                                    <select class="form-select" id="source_id" name="source_id" required>
                                        <option value="">-- اختر مصدر العميل --</option>
                                        <?php foreach ($customer_sources as $source): ?>
                                            <option value="<?php echo $source['id']; ?>" <?php echo ($source_id == $source['id']) ? 'selected' : ''; ?>>
                                                <?php echo $source['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <!-- العميل المُوصي (يظهر فقط عند اختيار مصدر "توصية") -->
                                <div class="mb-3" id="referralCustomerDiv" style="display: <?php echo ($source_id == 2) ? 'block' : 'none'; ?>;">
                                    <label for="referral_customer_id" class="form-label">العميل المُوصي</label>
                                    <select class="form-select" id="referral_customer_id" name="referral_customer_id">
                                        <option value="">-- اختر العميل المُوصي --</option>
                                        <?php foreach ($customers_list as $cust): ?>
                                            <option value="<?php echo $cust['id']; ?>" <?php echo ($referral_customer_id == $cust['id']) ? 'selected' : ''; ?>>
                                                <?php echo $cust['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <!-- تصنيف العميل -->
                                <div class="mb-3">
                                    <label for="category" class="form-label">تصنيف العميل</label>
                                    <select class="form-select" id="category" name="category">
                                        <option value="new" <?php echo ($category == 'new') ? 'selected' : ''; ?>>جديد</option>
                                        <option value="regular" <?php echo ($category == 'regular') ? 'selected' : ''; ?>>منتظم</option>
                                        <option value="VIP" <?php echo ($category == 'VIP') ? 'selected' : ''; ?>>VIP</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- الملاحظات -->
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">ملاحظات</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="أدخل أي ملاحظات إضافية عن العميل هنا..."><?php echo $notes; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- أزرار الإرسال -->
                <div class="text-end mt-3">
                    <a href="<?php echo create_url('customers'); ?>" class="btn btn-secondary me-2">إلغاء</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> حفظ العميل
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- سكريبت لإظهار/إخفاء حقل العميل المُوصي -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var sourceDropdown = document.getElementById('source_id');
    var referralDiv = document.getElementById('referralCustomerDiv');
    
    sourceDropdown.addEventListener('change', function() {
        // إذا كان المصدر هو "توصية" (معرف 2)، أظهر حقل العميل المُوصي
        if (this.value == '2') {
            referralDiv.style.display = 'block';
        } else {
            referralDiv.style.display = 'none';
        }
    });
});
</script>