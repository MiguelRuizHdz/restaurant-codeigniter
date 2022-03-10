<?php 

class Model_category extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	// Obtener la info de las Categorías
	public function getCategoryData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM category WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM category ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// Inserta la data en la tabla de categorías
	public function create($data = array())
	{
		if($data) {
			$create = $this->db->insert('category', $data);
			return ($create == true) ? true : false;
		}
	}

	// actualiza la data de la categoría con el id en la tabla de categorías
	public function update($id = null, $data = array())
	{
		if($id && $data) {
			$this->db->where('id', $id);
			$update = $this->db->update('category', $data);
			return ($update == true) ? true : false;
		}
	}

	// elimina de la base de datos la categoría
	public function remove($id = null)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('category');
			return ($delete == true) ? true : false;
		}
	}

	// Obtiene las categorías activas
	public function getActiveCategory()
	{
		$sql = "SELECT * FROM category WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	// Cuenta el total de categorías que estan activas
	public function countTotalCategory()
	{
		$sql = "SELECT * FROM category WHERE active = 1";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}
}