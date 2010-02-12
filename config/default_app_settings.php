<?php
/**
 * Example config file
 *
 * PHP versions 4 and 5
 *
 * Copyright (c) 2010, YourNameOrCompany
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) 2010, YourNameOrCompany
 * @link          www.yoursite.com
 * @package       mi_lists
 * @subpackage    mi_lists.config
 * @since         v 1.0 (11-Feb-2010)
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
$config = array (
	'Lists' => array (
		'1' => array (
			'name' => array (
				'description' => 'Name for this List',
				'value' => 'First List',
				'type' => 'string',
			),
			'description' => array (
				'description' => 'Description for this list',
				'value' => 'A list of 2 entries',
				'type' => 'string',
			),
			'relatedId' => array (
				'description' => 'This allows updating multiple lists at once, can be anything',
				'value' => '1',
				'type' => 'string',
			),
			'priority' => array (
				'description' => 'Used for order with relatedId, If autopopulated, what order should the list be processed in.',
				'value' => 1,
				'type' => 'integer',
			),
			'limit' => array (
				'description' => 'Maximum number of rows to show in this list',
				'value' => 2,
				'type' => 'integer',
			),
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
			'allowAutoUpdate' => array (
				'description' => 'Allow auto updating?',
				'value' => true,
				'type' => 'bool',
			),
			'order' => array (
				'description' => 'If auto updating, what field to use in the sort order?',
				'value' => 'created',
				'type' => 'string',
			)
		),
		'2' => array (
			'name' => array (
				'description' => 'Name for this List',
				'value' => 'Second List',
				'type' => 'string',
			),
			'description' => array (
				'description' => 'Description for this list',
				'value' => 'A list of 6 entries',
				'type' => 'string',
			),
			'relatedId' => array (
				'description' => 'This allows updating multiple lists at once, can be anything',
				'value' => '1',
				'type' => 'string',
			),
			'priority' => array (
				'description' => 'Used for order with relatedId, If autopopulated, what order should the list be processed in.',
				'value' => 2,
				'type' => 'integer',
			),
			'limit' => array (
				'description' => 'Maximum number of rows to show in this list',
				'value' => 6,
				'type' => 'integer',
			),
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
			'allowAutoUpdate' => array (
				'description' => 'Allow auto updating?',
				'value' => true,
				'type' => 'bool',
			),
			'order' => array (
				'description' => 'If auto updating, what field to use in the sort order?',
				'value' => 'created',
				'type' => 'string',
			)
		),
		'3' => array (
			'name' => array (
				'description' => 'Name for this List',
				'value' => 'Bottom',
				'type' => 'string',
			),
			'description' => array (
				'description' => 'Description for this list',
				'value' => 'A list of 8 entries',
				'type' => 'string',
			),
			'relatedId' => array (
				'description' => 'This allows updating multiple lists at once, can be anything',
				'value' => '1',
				'type' => 'string',
			),
			'priority' => array (
				'description' => 'Used for order with relatedId, If autopopulated, what order should the list be processed in.',
				'value' => 3,
				'type' => 'integer',
			),
			'limit' => array (
				'description' => 'Maximum number of rows to show in this list',
				'value' => 8,
				'type' => 'integer',
			),
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
			'allowAutoUpdate' => array (
				'description' => 'Allow auto updating?',
				'value' => true,
				'type' => 'bool',
			),
			'order' => array (
				'description' => 'If auto updating, what field to use in the sort order?',
				'value' => 'created',
				'type' => 'string',
			)
		)
	)
);