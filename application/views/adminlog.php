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
    <form method="post" class="js-validation-register">
	    <div class="col-xs-11">
		    <div class="col-xs-12">
			    <div class="col-xs-6">
				    <div class="form-group">
			            <label class="col-xs-2"><?php echo $this->lang->line('search_term'); ?></label>
			            <div class="col-xs-3">
			                <label class="radio-inline" for="search_term1">
			                    <input type="radio" id="search_term1" name="search_term" value="7:D"> <?php echo $this->lang->line('search_term_lastweek'); ?>
			                </label>
			                <label class="radio-inline" for="search_term2">
			                    <input type="radio" id="search_term2" name="search_term" value="1:M"> <?php echo $this->lang->line('search_term_lastmonth'); ?>
			                </label>
			            </div>
			            <label class="col-xs-2 control-label" for="example-daterange1"><?php echo $this->lang->line('sel_term'); ?></label>
		                <div class="col-xs-5 input-daterange input-group" data-date-format="yyyy-mm-dd">
		                    <input class="form-control js-datepicker" type="text" id="daterange1" name="daterange1" value="<?php echo date('Y-m-d'); ?>">
		                    <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
		                    <input class="form-control js-datepicker" type="text" id="daterange2" name="daterange2" value="<?php echo date('Y-m-d'); ?>">
		                </div>
			        </div>
			    </div>
		    </div>
			<div class="col-xs-12">
				<div class="col-xs-6 form-group">
		            <label class="col-xs-2 control-label" for="search_type"><?php echo $this->lang->line('search_account_type'); ?></label>
		            <div class="col-xs-10 form-inline">
		                <select class="col-xs-4 js-select2 form-inline" id="search_type" name="search_type" data-placeholder="Choose one..">
		                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
		                    <option value="_user_id"><?php echo $this->lang->line('search_type_seq'); ?></option>
		                    <option value="_player_id"><?php echo $this->lang->line('search_type_name'); ?></option>
		                    <option value="_admin_id"><?php echo $this->lang->line('search_type_adminid'); ?></option>
		                </select>
		                <input class="form-control" type="text" id="search_value" name="search_value" placeholder="Enter Value..">
		            </div>
		        </div>
			</div>
	    </div>
        <div class="col-xs-1 form-group">
            <button class="btn btn-lg btn-primary" id="btnSearch" type="button"><i class="fa fa-search"></i></button>
        </div>
    </form>
</div>
<!-- END Search Section -->
<!-- Page Content -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <!-- Header BG Table -->
            <div class="block">
                <div class="block-content">
	                <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
		            <table class="table table-hover table-borderless table-header-bg js-dataTable-full" id="log_info">
		                <thead>
		                    <tr>
		                        <th class="text-center"><?php echo $this->lang->line('_no'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('_insertdate'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('_ip'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('_admin_id'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('_user_id'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('_player_id'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('_memo'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('_contents'); ?></th>
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
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<script type="text/javascript">
	var session_language = '<?php echo $this->session->userdata('language'); ?>';
	var lang = <?php echo json_encode( $this->lang->language, JSON_UNESCAPED_UNICODE ); ?>;
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/adminlog.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>