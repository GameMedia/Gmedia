<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class galleries extends MY_Controller_Admin {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('backend/master-management/model_galleries');
	}

	/*-------------------------------------------------------------------------------------------------*/
	public function index()
	{
		$this->loadMenu();
		$this->data['pageTitle'] = 'Galleries';
		$this->data['pageTemplate'] = 'master-management/view_galleries';  //debug
		$this->load->view($this->folderLayout.'main', $this->data);
	}

	/*-------------------------------------------------------------------------------------------------*/
	public function loadGalleries()
	 {
	 	$this->isAjax(404);
	 	$result = array();
	 	$params = $_POST;
	 	$data = $this->model_galleries->loadGalleries($params);

	 	//count data
	 	if ($data['count']) 
	 	{
	 		for($i=0; $i<count($data['rows']); $i++)
	 		{
	 			$result['data'][$i][] = $params['start'] + ($i+1);
	 			$result['data'][$i][] = $data['rows'][$i]['type'];
	 			$result['data'][$i][] = $data['rows'][$i]['name'];
	 			$result['data'][$i][] = ( !empty($data['rows'][$i]['url_thumb']) || !empty($data['rows'][$i]['url_ori']))?"<img_src='".URL_PLATFORM.(!empty($data['rows'][$i]['url_thumb'])?$data['rows'][$i]['url_thumb']:$data['rows'][$i]['url_ori'])."' width='100' />":"";
	 			$result['data'][$i][] = ($data['rows'][$i]['status'])?'<span class="label label-sm label-success"> Active </span>':'<span class="label label-sm label-danger"> Inactive </span>';
	 			$buttonView = $this->createElementButtonView('view(\''.$data['rows'][$i]['id'].'\')', 'data-target="$fromAdd" data-toggle="modal"');

	 			$buttonDelete = ""; 
	 				if($this->data['accessDelete'])
	 					$buttonDelete = $this->createElementButtonDelete($data['rows'][$i]['id'], 'master-management/galleries/deleteGalleries', 'datatable');

	 			$result['data'][$i][] = $buttonview.' '.$buttonDelete;
	 		}
	 	} else
	 	{
	 		$result['data'] = array();
	 	}
	 	$result["draw"] = $params['draw'];
	 	$result["recordsTotal"] = $data['total'];
	 	$result["recordFiletered"] = $data['total'];
	 	echo json_encode($result);
	 }


	/*-------------------------------------------------------------------------------------------------*/ 
	public function loadGalleriesSelect()
	 {
	 	$this->isAjax(404);
	 	if(sizeof($_POST))
	 	{
	 		$params = $_POST;
	 		$result = $this->model_galleries->loadGalleriesSelect($params);

	 		echo json_encode($result);
	 	}
	 }

	/*-------------------------------------------------------------------------------------------------*/ //cek save or update 
	public function checkUI_GA()
	{
		$this->isAjax(404);
		if(sizeof($_POST))
		{
			$table = 'galleries';
			$this->load->model('backend/model_global');
			$params = $_POST;
			$paramsData = array(
							'type' => $params['type'],
							'id_reference' => $params['id_reference'],
							'name' => $params['name'],
							'description' => array($params['description'], true),
							'path_ori' => $params['path_ori'],
							'path_thumb' => $params['path_thumb'],
							'url_ori' => $params['url_ori'],
							'url_thumb' => $params['url_thumb'],
							'mime_type' => $params['mime_type'],
							'status' => $params['status']);
			$paramsKey = array( 'id' => $params['id']);
			$result = $this->model_global->checkUI($table, $paramsData,$paramsKey);

			if($result)
			{
				$result = $this->model_global->update($table, $paramsData, $paramsKey);
				//act history
				$paramsAct = array(
								'id_user' => $this->profile['id'],
								'action' => ACTION_HISTORY_UPDATE,
								'data' => ($result['success'])? json_encode($params):'',
								'result' => json_encode($result));
				$this->addActHistory($paramsAct);
			} else
			{
				$result = $this->model_global->insert($table, $paramsData);
				//act history
				$paramsAct = array(
								'id_user' => $this->profile['id'],
								'action' => ACTION_HISTORY_UPDATE,
								'data' => ($result['success'])? json_encode($params):'',
								'result' => json_encode($result));
				$this->addActHistory($paramsAct);
			}
			echo json_encode($result);
		}
	}

	/*-------------------------------------------------------------------------------------------------*/ 

	/*-------------------------------------------------------------------------------------------------*/ 
}

/* End of file galleries.php */
/* Location: ./application/controllers/galleries.php */