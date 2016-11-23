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
<!-- Page Content -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <!-- Header BG Table -->
            <div class="block">
                <div class="block-content">
	                <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
		            <table class="table table-hover table-borderless table-header-bg js-dataTable-full" id="account_list">
		                <thead>
		                    <tr>
		                        <th class="text-center"><?php echo $this->lang->line('notification_type'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('target_type'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('target_id'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('notification_title'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('start_time'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('end_time'); ?></th>
		                    </tr>
		                </thead>
		                <tbody>
		                    <tr>
		                        <td class="text-center"> - </td>
		                        <td class="text-center"> - </td>
		                        <td class="text-center"> - </td>
		                        <td class="text-center"> - </td>
		                        <td class="text-center"> - </td>
		                        <td class="text-center"> - </td>
		                    </tr>
		                </tbody>
		            </table>
                </div>
            </div>
            <!-- END Header BG Table -->
        </div>
    </div>
</div>
<div class="modal" id="modal-normal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
			<form class="form-horizontal push-10-t push-10 js-validation-material" method="post">
				<div class="block block-themed block-transparent remove-margin-b">
	                <div class="block-header bg-primary-dark">
	                    <ul class="block-options">
	                        <li>
	                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title" id="normal_title">-</h3>
	                </div>
	                <div class="block-content">
						<input type="hidden" name="change_index" id="change_index">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <span id="cur_val"></span>
                                    <label for="cur_val" id="cur_val_title"><?php echo $this->lang->line('current'); ?> </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="change_val" name="change_val" placeholder="<?php echo $this->lang->line('change_val_placeholder'); ?>">
                                    <label for="change_val" id="normal_title2">-</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="display:none;" id="chgval2">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="change_val2" name="change_val2" placeholder="<?php echo $this->lang->line('change_val_placeholder'); ?>">
                                    <label for="change_val2" id="normal_title3">-</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="admin_memo" name="admin_memo" placeholder="<?php echo $this->lang->line('need_admin_memo'); ?>">
                                    <label for="admin_memo"><?php echo $this->lang->line('admin_memo'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <p id="text_confirm"> 수정 하시겠습니까?</p>
                            </div>
                        </div>
	                </div>
	            </div>
	            <div class="modal-footer">
	                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
	                <button class="btn btn-sm btn-primary" type="button" id="btnNormal"><i class="fa fa-check"></i> Ok</button>
	            </div>
            </form>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<script type="text/javascript">
	var session_language = '<?php echo $this->session->userdata('language'); ?>';
	var auth = { 'view' : <?php echo $arrAuth['_auth_view']; ?>, 'edit' : <?php echo $arrAuth['_auth_write']; ?> };
	var lang = <?php echo json_encode( $this->lang->language, JSON_UNESCAPED_UNICODE ); ?>;
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/notification.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>