<?php
/**
 * قالب تذييل الصفحة
 */

// منع الوصول المباشر للملف
if (!defined('BASEPATH')) {
    exit('لا يمكن الوصول المباشر لهذا الملف');
}
?>
            </div> <!-- نهاية المحتوى الرئيسي -->
        </div> <!-- نهاية الصف -->
    </div> <!-- نهاية الحاوية -->

    <!-- تذييل الصفحة -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <span>جميع الحقوق محفوظة &copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?></span>
                <span>الإصدار <?php echo APP_VERSION; ?></span>
            </div>
        </div>
    </footer>

    <!-- جافاسكريبت Bootstrap -->
    <script src="<?php echo ASSETS_PATH; ?>/js/jquery.min.js"></script>
    <script src="<?php echo ASSETS_PATH; ?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo ASSETS_PATH; ?>/js/main.js"></script>
    
    <?php if (isset($page_scripts) && is_array($page_scripts)): ?>
        <?php foreach ($page_scripts as $script): ?>
            <script src="<?php echo ASSETS_PATH; ?>/js/<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>