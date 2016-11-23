<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

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
	{//PHP_SELF
		parent::__construct();
		if ( $this->session->has_userdata('language') )
		{
			if ( $this->session->userdata('language') == '' || $this->session->userdata('language') == null )
			{
				$this->lang->load('Admin_lang', $this->config->item('language') );
			}
			else
			{
				$this->lang->load('Admin_lang', $this->session->userdata('language') );
			}
		}
		else
		{
			$this->lang->load('Admin_lang', $this->config->item('language') );
		}
	}

	public function index()
	{
		$this->load->view( 'login' );
	}

	public function adminmenu()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrGroup = $this->dbBase->grouplist()->result_array();

		$arrAuth = $this->checkAuth();
		$this->load->view( 'adminmenu', array( 'arrGroup' => $arrGroup, 'arrAuth' => $arrAuth ) );
	}

	public function menulist()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		echo json_encode( $this->dbBase->menufulllist()->result_array(), JSON_UNESCAPED_UNICODE );
	}

	public function menudel()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		if ( $this->dbBase->menudel($this->input->post('id')) == 1 )
		{
			$this->load->model('Model_Master_Log', 'dbLog');
			$this->dbLog->adminlogins( 0, 0, '', '관리툴 메뉴 삭제( _id => '.$this->input->post('id').' )' );
			var_export(true);
		}
		else
		{
			var_export(false);
		}
	}

	public function menudetails()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrResult = $this->dbBase->menudetails( $this->input->post('id') )->result_array();
		if ( !empty($arrResult) )
		{
			echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
		}
		else
		{
			echo '[]';
		}
	}

	public function menuupdate()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		if ( $this->input->post('_id') == '' || $this->input->post('_id') == null )
		{
			$result = $this->dbBase->menuinsert(
				$this->input->post('_title_kr'), $this->input->post('_title_en'), $this->input->post('_controller'), $this->input->post('_view'),
				$this->input->post('_icon'), $this->input->post('_group_id'), $this->input->post('_active')
			);
			$this->load->model('Model_Master_Log', 'dbLog');
			$this->dbLog->adminlogins( 0, 0, '', '관리툴 메뉴 추가( _id => '.$result.' )' );
		}
		else
		{
			$result = boolval( $this->dbBase->menuupdate(
				$this->input->post('_title_kr'), $this->input->post('_title_en'), $this->input->post('_controller'), $this->input->post('_view'),
				$this->input->post('_icon'), $this->input->post('_group_id'), $this->input->post('_active'), $this->input->post('_id')
			) );
			$this->load->model('Model_Master_Log', 'dbLog');
			$this->dbLog->adminlogins( 0, 0, '', '관리툴 메뉴 수정( _id => '.$this->input->post('_id').', _title_kr => '.$this->input->post('_title_kr').', _title_en => '.$this->input->post('_title_en').', _controller => '.$this->input->post('_controller').', _view => '.$this->input->post('_view').', _icon => '.$this->input->post('_icon').', _group_id => '.$this->input->post('_group_id').', _active => '.$this->input->post('_active').' )' );
		}

		var_export( boolval( $result ) );
	}

	public function menuorder()
	{
		$result = true;
		$this->load->model('Model_Master_Base', 'dbBase');
		foreach( $this->input->post() as $key => $val )
		{
			$strLog = '관리툴 메뉴 순서 수정(';
			$isChanged = false;
			$subResult = boolval( $this->dbBase->menuorder( str_replace( 'order-', '', $key ), $val ) );
			$result = $result || $subResult;
			if ( $subResult )
			{
				if ( $strLog != '관리툴 메뉴 순서 수정(' )
				{
					$strLog .= ',';
				}
				$strLog .= ' _id => '.$key.', _order => '.$val.'';
				$isChanged = true;
			}
			if ( $isChanged )
			{
				$this->load->model('Model_Master_Log', 'dbLog');
				$this->dbLog->adminlogins( 0, 0, '', $strLog.' )' );
			}
		}

		var_export( boolval($result) );
	}

	public function adminaccount()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrGroup = $this->dbBase->admingrouplist()->result_array();

		$arrAuth = $this->checkAuth();
		$this->load->view( 'adminaccount', array( 'arrGroup' => $arrGroup, 'arrAuth' => $arrAuth ) );
	}

	public function accountlist()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrResult = $this->dbBase->accountlist()->result_array();

		echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
	}

	public function accountdetails()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrResult = $this->dbBase->accountdetails( $this->input->post('_useraccount') )->result_array();

		echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
	}

	public function accountupdate()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		if ( $this->input->post('_approved') == '2' )
		{
			$_deleted = '1';
			$_approved = '1';
		}
		else
		{
			$_deleted = '0';
			$_approved = $this->input->post('_approved');
		}

		$result = boolval( $this->dbBase->accountupdate( $this->input->post('_username'), $this->input->post('_name'), $this->input->post('_reason'),
				$this->input->post('_depart'), $this->input->post('_auth'), $_approved, $_deleted
		) );
		$this->load->model('Model_Master_Log', 'dbLog');
		$this->dbLog->adminlogins( 0, 0, $this->input->post('_reason'), '관리자 승인상태 변경( _username => '.$this->input->post('_username').', _auth => '.$this->input->post('_auth').', _approved => '.$this->input->post('_title_kr').', _deleted => '.$this->input->post('_title_en').' )' );
		var_export($result);
	}

	public function accountpassword()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$result = boolval( $this->dbBase->accountpassword( $this->input->post('_username') ) );
		$this->load->model('Model_Master_Log', 'dbLog');
		$this->dbLog->adminlogins( 0, 0, '', '관리자 암호 리셋( _username => '.$this->input->post('_username').' )' );

		var_export($result);
	}

	public function accountlog()
	{
		echo json_encode( array(
				array('_regdate' => '2016-02-12 17:23:04', '_admin_id' => $this->input->post('admin_id'), '_logdetails' => '계정 삭제' ),
				array('_regdate' => '2016-01-09 17:23:04', '_admin_id' => $this->input->post('admin_id'), '_logdetails' => '비번 초기화' ),
				array('_regdate' => '2015-12-31 01:03:04', '_admin_id' => $this->input->post('admin_id'), '_logdetails' => '권한 부여 - HGM' ),
				array('_regdate' => '2015-12-10 17:28:22', '_admin_id' => $this->input->post('admin_id'), '_logdetails' => '권한 부여 - GM' ),
				array('_regdate' => '2015-12-10 17:23:04', '_admin_id' => $this->input->post('admin_id'), '_logdetails' => '계정 승인 - wjswlgus01' )
		), JSON_UNESCAPED_UNICODE );
	}

	public function adminauth()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrGroup = $this->dbBase->admingrouplist()->result_array();

		$arrAuth = $this->checkAuth();
		$this->load->view( 'adminauth', array( 'arrGroup' => $arrGroup, 'arrAuth' => $arrAuth ) );
	}

	public function admingroupauth()
	{
		$this->load->model('Model_Master_Base', 'dbBase');

		echo json_encode( $this->dbBase->admingroupauth( $this->input->post('group_id') )->result_array(), JSON_UNESCAPED_UNICODE );
	}

	public function authupdate()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrData = json_decode(json_decode($this->input->post('data'), true), true);
		$result = 0;
		foreach( $arrData as $key => $val )
		{
			$result += intval( $this->dbBase->adminauthupdate( $this->input->post('group_id'), $val['key'], $val['val']['view'], $val['val']['write'] ) );
			$this->load->model('Model_Master_Log', 'dbLog');
			$this->dbLog->adminlogins( 0, 0, '', '권한 관리 수정( _group_id => '.$this->input->post('group_id').', _menu_id => '.$val['key'].', _auth_view => '.$val['val']['view'].', _auth_write => '.$val['val']['write'].' )' );
		}
		$arrResult = $this->dbBase->adminauthparentvalue( $this->input->post('group_id') )->result_array();
		foreach ( $arrResult as $row )
		{
			$result += intval( $this->dbBase->adminauthupdate( $this->input->post('group_id'), $row['_parent_id'], ( boolval( $row['sumval'] ) ? 'true' : 'false' ), ( boolval( $row['sumval'] ) ? 'true' : 'false' ) ) );
			$this->load->model('Model_Master_Log', 'dbLog');
			$this->dbLog->adminlogins( 0, 0, '', '권한 관리 수정( _group_id => '.$this->input->post('group_id').', _menu_id => '.$row['_parent_id'].', _auth_view => '.boolval( $row['sumval'] ).', _auth_write => '.boolval( $row['sumval'] ).' )' );
		}

		echo $result;
	}

	public function groupnamecheck()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		var_export( $this->dbBase->groupnamecheck( $this->input->post('group_name') ) );
	}

	public function groupinsert()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		var_export( $this->dbBase->authgroupinsert( $this->input->post('group_name'), $this->input->post('group_applies') ) );
	}

	public function groupdelete()
	{
		$result = true;
		$this->load->model('Model_Master_Base', 'dbBase');
		$result = $result & boolval( $this->dbBase->authdelete( $this->input->post('group_id') ) );
		$result = $result & boolval( $this->dbBase->authgroupdelete( $this->input->post('group_id') ) );
		var_export( boolval( $result ) );
	}

	public function adminlog()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrGroup = $this->dbBase->grouplist()->result_array();

		$this->load->view( 'adminlog', array( 'arrGroup' => $arrGroup ) );
	}

	public function adminloglist()
	{
		$this->load->model('Model_Master_Log', 'dbLog');
		$arrLog = $this->dbLog->adminlog( $this->input->post('daterange1'), $this->input->post('daterange2'), $this->input->post('search_type'), $this->input->post('search_value'), $this->input->post('log_type') )->result_array();

		echo json_encode( $arrLog, JSON_UNESCAPED_UNICODE );
	}

	public function datamanage()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrGroup = $this->dbBase->grouplist()->result_array();

		$arrAuth = $this->checkAuth();
		$this->load->view( 'datamanage', array( 'arrGroup' => $arrGroup, 'arrAuth' => $arrAuth ) );
	}

	public function datalist()
	{
		$arrFile = array();
		$handle = opendir('/data/shared/gameDB');
		while (false !== ($file = readdir($handle))) {
			if ( pathinfo( $file, PATHINFO_EXTENSION ) == 'xml' )
			{
				$key = -1;
				$fArr = array_column( REDISMAP, 'file' );
				foreach( $fArr as $fKey => $fVal )
				{
					if ( in_array( $file, $fVal ) )
					{
						$key = $fKey;
					}
				}

				if ( $key >= 0 )
				{
					$tname = REDISMAP[$key]['table'];
					$searchKey = array_search( $tname, array_column( $arrFile, 'table' ) );
					if ( $searchKey === false )
					{
						$tarr = array( 'table' => $tname, 'file' => array( $file ), 'size' => array( filesize( '/data/shared/gameDB/'.$file ) ) );
						$arrFile[] = $tarr;
					}
					else
					{
						$arrFile[$searchKey]['file'][] = $file;
						$arrFile[$searchKey]['size'][] = filesize( '/data/shared/gameDB/'.$file );
					}
				}
			}
		}

		array_multisort( array_column( $arrFile, 'table' ), SORT_ASC, $arrFile );
		echo json_encode( $arrFile, JSON_UNESCAPED_UNICODE );
	}

	public function reloaddata()
	{
		$key = array_search( explode( ',', $this->input->post('file') ), array_column( REDISMAP, 'file' ) );
		$row = REDISMAP[$key];
		$xml = $this->LoadXmlToArray( $row['file'] );
		$xml = array_map(
			function($row) {
				return array_filter(
					$row,
					function($col) {
						return $col;
					}
				);
			},
			$xml
		);

		$arrXml = array();
		foreach ( $xml as $xRow )
		{
			$arrXml = array_merge( $arrXml, $xRow );
		}
		$this->sortBy( REDISMAP[$key]['key'], $arrXml );
		$this->redis->del( $row['table'] );

		foreach ( $arrXml as $key => $val )
		{
			if ( array_key_exists( $row['key'] , $val ) )
			{
				if ( is_array( $row['key'] ) )
				{
					foreach ( $row['key'] as $kRow )
					{
						$idx .= strval( $kRow );
					}
				}
				else
				{
					$idx = $val[$row['key']];
				}

				if ( array_key_exists( 'exceptions', $row ) )
				{
					if ( in_array( $idx, $row['exceptions'] ) === false )
					{
						$this->redis->hset( $row['table'], $idx, json_encode( $val, JSON_UNESCAPED_UNICODE ) );
					}
				}
				else
				{
					$this->redis->hset( $row['table'], $idx, json_encode( $val, JSON_UNESCAPED_UNICODE ) );
				}
			}
		}

		var_export(true);

//		var_dump( $this->SresultFromRedis( $redis, 'MASTER_ITEM', '120505301' ) );
//		echo "\n---------------------------------------\n";
//		var_dump( $this->MresultFromRedis( $this->redis, $row['table'] ) );
	}

}
