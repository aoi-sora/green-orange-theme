<?php
/*
Template Name: Raw Content
*/
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<!-- move this code to add_action('wp_head'') for raw template-->	
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?> </title>
	<link media="all" href="<?php print get_template_directory_uri();?>/style.css" type="text/css" rel="stylesheet" >
	<?php 
	wp_head(); 
	
	?>
	<script>
	jQuery(document).ready(function($){
		$('.wpcf7-response-output').mouseover(function(){
			$('.wpcf7-response-output').fadeOut();
		});
		$('.wpcf7-display-none').mouseover(function(){
			$('.wpcf7-display-none').fadeOut();
		});
		$('.wpcf7-validation-errors').mouseover(function(){
			$('.wpcf7-validation-errors').fadeOut();
		});
		$('.wpcf7-mail-sent-ng').mouseover(function(){
			$('.wpcf7-mail-sent-ng').fadeOut();
		});
	});
	</script>
	
	<style>
		html { margin:0 !important;}
		body { background:none;}
		#wpadminbar {display:none;}
	</style>
	<?php wp_head();?>
</head>
<body>
	<?php if(!$_GET['video']) : ?>
	
		<div id="content" class="raw-content">
		
			<?php 
			the_post();
			the_content(); 
			?>
		</div>

	<?php else : ?>
			<?php
				$option = get_option('jwplayer_video_options');
				$v_height = $option['jwplayer_video_height']  ;
				$v_width = $option['jwplayer_video_width'] ;
				
				if(empty($_GET['height'])) {
					$v_height = empty($v_height) ? 270 : $v_height;
					
				} else {
					$v_height = $_GET['height'];
				}
				if(empty($_GET['width'])) {
					$v_width = empty($v_width) ? 480 : $v_width;
					
				} else {
					$v_width = $_GET['width'];
				}				
 
			?>	
		<div id="v-1_wrapper" style="position: relative; width: <?php echo $v_width; ?>px; height: <?php echo $v_height; ?>px;">
			<object 
				width="100%" 
				height="100%" 
				type="application/x-shockwave-flash" 
				data="<?php bloginfo('url');?>/wp-content/plugins/jwplayer-video/core/player.swf" 
				bgcolor="#000000" 
				id="v-1" 
				name="v-1" 
				tabindex="0">
					<param name="allowfullscreen" value="true">
					<param name="allowscriptaccess" value="always">
					<param name="seamlesstabbing" value="true">
					<param name="wmode" value="opaque">
					<param name="flashvars"   
					value="netstreambasepath=<?php echo urlencode(get_bloginfo('url'));?>&amp;id=v-1&amp;className=jwplayer-videos&amp;file=<?php echo urlencode($_GET['video']);?>&amp;image=<?php echo urlencode($_GET['image']);?>&amp;skin=http%3A%2F%2Fdev%2Fdemos.greenorange%2Fwp-content%2Fplugins%2Fjwplayer-video%2Fcore%2Fsnel.zip&amp;controlbar.position=bottom">
			</object>
		
		</div>	
	<?php endif; ?>
<?php wp_footer(); ?>
	</body>
</html>