<?php
/**
 * KSAS Graduate Fields
 *
 * @package     KSAS_Graduate_Fields
 * @author      KSAS Communications
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: KSAS Graduate Fields
 * Description: Graduate Fields of Study with full security and PHPCS compliance.
 * Version:     2.0
 * Author:      KSAS Communications
 * Text Domain:  ksas-grad-fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. POST TYPE REGISTRATION
 */

/**
 * Registers the 'gradstudyfields' post type.
 *
 * @return void
 */
function ksas_register_gradstudyfields_posttype() {
	$labels = array(
		'name'          => _x( 'Graduate Fields of Study', 'post type general name', 'ksas-grad-fields' ),
		'singular_name' => _x( 'Graduate Field of Study', 'post type singular name', 'ksas-grad-fields' ),
		'add_new'       => __( 'Add New Graduate Field of Study', 'ksas-grad-fields' ),
		'add_new_item'  => __( 'Add New Graduate Field of Study', 'ksas-grad-fields' ),
		'edit_item'     => __( 'Edit Graduate Field of Study', 'ksas-grad-fields' ),
		'menu_name'     => __( 'Graduate Fields', 'ksas-grad-fields' ),
	);

	register_post_type(
		'gradstudyfields',
		array(
			'labels'        => $labels,
			'public'        => true,
			'show_ui'       => true,
			'show_in_rest'  => true,
			'supports'      => array( 'title' ),
			'has_archive'   => false,
			'rewrite'       => array(
				'slug'       => 'programs',
				'with_front' => false,
			),
			'menu_position' => 5,
		)
	);
}
add_action( 'init', 'ksas_register_gradstudyfields_posttype' );

/**
 * 2. META BOX REGISTRATION
 */

/**
 * Adds the 'Basic Information' meta box.
 *
 * @return void
 */
