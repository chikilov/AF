<?php
class Model_Master_Base extends MY_Model {
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('master_base', TRUE);
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

	public function selectUsername( $username )
	{
		$query = "select _username from ".$this->config->item('db_prefix')."base.tb_admin_master where _username = ? ";

		$this->db->query( $query, array( $username ) );
		return $this->db->affected_rows();
	}

	public function insertUser( $username, $password, $name, $depart, $reason )
	{
		$query = "insert into ".$this->config->item('db_prefix')."base.tb_admin_master ( _username, _password, _name, _depart, _reason, _ipaddr, _lastchange, _regdate ) value ";
		$query .= "( ?, password(?), ?, ?, ?, ?, now(), now() ) ";

		$this->db->query( $query, array( $username, $password, $name, $depart, $reason, $this->input->server('REMOTE_ADDR') ) );
		return $this->db->affected_rows();
	}

	public function selectUser( $username, $password )
	{
		$query = "select _username, _auth, _lastchange from ".$this->config->item('db_prefix')."base.tb_admin_master where _username = ? and _password = password(?) and _deleted = 0 and _approved = 1 ";

		return $this->db->query( $query, array( $username, $password ) );
	}

	public function updatePassword( $username, $password )
	{
		$query = "update ".$this->config->item('db_prefix')."base.tb_admin_master set _password = password(?), _lastchange = NOW() where _username = ? ";

		$this->db->query( $query, array( $password, $username ) );
		return $this->db->affected_rows();
	}

	public function selectUserlist( $searchtype, $searchval, $daterange1, $daterange2 )
	{
		$addquery = '';
		$query = "select _user_id, _user_account, _email, _birth_datetime, _create_type from ".$this->config->item('db_prefix')."base.tb_user ";
		if ( $searchtype != '' && $searchval != '' )
		{
			$addquery .= "where ".$searchtype." = '".$searchval."' ";
		}

		if ( $daterange1 != '' && $daterange2 != '' )
		{
			if ( $addquery == '' )
			{
				$addquery .= "where ";
			}
			else
			{
				$addquery .= "and ";
			}
			$addquery .= "_birth_datetime between '".$daterange1." 00:00:00.000' and '".$daterange2." 23:59:59.999' ";
		}

		return $this->db->query( $query.$addquery, array() );
	}

	public function selectBlocklist( $useraccount )
	{
		$query = "select _id, _account, _device_id, _block_type, _itime, _etime from ".$this->config->item('db_prefix')."base.tb_block_list where _account = ? ";

		return $this->db->query( $query, array( $useraccount ) );
	}

	public function changeval( $table, $column, $val, $where, $condition, $id )
	{
		$query = "update ".$this->config->item('db_prefix')."base.".$table." set ";
		foreach ( $column as $cKey => $cRow )
		{
			if ( $condition == 'or' )
			{
				$query .= $cRow." = if( ".$where[$cKey]." = '".$id."', '".$val."', ".$cRow." )";
			}
			else
			{
				$query .= $cRow." = '".$val[$cKey]."'";
			}

			if ( $cRow != end($column) )
			{
				$query .= ", ";
			}
			else
			{
				$query .= " ";
			}
		}
		$query .= "where ";
		foreach ( $where as $wKey => $wRow )
		{
			$query .= $wRow." = '".$id."' ";
			if ( $wRow != end($where) )
			{
				$query .= $condition." ";
			}
		}

		return $this->db->query( $query );
	}

	public function xmlinfo()
	{
		$query = "select _location from ".$this->config->item('db_prefix')."base.tb_xml ";

		return $this->db->query( $query, array() );
	}

	public function menulist()
	{
		$query = "select a._title_".$this->session->userdata('language')." as _title, a._controller, a._view, a._icon, a._require_login ";
		$query .= "from ".$this->config->item('db_prefix')."base.tb_admin_menu as a ";
		$query .= "inner join ".$this->config->item('db_prefix')."base.tb_admin_auth as b on b._group_id = '".$this->session->userdata('admin_auth')."' and a._id = b._menu_id ";
		$query .= "where a._active = 1 and b._auth_view = 1 order by a._order asc ";

		return $this->db->query( $query, array() );
	}

