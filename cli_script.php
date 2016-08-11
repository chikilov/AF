<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	define( 'BASEPATH', '/var/www/html/system/' );
	include_once('/var/www/html/application/config/config.php');
	include_once('/var/www/html/application/config/database.php');
	include_once('/var/www/html/application/config/constants.php');
	/*
		// MySQL 데이터베이스 연결
		$mysqli = new mysqli($host, $user, $password, $dbname);

		// 연결 오류 발생 시 스크립트 종료
		if ($mysqli->connect_errno) {
		    die('Connect Error: '.$mysqli->connect_error);
		}

		// 쿼리문 전송
		if ($result = $mysqli->query('SELECT * FROM `temp`)) {
		    // 레코드 출력
		    while ($row = $result->fetch_object()) {
		        echo $row->name.' / '.$row->desc.'<br />';
		    }

		    // 메모리 정리
		    $result->free();
		}

		// 접속 종료
		$mysqli->close();
	*/
	$conn = array();
	$conn['base'] = new mysqli( $db['master_base']['hostname'], $db['master_base']['username'], $db['master_base']['password'], $db['master_base']['database'] );
	if ( $conn['base']->connect_errno )
	{
		exit( date('Y-m-d H:i:s').' : group_id('.$argv[1].') : base_conn, Debugging error: '.$conn['base']->connect_error.PHP_EOL );
	}
	$query = "select a._item_id, a._item_count, a._exp, a._gold, a._cash, a._point, a._free_cash, a._gemstone, a._crystal, a._soulstone, a._marble, a._battle_point, ";
	$query .= "a._title, a._contents, a._expiretime, a._url, b._server_id, b._player_id, c._user_id ";
	$query .= "from ".$config['db_prefix']."base.tb_admin_present as a inner join ".$config['db_prefix']."base.tb_present_load_group as b on a._group_id = b._group_id ";
	$query .= "inner join ".$config['db_prefix']."game.tb_player as c on b._player_id = c._player_id ";
	$query .= "where a._group_id = '".$argv[1]."' and a._is_valid = 1 ";

	if ( $result = $conn['base']->query($query) ) {
		$result_array = array();
	    while ( $row = $result->fetch_assoc() )
	    {
		    $result_array[] = $row;
	    }

	    $result->free();
	}

	$arrServer = array_unique( array_column( $result_array, '_server_id' ) );
	foreach ( $arrServer as $row )
	{
		$conn['game_'.$row[0]] = new mysqli($db['master_game_'.( $row[0] - 1 )]['hostname'], $db['master_game_'.( $row[0] - 1 )]['username'], $db['master_game_'.( $row[0] - 1 )]['password'], $db['master_game_'.( $row[0] - 1 )]['database']);
		if ( $conn['game_'.$row[0]]->connect_errno )
		{
			exit( date('Y-m-d H:i:s').' : group_id('.$argv[1].') : game'.$row[0].'_conn, Debugging error: '.$conn['game_'.$row[0]]->connect_error.PHP_EOL );
		}
	}

	foreach ( $result_array as $key => $val )
	{
		$contents = '{ "from" : "system", "to" : "me", "text" : "'.$val['_title'].'", "items" : [ { "id" : 0, "index" : '.$val['_item_id'].', "add_info" : 0, ';
		$contents .= '"count" : '.$val['_item_count'].', "limit" : 0, "acquired" : 0 } ], "type" : '.array_keys(MAILTYPE, 'MAIL_TYPE_EVENT_ITEM')[0].', ';
		$contents .= '"exp" : '.$val['_exp'].', "gold" : '.$val['_gold'].', "cash" : '.$val['_cash'].', "point" : '.$val['_point'].', "free_cash" : '.$val['_free_cash'].', ';
		$contents .= '"gemstone" : '.$val['_gemstone'].', "crystal" : '.$val['_crystal'].', "soulstone" : '.$val['_soulstone'].', "marble" : '.$val['_marble'].', ';
		$contents .= '"battle_point" : '.$val['_battle_point'].', "value" : 0 }';

		$query = "insert into ".$config['db_prefix']."game.tb_mail ( _user_id, _player_id, _box_type, _check, _taken, _content, _itime, _etime, _group_id ) values ";
		$query .= "( '".$val['_user_id']."', '".$val['_player_id']."', '0', 'N', 'N', '".$contents."', ";
		$query .= "now(), ".( $val['_expiretime'] == null ? "null" : "'".$val['_expiretime']."'").", '".$argv[1]."' ) ";

		if ( $conn['game_'.$val['_server_id']]->query($query) === false )
		{
			echo 'err_step1 : _group_id => '.$argv[1].' : _server_id => '.$val['_server_id'].' : _user_id => '.$val['_user_id'].' : _player_id => '.$val['_player_id'].PHP_EOL;
			echo $conn['game_'.$val['_server_id']]->error.PHP_EOL;
		}
		else
		{
			$query = "update ".$config['db_prefix']."base.tb_present_load_group set _is_send = 1 ";
			$query .= "where _group_id = '".$argv[1]."' and _player_id = '".$val['_player_id']."' and _server_id = '".$val['_server_id']."' ";
			if ( $conn['game_'.$val['_server_id']]->query($query) )
			{
				echo 'success : _group_id => '.$argv[1].' : _server_id => '.$val['_server_id'].' : _user_id => '.$val['_user_id'].' : _player_id => '.$val['_player_id'].PHP_EOL;
			}
			else
			{
				echo 'err_step2 : _group_id => '.$argv[1].' : _server_id => '.$val['_server_id'].' : _user_id => '.$val['_user_id'].' : _player_id => '.$val['_player_id'].PHP_EOL;
				echo $conn['game_'.$val['_server_id']]->error.PHP_EOL;
			}
		}
	}

	foreach ( $conn as $key => $val )
	{
		$conn[$key]->close();
		unset($conn[$key]);
	}
?>