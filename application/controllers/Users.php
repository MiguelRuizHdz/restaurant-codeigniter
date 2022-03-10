<?php 

class Users extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Empleados';
		

		$this->load->model('model_users');
		$this->load->model('model_groups');
		$this->load->model('model_stores2');
	}

	public function index()
	{

		if(!in_array('viewUser', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$user_data = $this->model_users->getUserData();

		$result = array();
		foreach ($user_data as $k => $v) {

			$result[$k]['user_info'] = $v;

			$group = $this->model_users->getUserGroup($v['id']);
			$result[$k]['user_group'] = $group;
		}

		$this->data['user_data'] = $result;

		$this->render_template('users/index', $this->data);
	}

	public function create()
	{

		if(!in_array('createUser', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->form_validation->set_rules('groups', 'Rol', 'required');
		$this->form_validation->set_rules('store', 'Restaurante', 'trim|required');
		$this->form_validation->set_rules('username', 'Nombre de usuario', 'trim|required|min_length[3]|max_length[20]|is_unique[users.username]');
		$this->form_validation->set_rules('email', 'Correo', 'trim|required|is_unique[users.email]|valid_email');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('cpassword', 'Confirmar contraseña', 'trim|required|matches[password]');
		$this->form_validation->set_rules('fname', 'Nombre', 'trim|required');
		// $this->form_validation->set_rules('lname', 'Apellido', 'trim|alpha');
		$this->form_validation->set_rules('phone', 'Teléfono', 'trim|numeric|min_length[10]|max_length[10]');
		// $this->form_validation->set_rules('gender', 'Género', 'trim|isset');
		
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            // caso verdadero
            $password = $this->password_hash($this->input->post('password'));
        	$data = array(
        		'username' => $this->input->post('username'),
        		'password' => $password,
        		'email' => $this->input->post('email'),
        		'firstname' => $this->input->post('fname'),
        		'lastname' => $this->input->post('lname'),
        		'phone' => $this->input->post('phone'),
        		'gender' => $this->input->post('gender'),
        		'store_id' => $this->input->post('store'),
        	);

        	$create = $this->model_users->create($data, $this->input->post('groups'));
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Creado con éxito');
        		redirect('users/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Se produjo un error');
        		redirect('users/create', 'refresh');
        	}
        }
        else {
            // caso falso
            $this->data['store_data'] = $this->model_stores2->getStoresData();
        	$group_data = $this->model_groups->getGroupData();
        	$this->data['group_data'] = $group_data;

            $this->render_template('users/create', $this->data);
        }	

		
	}

	public function password_hash($pass = '')
	{
		if($pass) {
			$password = password_hash($pass, PASSWORD_DEFAULT);
			return $password;
		}
	}

	public function edit($id = null)
	{

		if(!in_array('updateUser', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if($id) {
			// $this->form_validation->set_rules('groups', 'Rol', 'required');
			// $this->form_validation->set_rules('store', 'Restaurante', 'trim|required');
			// $this->form_validation->set_rules('username', 'Nombre de usuario', 'trim|required|min_length[5]|max_length[12]|is_unique[users.username]|alpha_numeric');
			// $this->form_validation->set_rules('email', 'Correo', 'trim|required|is_unique[users.email]|valid_email');
			// $this->form_validation->set_rules('password', 'Contraseña', 'trim|required|min_length[8]');
			// $this->form_validation->set_rules('cpassword', 'Confirmar contraseña', 'trim|required|matches[password]');
			// $this->form_validation->set_rules('fname', 'Nombre', 'trim|required|alpha');
			// $this->form_validation->set_rules('lname', 'Apellido', 'trim|alpha');
			// $this->form_validation->set_rules('phone', 'Teléfono', 'trim|numeric|min_length[10]|max_length[10]');
			// $this->form_validation->set_rules('gender', 'Género', 'trim|isset');
			$this->form_validation->set_rules('groups', 'Rol', 'required');
			$this->form_validation->set_rules('store', 'Restaurante', 'trim|required');
			$this->form_validation->set_rules('username', 'Nombre de usuario', 'trim|required|min_length[5]|max_length[12]');
			$this->form_validation->set_rules('email', 'Correo', 'trim|required');
			$this->form_validation->set_rules('fname', 'Nombre', 'trim|required');
			$this->form_validation->set_rules('phone', 'Teléfono', 'trim|numeric|exact_length[10]');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if ($this->form_validation->run() == TRUE) {
	            // caso verdadero
		        if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
		        	$data = array(
		        		'username' => $this->input->post('username'),
		        		'email' => $this->input->post('email'),
		        		'firstname' => $this->input->post('fname'),
		        		'lastname' => $this->input->post('lname'),
		        		'phone' => $this->input->post('phone'),
		        		'gender' => $this->input->post('gender'),
		        		'store_id' => $this->input->post('store'),
		        	);

		        	$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
		        	if($update == true) {
		        		$this->session->set_flashdata('success', 'Creado con éxito');
		        		redirect('users/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('errors', 'Se produjo un error');
		        		redirect('users/edit/'.$id, 'refresh');
		        	}
		        }
		        else {
		        	$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|min_length[8]');
					$this->form_validation->set_rules('cpassword', 'Confirmar contraseña', 'trim|required|matches[password]');

					if($this->form_validation->run() == TRUE) {

						$password = $this->password_hash($this->input->post('password'));

						$data = array(
			        		'username' => $this->input->post('username'),
			        		'password' => $password,
			        		'email' => $this->input->post('email'),
			        		'firstname' => $this->input->post('fname'),
			        		'lastname' => $this->input->post('lname'),
			        		'phone' => $this->input->post('phone'),
			        		'gender' => $this->input->post('gender'),
			        		'store_id' => $this->input->post('store'),
			        	);

			        	$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
			        	if($update == true) {
			        		$this->session->set_flashdata('success', 'Actualizado exitosamente');
			        		redirect('users/', 'refresh');
			        	}
			        	else {
			        		$this->session->set_flashdata('errors', 'Se produjo un error');
			        		redirect('users/edit/'.$id, 'refresh');
			        	}
					}
			        else {
			            // caso falso
			        	$user_data = $this->model_users->getUserData($id);
			        	$groups = $this->model_users->getUserGroup($id);

			        	$this->data['user_data'] = $user_data;
			        	$this->data['user_group'] = $groups;

			            $group_data = $this->model_groups->getGroupData();
			        	$this->data['group_data'] = $group_data;

						$this->render_template('users/edit', $this->data);	
			        }	

		        }
	        }
	        else {
	            // caso falso
	        	$user_data = $this->model_users->getUserData($id);
	        	$groups = $this->model_users->getUserGroup($id);

	        	$this->data['store_data'] = $this->model_stores2->getStoresData();

	        	$this->data['user_data'] = $user_data;
	        	$this->data['user_group'] = $groups;

	            $group_data = $this->model_groups->getGroupData();
	        	$this->data['group_data'] = $group_data;

				$this->render_template('users/edit', $this->data);	
	        }	
		}	
	}

	public function delete($id)
	{

		if(!in_array('deleteUser', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if($id) {
			if($this->input->post('confirm')) {

				
					$delete = $this->model_users->delete($id);
					if($delete == true) {
		        		$this->session->set_flashdata('success', 'Eliminado exitosamente');
		        		redirect('users/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('error', 'Se produjo un error');
		        		redirect('users/delete/'.$id, 'refresh');
		        	}

			}	
			else {
				$this->data['id'] = $id;
				$this->render_template('users/delete', $this->data);
			}	
		}
	}

	public function profile()
	{

		if(!in_array('viewProfile', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$user_id = $this->session->userdata('id');

		$user_data = $this->model_users->getUserData($user_id);
		$this->data['user_data'] = $user_data;

		$user_group = $this->model_users->getUserGroup($user_id);
		$this->data['user_group'] = $user_group;

        $this->render_template('users/profile', $this->data);
	}

	public function setting()
	{
		if(!in_array('updateSetting', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		$id = $this->session->userdata('id');

		if($id) {
			$this->form_validation->set_rules('username', 'Nombre de usuario', 'trim|required|min_length[5]|max_length[12]|is_unique[users.username]|alpha_numeric');
			$this->form_validation->set_rules('email', 'Correo', 'trim|required|is_unique[users.email]|valid_email');
			$this->form_validation->set_rules('fname', 'Nombre', 'trim|required|alpha');
			$this->form_validation->set_rules('lname', 'Apellido', 'trim|alpha');
			$this->form_validation->set_rules('phone', 'Teléfono', 'trim|numeric|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('gender', 'Género', 'trim|isset');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');


			if ($this->form_validation->run() == TRUE) {
	            // caso verdadero
		        if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
		        	$data = array(
		        		'username' => $this->input->post('username'),
		        		'email' => $this->input->post('email'),
		        		'firstname' => $this->input->post('fname'),
		        		'lastname' => $this->input->post('lname'),
		        		'phone' => $this->input->post('phone'),
		        		'gender' => $this->input->post('gender'),
		        	);

		        	$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
		        	if($update == true) {
		        		$this->session->set_flashdata('success', 'Actualizado exitosamente');
		        		redirect('users/setting/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('errors', 'Se produjo un error');
		        		redirect('users/setting/', 'refresh');
		        	}
		        }
		        else {
		        	$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|min_length[8]');
					$this->form_validation->set_rules('cpassword', 'Confirmar contraseña', 'trim|required|matches[password]');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

					if($this->form_validation->run() == TRUE) {

						$password = $this->password_hash($this->input->post('password'));

						$data = array(
			        		'username' => $this->input->post('username'),
			        		'password' => $password,
			        		'email' => $this->input->post('email'),
			        		'firstname' => $this->input->post('fname'),
			        		'lastname' => $this->input->post('lname'),
			        		'phone' => $this->input->post('phone'),
			        		'gender' => $this->input->post('gender'),
			        	);

			        	$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
			        	if($update == true) {
			        		$this->session->set_flashdata('success', 'Actualizado exitosamente');
			        		redirect('users/setting/', 'refresh');
			        	}
			        	else {
			        		$this->session->set_flashdata('errors', 'Se produjo un error');
			        		redirect('users/setting/', 'refresh');
			        	}
					}
			        else {
			            // caso falso
			        	$user_data = $this->model_users->getUserData($id);
			        	$groups = $this->model_users->getUserGroup($id);

			        	$this->data['user_data'] = $user_data;
			        	$this->data['user_group'] = $groups;

			            $group_data = $this->model_groups->getGroupData();
			        	$this->data['group_data'] = $group_data;

						$this->render_template('users/setting', $this->data);	
			        }	

		        }
	        }
	        else {
	            // caso falso
	        	$user_data = $this->model_users->getUserData($id);
	        	$groups = $this->model_users->getUserGroup($id);

	        	$this->data['user_data'] = $user_data;
	        	$this->data['user_group'] = $groups;

	            $group_data = $this->model_groups->getGroupData();
	        	$this->data['group_data'] = $group_data;

				$this->render_template('users/setting', $this->data);	
	        }	
		}
	}


}