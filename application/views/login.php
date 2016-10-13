<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>

<!-- Login Content -->
<div class="bg-white pulldown">
    <div class="content content-boxed overflow-hidden">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="push-30-t push-50 animated fadeIn">
                    <!-- Login Title -->
                    <div class="text-center">
                        <i class="fa fa-2x fa-circle-o-notch text-primary"></i>
                        <p class="text-muted push-15-t"><?php echo $this->lang->line('login_title'); ?></p>
                    </div>
                    <!-- END Login Title -->

                    <!-- Login Form -->
                    <!-- jQuery Validation (.js-validation-login class is initialized in js/pages/base_pages_login.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-login form-horizontal push-30-t" action="/Login/loginaction" method="post">
	                    <div class="form-group">
		                    <div class="col-xs-12">
			                    <div class="form-material form-material-primary floating">
									<select class="js-select2 form-control" id="login-language" name="login-language" style="width: 100%;">
		                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
		                                <option value="kr"<?php echo ( $this->session->userdata('language') == 'kr' ? 'selected = "true"' : '' ); ?>><?php echo $this->lang->line('kr'); ?></option>
		                                <option value="en"<?php echo ( $this->session->userdata('language') == 'en' ? 'selected = "true"' : '' ); ?>><?php echo $this->lang->line('en'); ?></option>
		                            </select>
		                            <label for="login-language"><?php echo $this->lang->line('lang_sel'); ?></label>
			                    </div>
			                </div>
	                    </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-primary floating">
                                    <input class="form-control" type="text" id="login-username" name="login-username">
                                    <label for="login-username"><?php echo $this->lang->line('username'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-primary floating">
                                    <input class="form-control" type="password" id="login-password" name="login-password">
                                    <label for="login-password"><?php echo $this->lang->line('password'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group push-30-t">
                            <div class="col-xs-12">
	                            <div class="col-sm-4 col-sm-offset-2">
	                                <button class="btn btn-sm btn-block btn-primary" type="submit"><?php echo $this->lang->line('btnLogin'); ?></button>
	                            </div>
	                            <div class="col-sm-4">
    	                            <button class="btn btn-sm btn-block btn-primary" type="button" id="btnRegister"><?php echo $this->lang->line('btnJoin'); ?></button>
	                            </div>
                            </div>
                        </div>
                    </form>
                    <!-- END Login Form -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Login Content -->

<!-- Login Footer -->
<div class="pulldown push-30-t text-center animated fadeInUp">
    <small class="text-muted"><span class="js-year-copy"></span> &copy; <?php echo $one->name . ' ' . $one->version; ?></small>
</div>
<!-- END Login Footer -->

<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.full.min.js"></script>
<script>
    jQuery(function(){
        // Init page helpers (BS Datepicker + BS Datetimepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
        App.initHelpers(['select2']);
        jQuery(document).on( 'click', '#btnRegister', function(){
	        window.location = '/Login/register';
        });

        jQuery(document).on( 'change', '#login-language', function () {
	        jQuery.ajax({
		        method: 'POST',
		        url: '/Login/changelanguage',
		        data: {'language':$(this).val()},
		        success: function () {
			        window.location.href = '/Login';
		        }
	        });
        });
    });

	var lang = <?php echo json_encode( $this->lang->language, JSON_UNESCAPED_UNICODE ); ?>;
</script>
<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/login.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>