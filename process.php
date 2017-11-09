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
			$result = load_categories($args, $LINK);
			
			$response['response'] = $result['Result'] == '0' && !empty($result['data']) ? TRUE : FALSE;
			$response['message'] = $result['Message'];
			$response['data'] = $result['data'];
			
			header('Content-Type:application/x-json');
			echo json_encode($response);
			
			break;
			
		case 'save_item':
			$args = $_POST;
			$result = save_item($args, $LINK);
			
			$response['response'] = $result['Result'] == '0' ? TRUE : FALSE;
			$response['message'] = $result['Message'];
			
			log_activity(
				$user_data['user_id'],
				6,
				'['.$user_data['username'].'] save_item('.$args['type'].','.$args['params']['item_id'].'): '.$result['Message'],
				$LINK
			);
			
			header('Content-Type:application/x-json');
			echo json_encode($response);
			
			break;
		
		default:
			
	}
	
?>