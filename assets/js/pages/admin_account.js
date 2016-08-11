/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */

var BaseTableDatatables = function() {
    // Init full DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFull = function() {
	    var title, groupname;
        jQuery('#admin_account').dataTable({
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 15,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
			"ajax": {
				"type"   : "POST",
				"url"    : '/Admin/accountlist',
				"data"   : null,
				"dataSrc": ""
			},
			"columns": [
				{"className" : "text-center", "data" : "_username"},
				{"className" : "text-center", "data" : "_name"},
				{"className" : "text-center", "data" : "_depart"},
				{"className" : "text-center", "data" : "_regdate"},
				{"className" : "text-center", "data" : "_ipaddr"},
				{"className" : "text-center", "data" : "_group_name"},
				{"className" : "text-center", "data" : "_approved", "render": function ( data, type, row, meta ) {
					return '<span class="label ' + ( row._deleted == '1' ? 'label-danger">' + lang['delete_status'] : ( row._approved == '1' ? 'label-success">' + lang['normal_status'] : 'label-warning">' + lang['notyet_status'] ) ) + '</span>';
				}},
				{"className" : "text-center", "data" : "_username", "render": function ( data, type, row, meta ) {
					return ( row._deleted == '1' ? '' : ( row._approved == '1' ? '<button class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-log" data-account="' + data + '"><i class="fa fa-th-list"></i></button>&nbsp;<button class="btn btn-xs btn-info btn-reset" data-account="' + data + '"><i class="fa fa-refresh"></i></button>&nbsp;' : '' ) + '<button class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-large" data-account="' + data + '"><i class="fa fa-pencil"></i></button>' );
				}}
			],
			destroy: true,
			autoWidth: false,
			paging: true,
			info: true,
			searching: true,
			ordering: true,
			order: [[ 3, 'asc' ]]
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

	jQuery('#admin_account').on( 'draw.dt', function () {
		if ( jQuery('#admin_account_filter input').css('display') != 'none' )
		{
			jQuery('#admin_account_filter input').hide();
			jQuery('#admin_account_filter > label').append(' <select id="selFilter" class="form-control"><option value="">' + lang['all'] + '</option><option value="1">' + lang['normal_status'] + '</option><option value="2">' + lang['notyet_status'] + '</option><option value="3">' + lang['delete_status'] + '</option></select>');
		}
	});

	jQuery(document).on( 'change', '#selFilter', function () {
		jQuery('#admin_account').dataTable().api().search( ( jQuery('#selFilter :selected').val() == '' ? '' : jQuery('#selFilter :selected').text() ) ).draw();
	});

    jQuery('#modal-large').on('show.bs.modal', function (e) {
		$('#modal-large h3').text(lang['account_edit']);
	    var button = $(e.relatedTarget);
	    if ( button.data('account') != '' && button.data('account') != null )
	    {
		    jQuery('#_useraccount').val( button.data('account') );
		    jQuery.ajax({
			    type: 'POST',
				url: '/Admin/accountdetails',
				data: {'_useraccount': button.data('account') },
				success: function ( result ) {
					var obj = eval(result);
					jQuery('#_username').val( obj[0]._username );
					jQuery('#_name').val( obj[0]._name );
					jQuery('#_reason').val( obj[0]._reason );
					jQuery('#_depart').val( obj[0]._depart );
					jQuery('#_auth').val( obj[0]._auth ).trigger('change');
					jQuery('#_approved').val( obj[0]._approved ).trigger('change');
				}
		    });
		}
    });

    jQuery('#modal-log').on('show.bs.modal', function (e) {
	    var button = $(e.relatedTarget);
	    jQuery('#admin_log').dataTable({
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 15,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
			"ajax": {
				"type"   : "POST",
				"url"    : '/Admin/accountlog',
				"data"   : {'admin_id': button.data('account')},
				"dataSrc": ""
			},
			"columns": [
				{"className" : "text-center", "data" : "_regdate"},
				{"className" : "text-center", "data" : "_admin_id"},
				{"className" : "text-center", "data" : "_logdetails"}
			],
			destroy: true,
			autoWidth: false,
			paging: true,
			info: true,
			searching: true,
			ordering: true,
			order: [[ 0, 'desc' ]]
        });
    });

    jQuery(document).on('click', '#btnSubmit', function () {
	    jQuery.ajax({
		    type: 'POST',
			url: '/Admin/accountupdate',
			data: {'_username': jQuery('#_username').val(), '_name': jQuery('#_name').val(), '_reason': jQuery('#_reason').val(),
					'_depart': jQuery('#_depart').val(), '_auth': jQuery('#_auth').val(), '_approved': jQuery('#_approved').val(),
					'_admin_memo': jQuery('#_admin_memo').val()
			},
			success: function ( result ) {
				if ( result == 'true' )
				{
					swal({
						title: lang['account_edit'],
						text: lang['account_edit_success'],
						type: 'success',
					}, function () {
						jQuery('#admin_account').dataTable().api().ajax.reload();
					});
				}
				else
				{
					swal({
						title: lang['account_edit'],
						text: lang['account_edit_fail'],
						type: 'error',
					});
				}
			}
	    });
    });

    jQuery(document).on('click', '.btn-reset', function () {
	    jQuery.ajax({
		    type: 'POST',
			url: '/Admin/accountpassword',
			data: {'_username': jQuery(this).data('account')},
			success: function ( result ) {
				if ( result == 'true' )
				{
					swal({
						title: lang['account_password_reset'],
						text: lang['account_password_reset_success'],
						type: 'success',
					});
				}
				else
				{
					swal({
						title: lang['account_password_reset'],
						text: lang['account_password_reset_fail'],
						type: 'error',
					});
				}
			}
	    });
    });
});
