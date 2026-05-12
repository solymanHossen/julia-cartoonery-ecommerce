<?php
/**
 * Home Videos Section
 * Dynamic video management for the front page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function julias_register_videos_post_type() {
	$labels = array(
		'name'               => __( 'Videos', 'julias-cartoonery' ),
		'singular_name'      => __( 'Video', 'julias-cartoonery' ),
		'menu_name'          => __( 'Videos', 'julias-cartoonery' ),
		'add_new'            => __( 'Add New Video', 'julias-cartoonery' ),
		'add_new_item'       => __( 'Add New Video', 'julias-cartoonery' ),
		'edit_item'          => __( 'Edit Video', 'julias-cartoonery' ),
		'new_item'           => __( 'New Video', 'julias-cartoonery' ),
		'view_item'          => __( 'View Video', 'julias-cartoonery' ),
		'all_items'          => __( 'All Videos', 'julias-cartoonery' ),
		'search_items'       => __( 'Search Videos', 'julias-cartoonery' ),
		'not_found'          => __( 'No videos found.', 'julias-cartoonery' ),
		'not_found_in_trash' => __( 'No videos found in Trash.', 'julias-cartoonery' ),
	);

	register_post_type(
		'video_item',
		array(
			'labels'              => $labels,
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'has_archive'         => false,
			'hierarchical'        => false,
			'menu_position'       => 21,
			'menu_icon'           => 'dashicons-format-video',
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		)
	);
}
add_action( 'init', 'julias_register_videos_post_type' );

function julias_add_video_metabox() {
	add_meta_box(
		'julias_video_meta',
		__( 'Video Settings', 'julias-cartoonery' ),
		'julias_video_metabox_callback',
		'video_item',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'julias_add_video_metabox' );

function julias_video_metabox_callback( $post ) {
	wp_nonce_field( 'julias_video_nonce', 'julias_video_nonce' );

	$video_url = get_post_meta( $post->ID, 'julias_video_url', true );
	$video_type = get_post_meta( $post->ID, 'julias_video_type', true ) ?: 'long';
	$video_duration = get_post_meta( $post->ID, 'julias_video_duration', true );
	$video_order = get_post_meta( $post->ID, 'julias_video_order', true ) ?: 0;
	$video_label = get_post_meta( $post->ID, 'julias_video_label', true );
	?>
	<div style="display:grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px;">
		<div>
			<label for="julias_video_url" style="display:block; margin-bottom:6px; font-weight:700;">Video URL</label>
			<input type="url" id="julias_video_url" name="julias_video_url" value="<?php echo esc_attr( $video_url ); ?>" placeholder="https://youtube.com/watch?v=..." style="width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:10px;" />
		</div>

		<div>
			<label for="julias_video_type" style="display:block; margin-bottom:6px; font-weight:700;">Layout Type</label>
			<select id="julias_video_type" name="julias_video_type" style="width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:10px;">
				<option value="long" <?php selected( $video_type, 'long' ); ?>>Long Video</option>
				<option value="short" <?php selected( $video_type, 'short' ); ?>>Short / Shorts</option>
			</select>
		</div>

		<div>
			<label for="julias_video_duration" style="display:block; margin-bottom:6px; font-weight:700;">Duration</label>
			<input type="text" id="julias_video_duration" name="julias_video_duration" value="<?php echo esc_attr( $video_duration ); ?>" placeholder="10:15" style="width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:10px;" />
		</div>

		<div>
			<label for="julias_video_order" style="display:block; margin-bottom:6px; font-weight:700;">Display Order</label>
			<input type="number" id="julias_video_order" name="julias_video_order" value="<?php echo esc_attr( $video_order ); ?>" min="0" step="1" style="width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:10px;" />
		</div>

		<div style="grid-column: 1 / -1;">
			<label for="julias_video_label" style="display:block; margin-bottom:6px; font-weight:700;">Badge Label</label>
			<input type="text" id="julias_video_label" name="julias_video_label" value="<?php echo esc_attr( $video_label ); ?>" placeholder="Featured, New, Shorts" style="width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:10px;" />
		</div>
	</div>
	<p style="margin-top:12px; color:#6b7280;">Use the featured image as the video thumbnail. Paste a YouTube, Shorts, Vimeo, or direct video URL.</p>
	<?php
}

function julias_save_video_meta( $post_id ) {
	if ( ! isset( $_POST['julias_video_nonce'] ) || ! wp_verify_nonce( $_POST['julias_video_nonce'], 'julias_video_nonce' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$video_url = isset( $_POST['julias_video_url'] ) ? esc_url_raw( wp_unslash( $_POST['julias_video_url'] ) ) : '';
	$video_type = isset( $_POST['julias_video_type'] ) && in_array( wp_unslash( $_POST['julias_video_type'] ), array( 'long', 'short' ), true ) ? wp_unslash( $_POST['julias_video_type'] ) : 'long';
	$video_duration = isset( $_POST['julias_video_duration'] ) ? sanitize_text_field( wp_unslash( $_POST['julias_video_duration'] ) ) : '';
	$video_order = isset( $_POST['julias_video_order'] ) ? absint( $_POST['julias_video_order'] ) : 0;
	$video_label = isset( $_POST['julias_video_label'] ) ? sanitize_text_field( wp_unslash( $_POST['julias_video_label'] ) ) : '';

	update_post_meta( $post_id, 'julias_video_url', $video_url );
	update_post_meta( $post_id, 'julias_video_type', $video_type );
	update_post_meta( $post_id, 'julias_video_duration', $video_duration );
	update_post_meta( $post_id, 'julias_video_order', $video_order );
	update_post_meta( $post_id, 'julias_video_label', $video_label );
}
add_action( 'save_post_video_item', 'julias_save_video_meta' );

function julias_get_video_image_data( $post_id, $size = 'large' ) {
	$attachment_id = get_post_thumbnail_id( $post_id );

	if ( ! $attachment_id ) {
		return array(
			'id'     => 0,
			'url'    => '',
			'alt'    => '',
			'width'  => 0,
			'height' => 0,
			'srcset' => '',
			'sizes'  => '',
		);
	}

	$image = wp_get_attachment_image_src( $attachment_id, $size );
	$alt   = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

	return array(
		'id'     => $attachment_id,
		'url'    => $image ? $image[0] : '',
		'alt'    => $alt !== '' ? $alt : get_the_title( $post_id ),
		'width'  => $image ? (int) $image[1] : 0,
		'height' => $image ? (int) $image[2] : 0,
		'srcset' => wp_get_attachment_image_srcset( $attachment_id, $size ),
		'sizes'  => wp_get_attachment_image_sizes( $attachment_id, $size ),
	);
}

function julias_get_home_videos() {
	$query = new WP_Query(
		array(
			'post_type'      => 'video_item',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'meta_value_num' => 'ASC',
				'date'           => 'DESC',
			),
			'meta_key'       => 'julias_video_order',
		)
	);

	$videos = array();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$video_id = get_the_ID();
			$video_type = get_post_meta( $video_id, 'julias_video_type', true ) ?: 'long';

			$videos[] = array(
				'id'          => $video_id,
				'type'        => $video_type,
				'label'       => get_post_meta( $video_id, 'julias_video_label', true ),
				'title'       => get_the_title(),
				'description' => get_the_excerpt(),
				'video_url'   => get_post_meta( $video_id, 'julias_video_url', true ),
				'duration'    => get_post_meta( $video_id, 'julias_video_duration', true ),
				'thumbnail'   => julias_get_video_image_data( $video_id, 'large' ),
			);
		}
		wp_reset_postdata();
	}

	return apply_filters( 'julias_home_videos', $videos );
}