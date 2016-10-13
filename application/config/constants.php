<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

const ITEMGRADE = array( '', 'NORMAL', 'MAGIC', 'RARE', 'UNIQUE', 'EPIC' );
const ITEMOPTIONTYPE = array(
        '', 'STR', 'DEX', 'HEA', 'INT', 'LUC', 'HP', 'MP', 'SHIELD(MECHA)', 'DURABILITY(MECHA)', 'ATK_ALL', 'DEF_ALL', 'ATK_PHYSICAL', 'DEF_PHYSICAL',
        'ATK_MAGIC', 'DEF_MAGIC', 'SPEED', '', '', '', '', 'CRT_PERCENT', 'CRT_DMG_PERCENT', 'EVADE_PERCENT', 'PARRY_PERCENT', 'PARRY_DMG_PERCENT',
        'PVP_ATK_PERCENT', 'PVP_DEF_PERCENT'
);
const ITEMOPTIONMAX = 6;        // < 로 비교하므로 1만큼 더 큰값임 실제는 5
const INVENTORY_TYPE = array(
		'NORMAL' => array( 1, 2, 3, 5, 6, 7, 10, 15, 16, 17, 18, 19, 20, 21, 'subtype' => array() ),
		'MECHA' => array( 11, 12, 'subtype' => array() ),
		'PET' => array( 13, 14, 'subtype' => array() ),
		'ALL' => array( 1, 2, 3, 5, 6, 7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21 )
);
const CLASSTYPE = array( '', 'KNIGHT', 'ARCHER', 'WARRIOR', 'WIZARD' );
const GRADETYPE = array( 'NORMAL_MEM', '', '', '', '', 'BIMASTER', '', '', '', '', 'MASTER' );
const NORMALMAILLIMIT = 700;

