/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */
var errMsg = Array('1', '2', '3');
var BaseFormValidation = function() {
    // Init Material Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationMaterial = function( arrMsg, isVal2 ){
	    if ( isVal2 )
	    {
	        jQuery('.js-validation-material').validate({
	            ignore: [],
	            errorClass: 'help-block text-right animated fadeInDown',
	            errorElement: 'div',
	            errorPlacement: function(error, e) {
	                jQuery(e).parents('.form-group > div').append(error);
	            },
	            highlight: function(e) {
	                var elem = jQuery(e);

	                elem.closest('.form-group').removeClass('has-error').addClass('has-error');
	                elem.closest('.help-block').remove();
	            },
	            success: function(e) {
	                var elem = jQuery(e);

	                elem.closest('.form-group').removeClass('has-error');
	                elem.closest('.help-block').remove();
	            },
	            rules: {
	                'change_val': {
	                    required: true
	                },
	                'change_val2': {
	                    required: true
	                },
	                'admin_memo': {
	                    required: true
	                }
	            },
	            messages: {
	                'change_val': {
	                    required: lang['please_input'] + arrMsg[0]
	                },
	                'change_val2': {
	                    required: lang['please_input'] + arrMsg[2]
	                },
	                'admin_memo': {
	                    required: lang['please_input'] + arrMsg[1]
	                }
	            }
	        });
	    }
	    else
	    {
		    jQuery('.js-validation-material').validate({
	            ignore: [],
	            errorClass: 'help-block text-right animated fadeInDown',
	            errorElement: 'div',
	            errorPlacement: function(error, e) {
	                jQuery(e).parents('.form-group > div').append(error);
	            },
	            highlight: function(e) {
	                var elem = jQuery(e);

	                elem.closest('.form-group').removeClass('has-error').addClass('has-error');
	                elem.closest('.help-block').remove();
	            },
	            success: function(e) {
	                var elem = jQuery(e);

	                elem.closest('.form-group').removeClass('has-error');
	                elem.closest('.help-block').remove();
	            },
	            rules: {
	                'change_val': {
	                    required: true
	                },
	                'admin_memo': {
	                    required: true
	                }
	            },
	            messages: {
	                'change_val': {
	                    required: lang['please_input'] + arrMsg[0]
	                },
	                'admin_memo': {
	                    required: lang['please_input'] + arrMsg[1]
	                }
	            }
	        });
	    }
    };

    return {
        init: function ( arrMsg, isVal2 ) {
            // Init Material Forms Validation
            initValidationMaterial( arrMsg, isVal2 );
        }
    };
}();

// Initialize when page loads
jQuery(function(){ BaseFormValidation.init( errMsg, false ); });

