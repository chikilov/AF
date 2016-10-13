/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */

var BaseTableDatatables = function() {
    // Init full DataTable, for more examples you can check out https://www.datatables.net/
    var res = true;
    $.validator.addMethod('namedupchk', function (value, element) {
	    jQuery.ajax({
		    type: 'POST',
		    url: '/Admin/groupnamecheck',
		    data: {'group_name':value},
		    success: function (result) {
			    res = ( parseInt(result) == 1 ? false : true );
		    }
	    });
	    return res;
    }, lang['group_name_dup'] );
    var initDataTableFull = function() {
        jQuery('#admin_auth').dataTable({
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 15,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
			"ajax": {
				"type"   : "POST",
				"url"    : '/Admin/admingroupauth',
				"data"   : {'group_id': jQuery('#group_id').val()},
				"dataSrc": ""
			},
			"columns": [
				{"className" : "text-center", "data" : "_id"},
				{"className" : "text-center", "data" : "_mtitle_" + session_language},
				{"className" : "text-center", "data" : "_stitle_" + session_language},
				{"className" : "text-center", "data" : "_auth_view", "render": function (data, type, row, meta) {
					return '<input class="group-view" type="checkbox"' + ( data == '1' ? ' checked' : '' ) + '>';
				}},
				{"className" : "text-center", "data" : "_auth_write", "render": function (data, type, row, meta) {
					return '<input class="group-write" type="checkbox"' + ( data == '1' ? ' checked' : '' ) + '>';
				}}
			],
			destroy: true,
			autoWidth: false,
			paging: false,
			info: false,
			searching: false,
			ordering: false
        });
    };

    // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFullPagination = function() {
        jQuery('.js-dataTable-full-pagination').dataTable({
            pagingType: "full_numbers",
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 20,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
			retrieve: true
        });
    };

    // DataTables Bootstrap integration
    var bsDataTables = function() {
        var $DataTable = jQuery.fn.dataTable;

        // Set the defaults for DataTables init
        jQuery.extend( true, $DataTable.defaults, {
            dom:
                "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            renderer: 'bootstrap',
            oLanguage: {
                sLengthMenu: "_MENU_",
                sInfo: "Showing <strong>_START_</strong>-<strong>_END_</strong> of <strong>_TOTAL_</strong>",
                oPaginate: {
                    sPrevious: '<i class="fa fa-angle-left"></i>',
                    sNext: '<i class="fa fa-angle-right"></i>'
                }
            }
        });

        // Default class modification
        jQuery.extend($DataTable.ext.classes, {
            sWrapper: "dataTables_wrapper form-inline dt-bootstrap",
            sFilterInput: "form-control",
            sLengthSelect: "form-control"
        });

        // Bootstrap paging button renderer
        $DataTable.ext.renderer.pageButton.bootstrap = function (settings, host, idx, buttons, page, pages) {
            var api     = new $DataTable.Api(settings);
            var classes = settings.oClasses;
            var lang    = settings.oLanguage.oPaginate;
            var btnDisplay, btnClass;

            var attach = function (container, buttons) {
                var i, ien, node, button;
                var clickHandler = function (e) {
                    e.preventDefault();
                    if (!jQuery(e.currentTarget).hasClass('disabled')) {
                        api.page(e.data.action).draw(false);
                    }
                };

                for (i = 0, ien = buttons.length; i < ien; i++) {
                    button = buttons[i];

                    if (jQuery.isArray(button)) {
                        attach(container, button);
                    }
                    else {
                        btnDisplay = '';
                        btnClass = '';

                        switch (button) {
                            case 'ellipsis':
                                btnDisplay = '&hellip;';
                                btnClass = 'disabled';
                                break;

                            case 'first':
                                btnDisplay = lang.sFirst;
                                btnClass = button + (page > 0 ? '' : ' disabled');
                                break;

                            case 'previous':
                                btnDisplay = lang.sPrevious;
                                btnClass = button + (page > 0 ? '' : ' disabled');
                                break;

                            case 'next':
                                btnDisplay = lang.sNext;
                                btnClass = button + (page < pages - 1 ? '' : ' disabled');
                                break;

                            case 'last':
                                btnDisplay = lang.sLast;
                                btnClass = button + (page < pages - 1 ? '' : ' disabled');
                                break;

                            default:
                                btnDisplay = button + 1;
                                btnClass = page === button ?
                                        'active' : '';
                                break;
                        }

                        if (btnDisplay) {
                            node = jQuery('<li>', {
                                'class': classes.sPageButton + ' ' + btnClass,
                                'aria-controls': settings.sTableId,
                                'tabindex': settings.iTabIndex,
                                'id': idx === 0 && typeof button === 'string' ?
                                        settings.sTableId + '_' + button :
                                        null
                            })
                            .append(jQuery('<a>', {
                                    'href': '#'
                                })
                                .html(btnDisplay)
                            )
                            .appendTo(container);

                            settings.oApi._fnBindAction(
                                node, {action: button}, clickHandler
                            );
                        }
                    }
                }
            };

            attach(
                jQuery(host).empty().html('<ul class="pagination"/>').children('ul'),
                buttons
            );
        };

        // TableTools Bootstrap compatibility - Required TableTools 2.1+
        if ($DataTable.TableTools) {
            // Set the classes that TableTools uses to something suitable for Bootstrap
            jQuery.extend(true, $DataTable.TableTools.classes, {
                "container": "DTTT btn-group",
                "buttons": {
                    "normal": "btn btn-default",
                    "disabled": "disabled"
                },
                "collection": {
                    "container": "DTTT_dropdown dropdown-menu",
                    "buttons": {
                        "normal": "",
                        "disabled": "disabled"
                    }
                },
                "print": {
                    "info": "DTTT_print_info"
                },
                "select": {
                    "row": "active"
                }
            });

            // Have the collection use a bootstrap compatible drop down
            jQuery.extend(true, $DataTable.TableTools.DEFAULTS.oTags, {
                "collection": {
                    "container": "ul",
                    "button": "li",
                    "liner": "a"
                }
            });
        }
    };

    var initValidator = function () {
	    jQuery('.js-validation-register').validate({
		    ignore: "",
            errorClass: 'help-block text-right animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function(error, e) {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: function(e) {
                jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            success: function(e) {
                jQuery(e).closest('.form-group').removeClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            rules: {
                'group_name': {
                    required: true,
                    namedupchk: true
                },
                'group_applies': {
                    required: true
                }
            },
            messages: {
                'group_name': {
                    required: lang['write_group_name']
                },
                'group_applies': {
                    required: lang['write_group_applies']
                }
            }
        });
    };

    return {
        init: function() {
            // Init Datatables
            bsDataTables();
            initDataTableFull();
            initDataTableFullPagination();
        },
        finit: function() {
            initValidator();
        }
    };
}();

