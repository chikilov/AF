<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

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
				$this->lang->load('Login_lang', $this->config->item('language') );
			}
			else
			{
				$this->lang->load('Login_lang', $this->session->userdata('language') );
			}
		}
		else
		{
			$this->lang->load('Login_lang', $this->config->item('language') );
		}
	}

	public function index()
	{
		$this->load->view( 'login' );
	}

	public function register()
	{
		$this->load->view( 'register' );
	}

	public function duplicationcheck()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		if ( $this->dbBase->selectUsername( $this->input->post('register-username') ) )
		{
			echo 'false';
		}
		else
		{
			echo 'true';
		}
	}

	public function registeraction()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		if ( $this->dbBase->insertUser(
					$this->input->post('register-username'), $this->input->post('register-password'), $this->input->post('register-name'),
					$this->input->post('register-depart'), $this->input->post('register-reason')
			)
		)
		{
			$this->load->view('alertlocationview', array(
				'alertprefix' => 'Success',
				'alertstring' => $this->lang->line('success_signup'),
				'alerttype' => 'success',
				'afterlocation' => '/Login',
			));
		}
		else
		{
			$this->load->view('alertlocationview', array(
				'alertprefix' => 'Oops...',
				'alertstring' => $this->lang->line('fail_signup'),
				'alerttype' => 'error',
				'afterlocation' => '/Login/register',
			));
		}
	}

	public function loginaction()
	{
		$this->load->model('Model_Master_Base', 'dbBase');

		$arrLogin = $this->dbBase->selectUser( $this->input->post('login-username'), $this->input->post('login-password') )->result_array();
		if ( empty($arrLogin) )
		{
			$this->load->view('alertlocationview', array(
				'alertprefix' => 'Oops...',
				'alertstring' => $this->lang->line('fail_signin'),
				'alerttype' => 'error',
				'afterlocation' => '/Login',
			));
		}
		else
		{
			if ( count($arrLogin) > 1 )
			{
				$this->load->view('alertlocationview', array(
					'alertprefix' => 'Oops...',
					'alertstring' => $this->lang->line('fail_signin'),
					'alerttype' => 'error',
					'afterlocation' => '/Login',
				));
			}
			else
			{
				$lastChange = new DateTime($arrLogin[0]['_lastchange']);
				$datediff = $lastChange->diff( new DateTime() )->days;
				if ( $datediff > 90 )
				{
					$this->session->set_userdata( array( 'temp_id' => $arrLogin[0]['_username'] ) );
					$this->session->set_userdata( array( 'temp_pass' => $this->input->post('login-password') ) );
					$this->load->view('alertlocationview', array(
						'alertprefix' => 'Oops...',
						'alertstring' => $this->lang->line('need_password_change'),
						'alerttype' => 'error',
						'afterlocation' => '/Login/changepassword',
					));
				}
				else
				{
					$this->session->set_userdata( array( 'admin_id' => $arrLogin[0]['_username'], 'language' => $this->input->post('login-language'), 'admin_auth' => $arrLogin[0]['_auth'] ) );
					$this->load->view('alertlocationview', array(
						'afterlocation' => '/User/userinfo',
					));
				}
			}
		}
	}

	public function changepassword()
	{
		$this->load->view('changepassword');
	}

	public function changepasswordaction()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		if ( $this->dbBase->updatePassword( $this->input->post('register-username'), $this->input->post('register-password') ) > 0 )
		{
			$this->session->unset_userdata( array('temp_id', 'temp_pass'));
			$this->load->view('alertlocationview', array(
				'alertprefix' => 'Success',
				'alertstring' => $this->lang->line('password_changecomplete'),
				'alerttype' => 'success',
				'afterlocation' => '/Login',
			));
		}
		else
		{
			$this->load->view('alertlocationview', array(
				'alertprefix' => 'Oops...',
				'alertstring' => $this->lang->line('password_changefail'),
				'alerttype' => 'error',
				'afterlocation' => '/Login/changepassword',
			));
		}
	}

	public function logout()
	{
		$this->session->unset_userdata( 'admin_id' );
		$this->load->view('alertlocationview', array(
			'alertprefix' => 'Success!',
			'alertstring' => $this->lang->line('logout_complete'),
			'alerttype' => 'success',
			'afterlocation' => '/Login',
		));
	}

	public function changelanguage()
	{
		$this->session->set_userdata('language', $this->input->post('language'));
		return true;
	}
}