const MAILTYPE = array(
	'',
	'MAIL_TYPE_TRACK_EXP',																	//1
	'MAIL_TYPE_TRACK_GOLD',																	//2
	'MAIL_TYPE_ITEM_LIMIT_TIME',															//3
	'MAIL_TYPE_ITEM_SOLD',																	//4
	'', '', '',
	'MAIL_TYPE_PVP_CASH',																	//8
	'', '',																					//10
	'', '', '', '', '', '', '', '', '', '',													//20
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//40
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//60
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//80
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//100
	'MAIL_TYPE_TRACK_ITEM',																	//101
	'MAIL_TYPE_TRACK_CASH',																	//102
	'MAIL_TYPE_BOX_ITEM',																	//103
	'', '', '', '', '', '',																	//109
	'MAIL_TYPE_VIP_EXP',																	//110
	'MAIL_TYPE_VIP_GOLD',																	//111
	'MAIL_TYPE_VIP_CASH',																	//112
	'MAIL_TYPE_VIP_POINT',																	//113
	'MAIL_TYPE_VIP_ITEM',																	//114
	'', '', '', '', '', '',																	//120
	'MAIL_TYPE_VIP_WEEK_GOLD',																//121
	'MAIL_TYPE_VIP_WEEK_CASH',																//122
	'MAIL_TYPE_VIP_WEEK_POINT',																//123
	'MAIL_TYPE_VIP_WEEK_ITEM',																//124
	'', '', '', '', '', '',																	//130
	'MAIL_TYPE_EVENT_GOLD',																	//131
	'MAIL_TYPE_EVENT_CASH',																	//132
	'MAIL_TYPE_EVENT_POINT',																//133
	'MAIL_TYPE_EVENT_ITEM',																	//134
	'MAIL_TYPE_EVENT_EXP',																	//135
	'', '', '', '', '',																		//140
	'MAIL_TYPE_TUTORIAL_REWARD_EXP',														//141
	'MAIL_TYPE_TUTORIAL_REWARD_GOLD',														//142
	'MAIL_TYPE_TUTORIAL_REWARD_CASH',														//143
	'MAIL_TYPE_TUTORIAL_REWARD_POINT',														//144
	'MAIL_TYPE_TUTORIAL_REWARD_ITEM',														//145
	'MAIL_TYPE_TUTORIAL_BASIC_ITEM',														//146
	'', '', '', '',																			//150
	'MAIL_TYPE_QUEST_REWARD_EXP',															//151
	'MAIL_TYPE_QUEST_REWARD_GOLD',															//152
	'MAIL_TYPE_QUEST_REWARD_CASH',															//153
	'MAIL_TYPE_QUEST_REWARD_POINT',															//154
	'MAIL_TYPE_QUEST_REWARD_ITEM',															//155
	'', '', '', '', '',																		//160
	'MAIL_TYPE_ATTENDANCE_REWARD_EXP',														//161
	'MAIL_TYPE_ATTENDANCE_REWARD_GOLD',														//162
	'MAIL_TYPE_ATTENDANCE_REWARD_CASH',														//163
	'MAIL_TYPE_ATTENDANCE_REWARD_POINT',													//164
	'MAIL_TYPE_ATTENDANCE_REWARD_ITEM',														//165
	'', '', '', '', '',																		//170
	'MAIL_TYPE_LEVELUP_REWARD_EXP',															//171
	'MAIL_TYPE_LEVELUP_REWARD_GOLD',														//172
	'MAIL_TYPE_LEVELUP_REWARD_CASH',														//173
	'MAIL_TYPE_LEVELUP_REWARD_POINT',														//174
	'MAIL_TYPE_LEVELUP_REWARD_ITEM',														//175
	'', '', '', '', '',																		//180
	'MAIL_TYPE_PAYMENT_REWARD_EXP',															//181
	'MAIL_TYPE_PAYMENT_REWARD_GOLD',														//182
	'MAIL_TYPE_PAYMENT_REWARD_CASH',														//183
	'MAIL_TYPE_PAYMENT_REWARD_POINT',														//184
	'MAIL_TYPE_PAYMENT_REWARD_ITEM',														//185
	'', '', '', '', '',																		//190
	'MAIL_TYPE_RECOMMEND_REWARD_EXP',														//191
	'MAIL_TYPE_RECOMMEND_REWARD_GOLD',														//192
	'MAIL_TYPE_RECOMMEND_REWARD_CASH',														//193
	'MAIL_TYPE_RECOMMEND_REWARD_POINT',														//194
	'MAIL_TYPE_RECOMMEND_REWARD_ITEM',														//195
	'', '', '', '', '',																		//200
	'MAIL_TYPE_BUDDY_REWARD_EXP',															//201
	'MAIL_TYPE_BUDDY_REWARD_GOLD',															//202
	'MAIL_TYPE_BUDDY_REWARD_CASH',															//203
	'MAIL_TYPE_BUDDY_REWARD_POINT',															//204
	'MAIL_TYPE_BUDDY_REWARD_ITEM',															//205
	'', '', '', '', '',																		//210
	'MAIL_TYPE_COUPON_REWARD_EXP',															//211
	'MAIL_TYPE_COUPON_REWARD_GOLD',															//212
	'MAIL_TYPE_COUPON_REWARD_CASH',															//213
	'MAIL_TYPE_COUPON_REWARD_POINT',														//214
	'MAIL_TYPE_COUPON_REWARD_ITEM',															//215
	'', '', '', '', '',																		//220
	'MAIL_TYPE_STORE_LEVEL_CASH_EXP',														//221
	'MAIL_TYPE_STORE_LEVEL_CASH_GOLD',														//222
	'MAIL_TYPE_STORE_LEVEL_CASH_CASH',														//223
	'MAIL_TYPE_STORE_LEVEL_CASH_POINT',														//224
	'MAIL_TYPE_STORE_LEVEL_CASH_ITEM',														//225
	'', '', '', '', '',																		//230
	'MAIL_TYPE_STORE_LEVEL_ITEM_EXP',														//231
	'MAIL_TYPE_STORE_LEVEL_ITEM_GOLD',														//232
	'MAIL_TYPE_STORE_LEVEL_ITEM_CASH',														//233
	'MAIL_TYPE_STORE_LEVEL_ITEM_POINT',														//234
	'MAIL_TYPE_STORE_LEVEL_ITEM_ITEM',														//235
	'', '', '', '', '',																		//240
	'MAIL_TYPE_LOGIN_CONTI_EXP',															//241
	'MAIL_TYPE_LOGIN_CONTI_GOLD',															//242
	'MAIL_TYPE_LOGIN_CONTI_CASH',															//243
	'MAIL_TYPE_LOGIN_CONTI_POINT',															//244
	'MAIL_TYPE_LOGIN_CONTI_ITEM',															//245
	'', '', '', '', '',																		//250
	'MAIL_TYPE_LOGIN_ACCESS_EXP',															//251
	'MAIL_TYPE_LOGIN_ACCESS_GOLD',															//252
	'MAIL_TYPE_LOGIN_ACCESS_CASH',															//253
	'MAIL_TYPE_LOGIN_ACCESS_POINT',															//254
	'MAIL_TYPE_LOGIN_ACCESS_ITEM',															//255
	'', '', '', '',																			//259
	'MAIL_TYPE_GUILD_ATTEND_REWARD_ITEM',													//260
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//280
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//300
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//320
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//340
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//360
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//380
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//400
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//420
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//440
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//460
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//480
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//500
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//520
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//540
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//560
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//580
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//600
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//620
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//640
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//660
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//680
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//700
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//720
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//740
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//760
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//780
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//800
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//820
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//840
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//860
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//880
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//900
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//920
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//940
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//960
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//980
	'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',			//1000
	'',
	'MAIL_TYPE_SVR_CASH'																	//1002
);