// Initialize when page loads
jQuery(function(){
	BaseTableDatatables.finit();
    // Init page helpers (BS Datepicker + BS Datetimepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
    App.initHelpers(['datepicker', 'select2', ]);

	jQuery(document).on('click', '#btnSearch', function (e) {
		e.preventDefault();
		if ( jQuery('#group_id').val() != '' && jQuery('#group_id').val() != null )
		{
			jQuery('#group_applies').text( jQuery('#group_id > option:selected').data('applies') );
			BaseTableDatatables.init();
		}
	});

	jQuery('#admin_auth').on('draw.dt', function () {
		if ( jQuery('#admin_auth').DataTable().page.info().recordsTotal > 0 && auth.edit == '1' )
		{
			jQuery('#btnEdit').show();
			jQuery('#btnDelete').show();
		}
		else
		{
			jQuery('#btnEdit').hide();
			jQuery('#btnDelete').hide();
		}
	});

	jQuery(document).on('click', '#btnEdit', function () {
		var idarr = new Array();
		jQuery('#admin_auth').find('tbody > tr').each(function () {
			idarr.push(jQuery(this).find('td').eq(0).text())
		});

		var data = '[';
		for (var i = 0; i < idarr.length; i++)
		{
			if ( i > 0 )
			{
				data += ',';
			}
			data += '{"key":"' + idarr[i] + '","val":{"view":"' + jQuery('.group-view').eq(i).is(':checked').toString() + '","write":"' + jQuery('.group-write').eq(i).is(':checked').toString() + '"}}';
		}
		data += ']';

		jQuery.ajax({
			type: 'POST',
			url:'/Admin/authupdate',
			data: {'data' : JSON.stringify( data ), 'group_id': jQuery('#group_id').val() },
			success: function (result) {
				if ( parseInt(result) > 0 )
				{
					swal({
						title: lang['auth_edit'],
						text: lang['auth_edit_success'],
						type: 'success',
					}, function () {
						jQuery('#admin_auth').dataTable().api().ajax.reload();
					});
				}
				else
				{
					swal({
						title: lang['auth_edit'],
						text: lang['auth_edit_fail'],
						type: 'error',
					});
				}
			}
		});
	});

	jQuery(document).on('click', '#btnDelete', function () {
		swal({
			title: lang['auth_delete'],
			text: lang['auth_delete_text'],
			type: 'warning',
			showCancelButton: true,
			closeOnConfirm: false,
			closeOnCancel: true,
	        confirmButtonColor: '#DD6B55',
			confirmButtonText: lang['confirm_button_text'],
			cancelButtonText: lang['cancel_button_text'],
		}, function( isConfirm ) {
			if ( isConfirm )
			{
				jQuery.ajax({
					type: 'POST',
					url: '/Admin/groupdelete',
					async: false,
					data: {'group_id': jQuery('#group_id').val() },
					success: function ( result ) {
						if ( result == 'true' )
						{
							swal({
								title: lang['auth_delete'],
								text: lang['group_delete_success'],
								type: 'success',
							}, function () {
								jQuery("#group_id option[value='" + jQuery('#group_id').val() + "']").remove();
								jQuery('#group_id').trigger("change");
								jQuery('#group_applies').text('');
								jQuery('#admin_auth > tbody').html('<tr><td class="text-center"> - </td><td class="text-center"> - </td><td class="text-center"> - </td><td class="text-center"> - </td><td class="text-center"> - </td></tr>');
								jQuery('#btnEdit').hide();
								jQuery('#btnDelete').hide();
							});
						}
						else
						{
							swal({
								title: lang['auth_delete'],
								text: lang['group_delete_fail'],
								type: 'error',
							});
						}
					}
				});
			}
		});
	});

	jQuery(document).on('show.bs.modal', '#modal-large', function () {
        jQuery('#admin_auth_pop').dataTable({
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 15,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
			"ajax": {
				"type"   : "POST",
				"url"    : '/Admin/admingroupauth',
				"data"   : {'group_id': ''},
				"dataSrc": ""
			},
			"columns": [
				{"className" : "text-center", "data" : "_id"},
				{"className" : "text-center", "data" : "_mtitle_" + session_language},
				{"className" : "text-center", "data" : "_stitle_" + session_language},
				{"className" : "text-center", "data" : "_auth_view", "render": function (data, type, row, meta) {
					return '<input class="group-view" type="checkbox"' + ( data == '1' ? ' checked' : '' ) + '>';
				}},
				{"className" : "text-center", "data" : "_auth_write", "render": function (data, type, row, meta) {
					return '<input class="group-write" type="checkbox"' + ( data == '1' ? ' checked' : '' ) + '>';
				}}
			],
			destroy: true,
			autoWidth: false,
			paging: false,
			info: false,
			searching: false,
			ordering: false
        });
	});

	jQuery(document).on('submit', '.js-validation-register', function (e) {
		e.preventDefault();
		swal({
			title: lang['new_auth'],
			text: lang['new_auth_text'],
			type: 'warning',
			showCancelButton: true,
			closeOnConfirm: false,
			closeOnCancel: true,
	        confirmButtonColor: '#DD6B55',
			confirmButtonText: lang['confirm_button_text'],
			cancelButtonText: lang['cancel_button_text'],
		}, function( isConfirm ) {
			if ( isConfirm )
			{
				var group_id;
				jQuery.ajax({
					type: 'POST',
					url: '/Admin/groupinsert',
					async: false,
					data: {'group_name': jQuery('#group_name').val(), 'group_applies': jQuery('#igroup_applies').val() },
					success: function ( result ) {
						if ( result != 'false' )
						{
							group_id = result;
							var idarr = new Array();
							jQuery('#admin_auth_pop').find('tbody > tr').each(function () {
								idarr.push(jQuery(this).find('td').eq(0).text())
							});

							var data = '[';
							for (var i = 0; i < idarr.length; i++)
							{
								if ( i > 0 )
								{
									data += ',';
								}
								data += '{"key":"' + idarr[i] + '","val":{"view":"' + jQuery('#admin_auth_pop').find('.group-view').eq(i).is(':checked').toString() + '","write":"' + jQuery('#admin_auth_pop').find('.group-write').eq(i).is(':checked').toString() + '"}}';
							}
							data += ']';

							jQuery.ajax({
								type: 'POST',
								url:'/Admin/authupdate',
								data: {'data' : JSON.stringify( data ), 'group_id': group_id },
								success: function (subresult) {
									if ( parseInt(subresult) > 0 )
									{
										swal({
											title: lang['group_insert'],
											text: lang['group_insert_success'],
											type: 'success',
										}, function () {
											jQuery('#modal-large').modal('hide');
											var option = new Option( jQuery('#group_name').val(), group_id );
											jQuery('#group_id').append(option);
											jQuery('#group_id').trigger("change");
										});
									}
									else
									{
										swal({
											title: lang['group_insert'],
											text: lang['group_insert_fail'],
											type: 'error',
										});
									}
								}
							});
						}
						else
						{
							swal({
								title: lang['group_insert'],
								text: lang['group_insert_fail'],
								type: 'error',
							});
						}
					}
				});
			}
		});
	});

    if ( typeof auth == 'object' )
    {
	    if ( auth.edit == 0 )
	    {
		    jQuery('#btnWrite').hide();
	    }
    }
// Login Check Start
    jQuery.fn.dataTable.ext.errMode = 'none';
	jQuery(document).ajaxError(function(event, jqxhr, settings, thrownError) {
		if ( jqxhr.status == 901 )
		{
			swal({
				title: lang['need_to_login'],
				text: lang['need_to_login'],
				type: 'error'
			}, function () {
				window.location.href = '/Login';
			});
			return;
		}
		else
		{
			swal({
				title: lang['data_load_error'],
				text: lang['data_load_error'],
				type: 'error'
			}, function () {
				window.location.href = '/User/userinfo';
			});
			return;
		}
	});
// Login Check End
});
