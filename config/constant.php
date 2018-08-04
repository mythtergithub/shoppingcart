<?php

	date_default_timezone_set('Asia/Manila');

		define('BASE_URL', '//shopping.cart/');

	$pages = [
		'admin' => [
			'dashboard' => '',
			'product_management' => 'Manage Products',
			'order_management' => 'Manage Orders',
			'user_management' => 'Manage Users',
		],
		'client' => [
			'home' => '',
			'about' => 'About',
			'products' => 'Products',
			'contact' => 'Contact',
			'my_orders' => 'My Orders'
		],
		'guest' => [
			'home' => '',
			'about' => 'About',
			'products' => 'Products',
			'contact' => 'Contact'
		]
	];

	define('PAGES', $pages);

	$submenu = [
		'admin' => [
			'product_management' => [
				'title' => 'Product Management',
				'items' => [
					'product_list' => 'Product List',
					'product_category' => 'Product Categories',
					'product_add' => 'Add New Product',
					'product_category_add' => 'Add New Category',
					'product_report' => 'Product Report'
				]
			],
			'order_management' => [
				'title' => 'Order Management',
				'items' => [
					'order_list' => 'Order Queue',
					'order_report' => 'Order Report'
				]
			],
			'user_management' => [
				'title' => 'User Management',
				'items' => [
					'user_list' => 'User List',
					'user_add' => 'Add New User',
					'user_report' => 'User Reports'
				]
			]
		]
	];

	define('SUBMENU', $submenu);

	define('DBASE_DATE', date('Y-m-d H:i:s'));

	define('IMAGES_DIR', $_SERVER['DOCUMENT_ROOT'] . '/shoppingcart/assets/images/');

?>
