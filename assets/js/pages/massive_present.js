/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */

var BaseTableDatatables = function() {
    // Init full DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFull = function() {
	    var objname = 'row.ITEMNAME' + ( session_language == 'kr' ? 'KOR' : 'ENG' )
        jQuery('#group_list').dataTable({
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 10,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
			"ajax": {
				"type"   : "POST",
				"url"    : '/Present/massivelist',
				"data"   : null,
				"dataSrc": ""
			},
			"columns": [
				{"className" : "text-center", "data" : "_sendtime"},
				{"className" : "text-center", "data" : "_item_id", "render" : function ( data, type, row, meta ) {
					var strobj = (
						eval( objname ) != '' && eval( objname ) != '0' ?
							'<span class="label label-default" style="line-height:2;">' + eval( objname ) + ' : ' + row._item_count + '</span>' :
							''
					) + (
						row._exp != '' && row._exp != '0' ?
							'<span class="label label-default" style="line-height:2;">' + lang['exp'] + ' : ' + row._exp + '</span>' :
							''
					) + (
						row._gold != '' && row._gold != '0' ?
							'<span class="label label-default" style="line-height:2;">' + lang['gold'] + ' : ' + row._gold + '</span>' :
							''
					) + (
						row._cash != '' && row._cash != '0' ?
							'<span class="label label-default" style="line-height:2;">' + lang['cash'] + ' : ' + row._cash + '</span>' :
							''
					) + (
						row._point != '' && row._point != '0' ?
							'<span class="label label-default" style="line-height:2;">' + lang['point'] + ' : ' + row._point + '</span>' :
							''
					) + (
						row._free_cash != '' && row._free_cash != '0' ?
							'<span class="label label-default" style="line-height:2;">' + lang['free_cash'] + ' : ' + row._free_cash + '</span>' :
							''
					) + (
						row._gemstone != '' && row._gemstone != '0' ?
							'<span class="label label-default" style="line-height:2;">' + lang['gemstone'] + ' : ' + row._gemstone + '</span>' :
							''
					) + (
						row._crystal != '' && row._crystal != '0' ?
							'<span class="label label-default" style="line-height:2;">' + lang['crystal'] + ' : ' + row._crystal + '</span>' :
							''
					) + (
						row._soulstone != '' && row._soulstone != '0' ?
							'<span class="label label-default" style="line-height:2;">' + lang['soulstone'] + ' : ' + row._soulstone + '</span>' :
							''
					) + (
						row._marble != '' && row._marble != '0' ?
							'<span class="label label-default" style="line-height:2;">' + lang['marble'] + ' : ' + row._marble + '</span>' :
							''
					) + (
						row._battle_point != '' && row._battle_point != '0' ?
							'<span class="label label-default" style="line-height:2;">' + lang['battle_point'] + ' : ' + row._battle_point + '</span>' :
							''
					);
					return strobj.replace(/\<\/span>\<span/gi, '</span><br /><span');
				}},
				{"className" : "text-center", "data" : "_title", "render" : function ( data, type, row, meta ) {
					return ( title[data] ? title[data] : '-' );
				}},
				{"className" : "text-center", "data" : "_total"},
				{"className" : "text-center", "data" : "_success", "render" : function ( data, type, row, meta ) {
					return data + ( row._is_recall == 1 ? '<br />( ' + row._recall + ' )' : '' );
				}},
				{"className" : "text-center", "data" : "_fail"},
				{"className" : "text-center", "data" : "_admin_memo"},
				{"className" : "text-center", "data" : "_admin_id"},
				{"className" : "text-center", "data" : "_status", "render" : function ( data, type, row, meta ) {
					return '<span class="label ' + ( row._is_valid == 1 ? ( row._is_recall == 1 ? 'label-primary">' + lang['recall'] : ( data == '1' ? 'label-success">' + lang['done'] : 'label-warning">' + lang['wait'] ) ) : 'label-danger">' + lang['delete'] ) + '</label>';
				}},
				{"className" : "text-center", "data" : "_status", "render" : function ( data, type, row, meta ) {
					var strReturn = '';
					strReturn += ( data == '1' ? ( row._is_recall == 1 ? '' : '<button class="btn btn-xs btn-warning btn-recall" data-groupid="' + row._group_id + '" data-toggle="popover" title="" data-placement="bottom" data-content="Recall"><i class="fa fa-undo"></i></button>' ) : ( row._is_valid == 1 ? ( '<button class="btn btn-xs btn-danger btn-delete" data-groupid="' + row._group_id + '" data-toggle="popover" title="" data-placement="bottom" data-content="Delete"><i class="fa fa-trash-o"></i></button>' ) : '' ) );
					strReturn += '&nbsp;&nbsp;<button class="btn btn-xs btn-success btn-download" data-toggle="popover" data-groupid="' + row._group_id + '" data-status="' + data + '" title="" data-placement="bottom" data-content="Download"><i class="fa fa-download"></i></button>';

					return strReturn;
				}}
			],
			destroy: true,
			autoWidth: false,
			paging: true,
			info: true,
			searching: true,
			ordering: true,
			order: [[ 0, 'desc' ]]
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

    var initValidator = function () {
	    $.validator.addMethod('checkgroupid', function (value, element) {
		    return ( jQuery('#_group_id').val() != '' && jQuery('#_group_id').val() != null && jQuery('#_group_id').val() > 0 );
	    }, lang['upload_fail'] + jQuery('#userlist').val() );

	    $.validator.addMethod('checkitemid', function (value, element) {
		    return ( jQuery('#_item_id').val() == '' || jQuery('#_item_id').val() != '' && ( jQuery('#_item_name').val() != '' && jQuery('#_item_name').val() != null ) );
	    }, lang['no_item_name'] );

	    $.validator.addMethod('checkcount', function (value, element) {
		    return ( jQuery('#_item_id').val() != '' ? value != '' && ( value <= 1000 || ( jQuery('#_is_countconfirm').val() != '' && jQuery('#_is_countconfirm').val() != null && jQuery('#_is_countconfirm').val() != '0' ) ) : true );
	    }, lang['check_item_count'] );

	    $.validator.addMethod('isset', function (value, element) {
		    return ( value == '0' || ( jQuery('#expiretime').val() != null && jQuery('#expiretime').val() != '' ) );
	    }, lang['need_expiretime'] );

	    jQuery('#frmSend1').validate({
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
                'userlist': {
                    required: true,
                    checkgroupid: true
                },
                '_item_id': {
                    checkitemid: true
                },
                '_item_count': {
                    checkcount: true
                },
                '_title': {
                    required: true
                },
                '_contents': {
                    required: true
                }
            },
            messages: {
	            'userlist': {
                    required: lang['need_fileupload']
                },
                '_title': {
                    required: lang['need_title']
                },
                '_contents': {
                    required: lang['need_contents']
                }
            },
            onfocusout:false
        });

	    jQuery('#frmSend2').validate({
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
                'send': {
                    required: true
                },
                'expire': {
                    required: true,
                    isset: true
                },
                '_admin_memo': {
                    required: true
                }
            },
            messages: {
                'send': {
                    required: lang['need_sendtime']
                },
                'expire': {
                    required: lang['need_expiretime']
                },
                '_admin_memo': {
                    required: lang['need_admin_memo']
                }
            },
            onfocusout:false
        });
    };

    return {
        init: function() {
            // Init Datatables
            bsDataTables();
            initDataTableFull();
            initDataTableFullPagination();
            initValidator();
        }
    };
}();

