<?php
/**
 * Example config file
 *
 * Structure for mutiple related lists:
 * 	Lists
 * 		SuperName
 * 			model
 * 			conditions
 * 			autoUpdate
 * 			order
 * 			sublists
 * 				ListId
 * 					ListName
 * 					ListDescription
 * 					limit
 * 				ListId
 * 					ListName
 * 					ListDescription
 * 					limit
 *
 * Strucutre for single list
 * 	Lists
 * 		SuperName
 * 			sublists
 * 				ListId
 * 					ListName
 * 					ListDescription
 * 					limit
 * 					model
 * 					conditions
 * 					autoUpdate
 * 					order
 * 					ListDescription
 * 					limit
 *
 *
 * PHP versions 5
 *
 * Copyright (c) 2010, Andy Dawson
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) 2010, Andy Dawson
 * @link          www.ad7six.com
 * @package       mi_lists
 * @subpackage    mi_lists.config
 * @since         v 1.0 (11-Feb-2010)
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
$config = array (
	'MiLists' => array (
		'home' => array (
			'model' => array (
				'description' => 'Which model to use',
				'value' => 'Entry',
				'type' => 'string',
			),
			'conditions' => array (
				'description' => 'Conditions to apply when looking for the pick list',
				'value' => json_encode(array('Entry.status' => 'published')),
				'type' => 'array',
			),
			'autoUpdate' => array (
				'description' => 'Allow auto updating? Yes|Manual|no',
				'value' => 'Yes',
				'type' => 'string',
			),
			'order' => array (
				'description' => 'If auto updating, what field to use in the sort order?',
				'value' => 'created DESC',
				'type' => 'string',
			),
			'sublists' => array (
				'1' => array (
					'name' => array (
						'description' => 'Description for this list',
						'value' => 'Main',
						'type' => 'string',
					),
					'description' => array (
						'description' => 'Description for this list',
						'value' => 'A list of 2 entries',
						'type' => 'string',
					),
					'limit' => array (
						'description' => 'Maximum number of rows to show in this list',
						'value' => 1,
						'type' => 'integer',
					),
				),
				'2' => array (
					'name' => array (
						'description' => 'Name for this list',
						'value' => 'Featured',
						'type' => 'string',
					),
					'description' => array (
						'description' => 'Description for this list',
						'value' => 'A list of 6 entries',
						'type' => 'string',
					),
					'limit' => array (
						'description' => 'Maximum number of rows to show in this list',
						'value' => 3,
						'type' => 'integer',
					)
				),
				'3' => array (
					'name' => array (
						'description' => 'Name for this list',
						'value' => 'Latest',
						'type' => 'string',
					),
					'description' => array (
						'description' => 'Description for this list',
						'value' => 'A list of 8 entries',
						'type' => 'string',
					),
					'limit' => array (
						'description' => 'Maximum number of rows to show in this list',
						'value' => 4,
						'type' => 'integer',
					)
				)
			)
		)
	)
);