	public function grouplist()
	{
		$query = "select _id, _title_kr, _title_en from ".$this->config->item('db_prefix')."base.tb_admin_menu ";
		$query .= "where _controller is null and _view is null group by _id, _title_kr, _title_en ";

		return $this->db->query( $query, array() );
	}

	public function menufulllist()
	{
		$query = "select a._id, a._title_kr, a._title_en, a._controller, a._view, a._icon, a._order, a._require_login, a._parent_id, ";
		$query .= "a._active, b._title_kr as _group_name_kr, b._title_en as _group_name_en, count(c._id) as _sub_count ";
		$query .= "from ".$this->config->item('db_prefix')."base.tb_admin_menu as a ";
		$query .= "left outer join ".$this->config->item('db_prefix')."base.tb_admin_menu as b on a._parent_id = b._id ";
		$query .= "left outer join ".$this->config->item('db_prefix')."base.tb_admin_menu as c on a._id = c._parent_id ";
		$query .= "group by a._id, a._title_kr, a._title_en, a._controller, a._view, a._icon, a._order, a._require_login, a._parent_id, ";
		$query .= "a._active, b._title_kr, b._title_en order by a._order asc ";

		return $this->db->query( $query, array() );
	}

	public function menudetails( $id )
	{
		$query = "select _id, _title_kr, _title_en, _controller, _view, _icon, _order, _parent_id, _active ";
		$query .= "from ".$this->config->item('db_prefix')."base.tb_admin_menu ";
		$query .= "where _id = '".$id."' ";

		return $this->db->query( $query, array() );
	}

	public function menudel( $id )
	{
		$query = "update ".$this->config->item('db_prefix')."base.tb_admin_menu set _active = 0 where _id = '".$id."' ";

		$this->db->query( $query, array() );
		return $this->db->affected_rows();
	}

	public function menuinsert( $_title_kr, $_title_en, $_controller, $_view, $_icon, $_group_id, $_active )
	{
		$query = "insert into ".$this->config->item('db_prefix')."base.tb_admin_menu ( _title_kr, _title_en, _controller, _view, _icon, _order, _require_login, _parent_id, _active ) ";
		$query .= "values ( '".$_title_kr."', '".$_title_en."', if( '".$_controller."' = '', null, '".$_controller."'), if( '".$_view."' = '', null, '".$_view."'), ";
		$query .= "if( '".$_icon."' = '', null, '".$_icon."'), 100, 1, ";
		$query .= "if( '".$_group_id."' = '', null, if( '".$_group_id."' = '0', ( ";
		$query .= "select auto_increment from information_schema.tables where table_name = 'tb_admin_menu' and table_schema = '".$this->config->item('db_prefix')."base' ";
		$query .= "), '".$_group_id."' ) ), '".$_active."' ) ";

		$this->db->query( $query, array() );
		return $this->db->insert_id();
	}

	public function menuupdate( $_title_kr, $_title_en, $_controller, $_view, $_icon, $_group_id, $_active, $_id )
	{
		$query = "update ".$this->config->item('db_prefix')."base.tb_admin_menu set ";
		$query .= "_title_en = '".$_title_en."', _title_kr = '".$_title_kr."', _controller = if( '".$_controller."' = '', null, '".$_controller."'), ";
		$query .= "_view = if( '".$_view."' = '', null, '".$_view."'), _icon = if( '".$_icon."' = '', null, '".$_icon."'), ";
		$query .= "_require_login = 1, _parent_id = '".$_group_id."', _active = '".$_active."' ";
		$query .= "where _id = '".$_id."' ";

		$this->db->query( $query, array() );
		return $this->db->affected_rows();
	}

	public function menuorder( $_id, $_order )
	{
		$query = "update ".$this->config->item('db_prefix')."base.tb_admin_menu set ";
		$query .= "_order = '".$_order."' where _id = '".$_id."' ";

		$this->db->query( $query, array() );
		return $this->db->affected_rows();
	}

	public function accountlist()
	{
		$query = "select a._username, a._name, a._depart, a._regdate, a._approved, a._ipaddr, b._group_name, a._deleted from ".$this->config->item('db_prefix')."base.tb_admin_master as a ";
		$query .= "left outer join ".$this->config->item('db_prefix')."base.tb_admin_group as b on a._auth = b._group_id ";

		return $this->db->query( $query, array() );
	}

