<?php
class MY_Controller extends CI_Controller
{
	public $socket;
	public $redis;

	function __construct()
	{
		parent::__construct();
		if ( ENVIRONMENT == 'production' )
		{
			error_reporting(E_ALL);
			ini_set('display_errors', TRUE);
			ini_set('display_startup_errors', TRUE);
		}
		else if ( ENVIRONMENT == 'development' || ENVIRONMENT == 'staging' )
		{
			error_reporting(E_ALL);
			ini_set('display_errors', TRUE);
			ini_set('display_startup_errors', TRUE);
		}

		$this->load->library('session');
		// 언어 로딩 설정
		if ( $this->session->has_userdata('language') )
		{
			if ( $this->session->userdata('language') == '' || $this->session->userdata('language') == null )
			{
				$this->session->set_userdata( array( 'language' => $this->config->item('language') ) );
//				$this->lang->load('Common_lang', $this->config->item('language') );
			}
//			else
//			{
//				$this->lang->load('Common_lang', $this->session->userdata('language') );
//			}
			$this->lang->load('Common_lang', $this->session->userdata('language') );
		}
		else
		{
			$this->lang->load('Common_lang', $this->config->item('language') );
		}

		if ( $this->router->fetch_class() != 'Login' )
		{
			if ( $this->session->has_userdata('admin_id') && $this->session->has_userdata('admin_auth') )
			{
				if ( $this->session->userdata('admin_id') == '' || $this->session->userdata('admin_id') == null )
				{
					if ( array_key_exists( 'HTTP_X_REQUESTED_WITH', $this->input->server() ) )
					{
						header("HTTP/1.0 901 Session Timeout");
						$this->output->_display();
						exit;
					}
					else
					{
						$this->session->set_userdata( array( 'admin_auth' => 0 ) );
						$this->load->view('alertlocationview', array(
							'alertprefix' => 'Oops...',
							'alertstring' => $this->lang->line('need_to_login'),
							'alerttype' => 'error',
							'afterlocation' => '/Login',
						));
						$this->output->_display();
						exit;
					}
				}
			}
			else
			{
				if ( $this->input->server('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest' )
				{
					header("HTTP/1.0 901 Session Timeout");
					$this->output->_display();
					exit;
				}
				else
				{
					$this->session->set_userdata( array( 'admin_auth' => 0 ) );
					$this->load->view('alertlocationview', array(
						'alertprefix' => 'Oops...',
						'alertstring' => $this->lang->line('need_to_login'),
						'alerttype' => 'error',
						'afterlocation' => '/Login',
					));
					$this->output->_display();
					exit;
				}
			}
		}

		$this->makeRedisConn();
	}

	// 소켓에 전달할 메세지를 생성하는 함수
	// $method => 메소드아이디( const ARRSOCKETSTRUCT 의 키값 )
	// $option => 메소드 타입( 일반패킷 = 0, CMg = 1 )
	// $params => 전달하려는 인자
	// $arrMsg => 감싸서 던지는 경우 전달되는 내부 메세지 ( send_with 키값이 있는 경우 메세지를 다른 메세지로 감싸서 전달 )
	//		ex) MSG_SERVER_SINGLECAST => 10017 (
	//				...header,
	//				...body(
	//							_user_id = 1,
	//							_msg_size = XXX,
	//							_msg = {
	//										MSG_SERVER_KICK_USER => 10031 (
	//											...header,
	//											...body
	//										)
	//							}
	//			)
	function makeMsg( $method, $params = array(), $arrMsg = array() )
	{
		$strMsg = pack(
				ARRSOCKETSTRUCT[$method]['send_struct'],
				...array_merge(
						array( $method, ( empty( $arrMsg ) ? ARRSOCKETSTRUCT[$method]['send_size'] : intval( $arrMsg['size'] ) + intval( ARRSOCKETSTRUCT[$method]['send_size'] ) ),
						ARRSOCKETSTRUCT[$method]['option'], ARRSOCKETSTRUCT[$method]['reserved'] ),
						( empty($params) ? ARRSOCKETSTRUCT[$method]['default_params'] : ( array_key_exists( 'default_params', ARRSOCKETSTRUCT[$method] ) ? array_merge( ARRSOCKETSTRUCT[$method]['default_params'], $params ) : $params ) ),
						( empty($arrMsg) ? array() : array( intval( $arrMsg['size'] ), $arrMsg['msg'] ) )
				)
		);

		$arrMsg['size'] = ( empty( $arrMsg ) ? ARRSOCKETSTRUCT[$method]['send_size'] : intval( $arrMsg['size'] ) + intval( ARRSOCKETSTRUCT[$method]['send_size'] ) );
		$arrMsg['msg'] = $strMsg;

		return $arrMsg;
	}

	function makeSocketConn( $ServerId )
	{
		$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ( $this->socket === false )
		{
//		    echo "socket_create() 실패! 이유: " . socket_strerror(socket_last_error()) . "\n";
		    return false;
		}

		if ( socket_connect( $this->socket, $this->config->item('MASTER')[$ServerId]['ip'], $this->config->item('MASTER')[$ServerId]['port'] ) === false )
		{
//		    echo "socket_connect() 실패.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
		    return false;
		}
		return true;
	}

	function sendSocketMsg( $method, $param = array() )
	{
		if ( array_key_exists( 'response_struct', ARRSOCKETSTRUCT[$method] ) )
		{
			$arrResponseStruct = ARRSOCKETSTRUCT[$method]['response_struct'];
		}
		else
		{
			$arrResponseStruct = array();
		}

		if ( array_key_exists( 'response_size', ARRSOCKETSTRUCT[$method] ) )
		{
			$intResponseSize = ARRSOCKETSTRUCT[$method]['response_size'];
		}
		else
		{
			$intResponseSize = 0;
		}

		if ( array_key_exists( 'send_with', ARRSOCKETSTRUCT[$method] ) )
		{
			$arrMsg = $this->makeMsg( $method );
			$arrMsg = $this->makeMsg( ARRSOCKETSTRUCT[$method]['send_with'], $param, $arrMsg );
		}
		else
		{
			$arrMsg = $this->makeMsg( $method, $param );
		}

		if ( !socket_write($this->socket, $arrMsg['msg'], $arrMsg['size']) )
		{
			return false;
		}

		if ( $intResponseSize > 0 && !empty( $arrResponseStruct ) )
		{
			$strResponseStruct = '';
			foreach ( $arrResponseStruct as $key => $row )
			{
				if ( $strResponseStruct != '' ) $strResponseStruct .= '/';
				switch ( $row['type'] )
				{
					case 'int':
						$strResponseStruct .= 'i';
						break;
					case 'uint':
						$strResponseStruct .= 'I';
						break;
					case 'float':
						$strResponseStruct .= 'f';
						break;
					case 'ufloat':
						$strResponseStruct .= 'F';
						break;
					case 'string':
						$strResponseStruct .= 'a';
						break;
					default:
						return false;
				}
				$strResponseStruct .= $row['name'];
			}
			$strResponse = socket_read($this->socket, $intResponseSize);
			$arrResponse = unpack( $strResponseStruct, $strResponse );

			return $arrResponse;
		}
		else
		{
			return true;
		}
	}

	function index()
	{
		$this->load->view('error/403_Forbidden');
	}

	function checkauth()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrAuth = $this->dbBase->loadauth( explode( '/', $this->uri->uri_string() ) )->result_array();

		if ( empty( $arrAuth ) )
		{
			$this->load->view('alertlocationview', array(
				'alertprefix' => 'Oops...',
				'alertstring' => $this->lang->line('need_authorization'),
				'alerttype' => 'error',
				'afterlocation' => 'history.back()',
			));
			$this->output->_display();
			exit;
		}
		else
		{
			$arrAuth = $arrAuth[0];
			if ( intval( $arrAuth['_auth_view'] ) < 1 )
			{
				$this->load->view('alertlocationview', array(
					'alertprefix' => 'Oops...',
					'alertstring' => $this->lang->line('need_authorization'),
					'alerttype' => 'error',
					'afterlocation' => 'history.back()',
				));
				$this->output->_display();
				exit;
			}
		}

		return $arrAuth;
	}