const ITEMINDEX = array(
	'exp' => 8000001,
	'gold' => 8100001,
	'cash' => 9300001,
	'point' => 9999999
);

const CQ_KNOCKING = 50;
const SA_KNOCKING = 51;
const CQ_LOGIN = 110;
const SA_LOGIN = 110;
const CQ_LOGIN_ADMIN = 999000;
const SA_LOGIN_ADMIN = 999000;
const CQ_LOGOUT = 111;
const SA_LOGOUT = 111;
const MSG_SERVER_SINGLECAST = 10017;
const MSG_SERVER_KICK_USER = 10031;
const MSG_SET_CONTENTS_STATUS = 10037;

const ARRSOCKETSTRUCT = array(
		50 => array(
						'send_struct' => 'I6f',
						'send_size' => 28,
						'option' => 0,
						'reserved' => 1,
						'default_params' => array( 0, 0, 0 ),
						'response_struct' => array(
									array( 'type' => 'uint', 'name' => 'msg_id', 'subtype' => array() ),
									array( 'type' => 'uint', 'name' => 'length', 'subtype' => array() ),
									array( 'type' => 'uint', 'name' => 'option', 'subtype' => array() ),
									array( 'type' => 'uint', 'name' => 'reserved', 'subtype' => array() ),
									array( 'type' => 'uint', 'name' => 'user_id', 'subtype' => array() ),
									array( 'type' => 'uint', 'name' => 'temp_id', 'subtype' => array() ),
									array( 'type' => 'float', 'name' => 'version' )
						),
						'response_size' => 28,
						'response_msg_id' => 51
		),
		999000 => array(
						'send_struct' => 'I6a46a46',
						'send_size' => 116,
						'option' => 0,
						'reserved' => 1,
						'default_params' => array( 0, 0 ),
						'response_struct' => array(
									array( 'type' => 'uint', 'name' => 'msg_id', 'subtype' => array() ),
									array( 'type' => 'uint', 'name' => 'length', 'subtype' => array() ),
									array( 'type' => 'uint', 'name' => 'option', 'subtype' => array() ),
									array( 'type' => 'uint', 'name' => 'reserved' )
						),
						'response_size' => 16,
						'response_msg_id' => 999000
		),
		10031 => array(
						'send_struct' => 'I5',
						'send_size' => 20,
						'option' => 0,
						'reserved' => 1,
						'default_params' => array( 0 ),
						'send_with' => 10017
		),
		10017 => array(
						'send_struct' => 'I6a4000',
						'send_size' => 24,
						'option' => 0,
						'reserved' => 1,
						'response_struct' => array(
									array( 'type' => 'uint', 'name' => 'msg_id', 'subtype' => array() ),
									array( 'type' => 'uint', 'name' => 'length', 'subtype' => array() ),
									array( 'type' => 'uint', 'name' => 'option', 'subtype' => array() ),
									array( 'type' => 'uint', 'name' => 'reserved' )
						),
						'response_size' => 16,
						'response_msg_id' => 10017
		),
		10037 => array(
						'send_struct' => 'I4Q',
						'send_size' => 24,
						'option' => 1,
						'reserved' => 1,
						'default_params' => array( 0 )
		)
);

