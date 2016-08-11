<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

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

	public $dbGame;
	public function __construct()
	{
		parent::__construct();
		if ( $this->session->has_userdata('language') )
		{
			if ( $this->session->userdata('language') == '' || $this->session->userdata('language') == null )
			{
				$this->lang->load('User_lang', $this->config->item('language') );
			}
			else
			{
				$this->lang->load('User_lang', $this->session->userdata('language') );
			}
		}
		else
		{
			$this->lang->load('User_lang', $this->config->item('language') );
		}
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function userinfo()
	{
		$this->load->view('userinfo');
	}

	public function userlist()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrResult = $this->dbBase->selectUserlist( $this->input->post('search_type'), $this->input->post('search_value'), $this->input->post('daterange1'), $this->input->post('daterange2') )->result_array();

		foreach( $arrResult as $key => $val )
		{
			$arrSubResult = $this->dbBase->selectBlocklist( $val['_user_account'] )->result_array();
			if ( !empty($arrSubResult) )
			{
				if ( array_key_exists( '_etime', $val ) )
				{
					if ( strtotime( $val['_etime'] ) < strtotime( $Subrow['_etime'] ) )
					{
						$arrResult[$key]['_etime'] = $Subrow['_etime'];
						$arrResult[$key]['_block_type'] = $Subrow['_block_type'];
					}
				}
				else
				{
					if ( strtotime( $Subrow['_etime'] ) > time() )
					{
						$arrResult[$key]['_etime'] = $Subrow['_etime'];
						$arrResult[$key]['_block_type'] = $Subrow['_block_type'];
					}
					else
					{
						$arrResult[$key]['_etime'] = '';
						$arrResult[$key]['_block_type'] = '';
					}
				}
			}
			else
			{
				$arrResult[$key]['_etime'] = '';
				$arrResult[$key]['_block_type'] = '';
			}
		}

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function accesslist()
	{
		$arrResult = array(
			array(
				'access_datetime' => '2016-06-06 14:05:12',
				'access_ip' => '211.36.24.3',
				'access_uuid' => '3R9SL00FFHKS523KJD',
				'create_type' => '0',
				'access_os' => 'IOS',
				'access_country' => 'Ko-kr',
				'access_version' => '1.0.7'
			),
			array(
				'access_datetime' => '2016-06-30 13:05:36',
				'access_ip' => '1.254.22.32',
				'access_uuid' => '3R9SL00FFHKS523KJD',
				'create_type' => '0',
				'access_os' => 'Android',
				'access_country' => 'Ko-kr',
				'access_version' => '1.0.7'
			),
			array(
				'access_datetime' => '2016-07-07 00:05:14',
				'access_ip' => '1.254.22.32',
				'access_uuid' => '3R9SL00FFHKS523KJD',
				'create_type' => '0',
				'access_os' => 'Android',
				'access_country' => 'Ko-kr',
				'access_version' => '1.0.7'
			),
			array(
				'access_datetime' => '2016-07-07 08:23:58',
				'access_ip' => '1.254.22.32',
				'access_uuid' => '3R9SL00FFHKS523KJD',
				'create_type' => '0',
				'access_os' => 'Android',
				'access_country' => 'Ko-kr',
				'access_version' => '1.0.7'
			),
			array(
				'access_datetime' => '2016-07-11 22:16:00',
				'access_ip' => '1.254.22.32',
				'access_uuid' => '3R9SL00FFHKS523KJD',
				'create_type' => '0',
				'access_os' => 'Android',
				'access_country' => 'Ko-kr',
				'access_version' => '1.0.7'
			)
		);

		$temparr = array();
		foreach ($arrResult as $row)
		{
			if ( $this->input->post('daterange1') != null && $this->input->post('daterange2') != null && $this->input->post('daterange1') != '' && $this->input->post('daterange2') != '' )
			{
				if ( strtotime($row['access_datetime']) >= strtotime($this->input->post('daterange1').' 00:00:00') && strtotime($row['access_datetime']) <= strtotime($this->input->post('daterange2').' 23:59:59') )
				{
					array_push($temparr, $row);
				}
			}
			else
			{
				if ( $this->input->post('daterange1') != null && $this->input->post('daterange1') != '' )
				{
					if ( strtotime($row['access_datetime']) >= strtotime($this->input->post('daterange1').' 00:00:00') )
					{
						array_push($temparr, $row);
					}
				}
				else if ( $this->input->post('daterange2') != null && $this->input->post('daterange2') != '' )
				{
					if ( strtotime($row['access_datetime']) <= strtotime($this->input->post('daterange2').' 23:59:59') )
					{
						array_push($temparr, $row);
					}
				}
				else
				{
					array_push($temparr, $row);
				}
			}
		}
		$arrResult = $temparr;

		echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function joinloglist()
	{
		$arrResult = array(
			array(
				'join_log_status' => '탈퇴',
				'join_log_datetime' => '2016-06-06 14:05:12',
				'join_log_manager' => 'rlaxogml01',
				'join_log_memo' => '계정도용 / CS접수'
			),
			array(
				'join_log_status' => '가입',
				'join_log_datetime' => '2016-06-30 13:05:36',
				'join_log_manager' => 'rlaxogml02',
				'join_log_memo' => '-'
			),
			array(
				'join_log_status' => '탈퇴',
				'join_log_datetime' => '2016-07-06 13:05:36',
				'join_log_manager' => 'rlaxogml03',
				'join_log_memo' => '직접 탈퇴'
			),
			array(
				'join_log_status' => '가입',
				'join_log_datetime' => '2016-07-07 00:05:14',
				'join_log_manager' => 'rlaxogml04',
				'join_log_memo' => '-'
			),
			array(
				'join_log_status' => '탈퇴',
				'join_log_datetime' => '2016-07-11 22:16:00',
				'join_log_manager' => 'rlaxogml05',
				'join_log_memo' => '계정도용 / CS접수'
			)
		);

		echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function blockaction()
	{
		if ( $this->input->post('block_type') == '1' )
		{
			echo '1';
		}
		else
		{
			echo '0';
		}
	}

	public function blocklist()
	{
		$arrResult = array(
			array(
				'block_info_manager' => 'rlaxogml01',
				'block_reason' => '테스트',
				'block_datetime' => '2016-06-06 14:05:12',
				'block_type' => '인증블록',
				'action_type' => '블록'
			),
			array(
				'block_info_manager' => 'rlaxogml02',
				'block_reason' => '빌링은 기간 없음',
				'block_datetime' => '2016-07-06 13:05:36',
				'block_type' => '인증블록',
				'action_type' => '해제'
			),
			array(
				'block_info_manager' => 'rlaxogml03',
				'block_reason' => '결제 어뷰징',
				'block_datetime' => '2016-06-30 13:05:36',
				'block_type' => '빌링블록',
				'action_type' => '블록'
			),
			array(
				'block_info_manager' => 'rlaxogml04',
				'block_reason' => '기간만료시 자동해제',
				'block_datetime' => '2016-07-07 00:05:14',
				'block_type' => '빌링블록',
				'action_type' => '해제'
			),
			array(
				'block_info_manager' => 'rlaxogml05',
				'block_reason' => '관리자가 작성한 사유',
				'block_datetime' => '2016-07-11 22:16:00',
				'block_type' => '인증블록',
				'action_type' => '블록'
			)
		);

		echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function paymentinfo()
	{
		$arrResult = array(
			array(
				'tid' => '3B9SL00FFHKS523KJD',
				'pay_type' => '결제',
				'store' => 'google',
				'product' => '보석 20,000',
				'amount' => '20,000',
				'last_change_datetime' => '2016-06-06 14:05:12',
				'status' => '성공'
			),
			array(
				'tid' => 'SLIUF862LSKN35KD31',
				'pay_type' => '선물',
				'store' => 'naver',
				'product' => '보석 20,000',
				'amount' => '20,000',
				'last_change_datetime' => '2016-06-17 18:42:09',
				'status' => '성공'
			),
			array(
				'tid' => '29DLEIVEEFSIJ352KE',
				'pay_type' => '결제',
				'store' => 'tstore',
				'product' => '보석 10,000',
				'amount' => '10,000',
				'last_change_datetime' => '2016-06-30 13:05:36',
				'status' => '지급실패'
			),
			array(
				'tid' => 'G146HOALK35D632QQ7',
				'pay_type' => '선물',
				'store' => 'naver',
				'product' => '보석 10,000',
				'amount' => '10,000',
				'last_change_datetime' => '2016-07-01 00:00:00',
				'status' => '지급실패'
			),
			array(
				'tid' => 'Q9L0FK53JDK2SHF0LG',
				'pay_type' => '선물',
				'store' => 'naver',
				'product' => '보석 10,000',
				'amount' => '10,000',
				'last_change_datetime' => '2016-07-06 13:05:36',
				'status' => '대기'
			),
			array(
				'tid' => 'EK5JSEVED29LIEFI32S',
				'pay_type' => '결제',
				'store' => 'google',
				'product' => '보석 10,000',
				'amount' => '10,000',
				'last_change_datetime' => '2016-07-07 00:05:14',
				'status' => '성공'
			),
			array(
				'tid' => 'G4HAK3D3Q716OL3D3Q',
				'pay_type' => '결제',
				'store' => 'google',
				'product' => '보석 10,000',
				'amount' => '10,000',
				'last_change_datetime' => '2016-07-11 22:16:00',
				'status' => '성공'
			)
		);

		echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function paymentdetail()
	{
		$arrResult = array(
			'3B9SL00FFHKS523KJD' => array(
				'tid' => '3B9SL00FFHKS523KJD',
				'user_id' => '112568',
				'pay_type' => '결제',
				'store' => 'google',
				'product_id' => 'jewel_20000',
				'order_id' => '20160606140512',
				'product_type' => 'FNQL002',
				'product' => '보석 20,000',
				'amount' => '20,000',
				'last_change_datetime' => '2016-06-06 14:05:12',
				'status' => '성공'
			),
			'SLIUF862LSKN35KD31' => array(
				'tid' => 'SLIUF862LSKN35KD31',
				'user_id' => '112568',
				'pay_type' => '선물',
				'store' => 'naver',
				'product_id' => 'jewel_20000',
				'order_id' => '20160617184209',
				'product_type' => 'FNQL002',
				'product' => '보석 20,000',
				'amount' => '20,000',
				'last_change_datetime' => '2016-06-17 18:42:09',
				'status' => '성공'
			),
			'29DLEIVEEFSIJ352KE' => array(
				'tid' => '29DLEIVEEFSIJ352KE',
				'user_id' => '112568',
				'pay_type' => '결제',
				'store' => 'tstore',
				'product_id' => 'jewel_10000',
				'order_id' => '20160630130536',
				'product_type' => 'FNQL002',
				'product' => '보석 10,000',
				'amount' => '10,000',
				'last_change_datetime' => '2016-06-30 13:05:36',
				'status' => '지급실패'
			),
			'G146HOALK35D632QQ7' => array(
				'tid' => 'G146HOALK35D632QQ7',
				'user_id' => '112568',
				'pay_type' => '선물',
				'store' => 'naver',
				'product_id' => 'jewel_10000',
				'order_id' => '20160701000000',
				'product_type' => 'FNQL002',
				'product' => '보석 10,000',
				'amount' => '10,000',
				'last_change_datetime' => '2016-07-01 00:00:00',
				'status' => '지급실패'
			),
			'Q9L0FK53JDK2SHF0LG' => array(
				'tid' => 'Q9L0FK53JDK2SHF0LG',
				'user_id' => '112568',
				'pay_type' => '선물',
				'store' => 'naver',
				'product_id' => 'jewel_10000',
				'order_id' => '20160706130536',
				'product_type' => 'FNQL002',
				'product' => '보석 10,000',
				'amount' => '10,000',
				'last_change_datetime' => '2016-07-06 13:05:36',
				'status' => '대기'
			),
			'EK5JSEVED29LIEFI32S' => array(
				'tid' => 'EK5JSEVED29LIEFI32S',
				'user_id' => '112568',
				'pay_type' => '결제',
				'store' => 'google',
				'product_id' => 'jewel_10000',
				'order_id' => '20160707000514',
				'product_type' => 'FNQL002',
				'product' => '보석 10,000',
				'amount' => '10,000',
				'last_change_datetime' => '2016-07-07 00:05:14',
				'status' => '성공'
			),
			'G4HAK3D3Q716OL3D3Q' => array(
				'tid' => 'G4HAK3D3Q716OL3D3Q',
				'user_id' => '112568',
				'pay_type' => '결제',
				'store' => 'google',
				'product_id' => 'jewel_10000',
				'order_id' => '20160711221600',
				'product_type' => 'FNQL002',
				'product' => '보석 10,000',
				'amount' => '10,000',
				'last_change_datetime' => '2016-07-11 22:16:00',
				'status' => '성공'
			)
		);

		echo json_encode( array( $arrResult[$this->input->post('tid')] ), JSON_UNESCAPED_UNICODE);
	}

	public function characterinfo()
	{
		$this->load->view('characterinfo');
	}

	public function characterlist()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$search_type = ( $this->input->post('search_type') == '_player_id' || $this->input->post('search_type') == '_player_name' ? '' : $this->input->post('search_type') ) ;
		$arrUResult = $this->dbBase->selectUserlist( $search_type, $this->input->post('search_value'), null, null )->result_array();

		if ( !empty($arrUResult) )
		{
			if ( $this->input->post('_server_id') == '' || $this->input->post('_server_id') == null )
			{
				$startDB = 0;
				$endDB = count( $this->config->item('GAMEDB') );
			}
			else
			{
				//배열이므로 서버번호에서 -1 해줌
				$startDB = intval( $this->input->post('_server_id') ) - 1;
				$endDB = intval( $this->input->post('_server_id') );
			}
			for ( $i = $startDB; $i < $endDB; $i++ )
			{
				$this->load->model('Model_Master_Game_'.$i, 'dbGame_'.$i);
				$dbName = 'dbGame_'.$i;
				$this->dbGame = $this->$dbName;

				$search_type = ( $this->input->post('search_type') == '_player_id' || $this->input->post('search_type') == '_player_name' ? $this->input->post('search_type') : '' ) ;
				if ( isset($arrResult) )
				{
					foreach ( $this->dbGame->characterlist( $i, $search_type, $this->input->post('search_value'), array_column($arrUResult, '_user_id') )->result_array() as $row )
					{
						$arrResult[] = $row;
					}
				}
				else
				{
					$arrResult = $this->dbGame->characterlist( $i, $search_type, $this->input->post('search_value'), array_column($arrUResult, '_user_id') )->result_array();
				}
			}
		}
		else
		{
			$arrResult = array();
		}

		$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
		$arrXml = $this->dbBase->xmlinfo()->result_array();
		$url = $arrXml[0]['_location'].'Character_Exp.xml';
		$xml = file_get_contents($url, false, $context);
		$xml = (array)simplexml_load_string($xml);
		foreach ( $xml['Class'] as $key => $val )
		{
			$xml['Class'][$key] = (array)($val);
		}

		foreach( $arrResult as $key => $val )
		{
			$i = 0;
			$search_key							= array_search( $val['_user_id'], array_column($arrUResult, '_user_id') );
			$arrResult[$key]['_user_account']	= $arrUResult[$search_key]['_user_account'];
			$arrResult[$key]['_email']			= $arrUResult[$search_key]['_email'];
			$val['_user_account']			= $arrUResult[$search_key]['_user_account'];
			$val['_email']				= $arrUResult[$search_key]['_email'];
			if ( intval($xml['Class'][$i]['LV']) >= intval($val['_level']) )
			{
				$arrResult[$key]['_prev_total_exp'] = strval(0);
			}
			else
			{
				while ( intval($xml['Class'][$i]['LV']) <= intval($val['_level']) && intval($xml['Class'][$i]['LV']) < 150 )
				{
					$arrResult[$key]['_prev_total_exp'] = strval($xml['Class'][$i]['TOTAL_EXP']);
					$i++;
				}
			}
			$arrResult[$key]['_need_exp'] = strval($xml['Class'][$i]['NEED_EXP']);

			$arrSubResult = $this->dbBase->selectBlocklist( $val['_user_account'] )->result_array();
			if ( !empty($arrSubResult) )
			{
				if ( array_key_exists( '_etime', $val ) )
				{
					if ( strtotime( $val['_etime'] ) < strtotime( $Subrow['_etime'] ) )
					{
						$arrResult[$key]['_etime'] = $Subrow['_etime'];
						$arrResult[$key]['_block_type'] = $Subrow['_block_type'];
					}
				}
				else
				{
					if ( strtotime( $Subrow['_etime'] ) > time() )
					{
						$arrResult[$key]['_etime'] = $Subrow['_etime'];
						$arrResult[$key]['_block_type'] = $Subrow['_block_type'];
					}
					else
					{
						$arrResult[$key]['_etime'] = '';
						$arrResult[$key]['_block_type'] = '';
					}
				}
			}
			else
			{
				$arrResult[$key]['_etime'] = '';
				$arrResult[$key]['_block_type'] = '';
			}
		}

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function adminlog()
	{
		$arrResult = array(
			array(
				'_id' => '1',
				'_datetime' => '2015-12-12 17:23:04',
				'_ip' => '10.10.20.14',
				'_admin_id' => 'rlaxogml01',
				'_player_id' => '112568',
				'_admin_memo' => '불량 캐릭명',
				'_content' => '캐릭터명 수정(홍길동 -> 길동이)'
			)
		);

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function itemlist()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		if ( $this->input->post('_server_id') == '' || $this->input->post('_server_id') == null )
		{
			$startDB = 0;
			$endDB = count( $this->config->item('GAMEDB') );
		}
		else
		{
			//배열이므로 서버번호에서 -1 해줌
			$startDB = intval( $this->input->post('_server_id') ) - 1;
			$endDB = intval( $this->input->post('_server_id') );
		}
		for ( $i = $startDB; $i < $endDB; $i++ )
		{
			$this->load->model('Model_Master_Game_'.$i, 'dbGame_'.$i);
			$dbName = 'dbGame_'.$i;
			$this->dbGame = $this->$dbName;

			if ( isset($arrResult) )
			{
				foreach ( $arrResult = $this->dbGame->itemlist( $this->input->post('_player_id') )->result_array() as $row )
				{
					$arrResult[] = $row;
				}
			}
			else
			{
				$arrResult = $this->dbGame->itemlist( $this->input->post('_player_id') )->result_array();
			}
		}

		if ( !empty( $arrResult ) )
		{
			$arrMResult = $this->dbBase->itemmasterlist( array_column($arrResult, '_item_index'), INVENTORY_TYPE[$this->input->post('type')] )->result_array();
		}
		else
		{
			$arrMResult = array();
		}

		foreach( $arrResult as $key=>$val )
		{
			$search_key = array_search($arrResult[$key]['_item_index'], array_column($arrMResult, '_item_id'));
			if ( $search_key === false )
			{
				unset($arrResult[$key]);
			}
			else
			{
				$arrResult[$key]['_itemrarity'] = $arrMResult[$search_key]['_itemrarity'];
				$val['_itemrarity'] = $arrMResult[$search_key]['_itemrarity'];
				$arrResult[$key]['_itemnamekor'] = $arrMResult[$search_key]['_itemnamekor'];
				$arrResult[$key]['_itemnameeng'] = $arrMResult[$search_key]['_itemnameeng'];
				$arrResult[$key]['_itemnamejpn'] = $arrMResult[$search_key]['_itemnamejpn'];
				$arrResult[$key]['_itemnamechn'] = $arrMResult[$search_key]['_itemnamechn'];
				$arrResult[$key]['_itemnamechn2'] = $arrMResult[$search_key]['_itemnamechn2'];
				$arrResult[$key]['_item_add_info'] = intval($arrResult[$key]['_item_add_info']) & hexdec('0000ffff');
				$arrResult[$key]['_isown'] = intval($arrResult[$key]['_item_add_info']) & hexdec('ffff0000') >> 16;
				for ( $i = 0; $i < 6; $i++ )
				{
					$currentOption = intval($val['_item_option_'.$i]);
					if ( $currentOption != 0 )
					{
						$arrResult[$key]['_item_option_'.$i] = array(
								'grade' => ITEMGRADE[($currentOption & hexdec('f0000000')) >> 28],
								'type' => ITEMOPTIONTYPE[($currentOption & hexdec('0ff00000')) >> 20],
								'value' => $currentOption & hexdec('000fffff')
						);
					}
				}

				$arrResult[$key]['_acquired_time'] = Date('Y-m-d H:i:s', $val['_acquired_time']);
				$arrResult[$key]['_itemrarity'] = ITEMGRADE[$val['_itemrarity']];
				if ( $val['_limit_time'] == '0' )
				{
					$arrResult[$key]['_limit_time'] = '-';
				}
				else
				{
					$arrResult[$key]['_limit_time'] = new DateTime($arrResult[$key]['_acquired_time']);
					$arrResult[$key]['_limit_time']->add( new DateInterval( 'PT'.$val['_limit_time'].'M' ) );
					$arrResult[$key]['_limit_time'] = $arrResult[$key]['_limit_time']->format('Y-m-d H:i:s');
				}
			}
		}
		$arrResult = array_values($arrResult);
		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function storagelist()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		if ( $this->input->post('_server_id') == '' || $this->input->post('_server_id') == null )
		{
			$startDB = 0;
			$endDB = count( $this->config->item('GAMEDB') );
		}
		else
		{
			//배열이므로 서버번호에서 -1 해줌
			$startDB = intval( $this->input->post('_server_id') ) - 1;
			$endDB = intval( $this->input->post('_server_id') );
		}
		for ( $i = $startDB; $i < $endDB; $i++ )
		{
			$this->load->model('Model_Master_Game_'.$i, 'dbGame_'.$i);
			$dbName = 'dbGame_'.$i;
			$this->dbGame = $this->$dbName;

			if ( isset($arrResult) )
			{
				foreach ( $arrResult = $this->dbGame->storagelist( $this->input->post('_player_id') )->result_array() as $row )
				{
					$arrResult[] = $row;
				}
			}
			else
			{
				$arrResult = $this->dbGame->storagelist( $this->input->post('_player_id') )->result_array();
			}
		}
		if ( !empty( $arrResult ) )
		{
			$arrMResult = $this->dbBase->itemmasterlist( array_column($arrResult, '_item_index'), INVENTORY_TYPE['ALL'] )->result_array();
		}
		else
		{
			$arrMResult = array();
		}
		foreach( $arrResult as $key=>$val )
		{
			$search_key = array_search($arrResult[$key]['_item_index'], array_column($arrMResult, '_item_id'));
			$arrResult[$key]['_itemrarity'] = $arrMResult[$search_key]['_itemrarity'];
			$val['_itemrarity'] = $arrMResult[$search_key]['_itemrarity'];
			$arrResult[$key]['_itemnamekor'] = $arrMResult[$search_key]['_itemnamekor'];
			$arrResult[$key]['_itemnameeng'] = $arrMResult[$search_key]['_itemnameeng'];
			$arrResult[$key]['_itemnamejpn'] = $arrMResult[$search_key]['_itemnamejpn'];
			$arrResult[$key]['_itemnamechn'] = $arrMResult[$search_key]['_itemnamechn'];
			$arrResult[$key]['_itemnamechn2'] = $arrMResult[$search_key]['_itemnamechn2'];
			$arrResult[$key]['_item_add_info'] = intval($arrResult[$key]['_item_add_info']) & hexdec('0000ffff');
			$arrResult[$key]['_isown'] = intval($arrResult[$key]['_item_add_info']) & hexdec('ffff0000') >> 16;
			for ( $i = 0; $i < 6; $i++ )
			{
				$currentOption = intval($val['_item_option_'.$i]);
				if ( $currentOption != 0 )
				{
					$arrResult[$key]['_item_option_'.$i] = array(
							'grade' => ITEMGRADE[($currentOption & hexdec('f0000000')) >> 28],
							'type' => ITEMOPTIONTYPE[($currentOption & hexdec('0ff00000')) >> 20],
							'value' => $currentOption & hexdec('000fffff')
					);
				}
			}

			$arrResult[$key]['_acquired_time'] = Date('Y-m-d H:i:s', $val['_acquired_time']);
			$arrResult[$key]['_itemrarity'] = ITEMGRADE[$val['_itemrarity']];
			if ( $val['_limit_time'] == '0' )
			{
				$arrResult[$key]['_limit_time'] = '-';
			}
			else
			{
				$arrResult[$key]['_limit_time'] = new DateTime($arrResult[$key]['_acquired_time']);
				$arrResult[$key]['_limit_time']->add( new DateInterval( 'PT'.$val['_limit_time'].'M' ) );
				$arrResult[$key]['_limit_time'] = $arrResult[$key]['_limit_time']->format('Y-m-d H:i:s');
			}
		}

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function tracklist()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		if ( $this->input->post('_server_id') == '' || $this->input->post('_server_id') == null )
		{
			$startDB = 0;
			$endDB = count( $this->config->item('GAMEDB') );
		}
		else
		{
			//배열이므로 서버번호에서 -1 해줌
			$startDB = intval( $this->input->post('_server_id') ) - 1;
			$endDB = intval( $this->input->post('_server_id') );
		}
		for ( $i = $startDB; $i < $endDB; $i++ )
		{
			$this->load->model('Model_Master_Game_'.$i, 'dbGame_'.$i);
			$dbName = 'dbGame_'.$i;
			$this->dbGame = $this->$dbName;

			if ( isset($arrResult) )
			{
				foreach ( $arrResult = $this->dbGame->tracklist( $this->input->post('_player_id') )->result_array() as $row )
				{
					$arrResult[] = $row;
				}
			}
			else
			{
				$arrResult = $this->dbGame->tracklist( $this->input->post('_player_id') )->result_array();
			}
		}

		$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
		$arrXml = $this->dbBase->xmlinfo()->result_array();
		$url = $arrXml[0]['_location'].'Map_Dungeon_Data.xml';
		$xml = file_get_contents($url, false, $context);
		$xml = simplexml_load_string($xml);

		foreach( $arrResult as $key => $val )
		{
			for ( $i = 0; $i < count($xml->Class); $i++ )
			{
				if ( $xml->Class[$i]->Index_id == $val['_map_id'] )
				{
					$arrResult[$key] = array_merge($arrResult[$key], array(
							'_dun_name_kor' => $xml->Class[$i]->Dun_Name_Kor->__toString(),
							'_dun_name_eng' => $xml->Class[$i]->Dun_Name_Eng->__toString(),
							'_dun_name_jpn' => $xml->Class[$i]->Dun_Name_Jpn->__toString(),
							'_dun_name_chn' => $xml->Class[$i]->Dun_Name_Cn->__toString(),
							'_dun_name_chn2' => $xml->Class[$i]->Dun_Name_Cn2->__toString(),
							'_dun_grade' => $xml->Class[$i]->Dun_grade->__toString(),
							'_dun_free_count' => $xml->Class[$i]->Dun_Free_Count->__toString(),
							'_dun_max_count' => $xml->Class[$i]->Dun_Max_Count->__toString()
					));
					break;
				}
			}
		}

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function guilddetail()
	{
		if ( $this->input->post('_server_id') == '' || $this->input->post('_server_id') == null )
		{
			$startDB = 0;
			$endDB = count( $this->config->item('GAMEDB') );
		}
		else
		{
			//배열이므로 서버번호에서 -1 해줌
			$startDB = intval( $this->input->post('_server_id') ) - 1;
			$endDB = intval( $this->input->post('_server_id') );
		}
		for ( $i = $startDB; $i < $endDB; $i++ )
		{
			$this->load->model('Model_Master_Game_'.$i, 'dbGame_'.$i);
			$dbName = 'dbGame_'.$i;
			$this->dbGame = $this->$dbName;

			if ( isset($arrResult) )
			{
				foreach ( $arrResult = $this->dbGame->guilddetail( $this->input->post('_guild_name') )->result_array() as $row )
				{
					$arrResult[] = $row;
				}
			}
			else
			{
				$arrResult = $this->dbGame->guilddetail( $this->input->post('_guild_name') )->result_array();
			}
		}

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function guildmemberlist()
	{
		if ( $this->input->post('_server_id') == '' || $this->input->post('_server_id') == null )
		{
			$startDB = 0;
			$endDB = count( $this->config->item('GAMEDB') );
		}
		else
		{
			//배열이므로 서버번호에서 -1 해줌
			$startDB = intval( $this->input->post('_server_id') ) - 1;
			$endDB = intval( $this->input->post('_server_id') );
		}
		for ( $i = $startDB; $i < $endDB; $i++ )
		{
			$this->load->model('Model_Master_Game_'.$i, 'dbGame_'.$i);
			$dbName = 'dbGame_'.$i;
			$this->dbGame = $this->$dbName;

			if ( isset($arrResult) )
			{
				foreach ( $arrResult = $this->dbGame->guildmemberlist( $this->input->post('_guild_name') )->result_array() as $row )
				{
					$arrResult[] = $row;
				}
			}
			else
			{
				$arrResult = $this->dbGame->guildmemberlist( $this->input->post('_guild_name') )->result_array();
			}
		}

		foreach($arrResult as $key => $val)
		{
			$arrResult[$key]['_char_id'] = $this->lang->line(CLASSTYPE[$val['_char_id']]);
			$arrResult[$key]['_grade'] = $this->lang->line(GRADETYPE[$val['_grade']]);
		}

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function maillist()
	{
		if ( $this->input->post('_server_id') == '' || $this->input->post('_server_id') == null )
		{
			$startDB = 0;
			$endDB = count( $this->config->item('GAMEDB') );
		}
		else
		{
			//배열이므로 서버번호에서 -1 해줌
			$startDB = intval( $this->input->post('_server_id') ) - 1;
			$endDB = intval( $this->input->post('_server_id') );
		}
		for ( $i = $startDB; $i < $endDB; $i++ )
		{
			$this->load->model('Model_Master_Game_'.$i, 'dbGame_'.$i);
			$dbName = 'dbGame_'.$i;
			$this->dbGame = $this->$dbName;

			if ( isset($arrResult) )
			{
				foreach ( $arrResult = $this->dbGame->maillist( $this->input->post('_player_id') )->result_array() as $row )
				{
					$arrResult[] = $row;
				}
			}
			else
			{
				$arrResult = $this->dbGame->maillist( $this->input->post('_player_id') )->result_array();
			}
		}

		$itemindexlist = array();
		foreach ( $arrResult as $key => $val )
		{
			$content = json_decode($val['_content'], JSON_UNESCAPED_UNICODE);
			$arrResult[$key]['_type'] = MAILTYPE[$content['type']];
			if ( array_key_exists('items', $content) )
			{
				$i = count($content['items']);
				$arrResult[$key]['items'] = $content['items'];
			}
			else
			{
				$i = 0;
			}
			foreach ( $content as $ckey => $cval )
			{
				if ( $ckey == 'items' )
				{
					continue;
				}
				if ( array_key_exists('items', $arrResult[$key]) === false )
				{
					$arrResult[$key]['items'] = array();
				}

				if ( array_key_exists($ckey, ITEMINDEX) && $cval > 0 )
				{
					array_push($arrResult[$key]['items'], array(
							'id' => -1,
							'index' => ITEMINDEX[$ckey],
							'add_info' => -1,
							'count' => $cval,
							'limit' => -1,
							'acquired' => -1
					));
				}
				$i++;
				unset($arrResult[$key][$ckey]);
			}
			unset($arrResult[$key]['_content']);
			array_push( $itemindexlist, array_column($arrResult[$key]['items'], 'index') );
		}
		$itemindexlist = call_user_func_array('array_merge', $itemindexlist);
		$this->load->model('Model_Master_Base', 'dbBase');
		if ( !empty( $arrResult ) )
		{
			$arrMResult = $this->dbBase->itemmasterlist( $itemindexlist, INVENTORY_TYPE['ALL'] )->result_array();
		}
		else
		{
			$arrMResult = array();
		}

		foreach ( $arrResult as $key => $val )
		{
			foreach( $val['items'] as $ikey => $ival)
			{
				if ( $ival['index'] == 9999999 )
				{
					$arrResult[$key]['items'][$ikey]['_itemnamekor'] = '소셜포인트';
					$arrResult[$key]['items'][$ikey]['_itemnameeng'] = 'Social Points';
					$arrResult[$key]['items'][$ikey]['_itemnamejpn'] = 'マジックキー';
					$arrResult[$key]['items'][$ikey]['_itemnamechn'] = '个社交点数';
					$arrResult[$key]['items'][$ikey]['_itemnamechn2'] = '個社交點數';
				}
				else
				{
					$search_key = array_search(array('_item_id' => $ival['index']), $arrMResult);
					$arrResult[$key]['items'][$ikey]['_itemnamekor'] = $arrMResult[$search_key]['_itemnamekor'];
					$arrResult[$key]['items'][$ikey]['_itemnameeng'] = $arrMResult[$search_key]['_itemnameeng'];
					$arrResult[$key]['items'][$ikey]['_itemnamejpn'] = $arrMResult[$search_key]['_itemnamejpn'];
					$arrResult[$key]['items'][$ikey]['_itemnamechn'] = $arrMResult[$search_key]['_itemnamechn'];
					$arrResult[$key]['items'][$ikey]['_itemnamechn2'] = $arrMResult[$search_key]['_itemnamechn2'];
				}
			}
		}
		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function forcedtodisconnect()
	{
		if ( $this->makeSocketConn() )
		{
			$method = CQ_KNOCKING;
			$arrResponse = $this->sendSocketMsg( $method );
			if ( !empty( $arrResponse ) )
			{
				if ( $arrResponse['msg_id'] !== SA_KNOCKING )
				{
					var_export( false );
				}
			}
			else
			{
				var_export( false );
			}

			$method = CQ_LOGIN_ADMIN;
			$arrResponse = $this->sendSocketMsg( $method );
			if ( !empty( $arrResponse ) )
			{
				if ( $arrResponse['msg_id'] !== SA_LOGIN_ADMIN )
				{
					var_export( false );
				}
			}
			else
			{
				var_export( false );
			}

			$method = MSG_SERVER_KICK_USER;
			$arrResponse = $this->sendSocketMsg( $method, $this->input->post('uid') );

			socket_close($this->socket);

			var_export( $arrResponse );
		}
		else
		{
			var_export( false );
		}
	}

	public function changeval()
	{
		$serverIdx = ( is_numeric( $this->input->post('_server_id') ) ? intval( $this->input->post('_server_id') ) - 1 : false );
		if ( $serverIdx === false )
		{
			var_export( false );
		}
		else
		{
			if ( $this->input->post('change_key') == 'email' )
			{
				$this->load->model('Model_Master_Base', 'dbBase');
				$this->dbBase->onBeginTransaction();
				$result = $this->dbBase->changeval( $this->input->post('change_key'), $this->input->post('change_val'), $this->input->post('_player_id'), $this->input->post('_user_id'), $this->input->post('change_val2') );
				$this->dbBase->onEndTransaction( $result );
			}
			else
			{
				if ( $this->input->post('change_key') == 'exp' )
				{
					$this->load->model('Model_Master_Base', 'dbBase');
					$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
					$arrXml = $this->dbBase->xmlinfo()->result_array();
					$url = $arrXml[0]['_location'].'Character_Exp.xml';
					$xml = file_get_contents($url, false, $context);
					$xml = (array)simplexml_load_string($xml);
					foreach ( $xml['Class'] as $key => $val )
					{

						if ( $val->LV == $this->input->post('level') )
						{
							$cur_lev_exp = $val->TOTAL_EXP;
						}
					}

					$this->load->model('Model_Master_Game_'.$serverIdx, 'dbGame_'.$serverIdx);
					$dbName = 'dbGame_'.$serverIdx;

					$this->dbGame = $this->$dbName;
					$this->dbGame->onBeginTransaction();
					$result = $this->dbGame->changeval( $this->input->post('change_key'), $cur_lev_exp + intval($this->input->post('change_val')), $this->input->post('_player_id'), $this->input->post('_user_id'), $this->input->post('change_val2') );
					$this->dbGame->onEndTransaction( $result );
				}
				else
				{
					$this->load->model('Model_Master_Game_'.$serverIdx, 'dbGame_'.$serverIdx);
					$dbName = 'dbGame_'.$serverIdx;

					$this->dbGame = $this->$dbName;
					$this->dbGame->onBeginTransaction();
					$result = $this->dbGame->changeval( $this->input->post('change_key'), $this->input->post('change_val'), $this->input->post('_player_id'), $this->input->post('_user_id'), $this->input->post('change_val2') );
					$this->dbGame->onEndTransaction( $result );
				}
			}
			//$this->dbGame->admin_log( $this->input->post('admin_memo') )
			var_export( $result );
		}
	}
}
