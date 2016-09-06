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
		            <table class="table table-hover table-borderless table-header-bg js-dataTable-full" id="admin_account">
		                <thead>
		                    <tr>
		                        <th class="text-center"><?php echo $this->lang->line('account'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('name'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('depart'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('create_datetime'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('ip'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('auth_group'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('status'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('detail'); ?></th>
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
<div class="modal in" id="modal-large" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal push-10-t" id="frmMenu" method="post" onsubmit="return false;">
                <input type="hidden" id="_useraccount" name="_useraccount">
	            <div class="block block-themed block-transparent remove-margin-b">
	                <div class="block-header bg-primary-dark">
	                    <ul class="block-options">
	                        <li>
	                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title"><?php echo $this->lang->line('account_edit'); ?></h3>
	                </div>
	                <div class="block-content block-content-narrow">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_username" name="_username">
                                    <label for="_username"><?php echo $this->lang->line('account'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_name" name="_name">
                                    <label for="_name"><?php echo $this->lang->line('name'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_reason" name="_reason">
                                    <label for="_reason"><?php echo $this->lang->line('reason'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_depart" name="_depart">
                                    <label for="_depart"><?php echo $this->lang->line('depart'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <select class="js-select2 form-control" id="_auth" name="_auth" style="width: 100%;" data-placeholder="Choose one..">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
<?php
	foreach ( $arrGroup as $row )
	{
?>
                                      <option value="<?php echo $row['_group_id']; ?>"><?php echo $row['_group_name']; ?></option>
<?php
	}
?>
                                    </select>
                                    <label for="_auth"><?php echo $this->lang->line('auth_group'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <select class="js-select2 form-control" id="_approved" name="_approved" style="width: 100%;" data-placeholder="Choose one..">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        <option value="0"><?php echo $this->lang->line('notyet_status'); ?></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        <option value="1"><?php echo $this->lang->line('normal_status'); ?></option>
                                        <option value="2"><?php echo $this->lang->line('delete_status'); ?></option>
                                    </select>
                                    <label for="_approved"><?php echo $this->lang->line('status'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_admin_memo" name="_admin_memo">
                                    <label for="_admin_memo"><?php echo $this->lang->line('admin_memo'); ?></label>
                                </div>
                            </div>
                        </div>
	                </div>
	            </div>
	            <div class="modal-footer">
	                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
	                <button class="btn btn-sm btn-primary" id="btnSubmit" type="submit" data-dismiss="modal"><i class="fa fa-check"></i> Ok</button>
	            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="modal-log" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content bg-gray-lighter">
			<div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title"><?php echo $this->lang->line('account_edit'); ?></h3>
                </div>
                <div class="block-content bg-white">
					<table class="table table-header-bg table-bordered" id="admin_log">
						<thead>
							<tr>
								<th class="text-center"><?php echo $this->lang->line('title_date'); ?></th>
								<th class="text-center"><?php echo $this->lang->line('title_account'); ?></th>
								<th class="text-center"><?php echo $this->lang->line('title_log'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
		                        <td class="text-center"> - </td>
		                        <td class="text-center"> - </td>
		                        <td class="text-center"> - </td>
							</tr>
						</tbody>
					</table>
                </div>
	            <div class="modal-footer">
	                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
	            </div>
			</div>
        </div>
    </div>
</div>
<!-- END Page Content -->
<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<script type="text/javascript">
	var session_language = '<?php echo $this->session->userdata('language'); ?>';
	var auth = { 'view' : <?php echo $arrAuth['_auth_view']; ?>, 'edit' : <?php echo $arrAuth['_auth_write']; ?> };
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
<script src="<?php echo $one->assets_folder; ?>/js/pages/admin_account.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>