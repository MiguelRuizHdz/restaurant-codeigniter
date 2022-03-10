<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Productos';

		$this->load->model('model_products');
		$this->load->model('model_category');
		$this->load->model('model_stores');
	}

    /* 
    * It only redirects to the manage product page
    */
	public function index()
	{
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->render_template('products/index', $this->data);	
	}

    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
	public function fetchProductData()
	{
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		$result = array('data' => array());

		$data = $this->model_products->getProductData();

		foreach ($data as $key => $value) {
            $store_ids = json_decode($value['store_id']);
            
            
            $store_name = array();
            foreach ($store_ids as $k => $v) {
                $store_data = $this->model_stores->getStoresData($v);
                $store_name[] = $store_data['name'];
            }

            $store_name = implode(', ', $store_name);
            

			// button
            $buttons = '';
            if(in_array('updateProduct', $this->permission)) {
    			$buttons .= '<a href="'.base_url('products/update/'.$value['id']).'" class="btn btn-info"><i class="fa fa-pencil"></i></a>';
            }

            if(in_array('deleteProduct', $this->permission)) { 
    			$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }
			

			$img = '<img src="'.base_url($value['image']).'" alt="'.$value['name'].'" class="img-circle" width="50" height="50" />';

            $availability = ($value['active'] == 1) ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>';

			$result['data'][$key] = array(
				$img,
				$value['name'],
                $value['price'],
				$store_name,
                $availability,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}	
    
    /*
    * ver el producto basado en el restaurante
    * el administrador puede ver toda la información de los productos
    */
    public function viewproduct()
    {
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $company_currency = $this->company_currency();
        // obtener todas las categorías
        $category_data = $this->model_category->getCategoryData();

        $result = array();
        
        foreach ($category_data as $k => $v) {
            $result[$k]['category'] = $v;
            $result[$k]['products'] = $this->model_products->getProductDataByCat($v['id']);
        }

        // en base a la categoría obtiene todos los productos 

        $html = '<!-- Main content -->
                    <!DOCTYPE html>
                    <html>
                    <head>
                      <meta charset="utf-8">
                      <meta http-equiv="X-UA-Compatible" content="IE=edge">
                      <title>Invoice</title>
                      <!-- Tell the browser to be responsive to screen width -->
                      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
                      <!-- Bootstrap 3.3.7 -->
                      <link rel="stylesheet" href="'.base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css').'">
                      <!-- Font Awesome -->
                      <link rel="stylesheet" href="'.base_url('assets/bower_components/font-awesome/css/font-awesome.min.css').'">
                      <link rel="stylesheet" href="'.base_url('assets/dist/css/AdminLTE.min.css').'">
                    </head>
                    <body>
                    
                    <div class="wrapper">
                      <section class="invoice">

                        <div class="row">
                        ';
                            foreach ($result as $k => $v) {
                                $html .= '<div class="col-md-6">
                                    <div class="product-info">
                                        <div class="category-title">
                                            <h1>'.$v['category']['name'].'</h1>
                                        </div>';

                                        if(count($v['products']) > 0) {
                                            foreach ($v['products'] as $p_key => $p_value) {
                                                $html .= '<div class="product-detail">
                                                            <div class="product-name" style="display:inline-block;">
                                                                <h5>'.$p_value['name'].'</h5>
                                                            </div>
                                                            <div class="product-price" style="display:inline-block;float:right;">
                                                                <h5>'.$company_currency . ' ' . $p_value['price'].'</h5>
                                                            </div>
                                                        </div>';
                                            }
                                        }
                                        else {
                                            $html .= 'N/A';
                                        }        
                                    $html .='</div>
                                        
                                </div>';
                            }
                        

                        $html .='
                        </div>
                      </section>
                      <!-- /.content -->
                    </div>
                </body>
            </html>';

                      echo $html;
    }

    /*
    * Si la validación no es válida, redirige a la página de creación.
    * Si la validación de cada campo de entrada es válido, inserta los datos en la base de datos
    * y almacena el mensaje de operación en los datos flash de la sesión y se muestra en la página de gestión del producto
    */
	public function create()
	{
		if(!in_array('createProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->form_validation->set_rules('product_name', 'Nombre del producto', 'trim|required');
		$this->form_validation->set_rules('price', 'Precio', 'trim|required|numeric');
		$this->form_validation->set_rules('active', 'Estado', 'trim|required');
		
        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
	
        if ($this->form_validation->run() == TRUE) {
            // caso verdadero
        	$upload_image = $this->upload_image();

        	$data = array(
        		'name' => $this->input->post('product_name'),
        		'price' => $this->input->post('price'),
        		'image' => $upload_image,
        		'description' => $this->input->post('description'),
        		'category_id' => json_encode($this->input->post('category')),
                'store_id' => json_encode($this->input->post('store')),
        		'active' => $this->input->post('active'),
        	);

        	$create = $this->model_products->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Creado con éxito');
        		redirect('products/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Se produjo un error');
        		redirect('products/create', 'refresh');
        	}
        }
        else {
            // caso falso

        	// attributes 
        	// $attribute_data = $this->model_attributes->getActiveAttributeData();


        	// $this->data['attributes'] = $attributes_final_data;
			// $this->data['brands'] = $this->model_brands->getActiveBrands();        	
			$this->data['category'] = $this->model_category->getActiveCategory();        	
			$this->data['stores'] = $this->model_stores->getActiveStore();        	

            $this->render_template('products/create', $this->data);
        }	
	}

    /*
    * Esta función se invoca desde otra función para cargar la imagen en la carpeta assets.
    * y retorna la ruta de la imagen 
    */
	public function upload_image()
    {
    	// assets/images/product_image
        $config['upload_path'] = 'assets/images/product_image';
        $config['file_name'] =  uniqid();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000';

        // $config['max_width']  = '1024';s
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('product_image'))
        {
            $error = $this->upload->display_errors();
            return $error;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $type = explode('.', $_FILES['product_image']['name']);
            $type = $type[count($type) - 1];
            
            $path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
            return ($data == true) ? $path : false;            
        }
    }

    /*
    * Si la validación no es válida, redirige a la página de editar el producto.
    * Si la validación es exitosa, actualiza los datos en la base de datos
    * y almacena el mensaje de operación en los datos flash de la sesión y se muestra en la página de getión del producto
    */
	public function update($product_id)
	{      
        if(!in_array('updateProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if(!$product_id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('product_name', 'Nombre del producto', 'trim|required');
        $this->form_validation->set_rules('price', 'Precio', 'trim|required|numeric');
        $this->form_validation->set_rules('active', 'Estado', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            // caso verdadero
            
            $data = array(
                'name' => $this->input->post('product_name'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'category_id' => json_encode($this->input->post('category')),
                'store_id' => json_encode($this->input->post('store')),
                'active' => $this->input->post('active'),
            );

            
            if($_FILES['product_image']['size'] > 0) {
                $upload_image = $this->upload_image();
                $upload_image = array('image' => $upload_image);
                
                $this->model_products->update($upload_image, $product_id);
            }

            $update = $this->model_products->update($data, $product_id);
            if($update == true) {
                $this->session->set_flashdata('success', 'Actualizado exitosamente');
                redirect('products/', 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Se produjo un error');
                redirect('products/update/'.$product_id, 'refresh');
            }
        }
        else {
                    
            $this->data['category'] = $this->model_category->getActiveCategory();           
            $this->data['stores'] = $this->model_stores->getActiveStore();          

            $product_data = $this->model_products->getProductData($product_id);
            $this->data['product_data'] = $product_data;
            $this->render_template('products/edit', $this->data); 
        }   
	}

    /*
    * Elimina los datos de la base de datos
    * y devuelve la respuesta en formato json 
    */
	public function remove()
	{
        if(!in_array('deleteProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $product_id = $this->input->post('product_id');

        $response = array();
        if($product_id) {
            $delete = $this->model_products->remove($product_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Eliminado exitosamente"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error en la base de datos al eliminar la información del producto";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Actualiza la página de nuevo. ";
        }

        echo json_encode($response);
	}

}