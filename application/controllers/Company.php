<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Información del restaurante';

		$this->load->model('model_company');
	}

    /* 
    // * Redirige a la página de la información del restaurante y muestra toda la información.
    // * También actualiza la información del restaurante en la base de datos si la  
    // * validación de cada campo de entrada es válida con éxito 
    */
	public function index()
	{  
        if(!in_array('updateCompany', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		$this->form_validation->set_rules('company_name', 'Nombre del restaurante', 'trim|required');
		$this->form_validation->set_rules('service_charge_value', 'Cargo por servicio', 'trim|integer');
		$this->form_validation->set_rules('vat_charge_value', 'Cargo por IVA', 'trim|integer');
		$this->form_validation->set_rules('address', 'Dirección', 'trim|required');
		$this->form_validation->set_rules('message', 'Mensaje', 'trim|required');
	
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		
        if ($this->form_validation->run() == TRUE) {
            // caso verdadero

        	$data = array(
        		'company_name' => $this->input->post('company_name'),
        		'service_charge_value' => $this->input->post('service_charge_value'),
        		'vat_charge_value' => $this->input->post('vat_charge_value'),
        		'address' => $this->input->post('address'),
        		'phone' => $this->input->post('phone'),
        		'message' => $this->input->post('message'),
                'currency' => $this->input->post('currency')
        	);

        	$update = $this->model_company->update($data, 1);
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Creado con éxito');
        		redirect('company/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Se produjo un error');
        		redirect('company/index', 'refresh');
        	}
        }
        else {

            // caso falso
            $this->data['currency_symbols'] = $this->currency();
        	$this->data['company_data'] = $this->model_company->getCompanyData(1);
			$this->render_template('company/index', $this->data);			
        }	

		
	}

}