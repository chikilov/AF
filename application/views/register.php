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
                        <h1 class="h3 push-10-t"><?php echo $this->lang->line('register_title'); ?></h1>
                    </div>
                    <!-- END Register Title -->

                    <!-- Register Form -->
                    <!-- jQuery Validation (.js-validation-register class is initialized in js/pages/base_pages_register.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-register form-horizontal push-50-t push-50" action="/Login/registeraction" method="post">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-success">
                                    <input class="form-control" type="text" id="register-username" name="register-username" placeholder="<?php echo $this->lang->line('username_comment'); ?>">
                                    <label for="register-username"><?php echo $this->lang->line('username'); ?></label>
                                </div>
                            </div>
                        </div>
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
                                <div class="form-material form-material-success">
                                    <input class="form-control" type="name" id="register-name" name="register-name" placeholder="<?php echo $this->lang->line('name_comment'); ?>">
                                    <label for="register-name"><?php echo $this->lang->line('name'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-success">
                                    <input class="form-control" type="depart" id="register-depart" name="register-depart" placeholder="<?php echo $this->lang->line('depart_comment'); ?>">
                                    <label for="register-depart"><?php echo $this->lang->line('depart'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-success">
                                    <input class="form-control" type="reason" id="register-reason" name="register-reason" placeholder="<?php echo $this->lang->line('reason_comment'); ?>">
                                    <label for="register-reason"><?php echo $this->lang->line('reason'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
	                            <div class="col-sm-4 col-sm-offset-2">
	                                <button class="btn btn-sm btn-block btn-success" type="submit"><?php echo $this->lang->line('btnJoinRequest'); ?></button>
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

<!-- Terms Modal -->
<div class="modal fade" id="modal-terms" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Terms &amp; Conditions</h3>
                </div>
                <div class="block-content">
                    <?php $one->get_text('small', 5); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary" type="button" data-dismiss="modal"><i class="fa fa-check"></i> I agree</button>
            </div>
        </div>
    </div>
</div>
<!-- END Terms Modal -->

<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Code -->
<script type="text/javascript">
	jQuery(document).on( 'click', '#btncancel', function () {
		window.location = '/Login';
	});

	var lang = {
<?php
	foreach( $this->lang->language as $key => $val )
	{
		echo "\t\t\"".$key."\":\"".$val."\"";
		if ( key($this->lang->language) == $key && end($this->lang->language) == $val )
		{
			echo PHP_EOL;
		}
		else
		{
			echo ','.PHP_EOL;
		}
	}
?>
	}
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/register.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>