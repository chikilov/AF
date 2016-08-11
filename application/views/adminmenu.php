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
                <div class="block-content" style="padding-bottom: 20px;">
	                <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
		            <table class="table table-hover table-borderless table-header-bg js-dataTable-full" id="admin_menu">
		                <thead>
		                    <tr>
		                        <th class="text-center"><?php echo $this->lang->line('menu_id'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('menu_title'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('url'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('order_sequence'); ?></th>
		                        <!--<th class="text-center"><?php echo $this->lang->line('require_login'); ?></th>-->
		                        <th class="text-center"><?php echo $this->lang->line('group_name'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('in_use'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('detail'); ?></th>
		                    </tr>
		                </thead>
		                <tbody>
		                    <tr>
		                        <td class="text-center"> - </td>
		                        <td class="text-center"> - </td>
		                        <td class="text-center"> - </td>
		                        <td class="text-center"> - </td>
		                        <!--<td class="text-center"> - </td>-->
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
                <input type="hidden" id="_id" name="_id">
	            <div class="block block-themed block-transparent remove-margin-b">
	                <div class="block-header bg-primary-dark">
	                    <ul class="block-options">
	                        <li>
	                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title"><?php echo $this->lang->line('menu_edit'); ?></h3>
	                </div>
	                <div class="block-content block-content-narrow">
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_title_kr" name="_title_kr" placeholder="Please enter menu title...">
                                    <label for="_title"><?php echo $this->lang->line('menu_title_kr'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_title_en" name="_title_en" placeholder="Please enter menu title...">
                                    <label for="_title"><?php echo $this->lang->line('menu_title_en'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_controller" name="_controller" placeholder="col-xs-6">
                                    <label for="_controller"><?php echo $this->lang->line('url'); ?></label>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_view" name="_view" placeholder="col-xs-6">
                                </div>
                            </div>
                            <div class="col-xs-12">
	                            <p><font style="color: #FF5C47;">( <?php echo $this->lang->line('menu_input_group'); ?> )<br />
	                            ( <?php echo $this->lang->line('menu_input_new'); ?> )</font></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_icon" name="_icon" placeholder="Please enter menu icon...">
                                    <label for="_title"><?php echo $this->lang->line('menu_icon'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <select class="js-select2 form-control" id="_group_id" name="_group_id" style="width: 100%;" data-placeholder="Choose one..">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        <option value="0"><?php echo $this->lang->line('self_name'); ?></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
<?php
	foreach ( $arrGroup as $row )
	{
?>
                                      <option value="<?php echo $row['_id']; ?>"><?php echo $row['_title_'.$this->session->userdata('language')].' ( '.$row['_id'].' )'; ?></option>
<?php
	}
?>
                                    </select>
                                    <label for="_group_id"><?php echo $this->lang->line('group_name'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12"><?php echo $this->lang->line('in_use'); ?></label>
                            <div class="col-xs-12">
                                <label class="radio-inline" for="_active_t">
                                    <input type="radio" id="_active_t" name="_active" value="1"> <?php echo $this->lang->line('in_active'); ?>
                                </label>
                                <label class="radio-inline" for="_active_f">
                                    <input type="radio" id="_active_f" name="_active" value="0"> <?php echo $this->lang->line('not_in_active'); ?>
                                </label>
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
<div class="modal in" id="modal-normal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
	        <form class="form-horizontal push-10-t" id="frmMenu" method="post" onsubmit="return false;">
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
	                    <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
			            <table class="table table-hover table-borderless table-header-bg js-dataTable-full" id="admin_menu_seq">
			                <thead>
			                    <tr>
			                        <th class="text-center"><?php echo $this->lang->line('menu_title'); ?></th>
			                        <th class="text-center"><?php echo $this->lang->line('order_sequence'); ?></th>
			                        <th class="text-center"><?php echo $this->lang->line('in_use'); ?></th>
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
	            </div>
	            <div class="modal-footer">
	                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
	                <button class="btn btn-sm btn-primary" id="btnOSubmit" type="submit" data-dismiss="modal"><i class="fa fa-check"></i> Ok</button>
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
<script src="<?php echo $one->assets_folder; ?>/js/pages/admin_menu.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>