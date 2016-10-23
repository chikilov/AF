<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Present extends MY_Controller {

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
				$this->lang->load('Present_lang', $this->config->item('language') );
			}
			else
			{
				$this->lang->load('Present_lang', $this->session->userdata('language') );
			}
		}
		else
		{
			$this->lang->load('Present_lang', $this->config->item('language') );
		}
	}

	public function index()
	{
		$this->load->view( 'login' );
	}

	public function massivepresent()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
		$arrXml = $this->dbBase->xmlinfo()->result_array();
		$url = $arrXml[0]['_location'].'Localization.xml';
		$xml = file_get_contents($url, false, $context);
		$xml = (array)simplexml_load_string($xml);

		$arrMsg = array();
		foreach ( $xml['Class'] as $key => $val )
		{
			if ( $val->index->__toString() == 'Post' )
			{
				array_push($arrMsg, (array)$val);
			}
		}
		$arrAuth = $this->checkAuth();
		$this->load->view( 'massivepresent', array( 'arrTitle' => $arrMsg, 'arrAuth' => $arrAuth ) );
	}

	public function searchitem()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
        $arrResult = $this->SresultFromRedis( $this->redis, 'MASTER_ITEM', $this->input->post('_item_id') );
        $typeArr = INVENTORY_TYPE['ALL'];
        if ( array_key_exists( 'subtype', $typeArr ) )
        {
            unset( $typeArr['subtype'] );
        }

        foreach ( $arrResult as $key => $val )
        {
            if ( in_array( $val['ITEMTYPE'], $typeArr ) === false )
            {
                unset( $arrResult[$key] );
            }
        }

        $arrResult = array_values( $arrResult );
		echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
	}

	public function checkpass()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		var_export( boolval( $this->dbBase->checkpass( $this->input->post('_password') ) ) );
	}

	public function userfileupload()
	{
		$error = false;
		$uploaddir = '/var/www/html/upload/xls/';
	    $OriginalFilename = $FinalFilename = date('YmdHis').'_'.$_FILES[0]['name'];
	    $FileCounter = 1;
		while ( file_exists( $uploaddir.$FinalFilename ) )
		{
			$FinalFilename = pathinfo($OriginalFilename, PATHINFO_FILENAME) . '_' . $FileCounter++ . '.' . pathinfo($OriginalFilename, PATHINFO_EXTENSION);
		}

        if (move_uploaded_file($_FILES[0]['tmp_name'], $uploaddir.$FinalFilename))
        {
            $files = $uploaddir.$FinalFilename;
        }
        else
        {
            $error = true;
        }

	    if ( $error )
	    {
		    var_export(false);
		    exit;
	    }
	    else
	    {
			$this->load->library("PHPExcel");
			$objPHPExcel = new PHPExcel();
			$objPHPExcel = PHPExcel_IOFactory::load($uploaddir.$FinalFilename);
			$sheetsCount = $objPHPExcel->getSheetCount();

			$rowData = array();
			/* 시트별로 읽기 */
			for($i = 0; $i < $sheetsCount; $i++)
			{
			    $objPHPExcel->setActiveSheetIndex($i);
			    $sheet = $objPHPExcel->getActiveSheet();
			    $highestRow = $sheet->getHighestRow();
			    $highestColumn = $sheet->getHighestColumn();

			    /* 한줄읽기 */
			    for ($row = 1; $row <= $highestRow; $row++)
			    {
			        /* $rowData가 한줄의 데이터를 셀별로 배열처리 됩니다. */
			        if ( $row == 1 )
			        {
				    	$first = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
				    	if ( $first[0] != array( '_server_id', '_player_name', '_player_id' ) )
				    	{
					    	echo PHP_EOL.$this->lang->line('error_occur').'0'.$this->lang->line('line_number');
					    	exit;
				    	}
			        }
			        else
			        {
				        $currentRow = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
				        if ( $currentRow[0][0] == '' || $currentRow[0][0] == null || $currentRow[0][2] == '' || $currentRow[0][2] == null )
				        {
					    	echo PHP_EOL.$this->lang->line('error_occur').$row.$this->lang->line('line_number');
					    	exit;
				        }
				        else
				        {
			        		array_push($rowData, $currentRow[0] );
			        	}
			        }
			    }
			}
			$this->load->model('Model_Master_Base', 'dbBase');
			$seq = $this->dbBase->maxpresentgroup()->result_array();
			$result = $this->dbBase->insertpresentgroup( $seq[0]['_group_id'], $rowData );
			if ( $result == count( $rowData ) )
			{
				echo json_encode( array( array( '_group_id' => $seq[0]['_group_id'], '_group_count' => (string)$result ) ), JSON_UNESCAPED_UNICODE );
			}
			else
			{
				echo PHP_EOL.$this->lang->line('error_occur').($result + 1).'/'.count($rowData).$this->lang->line('line_number');
			}
	    }
	}

	public function presentaction()
	{
		if ( $this->input->post('_send') == '0' )
		{
			$cronDate = new DateTime();
			$cronDate = $cronDate->add( new DateInterval( 'PT10M' ) );
		}
		else
		{
			$cronDate = new DateTime( $this->input->post('_sendtime') );
			$cronDate = $cronDate;
		}

		$this->load->model('Model_Master_Base', 'dbBase');
		$result = $this->dbBase->presentinsert(
				$this->input->post('_group_id'), $this->input->post('_item_id'), $this->input->post('_item_count'), $this->input->post('_exp'),
				$this->input->post('_gold'), $this->input->post('_cash'), $this->input->post('_point'), $this->input->post('_free_cash'),
				$this->input->post('_gemstone'), $this->input->post('_crystal'), $this->input->post('_soulstone'), $this->input->post('_marble'),
				$this->input->post('_battle_point'), $this->input->post('_title'), $this->input->post('_contents'), $cronDate->format('Y-m-d H:i:00'),
				$this->input->post('_expiretime'), $this->input->post('_admin_memo'), $this->input->post('_url')
		);

		$this->load->model('Model_Master_Log', 'dbLog');
		$this->dbLog->adminlogins( 0, 0, '', '일괄지급( _group_id => '.$this->input->post('_group_id').', _item_id => '.$this->input->post('_item_id').', _item_count => '.$this->input->post('_item_count').', _exp => '.$this->input->post('_exp').', _gold => '.$this->input->post('_gold').', _cash => '.$this->input->post('_cash').', _point => '.$this->input->post('_point').', _free_cash => '.$this->input->post('_free_cash').', _gemstone => '.$this->input->post('_gemstone').', _crystal => '.$this->input->post('_crystal').', _soulstone => '.$this->input->post('_soulstone').', _marble => '.$this->input->post('_marble').', _battle_point => '.$this->input->post('_battle_point').', _title => '.$this->input->post('_title').', _contents => '.$this->input->post('_contents').', _sendtime => '.$cronDate->format('Y-m-d H:i:00').', _expiretime => '.$this->input->post('_expiretime').', _admin_memo => '.$this->input->post('_admin_memo').', _url => '.$this->input->post('_url').' )' );
		if ( $result )
		{
			$file = fopen('/var/www/html/upload/cmd/cli_script_'.$this->input->post('_group_id').'.sh', 'w+');
			fwrite($file, '#!/bin/bash'.PHP_EOL);
			fwrite($file, '/usr/bin/php /var/www/html/cli_script.php '.$this->input->post('_group_id').' >> /var/www/html/upload/log/at_exec_log_'.$this->input->post('_group_id').'.log 2>&1');
			fclose($file);
			chmod('/var/www/html/upload/cmd/cli_script_'.$this->input->post('_group_id').'.sh', 0777);
			exec('at -f "/var/www/html/upload/cmd/cli_script_'.$this->input->post('_group_id').'.sh" '.$cronDate->format('H:i Y-m-d').' 2>&1 ', $result, $resnum );

			if ( $this->dbBase->stringcomp( (string)$result[0], 'job % at '.$cronDate->format('Y-m-d H:i') ) > 0 )
			{
				$job_id = str_replace( ' at '.$cronDate->format('Y-m-d H:i'), '', str_replace( 'job ', '', (string)$result[0] ) );
				if ( is_numeric($job_id) )
				{
					if ( $this->dbBase->presentupdatejob( $this->input->post('_group_id'), $job_id ) )
					{
						var_export(true);
					}
					else
					{
						exec('atrm '.$job_id );
						var_export(false);
					}
				}
				else
				{
					var_export(false);
				}
			}
			else
			{
				var_export(false);
			}
		}
		else
		{
			var_export(false);
		}
	}

	public function massivelist()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrResult = $this->dbBase->presentlist()->result_array();
		foreach ( $arrResult as $key => $row )
		{
			$arrItem = $this->SresultFromRedis( $this->redis, 'MASTER_ITEM', $row['_item_id'] )[0];
			if ( is_array($arrItem) )
			{
	        	$arrResult[$key] = array_merge( $row, $arrItem );
	        }
	        else
	        {
				$arrItem = array( 'ITEMNAMEKOR' => $row['_item_id'], 'ITEMNAMEENG' => $row['_item_id'] );
				$arrResult[$key] = array_merge( $row, $arrItem );
	        }
		}
		echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
	}

	public function grouplist( $_group_id )
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrResult = $this->dbBase->loadgrouplist( $_group_id )->result_array();

		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", "_server_id")->setCellValue("B1", "_player_name")->setCellValue("C1", "_player_id");
		for ( $i = 2; $i <= count($arrResult) + 1; $i++ )
		{
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A".$i, $arrResult[$i - 2]['_server_id'])->setCellValue("B".$i, '')->setCellValue("C".$i, $arrResult[$i - 2]['_player_id']);
		}

		$this->load->model('Model_Master_Log', 'dbLog');
		$this->dbLog->adminlogins( 0, 0, '', '유저 리스트 다운로드 ( _group_id => '.$_group_id.' )' );
		$filename = iconv('UTF-8', 'EUC-KR', 'group_list_'.$_group_id);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
	}

	public function groupcomplist( $_group_id )
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrResult = $this->dbBase->loadgroupcomplist( $_group_id )->result_array();

		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", "_server_id")->setCellValue("B1", "_player_name")->setCellValue("C1", "_player_id")->setCellValue("D1", "_is_send")->setCellValue("D1", "_is_recall");
		for ( $i = 2; $i <= count($arrResult) + 1; $i++ )
		{
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A".$i, $arrResult[$i - 2]['_server_id'])->setCellValue("B".$i, '')->setCellValue("C".$i, $arrResult[$i - 2]['_player_id'])->setCellValue("D".$i, $arrResult[$i - 2]['_is_send'])->setCellValue("D".$i, $arrResult[$i - 2]['_is_recall']);
		}

		$this->load->model('Model_Master_Log', 'dbLog');
		$this->dbLog->adminlogins( 0, 0, '', '유저 리스트 다운로드 ( _group_id => '.$_group_id.' )' );
		$filename = iconv('UTF-8', 'EUC-KR', 'group_result_'.$_group_id);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
	}

	public function massivedelete()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrResult = $this->dbBase->presentjobid( $this->input->post('_group_id') )->result_array();
		$job_id = $arrResult[0]['_job_id'];
		$qRes = $this->dbBase->presentdelete( $this->input->post('_group_id') );

		if ( $qRes == 1 && is_numeric($job_id) && (int)$job_id > 0 )
		{
			$file = '/var/www/html/upload/cmd/cli_script_'.$this->input->post('_group_id').'.sh';
			$newfile = '/var/www/html/upload/cmd/back_cli_script_'.$this->input->post('_group_id').'.sh';
			if ( file_exists( $file ) ) { rename( $file, $newfile ); }
			exec('atrm '.$job_id, $result, $resnum );

			if ( empty($result) )
			{
				$this->load->model('Model_Master_Log', 'dbLog');
				$this->dbLog->adminlogins( 0, 0, '', '일괄지급 삭제 ( _group_id => '.$this->input->post('_group_id').' )' );
				var_export(true);
			}
			else
			{
				var_export(false);
			}
		}
		else
		{
			var_export(false);
		}
	}

	public function massiverecall()
	{
		$this->load->model('Model_Master_Base', 'dbBase');
		$arrResult = $this->dbBase->loadgrouplist( $this->input->post('_group_id') )->result_array();
		$arrReturn = array( 'total' => count( $arrResult ), 'exec' => 0 );
		$arrServer = array_unique( array_column( $arrResult, '_server_id' ) );
		$startDB = 0;
		$endDB = count( $this->config->item('GAMEDB') );
		$this->dbBase->grouprecall( $this->input->post('_group_id') );

		$arrDivide = array();
		for ( $i = $startDB; $i < $endDB; $i++ )
		{
			$this->load->model('Model_Master_Game_'.$i, 'dbGame_'.$i);
			$arrDivide[$i] = array_filter($arrResult, function ($val) use ($i) { return ( (string)$val['_server_id'] == (string)( $i + 1 ) ); });
		}

		foreach ( $arrDivide as $key => $val )
		{
			$dbName = 'dbGame_'.$key;
			$this->dbGame = $this->$dbName;

			$this->dbGame->onBeginTransaction();
			$this->dbBase->onBeginTransaction();
			foreach ( $val as $sval )
			{
				if ( $this->dbGame->recallmail( $this->input->post('_group_id'), $sval['_player_id'] ) )
				{
					if ( $this->dbBase->presentrecall( $this->input->post('_group_id'), ( $key + 1 ), $sval['_player_id'] ) )
					{
						$arrReturn['exec']++;
					}
					else
					{
						continue;
					}
				}
				else
				{
					continue;
				}
			}
			$this->dbGame->onEndTransaction( true );
			$this->dbBase->onEndTransaction( true );
		}

		$this->load->model('Model_Master_Log', 'dbLog');
		$this->dbLog->adminlogins( 0, 0, '', '일괄지급 회수 ( _group_id => '.$this->input->post('_group_id').' )' );
		echo json_encode( array( $arrReturn ), JSON_UNESCAPED_UNICODE );
	}

	public function convertdata()
	{
		$this->load->view( 'convertdata', array() );
	}

	public function convertupload()
	{
		$error = false;
		$uploaddir = '/var/www/html/upload/conv/';
	    $OriginalFilename = $FinalFilename = date('YmdHis').'_'.$_FILES[0]['name'];
	    $FileCounter = 1;
		while ( file_exists( $uploaddir.$FinalFilename ) )
		{
			$FinalFilename = pathinfo($OriginalFilename, PATHINFO_FILENAME) . '_' . $FileCounter++ . '.' . pathinfo($OriginalFilename, PATHINFO_EXTENSION);
		}

        if (move_uploaded_file($_FILES[0]['tmp_name'], $uploaddir.$FinalFilename))
        {
            $files = $uploaddir.$FinalFilename;
        }
        else
        {
            $error = true;
        }

	    if ( $error )
	    {
		    var_export(false);
		    exit;
	    }
	    else
	    {
			$this->load->library("PHPExcel");
			$objPHPExcel = new PHPExcel();
			$objPHPExcel = PHPExcel_IOFactory::load($uploaddir.$FinalFilename);
			$sheetsCount = $objPHPExcel->getSheetCount();

			$rowData = array();

			$startDB = 0;
			$endDB = count( $this->config->item('GAMEDB') );
			for ( $i = $startDB; $i < $endDB; $i++ )
			{
				$this->load->model('Model_Master_Game_'.$i, 'dbGame_'.$i);
			}

			/* 시트별로 읽기 */
			for($i = 0; $i < $sheetsCount; $i++)
			{
			    $objPHPExcel->setActiveSheetIndex($i);
			    $sheet = $objPHPExcel->getActiveSheet();
			    $highestRow = $sheet->getHighestRow();
			    $highestColumn = $sheet->getHighestColumn();

			    /* 한줄읽기 */
			    for ($row = 1; $row <= $highestRow; $row++)
			    {
			        /* $rowData가 한줄의 데이터를 셀별로 배열처리 됩니다. */
			        if ( $row == 1 )
			        {
				    	$first = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
				    	if ( $first[0] != array( '_server_id', '_player_name', '_player_id' ) )
				    	{
					    	echo PHP_EOL.$this->lang->line('error_occur').'0'.$this->lang->line('line_number');
					    	exit;
				    	}
			        }
			        else
			        {
				        $currentRow = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
				        if ( $currentRow[0][0] == '' || $currentRow[0][0] == null )
				        {
					    	echo PHP_EOL.$this->lang->line('error_occur').$row.$this->lang->line('line_number');
					    	exit;
				        }
				        else
				        {
							$dbName = 'dbGame_'.( (int)$currentRow[0][0] - 1 );
							$this->dbGame = $this->$dbName;

					        if ( $currentRow[0][1] == '' || $currentRow[0][1] == null )
					        {
						        $arrResult = $this->dbGame->findplayername( $currentRow[0][2] )->result_array();
						        if ( !empty($arrResult) )
						        {
							        $currentRow[0][1] = $arrResult[0]['_player_name'];
						        }
					        }
					        if ( $currentRow[0][2] == '' || $currentRow[0][2] == null )
					        {
						        $arrResult = $this->dbGame->findplayerid( $currentRow[0][1] )->result_array();
						        if ( !empty($arrResult) )
						        {
							        $currentRow[0][2] = $arrResult[0]['_player_id'];
						        }
					        }
			        		array_push($rowData, $currentRow[0] );
			        	}
			        }
			    }
			}

			$this->load->model('Model_Master_Log', 'dbLog');
			$this->dbLog->adminlogins( 0, 0, '', '데이터 변환 ( _Final_Filename => '.$FinalFilename.' )' );
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", "_server_id")->setCellValue("B1", "_player_name")->setCellValue("C1", "_player_id");
			for ( $i = 2; $i <= count($rowData) + 1; $i++ )
			{
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit( 'A'.$i, $rowData[$i - 2][0],PHPExcel_Cell_DataType::TYPE_STRING )->setCellValueExplicit('B'.$i, $rowData[$i - 2][1],PHPExcel_Cell_DataType::TYPE_STRING )->setCellValueExplicit( 'C'.$i, $rowData[$i - 2][2],PHPExcel_Cell_DataType::TYPE_STRING );
			}

			$filename = 'converted_list_'.date('YmdHis').'.xlsx';
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('/var/www/html/upload/expt/'.$filename);

			echo '/upload/expt/'.$filename;
	    }
	}
}
?>