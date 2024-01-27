<?php


  // Register Custom Post Type
function ah_property_post_type() {

  $labels = array(
    'name'                  => _x( 'Properties', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Property', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'Properties', 'text_domain' ),
    'name_admin_bar'        => __( 'Property', 'text_domain' ),
    'archives'              => __( 'Property Archives', 'text_domain' ),
    'attributes'            => __( 'Property Attributes', 'text_domain' ),
    'parent_item_colon'     => __( 'Parent Property:', 'text_domain' ),
    'all_items'             => __( 'All Properties', 'text_domain' ),
    'add_new_item'          => __( 'Add New Property', 'text_domain' ),
    'add_new'               => __( 'Add New', 'text_domain' ),
    'new_item'              => __( 'New Property', 'text_domain' ),
    'edit_item'             => __( 'Edit Property', 'text_domain' ),
    'update_item'           => __( 'Update Property', 'text_domain' ),
    'view_item'             => __( 'View Property', 'text_domain' ),
    'view_items'            => __( 'View Properties', 'text_domain' ),
    'search_items'          => __( 'Search Property', 'text_domain' ),
    'not_found'             => __( 'Not found', 'text_domain' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
    'featured_image'        => __( 'Featured Image', 'text_domain' ),
    'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
    'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
    'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
    'insert_into_item'      => __( 'Insert into Property', 'text_domain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this Property', 'text_domain' ),
    'items_list'            => __( 'Properties list', 'text_domain' ),
    'items_list_navigation' => __( 'Properties list navigation', 'text_domain' ),
    'filter_items_list'     => __( 'Filter Properties list', 'text_domain' ),
  );
  $args = array(
    'label'                 => __( 'Property', 'text_domain' ),
    'description'           => __( 'Find exclusive and classy properties', 'text_domain' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'thumbnail','custom-fields' ),
    'taxonomies'            => array( 'location' ),
    'hierarchical'          => false,
    'menu_icon'             => "dashicons-admin-multisite",
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'post',
	'register_meta_box_cb' => 'ah_property_metabox'
  );
  register_post_type( 'property', $args );

}
add_action( 'init', 'ah_property_post_type', 0 );


    function ah_property_metabox() {
    	add_meta_box(
    		'property_option_id',
    		'Property Details',
    		'ah_property_options',
    		'property',
    		'normal',
    		'high'
    	);
    }
    

    function ah_property_options() {
	    global $post, $wpdb;
	    // Nonce field to validate form request came from current site
	    wp_nonce_field( basename( __FILE__ ), 'property_options_field' );
	    
	    // Get the location data if it's already been entered
	    $ah_starting_price = get_post_meta( $post->ID, 'ah_starting_price', true );
		$closing_price = get_post_meta( $post->ID, 'ah_closing_price', true );
		$ah_property_short_desc = get_post_meta( $post->ID, 'ah_property_short_desc', true );
		$ah_bathroom_num = get_post_meta( $post->ID, 'ah_bathroom_num', true );
		$ah_bedroom_num = get_post_meta( $post->ID, 'ah_bedroom_num', true );
		
		$ah_kitchen_num = get_post_meta( $post->ID, 'ah_kitchen_num', true );
		$ah_livingroom_num = get_post_meta( $post->ID, 'ah_livingroom_num', true );
			
	   	
		
	    // Output the field
	    echo '<label for="option_one">Starting Price</label><input type="text" name="ah_starting_price" class="widefat" value="'.$ah_starting_price.'"><br><small>This is also the regular price</small>';
		echo '<label for="option_one">Closing Price</label><input type="text" name="ah_closing_price" class="widefat" value="'.$ah_closing_price.'">';
		echo '<label for="option_one">Bedroom</label><input type="text" name="ah_bedroom_num" class="widefat" value="'.$ah_bedroom_num.'">';
		echo '<label for="option_one">Bathroom</label><input type="text" name="ah_bathroom_num" class="widefat" value="'.$ah_bathroom_num.'">';
		
		echo '<label for="option_one">Kitchen</label><input type="text" name="ah_kitchen_num" class="widefat" value="'.$ah_kitchen_num.'">';
		echo '<label for="option_one">Living Room</label><input type="text" name="ah_livingroom_num" class="widefat" value="'.$ah_livingroom_num.'">';
		
		echo '<label for="option_one">Short Description</label><textarea name="ah_property_short_desc" class="widefat">'.$ah_property_short_desc.'</textarea>';
// 		echo '<label for="option_one">Objectives</label><textarea name="wihrini_objectives" class="widefat">'.$wihrini_objectives.'</textarea>';
// 		echo '<label for="option_one">Thematic areas of work</label><textarea name="wihrini_thematic_areas_of_work" class="widefat">'.$wihrini_thematic_areas_of_work.'</textarea>';
// 	    echo '<label for="option_one">Contact address of organization</label><textarea name="wihrini_contact_add_of_org" class="widefat">'.$wihrini_contact_add_of_org.'</textarea>';
    }

	/**
 	* Save the metabox data
 	*/
	function property_save_meta( $post_id, $post ) {
		// Return if the user doesn't have edit permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		// Verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times.
		// 
	
		if ( ! isset( $_POST['ah_starting_price'] ) || ! isset( $_POST['ah_closing_price'] ) || ! isset( $_POST['ah_bathroom_num'] ) || ! isset( $_POST['ah_kitchen_num'] ) || ! isset( $_POST['ah_livingroom_num'] ) || ! isset( $_POST['ah_bedroom_num'] ) || ! isset( $_POST['ah_property_short_desc'] )  || ! wp_verify_nonce( $_POST['property_options_field'], basename(__FILE__) ) ) {
			return $post_id;
		}
		// Now that we're authenticated, time to save the data.
		// This sanitizes the data from the field and saves it into an array $events_meta.
		
		
		if ( get_post_meta( $post_id, 'ah_kitchen_num', false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, 'ah_kitchen_num', $_POST['ah_kitchen_num'] );
		}else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, 'ah_kitchen_num', $_POST['ah_kitchen_num']);
		}
		
		if ( get_post_meta( $post_id, 'ah_livingroom_num', false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, 'ah_livingroom_num', $_POST['ah_livingroom_num'] );
		}else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, 'ah_livingroom_num', $_POST['ah_livingroom_num']);
		}
		
		
		
		if ( get_post_meta( $post_id, 'ah_bedroom_num', false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, 'ah_bedroom_num', $_POST['ah_bedroom_num'] );
		}else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, 'ah_bedroom_num', $_POST['ah_bedroom_num']);
		}
		
		if ( get_post_meta( $post_id, 'ah_bathroom_num', false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, 'ah_bathroom_num', $_POST['ah_bathroom_num'] );
		}else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, 'ah_bathroom_num', $_POST['ah_bathroom_num']);
		}
		
		if ( get_post_meta( $post_id, 'ah_starting_price', false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, 'ah_starting_price', $_POST['ah_starting_price'] );
		}else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, 'ah_starting_price', $_POST['ah_starting_price']);
		}
		
		if ( get_post_meta( $post_id, 'ah_closing_price', false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, 'ah_closing_price', $_POST['ah_closing_price'] );
		}else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, 'ah_closing_price', $_POST['ah_closing_price']);
		}
		
		if ( get_post_meta( $post_id, 'ah_property_short_desc', false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, 'ah_property_short_desc', $_POST['ah_property_short_desc'] );
		}else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, 'ah_property_short_desc', $_POST['ah_property_short_desc']);
		}
		
	
	}
	add_action( 'save_post', 'property_save_meta', 1, 2 );
	
	
	add_action( 'init', 'create_taxonomies_property', 0 );
 
    //create a custom taxonomy name it subjects for your posts
     
    function create_taxonomies_property() {
     
    // Add new taxonomy, make it hierarchical like categories
    //first do the translations part for GUI
     
      $labels = array(
        'name' => _x( 'Locations', 'taxonomy general name' ),
        'singular_name' => _x( 'Location', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Location' ),
        'all_items' => __( 'All Locations' ),
        'parent_item' => __( 'Parent Location' ),
        'parent_item_colon' => __( 'Parent Location:' ),
        'edit_item' => __( 'Edit Location' ), 
        'update_item' => __( 'Update Location' ),
        'add_new_item' => __( 'Add New Location' ),
        'new_item_name' => __( 'New Location Name' ),
        'menu_name' => __( 'Locations' ),
      );    
      
      // Now register the taxonomy
      register_taxonomy('locations',array('property'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'location' ),
      ));
      
      $labels = array(
        'name' => _x( 'Types', 'taxonomy general name' ),
        'singular_name' => _x( 'Type', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Type' ),
        'all_items' => __( 'All Types' ),
        'parent_item' => __( 'Parent Type' ),
        'parent_item_colon' => __( 'Parent Type:' ),
        'edit_item' => __( 'Edit Type' ), 
        'update_item' => __( 'Update Type' ),
        'add_new_item' => __( 'Add New Type' ),
        'new_item_name' => __( 'New Type Name' ),
        'menu_name' => __( 'Types' ),
      );    
     
    // Now register the taxonomy
      register_taxonomy('types',array('property'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'types' ),
      ));
     
    }
    
    
    
    //Gallery Metabox
    add_action( 'add_meta_boxes', 'ah_property_multi_media_uploader_meta_box' );

    function ah_property_multi_media_uploader_meta_box() {
    	add_meta_box( 'my-post-box', 'Property Media Field', 'ah_property_multi_media_uploader_meta_box_func', 'property', 'normal', 'high' );
    }
    
    function ah_property_multi_media_uploader_meta_box_func($post) {
    	$banner_img = get_post_meta($post->ID,'post_banner_img',true);
    	?>
    	<style type="text/css">
    		.multi-upload-medias ul li .delete-img { position: absolute; right: 3px; top: 2px; background: aliceblue; border-radius: 50%; cursor: pointer; font-size: 14px; line-height: 20px; color: red; }
    		.multi-upload-medias ul li { width: 120px; display: inline-block; vertical-align: middle; margin: 5px; position: relative; }
    		.multi-upload-medias ul li img { width: 100%; }
    	</style>
    
    	<table cellspacing="10" cellpadding="10">
    		<tr>
    			<td>Banner Image</td>
    			<td>
    				<?php echo ah_property_multi_media_uploader_field( 'post_banner_img', $banner_img ); ?>
    			</td>
    		</tr>
    	</table>
    
    	<script type="text/javascript">
    		jQuery(function($) {
    
    			$('body').on('click', '.wc_multi_upload_image_button', function(e) {
    				e.preventDefault();
    
    				var button = $(this),
    				custom_uploader = wp.media({
    					title: 'Insert image',
    					button: { text: 'Use this image' },
    					multiple: true 
    				}).on('select', function() {
    					var attech_ids = '';
    					attachments
    					var attachments = custom_uploader.state().get('selection'),
    					attachment_ids = new Array(),
    					i = 0;
    					attachments.each(function(attachment) {
    						attachment_ids[i] = attachment['id'];
    						attech_ids += ',' + attachment['id'];
    						if (attachment.attributes.type == 'image') {
    							$(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.url + '" /></a><i class=" dashicons dashicons-no delete-img"></i></li>');
    						} else {
    							$(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.icon + '" /></a><i class=" dashicons dashicons-no delete-img"></i></li>');
    						}
    
    						i++;
    					});
    
    					var ids = $(button).siblings('.attechments-ids').attr('value');
    					if (ids) {
    						var ids = ids + attech_ids;
    						$(button).siblings('.attechments-ids').attr('value', ids);
    					} else {
    						$(button).siblings('.attechments-ids').attr('value', attachment_ids);
    					}
    					$(button).siblings('.wc_multi_remove_image_button').show();
    				})
    				.open();
    			});
    
    			$('body').on('click', '.wc_multi_remove_image_button', function() {
    				$(this).hide().prev().val('').prev().addClass('button').html('Add Media');
    				$(this).parent().find('ul').empty();
    				return false;
    			});
    
    		});
    
    		jQuery(document).ready(function() {
    			jQuery(document).on('click', '.multi-upload-medias ul li i.delete-img', function() {
    				var ids = [];
    				var this_c = jQuery(this);
    				jQuery(this).parent().remove();
    				jQuery('.multi-upload-medias ul li').each(function() {
    					ids.push(jQuery(this).attr('data-attechment-id'));
    				});
    				jQuery('.multi-upload-medias').find('input[type="hidden"]').attr('value', ids);
    			});
    		})
    	</script>
    
    	<?php
    }
    
    
    function ah_property_multi_media_uploader_field($name, $value = '') {
    	$image = '">Add Media';
    	$image_str = '';
    	$image_size = 'full';
    	$display = 'none';
    	$value = explode(',', $value);
    
    	if (!empty($value)) {
    		foreach ($value as $values) {
    			if ($image_attributes = wp_get_attachment_image_src($values, $image_size)) {
    				$image_str .= '<li data-attechment-id=' . $values . '><a href="' . $image_attributes[0] . '" target="_blank"><img src="' . $image_attributes[0] . '" /></a><i class="dashicons dashicons-no delete-img"></i></li>';
    			}
    		}
    
    	}
    
    	if($image_str){
    		$display = 'inline-block';
    	}
    
    	return '<div class="multi-upload-medias"><ul>' . $image_str . '</ul><a href="#" class="wc_multi_upload_image_button button' . $image . '</a><input type="hidden" class="attechments-ids ' . $name . '" name="' . $name . '" id="' . $name . '" value="' . esc_attr(implode(',', $value)) . '" /><a href="#" class="wc_multi_remove_image_button button" style="display:inline-block;display:' . $display . '">Remove media</a></div>';
    }
    
    // Save Meta Box values.
    add_action( 'save_post', 'wc_meta_box_save' );
    
    function wc_meta_box_save( $post_id ) {
    	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    		return;	
    	}
    
    	if( !current_user_can( 'edit_post' ) ){
    		return;	
    	}
    	
    	if( isset( $_POST['post_banner_img'] ) ){
    		update_post_meta( $post_id, 'post_banner_img', $_POST['post_banner_img'] );
    	}
    }