const CHANGE_TABLE = array(
			'level' => array( 'tb_player' ),
			'player_name' => array( 'tb_player', 'tb_buddy_ask', 'tb_guild_log', 'tb_guild_player_ask' ),
			'guildpoint' => array( 'tb_guild_player' ),
			'email' => array( 'tb_user' ),
			'gold' => array( 'tb_player' ),
			'exp' => array( 'tb_player' ),
			'gem' => array( 'tb_player' ),
			'free_gem' => array( 'tb_player' ),
			'vipgrade' => array( 'tb_player' )
);

const ASSET_TYPE = array(
	'',							// none
	'gold',
	'cash',
	'point',
	'free_cash',
	'gemstone',
	'crystal',
	'soulstone',
	'marble',
	'',							// enchant_stone
	'',							// magic_stone
	'',							// dungeon_ticket
	'',							// raid_dungeon_ticket
	'',							// guild_coin
	'',							// guild_point
	'battle_point',
	''							// max_price
);

const PROPERTY_LOGTYPE = array(
		'column' => '_nvalue0',
		'0' => 'EMPTY_STRING',
		'1' => 'INVEN_EXTEND',
		'2' => 'EXCHANGE_SLOT_EXTEND',
		'3' => 'BUDDY_MAX_EXTEND',
		'4' => 'STORAGE_EXTEND',
		'5' => 'RECEIVE_MAIL',
		'6' => 'TRAIN_SKILL',
		'7' => 'UPGRADE_SKILL',
		'8' => 'UPGRADE_SKILL_NOW',
		'9' => 'BUY_ITEM',
		'10' => 'BUY_MERCENARY',
		'11' => 'SELL_ITEM',
		'12' => 'ENCHANT',
		'13' => 'AUTO_POINT_GET',
		'14' => 'REVIVE_CASH',
		'15' => 'TSTORE_CASH_GET',
		'16' => 'TSTORE_CASH_CHARGE',
		'17' => 'TSTORE_FREECASH_CHARGE',
		'18' => 'GOOGLE_CASH_CHARGE',
		'19' => 'GOOGLE_FREECASH_CHARGE',
		'20' => 'NAVER_CASH_CHARGE',
		'21' => 'NAVER_FREECASH_CHARGE',
		'22' => 'APPLE_CASH_CHARGE',
		'23' => 'APPLE_FREECASH_CHARGE',
		'24' => 'ITOOLS_CASH_CHARGE',
		'25' => 'ITOOLS_FREECASH_CHARGE',
		'26' => 'BUY_CHAR_SLOT',
		'27' => 'BUY_CASH_BOX',
		'28' => '360_CASH_CHARGE',
		'29' => '360_CASH_RESULT',
		'30' => 'ACHIEVE',
		'31' => 'EXCHANGE_REGIST',
		'32' => 'EXCHANGE_BUY',
		'33' => 'BOX_OPEN',
		'34' => 'DUNGEON_REWARD',
		'35' => 'DAILY_CASH_REWARD',
		'36' => 'DAILY_VIP_CASH_REWARD',
		'37' => 'GRADEUP_CASH_REWARD',
		'38' => 'LEVELUP_CASH_REWARD',
		'39' => 'LEVELUP_VIP_CASH_REWARD',
		'40' => 'STORAGE_ITEM',
		'41' => 'CHEAT',
		'42' => 'AUTO_BATTLE',
		'43' => 'CREATE_GUILD',
		'44' => 'TRAIN_GUILD_SKILL',
		'45' => 'UPGRADE_GUILD_SKILL',
		'46' => 'UPGRADE_GUILD_SKILL_NOW',
		'47' => 'CUSTOMIZE',
		'48' => 'SELL_MERCENARY',
		'49' => 'EVENT_DUNGEON',
		'50' => 'EMOTION',
		'51' => 'TUTORIAL_REWARD',
		'52' => 'DUNGEON_MISSION',
		'53' => 'QUEST',
		'54' => 'TRAIN_MECHA_SKILL',
		'55' => 'UPGRADE_MECHA_SKILL',
		'56' => 'UPGRADE_MECHA_SKILL_NOW',
		'57' => 'TELEPORT',
		'58' => 'GENOME_HOLE_OPEN',
		'59' => 'GENOME_HOLE_AWAKENING',
		'60' => 'GENOME_MAP_ENCHANT',
		'61' => 'GENOME_TYPE_INIT',
		'62' => 'ITEM_GRIND',
		'63' => 'ITEM_OPTION_REFINE',
		'64' => 'ITEM_OPTION_ENCHANT',
		'65' => 'MECHA_PARTS_REFINE',
		'66' => 'MECHA_PARTS_ENCHANT',
		'67' => 'PET_PARTS_REFINE',
		'68' => 'ITEM_INHERITS',
		'69' => 'MECHA_GROWTH',
		'70' => 'MECHA_ENCHANT',
		'71' => 'PET_GROWTH',
		'72' => 'PET_EVOLUTION',
		'73' => 'PET_TAMING',
		'74' => 'UPGRADE_PET_SKILL',
		'75' => 'USE_ITEM',
		'76' => 'EVENT_REWARD',
		'77' => 'REJOICING_REWARD',
		'78' => 'GUILD_DONATE',
		'79' => 'EXCHANGE_ASSETS_TRADE',
		'80' => 'EXCHANGE_BUY',
		'81' => 'EXCHANGE_PAYOUTS',
		'82' => 'EXCHANGE_CANCEL',
		'83' => 'EXCHANGE_LIST',
		'84' => 'EXCHANGE_LIST_TIMELIMIT',
		'85' => 'ITEM_DISMANTLE',
		'86' => 'GUILD_LEVELUP',
		'87' => 'CREATURE_KILL',
		'88' => 'DAILY_MAP_CLEAR_LIMIT_RESET',
		'89' => 'BUY_SECRET_STORE',
		'90' => 'RESET_SECRET_STORE',
		'91' => 'BUY_GUILD_EMBLEM',
		'92' => 'BUY_GATCHA',
		'93' => 'ENTER_DUNGEON',
		'94' => 'ENTER_RAID',
		'95' => 'PVP_REWARD',
		'96' => 'GUILD_OBJECT_LEVELUP',
		'97' => 'LOGIN_REWARD',
		'98' => 'MECHA_CORE_EXTRACTION',
		'99' => 'FINALITY_UNION',
		'99' => 'DIRECT_BUY_ITEM',
		'99' => 'QUEST_COLLECTION',
		'99' => 'GUIDE_REWARD'
);

