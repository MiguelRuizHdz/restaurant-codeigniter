<?php 

class Stores extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Sucursales';
		$this->load->model('model_stores2');
	}

	public function index()
	{
		if(!in_array('viewStore', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		$this->render_template('stores/index', $this->data);
	}

	public function fetchCategoryData()
	{
		if(!in_array('viewStore', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$result = array('data' => array());

		$data = $this->model_stores2->getStoresData();

		foreach ($data as $key => $value) {
			// button
			$buttons = '';

			if(in_array('updateStore', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-info" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteStore', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value['active'] == 1) ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>';

			$result['data'][$key] = array(
				$value['name'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function create()
	{
		if(!in_array('createStore', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('store_name', 'Nombre de la sucursal', 'trim|required');
		$this->form_validation->set_rules('active', 'Estado', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('store_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_stores2->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Creado con éxito';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error en la base de datos al crear la información';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}

	public function fetchStoresDataById($id = null)
	{
		if($id) {
			$data = $this->model_stores2->getStoresData($id);
			echo json_encode($data);
		}
		
	}

	public function update($id)
	{
		if(!in_array('updateStore', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_store_name', 'Nombre de la sucursal', 'trim|required');
			$this->form_validation->set_rules('edit_active', 'Estado', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'name' => $this->input->post('edit_store_name'),
        			'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_stores2->update($id, $data);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Actualizado exitosamente';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error en la base de datos al actualizar la información';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error, actualice la página de nuevo.';
		}

		echo json_encode($response);
	}

	public function remove()
	{
		if(!in_array('deleteStore', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$store_id = $this->input->post('store_id');

		$response = array();
		if($store_id) {
			$delete = $this->model_stores2->remove($store_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Eliminado exitosamente";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the brand information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Actualiza la página de nuevo. ";
		}

		echo json_encode($response);
	}

}