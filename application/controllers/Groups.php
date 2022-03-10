<?php 

class Groups extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Roles';
		

		$this->load->model('model_groups');
	}

	public function index()
	{
		if(!in_array('viewGroup', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$groups_data = $this->model_groups->getGroupData();
		$this->data['groups_data'] = $groups_data;

		$this->render_template('groups/index', $this->data);
	}

	public function create()
	{
		if(!in_array('createGroup', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->form_validation->set_rules('group_name', 'Nombre del rol', 'trim|required|alpha');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            // caso verdadero
            $permission = serialize($this->input->post('permission'));
            
        	$data = array(
        		'group_name' => $this->input->post('group_name'),
        		'permission' => $permission
        	);

        	$create = $this->model_groups->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Creado con éxito');
        		redirect('groups/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Se produjo un error');
        		redirect('groups/create', 'refresh');
        	}
        }
        else {
            // caso falso
            $this->render_template('groups/create', $this->data);
        }	

		
	}

	public function edit($id = null)
	{
		if(!in_array('updateGroup', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if($id) {

			$this->form_validation->set_rules('group_name', 'Nombre del rol', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if ($this->form_validation->run() == TRUE) {
	            // caso verdadero
	            $permission = serialize($this->input->post('permission'));
	            
	        	$data = array(
	        		'group_name' => $this->input->post('group_name'),
	        		'permission' => $permission
	        	);

	        	$update = $this->model_groups->edit($data, $id);
	        	if($update == true) {
	        		$this->session->set_flashdata('success', 'Actualizado exitosamente');
	        		redirect('groups/', 'refresh');
	        	}
	        	else {
	        		$this->session->set_flashdata('errors', 'Se produjo un error');
	        		redirect('groups/edit/'.$id, 'refresh');
	        	}
	        }
	        else {
	            // caso falso
	            $group_data = $this->model_groups->getGroupData($id);
				$this->data['group_data'] = $group_data;
				$this->render_template('groups/edit', $this->data);	
	        }	
		}

		
	}

	public function delete($id)
	{
		if(!in_array('deleteGroup', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		if($id) {
			if($this->input->post('confirm')) {

				$check = $this->model_groups->existInUserGroup($id);
				if($check == true) {
					$this->session->set_flashdata('error', 'El grupo existe en los usuarios.');
	        		redirect('groups/', 'refresh');
				}
				else {
					$delete = $this->model_groups->delete($id);
					if($delete == true) {
		        		$this->session->set_flashdata('success', 'Eliminado exitosamente');
		        		redirect('groups/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('error', 'Se produjo un error');
		        		redirect('groups/delete/'.$id, 'refresh');
		        	}
				}	
			}	
			else {
				$this->data['id'] = $id;
				$this->render_template('groups/delete', $this->data);
			}	
		}
	}


}