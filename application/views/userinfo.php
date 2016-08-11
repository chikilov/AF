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
    <form method="post">
	    <div class="col-xs-12 form-group">
            <label class="col-md-2"><?php echo $this->lang->line('search_term'); ?></label>
            <div class="col-md-8">
                <label class="radio-inline" for="search_term1">
                    <input type="radio" id="search_term1" name="search_term" value="0:D"> <?php echo $this->lang->line('search_term_today'); ?>
                </label>
                <label class="radio-inline" for="search_term2">
                    <input type="radio" id="search_term2" name="search_term" value="7:D"> <?php echo $this->lang->line('search_term_lastweek'); ?>
                </label>
                <label class="radio-inline" for="search_term3">
                    <input type="radio" id="search_term3" name="search_term" value="1:M"> <?php echo $this->lang->line('search_term_lastmonth'); ?>
                </label>
                <label class="radio-inline" for="search_term4">
                    <input type="radio" id="search_term4" name="search_term" value="6:M"> <?php echo $this->lang->line('search_term_lasthalfyear'); ?>
                </label>
                <label class="radio-inline" for="search_term5">
                    <input type="radio" id="search_term5" name="search_term" value="10:Y"> <?php echo $this->lang->line('search_term_total'); ?>
                </label>
            </div>
        </div>
		<div class="col-xs-12 form-group">
            <label class="col-md-2 control-label" for="example-daterange1"><?php echo $this->lang->line('search_term_range'); ?></label>
            <div class="col-md-8">
                <div class="col-md-8 input-daterange input-group" data-date-format="yyyy/mm/dd">
                    <input class="form-control js-datepicker" type="text" id="daterange1" name="daterange1">
                    <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                    <input class="form-control" type="text" id="daterange2" name="daterange2">
                </div>
            </div>
        </div>
		<div class="col-xs-12 form-group">
            <label class="col-md-2 control-label" for="search_type"><?php echo $this->lang->line('search_account_type'); ?></label>
            <div class="col-md-8 form-inline">
                <select class="col-xs-4 js-select2 form-inline" id="search_type" name="search_type" style="width: 20%;" data-placeholder="Choose one..">
                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                    <option value="_user_account"><?php echo $this->lang->line('search_type_account'); ?></option>
                    <option value="_user_id"><?php echo $this->lang->line('search_type_seq'); ?></option>
                    <option value="_email"><?php echo $this->lang->line('search_type_email'); ?></option>
                </select>
                <input class="form-control" type="text" id="search_value" name="search_value" style="width: 40%;" placeholder="Enter Value..">
                <button class="btn btn-default" id="btnSearch"><i class="fa fa-search"></i></button>
            </div>
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
		            <table class="table table-hover table-borderless table-header-bg js-dataTable-full" id="account_list">
		                <thead>
		                    <tr>
		                        <th class="text-center"><?php echo $this->lang->line('user_id'); ?></th>
		                        <th><?php echo $this->lang->line('user_account'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('email'); ?></th>
		                        <th class="text-center" style="width: 15%;"><?php echo $this->lang->line('birth_datetime'); ?></th>
		                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('create_type'); ?></th>
		                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('status'); ?></th>
		                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('detail'); ?></th>
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
<div class="modal" id="modal-large" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content bg-gray-lighter">
			<div class="modal-header">
				<table class="table table-header-bg table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->lang->line('user_id'); ?></th>
							<th class="text-center"><?php echo $this->lang->line('user_account'); ?></th>
							<th class="text-center"><?php echo $this->lang->line('email'); ?></th>
							<th class="text-center"><?php echo $this->lang->line('birth_datetime'); ?></th>
							<th class="text-center"><?php echo $this->lang->line('create_type'); ?></th>
							<th class="text-center"><?php echo $this->lang->line('status'); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
	                        <td class="text-center" id="head_userid"> - </td>
	                        <td class="text-center" id="head_useraccount"> - </td>
	                        <td class="text-center" id="head_email"> - </td>
	                        <td class="text-center" id="head_birthdatetime"> - </td>
	                        <td class="text-center" id="head_createtype"> - </td>
	                        <td class="text-center" id="head_status"> - </td>
						</tr>
					</tbody>
				</table>
			</div>
	        <div class="block bg-gray-lighter" style="margin-bottom: 0;">
                <ul class="nav nav-tabs nav-tabs-alt nav-justified" data-toggle="tabs">
                    <li class="active">
                        <a href="#btabs-alt-static-justified-basic_info"><i class="fa fa-home"></i> <?php echo $this->lang->line('basic_info'); ?></a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-justified-access_info"><i class="fa fa-pencil"></i> <?php echo $this->lang->line('access_info'); ?></a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-justified-payment_info"><i class="fa fa-cog"></i> <?php echo $this->lang->line('payment_info'); ?></a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-justified-join_log"><i class="fa fa-cog"></i> <?php echo $this->lang->line('join_log'); ?></a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-justified-block_info"><i class="fa fa-cog"></i> <?php echo $this->lang->line('block_info'); ?></a>
                    </li>
                </ul>
                <div class="block-content tab-content bg-gray-lighter">
                    <div class="tab-pane active" id="btabs-alt-static-justified-basic_info">
                        <div class="content-grid">
					        <div class="row">
					            <div class="col-xs-6">
					                <div class="block">
					                    <div class="block-content">
						                    <p>
						                        <span id="_table_user_id"><?php echo $this->lang->line('user_id'); ?> : </span>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_create_type"><?php echo $this->lang->line('create_type'); ?> : </span>
					                        </p>
					                    </div>
					                </div>
					            </div>
					            <div class="col-xs-6">
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_birth_datetime"><?php echo $this->lang->line('birth_datetime'); ?> : </span>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_partner_user_id"><?php echo $this->lang->line('user_id'); ?> : </span>
						                    </p>
					                    </div>
					                </div>
					            </div>
					            <div class="col-xs-6">
					                <div class="block">
					                    <div class="block-content">
						                    <p>
						                        <span id="_table_partner_user_id"><?php echo $this->lang->line('user_id'); ?> : </span>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_user_account"><?php echo $this->lang->line('user_account'); ?> : </span>
						                    </p>
					                    </div>
					                </div>
					            </div>
					            <div class="col-xs-6">
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_email"><?php echo $this->lang->line('email'); ?> : </span>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <span class="col-md-10" style="padding-left: 0;" id="_table_block_type"><?php echo $this->lang->line('status'); ?> : </span>
					                        <form class="push-10" id="frmLeave" method="post">
						                        <input type="hidden" id="_user_id" name="_user_id" value="0">
						                        <input type="hidden" id="_user_account" name="_user_account" value="0">
						                        <button class="btn btn-info inline" id="btnLeave" type="submit"><?php echo $this->lang->line('leave_btn'); ?></button>
						                    </form>
					                    </div>
					                </div>
					            </div>
					        </div>
					    </div>
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-justified-access_info">
                        <!-- Dynamic Table Full Pagination -->
				        <div class="row">
						    <div class="col-xs-12 form-group">
					            <label class="col-md-2"><?php echo $this->lang->line('access_search_term'); ?></label>
					            <div class="col-md-8">
					                <label class="radio-inline" for="search_term1">
					                    <input type="radio" id="access_search_term1" name="access_search_term" value="0:D"> <?php echo $this->lang->line('search_term_today'); ?>
					                </label>
					                <label class="radio-inline" for="search_term2">
					                    <input type="radio" id="access_search_term2" name="access_search_term" value="7:D"> <?php echo $this->lang->line('search_term_lastweek'); ?>
					                </label>
					                <label class="radio-inline" for="search_term3">
					                    <input type="radio" id="access_search_term3" name="access_search_term" value="1:M"> <?php echo $this->lang->line('search_term_lastmonth'); ?>
					                </label>
					                <label class="radio-inline" for="search_term4">
					                    <input type="radio" id="access_search_term4" name="access_search_term" value="6:M"> <?php echo $this->lang->line('search_term_lasthalfyear'); ?>
					                </label>
					                <label class="radio-inline" for="search_term5">
					                    <input type="radio" id="access_search_term5" name="access_search_term" value="10:Y"> <?php echo $this->lang->line('search_term_total'); ?>
					                </label>
					            </div>
					        </div>
							<div class="col-xs-12 form-group">
					            <label class="col-md-2 control-label" for="example-daterange1"><?php echo $this->lang->line('search_term_range'); ?></label>
					            <div class="col-md-8">
					                <div class="col-md-8 input-daterange input-group" data-date-format="yyyy/mm/dd">
					                    <input class="form-control js-datepicker" type="text" id="access_daterange1" name="access_daterange1">
					                    <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
					                    <input class="form-control" type="text" id="access_daterange2" name="access_daterange2">
					                </div>
					            </div>
					        </div>
				        </div>
					    <div class="block">
					        <div class="block-content">
					            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
					            <table class="table table-hover table-bordered table-header-bg js-dataTable-full-pagination" id="access_info" style="width:100%;">
					                <thead>
					                    <tr>
					                        <th class="text-center"><?php echo $this->lang->line('access_datetime'); ?></th>
					                        <th><?php echo $this->lang->line('access_ipaddress'); ?></th>
					                        <th class="hidden-xs"><?php echo $this->lang->line('access_uuid'); ?></th>
					                        <th class="hidden-xs" style="width: 15%;"><?php echo $this->lang->line('access_create_type'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('access_os'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('access_country'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('access_version'); ?></th>
					                    </tr>
					                </thead>
					                <tbody>
					                    <tr>
					                        <td class="text-center">1</td>
					                        <td class="font-w600"><?php $one->get_name(); ?></td>
					                        <td class="hidden-xs">client1@example.com</td>
					                        <td class="hidden-xs">client1@example.com</td>
					                        <td class="hidden-xs">client1@example.com</td>
					                        <td class="hidden-xs">
					                            <?php $one->get_label(); ?>
					                        </td>
					                        <td class="text-center">
					                            <div class="btn-group">
					                                <button class="btn btn-xs btn-default" type="button" data-toggle="tooltip" title="Edit Client"><i class="fa fa-pencil"></i></button>
					                                <button class="btn btn-xs btn-default" type="button" data-toggle="tooltip" title="Remove Client"><i class="fa fa-times"></i></button>
					                            </div>
					                        </td>
					                    </tr>
					                </tbody>
					            </table>
					        </div>
					    </div>
					    <!-- END Dynamic Table Full Pagination -->
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-justified-payment_info">
                        <div class="block">
					        <div class="block-content">
					            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
					            <table class="table table-hover table-bordered table-header-bg js-dataTable-full-pagination" id="payment_info" style="width:100%;">
					                <thead>
					                    <tr>
					                        <th class="text-center">TID</th>
					                        <th><?php echo $this->lang->line('pay_type'); ?></th>
					                        <th class="hidden-xs"><?php echo $this->lang->line('store'); ?></th>
					                        <th class="hidden-xs" style="width: 15%;"><?php echo $this->lang->line('product'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('amount'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('last_change_datetime'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('status'); ?></th>
					                    </tr>
					                </thead>
					                <tbody>
					                    <tr>
					                        <td class="text-center">1</td>
					                        <td class="font-w600"></td>
					                        <td class="hidden-xs">client1@example.com</td>
					                        <td class="hidden-xs">client1@example.com</td>
					                        <td class="hidden-xs">client1@example.com</td>
					                        <td class="hidden-xs">client1@example.com</td>
					                        <td class="hidden-xs">client1@example.com</td>
					                    </tr>
					                </tbody>
					            </table>
					        </div>
					    </div>
					    <!-- END Dynamic Table Full Pagination -->
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-justified-join_log">
                        <!-- Dynamic Table Full Pagination -->
                        <div class="block">
					        <div class="block-content">
					            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
					            <table class="table table-hover table-bordered table-header-bg js-dataTable-full-pagination" id="join_log" style="width:100%;">
					                <thead>
					                    <tr>
					                        <th class="text-center"><?php echo $this->lang->line('join_log_status'); ?></th>
					                        <th><?php echo $this->lang->line('join_log_datetime'); ?></th>
					                        <th class="hidden-xs"><?php echo $this->lang->line('join_log_manager'); ?></th>
					                        <th class="hidden-xs" style="width: 15%;"><?php echo $this->lang->line('join_log_memo'); ?></th>
					                    </tr>
					                </thead>
					                <tbody>
					                    <tr>
					                        <td class="text-center">1</td>
					                        <td class="font-w600"><?php $one->get_name(); ?></td>
					                        <td class="hidden-xs">client1@example.com</td>
					                        <td class="hidden-xs">client1@example.com</td>
					                    </tr>
					                </tbody>
					            </table>
					        </div>
					    </div>
					    <!-- END Dynamic Table Full Pagination -->
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-justified-block_info">
                        <!-- Dynamic Table Full Pagination -->
				        <div class="row">
						    <div class="col-xs-6 form-group">
					            <label class="col-md-8"><?php echo $this->lang->line('title_auth_block'); ?> : 정상</label>
					            <div class="col-md-4">
						            <button class="btn btn-info" data-toggle="modal" id="btnAuthBlock" data-target="#modal-authblock" type="button"><?php echo $this->lang->line('title_auth_block'); ?></button>
					            </div>
					        </div>
							<div class="col-xs-6 form-group">
					            <label class="col-md-8"><?php echo $this->lang->line('title_bill_block'); ?> : 정상</label>
					            <div class="col-md-4">
						            <button class="btn btn-info" data-toggle="modal" id="btnBillBlock" data-target="#modal-billblock" type="button"><?php echo $this->lang->line('title_bill_block'); ?></button>
					            </div>
					        </div>
				        </div>
					    <div class="block">
					        <div class="block-content">
					            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
					            <table class="table table-hover table-bordered table-header-bg js-dataTable-full-pagination" id="block_info" style="width:100%;">
					                <thead>
					                    <tr>
					                        <th class="text-center"><?php echo $this->lang->line('block_admin'); ?></th>
					                        <th><?php echo $this->lang->line('block_reason'); ?></th>
					                        <th class="hidden-xs"><?php echo $this->lang->line('block_datetime'); ?></th>
					                        <th class="hidden-xs" style="width: 15%;"><?php echo $this->lang->line('block_type'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('block_action'); ?></th>
					                    </tr>
					                </thead>
					                <tbody>
					                    <tr>
					                        <td class="text-center">1</td>
					                        <td class="font-w600"><?php $one->get_name(); ?></td>
					                        <td class="hidden-xs">client1@example.com</td>
					                        <td class="hidden-xs">client1@example.com</td>
					                        <td class="hidden-xs">client1@example.com</td>
					                    </tr>
					                </tbody>
					            </table>
					        </div>
					    </div>
					    <!-- END Dynamic Table Full Pagination -->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal-authblock" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title"><?php echo $this->lang->line('title_auth_block'); ?></h3>
                </div>
                <div class="block-content">
		            <!-- Material Forms Validation -->
		            <div class="block">
		                <div class="block-content block-content-narrow">
				            <h2 class="content-heading"><?php echo $this->lang->line('title_auth_block'); ?> (<?php echo $this->lang->line('desc_auth_block'); ?>)</h2>
		                    <!-- jQuery Validation (.js-validation-material class is initialized in js/pages/base_forms_validation.js) -->
		                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
							<form class="js-validation-material form-horizontal push-10-t" action="base_forms_validation.php" method="post" novalidate="novalidate">
		                        <div class="form-group">
			                        <div class="col-sm-12">
			                            <label class="radio-inline" for="example-inline-radio1">
			                                <input type="radio" id="block_perm_radio" name="block_period" value="option1"> <?php echo $this->lang->line('block_permenent'); ?>
			                            </label>
			                            <label class="radio-inline" for="example-inline-radio2">
			                                <input type="radio" id="block_peri_radio" name="block_period" value="option2"> <?php echo $this->lang->line('block_period'); ?>
			                            </label>&nbsp;&nbsp;
	                                    <select class="js-select2 form-control select2-hidden-accessible" id="period_select" name="period_select" style="width: 50%;" data-placeholder="<?php echo $this->lang->line('select_period'); ?>" tabindex="-1" disabled="true">
	                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
	                                        <option value="1:D">1<?php echo $this->lang->line('daystring'); ?></option>
	                                        <option value="2:D">2<?php echo $this->lang->line('daystring'); ?></option>
	                                        <option value="3:D">3<?php echo $this->lang->line('daystring'); ?></option>
	                                        <option value="4:D">4<?php echo $this->lang->line('daystring'); ?></option>
	                                        <option value="5:D">5<?php echo $this->lang->line('daystring'); ?></option>
	                                        <option value="6:D">6<?php echo $this->lang->line('daystring'); ?></option>
	                                        <option value="7:D">7<?php echo $this->lang->line('daystring'); ?></option>
	                                        <option value="8:D">8<?php echo $this->lang->line('daystring'); ?></option>
	                                        <option value="9:D">9<?php echo $this->lang->line('daystring'); ?></option>
	                                        <option value="10:D">10<?php echo $this->lang->line('daystring'); ?></option>
	                                        <option value="15:D">15<?php echo $this->lang->line('daystring'); ?></option>
	                                        <option value="30:D">30<?php echo $this->lang->line('daystring'); ?></option>
	                                    </select>
			                        </div>
			                    </div>
		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <div class="form-material">
		                                    <input class="form-control" type="text" id="block_reason" name="block_reason">
		                                    <label for="block_reason"><?php echo $this->lang->line('block_reason'); ?></label>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <div class="form-material">
		                                    <input class="form-control" type="text" id="user_message" name="user_message">
		                                    <label for="user_message"><?php echo $this->lang->line('user_message'); ?></label>
		                                </div>
		                            </div>
		                        </div>
			                </form>
		                </div>
		            </div>
		            <!-- END Material Forms Validation -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal"><?php echo $this->lang->line('cancel_button_text'); ?></button>
                <button class="btn btn-sm btn-primary blocksubmit" type="button" data-dismiss="modal" data-type="1"><i class="fa fa-check"></i> <?php echo $this->lang->line('confirm2_button_text'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal-billblock" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title"><?php echo $this->lang->line('title_bill_block'); ?></h3>
                </div>
                <div class="block-content">
		            <!-- Material Forms Validation -->
		            <div class="block">
		                <div class="block-content block-content-narrow">
				            <h2 class="content-heading"><?php echo $this->lang->line('title_bill_block'); ?> (<?php echo $this->lang->line('desc_bill_block'); ?>)</h2>
		                    <!-- jQuery Validation (.js-validation-material class is initialized in js/pages/base_forms_validation.js) -->
		                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
							<form class="js-validation-material form-horizontal push-10-t" action="base_forms_validation.php" method="post" novalidate="novalidate">
		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <div class="form-material">
		                                    <input class="form-control" type="text" id="block_reason" name="block_reason">
		                                    <label for="block_reason"><?php echo $this->lang->line('block_reason'); ?></label>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <div class="form-material">
		                                    <input class="form-control" type="text" id="user_message" name="user_message">
		                                    <label for="user_message"><?php echo $this->lang->line('user_message'); ?></label>
		                                </div>
		                            </div>
		                        </div>
			                </form>
		                </div>
		            </div>
		            <!-- END Material Forms Validation -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal"><?php echo $this->lang->line('cancel_button_text'); ?></button>
                <button class="btn btn-sm btn-primary blocksubmit" type="button" data-dismiss="modal" data-type="2"><i class="fa fa-check"></i> <?php echo $this->lang->line('confirm2_button_text'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-payment_detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title"><?php echo $this->lang->line('title_payment_detail'); ?></h3>
                </div>
                <div class="block-content">
		            <!-- Material Forms Validation -->
		            <div class="block">
		                <div class="block-content block-content-narrow">
		                    <!-- jQuery Validation (.js-validation-material class is initialized in js/pages/base_forms_validation.js) -->
		                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
							<form class="js-validation-material form-horizontal push-10-t" action="base_forms_validation.php" method="post" novalidate="novalidate">
		                        <div class="form-group border-b">
					                <div class="col-xs-4">TID : </div>
					                <div class="col-xs-8" id="paydet_tid">SLIUF862LSKN35KD31</div>
				                </div>
				                <div class="form-group border-b">
					                <div class="col-xs-4"><?php echo $this->lang->line('user_id'); ?> : </div>
					                <div class="col-xs-8" id="paydet_userid">112568</div>
				                </div>
				                <div class="form-group border-b">
					                <div class="col-xs-4"><?php echo $this->lang->line('store'); ?> : </div>
					                <div class="col-xs-8" id="paydet_store">naver</div>
				                </div>
				                <div class="form-group border-b">
					                <div class="col-xs-4"><?php echo $this->lang->line('product_id'); ?> : </div>
					                <div class="col-xs-8" id="paydet_productid">32442211565</div>
				                </div>
				                <div class="form-group border-b">
					                <div class="col-xs-4"><?php echo $this->lang->line('order_id'); ?> : </div>
					                <div class="col-xs-8" id="paydet_orderid">92615847354529</div>
				                </div>
				                <div class="form-group border-b">
					                <div class="col-xs-4"><?php echo $this->lang->line('pay_type'); ?> : </div>
					                <div class="col-xs-8" id="paydet_producttype">FNQL002</div>
				                </div>
				                <div class="form-group border-b">
					                <div class="col-xs-4"><?php echo $this->lang->line('product'); ?> : </div>
					                <div class="col-xs-8" id="paydet_product">보석 20,000</div>
				                </div>
				                <div class="form-group border-b">
					                <div class="col-xs-4"><?php echo $this->lang->line('amount'); ?>(<?php echo $this->lang->line('currency'); ?>) : </div>
					                <div class="col-xs-8" id="paydet_amount">20,000 (KRW)</div>
				                </div>
				                <div class="form-group border-b">
					                <div class="col-xs-4"><?php echo $this->lang->line('last_change_datetime'); ?> : </div>
					                <div class="col-xs-8" id="paydet_lastchangedatetime">2015-12-23 19:15:25</div>
				                </div>
				                <div class="form-group border-b">
					                <div class="col-xs-4"><?php echo $this->lang->line('status'); ?> : </div>
					                <div class="col-xs-8" id="paydet_status">성공</div>
				                </div>
			                </form>
		                </div>
		            </div>
		            <!-- END Material Forms Validation -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary" type="button" data-dismiss="modal"><i class="fa fa-check"></i> <?php echo $this->lang->line('confirm2_button_text'); ?></button>
            </div>
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
<script src="<?php echo $one->assets_folder; ?>/js/pages/user_info.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>