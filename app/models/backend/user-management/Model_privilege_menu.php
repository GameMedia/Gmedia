<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class model_privilege_menu extends MY_Model {

	private $tablePrivilege_Menu = 'cms_privilege_menu';
	private $tablePrivilege = 'cms_privilege';
	private $tableMenu = 'cms_menu';
	private $tableUserType = 'cms_user_type';

	public function __construct () {
		parent::__construct();
		
		$this->loadDbCms();
	}
	
	public function loadMenuSelect($params = array()){
		$result = array();
				
		$this->dbCms->select('m.id, m.name, m.parent, m.url, m.status, m.sort, m.icon');
		$this->dbCms->select('(SELECT sort FROM '.$this->tableMenu.' WHERE parent=m.parent AND m.sort > sort ORDER BY sort ASC LIMIT 1) AS sort_up');
		$this->dbCms->select('(SELECT sort FROM '.$this->tableMenu.' WHERE parent=m.parent AND m.sort < sort ORDER BY sort ASC LIMIT 1) AS sort_down');
		$this->dbCms->select('(SELECT COUNT(1) FROM '.$this->tableMenu.' WHERE parent = m.id AND status != "-1") AS child');
		$this->dbCms->from($this->tableMenu.' m');
		$this->dbCms->where('m.status !=', '-1');
		
		
		if(isset($params['privilege'])){
			$this->dbCms->select('pm.id_privilege, p.name AS name_privilege, pm.access');
			$this->dbCms->join($this->tablePrivilege_Menu.' pm', 'm.id = pm.id_menu');
			$this->dbCms->join($this->tablePrivilege.' p', 'p.id = pm.id_privilege');
			if(!empty($params['privilege']))
				$this->dbCms->where('pm.id_privilege', $params['privilege']);
			if(!empty($params['menu']))
				$this->dbCms->where('pm.id_menu', $params['menu']);
			if(!empty($params['name']))
				$this->dbCms->where('m.name', $params['name']);
			if(!empty($params['status']))
				$this->dbCms->where('m.status', $params['status']);
			if(!empty($params['icon']))
				$this->dbCms->where('m.icon', $params['icon']);
		}
		
		if($params['parent'] != '')
			$this->dbCms->where('m.parent', $this->dbCms->escape_str($params['parent']));
		
		$this->dbCms->order_by('m.sort', 'ASC');
		$query = $this->dbCms->get();
		
		$i=0;
		if($query->num_rows() != 0){
			$result['count'] = true;
			$level = !empty($params['level'])?$params['level']:0;
			foreach($query->result_array() as $row) {
				$result['rows'][$level][$i]['id'] = $row['id'];
				$result['rows'][$level][$i]['name'] = $row['name'];
				$result['rows'][$level][$i]['parent'] = $row['parent'];
				$result['rows'][$level][$i]['url'] = $row['url'];
				$result['rows'][$level][$i]['status'] = $row['status'];
				$result['rows'][$level][$i]['sort'] = $row['sort'];
				$result['rows'][$level][$i]['level'] = $level;
				$result['rows'][$level][$i]['icon'] = $row['icon'];
				$result['rows'][$level][$i]['child'] = $row['child'];
				$result['rows'][$level][$i]['sort_up'] = $row['sort_up'];
				$result['rows'][$level][$i]['sort_down'] = $row['sort_down'];
				$result['rows'][$level][$i]['id_privilege'] = isset($row['id_privilege'])?$row['id_privilege']:'';;
				$result['rows'][$level][$i]['name_privilege'] = isset($row['name_privilege'])?$row['name_privilege']:'';
				$result['rows'][$level][$i]['access'] = isset($row['access'])?$row['access']:'0';
				if(!empty($row['child'])){
					$result['rows'][$row['id']] = $this->loadMenuChildSelect(array('parent' => $row['id'], 'level' => $level+1), $params);
					foreach($result['rows'][$row['id']] as $key => $val){
						if($val['child'])
							$result['rows'][$val['id']] = $this->loadMenuChildSelect(array('parent' => $val['id'], 'level' => $level+2), $params);
					}
				}
				$i++;
			}
		} else {
			$result['count'] = false;
			$result['title'] = DB_TITLE_RESULT;
			$result['message'] = DB_NULL_RESULT;
		}
		
		return $result;
	}
	
	public function loadMenuChildSelect($params = array(), $paramsPost = array()){
		$result = array();
				
		$this->dbCms->select('m.id, m.name, m.parent, m.url, m.status, m.sort, m.icon');
		$this->dbCms->select('(SELECT sort FROM '.$this->tableMenu.' WHERE parent=m.parent AND m.sort > sort ORDER BY sort ASC LIMIT 1) AS sort_up');
		$this->dbCms->select('(SELECT sort FROM '.$this->tableMenu.' WHERE parent=m.parent AND m.sort < sort ORDER BY sort ASC LIMIT 1) AS sort_down');
		$this->dbCms->select('(SELECT COUNT(1) FROM '.$this->tableMenu.' WHERE parent = m.id AND status != "-1") AS child');
		$this->dbCms->from($this->tableMenu.' m');
		$this->dbCms->where('m.status !=', '-1');
		
		if(isset($paramsPost['privilege'])){
			$this->dbCms->select('p.name AS name_privilege, pm.access, pm.id_privilege');
			$this->dbCms->join($this->tablePrivilege_Menu.' pm', 'm.id = pm.id_menu');
			$this->dbCms->join($this->tablePrivilege.' p', 'p.id = pm.id_privilege');
			if(!empty($paramsPost['privilege']))
				$this->dbCms->where('pm.id_privilege', $paramsPost['privilege']);
			if(!empty($paramsPost['menu']))
				$this->dbCms->where('pm.id_menu', $paramsPost['menu']);
			if(!empty($paramsPost['name']))
				$this->dbCms->where('m.name', $paramsPost['name']);
			if(!empty($paramsPost['status']))
				$this->dbCms->where('m.status', $paramsPost['status']);
			if(!empty($paramsPost['icon']))
				$this->dbCms->where('m.icon', $paramsPost['icon']);
		}
		
		if($params['parent'] != '')
			$this->dbCms->where('m.parent', $this->dbCms->escape_str($params['parent']));
		
		$this->dbCms->order_by('m.sort', 'ASC');
		$query = $this->dbCms->get();
				
		$i=0;
		if($query->num_rows() != 0){
			#$result['count'] = true;
			$level = !empty($params['level'])?$params['level']:1;
			foreach($query->result_array() as $row) {
				$result[$i]['id'] = $row['id'];
				$result[$i]['name'] = $row['name'];
				$result[$i]['parent'] = $row['parent'];
				$result[$i]['url'] = $row['url'];
				$result[$i]['status'] = $row['status'];
				$result[$i]['sort'] = $row['sort'];
				$result[$i]['level'] = $level;
				$result[$i]['child'] = $row['child'];
				$result[$i]['sort_up'] = $row['sort_up'];
				$result[$i]['sort_down'] = $row['sort_down'];
				$result[$i]['icon'] = $row['icon'];
				$result[$i]['id_privilege'] = isset($row['id_privilege'])?$row['id_privilege']:'';
				$result[$i]['name_privilege'] = isset($row['name_privilege'])?$row['name_privilege']:'';
				$result[$i]['access'] = isset($row['access'])?$row['access']:'0';
				/*if(!empty($row['child'])){
					
					$i++;
					$resultTemp = $this->loadMenuChildSelect(array('parent' => $row['id'], 'level' => $level+1), $paramsPost);
					for($x = 0; $x<count($resultTemp); $x++){
						$result[$i]['id'] = $resultTemp[$x]['id'];
						$result[$i]['name'] = $resultTemp[$x]['name'];
						$result[$i]['parent'] = $resultTemp[$x]['parent'];
						$result[$i]['url'] = $resultTemp[$x]['url'];
						$result[$i]['status'] = $resultTemp[$x]['status'];
						$result[$i]['sort'] = $resultTemp[$x]['sort'];
						$result[$i]['level'] = $level+1;
						$result[$i]['child'] = $resultTemp[$x]['child'];
						$result[$i]['sort_up'] = $resultTemp[$x]['sort_up'];
						$result[$i]['sort_down'] = $resultTemp[$x]['sort_down'];
						$result[$i]['icon'] = $resultTemp[$x]['icon'];
						$result[$i]['id_privilege'] = isset($resultTemp[$x]['id_privilege'])?$resultTemp[$x]['id_privilege']:'';
						$result[$i]['name_privilege'] = isset($resultTemp[$x]['name_privilege'])?$resultTemp[$x]['name_privilege']:'';
						$result[$i]['access'] = isset($row['access'])?$resultTemp[$x]['access']:'0';
						/ *if(!empty($row['child'])){
					
							$i++;
							$resultTemp2 = $this->loadMenuChildSelect(array('parent' => $resultTemp[$x]['id'], 'level' => $level+1), $paramsPost);
							for($y = 0; $y<count($resultTemp2); $y++){
								$result[$i]['id'] = $resultTemp2[$y]['id'];
								$result[$i]['name'] = $resultTemp2[$y]['name'];
								$result[$i]['parent'] = $resultTemp2[$y]['parent'];
								$result[$i]['url'] = $resultTemp2[$y]['url'];
								$result[$i]['status'] = $resultTemp2[$y]['status'];
								$result[$i]['sort'] = $resultTemp2[$y]['sort'];
								$result[$i]['level'] = $level+2;
								$result[$i]['child'] = $resultTemp2[$y]['child'];
								$result[$i]['sort_up'] = $resultTemp2[$y]['sort_up'];
								$result[$i]['sort_down'] = $resultTemp2[$y]['sort_down'];
								$result[$i]['icon'] = $resultTemp2[$y]['icon'];
								$result[$i]['id_privilege'] = isset($resultTemp2[$y]['id_privilege'])?$resultTemp2[$y]['id_privilege']:'';
								$result[$i]['name_privilege'] = isset($resultTemp2[$y]['name_privilege'])?$resultTemp2[$y]['name_privilege']:'';
								$result[$i]['access'] = isset($row['access'])?$resultTemp2[$y]['access']:'0';
								$i++;
							}
						}* /
						$i++;
					}
				}*/
				$i++;
			}
		} else {
			$result['count'] = false;
			$result['title'] = DB_TITLE_RESULT;
			$result['message'] = DB_NULL_RESULT;
		}
		return $result;
	}
	
	public function setAccess($params){		
		$this->dbCms->select('access');
		$this->dbCms->from($this->tablePrivilege_Menu);
		$this->dbCms->where('id_privilege', $params['privilege']);
		$this->dbCms->where('id_menu', $params['menu']);
		$query = $this->dbCms->get();
		
		if($query->num_rows() == 0){
			$result['success'] = false;
			$result['title'] = DB_TITLE_UPDATE;
			$result['message'] = DB_NULL_RESULT;
			return $result;
		}
			
		foreach($query->result_array() as $row)
			$access = $row['access'];
					
		$n = (int) $params['access'] & (int) $access;
		
		$newAccess = ($n==0)?$access+$params['access']:$access-$params['access'];
			
		$query = "UPDATE ".$this->tablePrivilege_Menu." SET access=".$newAccess." WHERE id_menu=".$params['menu']." AND id_privilege=".$params['privilege'];
		
		$this->dbCms->query($query);
		
		$dbResponse = $this->dbCms->error();		
		if($dbResponse['code'] == 0){
			$result['success'] = true;
			$result['title'] = DB_TITLE_UPDATE;
			$result['message'] = DB_SUCCESS_UPDATE;
		} else {
			$result['success'] = false;
			$result['title'] = DB_TITLE_UPDATE;
			$result['message'] = $dbResponse['message'];
		}
		return $result;
	}
	
	public function setSorting($params){
		
	}
	
	public function savePrivilege_Menu($params){
		$this->dbCms->select('id');
		$this->dbCms->from($this->tableMenu);
		$this->dbCms->where('id', $this->dbCms->escape_str($params['id']));
		$data = $this->dbCms->get();
		if($data->num_rows() != 0){
			$result = true;	
		} else 
			$result = false;
		return $result;
	}
	
	public function updatePrivilege_Menu($params){
		$update_by = $this->profile['id'];
		$update_time = date('Y-m-d H:i:s');
		
		#Get Last Sort
		$where = "id='".$params['parent']."'";
		if($params['parent'] == '')
			$where = "parent='0'";
		$select = "SELECT 
						level 
					FROM ".$this->tableMenu." 
					WHERE ".$where." ORDER BY sort DESC LIMIT 1";
		$query = $this->dbCms->query($select);
		$level = 1;
		if($query->num_rows() != 0){
			foreach($query->result_array() as $row){
				$level = $row['level']+1;
			}
		}
		
		$update = array(
						'url' 			=> $this->dbCms->escape_str($params['url']),
						'name' 			=> $this->dbCms->escape_str($params['name']),
						'description'	=> $this->dbCms->escape_str($params['description']),
						'icon'			=> $this->dbCms->escape_str($params['icon']),
						'parent' 		=> $this->dbCms->escape_str($params['parent']),
						'level' 		=> $this->dbCms->escape_str($level),
						'status'		=> $this->dbCms->escape_str($params['status']),
						'update_by' 	=> $this->dbCms->escape_str($update_by),
						'update_time'	=> $this->dbCms->escape_str($update_time)
					   );
		$this->dbCms->where('id', $this->dbCms->escape_str($params['id']));
		$this->dbCms->update($this->tableMenu, $update);
		
		$result = array();
		$dbResponse = $this->dbCms->error();		
		if($dbResponse['code'] == 0){
			$result['success'] = true;
			$result['title'] = DB_TITLE_UPDATE;
			$result['message'] = DB_SUCCESS_UPDATE;
		} else {
			$result['success'] = false;
			$result['title'] = DB_TITLE_UPDATE;
			$result['message'] = $dbResponse['message'];
		}
				
		return $result;
	} 
	
	public function insertPrivilege_Menu($params){
		$result = array();
		
		#Get Last Sort
		$where = "parent='".$params['parent']."'";
		if($params['parent'] == '')
			$where = "parent='0'";
		$select = "SELECT 
						(SELECT COUNT(1) FROM ".$this->tableMenu." WHERE parent='".$params['parent']."') AS sort, level 
					FROM ".$this->tableMenu." 
					WHERE ".$where." ORDER BY sort DESC LIMIT 1";
		$query = $this->dbCms->query($select);
		$sort = 0;
		$level = 1;
		if($query->num_rows() != 0){
			foreach($query->result_array() as $row){
				$sort = $row['sort'];
				$level = $row['level']+1;
			}
		}
		
		$input_by = $this->profile['id'];
		$input_time = date('Y-m-d H:i:s');
		$insert = array(
						'url' 			=> $this->dbCms->escape_str($params['url']),
						'name' 			=> $this->dbCms->escape_str($params['name']),
						'description'	=> $this->dbCms->escape_str($params['description']),
						'icon'			=> $this->dbCms->escape_str($params['icon']),
						'parent' 		=> $this->dbCms->escape_str($params['parent']),
						'sort' 			=> $this->dbCms->escape_str($sort+1),
						'level' 		=> $this->dbCms->escape_str($level),
						'status'		=> $this->dbCms->escape_str($params['status']),
						'entry_by' 		=> $this->dbCms->escape_str($input_by),
						'entry_time'	=> $this->dbCms->escape_str($input_time)
					   );
		$this->dbCms->insert($this->tableMenu, $insert);
		
		$dbResponse = $this->dbCms->error();		
		if($dbResponse['code'] == 0){
			#Insert into privilege_menu
			$idMenu = $this->dbCms->insert_id();
		
			$this->dbCms->select('id, status');
			$this->dbCms->from($this->tablePrivilege);

			$query = $this->dbCms->get();
			
			$i=0;
			if($query->num_rows() != 0){
				foreach($query->result_array() as $row) {
					$insertPM = array(
									'id_privilege' => $this->dbCms->escape_str($row['id']),
									'id_menu' => $this->dbCms->escape_str($idMenu),
									'access' => $this->dbCms->escape_str('0'),
									'status' => $this->dbCms->escape_str($row['status']),
									'entry_by' => $this->dbCms->escape_str($input_by),
									'entry_time' => $this->dbCms->escape_str($input_time)
								   );
					$this->dbCms->insert($this->tablePrivilege_Menu, $insertPM);
				}
			}		
			
			$result['success'] = true;
			$result['title'] = DB_TITLE_SAVE;
			$result['message'] = DB_SUCCESS_SAVE;
		} else {
			$result['success'] = false;
			$result['title'] = DB_TITLE_SAVE;
			$result['message'] = $dbResponse['message'];
		}
		return $result;
	}
	
	public function deletePrivilege_Menu($params){		
		$delete = array(
						'status' => $this->dbCms->escape_str("-1")
					   );
		$this->dbCms->where('id', $this->dbCms->escape_str($params['id']));
		$this->dbCms->update($this->tableMenu, $delete);
				
		$result = array();
		$dbResponse = $this->dbCms->error();		
		if($dbResponse['code'] == 0){
			$result['success'] = true;
			$result['title'] = DB_TITLE_UPDATE;
			$result['message'] = DB_SUCCESS_UPDATE;
		} else {
			$result['success'] = false;
			$result['title'] = DB_TITLE_UPDATE;
			$result['message'] = $dbResponse['message'];
		}
		return $result;
	}
	
	public function getPrivilege_MenuData($params){
		$this->dbCms->select('id, url, name, description, icon, parent, status');
		$this->dbCms->from($this->tableMenu);
		$this->dbCms->where('id', $this->dbCms->escape_str($params['id']));
		$query = $this->dbCms->get();
		$result = array();
		if($query->num_rows() != 0){
			$result['count'] = true;
			foreach($query->result_array() as $row) {
				$result['id'] = $row['id'];
				$result['url'] = $row['url'];
				$result['name'] = $row['name'];
				$result['description'] = $row['description'];
				$result['parent'] = $row['parent'];
				$result['icon'] = $row['icon'];
				$result['status'] = (int) $row['status'];
			}
		} else {
			$result['count'] = false;
			$result['title'] = DB_TITLE_RESULT;
			$result['message'] = DB_NULL_RESULT;
		}
		return $result;
	}
	
	public function getMenuSortData($params){
		$this->dbCms->select('id, url, name, description, icon, parent, status');
		$this->dbCms->from($this->tableMenu);
		$this->dbCms->where('id', $this->dbCms->escape_str($params['menu']));
		$query = $this->dbCms->get();
		$result = array();
		if($query->num_rows() != 0){
			$result['count'] = true;
			foreach($query->result_array() as $row) {
				$result['id'] = $row['id'];
				$result['url'] = $row['url'];
				$result['name'] = $row['name'];
				$result['description'] = $row['description'];
				$result['parent'] = $row['parent'];
				$result['icon'] = $row['icon'];
				$result['status'] = (int) $row['status'];
			}
		} else {
			$result['count'] = false;
			$result['title'] = DB_TITLE_RESULT;
			$result['message'] = DB_NULL_RESULT;
		}
		return $result;
	}
	
	public function getMenuAll($params = array()){
		$this->dbCms->select('id, url, name, description, icon, parent, status');
		$this->dbCms->from($this->tableMenu);
		$query = $this->dbCms->get();
		$result = array();
		if($query->num_rows() != 0){
			$result['count'] = true;
			$i=0;
			foreach($query->result_array() as $row) {
				$result[$i]['id'] = $row['id'];
				$result[$i]['url'] = $row['url'];
				$result[$i]['name'] = $row['name'];
				$result[$i]['description'] = $row['description'];
				$result[$i]['parent'] = $row['parent'];
				$result[$i]['icon'] = $row['icon'];
				$result[$i]['status'] = (int) $row['status'];
				$i++;
			}
		} else {
			$result['count'] = false;
			$result['title'] = DB_TITLE_RESULT;
			$result['message'] = DB_NULL_RESULT;
		}
		return $result;
	}
}
?>
