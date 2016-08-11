/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */

// Initialize when page loads
jQuery(function(){
    // Init page helpers (BS Datepicker + BS Datetimepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
    App.initHelpers(['datetimepicker', 'select2', ]);

	jQuery(document).on('click', 'input[name=send]', function () {
		if ( jQuery(this).val() == '0' )
		{
			jQuery('#sendtime').attr( 'disabled', false );
			jQuery('#sendtime').attr( 'readonly', true );
			jQuery('#sendtime').val( moment(new Date()).format("YYYY-MM-DD HH:mm") );
		}
		else
		{
			jQuery('#sendtime').attr( 'disabled', false );
			jQuery('#sendtime').attr( 'readonly', false );
		}
	});

	jQuery(document).on('click', 'input[name=expire]', function () {
		if ( jQuery(this).val() == '0' )
		{
		}
		else
		{
			jQuery('#expiretime').attr( 'disabled', false );
		}
	});

	jQuery(document).on('click', '#searchitem', function (e) {
		e.preventDefault();
		if ( jQuery('#_item_id').val() != '' && jQuery('#_item_id').val() != null )
		{
			jQuery.ajax({
				type: 'POST',
				url: '/Present/searchitem',
				data: {'_item_id': jQuery('#_item_id').val()},
				success: function ( result ) {
					if ( result == '[]' )
					{
						swal({
							title: lang['item_search'],
							text: lang['item_search_fail'],
							type: 'warning',
						}, function () {
							jQuery('#_item_name').val('');
						});
						jQuery('#_is_itemsearch').val('0');
					}
					else
					{
						var obj = eval(result);
						if ( session_language == 'kr' )
						{
							jQuery('#_item_name').val(obj[0]._itemnamekor);
						}
						else if ( session_language == 'en' )
						{
							jQuery('#_item_name').val(obj[0]._itemnameeng);
						}
						jQuery('#_is_itemsearch').val('1');
						jQuery('#_item_id').attr('readonly', true);
						jQuery('#searchitem').hide();
						jQuery('#cancelsearchitem').show();
					}
				}
			});
		}
		else
		{
			swal({
				title: lang['item_search'],
				text: lang['no_item_id'],
				type: 'warning',
			});
		}
	});

	jQuery(document).on('click', '#checkcount', function (e) {
		e.preventDefault();
		if ( jQuery.isNumeric( jQuery('#_item_count').val() ) )
		{
			if ( jQuery('#_item_count').val() > 1000 )
			{
				swal({
					title: lang['item_count'],
					text: lang['item_count_confirm'] + '\n' + lang['item_count'] + ' : ' + jQuery('#_item_count').val() + '\n\n' + lang['password_need'] + '.',
					type: 'input',
					inputType: 'password',
					showCancelButton: true,
					closeOnConfirm: true,
					closeOnCancel: true,
			        confirmButtonColor: '#DD6B55',
					confirmButtonText: lang['confirm_button_text'],
					cancelButtonText: lang['cancel_button_text'],
				}, function( isConfirm ) {
					if ( isConfirm )
					{
						jQuery.ajax({
							type: 'POST',
							url: '/Present/checkpass',
							data: {'_password':isConfirm},
							success: function ( result ) {
								if ( result == 'true' )
								{
									jQuery('#_is_countconfirm').val('1');
									jQuery('#_item_count').attr('readonly', true);
									jQuery('#checkcount').hide();
									jQuery('#cancelcheckcount').show();
								}
								else
								{
									swal({
										title: lang['item_count'],
										text: lang['password_incorrect'],
										type: 'warning'
									});
								}
							}
						});
					}
				});
			}
			else
			{
				jQuery('#_is_countconfirm').val('1');
				jQuery('#_item_count').attr('readonly', true);
				jQuery('#checkcount').hide();
				jQuery('#cancelcheckcount').show();
			}
		}
		else
		{
			swal({
				title: lang['item_count'],
				text: lang['count_not_numeric'],
				type: 'warning'
			});
		}
	});

	jQuery(document).on('click', '#cancelcheckcount', function () {
		jQuery('#_item_count').parent().parent().parent().removeClass('has-success');
		jQuery('#_is_countconfirm').val('0');
		jQuery('#_item_count').attr('readonly', false);
		jQuery('#_item_count').val('');
		jQuery('#checkcount').show();
		jQuery('#cancelcheckcount').hide();
	});

	jQuery(document).on('click', '#cancelsearchitem', function () {
		jQuery('#_item_name').val('');
		jQuery('#_item_name').parent().parent().removeClass('has-success');
		jQuery('#_is_itemsearch').val('0');
		jQuery('#_item_id').attr('readonly', false);
		jQuery('#_item_id').val('');
		jQuery('#searchitem').show();
		jQuery('#cancelsearchitem').hide();
	});

	jQuery(document).on('change', '#userlist', function (e) {
		files = e.target.files;
		var data = new FormData();
		jQuery.each(files, function(key, value) {
		    data.append(key, value);
		});

		var filename = jQuery(this).val().substring(jQuery(this).val().lastIndexOf('\\') + 1, jQuery(this).val().length);
		var ext = filename.split('.').pop().toLowerCase();
		if ( jQuery.inArray(ext, ['xls','xlsx'] ) == -1 )
		{
			swal({
	            title: lang['file_upload'],
	            text: lang['only_excel'],
	            type: "error",
			}, function () {
				jQuery('#userlist').val('');
			});
		}
		else
		{
			swal({
	            title: lang['file_upload'],
	            text: lang['userlist'] + ' : ' + filename,
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes!",
	            closeOnConfirm: false
	        }, function( isConfirm )
	        {
		        if ( isConfirm )
		        {
					jQuery.ajax({
						url: "/Present/convertupload",
						type: "POST",
						data: data,
						async: false,
						cache: false,
						contentType: false,
						processData: false,
						success:  function(result){
							if ( result != '' && result != null )
							{
								swal({
						            title: lang['file_upload'],
						            text: lang['upload_success'],
						            type: "success"
								}, function () {
									jQuery('#frmDown').attr( 'src', result );
								});
							}
							else
							{
								swal({
						            title: lang['file_upload'],
						            text: lang['upload_fail'] + result,
						            type: "error"
								});
							}
						}
					});
				}
	        });
	    }
	});

	jQuery(document).on('click', '#btnSample', function () {
		jQuery('#frmDown').attr( 'src', '/upload/convertdata.xlsx' );
	});
});
