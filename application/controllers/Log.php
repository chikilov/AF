<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends MY_Controller {

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
				$this->lang->load('Log_lang', $this->config->item('language') );
			}
			else
			{
				$this->lang->load('Log_lang', $this->session->userdata('language') );
			}
		}
		else
		{
			$this->lang->load('Log_lang', $this->config->item('language') );
		}
	}

	public function index()
	{
		$this->load->view( 'login' );
	}

	public function gameloginfo()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrGroup = $this->dbBase->grouplist()->result_array();

		$this->load->view( 'gameloginfo', array( 'arrGroup' => $arrGroup ) );
	}

	public function gameloglist()
	{
		$this->load->model('Model_Master_Log', 'dbLog');
		$arrLog = $this->dbLog->searchlog( $this->input->post('daterange1'), $this->input->post('daterange2'), $this->input->post('search_type'), $this->input->post('search_value'), $this->input->post('log_type') )->result_array();

		echo json_encode( $arrLog, JSON_UNESCAPED_UNICODE );
	}
}
