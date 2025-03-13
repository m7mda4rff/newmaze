<?php
/**
 * صفحة قائمة العملاء
 */

// منع الوصول المباشر للملف
if (!defined('BASEPATH')) {
    exit('لا يمكن الوصول المباشر لهذا الملف');
}

// تعيين عنوان الصفحة
$page_title = 'إدارة العملاء';

// تضمين فئة العملاء
require_once CLASSES_PATH . '/Customer.php';

// إنشاء كائن العميل
$customer = new Customer();

// معالجة حذف عميل
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $customer_id = (int) $_GET['id'];
    
    // التحقق من وجود العميل
    if ($customer->delete($customer_id)) {
        $_SESSION[SESSION_NAME]['success'] = 'تم حذف العميل بنجاح';
    } else {
        $_SESSION[SESSION_NAME]['error'] = 'فشل في حذف العميل';
    }
    
    // إعادة التوجيه لتجنب إعادة الحذف عند تحديث الصفحة
    header('Location: ' . create_url('customers'));
    exit;
}

// الحصول على مصادر العملاء للفلترة
$customer_sources = $customer->getCustomerSources();

// تهيئة متغيرات الفلترة والبحث
$filters = [];
$search = isset($_GET['search']) ? clean_input($_GET['search']) : '';
$source_id = isset($_GET['source_id']) ? (int) $_GET['source_id'] : 0;
$category = isset($_GET['category']) ? clean_input($_GET['category']) : '';

// إضافة الفلاتر إذا تم تحديدها
if (!empty($search)) {
    $filters['search'] = $search;
}

if ($source_id > 0) {
    $filters['source_id'] = $source_id;
}

if (!empty($category)) {
    $filters['category'] = $category;
}

// تهيئة متغيرات الصفحات
$page_number = isset($_GET['page_number']) ? (int) $_GET['page_number'] : 1;
$items_per_page = isset($config['pagination_limit']) ? $config['pagination_limit'] : 20;
$offset = ($page_number - 1) * $items_per_page;

// الحصول على إجمالي عدد العملاء
$total_customers = $customer->countCustomers($filters);

// الحصول على قائمة العملاء
$customers_list = $customer->getCustomers($filters, $items_per_page, $offset);

// حساب عدد الصفحات
$total_pages = ceil($total_customers / $items_per_page);
?>

<div class="container-fluid py-4">
    <!-- ترويسة الصفحة -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">إدارة العملاء</h1>
        <a href="<?php echo create_url('customers', 'add'); ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> إضافة عميل جديد
        </a>
    </div>
    
    <!-- بطاقة البحث والفلترة -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="get" action="<?php echo BASE_URL; ?>/public/index.php">
                <input type="hidden" name="page" value="customers">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3">
                        <label for="search" class="form-label">بحث</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="اسم العميل أو رقم الهاتف أو البريد الإلكتروني" value="<?php echo $search; ?>">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="source_id" class="form-label">مصدر العميل</label>
                        <select class="form-select" id="source_id" name="source_id">
                            <option value="0">الكل</option>
                            <?php foreach ($customer_sources as $source): ?>
                                <option value="<?php echo $source['id']; ?>" <?php echo ($source_id == $source['id']) ? 'selected' : ''; ?>>
                                    <?php echo $source['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="category" class="form-label">التصنيف</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">الكل</option>
                            <option value="VIP" <?php echo ($category == 'VIP') ? 'selected' : ''; ?>>VIP</option>
                            <option value="regular" <?php echo ($category == 'regular') ? 'selected' : ''; ?>>منتظم</option>
                            <option value="new" <?php echo ($category == 'new') ? 'selected' : ''; ?>>جديد</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> بحث
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- قائمة العملاء -->
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">قائمة العملاء</h5>
                <span class="badge bg-primary"><?php echo $total_customers; ?> عميل</span>
            </div>
        </div>
        <div class="card-body p-0">
            <?php if (empty($customers_list)): ?>
                <div class="text-center p-5">
                    <i class="fas fa-users text-muted fa-3x mb-3"></i>
                    <h4 class="text-muted">لا يوجد عملاء</h4>
                    <p class="text-muted">
                        لم يتم العثور على أي عملاء تطابق معايير البحث
                    </p>
                    <a href="<?php echo create_url('customers', 'add'); ?>" class="btn btn-primary mt-3">
                        <i class="fas fa-user-plus"></i> إضافة عميل جديد
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>رقم الهاتف</th>
                                <th>البريد الإلكتروني</th>
                                <th>المصدر</th>
                                <th>التصنيف</th>
                                <th>تاريخ الإضافة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers_list as $customer_item): ?>
                            <tr>
                                <td><?php echo $customer_item['id']; ?></td>
                                <td><?php echo $customer_item['name']; ?></td>
                                <td>
                                    <a href="tel:<?php echo $customer_item['phone']; ?>" class="text-decoration-none">
                                        <?php echo $customer_item['phone']; ?>
                                    </a>
                                </td>
                                <td>
                                    <?php if (!empty($customer_item['email'])): ?>
                                        <a href="mailto:<?php echo $customer_item['email']; ?>" class="text-decoration-none">
                                            <?php echo $customer_item['email']; ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo !empty($customer_item['source_name']) ? $customer_item['source_name'] : 'غير محدد'; ?>
                                </td>
                                <td>
                                    <?php 
                                    switch ($customer_item['category']) {
                                        case 'VIP':
                                            echo '<span class="badge bg-danger">VIP</span>';
                                            break;
                                        case 'regular':
                                            echo '<span class="badge bg-success">منتظم</span>';
                                            break;
                                        case 'new':
                                            echo '<span class="badge bg-info">جديد</span>';
                                            break;
                                        default:
                                            echo '<span class="badge bg-secondary">غير محدد</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo format_date($customer_item['created_at']); ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?php echo create_url('customers', 'view', ['id' => $customer_item['id']]); ?>" class="btn btn-info" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo create_url('customers', 'edit', ['id' => $customer_item['id']]); ?>" class="btn btn-warning" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo create_url('customers', 'delete', ['id' => $customer_item['id']]); ?>" class="btn btn-danger delete-btn" title="حذف" onclick="return confirm('هل أنت متأكد من رغبتك في حذف هذا العميل؟');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- ترقيم الصفحات -->
                <?php if ($total_pages > 1): ?>
                <div class="card-footer bg-white">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mb-0">
                            <!-- زر الصفحة السابقة -->
                            <li class="page-item <?php echo ($page_number <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo create_url('customers', 'index', array_merge($filters, ['page_number' => $page_number - 1])); ?>">
                                    <i class="fas fa-chevron-right"></i> السابق
                                </a>
                            </li>
                            
                            <!-- أرقام الصفحات -->
                            <?php
                            $start_page = max(1, $page_number - 2);
                            $end_page = min($total_pages, $start_page + 4);
                            
                            for ($i = $start_page; $i <= $end_page; $i++): ?>
                                <li class="page-item <?php echo ($i == $page_number) ? 'active' : ''; ?>">
                                    <a class="page-link" href="<?php echo create_url('customers', 'index', array_merge($filters, ['page_number' => $i])); ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <!-- زر الصفحة التالية -->
                            <li class="page-item <?php echo ($page_number >= $total_pages) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo create_url('customers', 'index', array_merge($filters, ['page_number' => $page_number + 1])); ?>">
                                    التالي <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>