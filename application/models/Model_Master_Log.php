<?php
class Model_Master_Log extends MY_Model {
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('master_log', TRUE);
		$this->db->trans_strict(FALSE);
		$this->db->query("SET NAMES utf8");
	}
	public function __destruct() {
		$this->db->close();
	}
	public function onStartTransaction()
	{
		$this->db->trans_start();
	}
	public function onCompleteTransaction()
    {
        $this->db->trans_complete();
    }
	public function onBeginTransaction()
	{
		$this->db->trans_begin();
	}
	public function onRollbackTransaction()
	{
		$this->db->trans_rollback();
	}
	public function onEndTransaction( $result )
	{
		if ($this->db->trans_status() === FALSE || $result === FALSE)
		{
		    $this->db->trans_rollback();
		}
		else
		{
		    $this->db->trans_commit();
		}
	}

	public function searchlog( $start_date, $end_date, $search_type, $search_value, $log_type )
	{
		$query = "select table_name from information_schema.tables where table_schema = '".$this->config->item('db_prefix')."log' ";
		$query .= "and table_name between 'tb_log_".intval(date('m', strtotime( $start_date.' 00:00:00' )))."' and 'tb_log_".intval(date('m', strtotime( $end_date.' 23:59:59' )))."' ";

		$arrTable = $this->db->query($query);
		if ( $arrTable )
		{
			$arrTable = $arrTable->result_array();
		}

		$selquery = "select _type, _stat, _db_id, _svr_id, _ch_id, _user_name, _user_id, _player_id, _user_id_1, _player_id_1, ";
		$selquery .= "_nvalue0, _nvalue1, _nvalue2, _nvalue3, _nvalue4, _nvalue5, _text1, _text2, _insertdate from ";
		$wherequery = "where ".$search_type." = '".$search_value."' and _type in ( ";
		foreach ( $log_type as $row )
		{
			$wherequery .= "'".array_search( $row, array_column( LOG_TYPE, 'type') )."' ";
			if ( end( $log_type ) !== $row )
			{
				$wherequery .= ", ";
			}
			else
			{
				$wherequery .= ") ";
			}
		}
		$query = "";
		foreach ( $arrTable as $row )
		{
			$query .= $selquery.$this->config->item('db_prefix')."log.".$row['table_name']." ".$wherequery;
			if ( end($arrTable) !== $row )
			{
				$query .= "union all ";
			}
		}

		return $this->db->query( $query, array() );
	}

	public function adminlog( $start_date, $end_date, $search_type, $search_value )
	{
		$query = "select _id, _insertdate, _ip, _admin_id, _user_id, _player_id, _memo, _contents from ".$this->config->item('db_prefix')."log.tb_log_gmtool ";
		$query .= "where _insertdate between '".$start_date." 00:00:00' and '".$end_date." 23:59:59' and ".$search_type." = '".$search_value."' ";

		return $this->db->query( $query, array() );
	}

	public function adminlogins( $user_id, $player_id, $memo, $contents )
	{
		$query = "insert into ".$this->config->item('db_prefix')."log.tb_log_gmtool ( _insertdate, _ip, _admin_id, _user_id, _player_id, _memo, _contents ) values (";
		$query .= "now(), '".$this->input->ip_address()."', '".$this->session->userdata('admin_id')."', '".$user_id."', '".$player_id."', '".$memo."', '".$contents."' ) ";

		$this->db->query( $query, array() )
		return $this->db->affected_rows();
	}
}
?>