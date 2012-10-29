<?php
/**
 * @package 
 * @version  
 */
/*
Plugin Name: JWPlayer for WordPress
Plugin URI: 
Description: A plugin using JWPlayer to play videos for Wordpress. JWPlayer is Crossbrowser compatible and Mobile ready. Supports multiple video player within a post.
Author: Jenneth Dela Fuente
Version: 1.0
TO DO : a JWPLayer wordpress plugin for mp3s/audio
Sample usage : <div class="jwplayer-videos" movie="videos/riproaring.mp4" image="videos/riproaring-thumbnail.png"></div>
or 
use shortcode : [jwp-video movie="videos/riproaring.mp4" image="videos/riproaring-thumbnail.png"]
ID is required and MUST BE UNIQUE
*/

$plugin_dir = plugin_dir_path( __FILE__ );

/* The options page */
include_once($plugin_dir . 'admin.php');

/* Include the script and css file in the page <head> */
function add_jwplayer_video_header(){
	$options = get_option('jwplayer_video_options');
	echo '
	<script type="text/javascript" src="'.plugins_url('core/jwplayer.js',  __FILE__) . '"></script>
	
	
	
	
	';
	
	$option = get_option('jwplayer_video_options');
	
	$swf_path = plugins_url('core/player.swf',  __FILE__); 
	$skin_path  = plugins_url('core/snel.zip',  __FILE__);
	$def_width = $option['jwplayer_video_width'];
	$def_height = $option['jwplayer_video_height'];
	
	
	
?>	
<script type="text/javascript">
	jQuery(document).ready(function($) {
	
		$('.jwplayer-videos').each(function(index,dom_object) {
			   
			   if( !$(dom_object).attr('id')) {
					$(dom_object).html("<div style='padding:10px 20px;background:#AEAEAE;'><b>movie must have unique id : " +  $(dom_object).attr('movie') + "</b></div>")
			   }
			   
			  jwplayer(  $(dom_object).attr('id')).setup({
				'flashplayer': '<?php echo $swf_path;?>',
				'id': 'playerID',
				'width':   '<?php echo $def_width; ?>',
				'height':   '<?php echo $def_height; ?>',
				'file':   $(dom_object).attr('movie'),  
				'image':   $(dom_object).attr('image'),  
				'skin': '<?php echo $skin_path;?>',
				'controlbar': 'bottom',
				'plugins':'viral',
				'viral.onpause':'false'
			  });
 			  
  
		});
  });
</script>	

<?php 	 
}
add_action('wp_head','add_jwplayer_video_header');



/* The [jwp-video] shortcode */
function jwplayer_video_shortcode($atts){
	
	$options = get_option('jwplayer_video_options'); //load the defaults
	
	extract(shortcode_atts(array(
		'movie' => '',
		'image' => '',
		'width' => $options['jwplayer_video_width'],
		'height' => $options['jwplayer_video_height'],
		'id' => '',
		'class' => 'jwplayer-videos'
	), $atts));
	
	$video_container = "<div class=\"{$class}\" id=\"{$id}\" movie=\"{$movie}\" height=\"{$height}\" width=\"{$width}\"  image=\"{$image}\"></div>";
	return $video_container;
}	
add_shortcode('jwp-video', 'jwplayer_video_shortcode');
?>