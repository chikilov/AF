<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		if ( $this->session->has_userdata('language') )
		{
			if ( $this->session->userdata('language') == '' || $this->session->userdata('language') == null )
			{
				$this->lang->load('Setting_lang', $this->config->item('language') );
			}
			else
			{
				$this->lang->load('Setting_lang', $this->session->userdata('language') );
			}
		}
		else
		{
			$this->lang->load('Setting_lang', $this->config->item('language') );
		}
	}

	public function index()
	{
		$this->load->view( 'login' );
	}

	public function content()
	{
		$arrAuth = $this->checkAuth();
		$this->load->view( 'content', array( 'arrAuth' => $arrAuth ) );
	}

	public function contentstatus()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrResult = $this->dbBase->contentstatus()->result_array();
		$result = array();

		foreach ( $arrResult as $key => $val )
		{
			$arrResult[$key]['_csflag'] = substr( (string)decbin( $val['_csflag'] ), 0, strlen( (string)decbin( $val['_csflag'] ) ) - 1 );
			for ( $i = 0; $i < count( CONTENT_TYPE ); $i++ )
			{
				if ( strlen( (string)$arrResult[$key]['_csflag'] ) > 0 )
				{
					$result[] = array_merge( CONTENT_TYPE[$i + 1], array( 'value' => substr( (string)$arrResult[$key]['_csflag'], -1 ) ) );
					$arrResult[$key]['_csflag'] = substr( (string)$arrResult[$key]['_csflag'], 0, strlen((string)$arrResult[$key]['_csflag']) - 1 );
				}
				else
				{
					if ( count( CONTENT_TYPE ) > $i + 1 )
					{
						$result[] = array_merge( CONTENT_TYPE[$i + 1], array( 'value' => '0' ) );
					}
				}
			}
		}

		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	public function contentupdate()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrResult = $this->dbBase->contentstatus()->result_array();
		$content['before'] = $arrResult[0]['_csflag'];
		$this->dbBase->onBeginTransaction();
		$result = boolval( $this->dbBase->contentupdate( $this->input->post('pmval') ) );
		$arrResult = $this->dbBase->contentstatus()->result_array();
		$content['after'] = $arrResult[0]['_csflag'];

		if ( $result )
		{
			foreach ( $this->config->item('MASTER') as $key => $val )
			{
				if ( $this->makeSocketConn( $key ) )
				{
					$method = CQ_KNOCKING;
					$arrResponse = $this->sendSocketMsg( $method );
					if ( !empty( $arrResponse ) )
					{
						if ( $arrResponse['msg_id'] !== SA_KNOCKING )
						{
							$this->dbBase->onEndTransaction( false );
							var_export( false );
							break;
						}
					}
					else
					{
						$this->dbBase->onEndTransaction( false );
						var_export( false );
					}

					$method = CQ_LOGIN_ADMIN;
					$arrResponse = $this->sendSocketMsg( $method, array( $val['pw'], $val['id'] ) );
					if ( !empty( $arrResponse ) )
					{
						if ( $arrResponse['msg_id'] !== SA_LOGIN_ADMIN )
						{
							$this->dbBase->onEndTransaction( false );
							var_export( false );
							break;
						}
					}
					else
					{
						$this->dbBase->onEndTransaction( false );
						var_export( false );
						break;
					}

					$method = MSG_SET_CONTENTS_STATUS;
					$arrResponse = $this->sendSocketMsg( $method, array( $content['after'] ) );

					socket_close($this->socket);
					$this->load->model('Model_Master_Log', 'dbLog');
					$this->dbLog->adminlogins( 0, 0, '', '컨텐츠 사용 변경( before => '.$content['before'].', after => '.$content['after'].' )' );
				}
				else
				{
					$this->dbBase->onEndTransaction( false );
					var_export( false );
					break;
				}
			}
			$this->dbBase->onEndTransaction( $arrResponse );
			var_export( $arrResponse );
		}
	}

	public function notification()
	{
		$arrAuth = $this->checkAuth();
		$this->load->view( 'notification', array( 'arrAuth' => $arrAuth ) );
	}

	public function notilist()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
		$arrXml = $this->dbBase->xmlinfo()->result_array();
		$url = $arrXml[0]['_location'].'Map_Dungeon_Data.xml';
		$xml = str_replace('</Classes>', '', file_get_contents( $url, false, $context ) );
		$url = $arrXml[0]['_location'].'Map_Raid_Data.xml';
		$xml .= str_replace( '<?xml version="1.0" encoding="utf-8" standalone="yes"?>', '', str_replace( '<Classes>', '', file_get_contents( $url, false, $context ) ) );
		$xml = (array)simplexml_load_string($xml);
		$arrXml = array();
		foreach ( $xml['Class'] as $key => $val )
		{
			$arrXml[$key]['id'] = $val->Index_id->__toString();
			$arrXml[$key]['kr'] = str_replace( array( '［', '］' ), '', $val->Dun_Name_Kor->__toString() );
			$arrXml[$key]['en'] = $val->Dun_Name_Eng->__toString();
		}

		$arrResult = $this->dbBase->selecteventnotice()->result_array();
	    foreach($arrResult as $key => $val)
	    {
	       $arrResult[$key] = array_merge( $val, $arrXml[array_search( $val['_target_id'] , array_column( $arrXml, 'id' ) )] );
	    }

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}
}
