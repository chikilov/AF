<?php
class MY_Controller extends CI_Controller
{
	public $socket;

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
	}

	function makeMsg( $method, $user_id = null, $arrMsg = null )
	{
		$size = ARRSOCKETSTRUCT[$method]['send_size'];
		if ( $method == CQ_KNOCKING )
		{
			$strMsg = pack( ARRSOCKETSTRUCT[$method]['send_struct'], $method, $size, 0, 1, 0, 0, 0 );
		}
		else if ( $method == CQ_LOGIN_ADMIN )
		{
			$size = 116;
			$strMsg = pack( ARRSOCKETSTRUCT[$method]['send_struct'], $method, $size, 0, 1, 0, 0, md5(MASTER_SERVER_ADMIN_PASSWORD), MASTER_SERVER_ADMIN_ID );
		}
		else if ( $method == MSG_SERVER_KICK_USER )
		{
			$size = 4000;
			$strMsg = pack( ARRSOCKETSTRUCT[$method]['send_struct'], $method, 4000, 0, 1, 0 );
		}
		else if ( $method == MSG_SERVER_SINGLECAST )
		{
			$strMsg = pack( ARRSOCKETSTRUCT[$method]['send_struct'], $method, $arrMsg['size'] + 24, 0, 1, $user_id, 20, $arrMsg['msg'] );
		}
		$arrMsg['msg'] = $strMsg;
		$arrMsg['size'] = $size;

		return $arrMsg;
	}

	function makeSocketConn()
	{
		$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ( $this->socket === false )
		{
//		    echo "socket_create() 실패! 이유: " . socket_strerror(socket_last_error()) . "\n";
		    return false;
		}
		if ( socket_connect( $this->socket, MASTER_SERVER_IP, MASTER_SERVER_PORT ) === false )
		{
//		    echo "socket_connect() 실패.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
		    return false;
		}
		return true;
	}

	function sendSocketMsg( $method, $user_id = null )
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

		$arrMsg = $this->makeMsg( $method );
		if ( array_key_exists( 'send_with', ARRSOCKETSTRUCT[$method] ) )
		{
			if ( !empty( ARRSOCKETSTRUCT[$method]['send_with'] ) )
			{
				foreach( ARRSOCKETSTRUCT[$method]['send_with'] as $row )
				{
					$arrMsg = $this->makeMsg( $row, $user_id, $arrMsg );
				}
			}
			else
			{
				return false;
			}
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
}
?>