	function LoadXmlToArray( $filename )
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
		$arrXml = $this->dbBase->xmlinfo()->result_array();
		$result = array();
		foreach ( $filename as $row )
		{
			$url = $arrXml[0]['_location'].$row;
			$xml = file_get_contents($url, false, $context);

			$xml_handle = new DOMDocument();
			$xml_handle->loadXML($xml, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);

			$this->load->library('XML2Array');
			$array = XML2Array::createArray($xml_handle);
			$result = array_merge( $result, $array['Classes']['Class'] );
		}

		return $result;
	}

	function makeRedisConn()
	{
		$this->redis = new Redis();
		$this->redis->connect('127.0.0.1', 6379);
		$this->redis->select(0);
	}

	function MresultFromRedis( $redis, $table_name )
	{
		if  ( $redis == null )
		{
			return null;
		}

		$array_redis = $redis->hgetall($table_name);
		if ( $array_redis == null || is_array($array_redis) == false )
		{
			return null;
		}

		$array_key = array_keys($array_redis);
		$spec_array = null;
		for ($i=0;$i<count($array_redis);++$i)
		{
			$spec_array[] = json_decode( $array_redis[$array_key[$i]], true );
		}

		return $spec_array;
	}

	function SresultFromRedis( $redis, $table_name, $key )
	{
		if ( $redis == null )
		{
			return null;
		}
		else
        {
            if ( is_array( $key ) === false )
            {
                $key = array( $key );
            }
        }

        $array_redis = $redis->hmget($table_name,$key);
        if ( $array_redis == null || ( is_string($array_redis) || is_array($array_redis) ) == false )
        {
            return null;
        }
        $return_string = array();
        foreach( $array_redis as $row )
        {
            array_push( $return_string, json_decode($row, true) );
        }
        return $return_string;
	}
}
?>