<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li id="head_string"></li>
                <li><a class="link-effect" href="" id="menu_string"></a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END Page Header -->
<!-- Search Section -->
<div class="content">
	<div class="row bg-white">
	    <div class="col-lg-6">
		    <!-- Datetimepicker (Material forms) -->
            <div class="block">
                <div class="block-content block-content-narrow">
                    <form class="form-horizontal push-10-t js-validation-register" id="frmSend1" method="post">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="form-material">
                                    <input class="form-control" type="file" id="userlist" name="userlist">
                                    <label for="userlist"><?php echo $this->lang->line('userlist'); ?></label>
                                </div>
                            </div>
                            <div class="col-sm-4" style="padding-top:15px;">
	                            <button class="btn btn-sm btn-primary" type="button" id="btnSample"><?php echo $this->lang->line('format_download'); ?> <i class="fa fa-download"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Datetimepicker (Material forms) -->
	    </div>
	</div>
</div>
<!-- END Search Section -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<iframe id="frmDown" style="width:0px; height:0px;" src="about:blank"></iframe>
<script type="text/javascript">
	var session_language = '<?php echo $this->session->userdata('language'); ?>';
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
	};
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/convert_data.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>