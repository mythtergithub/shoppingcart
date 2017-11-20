<?php
	
	require_once('connection.php');
	
	function log_activity($id = FALSE, $type = FALSE, $desc = FALSE, $link = FALSE) {
		
		$result = [
			'Result' => '-1',
			'Message' => 'Failed',
			'data' => []
		];
		
		try {
			
			if (!$link) {
				throw new Exception('No Database Connection');
			}
			
			if (empty($id) || empty($type) || empty($desc)) {
				throw new Exception('Invalid Parameters!');
			}
			
			$sql = "INSERT INTO activity_logs VALUES ('','".$desc."','".DBASE_DATE."',".$type.",'".$id."')";
			$res = $link->query($sql);
			
			if ($res === TRUE) {
				$result['Result'] = '0';
				$result['Message'] = 'Success';
			}
			
		} catch (mysqli_sql_exception $e) {
			
			$result['Result'] = $link->errno;
			$result['Message'] = $e->getMessage();
			
		} catch (Exception $e) {
			
			$result['Message'] = $e->getMessage();
			
		}
		
		return $result;
		
	}
	
	function verify_login($username = '', $password = '', $link = FALSE) {
		
		$result = [
			'Result' => '-1',
			'Message' => 'Failed to verify username and password.',
			'data' => []
		];
		
		try {
			
			if (!$link) {
				throw new Exception('No Database Connection');
			}
			
			if (empty($username) || empty($password)) {
				throw new Exception('Invalid Username and Password!');
			}
			
			$sql = "SELECT * FROM users WHERE username='".$username."' AND passwd=md5('".$password."') LIMIT 1";
			$res = $link->query($sql);
			
			if ($res->num_rows > 0) {
				$result['Result'] = '0';
				$result['Message'] = 'Success';
				$result['data'] = $res->fetch_assoc();
			}
			
		} catch (mysqli_sql_exception $e) {
			
			$result['Result'] = $link->errno;
			$result['Message'] = $e->getMessage();
			
		} catch (Exception $e) {
			
			$result['Message'] = $e->getMessage();
			
		}
		
		return $result;
		
	}
	
	function update_user_loginstatus($id = FALSE, $status = 0, $link = FALSE) {
		
		$result = [
			'Result' => '-1',
			'Message' => 'Failed to update user log status',
			'data' => []
		];
		
		try {
			
			if (!$link) {
				throw new Exception('No Database Connection');
			}
			
			if (empty($id)) {
				throw new Exception('Invalid Parameters!');
			}
			
			$sql = "UPDATE users SET isLoggedin = ".$status." WHERE user_id = '".$id."'";
			$res = $link->query($sql);
			
			if ($res === TRUE) {
				$result['Result'] = '0';
				$result['Message'] = 'Success';
			}
			
		} catch (mysqli_sql_exception $e) {
			$result['Result'] = $link->errno;
			$result['Message'] = $e->getMessage();
		} catch (Exception $e) {
			$result['Message'] = $e->getMessage();
		}
		
		return $result;
		
	}
	
	function count_records($args = [], $link = FALSE) {
		
		$result = [
			'Result' => '-1',
			'Message' => 'Failed to count records.',
			'data' => []
		];
		
		try {
			
			if (!$link) {
				throw new Exception('No Database Connection');
			}
			
			if (empty($args) || !isset($args['table'])) {
				throw new Exception('Invalid Parameters!');
			}
			
			$condition = ( isset($args['condition']) && !empty($args['condition']) ) ? " WHERE " . $args['condition'] : '';
			
			$sql = "SELECT COUNT(*) AS countedRecords FROM " . $args['tables'] . $condition;
			
			$res = $link->query($sql);
			
			if ($res) {
				$row = $res->fetch_assoc();
				
				$result['Result'] = '0';
				$result['Message'] = 'Success';
				$result['data'] = [ 'count' => $row['countedRecords'] ];
			}
			
		} catch (mysqli_sql_exception $e) {
			$result['Result'] = $link->errno;
			$result['Message'] = $e->getMessage() . "; " . $sql;
		} catch (Exception $e) {
			$result['Message'] = $e->getMessage();
		}
		
		return $result;
		
	}
	
	function load_products($args = [], $link = FALSE) {
		
		$result = [
			'Result' => '-1',
			'Message' => 'Failed to load product list/item.',
			'data' => []
		];
		
		$sql = "";
		
		try {
			
			if (!$link) {
				throw new Exception('No Database Connection');
			}
			
			if (empty($args)) {
				throw new Exception('Invalid Parameters!');
			}
			
			$sql = "SELECT * FROM items i, category c WHERE i.item_category = c.category_id";
			$count_sql = "SELECT COUNT(*) AS countedRecords FROM items i, category c WHERE i.item_category = c.category_id";
			
			if ( isset($args['id']) ) {
				if ( !empty($args['id']) ) {
					$sql .= " AND (item_id = '" . $args['id'] . "' OR item_code = '" . $args['id'] . "')";
					$count_sql .= " AND (item_id = '" . $args['id'] . "' OR item_code = '" . $args['id'] . "')";
				}
			}
			
			if ( isset($args['key']) ) {
				if ( !empty($args['key']) ) {
					$sql .= " AND (item_name LIKE '%" . $args['key'] . "%' || item_desc LIKE '%" . $args['key'] . "%')";
					$count_sql .= " AND (item_name LIKE '%" . $args['key'] . "%' || item_desc LIKE '%" . $args['key'] . "%')";
				}
			}
			
			if ( isset($args['status']) ) {
				if ( !empty($args['status']) ) {
					$sql .= " AND item_status = " . $args['status'];
					$count_sql .= " AND item_status = " . $args['status'];
				}
			}
			
			if ( isset($args['category']) ) {
				if ( !empty($args['category']) ) {
					$sql .= " AND i.item_category = " . $args['category'];
					$count_sql .= " AND i.item_category = " . $args['category'];
				}
			}
			
			if ( isset($args['orderby']) && isset($args['orderfield']) ) {
				if ( $args['orderby'] != 'false' && $args['orderfield'] != 'false' ) {
					$sql .= " ORDER BY " . $args['orderby'] . " " . $args['orderfield'];
					$count_sql .= " ORDER BY " . $args['orderby'] . " " . $args['orderfield'];
				}
			}
			
			if ( isset($args['start']) && isset($args['limit']) ) {
				if( $args['start'] == 'false' ) {
					$sql .= " LIMIT " .$args['limit'];
				} else {
					$sql .= " LIMIT " . $args['start'] . ", " . $args['limit'];
				}
			}
			
			$res = $link->query($sql);
			$res2= $link->query($count_sql);
			$row2 = $res2->fetch_assoc();
			
			if ($res->num_rows > 0) {
				$result['Result'] = '0';
				$result['Message'] = 'Success';
				
				while ($row = $res->fetch_assoc()) {
					$row['total_rows'] = $row2['countedRecords'];
					$result['data'][] = $row;
				}
			}
			
		} catch (mysqli_sql_exception $e) {
			$result['Result'] = $link->errno;
			$result['Message'] = $e->getMessage() . "; " . $sql;
		} catch (Exception $e) {
			$result['Message'] = $e->getMessage();
		}
		
		return $result;
	}
	
	function load_categories($args = [], $link = FALSE) {
		
		$result = [
			'Result' => '-1',
			'Message' => 'Failed to load category list/item.',
			'data' => []
		];
		
		$sql = "";
		
		try {
			
			if (!$link) {
				throw new Exception('No Database Connection');
			}
			
			if (empty($args)) {
				throw new Exception('Invalid Parameters!');
			}
			
			$sql = "SELECT * FROM category";
			$count_sql = "SELECT COUNT(*) AS countedRecords FROM category";
			
			if ( !empty($args['id']) ) {
				if ( !empty($args['id']) ) {
					$sql .= " WHERE category_id = '". $args['id'] . "'";
					$count_sql .= " WHERE category_id = '". $args['id'] . "'";
				}
			} else if ( !empty($args['code']) ) {
				if ( !empty($args['code']) ) {
					$sql .= " WHERE category_code = '". $args['code'] . "'";
					$count_sql .= " WHERE category_code = '". $args['code'] . "'";
				}
			} else if ( !empty($args['key']) ) {
				if ( !empty($args['key']) ) {
					$sql .= " WHERE (category_name LIKE '%" . $args['key'] . "%' || category_desc LIKE '%" . $args['key'] . "%')";
					$count_sql .= " WHERE (category_name LIKE '%" . $args['key'] . "%' || category_desc LIKE '%" . $args['key'] . "%')";
				}
			}
			
			$sql .= " ORDER BY category_name ASC";
			$count_sql .= " ORDER BY category_name ASC";
			
			if ( isset($args['start']) && isset($args['limit']) ) {
				if( $args['start'] == 'false' ) {
					$sql .= " LIMIT " .$args['limit'];
				} else {
					$sql .= " LIMIT " . $args['start'] . ", " . $args['limit'];
				}
			}
			
			$res = $link->query($sql);
			$res2= $link->query($count_sql);
			$row2 = $res2->fetch_assoc();
			
			if ($res->num_rows > 0) {
				$result['Result'] = '0';
				$result['Message'] = 'Success';
				
				while ($row = $res->fetch_assoc()) {
					$row['total_rows'] = $row2['countedRecords'];
					$result['data'][] = $row;
				}
			}
			
		} catch (mysqli_sql_exception $e) {
			$result['Result'] = $link->errno;
			$result['Message'] = $e->getMessage() . "; " . $sql;
		} catch (Exception $e) {
			$result['Message'] = $e->getMessage();
		}
		
		return $result;
	}
	
	function save_item($args = [], $link = FALSE) {
		
		$result = [
			'Result' => '-1',
			'Message' => 'Failed to save/update item.',
			'data' => []
		];
		
		$sql = "";
		
		try {
			
			if (!$link) {
				throw new Exception('No Database Connection');
			}
			
			if (empty($args)) {
				throw new Exception('Invalid Parameters!');
			}
			
			$item_id = '';
			
			switch ($args['type']) {
				case 'update':
					$except = array('item_id','item_code','item_dateAdded','item_dateModified');
				
					$sql = "UPDATE items SET ";
					
					foreach ($args['params'] as $idx => $val) {
						if (!in_array($idx, $except)) {
							$sql .= $idx . "='" . htmlentities($val, ENT_QUOTES) . "', ";
						} else {
							if ($idx == 'item_dateModified') {
								$val = DBASE_DATE;
							}
							$sql .= $idx . "='" . $val . "', ";
						}
					}
					
					$sql = substr($sql,0,-2) . " WHERE item_id = '" . $args['params']['item_id'] . "'";
					
					break;
				
				case 'update_code':
					$sql = "UPDATE items SET item_code = '" . $args['params']['item_code'] . "' WHERE item_id = '" . $args['params']['item_id'] . "'";
					
					break;
				case 'insert':
					$item_id = md5($args['params']['item_code'].":".$args['params']['item_name']);
					
					$sql = "INSERT INTO items ";
					$fields = "(item_id, item_dateAdded, item_dateModified, ";
					$values = " VALUES ('" . $item_id . "', '" . DBASE_DATE . "', '" . DBASE_DATE . "', ";
					
					foreach ($args['params'] as $idx => $val) {
						$fields .= $idx.", ";
						$values .= "'".$val."', ";
					}
					
					$fields = substr($fields,0,-2) . ")";
					$values = substr($values,0,-2) . ")";
					
					$sql .= $fields.$values;
					
					break;
				
				default: throw new Exception('Invalid action type.');
			}
			
			if (!empty($sql)) {
				$res = $link->query($sql);
				
				if ($res) {
					$result['Result'] = '0';
					$result['Message'] = 'Success';
					
					$result['data'] = ($args['type'] == 'insert') ? ['item_id' => $item_id] : [];
				}
			} else {
				$result['Message'] = 'Empty query.';
			}
			
		} catch (mysqli_sql_exception $e) {
			$result['Result'] = $link->errno;
			$result['Message'] = $e->getMessage() . "; " . $sql;
		} catch (Exception $e) {
			$result['Message'] = $e->getMessage();
		}
		
		return $result;
	}
	
	function save_category($args = [], $link = FALSE) {
		
		$result = [
			'Result' => '-1',
			'Message' => 'Failed to save/update category.',
			'data' => []
		];
		
		$sql = "";
		
		try {
			
			if (!$link) {
				throw new Exception('No Database Connection');
			}
			
			if (empty($args)) {
				throw new Exception('Invalid Parameters!');
			}
			
			switch ($args['type']) {
				case 'update':
					$except = array('category_id','category_code','directory','category_dateAdded','category_dateModified');
				
					$sql = "UPDATE category SET ";
					
					foreach ($args['params'] as $idx => $val) {
						if (!in_array($idx, $except)) {
							$sql .= $idx . "='" . htmlentities($val, ENT_QUOTES) . "', ";
						} else {
							if ($idx == 'category_dateModified') {
								$val = DBASE_DATE;
							}
							$sql .= $idx . "='" . $val . "', ";
						}
					}
					
					$sql = substr($sql,0,-2) . " WHERE category_id = '" . $args['params']['category_id'] . "'";
					
					break;
					
				case 'insert':
					$sql = "INSERT INTO category ";
					$fields = "(category_dateAdded, category_dateModified, ";
					$values = " VALUES ('" . DBASE_DATE . "', '" . DBASE_DATE . "', ";
					
					foreach ($args['params'] as $idx => $val) {
						$fields .= $idx.", ";
						$values .= "'".$val."', ";
					}
					
					$fields = substr($fields,0,-2) . ")";
					$values = substr($values,0,-2) . ")";
					
					$sql .= $fields.$values;
					
					break;
				
				default: throw new Exception('Invalid action type.');
			}
			
			if (!empty($sql)) {
				$res = $link->query($sql);
				
				if ($res) {
					$result['Result'] = '0';
					$result['Message'] = 'Success';
					
					if ($args['type'] == 'insert') {
						$res2 = load_categories(['code' => $args['params']['category_code']], $link);
						$result['data']['category_id'] = $res2['data'][0]['category_id'] ?? '0';
					}
				}
			} else {
				$result['Message'] = 'Empty query.';
			}
			
		} catch (mysqli_sql_exception $e) {
			$result['Result'] = $link->errno;
			$result['Message'] = $e->getMessage() . "; " . $sql;
		} catch (Exception $e) {
			$result['Message'] = $e->getMessage();
		}
		
		return $result;
	}

?>