	public function accountdetails( $account )
	{
		$query = "select _username, _name, _depart, _auth, _reason, _approved, _deleted from ".$this->config->item('db_prefix')."base.tb_admin_master where _username = '".$account."' ";

		return $this->db->query( $query, array() );
	}

	public function admingrouplist()
	{
		$query = "select _group_id, _group_name, _group_applies from ".$this->config->item('db_prefix')."base.tb_admin_group ";

		return $this->db->query( $query, array() );
	}

	public function accountupdate( $_username, $_name, $_reason, $_depart, $_auth, $_approved, $_deleted )
	{
		$query = "update ".$this->config->item('db_prefix')."base.tb_admin_master set ";
		$query .= "_username = '".$_username."', ";
		$query .= "_name = '".$_name."', ";
		$query .= "_reason = '".$_reason."', ";
		$query .= "_depart = '".$_depart."', ";
		$query .= "_auth = '".$_auth."', ";
		if ( $_deleted == '1' )
		{
			$query .= "_deleted = '".$_deleted."', ";
			$query .= "_deldate = now(), ";
		}
		$query .= "_approved = '".$_approved."' ";
		$query .= "where _username = '".$_username."' ";

		$this->db->query( $query, array() );
		return $this->db->affected_rows();
	}

	public function accountpassword( $_username )
	{
		$query = "update ".$this->config->item('db_prefix')."base.tb_admin_master set ";
		$query .= "_password = password('".date('Ymd')."'), ";
		$query .= "_lastchange = date_add(now(), interval -3 month) ";
		$query .= "where _username = '".$_username."' ";

		$this->db->query( $query, array() );
		return $this->db->affected_rows();
	}

	public function admingroupauth( $group_id )
	{
		$query = "select b._id, a._title_en as _mtitle_en, a._title_kr as _mtitle_kr, b._title_en as _stitle_en, b._title_kr as _stitle_kr, ";
		$query .= "ifnull(c._auth_view, 0) as _auth_view, ifnull(c._auth_write, 0) as _auth_write ";
		$query .= "from ".$this->config->item('db_prefix')."base.tb_admin_menu as a ";
		$query .= "inner join ".$this->config->item('db_prefix')."base.tb_admin_menu as b on a._id = b._parent_id and b._id != b._parent_id ";
		$query .= "left outer join ".$this->config->item('db_prefix')."base.tb_admin_auth as c on b._id = c._menu_id and c._group_id = ? order by b._order asc ";

		return $this->db->query( $query, array( $group_id ) );
	}

	public function adminauthupdate( $group_id, $id, $view, $write )
	{
		$query = "insert into ".$this->config->item('db_prefix')."base.tb_admin_auth values ( ?, ?, if( ? = 'true', 1, 0), if( ? = 'true', 1, 0), now() ) ";
		$query .= "on duplicate key update _auth_view = if( ? = 'true', 1, 0), _auth_write = if( ? = 'true', 1, 0), _regdate = now() ";

		$this->db->query( $query, array( $group_id, $id, $view, $write, $view, $write ) );
		return $this->db->affected_rows();
	}

	public function adminauthparentupdate( $group_id, $id, $view, $write )
	{
		$query = "insert into ".$this->config->item('db_prefix')."base.tb_admin_auth values ";
		$query .= "( ?, ( select _parent_id from ".$this->config->item('db_prefix')."base.tb_admin_menu where _id = ? ), if( ? = 'true', 1, 0), if( ? = 'true', 1, 0), now() ) ";
		$query .= "on duplicate key update _auth_view = if( ? = 'true', 1, 0), _auth_write = if( ? = 'true', 1, 0), _regdate = now() ";

		$this->db->query( $query, array( $group_id, $id, $view, $write, $view, $write ) );
		return $this->db->affected_rows();
	}

	public function adminauthparentvalue( $group_id )
	{
		$query = "select a._parent_id, sum(b._auth_view) as sumval from tb_admin_menu as a inner join tb_admin_auth as b on a._id = b._menu_id ";
		$query .= "where b._group_id = ? and a._id != a._parent_id group by a._parent_id ";

		return $this->db->query( $query, array( $group_id ) );
	}

	public function groupnamecheck( $group_name )
	{
		$query = "select _group_id from ".$this->config->item('db_prefix')."base.tb_admin_group where _group_name = ? ";

		$this->db->query( $query, array( $group_name ) );
		return $this->db->affected_rows();
	}

