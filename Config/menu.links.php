<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

return array(
	array(
		'module' => 'Pages',
		'services' => array(
			'Pages' => 'pageManager'
		)
	),

	array(
		'module' => 'Photogallery',
		'services' => array(
			'Photogallery' => 'albumManager'
		)
	),

	array(
		'module' => 'News',
		'services' => array(
			'News (Categories)' => 'categoryManager',
			'News (Posts)' => 'postManager'
		)
	),

	array(
		'module' => 'Shop',
		'services' => array(
			'Shop (Categories)' => 'categoryManager',
			'Shop (Products)' => 'productManager'
		)
	),

	array(
		'module' => 'Blog',
		'services' => array(
			'Blog (Categories)' => 'categoryManager',
			'Blog (Posts)' => 'postManager'
		)
	),

	array(
		'module' => 'Announcement',
		'services' => array(
			'Announcements' => 'announceManager'
		)
	),

	array(
		'module' => 'MailForm',
		'services' => array(
			'Mail forms' => 'formManager'
		)
	)
);