function ksas_add_grad_meta_boxes() {
	add_meta_box(
		'ksas_basic_info',
		__( 'Basic Information', 'ksas-grad-fields' ),
		'ksas_render_grad_meta_box',
		'gradstudyfields',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'ksas_add_grad_meta_boxes' );

/**
 * Renders the meta box HTML.
 *
 * @param WP_Post $post The current post object.
 * @return void
 */
function ksas_render_grad_meta_box( $post ) {
	wp_nonce_field( 'ksas_grad_meta_nonce_action', 'ksas_grad_meta_nonce_field' );

	$fields = array(
		'ecpt_website'               => get_post_meta( $post->ID, 'ecpt_website', true ),
		'ecpt_contactname'           => get_post_meta( $post->ID, 'ecpt_contactname', true ),
		'ecpt_phonenumber'           => get_post_meta( $post->ID, 'ecpt_phonenumber', true ),
		'ecpt_emailaddress'          => get_post_meta( $post->ID, 'ecpt_emailaddress', true ),
		'ecpt_deadline'              => get_post_meta( $post->ID, 'ecpt_deadline', true ),
		'ecpt_adddeadline'           => get_post_meta( $post->ID, 'ecpt_adddeadline', true ),
		'ecpt_degreesoffered'        => get_post_meta( $post->ID, 'ecpt_degreesoffered', true ),
		'ecpt_supplementalmaterials' => get_post_meta( $post->ID, 'ecpt_supplementalmaterials', true ),
	);
	?>
	<table class="form-table">
		<tr>
			<th><label for="ecpt_website"><?php esc_html_e( 'Department Website', 'ksas-grad-fields' ); ?></label></th>
			<td>
				<input type="url" name="ecpt_website" id="ecpt_website" value="<?php echo esc_url( $fields['ecpt_website'] ); ?>" class="widefat" />
				<p class="description"><?php esc_html_e( 'Please link to the Graduate section of your department website.', 'ksas-grad-fields' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="ecpt_contactname"><?php esc_html_e( 'Contact Name', 'ksas-grad-fields' ); ?></label></th>
			<td><input type="text" name="ecpt_contactname" id="ecpt_contactname" value="<?php echo esc_attr( $fields['ecpt_contactname'] ); ?>" class="widefat" /></td>
		</tr>
		<tr>
			<th><label for="ecpt_phonenumber"><?php esc_html_e( 'Phone Number', 'ksas-grad-fields' ); ?></label></th>
			<td><input type="text" name="ecpt_phonenumber" id="ecpt_phonenumber" value="<?php echo esc_attr( $fields['ecpt_phonenumber'] ); ?>" class="widefat" /></td>
		</tr>
		<tr>
			<th><label for="ecpt_emailaddress"><?php esc_html_e( 'Email Address', 'ksas-grad-fields' ); ?></label></th>
			<td><input type="email" name="ecpt_emailaddress" id="ecpt_emailaddress" value="<?php echo esc_attr( $fields['ecpt_emailaddress'] ); ?>" class="widefat" /></td>
		</tr>
		<tr>
			<th><label for="ecpt_deadline"><?php esc_html_e( 'Deadline', 'ksas-grad-fields' ); ?></label></th>
			<td>
				<input type="text" name="ecpt_deadline" id="ecpt_deadline" value="<?php echo esc_attr( $fields['ecpt_deadline'] ); ?>" class="widefat" />
				<p class="description"><?php esc_html_e( 'Please type month in abbreviated format (e.g. Jan. 15)', 'ksas-grad-fields' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="ecpt_adddeadline"><?php esc_html_e( 'Additional Deadlines', 'ksas-grad-fields' ); ?></label></th>
			<td>
				<input type="text" name="ecpt_adddeadline" id="ecpt_adddeadline" value="<?php echo esc_attr( $fields['ecpt_adddeadline'] ); ?>" class="widefat" />
				<p class="description"><?php esc_html_e( 'Please enter degree type, and month in abbreviated format (MA Spring Admission: Jan. 15)', 'ksas-grad-fields' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="ecpt_degreesoffered"><?php esc_html_e( 'Degrees Offered', 'ksas-grad-fields' ); ?></label></th>
			<td>
				<input type="text" name="ecpt_degreesoffered" id="ecpt_degreesoffered" value="<?php echo esc_attr( $fields['ecpt_degreesoffered'] ); ?>" class="widefat" />
				<p class="description"><?php esc_html_e( 'Separate with commas', 'ksas-grad-fields' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="ecpt_supplementalmaterials"><?php esc_html_e( 'Supplemental Materials', 'ksas-grad-fields' ); ?></label></th>
			<td><textarea name="ecpt_supplementalmaterials" id="ecpt_supplementalmaterials" rows="5" class="widefat"><?php echo esc_textarea( $fields['ecpt_supplementalmaterials'] ); ?></textarea></td>
		</tr>
	</table>
	<?php
}

/**
 * 4. SECURE SAVE LOGIC
 *
 * @param int $post_id The ID of the post being saved.
 * @return void
 */
function ksas_save_grad_meta_box_data( $post_id ) {
	// Verify nonce.
	$nonce_field = isset( $_POST['ksas_grad_meta_nonce_field'] ) ? sanitize_text_field( wp_unslash( $_POST['ksas_grad_meta_nonce_field'] ) ) : '';

	if ( ! wp_verify_nonce( $nonce_field, 'ksas_grad_meta_nonce_action' ) ) {
		return;
	}

	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$field_keys = array(
		'ecpt_website'               => 'esc_url_raw',
		'ecpt_contactname'           => 'sanitize_text_field',
		'ecpt_phonenumber'           => 'sanitize_text_field',
		'ecpt_emailaddress'          => 'sanitize_email',
		'ecpt_deadline'              => 'sanitize_text_field',
		'ecpt_adddeadline'           => 'sanitize_text_field',
		'ecpt_degreesoffered'        => 'sanitize_text_field',
		'ecpt_supplementalmaterials' => 'sanitize_textarea_field',
	);

	foreach ( $field_keys as $key => $sanitize_func ) {
		if ( isset( $_POST[ $key ] ) ) {
			// Wrapping unslash directly inside the call clears the "non-sanitized" input error in loops.
			update_post_meta(
				$post_id,
				$key,
				call_user_func( $sanitize_func, wp_unslash( $_POST[ $key ] ) )
			);
		}
	}
}
add_action( 'save_post', 'ksas_save_grad_meta_box_data' );