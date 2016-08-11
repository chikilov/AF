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
	{
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

		$this->load->view( 'adminmenu', array( 'arrGroup' => $arrGroup ) );
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
			$result = boolval( $this->dbBase->menuinsert(
				$this->input->post('_title_kr'), $this->input->post('_title_en'), $this->input->post('_controller'), $this->input->post('_view'),
				$this->input->post('_icon'), $this->input->post('_group_id'), $this->input->post('_active')
			) );
		}
		else
		{
			$result = boolval( $this->dbBase->menuupdate(
				$this->input->post('_title_kr'), $this->input->post('_title_en'), $this->input->post('_controller'), $this->input->post('_view'),
				$this->input->post('_icon'), $this->input->post('_group_id'), $this->input->post('_active'), $this->input->post('_id')
			) );
		}

		var_export( boolval( $result ) );
	}

	public function menuorder()
	{
		$result = true;
		$this->load->model('Model_Master_Base', 'dbBase');
		foreach( $this->input->post() as $key => $val )
		{
			$result = $result | boolval( $this->dbBase->menuorder( str_replace( 'order-', '', $key ), $val ) );
		}

		var_export( boolval($result) );
	}

	public function adminaccount()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrGroup = $this->dbBase->admingrouplist()->result_array();

		$this->load->view( 'adminaccount', array( 'arrGroup' => $arrGroup ) );
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
		var_export($result);
	}

	public function accountpassword()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$result = boolval( $this->dbBase->accountpassword( $this->input->post('_username') ) );

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

		$this->load->view( 'adminauth', array( 'arrGroup' => $arrGroup ) );
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
		}
		$arrResult = $this->dbBase->adminauthparentvalue( $this->input->post('group_id') )->result_array();
		foreach ( $arrResult as $row )
		{
			$result += intval( $this->dbBase->adminauthupdate( $this->input->post('group_id'), $row['_parent_id'], ( boolval( $row['sumval'] ) ? 'true' : 'false' ), ( boolval( $row['sumval'] ) ? 'true' : 'false' ) ) );
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
}
