<?php
/*
* The customizable settings for each post provided by the Startup Themes
*/

/* for post custom fields - post specific theme settings */

/* Define the custom box */
add_action('add_meta_boxes', 'startup_add_custom_box');

/* Do something with the data entered */
add_action('save_post', 'startup_save_postdata');

/* Adds a box to the main column on the Post and Page edit screens */

/**
 * startup_add_custom_box
 **/ 
function startup_add_custom_box() {
	// load other scripts provided by the theme
	startup_admin_enqueue_scripts('');
	
    add_meta_box(
            'startup-page-options',  get_current_theme(). '  Theme Options'  , 'startup_inner_custom_box', 'page'
    );
	
    add_meta_box(
            'startup-page-options',  get_current_theme(). '  Theme Options'  , 'startup_inner_custom_box', 'post'
    );
	
    add_meta_box(
            'startup-page-options',  get_current_theme(). '  Theme Options'  , 'startup_inner_custom_box', 'portfolio'
    );
	
    add_meta_box(
            'startup-page-options',  get_current_theme(). '  Theme Options'  , 'startup_inner_custom_box', 'top-sliding-image'
    );	

}

/**
 * startup_inner_custom_box
 **/
function startup_inner_custom_box($post) {
    $custom_fields = get_post_custom($post->ID);
 
    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');
	
?>
	<style>
		#postimagediv img {width:100%;}
		#post-meta-set .clear {clear:both;}
		#meta-su-thumbnail img {width : 100%;}
		#post-meta-set #page-list table {
			width:100%;			
			border-collapse:collapse;
			border:solid 1px #f4f4f4;
		}
		#post-meta-set #page-list td  { height:25px;border:solid 1px #f4f4f4;}
		#post-meta-set #page-list tr.odd { background:#fff;}
		#post-meta-set #page-list tr.even { background:#f4f4f4;}
		#post-meta-set #page-list {
			width:550px;
			height:225px;
			overflow-y:scroll;
			overflow-x: hidden;
			background:#fff;
		}	
	</style>
 
	<div id="post-meta-set">
	
		<?php /*  post-thumbnail for portfolio  */
		if(in_array( get_post_type(), array('portfolio' )) ) :?>
		<h4>Post Thumbnail Options</h4>
 
			 <div id="meta-su-thumbnail" class="meta-row">
				<h4>Thumbnail Image</h4>
				<input type="text" name="startup_page_options[su_thumbnail]" id="startup_page_options_thumbnail" size="76" value="<?php echo esc_attr( $custom_fields['su_thumbnail'][0]); ?>"/> <input id="thumbnail-upload-button" class="button" type="button" value="Upload" /> 
				<?php _e( '', 'startup' ); ?>
				<br/>
				<?php
					if ( $custom_fields['su_thumbnail'][0] ) :
						$size = getimagesize($custom_fields['su_thumbnail'][0]);
				?>		<p><img src="<?php echo $custom_fields['su_thumbnail'][0]; ?>" <?php echo $size[3]; ?> alt=""/></p>
				<?php	   endif;	?>
			</div>
			 
			<div class="meta-row">
				<h4>Alternate Text</h4>
				<input type="text" name="startup_page_options[su_thumbnail_alt]" id="thumbnail_alt" size="100" value="<?php echo esc_attr( $custom_fields['su_thumbnail_alt'][0]); ?>"/>
				<input type="hidden" name="startup_page_options[su_thumbnail_id]" id="thumbnail-class" value="<?php echo $custom_fields['su_thumbnail_id'][0];?>"/> 
			</div>
			 
		<?php endif; ?>
		<?php /*  post-thumbnail for top-sliding-image  */
		$slide_to_page =   unserialize($custom_fields['su_slide_to_page'][0]) ;
		$slide_to_page = empty($slide_to_page) ? array() : $slide_to_page;
		if(in_array( get_post_type(), array('top-sliding-image' )) ) :?>
			 <div  class="meta-row">
				<h4>Select which page you want this sliding image to show</h4>
				 
				<div id="page-list">
					<table cellpadding="0" cellspacing="0" >
						<tbody>
						<?php foreach(get_pages(array('orderby' => 'title')) as $k=>$v) : ?>
							<tr class="<?php echo (($k+1 ) %2 == 0 ? 'even' : 'odd' );?>">
								<td width="30" align="center"><input type="checkbox" name="startup_slider_options[]" id="page-<?php echo $v->ID;?>" value="<?php echo $v->ID;?>" <?php echo (in_array($v->ID, $slide_to_page) ? ' checked' : '');?> /></td>
								<td><label for="page-<?php echo $v->ID;?>"><?php echo $v->post_title;?></label></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>	
				</div>
			</div>
			 
		<?php endif; ?>		
		<div class="clear"></div>
	</div>

<?php
}	



/* When the post is saved, saves our custom data */
/**
 * startup_save_postdata
 **/ 
function startup_save_postdata($post_id) {
  // verify if this is an auto save routine.
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
      return;

 
  // Check permissions
  if ( 'page' == $_POST['post_type'] )
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }

  // OK, we're authenticated: we need to find and save the data

  
  // Do something with $mydata
  // probably using add_post_meta(), update_post_meta(), or
  // a custom table (see Further Reading section below)

  foreach($_POST['startup_page_options'] as $option_name=> $option_value) {
 
		if(is_array($option_value) || is_object($option_value)) {
			$option_value = serialize($option_value);
			
		}
		update_post_meta($post_id, $option_name,  $option_value);
  }
  
  /* top slider option - save the page id */
  update_post_meta($post_id,'su_slide_to_page',  $_POST['startup_slider_options'] );
   
  
  
 
}

 

?>