// Initialize when page loads
jQuery(function(){ BaseTableDatatables.init(); });
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
							jQuery('#_item_name').val(obj[0].ITEMNAMEKOR);
						}
						else if ( session_language == 'en' )
						{
							jQuery('#_item_name').val(obj[0].ITEMNAMEENG);
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
						url: "/Present/userfileupload",
						type: "POST",
						data: data,
						async: false,
						cache: false,
						contentType: false,
						processData: false,
						success:  function(result){
							var obj = eval(result);
							if ( obj.length > 0 )
							{
								if ( obj[0].hasOwnProperty('_group_id') )
								{
									swal({
							            title: lang['file_upload'],
							            text: lang['upload_success'],
							            type: "success"
									});

									jQuery('#_group_id').val(obj[0]._group_id);
									jQuery('#_group_count').val(obj[0]._group_count);
								}
								else
								{
									swal({
							            title: lang['file_upload'],
							            text: lang['upload_fail'] + result,
							            type: "error"
									});

									jQuery('#_group_id').val('');
								}
							}
							else
							{
								swal({
						            title: lang['file_upload'],
						            text: lang['upload_fail'] + result,
						            type: "error"
								});

								jQuery('#_group_id').val('');
							}
						}
					});
				}
	        });
	    }
	});

	jQuery(document).on('click', '#btnSubmit', function (e) {
		e.preventDefault();
		jQuery('#frmSend1').valid();
		jQuery('#frmSend2').valid();
		if ( jQuery('#frmSend1').valid() && jQuery('#frmSend2').valid() )
		{
			swal({
				title: lang['reg_massive'],
	            text: ( jQuery('#_item_id').val() != '' ? lang['item_id'] + ' : ' + jQuery('#_item_id').val() + '\n' + lang['item_count'] + ' : ' + jQuery('#_item_count').val() + '\n' : '' ) +
	            ( jQuery('#_exp').val() != '' && jQuery('#_exp').val() > 0 ? lang['exp'] + ' : ' + jQuery('#_exp').val() + '\n' : '' ) +
	            ( jQuery('#_gold').val() != '' && jQuery('#_gold').val() > 0 ? lang['gold'] + ' : ' + jQuery('#_gold').val() + '\n' : '' ) +
	            ( jQuery('#_cash').val() != '' && jQuery('#_cash').val() > 0 ? lang['cash'] + ' : ' + jQuery('#_cash').val() + '\n' : '' ) +
	            ( jQuery('#_point').val() != '' && jQuery('#_point').val() > 0 ? lang['point'] + ' : ' + jQuery('#_point').val() + '\n' : '' ) +
	            ( jQuery('#_free_cash').val() != '' && jQuery('#_free_cash').val() > 0 ? lang['free_cash'] + ' : ' + jQuery('#_free_cash').val() + '\n' : '' ) +
	            ( jQuery('#_gemstone').val() != '' && jQuery('#_gemstone').val() > 0 ? lang['gemstone'] + ' : ' + jQuery('#_gemstone').val() + '\n' : '' ) +
	            ( jQuery('#_crystal').val() != '' && jQuery('#_crystal').val() > 0 ? lang['crystal'] + ' : ' + jQuery('#_crystal').val() + '\n' : '' ) +
	            ( jQuery('#_soulstone').val() != '' && jQuery('#_soulstone').val() > 0 ? lang['soulstone'] + ' : ' + jQuery('#_soulstone').val() + '\n' : '' ) +
	            ( jQuery('#_marble').val() != '' && jQuery('#_marble').val() > 0 ? lang['marble'] + ' : ' + jQuery('#_marble').val() + '\n' : '' ) +
	            ( jQuery('#_battle_point').val() != '' && jQuery('#_battle_point').val() > 0 ? lang['battle_point'] + ' : ' + jQuery('#_battle_point').val() + '\n' : '' ) +
	            lang['sendtime'] + ' : ' + jQuery('#sendtime').val() + '\n' + lang['expiretime'] + ' : ' + ( jQuery('#expiretime').val() != '' ? jQuery('#expiretime').val() : '-' ) + '\n',
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes!",
	            closeOnConfirm: false
			}, function () {
				jQuery.ajax({
					type: "POST",
					url: "/Present/presentaction",
					data: {
						'_group_id': jQuery('#_group_id').val(),
						'_item_id': jQuery('#_item_id').val(),
						'_item_count': jQuery('#_item_count').val(),
						'_exp': jQuery('#_exp').val(),
						'_gold': jQuery('#_gold').val(),
						'_cash': jQuery('#_cash').val(),
						'_point': jQuery('#_point').val(),
						'_free_cash': jQuery('#_free_cash').val(),
						'_gemstone': jQuery('#_gemstone').val(),
						'_crystal': jQuery('#_crystal').val(),
						'_soulstone': jQuery('#_soulstone').val(),
						'_marble': jQuery('#_marble').val(),
						'_battle_point': jQuery('#_battle_point').val(),
						'_title': jQuery('#_title').val(),
						'_contents': jQuery('#_contents').val(),
						'_send': jQuery('input[name=send]:checked').val(),
						'_sendtime': jQuery('#sendtime').val(),
						'_expire': jQuery('input[name=expire]:checked').val(),
						'_expiretime': jQuery('#expiretime').val(),
						'_admin_memo': jQuery('#_admin_memo').val(),
						'_url': jQuery('#_url').val()
					},
					success: function ( result ) {
						if ( result == 'true' )
						{
							swal({
								title: lang['presentsend'],
					            text: lang['presentsend_success'],
					            type: "success"
							}, function () {
								jQuery("form").each(function() {
									this.reset();
								});
								jQuery('#_title').val('').trigger('change');
								jQuery('#_is_itemsearch').val('');
								jQuery('#_is_countconfirm').val('');
								jQuery('#_item_count').attr('readonly', false);
								jQuery('#_item_id').attr('readonly', false);
								jQuery('#cancelcheckcount').hide();
								jQuery('#cancelsearchitem').hide();
								jQuery('#checkcount').show();
								jQuery('#searchitem').show();
								jQuery('#group_list').dataTable().api().ajax.reload();
							});
						}
						else
						{
							swal({
					            title: lang['presentsend'],
					            text: lang['presentsend_fail'],
					            type: "error"
							});
						}
					}
				});
			});
		}
	});

	jQuery('#group_list').on( 'draw.dt', function () {
		jQuery('[data-toggle="popover"]').popover({
			trigger: "manual" ,
			html: true,
			animation:false
		}).on("mouseenter", function () {
				var _this = this;
				jQuery(this).popover("show");
				jQuery(".popover").on("mouseleave", function () {
					jQuery(_this).popover('hide');
				});
		}).on("mouseleave", function () {
				var _this = this;
				setTimeout(function () {
					if (!jQuery(".popover:hover").length) {
						jQuery(_this).popover("hide");
					}
				}, 100);
		});
	});

	jQuery(document).on('click', '.btn-download', function () {
		var group_id = jQuery(this).data('groupid');
		if ( jQuery(this).data('status') == '0' )
		{
			jQuery('#frmDown').attr('src', '/Present/grouplist/' + group_id );
		}
		else
		{
			jQuery('#frmDown').attr('src', '/Present/groupcomplist/' + group_id );
		}
	});

	jQuery(document).on('click', '.btn-delete', function () {
		var group_id = jQuery(this).data('groupid');
		swal({
			title: lang['delete_title'],
            text: lang['delete_confirm'],
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: false
		}, function () {
			jQuery.ajax({
				type: "POST",
				url: "/Present/massivedelete",
				data: {
					'_group_id': group_id
				},
				success: function ( result ) {
					if ( result == 'true' )
					{
						swal({
							title: lang['delete_title'],
				            text: lang['delete_success'],
				            type: "success"
						}, function () {
							jQuery('#group_list').dataTable().api().ajax.reload();
						});
					}
					else
					{
						swal({
				            title: lang['delete_title'],
				            text: lang['delete_fail'],
				            type: "error"
						});
					}
				}
			});
		});
	});

	jQuery(document).on('click', '.btn-recall', function () {
		var group_id = jQuery(this).data('groupid');
		swal({
			title: lang['recall_title'],
            text: lang['recall_confirm'],
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: false
		}, function () {
			jQuery.ajax({
				type: "POST",
				url: "/Present/massiverecall",
				data: {
					'_group_id': group_id
				},
				success: function ( result ) {
					var obj = eval( result );
					if ( obj.length > 0 )
					{
						swal({
							title: lang['recall_title'],
				            text: lang['recall_success'] + '( ' + obj[0].exec + ' / ' + obj[0].total + ' )',
				            type: "success"
						}, function () {
							jQuery('#group_list').dataTable().api().ajax.reload();
						});
					}
				}
			});
		});
	});

	jQuery(document).on('click', '#btnSample', function () {
		jQuery('#frmDown').attr( 'src', '/upload/massivepresent.xlsx' );
	});

	jQuery('#group_list').on( 'draw.dt', function () {
	    if ( typeof auth == 'object' )
	    {
		    if ( auth.edit == 0 )
		    {
			    jQuery('.btn-delete, .btn-recall').hide();
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
				window.location.href = '/User/userinfo';
			});
			return;
		}
	});
// Login Check End
});
