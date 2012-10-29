<?php
/**
 * The Header for our theme.
 * 
 */
extract($GLOBALS['def_path']);
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
        <meta charset="<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=device-width" />
        <title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;
		
		$seo_title = BP_seo_title();
		if (empty($seo_title)) {
			wp_title('|', true, 'right');
			// Add the blog name.
			bloginfo('name');
		
			// Add the blog description for the home/front page.
			$site_description = get_bloginfo('description', 'display');
			if ($site_description && ( is_home() || is_front_page() ))
				echo " | $site_description";
		} else {
			echo $seo_title;
		}
		?></title>

        <?php
        /* favorite icon */
        $options = get_option('startup_theme_options');
        if ($options['favico'])
            echo '<link rel="shortcut icon" href="' . $options['favico'] . '" type="image/x-icon" />';
        ?> 
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo $ss_uri; ?>reset.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo $ss_uri; ?>print.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo $ss_uri; ?>responsive.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo $ss_uri; ?>style.css" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <!-- remove skype toolbar effect on phone like text -->
        <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
        <?php
        if (is_singular() && get_option('thread_comments'))
            wp_enqueue_script('comment-reply');

        wp_head();
        ?>
	
		<meta name="theme_slider_dir" content="<?php echo get_stylesheet_directory_uri();  ?>/js/coda-slider">
		<script src="<?php echo get_stylesheet_directory_uri();?>/js/jquery/jquery-1.7.2.min.js"></script>
		<script type='text/javascript' src="<?php echo get_stylesheet_directory_uri();?>/js/general.js"></script>
		<!-- Add fancyBox main JS and CSS files -->
		<link href="<?php echo get_stylesheet_directory_uri(); ?>/js/fancybox2/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />  		
		<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/js/fancybox2/source/jquery.fancybox.pack.js'></script>	
		<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/js/fancybox2/lib/jquery.mousewheel-3.0.6.pack.js'></script>	
		<!-- JWPlayer Video -->
		<script>		
			<?php
			$option = get_option('jwplayer_video_options');
			$v_height = $option['jwplayer_video_height']  ;
			$v_width = $option['jwplayer_video_width'] ;
			?>
			(function($){
		
				$('.fancybox-video').fancybox({ 'type':'iframe','padding':10,'autoSize':false,'height':<?php echo $v_height; ?>, 'width':<?php echo $v_width; ?> })
		
			}(jQuery))
		</script>
		<script>
			(function($){
				$('.fancybox').fancybox();
			}(jQuery));	
		</script>
		<!-- top image slider -->
		<script type='text/javascript' src='<?php echo $ss_uri; ?>js/slides.min.jquery.js'></script>
		<script type='text/javascript' >
			jQuery(document).ready(function($){
				if($("#contents-slider").length > 0) {
					$("#contents-slider").slides({
						container: 'contents-slides',
						next: 'nxt', 
						prev: 'prev',
						pagination: true,
						generatePagination: false,		
						preload: true,		
						effect: 'fade',		
						slideSpeed: 1000,		
						play: 5000	    	
					});
				}
				
				/* inline gallery slide */
				if($("#gallery-slide").length > 0) {
					$("#gallery-slide").slides({
						container: 'gallery-slides',
						next: 'nxt', 
						prev: 'prev',
						pagination: true,
						generatePagination: false,		
						preload: true,		
						effect: 'fade',		
						slideSpeed: 1000,		
						play: 5000	    	
					});
				}
			});
		</script>

		<!-- coda slider -->
		<script type='text/javascript' src='<?php echo $ss_uri;?>js/coda-slider/jquery.scrollTo-1.3.3.js?ver=3.4.1'></script>
		<script type='text/javascript' src='<?php echo $ss_uri;?>js/coda-slider/jquery.localscroll-1.2.5.js?ver=3.4.1'></script>
		<script type='text/javascript' src='<?php echo $ss_uri;?>js/coda-slider/jquery.serialScroll-1.2.1.js?ver=3.4.1'></script>
		<script type='text/javascript' src='<?php echo $ss_uri;?>js/coda-slider/jquery.easing.1.3.js?ver=3.4.1'></script>
		<link href="<?php echo $ss_uri; ?>js/coda-slider/coda-slider.css" rel="stylesheet" type="text/css" />  		
		<script type='text/javascript' src='<?php echo $ss_uri; ?>js/coda-slider/coda-slider.js'></script>		
 
		<!-- jquery ui -->
		<link type="text/css" href="<?php echo $ss_uri; ?>js/jqueryui/css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo $ss_uri; ?>js/jqueryui/js/jquery-ui-1.8.21.custom.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
			$(function() {
				$( "#datepicker" ).datepicker({ minDate: 0 });
				$( ".datepicker_ui" ).datepicker({ minDate: 0 });
			});
		
				
		
			});                              
		</script>
    		

        <?php if (!dynamic_sidebar('sidebar-head')) : ?>

        <?php endif; ?>		
		

    </head>
    <body>
        <div id="<?php echo (is_home() || is_front_page() ? 'wrapper' : 'wrapper-inner');?>">
            <div id="menu">
                <!-- ul>
                    <li class="current_page_item"><a href="#">Homepage</a></li>
                    <li><a href="#">Portfolio</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Contact</a></li>
                </ul -->
				<?php wp_nav_menu( array( 'theme_location' => 'navigation_menu' ) ); ?>
            </div>
            <!-- end #menu -->
            <div id="<?php  echo (is_home() || is_front_page() ? 'header' : 'header-inner'); ?>">
                <div id="<?php  echo (is_home() || is_front_page() ? 'logo' : 'logo-inner'); ?>">
                    <h1><a href="<?php echo site_url();?>">Green<span>Orange</span></a></h1>
                    <p> design by <a href="http://www.freecsstemplates.org">FCT</a></p>
                </div>
            </div>
            <!-- end #header -->
			<!-- top page slider -->
			<?php if((!is_home()) && (!is_front_page()) && get_sliding_images()) : ?>
				  <?php show_top_slider();?>
			<?php endif; ?>
            <div id="page">
                <div id="page-bgtop">
                    <div id="page-bgbtm">