const ITEMGAIN_LOGTYPE = array(
		'column' => '_nvalue0',
		'0' => 'EMPTY_STRING',
		'1' => 'MAIL',
		'2' => 'ACHIEVE',
		'3' => 'TRACK_REWARD',
		'4' => 'TRACK_CASH_REWARD',
		'5' => 'GBOX',
		'6' => 'ABOX',
		'7' => 'GABOX',
		'8' => 'RCASHBOX',
		'9' => 'EVENT_REWARD',
);

const ITEMUSE_LOGTYPE = array(
		'column' => '_nvalue0',
		'0' => 'EMPTY_STRING',
		'1' => 'POTION',
		'2' => 'ENCHANT_STONE',
		'3' => 'MAGIC_STONE',
		'4' => 'TICKET_DUNGEON',
		'5' => 'TICKET_RAID',
		'6' => 'MAGIC_EQUIP'
);

const ITEMREMOVE_LOGTYPE = array(
		'column' => '_nvalue0',
		'0' => 'EMPTY_STRING',
		'1' => 'ENCHANT'
);

const EXCHANGE_LOGTYPE = array(
		'column' => '_nvalue0',
		'0' => 'EMPTY_STRING',
		'1' => 'REGIST',
		'2' => 'ASSET_REGIST',
		'3' => 'BUY',
		'4' => 'CANCEL',
		'5' => 'EXPIRE',
		'6' => 'EXTEND'
);