var BaseTableDatatables = function() {
    // Init full DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFull = function() {
        jQuery('#account_list').dataTable({
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 10,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
			"ajax": {
				"type"   : 'POST',
				"url"    : '/User/characterlist',
				"async"  : false,
				"data"   : {'search_type': jQuery('#search_type').val(), 'search_value': jQuery('#search_value').val()},
				"dataSrc": ""
			},
			columns: [
				{"className" : "text-center", "data" : "_user_id"},
				{"className" : "text-center", "data" : "_user_account"},
				{"className" : "text-center", "data" : "_email"},
				{"className" : "text-center", "data" : "_server_id", "render" : function ( data, type, row, meta ) {
					return serverlist[row._server_id].name;
				}},
				{"className" : "text-center", "data" : "_player_name"},
				{"className" : "text-center", "data" : "_level"},
				{"className" : "text-center", "data" : "_birth_datetime"},
				{"className" : "text-center", "data" : "_block_type", "render" : function ( data, type, row, meta ) { return ( data == '' ? '<span class="label label-primary">' + lang['in_use'] + '</span>' : '<span class="label label-primary">' + lang['not_in_use'] + '</span>' ); } },
				{"className" : "text-center", "data" : "_etime"},
				{"className" : "text-center", "data" : "_user_id", "render" : function ( data, type, row, meta ) { return '<button class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-large" data-userid="' + data + '" data-useraccount="' + row._user_account + '" data-email="' + row._email + '" data-birthdatetime="' + row._birth_datetime + '" data-level="' + row._level + '" data-blocktype="' + ( row._block_type == '' ? lang['in_use'] : lang['not_in_use'] ) + '" data-playername="' + row._player_name + '" data-exp="' + row._exp + '" data-prevtotalexp="' + row._prev_total_exp + '" data-needexp="' + row._need_exp + '" data-playerid="' + row._player_id + '" data-serverid="' + row._server_id + '" data-guildname="' + row._guild_name + '" data-logon="' + row._logon + '" data-valid="' + row._valid + '" data-gold="' + row._gold + '" data-vipgrade="' + row._grade + '" data-guildpoint="' + row._guild_point + '" data-buddycount="' + row._buddy_count + '" data-buddymax="' + row._buddy_max + '" data-gem="' + row._gem + '" data-free_gem="' + row._free_gem + '" data-gem_charge_sum="' + row._gem_charge_sum + '" data-charid="' + row._char_id + '" data-invenmax="' + row._inven_max + '" type="button">' + lang['detail'] + '</button>'; } }
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
        }
    };
}();

// Initialize when page loads
jQuery(function(){ BaseTableDatatables.init(); });
var prevId = '0';
jQuery(function(){
    // Init page helpers (BS Datepicker + BS Datetimepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
    App.initHelpers(['datepicker', 'select2', ]);

	jQuery('ul[data-toggle="tabs"]').children('li').children('a').on('shown.bs.tab', function (e) {
		var target = jQuery(e.target).attr("href") // activated tab

		if ( target == '#btabs-alt-static-justified-item_info' )
		{
			jQuery('#item_info').dataTable({
	            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
	            pageLength: 10,
	            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
				"ajax": {
					"type"   : "POST",
					"url"    : '/User/itemlist',
					"data"   : {'_player_id': jQuery('#_player_id').val(), '_server_id': jQuery('#_server_id').val(), 'type': 'NORMAL'},
					"dataSrc": ""
				},
				"columns": [
					{"className" : "text-center", "data" : "_player_name"},
					{"className" : "text-left", "data" : "_itemnamekor", "render" : function ( data, type, row, meta ) {
						var returnString = ( row._itemrarity != '' && row._itemrarity != null ? '[' + lang[row._itemrarity] + '] ' : '' ) + ( session_language == '' || session_language == 'kr' ? row._itemnamekor : row._itemnameeng ) + (row._isown == 1 ? ' [' + lang['belonging'] + ']' : '');
						if ( row._itemrarity != '' && row._itemrarity != null )
						{
							returnString += '<button class="btn btn-success btn-xs" style="float:right;" data-toggle="popover" title="" data-placement="right" data-content="';
							for ( var i = 0; i < 6; i++ )
							{
								var optionname = eval('row._item_option_' + i);

								if ( optionname == 0 )
								{
									if ( i == 0 )
									{
										returnString += '<font style=\'color: #646464\'>' + lang['no_options'] + '</font>';
									}
									break;
								}
								else
								{
									if ( i > 0 )
									{
										returnString += '<br />';
									}
									if ( optionname.grade == 'NORMAL' )
									{
										returnString += '<font style=\'color: #646464\'>';
									}
									if ( optionname.grade == 'MAGIC' )
									{
										returnString += '<font style=\'color: green\'>';
									}
									else if ( optionname.grade == 'RARE' )
									{
										returnString += '<font style=\'color: #BE8E27\'>';
									}
									else if ( optionname.grade == 'EPIC' )
									{
										returnString += '<font style=\'color: purple\'>';
									}
									else if ( optionname.grade == 'UNIQUE' )
									{
										returnString += '<font style=\'color: gold\'>';
									}
									returnString += lang[optionname.type] + ' : ' + optionname.value;
									if ( optionname.grade != '' )
									{
										returnString += '</font>';
									}
								}
							}
							returnString += '" type="button" data-original-title="<font style=\'color: #646464\'>' + lang['option_information'] + '</font>">' + lang['option'] + '</button>';
						}
						return returnString;
					} },
					{"className" : "text-right", "data" : "_item_index"},
					{"className" : "text-center", "data" : "_count"},
					{"className" : "text-center", "data" : "_limit_time"},
					{"className" : "text-center", "data" : "_distraint_status"},
					{"className" : "text-center", "data" : "_acquired_time"}
				],
				destroy: true,
				autoWidth: false,
				paging: true,
				info: true,
				searching: true,
				ordering: true,
				order: [[ 0, 'desc' ]]
			});

			jQuery('#item_info').on( 'draw.dt', function () {
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
			    jQuery(this).find('tbody > tr').each( function () {
				    var nameString = jQuery(this).find('td').eq(1).text();
				    if ( nameString.indexOf(']') > -1 )
				    {
					    if ( nameString.substring(1, nameString.indexOf(']')) == lang['NORMAL'] )
						{
							jQuery(this).find('td').eq(1).css('color', '#646464');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['MAGIC'] )
						{
							jQuery(this).find('td').eq(1).css('color', 'green');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['RARE'] )
						{
							jQuery(this).find('td').eq(1).css('color', '#BE8E27');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['EPIC'] )
						{
							jQuery(this).find('td').eq(1).css('color', 'purple');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['UNIQUE'] )
						{
							jQuery(this).find('td').eq(1).css('color', 'gold');
						}
				    }
			    });
			});
		}
		else if ( target == '#btabs-alt-static-justified-mecha_info' )
		{
			jQuery('#mecha_info').dataTable({
	            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
	            pageLength: 10,
	            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
				"ajax": {
					"type"   : "POST",
					"url"    : '/User/itemlist',
					"data"   : {'_player_id': jQuery('#_player_id').val(), '_server_id': jQuery('#_server_id').val(), 'type': 'MECHA'},
					"dataSrc": ""
				},
				"columns": [
					{"className" : "text-center", "data" : "_player_name"},
					{"className" : "text-left", "data" : "_itemnamekor", "render" : function ( data, type, row, meta ) {
						var returnString = ( row._itemrarity != '' && row._itemrarity != null ? '[' + lang[row._itemrarity] + '] ' : '' ) + ( session_language == '' || session_language == 'kr' ? row._itemnamekor : row._itemnameeng ) + (row._isown == 1 ? ' [' + lang['belonging'] + ']' : '');
						if ( row._itemrarity != '' && row._itemrarity != null )
						{
							returnString += '<button class="btn btn-success btn-xs" style="float:right;" data-toggle="popover" title="" data-placement="right" data-content="';
							for ( var i = 0; i < 6; i++ )
							{
								var optionname = eval('row._item_option_' + i);

								if ( optionname == 0 )
								{
									if ( i == 0 )
									{
										returnString += '<font style=\'color: #646464\'>' + lang['no_options'] + '</font>';
									}
									break;
								}
								else
								{
									if ( i > 0 )
									{
										returnString += '<br />';
									}
									if ( optionname.grade == 'NORMAL' )
									{
										returnString += '<font style=\'color: #646464\'>';
									}
									if ( optionname.grade == 'MAGIC' )
									{
										returnString += '<font style=\'color: green\'>';
									}
									else if ( optionname.grade == 'RARE' )
									{
										returnString += '<font style=\'color: #BE8E27\'>';
									}
									else if ( optionname.grade == 'EPIC' )
									{
										returnString += '<font style=\'color: purple\'>';
									}
									else if ( optionname.grade == 'UNIQUE' )
									{
										returnString += '<font style=\'color: gold\'>';
									}
									returnString += lang[optionname.type] + ' : ' + optionname.value;
									if ( optionname.grade != '' )
									{
										returnString += '</font>';
									}
								}
							}
							returnString += '" type="button" data-original-title="<font style=\'color: #646464\'>' + lang['option_information'] + '</font>">' + lang['option'] + '</button>';
						}
						return returnString;
					} },
					{"className" : "text-right", "data" : "_item_index"},
					{"className" : "text-center", "data" : "_count"},
					{"className" : "text-center", "data" : "_limit_time"},
					{"className" : "text-center", "data" : "_distraint_status"},
					{"className" : "text-center", "data" : "_acquired_time"}
				],
				destroy: true,
				autoWidth: false,
				paging: true,
				info: true,
				searching: true,
				ordering: true,
				order: [[ 0, 'desc' ]]
			});

			jQuery('#mecha_info').on( 'draw.dt', function () {
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
			    jQuery(this).find('tbody > tr').each( function () {
				    var nameString = jQuery(this).find('td').eq(1).text();
				    if ( nameString.indexOf(']') > -1 )
				    {
					    if ( nameString.substring(1, nameString.indexOf(']')) == lang['NORMAL'] )
						{
							jQuery(this).find('td').eq(1).css('color', '#646464');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['MAGIC'] )
						{
							jQuery(this).find('td').eq(1).css('color', 'green');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['RARE'] )
						{
							jQuery(this).find('td').eq(1).css('color', '#BE8E27');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['EPIC'] )
						{
							jQuery(this).find('td').eq(1).css('color', 'purple');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['UNIQUE'] )
						{
							jQuery(this).find('td').eq(1).css('color', 'gold');
						}
				    }
			    });
			});
		}
		else if ( target == '#btabs-alt-static-justified-pet_info' )
		{
			jQuery('#pet_info').dataTable({
	            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
	            pageLength: 10,
	            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
				"ajax": {
					"type"   : "POST",
					"url"    : '/User/itemlist',
					"data"   : {'_player_id': jQuery('#_player_id').val(), '_server_id': jQuery('#_server_id').val(), 'type': 'PET'},
					"dataSrc": ""
				},
				"columns": [
					{"className" : "text-center", "data" : "_player_name"},
					{"className" : "text-left", "data" : "_itemnamekor", "render" : function ( data, type, row, meta ) {
						var returnString = ( row._itemrarity != '' && row._itemrarity != null ? '[' + lang[row._itemrarity] + '] ' : '' ) + ( session_language == '' || session_language == 'kr' ? row._itemnamekor : row._itemnameeng ) + (row._isown == 1 ? ' [' + lang['belonging'] + ']' : '');
						if ( row._itemrarity != '' && row._itemrarity != null )
						{
							returnString += '<button class="btn btn-success btn-xs" style="float:right;" data-toggle="popover" title="" data-placement="right" data-content="';
							for ( var i = 0; i < 6; i++ )
							{
								var optionname = eval('row._item_option_' + i);

								if ( optionname == 0 )
								{
									if ( i == 0 )
									{
										returnString += '<font style=\'color: #646464\'>' + lang['no_options'] + '</font>';
									}
									break;
								}
								else
								{
									if ( i > 0 )
									{
										returnString += '<br />';
									}
									if ( optionname.grade == 'NORMAL' )
									{
										returnString += '<font style=\'color: #646464\'>';
									}
									if ( optionname.grade == 'MAGIC' )
									{
										returnString += '<font style=\'color: green\'>';
									}
									else if ( optionname.grade == 'RARE' )
									{
										returnString += '<font style=\'color: #BE8E27\'>';
									}
									else if ( optionname.grade == 'EPIC' )
									{
										returnString += '<font style=\'color: purple\'>';
									}
									else if ( optionname.grade == 'UNIQUE' )
									{
										returnString += '<font style=\'color: gold\'>';
									}
									returnString += lang[optionname.type] + ' : ' + optionname.value;
									if ( optionname.grade != '' )
									{
										returnString += '</font>';
									}
								}
							}
							returnString += '" type="button" data-original-title="<font style=\'color: #646464\'>' + lang['option_information'] + '</font>">' + lang['option'] + '</button>';
						}
						return returnString;
					} },
					{"className" : "text-right", "data" : "_item_index"},
					{"className" : "text-center", "data" : "_count"},
					{"className" : "text-center", "data" : "_limit_time"},
					{"className" : "text-center", "data" : "_distraint_status"},
					{"className" : "text-center", "data" : "_acquired_time"}
				],
				destroy: true,
				autoWidth: false,
				paging: true,
				info: true,
				searching: true,
				ordering: true,
				order: [[ 0, 'desc' ]]
			});

			jQuery('#pet_info').on( 'draw.dt', function () {
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
			    jQuery(this).find('tbody > tr').each( function () {
				    var nameString = jQuery(this).find('td').eq(1).text();
				    if ( nameString.indexOf(']') > -1 )
				    {
					    if ( nameString.substring(1, nameString.indexOf(']')) == lang['NORMAL'] )
						{
							jQuery(this).find('td').eq(1).css('color', '#646464');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['MAGIC'] )
						{
							jQuery(this).find('td').eq(1).css('color', 'green');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['RARE'] )
						{
							jQuery(this).find('td').eq(1).css('color', '#BE8E27');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['EPIC'] )
						{
							jQuery(this).find('td').eq(1).css('color', 'purple');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['UNIQUE'] )
						{
							jQuery(this).find('td').eq(1).css('color', 'gold');
						}
				    }
			    });
			});
		}
		else if ( target == '#btabs-alt-static-justified-storage_info' )
		{
			jQuery('#storage_info').dataTable({
	            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
	            pageLength: 10,
	            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
				"ajax": {
					"type"   : "POST",
					"url"    : '/User/storagelist',
					"data"   : {'_player_id': jQuery('#_player_id').val(), '_server_id': jQuery('#_server_id').val()},
					"dataSrc": ""
				},
				"columns": [
					{"className" : "text-center", "data" : "_player_name"},
					{"className" : "text-left", "data" : "_itemnamekor", "render" : function ( data, type, row, meta ) {
						var returnString = ( row._itemrarity != '' && row._itemrarity != null ? '[' + lang[row._itemrarity] + '] ' : '' ) + ( session_language == '' || session_language == 'kr' ? row._itemnamekor : row._itemnameeng ) + (row._isown == 1 ? ' [' + lang['belonging'] + ']' : '');
						if ( row._itemrarity != '' && row._itemrarity != null )
						{
							returnString += '<button class="btn btn-success btn-xs" style="float:right;" data-toggle="popover" title="" data-placement="right" data-content="';
							for ( var i = 0; i < 6; i++ )
							{
								var optionname = eval('row._item_option_' + i);

								if ( optionname == 0 )
								{
									if ( i == 0 )
									{
										returnString += '<font style=\'color: #646464\'>' + lang['no_options'] + '</font>';
									}
									break;
								}
								else
								{
									if ( i > 0 )
									{
										returnString += '<br />';
									}
									if ( optionname.grade == 'NORMAL' )
									{
										returnString += '<font style=\'color: #646464\'>';
									}
									if ( optionname.grade == 'MAGIC' )
									{
										returnString += '<font style=\'color: green\'>';
									}
									else if ( optionname.grade == 'RARE' )
									{
										returnString += '<font style=\'color: #BE8E27\'>';
									}
									else if ( optionname.grade == 'EPIC' )
									{
										returnString += '<font style=\'color: purple\'>';
									}
									else if ( optionname.grade == 'UNIQUE' )
									{
										returnString += '<font style=\'color: gold\'>';
									}
									returnString += lang[optionname.type] + ' : ' + optionname.value;
									if ( optionname.grade != '' )
									{
										returnString += '</font>';
									}
								}
							}
							returnString += '" type="button" data-original-title="<font style=\'color: #646464\'>' + lang['option_information'] + '</font>">' + lang['option'] + '</button>';
						}
						return returnString;
					} },
					{"className" : "text-right", "data" : "_item_index"},
					{"className" : "text-center", "data" : "_count"},
					{"className" : "text-center", "data" : "_limit_time"},
					{"className" : "text-center", "data" : "_distraint_status"},
					{"className" : "text-center", "data" : "_acquired_time"}
				],
				destroy: true,
				autoWidth: false,
				paging: true,
				info: true,
				searching: true,
				ordering: true,
				order: [[ 0, 'desc' ]]
			});

			jQuery('#storage_info').on( 'draw.dt', function () {
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
			    jQuery(this).find('tbody > tr').each( function () {
				    var nameString = jQuery(this).find('td').eq(1).text();
				    if ( nameString.indexOf(']') > -1 )
				    {
					    if ( nameString.substring(1, nameString.indexOf(']')) == lang['NORMAL'] )
						{
							jQuery(this).find('td').eq(1).css('color', '#646464');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['MAGIC'] )
						{
							jQuery(this).find('td').eq(1).css('color', 'green');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['RARE'] )
						{
							jQuery(this).find('td').eq(1).css('color', '#BE8E27');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['EPIC'] )
						{
							jQuery(this).find('td').eq(1).css('color', 'purple');
						}
						else if ( nameString.substring(1, nameString.indexOf(']')) == lang['UNIQUE'] )
						{
							jQuery(this).find('td').eq(1).css('color', 'gold');
						}
				    }
			    });
			});
		}
		else if ( target == '#btabs-alt-static-justified-track_info' )
		{
			jQuery('#track_info').dataTable({
	            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
	            pageLength: 10,
	            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
				"ajax": {
					"type"   : "POST",
					"url"    : '/User/tracklist',
					"data"   : {'_player_id': jQuery('#_player_id').val(), '_server_id': jQuery('#_server_id').val()},
					"dataSrc": ""
				},
				"columns": [
					{"className" : "text-center", "data" : "_id"},
					{"className" : "text-left", "data" : "_dun_name_kor", "render" : function ( data, type, row, meta ) {
						return ( session_language == '' || session_language == 'kr' ? row._dun_name_kor : row._dun_name_eng );
					}},
					{"className" : "text-right", "data" : "_day_clear_cnt", "render" : function ( data, type, row, meta ) {
						var dateString;
						if ( row._day_clear_auto_last_day == 0 )
						{
							dateString = '-';
						}
						else
						{
							dateString = row._day_clear_last_day.substring(0, 4) + '-' + row._day_clear_last_day.substring(4, 6) + '-' + row._day_clear_last_day.substring(6, 8);
						}
						return row._day_clear_cnt + ' / ' + row._dun_free_count + ' ( ' + dateString + ' )';
					}},
					{"className" : "text-right", "data" : "_day_auto_clear_cnt", "render" : function ( data, type, row, meta ) {
						var dateString;
						if ( row._day_clear_auto_last_day == 0 )
						{
							dateString = '-';
						}
						else
						{
							dateString = row._day_clear_auto_last_day.substring(0, 4) + '-' + row._day_clear_auto_last_day.substring(4, 6) + '-' + row._day_clear_auto_last_day.substring(6, 8);
						}
						return row._day_clear_auto_cnt + ' / ' + row._dun_free_count + ' ( ' + dateString + ' )';
					}},
					{"className" : "text-right", "data" : "_max_rank"},
					{"className" : "text-center", "data" : "_total_clear"},
					{"className" : "text-center", "data" : "_date"}
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
		else if ( target == '#btabs-alt-static-justified-guild_info' )
		{
			jQuery('#sel_server').val(jQuery('#_server_id').val()).trigger("change");
			jQuery('#guild_name').val( ( jQuery('#_guild_name').val() == '0' ? '' : jQuery('#_guild_name').val() ) );
			if ( jQuery('#guild_name').val() != '' )
			{
				jQuery.ajax({
					type: 'POST',
					url: '/User/guilddetail',
					data: {'_guild_name': jQuery('#guild_name').val(), '_server_id': jQuery('#sel_server').val()},
					success: function (result) {
						if ( result == '[]' )
						{
							jQuery('#_table_guild_nm').text('-');
							jQuery('#_table_guild_master_name').text('-');
							jQuery('#_table_guild_pl_cnt').text('-');
							jQuery('#_table_guild_insert_date').text('-');
							jQuery('#_table_guild_level').text('-');
							jQuery('#_table_guild_rank').text('-');
							jQuery('#_table_guild_occupy').text('-');
							jQuery('#_table_guild_mark').text('-');
						}
						else
						{
							var obj = eval(result);
							jQuery('#_table_guild_nm').text(obj[0]._guild_name);
							jQuery('#_table_guild_master_name').text(obj[0]._master_name);
							jQuery('#_table_guild_pl_cnt').text(obj[0]._pl_cnt + ' / ' + obj[0]._pl_cnt_max);
							jQuery('#_table_guild_insert_date').text(obj[0]._insertdate);
							jQuery('#_table_guild_level').text(obj[0]._lvl);
							jQuery('#_table_guild_rank').text(obj[0]._rank);
							jQuery('#_table_guild_occupy').text(obj[0]._occupy);
							jQuery('#_table_guild_mark').text(obj[0]._guild_color + ', ' + obj[0]._mark_id);
							jQuery('#guildmember_info').dataTable({
								dom:
						            "<'row'<'col-sm-12'tr>>" +
						            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
						        columnDefs: [ { orderable: false, targets: [ 0 ] } ],
						        pageLength: 10,
						        lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
								"ajax": {
									"type"   : "POST",
									"url"    : '/User/guildmemberlist',
									"data"   : {'_guild_name': jQuery('#guild_name').val(), '_server_id': jQuery('#sel_server').val()},
									"dataSrc": ""
								},
								"columns": [
									{"className" : "text-center", "data" : "_player_name"},
									{"className" : "text-center", "data" : "_player_id"},
									{"className" : "text-center", "data" : "_level"},
									{"className" : "text-center", "data" : "_char_id"},
									{"className" : "text-center", "data" : "_grade"}
								],
								destroy: true,
								autoWidth: false,
								paging: true,
								info: true,
								searching: true,
								ordering: true,
								order: [[ 3, 'desc' ]]
						    });
						}
					}
				});
			}
			else
			{
				jQuery('#_table_guild_nm').text('-');
				jQuery('#_table_guild_master_name').text('-');
				jQuery('#_table_guild_pl_cnt').text('-');
				jQuery('#_table_guild_insert_date').text('-');
				jQuery('#_table_guild_level').text('-');
				jQuery('#_table_guild_rank').text('-');
				jQuery('#_table_guild_occupy').text('-');
				jQuery('#_table_guild_mark').text('-');
				jQuery('#guildmember_info').find('tbody').html('<tr><td class="text-center" colspan="5">' + lang['select_guild_first'] + '</td></tr>');
			}
		}
		else if ( target == '#btabs-alt-static-justified-mailbox_info' )
		{
			jQuery('#mailbox_info').dataTable({
				dom:
		            "<'row'<'col-sm-12'tr>>" +
		            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
		        columnDefs: [ { orderable: false, targets: [ 0 ] } ],
		        pageLength: 10,
		        lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
				"ajax": {
					"type"   : "POST",
					"url"    : '/User/maillist',
					"data"   : {'_player_id': jQuery('#_player_id').val(), '_server_id': jQuery('#_server_id').val()},
					"dataSrc": ""
				},
				"columns": [
					{"className" : "text-center", "data" : "_itime"},
					{"className" : "text-center", "data" : "items", "render": function ( data, type, row, meta ) {
						var strItem = '';
						for ( var i = 0; i < row.items.length; i++ )
						{
							strItem += ( row.items[i].index == 9999999 ? '-' : row.items[i].index );
							if ( i < row.items.length - 1 )
							{
								strItem += '<br />';
							}
						}

						return strItem;
					}},
					{"className" : "text-center", "data" : "items", "render": function ( data, type, row, meta ) {
						var strItem = '';
						for ( var i = 0; i < row.items.length; i++ )
						{
							strItem += row.items[i]._itemnamekor;
							if ( i < row.items.length - 1 )
							{
								strItem += '<br />';
							}
						}

						return strItem;
					}},
					{"className" : "text-center", "data" : "items", "render": function ( data, type, row, meta ) {
						var strItem = '';
						for ( var i = 0; i < row.items.length; i++ )
						{
							strItem += row.items[i].count;
							if ( i < row.items.length - 1 )
							{
								strItem += '<br />';
							}
						}

						return strItem;
					}},
					{"className" : "text-center", "data" : "_etime"},
					{"className" : "text-center", "data" : "_type"}
				],
				destroy: true,
				autoWidth: false,
				paging: true,
				info: true,
				searching: true,
				ordering: true,
				order: [[ 3, 'desc' ]]
		    });
		}
	});

	jQuery(document).on( 'click', '#btnSearch', function (e) {
		e.preventDefault();

		jQuery('#account_list').dataTable({
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 10,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
			"ajax": {
				"type"   : "POST",
				"url"    : '/User/characterlist',
				"data"   : {'search_type': jQuery('#search_type').val(), 'search_value': jQuery('#search_value').val()},
				"dataSrc": ""
			},
			"columns": [
				{"className" : "text-center", "data" : "_user_id"},
				{"className" : "text-center", "data" : "_user_account"},
				{"className" : "text-center", "data" : "_email"},
				{"className" : "text-center", "data" : "_server_id", "render" : function ( data, type, row, meta ) {
					return serverlist[row._server_id].name;
				}},
				{"className" : "text-center", "data" : "_player_name"},
				{"className" : "text-center", "data" : "_level"},
				{"className" : "text-center", "data" : "_birth_datetime"},
				{"className" : "text-center", "data" : "_block_type", "render" : function ( data, type, row, meta ) { return ( data == '' ? '<span class="label label-primary">' + lang['in_use'] + '</span>' : '<span class="label label-primary">' + lang['not_in_use'] + '</span>' ); } },
				{"className" : "text-center", "data" : "_etime"},
				{"className" : "text-center", "data" : "_user_id", "render" : function ( data, type, row, meta ) { return '<button class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-large" data-userid="' + data + '" data-useraccount="' + row._user_account + '" data-email="' + row._email + '" data-birthdatetime="' + row._birth_datetime + '" data-level="' + row._level + '" data-blocktype="' + ( row._block_type == '' ? lang['in_use'] : lang['not_in_use'] ) + '" data-playername="' + row._player_name + '" data-exp="' + row._exp + '" data-prevtotalexp="' + row._prev_total_exp + '" data-needexp="' + row._need_exp + '" data-playerid="' + row._player_id + '" data-serverid="' + row._server_id + '" data-guildname="' + row._guild_name + '" data-logon="' + row._logon + '" data-valid="' + row._valid + '" data-gold="' + row._gold + '" data-vipgrade="' + row._grade + '" data-guildpoint="' + row._guild_point + '" data-buddycount="' + row._buddy_count + '" data-buddymax="' + row._buddy_max + '" data-gem="' + row._gem + '" data-free_gem="' + row._free_gem + '" data-gem_charge_sum="' + row._gem_charge_sum + '" data-charid="' + row._char_id + '" data-invenmax="' + row._inven_max + '" type="button">' + lang['detail'] + '</button>'; } }
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

	jQuery('#modal-large').on('show.bs.modal', function (event) {
		var button = jQuery(event.relatedTarget); // Button that triggered the modal
		prevId = button.data('userid');
		prevPId = button.data('playerid');
		prevSId = button.data('serverid');
		prevGuildName = button.data('guildname');
		var trIdx;

		jQuery('#myTab a:first').tab('show');
		if ( button.data('userid') )
		{
			jQuery('#headinfo').dataTable({
	            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
	            pageLength: 10,
	            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
				"ajax": {
					"type"   : "POST",
					"url"    : '/User/characterlist',
					"async"  : false,
					"data"   : {'search_type': '_user_id', 'search_value': button.data('userid'), '_server_id': button.data('serverid')},
					"dataSrc": ""
				},
				"columns": [
					{"className" : "text-center", "data" : "_user_id"},
					{"className" : "text-center", "data" : "_user_account"},
					{"className" : "text-center", "data" : "_email"},
					{"className" : "text-center", "data" : "_server_id", "render" : function ( data, type, row, meta ) {
						return serverlist[row._server_id].name;
					}},
					{"className" : "text-center", "data" : "_player_name"},
					{"className" : "text-center", "data" : "_level"},
					{"className" : "text-center", "data" : "_birth_datetime"},
					{"className" : "text-center", "data" : "_block_type", "render" : function ( data, type, row, meta ) { return ( data == '' ? '<span class="label label-primary">' + lang['in_use'] + '</span>' : '<span class="label label-primary">' + lang['not_in_use'] + '</span>' ); } },
					{"className" : "text-center", "data" : "_etime"},
					{"className" : "text-center", "data" : "_user_id", "render" : function ( data, type, row, meta ) { return '<button class="btn btn_sub_det btn-info btn-xs" data-target="#modal-large" data-userid="' + data + '" data-useraccount="' + row._user_account + '" data-email="' + row._email + '" data-birthdatetime="' + row._birth_datetime + '" data-level="' + row._level + '" data-blocktype="' + ( row._block_type == '' ? lang['in_use'] : lang['not_in_use'] ) + '" data-playername="' + row._player_name + '" data-exp="' + row._exp + '" data-prevtotalexp="' + row._prev_total_exp + '" data-needexp="' + row._need_exp + '" data-playerid="' + row._player_id + '" data-serverid="' + row._server_id + '" data-guildname="' + row._guild_name + '" data-logon="' + row._logon + '" data-valid="' + row._valid + '" data-gold="' + row._gold + '" data-vipgrade="' + row._grade + '" data-guildpoint="' + row._guild_point + '" data-buddycount="' + row._buddy_count + '" data-buddymax="' + row._buddy_max + '" data-gem="' + row._gem + '" data-free_gem="' + row._free_gem + '" data-gem_charge_sum="' + row._gem_charge_sum + '" data-charid="' + row._char_id + '" data-invenmax="' + row._inven_max + '" type="button">' + lang['detail'] + '</button>'; } }
				],
				destroy: true,
				autoWidth: false,
				paging: true,
				info: true,
				searching: true,
				ordering: true,
				order: [[ 3, 'desc' ]],
				"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
					if ( aData._player_id == button.data('playerid') && aData._server_id == button.data('serverid') )
					{
						trIdx = iDisplayIndex + 1;
						jQuery('#_user_id').val( button.data('userid') ); // Extract info from data-* attributes
						jQuery('#_level').val( button.data('level') ); // Extract info from data-* attributes
						jQuery('#_user_account').val( button.data('useraccount') ); // Extract info from data-* attributes
						jQuery('#_guild_name').val( button.data('guildname') ); // Extract info from data-* attributes
						jQuery('#_server_id').val( button.data('serverid') ); // Extract info from data-* attributes
						jQuery('#_player_id').val( button.data('playerid') ); // Extract info from data-* attributes
						var ItemCur = 0;
						jQuery.ajax({
							type	: 'POST',
							url		: '/User/itemlist',
							async	: false,
							data	: {'_player_id': jQuery('#_player_id').val(), '_server_id': jQuery('#_server_id').val(), 'type': 'NORMAL'},
							success	: function ( result ) {
								ItemCur = eval(result).length;
							},
							error	: function () {
								ItemCur = 'err';
							}
						});
						jQuery('#_table_inven_max').html( lang['inven_max'] + ' : ' + ItemCur + ' / ' + button.data('invenmax') );
						jQuery('#_table_player_id').text( lang['player_id'] + ' : ' + button.data('playerid') );
						jQuery('#_table_player_name').text( lang['player_name'] + ' : ' + button.data('playername') );
						jQuery('#_table_server_id').text( lang['server_id'] + ' : ' + serverlist[button.data('serverid')].name );
						jQuery('#_table_class').text( lang['class'] + ' : ' + lang[classtype[button.data('charid')]] );
						jQuery('#_table_user_account').text( lang['user_account'] + ' : ' + button.data('useraccount') );
						jQuery('#_table_level').text( lang['level'] + ' : ' + button.data('level') );
						jQuery('#_table_guildpoint').text( lang['guildpoint'] + ' : ' + button.data('guildpoint') );
						jQuery('#_table_vipgrade').text( lang['vipgrade'] + ' : ' + button.data('vipgrade') + ' / 12' );
						jQuery('#_table_online').text( lang['online'] + ' : ' + button.data('logon') );
						jQuery('#_table_valid').text( lang['valid'] + ' : ' + button.data('valid') );
						jQuery('#_table_exp').text( lang['exp'] + ' : ' + Math.round( ( ( button.data('exp') - button.data('prevtotalexp') ) / button.data('needexp') ) * 100 ) + '% ( ' + ( button.data('exp') - button.data('prevtotalexp') ) + ' / ' + button.data('needexp') + ' )' );
						jQuery('#_table_guild_name').text( lang['guild_name'] + ' : ' + (button.data('guildname') == '' ? '-' : button.data('guildname')) );
						jQuery('#_table_email').text( lang['email'] + ' : ' + (button.data('email') == '' ? '-' : button.data('email')) );
						jQuery('#_table_buddy').text( lang['buddy'] + ' : ' + button.data('buddycount') + ' / ' + button.data('buddymax') );
						jQuery('#_table_gem').html( lang['gem'] + ' : ' + button.data('gem') );
						jQuery('#_table_free_gem').html( lang['free_gem'] + ' : ' + button.data('free_gem') );
						jQuery('#_table_gold').text( lang['gold'] + ' : ' + button.data('gold') );
						jQuery('#_table_gem_charge_sum').html( lang['gem_charge_sum'] + ' : ' + button.data('gem_charge_sum') );
						prevId = button.data('userid');
						prevPId = button.data('playerid');
						prevSId = button.data('serverid');
						prevGuildName = button.data('guildname');
					}
					else
					{
						jQuery('#headinfo').find('tr').eq(iDisplayIndex).removeClass('bg-danger-light');
					}
				}
	        });
			jQuery('#headinfo').find('tr').eq(trIdx).addClass('bg-danger-light');

			jQuery('#adminlog').dataTable({
	            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
	            pageLength: 10,
	            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
				"ajax": {
					"type"   : "POST",
					"url"    : '/User/adminlog',
					"async"	 : false,
					"data"   : {'search_type': '_player_id', 'search_value': button.data('playerid')},
					"dataSrc": ""
				},
				dom:
                "<'row'<'col-sm-12'tr>>",
                "columns": [
					{"className" : "text-center", "data" : "_id"},
					{"className" : "text-center", "data" : "_datetime"},
					{"className" : "text-center", "data" : "_ip"},
					{"className" : "text-center", "data" : "_admin_id"},
					{"className" : "text-center", "data" : "_player_id"},
					{"className" : "text-center", "data" : "_admin_memo"},
					{"className" : "text-center", "data" : "_content"}
				],
				destroy: true,
				autoWidth: false,
				paging: true,
				info: true,
				searching: true,
				ordering: true,
				order: [[ 3, 'desc' ]]
	        });
		}
		else
		{
			jQuery('#_user_id').val( prevId ); // Extract info from data-* attributes
			jQuery('#_player_id').val( prevPId ); // Extract info from data-* attributes
			jQuery('#_server_id').val( prevSId ); // Extract info from data-* attributes
			jQuery('#_guild_name').val( prevGuildName ); // Extract info from data-* attributes
		}
	});

	jQuery(document).on('click', '.btn_sub_det', function (event) {
		event.preventDefault();
		jQuery('#myTab a:first').tab('show');
		jQuery('#_player_id').val( jQuery(this).data('playerid') );
		jQuery('#_server_id').val( jQuery(this).data('serverid') );
		jQuery(this).parent().parent().parent().find('tr').removeClass('bg-danger-light');
		jQuery(this).parent().parent().addClass('bg-danger-light');
		jQuery.ajax({
			"type"   : "POST",
			"url"    : '/User/characterlist',
			"data"   : {'search_type': '_player_id', 'search_value': jQuery('#_player_id').val(), '_server_id':jQuery('#_server_id').val()},
			"dataSrc": "",
			"success": function (result) {
				var obj = eval(result);
				jQuery('#_user_id').val( obj[0]._user_id ); // Extract info from data-* attributes
				jQuery('#_user_account').val( obj[0]._user_account ); // Extract info from data-* attributes
				jQuery('#_level').val( obj[0]._level ); // Extract info from data-* attributes
				jQuery('#_player_id').val( obj[0]._player_id ); // Extract info from data-* attributes
				jQuery('#_server_id').val( obj[0]._server_id ); // Extract info from data-* attributes
				jQuery('#_guild_name').val( obj[0]._guild_name ); // Extract info from data-* attributes
				var ItemCur = 0;
				jQuery.ajax({
					type	: 'POST',
					url		: '/User/itemlist',
					async	: false,
					data	: {'_player_id': jQuery('#_player_id').val(), '_server_id': jQuery('#_server_id').val(), 'type': 'NORMAL'},
					success	: function ( result ) {
						ItemCur = eval(result).length;
					},
					error	: function () {
						ItemCur = 'err';
					}
				});
				jQuery('#_table_inven_max').html( lang['inven_max'] + ' : ' + ItemCur + ' / ' + obj[0]._inven_max );
				jQuery('#_table_player_name').text( lang['player_name'] + ' : ' + obj[0]._player_name );
				jQuery('#_table_player_id').text( lang['player_id'] + ' : ' + obj[0]._player_id );
				jQuery('#_table_server_id').text( lang['server_id'] + ' : ' + serverlist[obj[0]._server_id].name );
				jQuery('#_table_class').text( lang['class'] + ' : ' + lang[classtype[obj[0]._char_id]] );
				jQuery('#_table_level').text( lang['level'] + ' : ' + obj[0]._level);
				jQuery('#_table_guildpoint').text( lang['guildpoint'] + ' : ' + obj[0]._guild_point );
				jQuery('#_table_vipgrade').text( lang['vipgrade'] + ' : ' + obj[0]._grade + ' / 12' );
				jQuery('#_table_online').text( lang['online'] + ' : ' + obj[0]._logon );
				jQuery('#_table_valid').text( lang['valid'] + ' : ' + obj[0]._valid );
				jQuery('#_table_exp').text( lang['exp'] + ' : ' + Math.round( ( ( obj[0]._exp - obj[0]._prev_total_exp ) / obj[0]._need_exp ) * 100 ) + '% ( ' + ( obj[0]._exp - obj[0]._prev_total_exp ) + ' / ' + obj[0]._need_exp + ' )' );
				jQuery('#_table_guild_name').text( lang['guild_name'] + ' : ' + (obj[0]._guild_name == '' ? '-' : obj[0]._guild_name) );
				jQuery('#_table_buddy').text( lang['buddy'] + ' : ' + obj[0]._buddy_count + ' / ' + obj[0]._buddy_max );
				jQuery('#_table_gem').html( lang['gem'] + ' : ' + obj[0]._gem );
				jQuery('#_table_free_gem').html( lang['free_gem'] + ' : ' + obj[0]._free_gem );
				jQuery('#_table_gold').text( lang['gold'] + ' : ' + obj[0]._gold );
				jQuery('#_table_gem_charge_sum').html( lang['gem_charge_sum'] + ' : ' + obj[0]._gem_charge_sum );

				prevId = obj[0]._user_id;
				prevPId = obj[0]._player_id;
				prevSId = obj[0]._server_id;
				prevGuildName = obj[0]._guild_name;
			}
		});

		jQuery('#adminlog').dataTable({
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 10,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
			"ajax": {
				"type"   : "POST",
				"url"    : '/User/adminlog',
				"async"	 : false,
				"data"   : {'search_type': '_player_id', 'search_value': jQuery('#_player_id').val()},
				"dataSrc": ""
			},
			dom:
            "<'row'<'col-sm-12'tr>>",
            "columns": [
				{"className" : "text-center", "data" : "_id"},
				{"className" : "text-center", "data" : "_datetime"},
				{"className" : "text-center", "data" : "_ip"},
				{"className" : "text-center", "data" : "_admin_id"},
				{"className" : "text-center", "data" : "_player_id"},
				{"className" : "text-center", "data" : "_admin_memo"},
				{"className" : "text-center", "data" : "_content"}
			],
			destroy: true,
			autoWidth: false,
			paging: true,
			info: true,
			searching: true,
			ordering: true,
			order: [[ 3, 'desc' ]]
        });

		jQuery('.nav li:eq(0) a').tab('show')
	});

	jQuery('#btnGuildSearch').on('click', function (event) {
		event.preventDefault();
		if ( jQuery('#guild_name').val() != '' )
		{
			jQuery.ajax({
				type: 'POST',
				url: '/User/guilddetail',
				data: {'_guild_name': jQuery('#guild_name').val(), '_server_id': jQuery('#sel_server').val()},
				success: function (result) {
					if ( result == '[]' )
					{
						jQuery('#_table_guild_nm').text('-');
						jQuery('#_table_guild_master_name').text('-');
						jQuery('#_table_guild_pl_cnt').text('-');
						jQuery('#_table_guild_insert_date').text('-');
						jQuery('#_table_guild_level').text('-');
						jQuery('#_table_guild_rank').text('-');
						jQuery('#_table_guild_occupy').text('-');
						jQuery('#_table_guild_mark').text('-');
						swal({
					        title: 'found nothing...',
					        text: lang['search_result_no'],
					        type: 'error'
				        });
					}
					else
					{
						var obj = eval(result);
						jQuery('#_table_guild_nm').text(obj[0]._guild_name);
						jQuery('#_table_guild_master_name').text(obj[0]._master_name);
						jQuery('#_table_guild_pl_cnt').text(obj[0]._pl_cnt + ' / ' + obj[0]._pl_cnt_max);
						jQuery('#_table_guild_insert_date').text(obj[0]._insertdate);
						jQuery('#_table_guild_level').text(obj[0]._lvl);
						jQuery('#_table_guild_rank').text(obj[0]._rank);
						jQuery('#_table_guild_occupy').text(obj[0]._occupy);
						jQuery('#_table_guild_mark').text(obj[0]._guild_color + ', ' + obj[0]._mark_id);
						jQuery('#guildmember_info').dataTable({
							dom:
					            "<'row'<'col-sm-12'tr>>" +
					            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
					        columnDefs: [ { orderable: false, targets: [ 0 ] } ],
					        pageLength: 10,
					        lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
							"ajax": {
								"type"   : "POST",
								"url"    : '/User/guildmemberlist',
								"data"   : {'_guild_name': jQuery('#guild_name').val(), '_server_id': jQuery('#sel_server').val()},
								"dataSrc": ""
							},
							"columns": [
								{"className" : "text-center", "data" : "_player_name"},
								{"className" : "text-center", "data" : "_player_id"},
								{"className" : "text-center", "data" : "_level"},
								{"className" : "text-center", "data" : "_char_id"},
								{"className" : "text-center", "data" : "_grade"}
							],
							destroy: true,
							autoWidth: false,
							paging: true,
							info: true,
							searching: true,
							ordering: true,
							order: [[ 3, 'desc' ]]
					    });
					}
				}
			});
		}
		else
		{
			jQuery('#_table_guild_nm').text('-');
			jQuery('#_table_guild_master_name').text('-');
			jQuery('#_table_guild_pl_cnt').text('-');
			jQuery('#_table_guild_insert_date').text('-');
			jQuery('#_table_guild_level').text('-');
			jQuery('#_table_guild_rank').text('-');
			jQuery('#_table_guild_occupy').text('-');
			jQuery('#_table_guild_mark').text('-');
			jQuery('#guildmember_info').find('tbody').html('<tr><td class="text-center" colspan="5">' + lang['select_guild_first'] + '</td></tr>');
		}
	});

	jQuery(document).on("click", "#btnLogOff", function () {
		swal({
			title: lang['logoff_title'],
			text: lang['user_id'] + ' : ' + jQuery('#_user_id').val() + '\n' + lang['user_account'] + ' : ' + jQuery('#_user_account').val() + '\n' + jQuery('#_table_player_name').text().replace(/\)/gi, '').replace(/ \( /gi, '\n' + lang['player_id'] + ' : '),
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
					url: '/User/forcedtodisconnect',
					data: { 'uid' : jQuery('#_user_id').val(), 'server_id' : jQuery('#_server_id').val() },
					success: function ( result ) {
						if ( result == 'true' )
						{
							swal({
								title: lang['logoff_title'],
								text: lang['logoff_success_text'],
								type: 'success',
							});
						}
						else
						{
							swal({
								title: lang['logoff_title'],
								text: lang['logoff_fail_text'],
								type: 'error',
							});
						}
					}
				});
			}
		});
	});

	jQuery(document).on("show.bs.modal", "#modal-normal", function (e) {
		jQuery('.js-validation-material').removeData("validator");
		jQuery('.js-validation-material > div.block-themed > div.block-content > div.form-group').removeClass('has-error');
		jQuery('#change_val-error').remove();
		jQuery('#change_val2-error').remove();
		jQuery('#admin_memo-error').remove();

		var eventobject = $(e.relatedTarget);
		var editValue = $(this).attr('id').replace(/_edit/gi, '');
	    jQuery('#modal-large').css('z-index', 1033);
	    jQuery('#normal_title').text( lang[eventobject.data('type')]  + ' ' + lang['common_edit'] );
	    if ( eventobject.data('type') == 'exp' || eventobject.data('type') == 'gem_charge_sum' )
	    {
		    if ( jQuery('#val_matrix_title').text() != lang[eventobject.data('type')] )
		    {
			    var ItemCur;
			    var colCnt;
			    jQuery.ajax({
					type	: 'POST',
					url		: '/User/masterinfo',
					async	: false,
					data	: {'_type': eventobject.data('type')},
					success	: function ( result ) {
						ItemCur = eval(result);
					},
					error	: function () {
						alert('error');
					}
			    });

			    switch ( eventobject.data('type') )
			    {
				    case 'exp' :
					    colCnt = 5;
					    colName = ['LV', 'TOTAL_EXP'];
					    break;
					case 'gem_charge_sum' :
						colCnt = 2;
					    colName = ['Vip_Lvl', 'Vip_Total_Cash'];
					    break;
					default :
						colCnt = 1;
			    }

			    var strHtml = '<div class="block-content">\
	                    <table class="table table-bordered" id="master_info">\
	                        <thead>\
	                            <tr>\
	            ';

	            for ( var i = 0; i < colCnt; i++ )
	            {
	                strHtml += '<th class="text-center" style="width: 50px;">' + lang[colName[0]] + '</th>\
	                                <th>' + lang[colName[1]] + '</th>\
	                ';
	            }

	            strHtml += '</tr>\
	                        </thead>\
	                        <tbody>\
				';
				for( var row in ItemCur )
				{
					if ( row == 0 )
					{
						strHtml += '<tr>\
						';
					}
					var tempval = parseInt( eval( 'ItemCur[row].' + colName[1] ) );
					tempval -= ( eventobject.data('type') == 'exp' ? ItemCur[row].NEED_EXP : ( eventobject.data('type') == 'gem_charge_sum' ? ItemCur[row].Vip_Cash : 0 ) );
	                strHtml += '<td class="text-center">' + eval( 'ItemCur[row].' + colName[0] ) + '</td>\
	                                <td class="text-right">' + tempval + '</td>\
					';
					if ( row % colCnt == colCnt - 1 )
					{
						strHtml += '</tr>\
						';
					}
				}

				strHtml += '</tbody>\
	                    </table>\
	                </div>';
			}
		    jQuery('#val_matrix').html(strHtml);
		    jQuery('#val_matrix_title').show();
		    jQuery('#val_matrix').show();
		    jQuery('#val_matrix_title').text( lang[eventobject.data('type')] );
	    }
	    else
	    {
		    jQuery('#val_matrix').hide();
		    jQuery('#val_matrix_title').hide();
	    }
		jQuery('#normal_title2').text( lang[eventobject.data('type')] );
	    if ( session_language == 'kr' || session_language == '' )
	    {
	    	jQuery('#text_confirm').prepend( lang[eventobject.data('type')] + ( has_last( lang[eventobject.data('type')] ) ? '을' : '를' ) );
	    }
	    else
	    {
		    jQuery('#text_confirm').text( 'Do you want to change ' + lang[eventobject.data('type')] + '?' );
	    }
	    jQuery('#cur_val_title').append( jQuery('#_table_' + eventobject.data('type')).text() );
	    jQuery('#change_index').val( eventobject.data('type') );

	    var isVal2 = false;
	    jQuery('#chgval2').css('display', 'none');
		errMsg = Array(lang[jQuery('#change_index').val()], lang['admin_memo'], '');

	    BaseFormValidation.init( errMsg, isVal2 );
	});

	jQuery(document).on("hidden.bs.modal", "#modal-normal", function () {
	    jQuery('#modal-large').css('z-index', 1050);
	    jQuery('body').addClass('modal-open');
	    jQuery('#normal_title').text( '-' );
	    jQuery('#normal_title2').text( '-' );
	    jQuery('#text_confirm').text( ' 수정 하시겠습니까?' );
	    jQuery('#cur_val_title').text( lang['current'] + ' ' );
	});

	jQuery(document).on("click", "#btnNormal", function () {
		if ($('.js-validation-material').valid())
		{
			jQuery.ajax({
				type: 'POST',
				url: '/User/forcedtodisconnect',
				async: false,
				data: { 'uid' : jQuery('#_user_id').val(), 'server_id' : jQuery('#_server_id').val() },
				success: function ( result ) {
					if ( result == 'true' )
					{
						jQuery.ajax({
							type: 'POST',
							url: '/User/changeval',
							async: false,
							data: ( jQuery('#change_index').val() == 'gem' ? { '_user_id': jQuery('#_user_id').val(), '_player_id': jQuery('#_player_id').val(), '_server_id': jQuery('#_server_id').val(), 'change_key' : jQuery('#change_index').val(), 'change_val' : jQuery('#change_val').val(), 'change_val2' : jQuery('#change_val2').val(), 'admin_memo' : jQuery('#admin_memo').val(), 'level' : jQuery('#_level').val() } : { '_user_id': jQuery('#_user_id').val(), '_player_id': jQuery('#_player_id').val(), '_server_id': jQuery('#_server_id').val(), 'change_key' : jQuery('#change_index').val(), 'change_val' : jQuery('#change_val').val(), 'admin_memo' : jQuery('#admin_memo').val(), 'level' : jQuery('#_level').val() } ),
							success: function ( result ) {
								if ( result == 'true' )
								{
									jQuery('#account_list').dataTable().api().ajax.reload();
									jQuery('#modal-large').modal('hide');
									swal({
										title: lang[jQuery('#change_index').val()],
										text: lang[jQuery('#change_index').val()] + ' ' + lang['common_edit'] + lang['success_text'],
										type: 'success'
									}, function () {
										jQuery.each( jQuery('#account_list > tbody > tr'), function ( key, val ) {
											if (
												jQuery(this).children('td').eq(9).children('button').data('playerid') == jQuery('#_player_id').val() &&
												jQuery(this).children('td').eq(9).children('button').data('serverid') == jQuery('#_server_id').val()
											) {
												jQuery(this).children('td').eq(9).children('button').click();
												return false;
											}
										});
									});
								}
								else
								{
									swal({
										title: lang[jQuery('#change_index').val()],
										text: lang[jQuery('#change_index').val()] + ' ' + lang['common_edit'] + lang['fail_text'],
										type: 'error'
									});
								}

								jQuery('#modal-normal').modal('hide');
								jQuery('#change_val').val('');
								jQuery('#change_val2').val('');
								jQuery('#admin_memo').val('');
							}
						});
					}
					else
					{
						swal({
							title: lang[jQuery('#change_index').val()],
							text: lang[jQuery('#change_index').val()] + ' ' + lang['common_edit'] + lang['fail_text'],
							type: 'error'
						});
					}
				}
			});

		}
	});

	jQuery(document).on("click", "#btnBlockChat", function () {
		swal('Now Progressing...')
	});

	if ( auth.edit == '0' )
	{
		jQuery('.btn-edit, #btnLogOff, #btnBlockChat').hide();
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
