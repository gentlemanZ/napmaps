<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Library_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function getList() {
		$query = $this->db->query("SELECT * FROM products WHERE deleted='0' ORDER BY name ASC");

		$products = array();

		if ($query->num_rows() > 0) {

			foreach ($query->result() as $row) {
				$product = array();
				$product['id'] = $row->id;
				$product['name'] = $row->name;
                $product['lat'] = $row->lat;
                $product['lng'] = $row->lng;
				$product['desc'] = $row->description;
                $product['status'] =  $row->status;
                $product['coment'] = '';
				$products[] = $product;
			}
		}

		return $products;
	}

	public function getPackingsList() {
		$query = $this->db->query("SELECT * FROM packings WHERE deleted='0' ORDER BY name ASC");

		$products = array();

		if ($query->num_rows() > 0) {

			foreach ($query->result() as $row) {
				$product = array();
				$product['id'] = $row->id;
				$product['name'] = $row->name;
				$product['desc'] = $row->description;
				$products[] = $product;
			}
		}

		return $products;
	}

	public function addProduct($name, $lat,$lng,$desc) {
		$this->db->query("INSERT INTO products (name,lat,lng,description,status) VALUES ('$name','$lat','$lng','$desc','')");
	}

	public function updateProduct($id, $name, $desc) {
		$this->db->query("UPDATE products SET name='$name', description='$desc' WHERE id='$id'");
	}
    public function updateStatus($id, $status) {
		$this->db->query("UPDATE products SET status = '$status' WHERE name='$id'");
	}

	public function getProduct($id) {
		$query = $this->db->query("SELECT * FROM products WHERE id='$id'");
		$product = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$product['id'] = $row->id;
				$product['name'] = $row->name;
				$product['desc'] = $row->description;
			}
		}

		return $product;
	}

	public function delProduct($id) {
		$this->db->query("UPDATE products SET deleted='1' WHERE id='$id'");
	}

	public function getDescriptions() {
		$query = $this->db->query("SELECT DISTINCT description FROM products WHERE deleted=0");
		$products = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$product['desc'] = $row->description;
				$products[] = $product;
			}
		}
		return $products;
	}

}