const STORAGE_LOGTYPE = array(
		'column' => '_user_id_1',
		'0' => 'EMPTY_STRING',
		'1' => 'ITEM_PUSH',
		'2' => 'ITEM_POP'
);

const ADDEXP_LOGTYPE = array(
		'column' => '_nvalue0',
		'0' => 'EMPTY_STRING',
		'1' => 'ACHIEVE',
		'2' => 'ZONE_CLEAR',
		'3' => 'MAIL',
		'4' => 'DUNGEON_MISSION',
		'5' => 'QUEST',
		'6' => 'FIELD',
		'7' => 'REJOICE',
		'8' => 'MEDITATION',
		'9' => 'COLLECTION_QUEST'
);

const SKILL_LOGTYPE = array(
		'column' => '_nvalue0',
		'0' => 'EMPTY_STRING',
		'1' => 'TRAIN',
		'2' => 'ENCHANT'
);

const MECHA_LOGTYPE = array(
		'column' => '_nvalue0',
		'0' => 'EMPTY_STRING',
		'1' => 'CREATE',
		'2' => 'GROWTH',
		'3' => 'UPGRADE'
);

const PET_LOGTYPE = array(
		'column' => '_nvalue0',
		'0' => 'EMPTY_STRING',
		'1' => 'CREATE',
		'2' => 'GROWTH',
		'3' => 'EVOLUTION'
);

const GRADE_LOGTYPE = array(
		'column' => '_nvalue0',
		'0' => 'EMPTY_STRING',
		'1' => 'VIP_UP'
);

const TRACK_LOGTYPE = array(
		'column' => '_nvalue0',
		'0' => 'EMPTY_STRING',
		'1' => 'CREATE',
		'2' => 'ENTER',
		'3' => 'CLEAR',
		'4' => 'REVIVE',
		'5' => 'MISSION_COMPLETE',
		'6' => 'FAIL'
);

const GENOME_LOGTYPE = array(
		'column' => '_nvalue0',
		'0' => 'HOLE_OPEN',
		'1' => 'HOLE_AWAKE',
		'2' => 'MAP_ENCHANT',
		'3' => 'MAP_OPEN'
);

const OPSMELT_LOGTYPE = array(
		'column' => '_user_id_1',
		'0' => 'EMPTY_STRING',
		'1' => 'CREATE',
		'2' => 'SAVE'
);

const OPENCHANT_LOGTYPE = array(
		'column' => '_user_id_1',
		'0' => 'EMPTY_STRING',
		'1' => 'CREATE',
		'2' => 'SAVE'
);

const MECHAPARTSREMODEL_LOGTYPE = array(
		'column' => '_user_id_1',
		'0' => 'EMPTY_STRING',
		'1' => 'CREATE',
		'2' => 'SAVE'
);

const MECHAPARTSENCHANT_LOGTYPE = array(
		'column' => '_user_id_1',
		'0' => 'EMPTY_STRING',
		'1' => 'CREATE',
		'2' => 'SAVE'
);

const SECRETSTORE_LOGTYPE = array(
		'column' => '_nvalue0',
		'0' => 'BUY',
		'1' => 'RESET'
);

const MECHACORE_LOGTYPE = array(
		'column' => '_nvalue0',
		'0' => 'EXTRACTION'
);

const BUDDY_LOGTYPE = array(
		'column' => '_nvalue0',
		'1' => '친구 요청',
		'2' => '친구 수락',
		'3' => '친구 거부',
		'4' => '친구 요청 취소',
		'5' => '친구 삭제'
);

