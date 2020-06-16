<?php
/*
Plugin Name: KSAS Graduate Fields
Plugin URI: https://krieger.jhu.edu
Description: Graduate Fields of Study
Version: 1.0
Author: KSAS Communications
Author URI: mailto:ksasweb@jhu.edu
License: GPL2
*/

// registration code for Graduate Fields of Study post type
	function register_gradstudyfields_posttype() {
		$labels = array(
			'name' 				=> _x( 'Graduate Fields of Study', 'post type general name' ),
			'singular_name'		=> _x( 'Graduate Field of Study', 'post type singular name' ),
			'add_new' 			=> __( 'Add New Graduate Field of Study' ),
			'add_new_item' 		=> __( 'Add New Graduate Field of Study' ),
			'edit_item' 		=> __( 'Edit Graduate Field of Study' ),
			'new_item' 			=> __( 'New Graduate Field of Study' ),
			'view_item' 		=> __( 'View Graduate Field of Study' ),
			'search_items' 		=> __( 'Search Graduate Fields of Study' ),
			'not_found' 		=> __( 'No Graduate Fields of Study found' ),
			'not_found_in_trash'=> __( 'No Graduate Fields of Study found in Trash' ),
			'parent_item_colon' => __( '' ),
			'menu_name'			=> __( 'Graduate Fields of Study' )
		);
				
		$supports = array('title');
		
		$post_type_args = array(
			'labels' 			=> $labels,
			'singular_label' 	=> __('Graduate Field of Study'),
			'public' 			=> true,
			'show_ui' 			=> true,
			'publicly_queryable'=> true,
			'query_var'			=> true,
			'capability_type' 	=> 'post',
			'has_archive' 		=> false,
			'rewrite' 			=> array('slug' => 'programs', 'with_front' => false ),
			'supports' 			=> $supports,
			'menu_position' 	=> 5,
			'show_in_nav_menus' => true,
		 );
		 register_post_type('gradstudyfields',$post_type_args);
	}
	add_action('init', 'register_gradstudyfields_posttype');

$basicinformation_5_metabox = array( 
	'id' => 'basicinformation',
	'title' => 'Basic Information',
	'page' => array('gradstudyfields'),
	'context' => 'normal',
	'priority' => 'default',
	'fields' => array(

				array(
					'name' 			=> 'Department Website',
					'desc' 			=> 'We recommend linking to the Graduate section',
					'id' 				=> 'ecpt_website',
					'class' 			=> 'ecpt_website',
					'type' 			=> 'text',
					'rich_editor' 	=> 0,			
					'max' 			=> 0,
					'std'			=> ''				
				),

				array(
					'name' 			=> 'Contact Name',
					'desc' 			=> '',
					'id' 				=> 'ecpt_contactname',
					'class' 			=> 'ecpt_contactname',
					'type' 			=> 'text',
					'rich_editor' 	=> 0,			
					'max' 			=> 0,
					'std'			=> ''				
				),
				
				array(
					'name' 			=> 'Phone Number',
					'desc' 			=> '',
					'id' 			=> 'ecpt_phonenumber',
					'class' 		=> 'ecpt_phonenumber',
					'type' 			=> 'text',
					'rich_editor' 	=> 0,			
					'max' 			=> 0,
					'default'		=> '',
					'std'			=> ''					
				),
							
				array(
					'name' 			=> 'Email Address',
					'desc' 			=> '',
					'id' 				=> 'ecpt_emailaddress',
					'class' 			=> 'ecpt_emailaddress',
					'type' 			=> 'text',
					'rich_editor' 	=> 0,			
					'max' 			=> 0,
					'default'		=> '',
					'std'			=> ''						
				),

				array(
					'name' 			=> 'Deadline',
					'desc' 			=> 'Please type month in abbreviated format (Jan. 15)',
					'id' 				=> 'ecpt_deadline',
					'class' 			=> 'ecpt_deadline',
					'type' 			=> 'text',
					'rich_editor' 	=> 0,			
					'max' 			=> 0,
					'std'			=> ''						
				),	

				array(
					'name' 			=> 'Additional Deadlines',
					'desc' 			=> 'Please enter degree type, and month in abbreviated format (MA Spring Admission: Jan. 15)',
					'id' 				=> 'ecpt_adddeadline',
					'class' 			=> 'ecpt_adddeadline',
					'type' 			=> 'text',
					'rich_editor' 	=> 0,			
					'max' 			=> 0,
					'std'			=> ''			
				),			
				
				array(
					'name' 			=> 'Degrees Offered',
					'desc' 			=> 'Separate with commas',
					'id' 				=> 'ecpt_degreesoffered',
					'class' 			=> 'ecpt_degreesoffered',
					'type' 			=> 'text',
					'rich_editor' 	=> 1,			
					'max' 			=> 0,
					'default'		=> '',
					'std'			=> ''		
				),
				array(
					'name' 			=> 'Supplemental Materials',
					'desc' 			=> '',
					'id' 				=> 'ecpt_supplementalmaterials',
					'class' 			=> 'ecpt_supplementalmaterials',
					'type' 			=> 'textarea',
					'rich_editor' 	=> 0,			
					'max' 			=> 0,
					'default'			=> '',
					'std'			=> ''					
				),
		)								
);			
			
