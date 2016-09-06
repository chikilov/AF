/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */

var BaseTableDatatables = function() {
    // Init full DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFull = function() {
	    var title, groupname;
        jQuery('#admin_menu').dataTable({
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
			"ajax": {
				"type"   : "POST",
				"url"    : '/Admin/menulist',
				"data"   : null,
				"dataSrc": ""
			},
			"columns": [
				{"className" : "text-center", "data" : "_id"},
				{"className" : "text-center", "data" : "_title_" + session_language},
				{"className" : "text-center", "data" : "_controller", "render" : function ( data, type, row, meta ) {
					return ( row._controller != null && row._view != null ? '/' + row._controller + '/' + row._view : '-' );
				}},
				{"className" : "text-center", "data" : "_order"},
//				{"className" : "text-center", "data" : "_require_login", "render" : function ( data, type, row, meta ) {
//					return ( data == '1' ? '<span class="label label-primary">' + lang['yes_in_use'] + '</span>' : '<span class="label label-warning">' + lang['not_in_use'] + '</span>' );
//				}},
				{"className" : "text-center", "data" : "_group_name_" + session_language, "render" : function ( data, type, row, meta ) {
					title = eval('row._title_' + session_language);
					groupname = eval('row._group_name_' + session_language);
					return ( title == groupname ? '<span class="label label-warning">' : '<span class="label label-info">' ) + groupname + '</span>';
				}},
				{"className" : "text-center", "data" : "_active", "render" : function ( data, type, row, meta ) {
					return ( data == '1' ? '<span class="label label-primary">' + lang['in_active'] + '</span>' : '<span class="label label-warning">' + lang['not_in_active'] + '</span>' );
				}},
				{"className" : "text-center", "data" : "_active", "render" : function ( data, type, row, meta ) {
					return '<button class="btn btn-info btn-xs" type="button" data-toggle="modal" data-target="#modal-large" data-idx="' + row._id + '"><i class="fa fa-pencil"></i></button>' + ( row._controller != null && row._view != null ? '&nbsp;<button class="btn btn-danger btn-xs" type="button" data-idx="' + row._id + '"><i class="fa fa-trash"></i></button>' : ( row._active == 0 || row._sub_count > 1 ? '' : '&nbsp;<button class="btn btn-danger btn-xs" type="button" data-idx="' + row._id + '"><i class="fa fa-trash"></i></button>' ) );
				}}
			],
			destroy: true,
			autoWidth: false,
			paging: false,
			info: false,
			searching: false,
			ordering: true,
			order: [[ 3, 'asc' ]]
        });

        jQuery('#admin_menu_seq').dataTable({
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            dom:
                "<'row'>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'>",
			"ajax": {
				"type"   : "POST",
				"url"    : '/Admin/menulist',
				"data"   : null,
				"dataSrc": ""
			},
			"columns": [
				{"className" : "text-center", "data" : "_title_" + session_language},
				{"className" : "text-center", "data" : "_order", "render" : function ( data, type, row, meta ) {
					return '<input type="text" class="form-control" name="order-' + row._id + '" value="' + data + '">';
				}},
				{"className" : "text-center", "data" : "_active", "render" : function ( data, type, row, meta ) {
					return ( data == '1' ? '<span class="label label-primary">' + lang['in_active'] + '</span>' : '<span class="label label-warning">' + lang['not_in_active'] + '</span>' );
				}}
			],
			destroy: true,
			autoWidth: false,
			paging: false,
			info: false,
			searching: false,
			ordering: true,
			order: [[ 1, 'asc' ]]
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
                "<'row'<'col-sm-2'i><'col-sm-4'p><'col-sm-6'B>>",
            renderer: 'bootstrap',
            oLanguage: {
                sLengthMenu: "_MENU_",
                sInfo: "Showing <strong>_START_</strong>-<strong>_END_</strong> of <strong>_TOTAL_</strong>",
                oPaginate: {
                    sPrevious: '<i class="fa fa-angle-left"></i>',
                    sNext: '<i class="fa fa-angle-right"></i>'
                }
            },
            buttons: [
            	{
	                text: '등록',
	                action: function ( e, dt, node, config ) {
	                }
	            }
			]
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

    return {
        init: function() {
            // Init Datatables
            bsDataTables();
            initDataTableFull();
            initDataTableFullPagination();
        }
    };
}();

// Initialize when page loads
jQuery(function(){ BaseTableDatatables.init(); });
var prevId = '0';
jQuery(function(){
    // Init page helpers (BS Datepicker + BS Datetimepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
    App.initHelpers(['datepicker', 'select2', ]);

    jQuery(document).on( 'click', '.btn-danger', function () {
	    var idx = jQuery(this).data('idx');
		swal({
			title: jQuery(this).parent().siblings('td').eq(1).text(),
			text: lang['delete_menu_text'],
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
					url: '/Admin/menudel',
					data: {'id': idx },
					success: function ( result ) {
						if ( result == 'true' )
						{
							swal({
								title: lang['delete_menu'],
								text: lang['delete_success_text'],
								type: 'success',
							}, function () {
								jQuery('#admin_menu').dataTable().api().ajax.reload();
							});
						}
						else
						{
							swal({
								title: lang['delete_menu'],
								text: lang['delete_fail_text'],
								type: 'error',
							});
						}
					}
				});
			}
		});
    });

    jQuery('#modal-large').on('show.bs.modal', function (e) {
		$('#modal-large h3').text(lang['menu_edit']);
	    var button = $(e.relatedTarget);
	    if ( button.data('idx') != '' && button.data('idx') != null )
	    {
		    jQuery('#_id').val( button.data('idx') );
		    jQuery.ajax({
			    type: 'POST',
				url: '/Admin/menudetails',
				data: {'id': button.data('idx') },
				success: function ( result ) {
					var obj = eval(result);
					jQuery('#_title_kr').val( obj[0]._title_kr );
					jQuery('#_title_en').val( obj[0]._title_en );
					jQuery('#_controller').val( obj[0]._controller );
					jQuery('#_view').val( obj[0]._view );
					jQuery('#_icon').val( obj[0]._icon );
					jQuery('#_group_id').val( obj[0]._parent_id ).trigger('change');
					if ( obj[0]._active == 1 )
					{
						jQuery('#_active_t').prop( 'checked', true );
					}
					else
					{
						jQuery('#_active_f').prop( 'checked', true );
					}
				}
		    });
		}
		else
		{
			jQuery('#_id').val('');
			jQuery('#frmMenu')[0].reset();
			jQuery('#_group_id').val('').trigger('change');
			jQuery('#_active_t').prop( 'checked', false );
			jQuery('#_active_f').prop( 'checked', false );
			jQuery('#modal-large h3').text(lang['menu_input']);
		}
    });

    jQuery('.dt-buttons').css('float', 'right').css('margin-top', '14px');
    jQuery('.dt-buttons').html('<button id="btnOrder" class="btn btn-primary" data-toggle="modal" data-target="#modal-normal"><i class="fa fa-sort-numeric-asc"></i></button>&nbsp;&nbsp;&nbsp;<button id="btnInput" class="btn btn-primary" data-toggle="modal" data-target="#modal-large" data-idx=""><i class="fa fa-edit"></i></button>');
    jQuery(document).on('click', '#btnSubmit', function () {
	    jQuery.ajax({
		    type: 'POST',
			url: '/Admin/menuupdate',
			data: {'_id': jQuery('#_id').val(), '_title_kr': jQuery('#_title_kr').val(), '_title_en': jQuery('#_title_en').val(),
					'_controller': jQuery('#_controller').val(), '_view': jQuery('#_view').val(), '_icon': jQuery('#_icon').val(),
					'_group_id': jQuery('#_group_id').val(), '_active': jQuery('input[name=_active]').val()
			},
			success: function ( result ) {
				if ( result == 'true' )
				{
					swal({
						title: ( jQuery('#_id').val() == '' ? lang['menu_insert_title'] : lang['menu_edit_title'] ),
						text: ( jQuery('#_id').val() == '' ? lang['menu_insert_success'] : lang['menu_edit_success'] ),
						type: 'success',
					}, function () {
						jQuery('#admin_menu').dataTable().api().ajax.reload();
					});
				}
				else
				{
					swal({
						title: ( jQuery('#_id').val() == '' ? lang['menu_insert_title'] : lang['menu_edit_title'] ),
						text: ( jQuery('#_id').val() == '' ? lang['menu_insert_fail'] : lang['menu_edit_fail'] ),
						type: 'error',
					});
				}
			}
	    });
    });

    jQuery(document).on('click', '#btnOrder', function () {
	    jQuery('#admin_menu_seq').dataTable().api().ajax.reload();
    });

    jQuery(document).on('click', '#btnOSubmit', function () {
	    var dataobj = {};
	    var tmpobj;
	    jQuery('input[name|=order]').each( function () {
		    dataobj[jQuery(this).attr('name')] = jQuery(this).val();
	    });

	    jQuery.ajax({
		    type: 'POST',
			url: '/Admin/menuorder',
			data: dataobj,
			success: function ( result ) {
				if ( result == 'true' )
				{
					swal({
						title: lang['menu_order'],
						text: lang['menu_order_success'],
						type: 'success',
					}, function () {
						jQuery('#admin_menu').dataTable().api().ajax.reload();
					});
				}
				else
				{
					swal({
						title: lang['menu_order'],
						text: lang['menu_order_fail'],
						type: 'error',
					});
				}
			}
	    });
    });

	jQuery('#admin_menu').on( 'draw.dt', function () {
	    if ( typeof auth == 'object' )
	    {
		    if ( auth.edit == 0 )
		    {
			    jQuery('#btnOrder, #btnInput').hide();
			    jQuery('#admin_menu > thead > tr > th:last').hide();
			    jQuery('#admin_menu > tbody > tr').each(function () {
					jQuery(this).children('td:last').hide();
			    });
		    }
	    }
	});
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
				window.location.reload();
			});
			return;
		}
	});
// Login Check End
});
