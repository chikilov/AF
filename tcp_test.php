<?php
	error_reporting(E_ALL);

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
const MASTER_SERVER_ADMIN_ID = 'gm';
const MASTER_SERVER_ADMIN_PASSWORD = '1234';
	function makeMsg( $method, $size, $user_id = null, $subMsg = null )
	{
		if ( $method == CQ_KNOCKING )
		{
			$strMsg = pack( "I6f", $method, $size, 0, 1, 0, 0, 0 );
		}
		else if ( $method == CQ_LOGIN_ADMIN )
		{
			$strMsg = pack( "I6a46a46", $method, $size, 0, 1, 0, 0, md5(MASTER_SERVER_ADMIN_PASSWORD), MASTER_SERVER_ADMIN_ID );
		}
		else if ( $method == MSG_SERVER_KICK_USER )
		{
			$strMsg = pack( "I5", $method, 4000, 0, 1, 0 );
		}
		else if ( $method == MSG_SERVER_SINGLECAST )
		{
			$strMsg = pack( "I6a4000", $method, 4024, 0, 1, $user_id, 20, $subMsg );
		}
		return $strMsg;
	}

	//The Client
	$address = "192.168.0.27";													// 접속할 IP //
	$port = "20000";															// 접속할 PORT //

	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);						// TCP 통신용 소켓 생성 //
	if ( $socket === false )
	{
	    echo "socket_create() 실패! 이유: " . socket_strerror(socket_last_error()) . "\n";
		echo "<br>";
	}
	else
	{
	     echo "socket 성공적으로 생성.\n";
	     echo "<br>";
	}

	echo "다음 IP '$address' 와 Port '$port' 으로 접속중...";
	echo "<BR>";
	$result = socket_connect($socket, $address, $port);           // 소켓 연결 및 $result에 접속값 지정 //
	if ( $result === false )
	{
	    echo "socket_connect() 실패.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
		echo "<br>";
	}
	else
	{
	    echo "다음 주소로 연결 성공 : $address.\n";
		echo "<br>";
	}

	$strSend = makeMsg( CQ_KNOCKING, 28 );
	echo "서버로 보내는 전문 : ";
	var_dump($strSend);
	echo "|종료|<br>";

	socket_write($socket, $strSend, 28); // 실제로 소켓으로 보내는 명령어 //
	echo "send complete<br>";
	$strResponse = socket_read($socket, 28);
	$strResponse = unpack("Imsg_id/Ilength/Ioption/Ireserved/Iuser_id/Itemp_id/fversion", $strResponse);
	var_dump($strResponse);
	echo "<br />";
	if ( $strResponse['msg_id'] == SA_KNOCKING )
	{
		echo "knocking complete<br />";
	}
	else
	{
		echo "knocking fail<br />";
	}

	$strSend = makeMsg( CQ_LOGIN_ADMIN, 116 );

	socket_write($socket, $strSend, 116); // 실제로 소켓으로 보내는 명령어 //
	echo "send complete<br>";

	$strResponse = socket_read($socket, 20);
	$strResponse = unpack("Imsg_id/Ilength/Ioption/Ireserved", $strResponse);
	var_dump($strResponse);
	if ( $strResponse['msg_id'] == SA_LOGIN_ADMIN )
	{
		echo "login_admin complete<br />";
	}
	else
	{
		echo "login_admin fail<br />";
	}

	$strSend = makeMsg( "kick", 4024 );

	socket_write($socket, $strSend, 4024); // 실제로 소켓으로 보내는 명령어 //
	echo "send complete<br>";

	socket_close($socket);
?>