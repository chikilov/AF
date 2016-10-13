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
            <label class="col-md-2 control-label" for="search_type"><?php echo $this->lang->line('search_account_type'); ?></label>
            <div class="col-md-8 form-inline">
                <select class="col-xs-4 js-select2 form-inline" id="search_type" name="search_type" style="width: 20%;" data-placeholder="Choose one..">
                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                    <option value="_user_account"><?php echo $this->lang->line('search_type_account'); ?></option>
                    <option value="_user_id"><?php echo $this->lang->line('search_type_seq'); ?></option>
                    <option value="_email"><?php echo $this->lang->line('search_type_email'); ?></option>
                    <option value="_player_name"><?php echo $this->lang->line('search_type_playername'); ?></option>
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
		                        <th class="text-center" style="width: 6%;"><?php echo $this->lang->line('server_id'); ?></th>
		                        <th class="text-center" style="width: 12%;"><?php echo $this->lang->line('player_name'); ?></th>
		                        <th class="text-center" style="width: 5%;"><?php echo $this->lang->line('level'); ?></th>
		                        <th class="text-center" style="width: 12%;"><?php echo $this->lang->line('birth_datetime'); ?></th>
		                        <th class="text-center" style="width: 5%;"><?php echo $this->lang->line('status'); ?></th>
		                        <th class="text-center" style="width: 12%;"><?php echo $this->lang->line('etime'); ?></th>
		                        <th class="text-center" style="width: 7%;"><?php echo $this->lang->line('detail'); ?></th>
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
		                        <td class="text-center"> - </td>
		                    </tr>
		                </tbody>
		            </table>
                    <input type="hidden" id="_player_id" name="_player_id" value="0">
                    <input type="hidden" id="_server_id" name="_server_id" value="-1">
                    <input type="hidden" id="_user_id" name="_user_id" value="0">
                    <input type="hidden" id="_user_account" name="_user_account" value="0">
                    <input type="hidden" id="_guild_name" name="_guild_name" value="0">
                    <input type="hidden" id="_level" name="_level" value="0">
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
<div class="modal" id="modal-large" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content bg-gray-lighter">
			<div class="modal-header bg-white">
				<table class="table table-header-bg table-bordered" id="headinfo">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->lang->line('user_id'); ?></th>
							<th class="text-center"><?php echo $this->lang->line('user_account'); ?></th>
							<th class="text-center"><?php echo $this->lang->line('email'); ?></th>
	                        <th class="text-center" style="width: 6%;"><?php echo $this->lang->line('server_id'); ?></th>
							<th class="text-center"><?php echo $this->lang->line('player_name'); ?></th>
							<th class="text-center"><?php echo $this->lang->line('level'); ?></th>
							<th class="text-center"><?php echo $this->lang->line('birth_datetime'); ?></th>
							<th class="text-center"><?php echo $this->lang->line('status'); ?></th>
							<th class="text-center"><?php echo $this->lang->line('etime'); ?></th>
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
	                        <td class="text-center"> - </td>
	                        <td class="text-center"> - </td>
	                        <td class="text-center"> - </td>
	                        <td class="text-center"> - </td>
						</tr>
					</tbody>
				</table>
			</div>
	        <div class="block bg-gray-lighter" style="margin-bottom: 0;">
                <ul class="nav nav-tabs nav-tabs-alt nav-justified" data-toggle="tabs" id="myTab">
                    <li class="active">
                        <a href="#btabs-alt-static-justified-basic_info"><i class="fa fa-user"></i> <?php echo $this->lang->line('character_detail'); ?></a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-justified-item_info"><i class="fa fa-shopping-bag"></i> <?php echo $this->lang->line('character_inventory'); ?></a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-justified-mecha_info"><i class="fa fa-steam"></i> <?php echo $this->lang->line('mecha_inventory'); ?></a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-justified-pet_info"><i class="fa fa-paw"></i> <?php echo $this->lang->line('pet_inventory'); ?></a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-justified-storage_info"><i class="fa fa-truck"></i> <?php echo $this->lang->line('storage_info'); ?></a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-justified-track_info"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('track_info'); ?></a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-justified-guild_info"><i class="fa fa-group"></i> <?php echo $this->lang->line('guild_info'); ?></a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-justified-mailbox_info"><i class="fa fa-envelope-o"></i> <?php echo $this->lang->line('mailbox_info'); ?></a>
                    </li>
                </ul>
                <div class="block-content tab-content bg-gray-lighter">
                    <div class="tab-pane active" id="btabs-alt-static-justified-basic_info">
                        <div class="content-grid">
					        <div class="row">
					            <div class="col-xs-4">
					                <div class="block">
					                    <div class="block-content" style="min-height: 63px;">
						                    <p>
					                        	<span id="_table_user_account"><?php echo $this->lang->line('user_account'); ?> : </span>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_email"><?php echo $this->lang->line('email'); ?> : </span>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content" style="min-height: 63px;">
						                    <p>
					                        	<span id="_table_guild_name"><?php echo $this->lang->line('guildname'); ?> : </span>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content" style="min-height: 63px;">
						                    <p>
					                        	<span id="_table_power"><?php echo $this->lang->line('power'); ?> : </span>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_online"><?php echo $this->lang->line('online'); ?> : </span>
					                        	<button class="btn btn-xs btn-primary" style="float:right;" id="btnLogOff" type="button"><i class="glyphicon glyphicon-off"></i></button>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_valid"><?php echo $this->lang->line('valid'); ?> : </span>
					                        	<button class="btn btn-xs btn-primary" style="float:right;" id="btnLeave" type="button"><i class="glyphicon glyphicon-trash"></i></button>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_blockchat"><?php echo $this->lang->line('blockchat'); ?> : </span>
					                        	<button class="btn btn-xs btn-primary padding-r-10" style="float:right;" type="button" id="btnBlockChat"><?php echo $this->lang->line('blockchat'); ?></button>
						                    </p>
					                    </div>
					                </div>
					            </div>
					            <div class="col-xs-4">
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_player_name"><?php echo $this->lang->line('player_name'); ?> : </span>
					                        	<button class="btn btn-xs btn-primary btn-edit" data-toggle="modal" data-target="#modal-normal" data-type="player_name" style="float:right;" type="button"><i class="fa fa-pencil"></i></button>
					                        </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_server_id"><?php echo $this->lang->line('server_id'); ?> : </span>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content" style="min-height: 63px;">
						                    <p>
					                        	<span id="_table_buddy"><?php echo $this->lang->line('buddy'); ?> : </span>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_invencount"><?php echo $this->lang->line('invencount'); ?> : </span>
					                        	<button class="btn btn-xs btn-primary btn-edit" data-toggle="modal" data-target="#modal-normal" data-type="invencount" style="float:right;" type="button"><i class="fa fa-pencil"></i></button>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_gold"><?php echo $this->lang->line('gold'); ?> : </span>
					                        	<button class="btn btn-xs btn-primary btn-edit" data-toggle="modal" data-target="#modal-normal" data-type="gold" style="float:right;" type="button"><i class="fa fa-pencil"></i></button>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_gem"><?php echo $this->lang->line('gem'); ?> : </span>
					                        	<button class="btn btn-xs btn-primary btn-edit" data-toggle="modal" data-target="#modal-normal" data-type="gem" style="float:right;" type="button"><i class="fa fa-pencil"></i></button>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_vipgrade"><?php echo $this->lang->line('vipgrade'); ?> : </span>
					                        	<button class="btn btn-xs btn-primary btn-edit" data-toggle="modal" data-target="#modal-normal" data-type="vipgrade" style="float:right;" type="button"><i class="fa fa-pencil"></i></button>
						                    </p>
					                    </div>
					                </div>
					            </div>
					            <div class="col-xs-4">
					                <div class="block">
					                    <div class="block-content" style="min-height: 63px;">
						                    <p>
						                        <span id="_table_player_id"><?php echo $this->lang->line('player_id'); ?> : </span>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_class"><?php echo $this->lang->line('class'); ?> : </span>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content" style="min-height: 63px;">
						                    <p>
					                        	<span id="_table_level"><?php echo $this->lang->line('level'); ?> : </span>
					                        	<button class="btn btn-xs btn-primary btn-edit" data-toggle="modal" data-target="#modal-normal" data-type="level" style="float:right;" type="button"><i class="fa fa-pencil"></i></button>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_exp"><?php echo $this->lang->line('exp'); ?> : </span>
					                        	<button class="btn btn-xs btn-primary btn-edit" data-toggle="modal" data-target="#modal-normal" data-type="exp" style="float:right;" type="button"><i class="fa fa-pencil"></i></button>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_guildpoint"><?php echo $this->lang->line('guildpoint'); ?> : </span>
					                        	<button class="btn btn-xs btn-primary btn-edit" data-toggle="modal" data-target="#modal-normal" data-type="guildpoint" style="float:right;" type="button"><i class="fa fa-pencil"></i></button>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_free_gem"><?php echo $this->lang->line('free_gem'); ?> : </span>
					                        	<button class="btn btn-xs btn-primary btn-edit" data-toggle="modal" data-target="#modal-normal" data-type="free_gem" style="float:right;" type="button"><i class="fa fa-pencil"></i></button>
						                    </p>
					                    </div>
					                </div>
					                <div class="block">
					                    <div class="block-content">
						                    <p>
					                        	<span id="_table_gem_charge_sum"><?php echo $this->lang->line('gem_charge_sum'); ?> : </span>
					                        	<button class="btn btn-xs btn-primary btn-edit" data-toggle="modal" data-target="#modal-normal" data-type="gem_charge_sum" style="float:right;" type="button"><i class="fa fa-pencil"></i></button></span>
						                    </p>
					                    </div>
					                </div>
					            </div>
					        </div>
					        <div class="row">
								<table class="table table-header-bg table-bordered table-hover bg-white" id="adminlog">
									<thead>
										<tr>
											<th class="text-center">NO</th>
											<th class="text-center"><?php echo $this->lang->line('access_datetime'); ?></th>
											<th class="text-center"><?php echo $this->lang->line('access_ipaddress'); ?></th>
											<th class="text-center"><?php echo $this->lang->line('admin_account'); ?></th>
											<th class="text-center"><?php echo $this->lang->line('user_id'); ?></th>
											<th class="text-center"><?php echo $this->lang->line('admin_memo'); ?></th>
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
					                        <td class="text-center"> - </td>
										</tr>
									</tbody>
								</table>
					        </div>
					    </div>
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-justified-item_info">
                        <!-- Dynamic Table Full Pagination -->
					    <div class="block">
					        <div class="block-content">
					            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
					            <table class="table table-hover table-bordered table-header-bg js-dataTable-full-pagination" id="item_info" style="width:100%;">
					                <thead>
					                    <tr>
					                        <th class="text-center"><?php echo $this->lang->line('owner'); ?></th>
					                        <th><?php echo $this->lang->line('item_name'); ?></th>
					                        <th class="hidden-xs"><?php echo $this->lang->line('tid'); ?></th>
					                        <th class="hidden-xs" style="width: 15%;"><?php echo $this->lang->line('count'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('limit_time'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('distraint_status'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('acquired_time'); ?></th>
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
                    <div class="tab-pane" id="btabs-alt-static-justified-mecha_info">
                        <!-- Dynamic Table Full Pagination -->
					    <div class="block">
					        <div class="block-content">
					            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
					            <table class="table table-hover table-bordered table-header-bg js-dataTable-full-pagination" id="mecha_info" style="width:100%;">
					                <thead>
					                    <tr>
					                        <th class="text-center"><?php echo $this->lang->line('owner'); ?></th>
					                        <th><?php echo $this->lang->line('item_name'); ?></th>
					                        <th class="hidden-xs"><?php echo $this->lang->line('tid'); ?></th>
					                        <th class="hidden-xs" style="width: 15%;"><?php echo $this->lang->line('count'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('limit_time'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('distraint_status'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('acquired_time'); ?></th>
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
                    <div class="tab-pane" id="btabs-alt-static-justified-pet_info">
                        <!-- Dynamic Table Full Pagination -->
					    <div class="block">
					        <div class="block-content">
					            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
					            <table class="table table-hover table-bordered table-header-bg js-dataTable-full-pagination" id="pet_info" style="width:100%;">
					                <thead>
					                    <tr>
					                        <th class="text-center"><?php echo $this->lang->line('owner'); ?></th>
					                        <th><?php echo $this->lang->line('item_name'); ?></th>
					                        <th class="hidden-xs"><?php echo $this->lang->line('tid'); ?></th>
					                        <th class="hidden-xs" style="width: 15%;"><?php echo $this->lang->line('count'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('limit_time'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('distraint_status'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('acquired_time'); ?></th>
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
                    <div class="tab-pane" id="btabs-alt-static-justified-storage_info">
                        <!-- Dynamic Table Full Pagination -->
					    <div class="block">
					        <div class="block-content">
					            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
					            <table class="table table-hover table-bordered table-header-bg js-dataTable-full-pagination" id="storage_info" style="width:100%;">
					                <thead>
					                    <tr>
					                        <th class="text-center"><?php echo $this->lang->line('owner'); ?></th>
					                        <th><?php echo $this->lang->line('item_name'); ?></th>
					                        <th class="hidden-xs"><?php echo $this->lang->line('tid'); ?></th>
					                        <th class="hidden-xs" style="width: 15%;"><?php echo $this->lang->line('count'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('limit_time'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('distraint_status'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('acquired_time'); ?></th>
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
                    <div class="tab-pane" id="btabs-alt-static-justified-track_info">
                        <!-- Dynamic Table Full Pagination -->
					    <div class="block">
					        <div class="block-content">
					            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
					            <table class="table table-hover table-bordered table-header-bg js-dataTable-full-pagination" id="track_info" style="width:100%;">
					                <thead>
					                    <tr>
					                        <th class="text-center"><?php echo $this->lang->line('quest_index'); ?></th>
					                        <th><?php echo $this->lang->line('quest_name'); ?></th>
					                        <th class="hidden-xs"><?php echo $this->lang->line('daily_play_count'); ?></th>
					                        <th class="hidden-xs"><?php echo $this->lang->line('daily_autoplay_count'); ?></th>
					                        <th class="hidden-xs"><?php echo $this->lang->line('max_grade'); ?></th>
					                        <th class="hidden-xs" style="width: 15%;"><?php echo $this->lang->line('total_clear'); ?></th>
					                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('last_datetime'); ?></th>
					                    </tr>
					                </thead>
					                <tbody>
					                    <tr>
					                        <td class="text-center">1</td>
					                        <td class="text-center">-</td>
					                        <td class="text-center">-</td>
					                        <td class="text-center">-</td>
					                        <td class="text-center">-</td>
					                        <td class="text-center">-</td>
					                        <td class="text-center">-</td>
					                    </tr>
					                </tbody>
					            </table>
					        </div>
					    </div>
					    <!-- END Dynamic Table Full Pagination -->
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-justified-guild_info">
			            <form class="form-horizontal" action="base_forms_pickers_more.php" method="post" onsubmit="return false;">
	                        <!-- Dynamic Table Full Pagination -->
					        <div class="row">
							    <div class="col-xs-6 form-group bg-white">
								    <div class="block col-xs-16">
									    <div class="block-content">
				                            <label class="col-md-2 control-label" for="sel_server"><?php echo $this->lang->line('select_server'); ?></label>
				                            <div class="col-md-2">
				                                <select class="js-select2 form-control" id="sel_server" name="sel_server" style="width: 100%;">
				                                    <option value="1">1</option>
				                                    <option value="2">2</option>
				                                </select>
				                            </div>
				                            <label class="col-md-2 control-label" for="guild_name"><?php echo $this->lang->line('guild_name'); ?></label>
				                            <div class="col-md-4">
				                                <input class="form-control" type="text" id="guild_name" name="guild_name">
				                            </div>
				                            <div class="col-md-2">
												<button class="btn btn-default" id="btnGuildSearch"><i class="fa fa-search"></i></button>
				                            </div>
									    </div>
								    </div>
								    <div class="block col-xs-12">
									    <div class="block-content">
								            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
								            <table class="table table-hover table-bordered" id="guild_info" style="width:100%;">
								                <tbody>
								                    <tr>
								                        <th class="text-center btn-primary col-xs-4"><?php echo $this->lang->line('guild_name'); ?></th>
								                        <td class="text-center" id="_table_guild_nm">-</td>
								                    </tr>
								                    <tr>
								                        <th class="text-center btn-primary col-xs-4"><?php echo $this->lang->line('guild_owner'); ?></th>
								                        <td class="text-center" id="_table_guild_master_name">-</td>
								                    </tr>
								                    <tr>
								                        <th class="text-center btn-primary col-xs-4"><?php echo $this->lang->line('guild_user_count'); ?></th>
								                        <td class="text-center" id="_table_guild_pl_cnt">-</td>
								                    </tr>
								                    <tr>
								                        <th class="text-center btn-primary col-xs-4"><?php echo $this->lang->line('create_date'); ?></th>
								                        <td class="text-center" id="_table_guild_insert_date">-</td>
								                    </tr>
								                    <tr>
								                        <th class="text-center btn-primary col-xs-4"><?php echo $this->lang->line('guild_level'); ?></th>
								                        <td class="text-center" id="_table_guild_level">-</td>
								                    </tr>
								                    <tr>
								                        <th class="text-center btn-primary col-xs-4"><?php echo $this->lang->line('guild_rank'); ?></th>
								                        <td class="text-center" id="_table_guild_rank">-</td>
								                    </tr>
								                    <tr>
								                        <th class="text-center btn-primary col-xs-4"><?php echo $this->lang->line('occupy_area'); ?></th>
								                        <td class="text-center" id="_table_guild_occupy">-</td>
								                    </tr>
								                    <tr>
								                        <th class="text-center btn-primary col-xs-4"><?php echo $this->lang->line('guild_image'); ?></th>
								                        <td class="text-center" id="_table_guild_mark">-,_guild_color, _mark_id</td>
								                    </tr>
								                </tbody>
								            </table>
							            </div>
								    </div>
							    </div>
							    <div class="block col-xs-6">
								    <div class="block-header">
								        <h3 class="block-title"><?php echo $this->lang->line('guild_member_list'); ?></h3>
								    </div>
						            <div class="block-content">
							            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
							            <table class="table table-hover table-bordered table-header-bg js-dataTable-full-pagination" id="guildmember_info">
							                <thead>
							                    <tr>
							                        <th class="text-center"><?php echo $this->lang->line('player_name'); ?></th>
							                        <th><?php echo $this->lang->line('player_id'); ?></th>
							                        <th class="hidden-xs"><?php echo $this->lang->line('level'); ?></th>
							                        <th class="hidden-xs" style="width: 15%;"><?php echo $this->lang->line('class'); ?></th>
							                        <th class="text-center" style="width: 10%;"><?php echo $this->lang->line('position'); ?></th>
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
					        </div>
						    <!-- END Dynamic Table Full Pagination -->
			            </form>
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-justified-mailbox_info">
                        <!-- Dynamic Table Full Pagination -->
					    <div class="block">
						    <div class="block-header">
						        <h3 class="block-title"><?php echo $this->lang->line('mail_list'); ?></h3>
						    </div>
					        <div class="block-content">
					            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
					            <table class="table table-hover table-bordered table-header-bg js-dataTable-full-pagination" id="mailbox_info" style="width:100%;">
					                <thead>
					                    <tr>
					                        <th class="text-center"><?php echo $this->lang->line('send_datetime'); ?></th>
					                        <th class="text-center"><?php echo $this->lang->line('tid'); ?></th>
					                        <th class="text-center"><?php echo $this->lang->line('item_name'); ?></th>
					                        <th class="text-center"><?php echo $this->lang->line('count'); ?></th>
					                        <th class="text-center"><?php echo $this->lang->line('limit_time'); ?></th>
					                        <th class="text-center"><?php echo $this->lang->line('reason'); ?></th>
					                    </tr>
					                </thead>
					                <tbody>
					                    <tr>
					                        <td class="text-center">1</td>
					                        <td class="text-center">1</td>
					                        <td class="text-center">1</td>
					                        <td class="text-center">1</td>
					                        <td class="text-center">1</td>
					                        <td class="text-center">1</td>
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
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<script type="text/javascript">
	var session_language = '<?php echo $this->session->userdata('language'); ?>';
	var auth = { 'view' : <?php echo $arrAuth['_auth_view']; ?>, 'edit' : <?php echo $arrAuth['_auth_write']; ?> };
	var lang = <?php echo json_encode( $this->lang->language, JSON_UNESCAPED_UNICODE ); ?>;
	var serverlist = eval('<?php echo json_encode( $this->config->item('GAMEDB'), JSON_UNESCAPED_UNICODE ); ?>');
	var classtype = eval('<?php echo json_encode( CLASSTYPE, JSON_UNESCAPED_UNICODE ); ?>')
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/character_info.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>