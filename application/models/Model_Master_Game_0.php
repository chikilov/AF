<?php
class Model_Master_Game_0 extends MY_Model {
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('master_game_0', TRUE);
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
		$query = "insert into ".$this->config->item('db_prefix')."base.tb_admin_master ( _username, _password, _name, _depart, _reason, _ipaddr ) value ( ?, password(?), ?, ?, ?, ? ) ";

		$this->db->query( $query, array( $username, $password, $name, $depart, $reason, $this->input->server('REMOTE_ADDR') ) );
		return $this->db->affected_rows();
	}

	public function selectUser( $username, $password )
	{
		$query = "select _username, _lastchange from ".$this->config->item('db_prefix')."base.tb_admin_master where _username = ? and _password = password(?) and _deleted = 0 and _approved = 1 ";

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
			$addquery .= "where ".$searchtype." like '%".$searchval."%' ";
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

	public function characterlist( $server_id, $searchtype, $searchval, $arrUserID )
	{
		$query = "select '".$server_id."' as _server_id, a._user_id, a._player_id, a._player_name, a._level, a._exp, a._birth_datetime, a._logon, a._gold, a._gem, a._free_gem, _char_id, ";
		$query .= "a._buddy_max, a._grade, a._valid, a._gem_charge_sum, ifnull(c._name, '') as _guild_name, ifnull(b._point, 0) as _guild_point, count(d._id) as _buddy_count ";
		$query .= "from ".$this->config->item('db_prefix')."game.tb_player as a left outer join ".$this->config->item('db_prefix')."game.tb_guild_player as b on a._player_id = b._player_id ";
		$query .= "left outer join ".$this->config->item('db_prefix')."game.tb_guild as c on b._guild_id = c._id ";
		$query .= "left outer join ".$this->config->item('db_prefix')."game.tb_buddy as d on a._player_id = d._player_id ";
		if ( $searchtype != null && $searchtype != '' && $searchval != null && $searchval != '' )
		{
			if ( $searchtype == '_player_id' )
			{
				$query .= "where a.".$searchtype." = '".$searchval."' ";
			}
			else
			{
				$query .= "where a.".$searchtype." like '%".$searchval."%' and a._user_id in (".implode(',', $arrUserID).") ";
			}
		}
		else
		{
			$query .= "where a._user_id in (".implode(",", $arrUserID).") ";
		}

		$query .= "group by a._user_id, a._player_id, a._player_name, a._level, a._exp, a._birth_datetime, a._logon, a._gold, a._gem, a._free_gem, ";
		$query .= "a._buddy_max, a._grade, ifnull(c._name, ''), ifnull(b._point, 0) order by a._player_id desc ";

		return $this->db->query( $query, array() );
	}

	public function itemlist( $player_id )
	{
		$query = "select b._player_name, a._item_index, a._item_id, a._item_add_info, a._item_option_0, a._item_option_1, a._item_option_2, a._item_option_3, a._item_option_4, a._item_option_5, ";
		$query .= "a._count, a._limit_time, 'N' as _distraint_status, a._acquired_time ";
		$query .= "from ".$this->config->item('db_prefix')."game.tb_item as a inner join ".$this->config->item('db_prefix')."game.tb_player as b on a._player_id = b._player_id ";
		$query .= "where a._player_id = ? ";

		return $this->db->query( $query, array( $player_id ) );
	}

	public function storagelist( $player_id )
	{
		$query = "select b._player_name, a._item_index, a._item_id, a._item_add_info, a._item_option_0, a._item_option_1, a._item_option_2, a._item_option_3, a._item_option_4, a._item_option_5, ";
		$query .= "a._count, a._limit_time, 'N' as _distraint_status, a._acquired_time ";
		$query .= "from ".$this->config->item('db_prefix')."game.tb_storage as a inner join ".$this->config->item('db_prefix')."game.tb_player as b on a._player_id = b._player_id ";
		$query .= "where a._player_id = ? ";

		return $this->db->query( $query, array( $player_id ) );
	}

	public function tracklist( $player_id )
	{
		$query = "select _id, _map_id, _day_clear_cnt, _day_clear_last_day, _day_clear_auto_cnt, _day_clear_auto_last_day, _max_rank, _total_clear, _date ";
		$query .= "from ".$this->config->item('db_prefix')."game.tb_map_clear_day where _player_id = ? ";

		return $this->db->query( $query, array( $player_id ) );
	}

	public function guilddetail( $guild_name )
	{
		$query = "select _name as _guild_name, _master_name, _pl_cnt, _pl_cnt_max, _insertdate, _lvl, 1 as _rank, '-' as _occupy, _guild_color, _mark_id ";
		$query .= "from ".$this->config->item('db_prefix')."game.tb_guild where _name = ? ";

		return $this->db->query( $query, array( $guild_name ) );
	}

	public function guildmemberlist( $guild_name )
	{
		$query = "select c._player_name, b._player_id, c._level, c._char_id, b._grade ";
		$query .= "from ".$this->config->item('db_prefix')."game.tb_guild as a ";
		$query .= "inner join ".$this->config->item('db_prefix')."game.tb_guild_player as b on a._id = b._guild_id ";
		$query .= "inner join ".$this->config->item('db_prefix')."game.tb_player as c on b._player_id = c._player_id ";
		$query .= "where _name = ? ";

		return $this->db->query( $query, array( $guild_name ) );
	}

	public function maillist( $player_id )
	{
		$query = "select _itime, _content, date_add(_itime, interval ".NORMALMAILLIMIT." day) as _etime ";
		$query .= "from ".$this->config->item('db_prefix')."game.tb_mail ";
		$query .= "where _player_id = ? and _taken = 'N' and _itime > date_add(now(), interval -".NORMALMAILLIMIT." day) ";
		$query .= "order by _mail_id asc";

		return $this->db->query( $query, array( $player_id ) );
	}

	public function changeval( $key, $val, $player_id, $user_id, $val2 )
	{
		$tables = array();
		$result = true;
		if ( array_key_exists( $key, CHANGE_TABLE ) )
		{
			foreach( CHANGE_TABLE[$key] as $row )
			{
				if ( $row == 'tb_buddy_ask' )
				{
					$query = "update ".$this->config->item('db_prefix')."game.".$row." ";
					$query .= "set _asker_name = if( _asker_player_id = '".$player_id."', '".$val."', _asker_name ), ";
					$query .= "_target_name = if( _target_player_id = '".$player_id."', '".$val."', _target_name ) ";
					$query .= "where _asker_player_id = '".$player_id."' or _target_player_id = '".$player_id."' ";
				}
				else if ( $row == 'tb_user' )
				{
					$query = "update ".$this->config->item('db_prefix')."base.".$row." ";
					$query .= "set _".str_replace( 'guild', '', $key )." = '".$val."' ";
					$query .= "where _user_id = '".$user_id."' ";
				}
				else
				{
					$query = "update ".$this->config->item('db_prefix')."game.".$row." ";
					$query .= "set _".str_replace( 'vip', '', str_replace( 'guild', '', $key ) )." = '".$val."' ";
					$query .= "where _player_id = '".$player_id."' ";
				}

				if ( $this->db->query( $query ) === false )
				{
					$result = false;
					break;
				}
			}
		}

		return $result;
	}

	public function recallmail( $_group_id, $_player_id )
	{
		$query = "update ".$this->config->item('db_prefix')."game.tb_mail set _taken = 'R' where _taken = 'N' and _group_id = '".$_group_id."' and _player_id = '".$_player_id."' ";

		$this->db->query( $query, array() );
		return $this->db->affected_rows();
	}

	public function findplayername( $_player_id )
	{
		$query = "select _player_name from ".$this->config->item('db_prefix')."game.tb_player where _player_id = '".$_player_id."' ";

		return $this->db->query( $query, array() );
	}

	public function findplayerid( $_player_name )
	{
		$query = "select _player_id from ".$this->config->item('db_prefix')."game.tb_player where _player_name = '".$_player_name."' ";

		return $this->db->query( $query, array() );
	}
}
?>