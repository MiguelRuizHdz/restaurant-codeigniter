<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Admin_Controller 
{
	var $currency_code = '';

	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Pedidos';

		$this->load->model('model_orders');
		$this->load->model('model_tables');
		$this->load->model('model_products');
		$this->load->model('model_company');
		$this->load->model('model_stores');

		$this->currency_code = $this->company_currency();
	}

	/* 
	* Solo redirige a la página de gestionar pedidos. 
	*/
	public function index()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Gestionar pedidos';
		$this->render_template('orders/index', $this->data);		
	}

	/*
	* Obtiene los datos de los pedidos de la tabla de pedidos. 
	* Esta función se llama desde la función ajax de la tabla de datos. 
	*/
	public function fetchOrdersData()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$result = array('data' => array());

		$data = $this->model_orders->getOrdersData();

		foreach ($data as $key => $value) {

			$store_data = $this->model_stores->getStoresData($value['store_id']);

			$count_total_item = $this->model_orders->countOrderItem($value['id']);
			$date = date('d-m-Y', $value['date_time']);
			$time = date('h:i a', $value['date_time']);

			$date_time = $date . ' ' . $time;

			// button
			$buttons = '';

			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a target="__blank" href="'.base_url('orders/printDiv/'.$value['id']).'" class="btn btn-warning"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-info"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			if($value['paid_status'] == 1) {
				$paid_status = '<span class="label label-success">Pagado</span>';	
			}
			else {
				$paid_status = '<span class="label label-danger">No Pagado</span>';
			}

			$result['data'][$key] = array(
				$value['bill_no'],
				$store_data['name'],
				$date_time,
				$count_total_item,
				$value['net_amount'],
				$paid_status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* Si la validación no es válida, redirige a la página de creación.
	* Si la validación para cada campo de entrada es válida, inserta los datos en la base de datos
	* y almacena el mensaje de operación en la sesión flashdata y se muestra en la página de gestión de pedidos.
	*/
	public function create()
	{
		if(!in_array('createOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Agregrar pedido';

		$this->form_validation->set_rules('product[]', 'Producto', 'trim|required');
		
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$order_id = $this->model_orders->create();
        	
        	if($order_id) {
        		$this->session->set_flashdata('success', 'Creado con éxito');
        		redirect('orders/update/'.$order_id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Se produjo un error');
        		redirect('orders/create/', 'refresh');
        	}
        }
        else {
            // caso falso
            $this->data['table_data'] = $this->model_tables->getActiveTable();
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$this->data['products'] = $this->model_products->getActiveProductData();      	

            $this->render_template('orders/create', $this->data);
        }	
	}

	/*
	* It gets the product id passed from the ajax method.
	* It checks retrieves the particular product data from the product id 
	* and return the data into the json format.
	*/
	public function getProductValueById()
	{
		$product_id = $this->input->post('product_id');
		if($product_id) {
			$product_data = $this->model_products->getProductData($product_id);
			echo json_encode($product_data);
		}
	}

	/*
	* It gets the all the active product inforamtion from the product table 
	* This function is used in the order page, for the product selection in the table
	* The response is return on the json format.
	*/
	public function getTableProductRow()
	{
		$products = $this->model_products->getActiveProductData();
		echo json_encode($products);
	}

	/*
	* If the validation is not valid, then it redirects to the edit orders page 
	* If the validation is successfully then it updates the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function update($id)
	{
		if(!in_array('updateOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Actualizar pedido';

		// TODO: validar cantidad que sea positivo y que no sea cero
		$this->form_validation->set_rules('product[]', 'Producto', 'trim|required');
		
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
	
        if ($this->form_validation->run() == TRUE) {        	

        	$update = $this->model_orders->update($id);
        	
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Actualizado exitosamente');
        		redirect('orders/update/'.$id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Se produjo un error');
        		redirect('orders/update/'.$id, 'refresh');
        	}
        }
        else {
            // caso falso
        	$this->data['table_data'] = $this->model_tables->getActiveTable();

        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$result = array();
        	$orders_data = $this->model_orders->getOrdersData($id);

        	if(empty($orders_data)) {
        		$this->session->set_flashdata('errors', 'Los datos de la solicitud no existen');
        		redirect('orders', 'refresh');
        	}

    		$result['order'] = $orders_data;
    		$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

    		foreach($orders_item as $k => $v) {
    			$result['order_item'][] = $v;
    		}

    		$table_id = $result['order']['table_id'];
    		$table_data = $this->model_tables->getTableData($table_id);

    		$result['order_table'] = $table_data;

    		$this->data['order_data'] = $result;

        	$this->data['products'] = $this->model_products->getActiveProductData();      	

        	

            $this->render_template('orders/edit', $this->data);
        }
	}

	/*
	* Elimina los datos de la base de datos.
	* y devuelve la respuesta en formato json 
	*/
	public function remove()
	{
		if(!in_array('deleteOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$order_id = $this->input->post('order_id');

        $response = array();
        if($order_id) {
            $delete = $this->model_orders->remove($order_id);
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

	/*
	* Obtiene el id del producto y obtiene los datos del pedido.
	* La lógica de impresión (Factura) del pedido se realiza aquí. 
	*/
	public function printDiv($id)
	{
		if(!in_array('viewOrder', $this->permission)) {
          	redirect('dashboard', 'refresh');
  		}
        
		if($id) {
			$order_data = $this->model_orders->getOrdersData($id);
			$orders_items = $this->model_orders->getOrdersItemData($id);
			$company_info = $this->model_company->getCompanyData(1);
			$store_data = $this->model_stores->getStoresData($order_data['store_id']);

			$order_date = date('d/m/Y', $order_data['date_time']);
			$paid_status = ($order_data['paid_status'] == 1) ? "Pagado" : "No pagado";

			$table_data = $this->model_tables->getTableData($order_data['table_id']);

			if ($order_data['discount'] > 0) {
				$discount = $this->currency_code . ' ' .$order_data['discount'];
			}
			else {
				$discount = '0';
			}


			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <title>Factura</title>
			  <!-- Tell the browser to be responsive to screen width -->
			  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			  <!-- Bootstrap 3.3.7 -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css').'">
			  <!-- Font Awesome -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/font-awesome/css/font-awesome.min.css').'">
			  <link rel="stylesheet" href="'.base_url('assets/dist/css/AdminLTE.min.css').'">
			</head>
			<body onload="window.print();">
			
			<div class="wrapper">
			  <section class="invoice">
			    <!-- title row -->
			    <div class="row">
			      <div class="col-xs-12">
			        <h2 class="page-header">
			          '.$company_info['company_name'].'
			          <small class="pull-right">Fecha: '.$order_date.'</small>
			        </h2>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- info row -->
			    <div class="row invoice-info">
			      
			      <div class="col-sm-4 invoice-col">
			        <b>Factura ID: </b> '.$order_data['bill_no'].'<br>
			        <b>Restaurante: </b> '.$store_data['name'].'<br>
			        <b>Nombre de la mesa: </b> '.$table_data['table_name'].'<br>
			        <b>Total de productos: </b> '.count($orders_items).'<br><br>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <!-- Table row -->
			    <div class="row">
			      <div class="col-xs-12 table-responsive">
			        <table class="table table-striped">
			          <thead>
			          <tr>
			            <th>Nombre del producto</th>
			            <th>Precio</th>
			            <th>Cantidad</th>
			            <th>Monto</th>
			          </tr>
			          </thead>
			          <tbody>'; 

			          foreach ($orders_items as $k => $v) {

			          	$product_data = $this->model_products->getProductData($v['product_id']); 
			          	
			          	$html .= '<tr>
				            <td>'.$product_data['name'].'</td>
				            <td>'.$this->currency_code . ' ' .$v['rate'].'</td>
				            <td>'.$v['qty'].'</td>
				            <td>'.$this->currency_code . ' ' .$v['amount'].'</td>
			          	</tr>';
			          }
			          
			          $html .= '</tbody>
			        </table>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <div class="row">
			      
			      <div class="col-xs-6 pull pull-right">

			        <div class="table-responsive">
			          <table class="table">
			            <tr>
			              <th style="width:50%">Importe bruto:</th>
			              <td>'.$this->currency_code . ' ' .$order_data['gross_amount'].'</td>
			            </tr>';

			            if($order_data['service_charge_amount'] > 0) {
			            	$html .= '<tr>
				              <th>Cargo por servicio ('.$order_data['service_charge_rate'].'%)</th>
				              <td>'.$this->currency_code .' '.$order_data['service_charge_amount'].'</td>
				            </tr>';
			            }

			            if($order_data['vat_charge_amount'] > 0) {
			            	$html .= '<tr>
				              <th>Cargo por IVA ('.$order_data['vat_charge_rate'].'%)</th>
				              <td>'.$this->currency_code .' '.$order_data['vat_charge_amount'].'</td>
				            </tr>';
			            }
			            
			            
			            $html .=' <tr>
			              <th>Descuento:</th>
			              <td>'.$discount.'</td>
			            </tr>
			            <tr>
			              <th>Importe neto:</th>
			              <td>'.$this->currency_code . ' ' .$order_data['net_amount'].'</td>
			            </tr>
			            <tr>
			              <th>Estado de pago:</th>
			              <td>'.$paid_status.'</td>
			            </tr>
			          </table>
			        </div>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->
			  </section>
			  <!-- /.content -->
			</div>
		</body>
	</html>';

			  echo $html;
		}
	}

}