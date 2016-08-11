<?php
/**
 * template_footer_start.php
 *
 * Author: pixelcave
 *
 * All vital JS scripts are included here
 *
 */
?>

<!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
<script src="<?php echo $one->assets_folder; ?>/js/core/jquery.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/core/bootstrap.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/core/jquery.slimscroll.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/core/jquery.scrollLock.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/core/jquery.appear.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/core/jquery.countTo.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/core/jquery.placeholder.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert-dev.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/core/js.cookie.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/app.js"></script>
<script type="text/javascript">
	jQuery('#head_string').html(jQuery('.side-content').find('.active').parent().prevAll('li.nav-main-heading:first').children('span').html());
	jQuery('#menu_string').html(jQuery('.side-content').find('.active > span').html());
	jQuery('.page-heading').html(jQuery('.side-content').find('.active > span').html());
</script>
<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datetimepicker/moment.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/buttons.flash.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/vfs_fonts.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/buttons.print.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- Page JS Code -->