const LOG_TYPE = array(
	'0' => array( 'type' => '' ),
	'1' => array( 'type' => 'LogOn' ),
	'2' => array( 'type' => 'Reconnection' ),
	'3' => array( 'type' => 'ShiftedOff' ),
	'4' => array( 'type' => 'LogOff' ),
	'5' => array( 'type' => 'NetworkOff' ),
	'6' => array( 'type' => 'ForcedOff' ),
	'7' => array( 'type' => 'FrontOff' ),
	'8' => array( 'type' => 'TimeoutOff' ),
	'9' => array( 'type' => 'OnChannel' ),
	'10' => array( 'type' => 'LEVELUP' ),
	'11' => array( 'type' => 'DEAD' ),
	'12' => array( 'type' => 'ITEM_BUY' ),
	'13' => array( 'type' => 'ITEM_SELL' ),
	'14' => array( 'type' => 'ZONE_START' ),
	'15' => array( 'type' => 'ZONE_CLEAR' ),
	'16' => array( 'type' => 'ZONE_ENTER' ),
	'17' => array( 'type' => 'ZONE_FAIL' ),
	'18' => array( 'type' => 'ZONE_CLOSE' ),
	'19' => array( 'type' => 'BUY_PL_SLOT' ),
	'20' => array( 'type' => 'ADD_GEM', 'subtype' => PROPERTY_LOGTYPE ),
	'21' => array( 'type' => 'ADD_FREE_GEM', 'subtype' => PROPERTY_LOGTYPE ),
	'22' => array( 'type' => 'ADD_GOLD', 'subtype' => PROPERTY_LOGTYPE ),
	'23' => array( 'type' => 'ADD_POINT', 'subtype' => PROPERTY_LOGTYPE ),
	'24' => array( 'type' => 'ADD_GEMSTONE', 'subtype' => PROPERTY_LOGTYPE ),
	'25' => array( 'type' => 'ADD_CRYSTAL', 'subtype' => PROPERTY_LOGTYPE ),
	'26' => array( 'type' => 'ADD_SOULSTONE', 'subtype' => PROPERTY_LOGTYPE ),
	'27' => array( 'type' => 'ADD_MARBLE', 'subtype' => PROPERTY_LOGTYPE ),
	'28' => array( 'type' => 'PARTY_CREATE' ),
	'29' => array( 'type' => 'PARTY_JOIN' ),
	'30' => array( 'type' => 'BUDDY', 'subtype' => BUDDY_LOGTYPE ),
	'31' => array( 'type' => 'LOG_NULL' ),
	'32' => array( 'type' => 'SKILL', 'subtype' => SKILL_LOGTYPE ),
	'33' => array( 'type' => 'ACHIEVE_REWARD' ),
	'34' => array( 'type' => 'CREATE_ACCOUNT' ),
	'35' => array( 'type' => 'USE_CASH' ),
	'36' => array( 'type' => 'TSTORE_CASH' ),
	'37' => array( 'type' => 'REMOVE_PLAYER' ),
	'38' => array( 'type' => 'REWARD_CHEAT' ),
	'39' => array( 'type' => 'GOOGLE_CASH' ),
	'40' => array( 'type' => 'NAVER_CASH' ),
	'41' => array( 'type' => 'BUY_STORAGE_SLOT' ),
	'42' => array( 'type' => 'LOST_DB_INSERT_ITEM' ),
	'43' => array( 'type' => 'TRACK', 'subtype' => TRACK_LOGTYPE ),
	'44' => array( 'type' => 'INVEN_EXTEND' ),
	'45' => array( 'type' => 'APPLE_CASH' ),
	'46' => array( 'type' => 'ITOOLS_CASH' ),
	'47' => array( 'type' => 'ITEM_GAIN', 'subtype' => ITEMGAIN_LOGTYPE ),
	'48' => array( 'type' => 'ITEM_REMOVE', 'subtype' => ITEMREMOVE_LOGTYPE ),
	'49' => array( 'type' => 'ITEM_USE', 'subtype' => ITEMUSE_LOGTYPE ),
	'50' => array( 'type' => 'ADD_EXP', 'subtype' => ADDEXP_LOGTYPE ),
	'51' => array( 'type' => 'CREATE_PLAYER' ),
	'52' => array( 'type' => 'EXCHANGE', 'subtype' => EXCHANGE_LOGTYPE ),
	'53' => array( 'type' => 'STORAGE', 'subtype' => STORAGE_LOGTYPE ),
	'54' => array( 'type' => 'RECEIVE_MAIL' ),
	'55' => array( 'type' => 'GRADE', 'subtype' => GRADE_LOGTYPE ),
	'56' => array( 'type' => 'CUSTOMIZE' ),
	'57' => array( 'type' => 'MECHA', 'subtype' => MECHA_LOGTYPE ),
	'58' => array( 'type' => 'PET', 'subtype' => PET_LOGTYPE ),
	'59' => array( 'type' => 'GENOME', 'subtype' => GENOME_LOGTYPE ),
	'60' => array( 'type' => 'ITEM_GRIND' ),
	'61' => array( 'type' => 'ITEM_OP_SMELT', 'subtype' => OPSMELT_LOGTYPE ),
	'62' => array( 'type' => 'ITEM_OP_ENCHANT', 'subtype' => OPENCHANT_LOGTYPE ),
	'63' => array( 'type' => 'MECHA_PARTS_REMODEL', 'subtype' => MECHAPARTSREMODEL_LOGTYPE ),
	'64' => array( 'type' => 'MECHA_PARTS_ENCHANT', 'subtype' => MECHAPARTSENCHANT_LOGTYPE ),
	'65' => array( 'type' => 'PET_PARTS_GRIND' ),
	'66' => array( 'type' => 'MECHA_SKILL', 'subtype' => SKILL_LOGTYPE ),
	'67' => array( 'type' => 'PET_SKILL', 'subtype' => SKILL_LOGTYPE ),
	'68' => array( 'type' => 'SINGLE_ZONE_ENTER' ),
	'69' => array( 'type' => 'ITEM_DISMANTLE' ),
	'70' => array( 'type' => 'MEDITATION' ),
	'71' => array( 'type' => 'ADD_BATTLE_POINT' ),
	'72' => array( 'type' => 'SECRET_STORE', 'subtype' => SECRETSTORE_LOGTYPE ),
	'73' => array( 'type' => 'GATCHA' ),
	'74' => array( 'type' => 'QUEST_COMPLETE' ),
	'75' => array( 'type' => 'ACHIEVE_COMPLETE' ),
	'76' => array( 'type' => 'MECHA_CORE', 'subtype' => MECHACORE_LOGTYPE ),
	'77' => array( 'type' => 'FINALITY_UNION' ),
	'78' => array( 'type' => 'DIRECT_BUY_ITEM' ),
	'79' => array( 'type' => 'QUEST_COLLECTION' )
);

