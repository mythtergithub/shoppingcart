<?php
	$page = isset($_GET['page']) ? $_GET['page'] : 'home';
	$subpage = isset($_GET['subpage']) ? $_GET['subpage'] : '';
	$admin = -1;
	$type = 'guest';
	$files = [];
	$javascript_files = [];
	$css_files = [];
	$data = [];
	$has_search = FALSE;
	$search_key = '';
	
	$user_data = [];
	if (validate_session()) {
		$javascript_files[] = '<script src="assets/js/logout.js"></script>';
		$user_data = get_userdata();
		$admin = $user_data['isAdmin'];
		$page = ($admin == 1 && !isset($_GET['page'])) ? 'dashboard' : $page;
		$type = ($admin == 1) ? 'admin' : 'client';
	}
	
	$subpages = SUBMENU[$type][$page] ?? [];
	$subpages_type = '';
	
	switch ($page) {
		case 'home':
			$javascript_files[] = '<script src="assets/js/'.$page.'.js"></script>';
			break;
			
		case 'products':
			authenticate_user($type, $page);
			
			$search_key = $_POST['keyword'] ?? '';
			
			require_once('database.php');
			
			$cat_res = load_categories(['id'=>0], $LINK);
			
			if ( $cat_res['Result'] == '0' && ( !empty($cat_res['data']) && is_array($cat_res['data']) ) ) {
				$subpages = [
					'title' => 'Categories',
					'items' => []
				];
				
				$subpages['items'][0] = 'All Products';
				foreach ($cat_res['data'] as $idx => $val) {
					$subpages['items'][$val['category_id']] = $val['category_name'];
				}
				
				$subpages_type = 'side_menu';
			}
			
			// $view_type = $_GET['view_type'] ?? 'all';
			// switch($view_type) {
				// case 'all':
			// }
			
			$javascript_files[] = '<script src="assets/js/'.$page.'.js"></script>';
			
			break;
			
		case 'about':
			authenticate_user($type, $page);
		
			break;
			
		case 'contact':
			authenticate_user($type, $page);
			
			break;
			
		case 'my_orders':
			authenticate_user($type, $page);
			
			break;
			
		case 'dashboard':
			authenticate_user($type, $page);
			
			break;
			
		case 'product_management':
			authenticate_user($type, $page);
			$subpage = (!empty($subpage)) ? $subpage : 'product_list';
			$subpages_type = 'pages';
			
			switch ($subpage) {
				case 'product_list':
					
					$has_search = TRUE;
					
					$data = [
						'pageNum' => '1',
						'pageSize' => '10',
						'search_controller' => 'load_product_list',
						'search_title' => 'Item',
						'additionals' => '
							<div class="col-lg-4">
								<div class="form-group" id="searchFilter">
									<div class="input-group">
										<span class="input-group-addon">
											<span>Filter Category</span>
										</span>				
										<input type="hidden" class="form-control field" id="filter_category" value="0" />
										<select class="form-control" id="mnuCategory">
											<option value="0">--All Categories--</option>
										</select>
									</div>
								</div>
							</div>
						',
						'table_headers' => [
							[
								'name'	=> '#',
								'width'	=> '3%',
								'alt'	=> 'ctr',
								'class' => ''
							],
							[
								'name'	=> 'Item Code',
								'width'	=> '10%',
								'alt'	=> 'item_code',
								'class' => ''
							],
							[
								'name'	=> 'Item Name',
								'width'	=> '20%',
								'alt'	=> 'item_name',
								'class' => ''
							],
							[
								'name'	=> 'Item Status',
								'width'	=> '10%',
								'alt'	=> 'item_status',
								'class' => ''
							],
							[
								'name'	=> 'Category',
								'width'	=> '20%',
								'alt'	=> 'category_name',
								'class' => ''
							],
							[
								'name'	=> 'Date Added',
								'width'	=> '20%',
								'alt'	=> 'item_dateAdded',
								'class' => ''
							],
							[
								'name'	=> 'Last Modified',
								'width'	=> '20%',
								'alt'	=> 'item_dateModified',
								'class' => ''
							],
							[
								'name'	=> '',
								'width'	=> '10%',
								'alt'	=> 'action',
								'class' => ''
							]
						]
					];
					
					break;
				
				case 'product_add':
					
					break;
				
				case 'product_category':
				
					$has_search = TRUE;
					
					$data = [
						'pageNum' => '1',
						'pageSize' => '10',
						'search_controller' => 'load_category_list',
						'search_title' => 'Category',
						'table_headers' => [
							[
								'name'	=> '#',
								'width'	=> '3%',
								'alt'	=> 'ctr',
								'class' => ''
							],
							[
								'name'	=> 'Category Code',
								'width'	=> '10%',
								'alt'	=> 'category_code',
								'class' => ''
							],
							[
								'name'	=> 'Category Name',
								'width'	=> '20%',
								'alt'	=> 'category_name',
								'class' => ''
							],
							[
								'name'	=> 'Description',
								'width'	=> '20%',
								'alt'	=> 'category_desc',
								'class' => ''
							],
							[
								'name'	=> '',
								'width'	=> '10%',
								'alt'	=> 'action',
								'class' => ''
							]
						]
					];
					
					break;
			}
			
			$javascript_files[] = '<script src="assets/js/'.$page.'/'.$subpage.'.js"></script>';
			if ($has_search) {
				$javascript_files[] = '<script src="assets/js/search-widget-pagination.js"></script>';
			}
			
			break;
			
		case 'order_management':
			authenticate_user($type, $page);
			$subpage = (!empty($subpage)) ? $subpage : 'order_list';
			
			$javascript_files[] = '<script src="assets/js/'.$page.'/'.$subpage.'.js"></script>';
			
			break;
			
		case 'user_management':
			authenticate_user($type, $page);
			$subpage = (!empty($subpage)) ? $subpage : 'user_list';
			
			$javascript_files[] = '<script src="assets/js/'.$page.'/'.$subpage.'.js"></script>';
			
			break;
			
		default:
			$page = '404';
	}
	
	$files[] = (!empty($subpage)) ? 'views/'.$page.'/'.$subpage : 'views/'.$page;
	if ($has_search) {
		$files[] = 'views/search-widget';
	}
?>