	public function authgroupinsert( $group_name, $group_applies )
	{
		$query = "insert into ".$this->config->item('db_prefix')."base.tb_admin_group ( _group_name, _group_applies, _regdate, _admin_id ) values ( ?, ?, now(), ? ) ";

		$this->db->query( $query, array( $group_name, $group_applies, $this->session->userdata('admin_id') ) );
		return $this->db->insert_id();
	}

	public function authdelete( $group_id )
	{
		$query = "delete from ".$this->config->item('db_prefix')."base.tb_admin_auth where _group_id = ? ";

		$this->db->query( $query, array( $group_id ) );
		return $this->db->affected_rows();
	}

	public function authgroupdelete( $group_id )
	{
		$query = "delete from ".$this->config->item('db_prefix')."base.tb_admin_group where _group_id = ? ";

		$this->db->query( $query, array( $group_id ) );
		return $this->db->affected_rows();
	}

	public function checkpass( $_password )
	{
		$query = "select _username from ".$this->config->item('db_prefix')."base.tb_admin_master where _username = ? and _password = password(?) ";

		$this->db->query( $query, array( $this->session->userdata('admin_id'), $_password ) );
		return $this->db->affected_rows();
	}

	public function maxpresentgroup()
	{
		$query = "lock tables ".$this->config->item('db_prefix')."base.tb_present_load_group ";

		$this->db->query( $query, array() );

		$query = "select ifnull(max(_group_id), 0) + 1 as _group_id from ".$this->config->item('db_prefix')."base.tb_present_load_group ";

		return $this->db->query( $query, array() );
	}

	public function insertpresentgroup( $_group_id, $rowData )
	{
		$query = "insert into ".$this->config->item('db_prefix')."base.tb_present_load_group ( _group_id, _server_id, _player_id ) values ";
		$result = 0;
		foreach( $rowData as $row )
		{
			$squery = $query."( '".$_group_id."', '".$row[0]."', '".$row[2]."' )";
			if ( $this->db->query($squery) )
			{
				$result += $this->db->affected_rows();
			}
			else
			{
				$query = "unlock tables ";

				$this->db->query( $query, array() );
				return $result;
			}
		}
		$query = "unlock tables ";

		$this->db->query( $query, array() );

		return $result;
	}

	public function presentinsert(
			$_group_id, $_item_id, $_item_count, $_exp, $_gold, $_cash, $_point, $_free_cash, $_gemstone, $_crystal, $_soulstone, $_marble, $_battle_point,
			$_title, $_contents, $_sendtime, $_expiretime, $_admin_memo, $_url
	)
	{
		$query = "insert into ".$this->config->item('db_prefix')."base.tb_admin_present ";
		$query .= "( _group_id, _item_id, _item_count, _exp, _gold, _cash, _point, _free_cash, _gemstone, _crystal, _soulstone, _marble, _battle_point, ";
		$query .= "_title, _contents, _sendtime, _expiretime, _admin_memo, _url, _admin_id ) values ";
		$query .= "( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";

		$this->db->query( $query, array(
				$_group_id, $_item_id, $_item_count, $_exp, $_gold, $_cash, $_point, $_free_cash, $_gemstone, $_crystal, $_soulstone, $_marble, $_battle_point,
				$_title, $_contents, $_sendtime, ( $_expiretime == '' ? null : $_expiretime ), $_admin_memo, $_url, $this->session->userdata('admin_id')
		) );

		return $this->db->affected_rows();
	}

	public function stringcomp( $result, $strcomp )
	{
		$query = "select result from ( select '".$result."' as result from dual ) as a where '".$result."' like '".$strcomp."' ";

		$this->db->query( $query, array( $result, $result, $strcomp ) );
		return $this->db->affected_rows();
	}

