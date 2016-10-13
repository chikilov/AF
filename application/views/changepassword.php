<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>

<!-- Register Content -->
<div class="bg-white pulldown">
    <div class="content content-boxed overflow-hidden">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="push-30-t push-20 animated fadeIn">
                    <!-- Register Title -->
                    <div class="text-center">
                        <i class="fa fa-2x fa-circle-o-notch text-primary"></i>
                        <h1 class="h3 push-10-t"><?php echo $this->lang->line('changepassword_title'); ?></h1>
                    </div>
                    <!-- END Register Title -->

                    <!-- Register Form -->
                    <!-- jQuery Validation (.js-validation-register class is initialized in js/pages/base_pages_register.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-register form-horizontal push-50-t push-50" action="/Login/changepasswordaction" method="post">
                        <input class="form-control" type="hidden" id="register-username" name="register-username" value="<?php echo $this->session->userdata('temp_id'); ?>"/>
                        <input class="form-control" type="hidden" id="prev_pass" name="prev_pass" value="<?php echo $this->session->userdata('temp_pass'); ?>"/>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-success">
                                    <input class="form-control" type="password" id="register-password" name="register-password" placeholder="<?php echo $this->lang->line('password_comment'); ?>">
                                    <label for="register-password"><?php echo $this->lang->line('password'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-success">
                                    <input class="form-control" type="password" id="register-password2" name="register-password2" placeholder="<?php echo $this->lang->line('confirm_comment'); ?>">
                                    <label for="register-password2"><?php echo $this->lang->line('password_confirm'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
	                            <div class="col-sm-4 col-sm-offset-2">
	                                <button class="btn btn-sm btn-block btn-success" type="submit" id="btnChange"><?php echo $this->lang->line('btnChangePassword'); ?></button>
	                            </div>
	                            <div class="col-sm-4">
	                                <button class="btn btn-sm btn-block btn-danger" type="button" id="btncancel"><?php echo $this->lang->line('btnCancel'); ?></button>
	                            </div>
                            </div>
                        </div>
                    </form>
                    <!-- END Register Form -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Register Content -->

<!-- Register Footer -->
<div class="pulldown push-30-t text-center animated fadeInUp">
    <small class="text-muted"><span class="js-year-copy"></span> &copy; <?php echo $one->name . ' ' . $one->version; ?></small>
</div>
<!-- END Register Footer -->

<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Code -->
<script type="text/javascript">
	jQuery(document).on( 'click', '#btncancel', function () {
		window.location = '/Login';
	});

	var lang = <?php echo json_encode( $this->lang->language, JSON_UNESCAPED_UNICODE ); ?>;
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/changepassword.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>