const CONTENT_TYPE = array(
	array( 'type' => 'CONTENTS_NONE', 'text_kr' => '', 'text_en' => '' ),
	array( 'type' => 'CONTENTS_GACHA', 'text_kr' => '가차', 'text_en' => 'Gacha' ),
	array( 'type' => 'CONTENTS_CONTINUE_LOGIN', 'text_kr' => '연속로그인', 'text_en' => 'Continue Login' ),
	array( 'type' => 'CONTENTS_CONTINUE_CONNECTION', 'text_kr' => '접속유지', 'text_en' => 'Continue Connection' ),
	array( 'type' => 'CONTENTS_MISSION_ROULETTE', 'text_kr' => '미션룰렛', 'text_en' => 'Mission Roulette' ),
	array( 'type' => 'CONTENTS_COUPON', 'text_kr' => '쿠폰', 'text_en' => 'Coupon' )
);

const REDISMAP = array(
	array( 'file' => array( 'Item.xml', 'ItemConsumables.xml' ), 'table' => 'MASTER_ITEM', 'key' => 'INDEX' ),
	array( 'file' => array( 'Vip.xml' ), 'table' => 'MASTER_VIP', 'key' => 'Vip_Lvl' ),
	array( 'file' => array( 'Character_Exp.xml' ), 'table' => 'MASTER_EXP', 'key' => 'LV' )
);