	public function presentlist()
	{
		$query = "select a._group_id, a._item_id, a._item_count, a._title, a._contents, a._sendtime, a._expiretime, a._admin_memo, a._url, a._admin_id, a._is_valid, a._is_recall, ";
		$query .= "a._exp, a._gold, a._cash, a._point, a._free_cash, a._gemstone, a._crystal, a._soulstone, a._marble, a._battle_point, ";
		$query .= "if( a._sendtime < now(), 1, 0 ) as _status, count(b._player_id) as _total, sum(if(b._is_send = 0, 1, 0)) as _fail, sum(if(b._is_send = 1, 1, 0)) as _success, ";
		$query .= "sum(if(b._is_recall = 1, 1, 0)) as _recall ";
		$query .= "from ".$this->config->item('db_prefix')."base.tb_admin_present as a ";
		$query .= "inner join ".$this->config->item('db_prefix')."base.tb_present_load_group as b on a._group_id = b._group_id ";
		$query .= "group by a._group_id, a._item_id, a._item_count, a._title, a._contents, a._sendtime, a._expiretime, a._admin_memo, a._url, a._admin_id, a._sendtime ";

		return $this->db->query( $query, array() );
	}

	public function presentupdatejob( $_group_id, $job_id )
	{
		$query = "update ".$this->config->item('db_prefix')."base.tb_admin_present set _job_id = '".$job_id."' where _group_id = '".$_group_id."' ";

		$this->db->query( $query, array() );
		return $this->db->affected_rows();
	}

	public function loadgrouplist( $_group_id )
	{
		$query = "select _server_id, _player_id from ".$this->config->item('db_prefix')."base.tb_present_load_group where _group_id = '".$_group_id."' ";

		return $this->db->query( $query, array() );
	}

	public function loadgroupcomplist( $_group_id )
	{
		$query = "select _server_id, _player_id, _is_send, _is_recall from ".$this->config->item('db_prefix')."base.tb_present_load_group where _group_id = '".$_group_id."' ";

		return $this->db->query( $query, array() );
	}

	public function presentjobid( $_group_id )
	{
		$query = "select _job_id from ".$this->config->item('db_prefix')."base.tb_admin_present ";
		$query .= "where _group_id = '".$_group_id."' ";

		return $this->db->query( $query, array() );
	}

	public function presentdelete( $_group_id )
	{
		$query = "update ".$this->config->item('db_prefix')."base.tb_admin_present set _is_valid = 0 where _group_id = '".$_group_id."' ";

		$this->db->query( $query, array() );
		return $this->db->affected_rows();
	}

	public function presentrecall( $_group_id, $_server_id, $_player_id )
	{
		$query = "update ".$this->config->item('db_prefix')."base.tb_present_load_group set _is_recall = 1 ";
		$query .= "where _group_id = '".$_group_id."' and _server_id = '".$_server_id."' and _player_id = '".$_player_id."' ";

		$this->db->query( $query, array() );
		return $this->db->affected_rows();
	}

	public function grouprecall( $_group_id )
	{
		$query = "update ".$this->config->item('db_prefix')."base.tb_admin_present set _is_recall = 1 where _group_id = '".$_group_id."' ";

		$this->db->query( $query, array() );
		return $this->db->affected_rows();
	}

	public function loadauth( $uri )
	{
		$query = "select a._auth_view, a._auth_write ";
		$query .= "from ".$this->config->item('db_prefix')."base.tb_admin_auth as a ";
		$query .= "left outer join ".$this->config->item('db_prefix')."base.tb_admin_master as b on a._group_id = b._auth ";
		$query .= "left outer join ".$this->config->item('db_prefix')."base.tb_admin_menu as c on a._menu_id = c._id ";
		$query .= "where b._username = ? and c._controller = ? and c._view = ? ";

		return $this->db->query( $query, array( $this->session->userdata('admin_id'), $uri[0], $uri[1] ) );
	}

	public function selecteventnotice()
	{
		$query = "select _id, _type, _target, _target_id, _time_stay_target, _title, _fixed_time, _time_start_day, _time_start_time, _time_end, _time_end_time ";
		$query .= "from ".$this->config->item('db_prefix')."base.tb_event_notice ";

		return $this->db->query( $query, array() );
	}

	public function contentstatus()
	{
		$query = "select _csflag from ".$this->config->item('db_prefix')."base.tb_contents_status ";

		return $this->db->query( $query, array() );
	}

	public function contentupdate( $pmval )
	{
		$query = "update ".$this->config->item('db_prefix')."base.tb_contents_status set _csflag = _csflag + ('".$pmval."') ";

		$this->db->query( $query, array() );
		return $this->db->affected_rows();
	}
}
?>