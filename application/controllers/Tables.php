<?php 

class Tables extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Mesas';
		$this->load->model('model_tables');
		$this->load->model('model_stores');
	}

	public function index()
	{	
		$store_data = $this->model_stores->getActiveStore();
		$this->data['store_data'] = $store_data;
		$this->render_template('tables/index', $this->data);
	}

	public function fetchTableData()
	{
		if(!in_array('viewTable', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$result = array('data' => array());

		$data = $this->model_tables->getTableData();

		foreach ($data as $key => $value) {

			$store_data = $this->model_stores->getStoresData($value['store_id']);

			// button
			$buttons = '';

			if(in_array('updateTable', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-info" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteTable', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$available = ($value['available'] == 1) ? '<span class="label label-success">Disponible</span>' : '<span class="label label-danger">Ocupada</span>';
			$status = ($value['active'] == 1) ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>';

			$result['data'][$key] = array(
				$store_data['name'],
				$value['table_name'],
				$value['capacity'],
				$available,
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function create()
	{
		if(!in_array('createTable', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('table_name', 'Nombre de la mesa', 'trim|required');
		$this->form_validation->set_rules('capacity', 'Capacidad', 'trim|integer');
		$this->form_validation->set_rules('active', 'Estado', 'trim|required');
		$this->form_validation->set_rules('store', 'Restaurante', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'table_name' => $this->input->post('table_name'),
        		'available' => 1,
        		'capacity' => $this->input->post('capacity'),	
        		'active' => $this->input->post('active'),	
        		'store_id' => $this->input->post('store'),	
        	);

        	$create = $this->model_tables->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Creado con ??xito';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error en la base de datos al crear la informaci??n';			
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

	public function fetchTableDataById($id = null)
	{
		if($id) {
			$data = $this->model_tables->getTableData($id);
			echo json_encode($data);
		}
		
	}

	public function update($id)
	{
		if(!in_array('updateTable', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_table_name', 'Nombre de la mesa', 'trim|required');
			$this->form_validation->set_rules('edit_capacity', 'Capacidad', 'trim|integer');
			$this->form_validation->set_rules('edit_active', 'Estado', 'trim|required');
			$this->form_validation->set_rules('edit_store', 'Restaurante', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'table_name' => $this->input->post('edit_table_name'),
        			'capacity' => $this->input->post('edit_capacity'),	
        			'active' => $this->input->post('edit_active'),	
        			'store_id' => $this->input->post('edit_store'),	
	        	);

	        	$update = $this->model_tables->update($id, $data);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Actualizado exitosamente';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error en la base de datos al actualizar la informaci??n';			
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
    		$response['messages'] = 'Error, actualice la p??gina de nuevo.';
		}

		echo json_encode($response);
	}

	public function remove()
	{
		if(!in_array('deleteTable', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$table_id = $this->input->post('table_id');

		$response = array();
		if($table_id) {
			$delete = $this->model_tables->remove($table_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Eliminado exitosamente";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error en la base de datos al eliminar la informaci??n";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Actualiza la p??gina de nuevo.";
		}

		echo json_encode($response);
	}

}