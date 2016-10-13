<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<?php
	if ( !empty( $arrAuth ) )
	{
		if ( array_key_exists( '_auth_write', $arrAuth ) )
		{
			if ( $arrAuth['_auth_write'] == '1' )
			{
?>
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
	                    <input type="hidden" id="_is_itemsearch" name="_is_itemsearch" value="0">
	                    <input type="hidden" id="_is_countconfirm" name="_is_countconfirm" value="0">
	                    <input type="hidden" id="_group_id" name="_group_id" value="">
	                    <input type="hidden" id="_group_count" name="_group_count" value="">
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
                        <div class="form-group">
                            <div class="col-sm-2">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_exp" name="_exp">
                                    <label for="_exp"><?php echo $this->lang->line('exp'); ?></label>
                                </div>
                            </div>
<?php
				$divCount = 1;
				foreach( ASSET_TYPE as $key => $val )
				{
					if ( $val == '' )
					{
						continue;
					}
					else
					{
						$divCount++;
?>
                            <div class="col-sm-2">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_<?php echo $val; ?>" name="_<?php echo $val; ?>">
                                    <label for="_<?php echo $val; ?>"><?php echo $this->lang->line($val); ?></label>
                                </div>
                            </div>
<?php
					}

					if ( $divCount % 6 == 0 )
					{
?>
                        </div>
<?php
						if ( count( array_filter( ASSET_TYPE ) ) > ( $divCount - 1 ) )
						{
?>
                        <div class="form-group">
<?php
						}
					}

					if ( count( array_filter( ASSET_TYPE ) ) == ( $divCount - 1 ) )
					{
						while ( $divCount % 6 > 0 )
						{
?>
							<div class="col-sm-2">
							</div>
<?php
							$divCount++;
						}
?>
                        </div>
<?php
					}
				}
?>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_item_id" name="_item_id">
                                    <label for="_item_id"><?php echo $this->lang->line('item_id'); ?></label>
                                </div>
                            </div>
                            <div class="col-sm-2" style="padding-top:15px;">
	                            <button class="btn btn-sm btn-primary" id="searchitem"><i class="fa fa-search"></i></button>
	                            <button class="btn btn-sm btn-danger" id="cancelsearchitem" style="display:none;"><i class="fa fa-close"></i></button>
                            </div>
                            <div class="col-sm-4" style="padding-top:15px;">
	                            <input class="form-control" type="text" id="_item_name" name="_item_name" readonly="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-2">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_item_count" name="_item_count">
                                    <label for="_item_count"><?php echo $this->lang->line('item_count'); ?></label>
                                </div>
                            </div>
                            <div class="col-xs-10" style="padding-top:15px;">
                                <button class="btn btn-sm btn-primary" id="checkcount"><i class="fa fa-check"></i></button>
                                <button class="btn btn-sm btn-danger" id="cancelcheckcount" style="display:none;"><i class="fa fa-close"></i></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <select class="js-select2 form-control" id="_title" name="_title" style="width: 100%;" data-placeholder="<?php echo $this->lang->line('title_need'); ?>">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
<?php
				foreach ( $arrTitle as $row )
				{
					$text = ( $this->session->userdata('language') == 'kr' ? $row['korean'] : $row['english'] );
?>
                                      <option value="<?php echo $row['target']; ?>"><?php echo $text; ?></option>
<?php
				}
?>
                                    </select>
                                    <label for="group_id"></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <textarea class="form-control" id="_contents" name="_contents" rows="8"></textarea>
                                    <label for="_contents"><?php echo $this->lang->line('_contents'); ?></label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Datetimepicker (Material forms) -->
	    </div>
	    <div class="col-lg-6">
            <!-- Datetimepicker (Material forms) -->
            <div class="block">
                <div class="block-content block-content-narrow">
                    <form class="form-horizontal push-10-t js-validation-register" id="frmSend2" method="post">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div style="padding-bottom:20px;">
	                                <label class="radio-inline" for="send0">
	                                    <input type="radio" id="send0" name="send" value="0"> <?php echo $this->lang->line('right_now'); ?>
	                                </label>
	                                <label class="radio-inline" for="send1">
	                                    <input type="radio" id="send1" name="send" value="1"> <?php echo $this->lang->line('reserve'); ?>
	                                </label>
	                            </div>
                                <div class="js-datetimepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="true" data-min-date="true">
                                    <input class="form-control" type="text" id="sendtime" name="sendtime" placeholder="Choose a date.." disabled="true" data-date-format="YYYY-MM-DD HH:mm">
                                    <label for="sendtime"><?php echo $this->lang->line('sendtype'); ?></label>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div style="padding-bottom:20px;">
	                                <label class="radio-inline" for="expire0">
	                                    <input type="radio" id="expire0" name="expire" value="0"> <?php echo $this->lang->line('none'); ?>
	                                </label>
	                                <label class="radio-inline" for="expire1">
	                                    <input type="radio" id="expire1" name="expire" value="1"> <?php echo $this->lang->line('settings'); ?>
	                                </label>
	                            </div>
                                <div class="js-datetimepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="true" data-min-date="true">
                                    <input class="form-control" type="text" id="expiretime" name="expiretime" placeholder="Choose a date.." disabled="true" data-date-format="YYYY-MM-DD HH:mm">
                                    <label for="expiretime"><?php echo $this->lang->line('expiretype'); ?></label>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_admin_memo" name="_admin_memo">
                                    <label for="_admin_memo"><?php echo $this->lang->line('_admin_memo'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="_url" name="_url">
                                    <label for="_url">URL</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button class="btn btn-lg btn-primary" style="float:right;" type="submit" id="btnSubmit">Submit</button>
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
<?php
			}
		}
	}
?>
<!-- Page Content -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <!-- Header BG Table -->
            <div class="block">
                <div class="block-content">
	                <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
		            <table class="table table-hover table-border table-header-bg js-dataTable-full" id="group_list">
		                <thead>
		                    <tr>
		                        <th class="text-center"><?php echo $this->lang->line('sendtime'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('attach'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('posttitle'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('usercount'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('success'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('fail'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('_admin_memo'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('admin_id'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('status'); ?></th>
		                        <th class="text-center"><?php echo $this->lang->line('details'); ?></th>
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
            </div>
            <!-- END Header BG Table -->
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<iframe id="frmDown" style="width:0px; height:0px;" src="about:blank"></iframe>
<script type="text/javascript">
	var session_language = '<?php echo $this->session->userdata('language'); ?>';
	var auth = { 'view' : <?php echo $arrAuth['_auth_view']; ?>, 'edit' : <?php echo $arrAuth['_auth_write']; ?> };
	var lang = <?php echo json_encode( $this->lang->language, JSON_UNESCAPED_UNICODE ); ?>;

	var title = {
<?php
	foreach ( $arrTitle as $key => $val )
	{
		$text = ( $this->session->userdata('language') == 'kr' ? $val['korean'] : $val['english'] );
		$text = str_replace('"', '', $text);
		echo "\t\t\"".$val['target']."\":\"".$text."\"";
		if ( key($arrTitle) == $key && end($arrTitle) == $val )
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
<script src="<?php echo $one->assets_folder; ?>/js/pages/massive_present.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>