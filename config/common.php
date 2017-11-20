<?php
	
	require_once('constant.php');
	
	session_start();
	
	if (!function_exists('debug')){
		function debug($var, $die = TRUE) {
			echo '<pre>';
			var_dump($var);
			echo '</pre>';
			
			if ($die) {
				die;
			}
		}
	}
	
	if (!function_exists('validate_session')){
		function validate_session() {
			if (!isset($_SESSION['userdata'])) {
				return FALSE;
			} else {
				if (COUNT($_SESSION['userdata']) > 0) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		}
	}
	
	if (!function_exists('get_userdata')){
		function get_userdata() {
			if (isset($_SESSION['userdata'])) {
				return $_SESSION['userdata'];
			} else {
				return [];
			}
		}
	}
	
	if (!function_exists('authenticate_user')){
		function authenticate_user($type, $page) {
			if (!isset(PAGES[$type][$page])) {
				header('Location: ' . BASE_URL);
			}
		}
	}

?>