add_action('admin_menu', 'ecpt_add_basicinformation_5_meta_box');
function ecpt_add_basicinformation_5_meta_box() {

	global $basicinformation_5_metabox;		

	foreach($basicinformation_5_metabox['page'] as $page) {
		add_meta_box($basicinformation_5_metabox['id'], $basicinformation_5_metabox['title'], 'ecpt_show_basicinformation_5_box', $page, 'normal', 'default', $basicinformation_5_metabox);
	}
}

// function to show meta boxes
function ecpt_show_basicinformation_5_box()	{
	global $post;
	global $basicinformation_5_metabox;
	global $ecpt_prefix;
	global $wp_version;
	
	// Use nonce for verification
	echo '<input type="hidden" name="ecpt_basicinformation_5_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($basicinformation_5_metabox['fields'] as $field) {
		// get current post meta data

		$meta = get_post_meta($post->ID, $field['id'], true);
		
		echo '<tr>',
				'<th style="width:20%"><label for="', $field['id'], '">', stripslashes($field['name']), '</label></th>',
				'<td class="ecpt_field_type_' . str_replace(' ', '_', $field['type']) . '">';
		switch ($field['type']) {
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" /><br/>', '', stripslashes($field['desc']);
				break;
			case 'textarea':
			
				if($field['rich_editor'] == 1) {
						echo wp_editor($meta, $field['id'], array('textarea_name' => $field['id'], 'wpautop' => false)); }
					 else {
					echo '<div style="width: 100%;"><textarea name="', $field['id'], '" class="', $field['class'], '" id="', $field['id'], '" cols="60" rows="8" style="width:97%">', $meta ? $meta : $field['default'], '</textarea></div>', '', stripslashes($field['desc']);				
				}
				
				break;
			case 'select':
				echo '<select name="', $field['id'], '" id="', $field['id'], '">';
				foreach ($field['options'] as $option) {
					echo '<option value="' . $option . '"', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				echo '</select>', '', $field['desc'];
				break;
			case 'checkbox':
				echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />&nbsp;';
				echo $field['desc'];
				break;							
		}
		echo     '<td>',
			'</tr>';
	}
	
	echo '</table>';
}	

// Save data from meta box
add_action('save_post', 'ecpt_basicinformation_5_save');
function ecpt_basicinformation_5_save($post_id) {
	global $post;
	global $basicinformation_5_metabox;
	
	// verify nonce
	if (!isset($_POST['ecpt_basicinformation_5_meta_box_nonce']) || !wp_verify_nonce($_POST['ecpt_basicinformation_5_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	
	foreach ($basicinformation_5_metabox['fields'] as $field) {
	
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		
		if ($new && $new != $old) {
			if($field['type'] == 'date') {
				$new = ecpt_format_date($new);
				update_post_meta($post_id, $field['id'], $new);
			} else {
				if(is_string($new)) {
					$new = $new;
				} 
				update_post_meta($post_id, $field['id'], $new);
				
				
			}
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}
?>