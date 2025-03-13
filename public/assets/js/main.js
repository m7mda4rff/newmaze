/**
 * ملف الجافاسكريبت الرئيسي للنظام
 */

// تنفيذ الكود عند اكتمال تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    // تفعيل توست بوتستراب
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function(toastEl) {
        return new bootstrap.Toast(toastEl);
    });
    
    // إظهار جميع التوست
    toastList.forEach(function(toast) {
        toast.show();
    });
    
    // إخفاء رسائل التنبيه تلقائيًا بعد 5 ثوانٍ
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
    
    // تفعيل بوبوفر بوتستراب
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // تفعيل التلميحات
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // التحقق من صحة النماذج
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
    });
    
    // تأكيد حذف العناصر
    var deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            if (!confirm('هل أنت متأكد من رغبتك في حذف هذا العنصر؟')) {
                event.preventDefault();
            }
        });
    });
});

/**
 * دالة لتنسيق المبالغ المالية
 * 
 * @param {number} amount المبلغ المراد تنسيقه
 * @param {string} currency العملة
 * @param {string} position موضع العملة
 * @returns {string} المبلغ منسقاً
 */
function formatAmount(amount, currency = 'ر.س', position = 'after') {
    amount = parseFloat(amount).toFixed(2);
    amount = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    
    if (position === 'before') {
        return currency + ' ' + amount;
    } else {
        return amount + ' ' + currency;
    }
}

/**
 * دالة لتحديث قائمة منسدلة تابعة
 * 
 * @param {string} parentSelector محدد القائمة الأم
 * @param {string} childSelector محدد القائمة التابعة
 * @param {Object} data بيانات الخيارات
 */
function updateDependentDropdown(parentSelector, childSelector, data) {
    var parentElement = document.querySelector(parentSelector);
    var childElement = document.querySelector(childSelector);
    
    if (parentElement && childElement) {
        parentElement.addEventListener('change', function() {
            var parentValue = parentElement.value;
            var options = data[parentValue] || [];
            
            // إفراغ القائمة التابعة
            childElement.innerHTML = '';
            
            // إضافة خيار فارغ
            var emptyOption = document.createElement('option');
            emptyOption.value = '';
            emptyOption.textContent = 'اختر...';
            childElement.appendChild(emptyOption);
            
            // إضافة الخيارات الجديدة
            options.forEach(function(option) {
                var newOption = document.createElement('option');
                newOption.value = option.value;
                newOption.textContent = option.text;
                childElement.appendChild(newOption);
            });
        });
    }
}