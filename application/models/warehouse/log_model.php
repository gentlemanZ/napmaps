<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Log_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function getList($group) {
		$query = $this->db->query("SELECT "
				. "products.id AS id, "
				. "products.name AS name, "
				. "products.description AS description, "
				. "counter.sum AS sum "
				. "FROM products LEFT JOIN (SELECT id_product, sum(amount) AS sum FROM `log` WHERE action=$group OR action=5 GROUP BY 1 ORDER BY 2) AS counter "
				. "ON products.id=counter.id_product WHERE products.deleted='0' ORDER BY name ASC");

		$products = array();

		if ($query->num_rows() > 0) {

			foreach ($query->result() as $row) {
				$product = array();
				$product['id'] = $row->id;
				$product['name'] = $row->name;
				$product['desc'] = $row->description;
				if ($row->sum != '') {
					$product['sum'] = $row->sum;
				} else {
					$product['sum'] = 0;
				}
				$products[] = $product;
			}
		}

		return $products;
	}

	// $ngroup is negation group (the one with minuses)
	public function getOrderList($group, $ngroup = 5) {
		$q = "SELECT "
				. "products.id AS id, "
				. "products.name AS name, "
				. "products.description AS description, "
				. "counter.sum AS sum "
				. "FROM products "
				. "JOIN (SELECT id_product, id_order, sum(amount) AS sum, max(id) AS id_log FROM `log` WHERE action=$group OR action=$ngroup GROUP BY 1) AS counter "
				. "ON products.id=counter.id_product "
				. "WHERE products.deleted='0' AND counter.sum<>0 ORDER BY id_log DESC";

		$query = $this->db->query($q);

		$products = array();

		if ($query->num_rows() > 0) {

			foreach ($query->result() as $row) {
				$product = array();
				$product['id'] = $row->id;
				$product['name'] = $row->name;
				$product['desc'] = $row->description;
				if ($row->sum != '') {
					$product['sum'] = $row->sum;
				} else {
					$product['sum'] = 0;
				}
				$products[] = $product;
			}
		}

		return $products;
	}
    public function getCommentList() {
		$query = $this->db->query("SELECT * FROM log ORDER BY id ASC");

		$products = array();

		if ($query->num_rows() > 0) {

			foreach ($query->result() as $row) {
				$product = array();
				$product['id'] = $row->id_product;
				$product['name'] = $row->name_product;
				$product['desc'] = $row->comment;
				$products[] = $product;
			}
		}

		return $products;
	}

	public function getPackingList($group, $ngroup = 0) {

		$q = "SELECT "
				. "products.id AS id, "
				. "products.name AS name, "
				. "products.description AS description, "
				. "packings.id AS packingid, "
				. "packings.name AS packing, "
				. "counter.sum AS sum "
				. "FROM products "
				. "JOIN (SELECT id_product, id_packing, sum(amount) AS sum, max(id) AS id_log FROM `log` WHERE action=$group OR action=$ngroup GROUP BY 1, 2) AS counter "
				. "ON products.id=counter.id_product "
				. "JOIN packings "
				. "ON counter.id_packing = packings.id "
				. "WHERE products.deleted='0' AND counter.sum<>0 ORDER BY id_log DESC";

		$query = $this->db->query($q);

		$products = array();

		if ($query->num_rows() > 0) {

			foreach ($query->result() as $row) {
				$product = array();
				$product['id'] = $row->id;
				$product['name'] = $row->name;
				$product['desc'] = $row->description;
				if ($row->sum != '') {
					$product['sum'] = $row->sum;
				} else {
					$product['sum'] = 0;
				}
				$product['packingid'] = $row->packingid;
				$product['packing'] = $row->packing;
				$products[] = $product;
			}
		}

		return $products;
	}

	public function addAction($name, $amount, $action, $id_packing = 0, $id_order = 0) {
		$id_user = $this->session->userdata('user_id');
		$this->db->query("INSERT INTO log (id_user, action, comment, name_product, id_packing, id_order) "
				. "VALUES ('$id_user', '$action', '$amount', '$name', '$id_packing', '$id_order')");
	}

	public function getStatusList() {
		$query = $this->db->query("SELECT "
				. "products.id AS id, "
				. "products.name AS name, "
				. "products.description AS description, "
				. "counter.sum AS sum "
				. "FROM products JOIN (SELECT id_product, sum(amount) AS sum FROM `log` GROUP BY 1 ORDER BY 2) AS counter "
				. "ON products.id=counter.id_product WHERE products.deleted='0' ORDER BY id");

		$products = array();

		if ($query->num_rows() > 0) {

			foreach ($query->result() as $row) {
				$product = array();
				$product['id'] = $row->id;
				$product['name'] = $row->name;
				$product['desc'] = $row->description;
				$product['sum'] = $row->sum;
				$products[] = $product;
			}
		}

		return $products;
	}

	public function getNewStatusList() {
		$q = "SELECT "
				. "products.id AS id, "
				. "products.name AS name, "
				. "products.description AS description, "
				. "magazyn.sum AS magazyn_sum, "
				. "production.sum AS production_sum, "
				. "onway.sum AS onway_sum "
				. "FROM products "
				. "LEFT JOIN (SELECT id_product, sum(amount) AS sum FROM `log` WHERE action=2 OR action=3 OR action=4 OR action=6 "
				. "GROUP BY 1 ORDER BY 2) AS magazyn "
				. "ON products.id=magazyn.id_product "
				. "LEFT JOIN (SELECT id_product, id_packing, sum(amount) AS sum FROM `log` WHERE action=5 OR action=6 "
				. "GROUP BY 1) AS onway "
				. "ON products.id=onway.id_product "
				. "LEFT JOIN (SELECT id_product, sum(amount) AS sum FROM `log` WHERE action=1 OR action=5 "
				. "GROUP BY 1 ORDER BY 2) AS production "
				. "ON products.id=production.id_product "
				. "WHERE products.deleted='0' ORDER BY name ASC";

		$query = $this->db->query($q);

		$products = array();

		if ($query->num_rows() > 0) {

			foreach ($query->result() as $row) {
				$product = array();
				$product['id'] = $row->id;
				$product['name'] = $row->name;
				$product['desc'] = $row->description;
				$product['magazyn_sum'] = intval($row->magazyn_sum);
				$product['onway_sum'] = intval(0 - $row->onway_sum);
				$product['production_sum'] = intval($row->production_sum);
				$products[] = $product;
			}
		}

		return $products;
	}

	public function getSearchList($start, $end, $product) {

		$starts = date("Y-m-d H:i:s", strtotime($start));
		$ends = date("Y-m-d H:i:s", strtotime($end . ' + 1 day'));

		$qand = "AND (date BETWEEN '$starts' AND '$ends') ";

		$q = "SELECT "
				. "products.id AS id, "
				. "products.name AS name, "
				. "products.description AS description, "
				. "magazyn.sum AS magazyn_sum, "
				. "production.sum AS production_sum, "
				. "given.sum AS given_sum, "
				. "onway.sum AS onway_sum "
				. "FROM products "
				. "LEFT JOIN (SELECT id_product, sum(amount) AS sum FROM `log` WHERE action=2 OR action=3 OR action=4 OR action=6 "
				. "GROUP BY 1 ORDER BY 2) AS magazyn "
				. "ON products.id=magazyn.id_product "
				. "LEFT JOIN (SELECT id_product, id_packing, sum(amount) AS sum FROM `log` WHERE action=5 OR action=6 "
				. "GROUP BY 1) AS onway "
				. "ON products.id=onway.id_product "
				. "LEFT JOIN (SELECT id_product, sum(amount) AS sum FROM `log` WHERE action=1 OR action=5 "
				. "GROUP BY 1 ORDER BY 2) AS production "
				. "ON products.id=production.id_product "
				. "LEFT JOIN (SELECT id_product, sum(amount) AS sum FROM `log` WHERE (action=4) $qand "
				. "GROUP BY 1 ORDER BY 2) AS given "
				. "ON products.id=given.id_product "
				. "WHERE products.deleted='0' ";

		if ($product != '') {
			$q .= "AND products.id=$product ";
		}

		$q .= "ORDER BY name ASC";

		$query = $this->db->query($q);

		$products = array();

		if ($query->num_rows() > 0) {

			foreach ($query->result() as $row) {
				$product = array();
				$product['id'] = $row->id;
				$product['name'] = $row->name;
				$product['desc'] = $row->description;
				$product['magazyn_sum'] = intval($row->magazyn_sum);
				$product['onway_sum'] = intval(0- $row->onway_sum);
				$product['production_sum'] = intval($row->production_sum);
				$product['given_sum'] = intval(0 - $row->given_sum);
				$product['total_sum'] = intval($product['magazyn_sum'] + $product['onway_sum'] + $product['production_sum']);
				$products[] = $product;
			}
		}

		return $products;
	}

	public function getReports($start, $end, $user = null) {

		$starts = date("Y-m-d H:i:s", strtotime($start));
		$ends = date("Y-m-d H:i:s", strtotime($end . ' + 1 day'));

		$report = array();
		$this->load->model('warehouse/library_model');

		$q = "SELECT "
				. "products.id AS pid, "
				. "products.name AS pname, "
				. "log.date AS date, "
				. "users.id AS uid, "
				. "users.login AS login, "
				. "log.action AS action, "
				. "log.amount AS amount "
				. "FROM log "
				. "JOIN products ON log.id_product=products.id "
				. "JOIN users ON log.id_user=users.id "
				. "WHERE (date BETWEEN '$starts' AND '$ends') ";

		if ($user != null) {
			$q .= "AND users.id='$user' ";
		}

		$q .= "ORDER BY log.id DESC";

		$query = $this->db->query($q);

		if ($query->num_rows() > 0) {

			foreach ($query->result() as $row) {
				$log = array();
				$log['pid'] = $row->pid;
				$log['pname'] = $row->pname;
				$log['date'] = $row->date;
				$log['uid'] = $row->uid;
				$log['login'] = $row->login;
				$log['action'] = $this->getLongActionName($row->action);

				// packing change is reverse of others
				if ($row->action == 5) {
					$log['amount'] = 0 - ($row->amount);
				} else {
					$log['amount'] = $row->amount;
				}

				$report[] = $log;
			}
		}

		return $report;
	}

	public function getProReports($start, $end, $desc = null) {

		$starts = date("Y-m-d H:i:s", strtotime($start));
		$ends = date("Y-m-d H:i:s", strtotime($end . ' + 1 day'));

		$report = array();
		$this->load->model('warehouse/library_model');

		$q = "SELECT "
				. "products.id AS pid, "
				. "products.name AS pname, "
				. "products.description AS pdesc, "
				. "log.date AS date, "
				. "users.id AS uid, "
				. "users.login AS login, "
				. "log.action AS action, "
				. "log.amount AS amount "
				. "FROM log "
				. "JOIN products ON log.id_product=products.id "
				. "JOIN users ON log.id_user=users.id "
				. "WHERE (date BETWEEN '$starts' AND '$ends') "
				. "AND action=1 ";

		if ($desc != null) {
			$q .= "AND products.description='$desc' ";
		}

		$q .= "ORDER BY log.id DESC";

		$query = $this->db->query($q);

		if ($query->num_rows() > 0) {

			foreach ($query->result() as $row) {
				$log = array();
				$log['pid'] = $row->pid;
				$log['pname'] = $row->pname;
				$log['date'] = $row->date;
				$log['uid'] = $row->uid;
				$log['login'] = $row->login;
				$log['pdesc'] = $row->pdesc;
				$log['amount'] = $row->amount;
				$report[] = $log;
			}
		}

		return $report;
	}

	private function getLongActionName($action) {
		return $this->lang->line('action_' . $action);
	}

	public function copyActionByPacking($action_from, $action_to, $id_packing) {

		$q = "SELECT "
				. "products.id AS id, "
				. "products.name AS name, "
				. "products.description AS description, "
				. "packings.id AS packingid, "
				. "packings.name AS packing, "
				. "counter.sum AS sum "
				. "FROM products "
				. "JOIN (SELECT id_product, id_packing, sum(amount) AS sum, max(id) AS id_log FROM `log` WHERE action=$action_from AND id_packing=$id_packing GROUP BY 1, 2) AS counter "
				. "ON products.id=counter.id_product "
				. "JOIN packings "
				. "ON counter.id_packing = packings.id "
				. "WHERE products.deleted='0' AND counter.sum<>0 AND packings.id =$id_packing ORDER BY id_log DESC";

		$query = $this->db->query($q);

		$products = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$product = array();
				$product['id'] = $row->id;
				$product['name'] = $row->name;
				$product['desc'] = $row->description;
				if ($row->sum != '') {
					$product['sum'] = $row->sum;
				} else {
					$product['sum'] = 0;
				}
				$product['packingid'] = $row->packingid;
				$product['packing'] = $row->packing;
				$products[] = $product;
			}
		}

		foreach ($products as $product) {
			if ($product['sum'] != 0) {
				$sum = 0 - $product['sum'];
				$this->addAction($product['id'], $sum, $action_to, $product['packingid']);
			}
		}

		return $products;
	}

	public function getBackup($filename, $tables = '*') {

		$host = $this->db->hostname;
		$user = $this->db->username;
		$pass = $this->db->password;
		$name = $this->db->database;

		$link = mysql_connect($host, $user, $pass);
		mysql_select_db($name, $link);

		if ($tables == '*') {
			$tables = array();
			$result = mysql_query('SHOW TABLES');
			while ($row = mysql_fetch_row($result)) {
				$tables[] = $row[0];
			}
		} else {
			$tables = is_array($tables) ? $tables : explode(',', $tables);
		}

		$return = '';

		foreach ($tables as $table) {
			$return.="-- ----------"
					. "\n-- " . $this->lang->line('header_title')
					. "\n-- Table: $table"
					. "\n-- ----------\n";
			$result = mysql_query('SELECT * FROM ' . $table);
			$num_fields = mysql_num_fields($result);

			$return.= 'DROP TABLE ' . $table . ';';
			$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table));
			$return.= "\n\n" . $row2[1] . ";\n\n";

			for ($i = 0; $i < $num_fields; $i++) {
				while ($row = mysql_fetch_row($result)) {
					$return.= 'INSERT INTO ' . $table . ' VALUES(';
					for ($j = 0; $j < $num_fields; $j++) {
						$row[$j] = addslashes($row[$j]);
						$row[$j] = ereg_replace("\n", "\\n", $row[$j]);
						if (isset($row[$j])) {
							$return.= '"' . $row[$j] . '"';
						} else {
							$return.= '""';
						}
						if ($j < ($num_fields - 1)) {
							$return.= ',';
						}
					}
					$return.= ");\n";
				}
			}
			$return.="\n";
		}

		// return file
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Content-Type: text/plain');
		header('Content-Length: ' . strlen($return));
		header('Connection: close');

		echo $return;
		exit;
	}

}
