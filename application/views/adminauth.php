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
			<div class="block block-themed">
                <div class="block-header bg-primary">
                    <h3 class="block-title"><?php echo $this->lang->line('admin_auth'); ?></h3>
                </div>
                <div class="block-content">
                    <form class="form-horizontal push-10-t push-10" method="post">
                        <div class="form-group">
                            <div class="col-xs-4">
                                <div class="form-material">
                                    <select class="js-select2 form-control" id="group_id" name="group_id" style="width: 100%;" data-placeholder="<?php echo $this->lang->line('select_group'); ?>">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
<?php
	foreach ( $arrGroup as $row )
	{
?>
                                      <option value="<?php echo $row['_group_id']; ?>" data-applies="<?php echo $row['_group_applies']; ?>"><?php echo $row['_group_name']; ?></option>
<?php
	}
?>
                                    </select>
                                    <label for="group_id"></label>
                                </div>
                            </div>
                            <div class="col-xs-8">
	                            <button class="btn btn-lg btn-primary" id="btnSearch" type="button"><i class="fa fa-search"></i></button>&nbsp;<button class="btn btn-lg btn-warning" style="display:none;" id="btnEdit" type="button"><i class="fa fa-edit"></i></button>&nbsp;<button class="btn btn-lg btn-danger" id="btnDelete" style="display:none;" type="button"><i class="fa fa-trash-o"></i></button>&nbsp;<button class="btn btn-lg btn-success" id="btnWrite" data-toggle="modal" data-target="#modal-large" type="button"><i class="fa fa-plus-square-o"></i></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-1">
	                            <h4 class="block-title">주요 대상 : </h4>
                            </div>
                            <div class="col-xs-11">
	                            <span id="group_applies"></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
		</div>
	</div>
    <div class="row">
        <div class="col-lg-12">
            <!-- Header BG Table -->
            <div class="block">
                <div class="block-content">
	                <form class="form-horizontal push-10-t" method="post" onsubmit="return false;">
	                <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
		            <table class="table table-hover table-borderless table-header-bg js-dataTable-full" id="admin_auth">
		                <thead>
		                    <tr>
		                        <th class="text-center"><?php echo $this->lang->line('menu_id'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('menu_group'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('menu_item'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('view'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('write'); ?></th>
		                    </tr>
		                </thead>
		                <tbody>
		                    <tr>
		                        <td class="text-center"> - </td>
		                        <td class="text-center"> - </td>
		                        <td class="text-center"> - </td>
		                        <td class="text-center"> - </td>
		                        <td class="text-center"> - </td>
		                    </tr>
		                </tbody>
		            </table>
	                </form>
                </div>
            </div>
            <!-- END Header BG Table -->
        </div>
    </div>
</div>
<!-- END Page Content -->
<!-- Large Modal -->
<div class="modal" id="modal-large" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal push-10-t push-10 js-validation-register" method="post">
	            <div class="block block-themed block-transparent remove-margin-b">
	                <div class="block-header bg-primary-dark">
	                    <ul class="block-options">
	                        <li>
	                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title"><?php echo $this->lang->line('new_auth'); ?></h3>
	                </div>
	                <div class="block-content">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="group_name" name="group_name" placeholder="<?php echo $this->lang->line('write_group_name'); ?>">
                                    <label for="group_name"><?php echo $this->lang->line('group_name'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="igroup_applies" name="group_applies" placeholder="<?php echo $this->lang->line('write_group_applies'); ?>">
                                    <label for="group_applies"><?php echo $this->lang->line('group_applies'); ?></label>
                                </div>
                            </div>
                        </div>
		                <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
			            <table class="table table-hover table-borderless table-header-bg js-dataTable-full" id="admin_auth_pop">
			                <thead>
			                    <tr>
			                        <th class="text-center"><?php echo $this->lang->line('menu_id'); ?></th>
			                        <th class="text-center"><?php echo $this->lang->line('menu_group'); ?></th>
			                        <th class="text-center"><?php echo $this->lang->line('menu_item'); ?></th>
			                        <th class="text-center"><?php echo $this->lang->line('view'); ?></th>
			                        <th class="text-center"><?php echo $this->lang->line('write'); ?></th>
			                    </tr>
			                </thead>
			                <tbody>
			                </tbody>
			            </table>
	                </div>
	            </div>
	            <div class="modal-footer">
	                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
	                <button class="btn btn-sm btn-primary" type="submit" id="btnInsert"><i class="fa fa-check"></i> Ok</button>
	            </div>
            </form>
        </div>
    </div>
</div>
<!-- END Large Modal -->
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
<script src="<?php echo $one->assets_folder; ?>/js/pages/admin_auth.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>