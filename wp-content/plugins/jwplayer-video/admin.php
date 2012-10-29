<?php

if( is_admin() ) {
	add_action('admin_menu', 'jwplayer_video_menu');
	add_action('admin_init', 'register_jwplayer_video_settings');
}

function jwplayer_video_menu() {
	add_options_page('JWPlayer Video Settings', '<img src="' . plugins_url('core/jwplayer-video-icon.png',__FILE__) . '" />&nbsp; JWPlayer Video', 'manage_options', 'jwplayer_video-settings', 'jwplayer_video_settings');
}

function jwplayer_video_settings() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	?>
	<div class="wrap">
	<h2>Video.js Settings</h2>
	
	<form method="post" action="options.php">
	<?php
	settings_fields( 'jwplayer_video_options' );
	do_settings_sections( 'jwplayer_video-settings' );
	?>
	<p class="submit">
	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
	</form>
	</div>
	<?php
	
}

function register_jwplayer_video_settings() {
	register_setting('jwplayer_video_options', 'jwplayer_video_options', 'jwplayer_video_options_validate');
	add_settings_section('jwplayer_video_defaults', 'Default Settings', 'defaults_output_jwplayer_video', 'jwplayer_video-settings');
	
	add_settings_field('jwplayer_video_width', 'Width', 'jwplayer_video_width_output', 'jwplayer_video-settings', 'jwplayer_video_defaults');
	add_settings_field('jwplayer_video_height', 'Height', 'jwplayer_video_height_output', 'jwplayer_video-settings', 'jwplayer_video_defaults');
	
	 
}

/* Validate our inputs */

function jwplayer_video_options_validate($input) {
	$newinput['jwplayer_video_height'] = $input['jwplayer_video_height'];
	$newinput['jwplayer_video_width'] = $input['jwplayer_video_width'];
	$newinput['jwplayer_video_preload'] = $input['jwplayer_video_preload'];
	$newinput['jwplayer_video_autoplay'] = $input['jwplayer_video_autoplay'];
	$newinput['jwplayer_video_cdn'] = $input['jwplayer_video_cdn'];
	$newinput['jwplayer_video_reset'] = $input['jwplayer_video_reset'];
	
	if(!preg_match("/^\d+$/", trim($newinput['jwplayer_video_width']))) {
		 $newinput['jwplayer_video_width'] = '';
	 }
	 
	 if(!preg_match("/^\d+$/", trim($newinput['jwplayer_video_height']))) {
		 $newinput['jwplayer_video_height'] = '';
	 }
	
	return $newinput;
}

/* Display the input fields */

function defaults_output_jwplayer_video() {
	//echo '';
}

function jwplayer_video_height_output() {
	$options = get_option('jwplayer_video_options');
	echo "<input id='jwplayer_video_height' name='jwplayer_video_options[jwplayer_video_height]' size='40' type='text' value='{$options['jwplayer_video_height']}' />";
}

function jwplayer_video_width_output() {
	$options = get_option('jwplayer_video_options');
	echo "<input id='jwplayer_video_width' name='jwplayer_video_options[jwplayer_video_width]' size='40' type='text' value='{$options['jwplayer_video_width']}' />";
}

 


/* Set Defaults */
register_activation_hook(plugin_dir_path( __FILE__ ) . 'jwplayer-video.php', 'add_defaults_jwplayer_video');

function add_defaults_jwplayer_video() {
	$tmp = get_option('jwplayer_video_options');
    if(($tmp['jwplayer_video_reset']=='on')||(!is_array($tmp))) {
		$arr = array("jwplayer_video_height"=>"270","jwplayer_video_width"=>"480");
		update_option('jwplayer_video_options', $arr);
	}
	
}

?>
