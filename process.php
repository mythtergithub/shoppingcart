<?php
	require_once('config/common.php');
	require_once('config/database.php');
	
	$action = $_POST['action'] ?? '';
	$response = [
		'response' => FALSE,
		'message' => 'Invalid request!',
		'data' => []
	];
	
	$user_data = get_userdata();
	
	switch ($action) {
		case 'login':
			$u = $_POST['user'] ?? '';
			$p = $_POST['pass'] ?? '';
			
			$result = verify_login($u, $p, $LINK);
			
			if ($result['Result'] == '0') {
				$response['response'] = TRUE;
				
				unset($result['data']['passwd']);
				$_SESSION['userdata'] = $result['data'];
				
				$result2=update_user_loginstatus($result['data']['user_id'], 1, $LINK);
				
				$res = log_activity(
					$result['data']['user_id'],
					1,
					'['.$result['data']['username'].'] verify_login: '.$result['Message'].'; update_user_loginstatus(LOGIN): '.$result2['Message'],
					$LINK
				);
			}
			
			$response['message'] = $result['Message'];
			
			header('Content-Type:application/x-json');
			echo json_encode($response);
			
			break;
		
		case 'logout':
			$id = $_POST['id'] ?? '';
			$result = update_user_loginstatus($id, 0, $LINK);
			
			$response['response'] = TRUE;
			$response['message'] = 'Successfully logged out';
			
			log_activity(
				$_POST['id'],
				1,
				'['.$user_data['username'].'] update_user_loginstatus(LOGOUT): '.$result['Message'],
				$LINK
			);
			
			session_destroy();
			
			header('Content-Type:application/x-json');
			echo json_encode($response);
			
			break;
			
		case 'load_products':
			$args = $_POST;
			$result = load_products($args, $LINK);
			
			$response['response'] = $result['Result'] == '0' && !empty($result['data']) ? TRUE : FALSE;
			$response['message'] = $result['Message'];
			$response['data'] = $result['data'];
			
			foreach ($response['data'] as $idx => $val) {
				$response['data'][$idx]['item_name'] = html_entity_decode($val['item_name'], ENT_QUOTES);
				$response['data'][$idx]['item_desc'] = html_entity_decode($val['item_desc'], ENT_QUOTES);
				$response['data'][$idx]['item_status'] = ($val['item_status'] == 1) ? 'active' : 'inactive';
			}
			
			header('Content-Type:application/x-json');
			echo json_encode($response);
			
			break;
			
		case 'load_product_list':
			$args = $_POST;
			$result = load_products($args, $LINK);
			
			$response['response'] = $result['Result'] == '0' && !empty($result['data']) ? TRUE : FALSE;
			$response['message'] = $result['Message'];
			$response['data'] = $result['data'];
			
			foreach ($response['data'] as $idx => $val) {
				$response['data'][$idx]['item_status'] = ($val['item_status'] == 1) ? 'active' : 'inactive';
			}
			
			$response['btns'] = [
							[
								'type' => 'view_modal',
								'label' => 'View',
								'id' => 'item_id',
								'funct' => 'view_product'
							]
						];
			
			header('Content-Type:application/x-json');
			echo json_encode($response);	
			
			break;
		
		case 'load_category_list':
			$args = $_POST;
			$type = $args['type'] ?? ''; 
			$result = load_categories($args, $LINK);
			
			$response['response'] = $result['Result'] == '0' && !empty($result['data']) ? TRUE : FALSE;
			$response['message'] = $result['Message'];
			$response['data'] = $result['data'];
			
			foreach ($response['data'] as $idx => $val) {
				$response['data'][$idx]['category_name'] = html_entity_decode($val['category_name'], ENT_QUOTES);
				$response['data'][$idx]['category_desc'] = html_entity_decode($val['category_desc'], ENT_QUOTES);
			}
			
			if ($type = 'list') {
				$response['btns'] = [
							[
								'type' => 'view_modal',
								'label' => 'View',
								'id' => 'category_id',
								'funct' => 'view_category'
							]
						];
			}
			
			header('Content-Type:application/x-json');
			echo json_encode($response);
			
			break;
			
		case 'save_item':
			$args = $_POST;
			$result = save_item($args, $LINK);
			
			$response['response'] = $result['Result'] == '0' ? TRUE : FALSE;
			$response['message'] = $result['Message'];
			
			$log_type = 6;
			
			if ($result['Result'] == '0') {
				
				switch ($args['type']) {
					case 'update':
						if ($args['oldCat'] != $args['params']['item_category']) {
							$oldFile = IMAGES_DIR . '/' . $args['oldDir'] . '/' . $args['oldCode'] . '.jpg';
							$newFile = IMAGES_DIR . '/' . $args['newDir'] . '/' . $args['params']['item_code'] . '.jpg';
							
							if (file_exists($oldFile)) {
								copy($oldFile, $newFile);
								unlink($oldFile);
							}
						} else if ($args['oldCode'] != $args['params']['item_code']) {
							$oldFile = IMAGES_DIR . '/' . $args['oldDir'] . '/' . $args['oldCode'] . '.jpg';
							$newFile = IMAGES_DIR . '/' . $args['oldDir'] . '/' . $args['params']['item_code'] . '.jpg';
							rename($oldFile,$newFile);
						}
						
						break;
						
					case 'insert':
						$args['params']['item_id'] = $result['data']['item_id'];
						$log_type = 5;
						break;
						
					default:
					
						break;
				}
			}
			
			log_activity(
				$user_data['user_id'],
				$log_type,
				'['.$user_data['username'].'] save_item('.$args['type'].','.$args['params']['item_id'].'): '.$result['Message'],
				$LINK
			);
			
			header('Content-Type:application/x-json');
			echo json_encode($response);
			
			break;
			
		case 'update_item_image':
			$args = $_POST;
			$file = $_FILES['item_image'];
			
			$filepath = IMAGES_DIR . '/' . $args['cat_dir'] . '/' . $args['item_code'] . '.jpg';
			
			if ($file['error'] > 0) {
				$response['message'] = 'File may be corrupted.';
			} else {
				if ($file['size'] > 2097152) {
					$response['message'] = 'File size cannot exceed 2097152 bytes (or 2MB).';
				} else if ($file['type'] != 'image/jpeg') {
					$response['message'] = 'Only *.JPG files are allowed.';
				} else {
					if (move_uploaded_file($file["tmp_name"], $filepath)) {
						$response['response'] = TRUE;
						$response['message'] = 'Successfully updated item image.';
					} else {
						$response['message'] = 'Failed to update item image';
					}
				}
			}
			
			log_activity(
				$user_data['user_id'],
				6,
				'['.$user_data['username'].'] update_item_image(item_code='.$args['item_code'].'): '.$response['message'],
				$LINK
			);
			
			header('Content-Type:application/x-json');
			echo json_encode($response);
			
			break;
		
		case 'save_category':
			$args = $_POST;
			$result = save_category($args, $LINK);
			
			$response['response'] = $result['Result'] == '0' ? TRUE : FALSE;
			$response['message'] = $result['Message'];
			
			if ($result['Result'] == '0') {
				$dir = ($args['oldDir'] != $args['params']['directory']) ? $args['params']['directory'] : $args['oldDir'];
				
				// if ($args['oldDir'] != $args['params']['directory']) {
					// $oldFolder = IMAGES_DIR . '/' . $args['oldDir'];
					// $newFolder = IMAGES_DIR . '/' . $args['params']['directory'];
					
					// if (!file_exists($newFolder)) {
						// rename($oldFolder, $newFolder);
					// }
				// }
				
				if ($args['oldCode'] != $args['params']['category_code']) {
					$prod_list_res = load_products(
						[
							'category' => $args['params']['category_id']
						],
						$LINK
					);
					if ($prod_list_res['Result'] == '0' && !empty($prod_list_res['data'])) {
						foreach ($prod_list_res['data'] as $idx => $val) {
							$itemCode = explode('-', $val['item_code'])[1];
							$newCode = $args['params']['category_code'] . '-' . $itemCode;
							
							save_item(
								[
									'type' => 'update_code',
									'params' => [
										'item_code' => $newCode,
										'item_id' => $val['item_id']
									]
								],
								$LINK
							);
							
							$oldFile = IMAGES_DIR . '/' . $dir . '/' . $args['oldCode'] . '.jpg';
							$newFile = IMAGES_DIR . '/' . $dir . '/' . $newCode . '.jpg';
							
							rename($oldFile, $newFile);
							
							log_activity(
								$user_data['user_id'],
								6,
								'['.$user_data['username'].'] save_item(update_code,'.$args['params']['category_code'].'): '.$result['Message'],
								$LINK
							);
						}
					}
				}
			}
			
			log_activity(
				$user_data['user_id'],
				15,
				'['.$user_data['username'].'] save_category('.$args['type'].','.$args['params']['category_id'].'): '.$result['Message'],
				$LINK
			);
			
			header('Content-Type:application/x-json');
			echo json_encode($response);
			
			break;
			
		case 'update_category_image':
			$args = $_POST;
			$file = $_FILES['category_image'];
			
			$filepath = IMAGES_DIR . '/' . $args['category_code'] . '.jpg';
			
			if ($file['error'] > 0) {
				$response['message'] = 'File may be corrupted.';
			} else {
				if ($file['size'] > 2097152) {
					$response['message'] = 'File size cannot exceed 2097152 bytes (or 2MB).';
				} else if ($file['type'] != 'image/jpeg') {
					$response['message'] = 'Only *.JPG files are allowed.';
				} else {
					if (move_uploaded_file($file["tmp_name"], $filepath)) {
						$response['response'] = TRUE;
						$response['message'] = 'Successfully updated category image.';
					} else {
						$response['message'] = 'Failed to update category image';
					}
				}
			}
			
			log_activity(
				$user_data['user_id'],
				15,
				'['.$user_data['username'].'] update_category_image(category_code='.$args['category_code'].'): '.$response['message'],
				$LINK
			);
			
			header('Content-Type:application/x-json');
			echo json_encode($response);
			
			break;
		
		default:
			
	}
	
?>