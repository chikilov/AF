/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */

var BaseTableDatatables = function() {
    // Init full DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFull = function() {
        jQuery('#account_list').dataTable({
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 10,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
			"ajax": {
				"type"   : "POST",
				"url"    : '/User/userlist',
				"data"   : {'daterange1': '', 'daterange2': '', 'search_type': '', 'search_value': ''},
				"dataSrc": ""
			},
			"columns": [
				{"className" : "text-center", "data" : "_user_id"},
				{"className" : "text-center", "data" : "_user_account"},
				{"className" : "text-center", "data" : "_email"},
				{"className" : "text-center", "data" : "_birth_datetime"},
				{"className" : "text-center", "data" : "_create_type", "render" : function ( data, type, row, meta ) { return ( data == '0' ? 'NORMAL' : ( data == '1' ? 'AUTO' : ( data == '2' ? 'ITOOLS' : ( data == '3' ? 'TWITTER' : ( data == '4' ? 'FACEBOOK' : ( data == '5' ? 'ITEMBAY' : ( data == '6' ? 'NAVER' : '???' ) ) ) ) ) ) ); } },
				{"className" : "text-center", "data" : "_block_type", "render" : function ( data, type, row, meta ) { return ( data == '' ? '<span class="label label-primary">' + lang['in_use'] + '</span>' : '<span class="label label-primary">' + lang['not_in_use'] + '</span>' ); } },
				{"className" : "text-center", "data" : "_user_id", "render" : function ( data, type, row, meta ) { return '<button class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-large" data-userid="' + data + '" data-useraccount="' + row._user_account + '" data-email="' + row._email + '" data-birthdatetime="' + row._birth_datetime + '" data-createtype="' + ( row._create_type == '0' ? 'NORMAL' : ( row._create_type == '1' ? 'AUTO' : ( row._create_type == '2' ? 'ITOOLS' : ( row._create_type == '3' ? 'TWITTER' : ( row._create_type == '4' ? 'FACEBOOK' : ( row._create_type == '5' ? 'ITEMBAY' : ( row._create_type == '6' ? 'NAVER' : '???' ) ) ) ) ) ) ) + '" data-blocktype="' + ( row._block_type == '' ? lang['in_use'] : lang['not_in_use'] ) + '" type="button">' + lang['detail'] + '</button>'; } }
			],
			destroy: true,
			autoWidth: false,
			paging: true,
			info: true,
			searching: true,
			ordering: true,
			order: [[ 3, 'desc' ]]
        });
    };

    // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFullPagination = function() {
        jQuery('.js-dataTable-full-pagination').dataTable({
            pagingType: "full_numbers",
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 10,
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
                "<'row'<'col-sm-6'Bl><'col-sm-6'f>>" +
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
            },
            buttons: [
            	'copy', 'csv', 'excel', 'pdf', 'print'
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

	jQuery(document).on( 'click', 'input[name=search_term]', function () {
		var term = jQuery(this).val().split(':');
		var endDate = new Date();
		var startDate = new Date();
		if ( term[1] == 'Y' )
		{
			startDate.setFullYear(startDate.getFullYear() - term[0]);
		}
		else if ( term[1] == 'M' )
		{
			startDate.setMonth(startDate.getMonth() - term[0]);
		}
		else if ( term[1] == 'D' )
		{
			startDate.setDate(startDate.getDate() - term[0]);
		}

		jQuery('#daterange1').val(startDate.toISOString().substring(0, 10));
		jQuery('#daterange2').val(endDate.toISOString().substring(0, 10));
	});

	jQuery(document).on( 'click', 'input[name=access_search_term]', function () {
		var term = jQuery(this).val().split(':');
		var endDate = new Date();
		var startDate = new Date();
		if ( term[1] == 'Y' )
		{
			startDate.setFullYear(startDate.getFullYear() - term[0]);
		}
		else if ( term[1] == 'M' )
		{
			startDate.setMonth(startDate.getMonth() - term[0]);
		}
		else if ( term[1] == 'D' )
		{
			startDate.setDate(startDate.getDate() - term[0]);
		}

		jQuery('#access_daterange1').datepicker('setDate', startDate);
		jQuery('#access_daterange2').datepicker('setDate', endDate);

		jQuery('#access_info').dataTable({
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 10,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
			"ajax": {
				"type"   : "POST",
				"url"    : '/User/accesslist',
				"data"   : {'daterange1': jQuery('#access_daterange1').val(), 'daterange2': jQuery('#access_daterange2').val()},
				"dataSrc": ""
			},
			"columns": [
				{"className" : "text-center", "data" : "access_datetime"},
				{"className" : "text-center", "data" : "access_ip"},
				{"className" : "text-center", "data" : "access_uuid"},
				{"className" : "text-center", "data" : "create_type", "render" : function ( data, type, row, meta ) { return ( data == '0' ? 'NORMAL' : ( data == '1' ? 'AUTO' : ( data == '2' ? 'ITOOLS' : ( data == '3' ? 'TWITTER' : ( data == '4' ? 'FACEBOOK' : ( data == '5' ? 'ITEMBAY' : ( data == '6' ? 'NAVER' : '???' ) ) ) ) ) ) ); } },
				{"className" : "text-center", "data" : "access_os"},
				{"className" : "text-center", "data" : "access_country"},
				{"className" : "text-center", "data" : "access_version"}
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

	$('ul[data-toggle="tabs"]').children('li').children('a').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href") // activated tab
		// 1: #btabs-alt-static-justified-basic_info
		// 2: #btabs-alt-static-justified-access_info
		// 3: #btabs-alt-static-justified-payment_info
		// 4: #btabs-alt-static-justified-join_log
		// 5: #btabs-alt-static-justified-block_info

		if ( target == '#btabs-alt-static-justified-access_info' )
		{
			jQuery('#access_info').dataTable({
	            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
	            pageLength: 10,
	            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
				"ajax": {
					"type"   : "POST",
					"url"    : '/User/accesslist',
					"data"   : {'daterange1': jQuery('#access_daterange1').val(), 'daterange2': jQuery('#access_daterange2').val()},
					"dataSrc": ""
				},
				"columns": [
					{"className" : "text-center", "data" : "access_datetime"},
					{"className" : "text-center", "data" : "access_ip"},
					{"className" : "text-center", "data" : "access_uuid"},
					{"className" : "text-center", "data" : "create_type", "render" : function ( data, type, row, meta ) { return ( data == '0' ? 'NORMAL' : ( data == '1' ? 'AUTO' : ( data == '2' ? 'ITOOLS' : ( data == '3' ? 'TWITTER' : ( data == '4' ? 'FACEBOOK' : ( data == '5' ? 'ITEMBAY' : ( data == '6' ? 'NAVER' : '???' ) ) ) ) ) ) ); } },
					{"className" : "text-center", "data" : "access_os"},
					{"className" : "text-center", "data" : "access_country"},
					{"className" : "text-center", "data" : "access_version"}
				],
				destroy: true,
				autoWidth: false,
				paging: true,
				info: true,
				searching: true,
				ordering: true,
				order: [[ 0, 'desc' ]]
			});
		}
		else if ( target == '#btabs-alt-static-justified-payment_info' )
		{
			jQuery('#payment_info').dataTable({
	            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
	            pageLength: 10,
	            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
				"ajax": {
					"type"   : "POST",
					"url"    : '/User/paymentinfo',
					"data"	 : {'user_id':jQuery('#_user_id').val()},
					"dataSrc": ""
				},
				"columns": [
					{"className" : "text-center", "data" : "tid"},
					{"className" : "text-center", "data" : "pay_type"},
					{"className" : "text-center", "data" : "store"},
					{"className" : "text-center", "data" : "product"},
					{"className" : "text-center", "data" : "amount"},
					{"className" : "text-center", "data" : "last_change_datetime"},
					{"className" : "text-center", "data" : "status"}
				],
				destroy: true,
				autoWidth: false,
				paging: true,
				info: true,
				searching: true,
				ordering: true,
				order: [[ 2, 'desc' ]]
			});
		}
		else if ( target == '#btabs-alt-static-justified-join_log' )
		{
			jQuery('#join_log').dataTable({
	            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
	            pageLength: 10,
	            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
				"ajax": {
					"type"   : "POST",
					"url"    : '/User/joinloglist',
					"data"   : {'daterange1': jQuery('#access_daterange1').val(), 'daterange2': jQuery('#access_daterange2').val()},
					"dataSrc": ""
				},
				"columns": [
					{"className" : "text-center", "data" : "join_log_status"},
					{"className" : "text-center", "data" : "join_log_datetime"},
					{"className" : "text-center", "data" : "join_log_manager"},
					{"className" : "text-center", "data" : "join_log_memo"}
				],
				destroy: true,
				autoWidth: false,
				paging: true,
				info: true,
				searching: true,
				ordering: true,
				order: [[ 1, 'desc' ]]
			});
		}
		else if ( target == '#btabs-alt-static-justified-block_info' )
		{
			jQuery('#block_info').dataTable({
	            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
	            pageLength: 10,
	            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
				"ajax": {
					"type"   : "POST",
					"url"    : '/User/blocklist',
					"data"	 : {'a':'1'},
					"dataSrc": ""
				},
				"columns": [
					{"className" : "text-center", "data" : "block_info_manager"},
					{"className" : "text-center", "data" : "block_reason"},
					{"className" : "text-center", "data" : "block_datetime"},
					{"className" : "text-center", "data" : "block_type"},
					{"className" : "text-center", "data" : "action_type"}
				],
				destroy: true,
				autoWidth: false,
				paging: true,
				info: true,
				searching: true,
				ordering: true,
				order: [[ 2, 'desc' ]]
			});
		}
	});

	jQuery(document).on( 'change', 'input[name*=access_daterange]', function () {
		jQuery('#access_info').dataTable({
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 10,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
			"ajax": {
				"type"   : "POST",
				"url"    : '/User/accesslist',
				"data"   : {'daterange1': jQuery('#access_daterange1').val(), 'daterange2': jQuery('#access_daterange2').val()},
				"dataSrc": ""
			},
			"columns": [
				{"className" : "text-center", "data" : "access_datetime"},
				{"className" : "text-center", "data" : "access_ip"},
				{"className" : "text-center", "data" : "access_uuid"},
				{"className" : "text-center", "data" : "create_type", "render" : function ( data, type, row, meta ) { return ( data == '0' ? 'NORMAL' : ( data == '1' ? 'AUTO' : ( data == '2' ? 'ITOOLS' : ( data == '3' ? 'TWITTER' : ( data == '4' ? 'FACEBOOK' : ( data == '5' ? 'ITEMBAY' : ( data == '6' ? 'NAVER' : '???' ) ) ) ) ) ) ); } },
				{"className" : "text-center", "data" : "access_os"},
				{"className" : "text-center", "data" : "access_country"},
				{"className" : "text-center", "data" : "access_version"}
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

	jQuery(document).on( 'click', '#btnSearch', function (e) {
		e.preventDefault();
		jQuery('.js-dataTable-full').dataTable({
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 10,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
			"ajax": {
				"type"   : "POST",
				"url"    : '/User/userlist',
				"data"   : {'daterange1': jQuery('#daterange1').val(), 'daterange2': jQuery('#daterange2').val(), 'search_type': jQuery('#search_type').val(), 'search_value': jQuery('#search_value').val()},
				"dataSrc": ""
			},
			"columns": [
				{"className" : "text-center", "data" : "_user_id"},
				{"className" : "text-center", "data" : "_user_account"},
				{"className" : "text-center", "data" : "_email"},
				{"className" : "text-center", "data" : "_birth_datetime"},
				{"className" : "text-center", "data" : "_create_type", "render" : function ( data, type, row, meta ) { return ( data == '0' ? 'NORMAL' : ( data == '1' ? 'AUTO' : ( data == '2' ? 'ITOOLS' : ( data == '3' ? 'TWITTER' : ( data == '4' ? 'FACEBOOK' : ( data == '5' ? 'ITEMBAY' : ( data == '6' ? 'NAVER' : '???' ) ) ) ) ) ) ); } },
				{"className" : "text-center", "data" : "_block_type", "render" : function ( data, type, row, meta ) { return ( data == '' ? '이용중' : '제한중' ); } },
				{"className" : "text-center", "data" : "_user_id", "render" : function ( data, type, row, meta ) { return '<button class="btn btn-info" data-toggle="modal" data-target="#modal-large" data-userid="' + data + '" data-useraccount="' + row._user_account + '" data-email="' + row._email + '" data-birthdatetime="' + row._birth_datetime + '" data-createtype="' + row._create_type + '" type="button">' + lang['detail'] + '</button>'; } }
			],
			destroy: true,
			autoWidth: false,
			paging: true,
			info: true,
			searching: true,
			ordering: true,
			order: [[ 3, 'desc' ]]
        });
	});

	document.querySelector('#frmLeave').addEventListener('submit', function(e) {
	    e.preventDefault();
	    jQuery('#modal-large').css('z-index', 1033);
	    swal({
			title: lang['leave_title'],
			text: lang['user_id'] + ' : ' + jQuery('#_user_id').val() + '\n' + lang['user_account'] + ' : ' + jQuery('#_user_account').val(),
			type: 'input',
			showCancelButton: true,
			closeOnConfirm: false,
			closeOnCancel: false,
	        confirmButtonColor: '#DD6B55',
			confirmButtonText: lang['confirm_button_text'],
			cancelButtonText: lang['cancel_button_text'],
			inputPlaceholder: lang['admin_memo'],
		}, function( isConfirm ){
			if (isConfirm !== false) {
				if ( isConfirm == '' )
				{
					swal.showInputError( lang['need_admin_memo'] );
					return false;
				}
				else
				{
			        swal({
				        title: 'Success!',
				        text: lang['leave_complete'],
				        type: 'success'
			        }, function () {
				        window.location.href = '/User/userinfo';
			        });
			    }
		    } else {
		        swal({
			        title: 'Cancelled',
			        text: lang['cancel_text'],
			        type: 'error'
		        }, function() {
			        jQuery('#modal-large').css('z-index', 1050);
			        jQuery('body').addClass('modal-open');
				});
		    }
		});
	});

	jQuery('#modal-large').on('show.bs.modal', function (event) {
		var button = jQuery(event.relatedTarget); // Button that triggered the modal
		if ( button.data('userid') )
		{
			jQuery('#_user_id').val( button.data('userid') ); // Extract info from data-* attributes
			jQuery('#_user_account').val( button.data('useraccount') ); // Extract info from data-* attributes
			jQuery('#_table_user_id').text( lang['user_id'] + ' : ' + button.data('userid') );
			jQuery('#_table_create_type').text( lang['create_type'] + ' : ' + button.data('createtype') );
			jQuery('#_table_user_account').text( lang['user_account'] + ' : ' + button.data('useraccount') );
			jQuery('#_table_email').text( lang['email'] + ' : ' + button.data('email') );
			jQuery('#_table_birth_datetime').text( lang['birth_datetime'] + ' : ' + button.data('birthdatetime') );
			jQuery('#_table_block_type').text( lang['status'] + ' : ' + button.data('blocktype') );
			jQuery('#head_userid').text( button.data('userid') ); // Extract info from data-* attributes
			jQuery('#head_useraccount').text( button.data('useraccount') ); // Extract info from data-* attributes
			jQuery('#head_createtype').text( button.data('createtype') );
			jQuery('#head_email').text( button.data('email') );
			jQuery('#head_birthdatetime').text( button.data('birthdatetime') );
			jQuery('#head_status').text( button.data('blocktype') );
			prevId = button.data('userid');
		    if ( auth.edit == '0' ) {
			    jQuery('#btnLeave').hide();
			    jQuery('#btnAuthBlock').hide();
			    jQuery('#btnBillBlock').hide();
			}
			else
			{
				jQuery('#btnLeave').show();
			    jQuery('#btnAuthBlock').show();
			    jQuery('#btnBillBlock').show();
			}
		}
		else
		{
			jQuery('#_user_id').val( prevId ); // Extract info from data-* attributes
		}
	});

	jQuery('#modal-authblock').on('show.bs.modal', function () {
		jQuery('#modal-large').css('z-index', 1033);
	});

	jQuery('#modal-authblock').on('hidden.bs.modal', function () {
		jQuery('#modal-large').css('z-index', 1050);
		jQuery('body').addClass('modal-open');
	});

	jQuery('#modal-billblock').on('show.bs.modal', function () {
		jQuery('#modal-large').css('z-index', 1033);
	});

	jQuery('#modal-billblock').on('hidden.bs.modal', function () {
		jQuery('#modal-large').css('z-index', 1050);
		jQuery('body').addClass('modal-open');
	});

	jQuery('#modal-payment_detail').on('show.bs.modal', function () {
		jQuery('#modal-large').css('z-index', 1033);
	});

	jQuery('#modal-payment_detail').on('hidden.bs.modal', function () {
		jQuery('#modal-large').css('z-index', 1050);
		jQuery('body').addClass('modal-open');
	});

	jQuery('.blocksubmit').on('click', function (event) {
		event.preventDefault();
		jQuery.ajax({
			type: 'POST',
			url: '/User/blockaction',
			data: {"block_type":jQuery(this).data('type')},
			success: function (result) {
				if ( parseInt(result) == 1 )
				{
					swal({
				        title: 'Success!',
				        text: lang['block_complete'],
				        type: 'success'
			        }, function () {
				        window.location.href = self.location;
			        });
				}
				else
				{
			        swal({
				        title: 'Error Occurs..',
				        text: lang['cancel_text'],
				        type: 'error'
			        });
				}
			}
		});
	});
	jQuery('#payment_info').on('click', 'tr', function () {
        var tid = jQuery('td', jQuery(this)).eq(0).text();
		jQuery.ajax({
			type: 'POST',
			url: '/User/paymentdetail',
			data: {'tid': tid},
			success: function (result) {
				var obj = eval(result);
				jQuery('#paydet_tid').text(obj[0].tid);
				jQuery('#paydet_userid').text(obj[0].user_id);
				jQuery('#paydet_store').text(obj[0].store);
				jQuery('#paydet_productid').text(obj[0].product_id);
				jQuery('#paydet_orderid').text(obj[0].orderid);
				jQuery('#paydet_producttype').text(obj[0].product_type);
				jQuery('#paydet_product').text(obj[0].product);
				jQuery('#paydet_amount').text(obj[0].amount);
				jQuery('#paydet_lastchangedatetime').text(obj[0].last_change_datetime);
				jQuery('#paydet_status').text(obj[0].status);
				jQuery('#modal-payment_detail').modal("show");
			}
		});
    });

    jQuery('#block_perm_radio').on('click', function () {
	    jQuery('#period_select').attr('disabled', true);
    });

    jQuery('#block_peri_radio').on('click', function () {
	    jQuery('#period_select').attr('disabled', false);
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
				window.location.href = '/User/userinfo';
			});
			return;
		}
	});
// Login Check End
});
