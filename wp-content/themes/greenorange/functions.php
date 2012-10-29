<?php

$GLOBALS['def_path']['site_uri'] = trailingslashit(site_url());
$GLOBALS['def_path']['ss_uri'] = trailingslashit(get_stylesheet_directory_uri());
$GLOBALS['def_path']['ss_dir'] = trailingslashit(get_stylesheet_directory());

extract($GLOBALS['def_path']);

 

/**
 * Tell WordPress to run startup_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'startup_setup' );

if ( ! function_exists( 'startup_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 * 
 */
function startup_setup() {
 
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Load up our theme options page and related code.
	require( get_template_directory() . '/inc/__theme-bootstrap__.php' );	
	require( get_template_directory() . '/inc/__theme-options__.php' );	
	require( get_template_directory() . '/inc/__theme-post-meta__.php' );
	require( get_template_directory() . '/inc/__common__.php' );
	

	// Grab  Ephemera widget.
	require( get_template_directory() . '/inc/__widgets__.php' );
	require( get_template_directory() . '/inc/__frontpage-slider-widgets__.php' );	
	require( get_template_directory() . '/inc/__php-snippet-widgets__.php' );	

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'navigation_menu', __( 'Navigation Menu'  ) );
        
    register_nav_menu( 'footer_menu', __( 'Footer Menu'  ) );
        
    register_nav_menu( 'sidebar_menu', __( 'Sidebar Menu'   ) );

	// Add support for a variety of post formats, disable this for a while
	/* add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ), ); */

 
	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support('post-thumbnails', array('post','page','top-sliding-image'));
	add_post_type_support('top-sliding-image','thumbnail');
	

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be the size of the header image that we just defined
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Add  custom image sizes
	add_image_size( 'large-feature', HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true ); // Used for large feature (header) images
	add_image_size( 'small-feature', 500, 300 ); // Used for featured posts if a large-feature doesn't exist

}
endif; // startup_setup

 

/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function startup_excerpt_length( $length ) {
	return 50;
}
add_filter( 'excerpt_length', 'startup_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function startup_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'startup' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and startup_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function startup_auto_excerpt_more( $more ) {
	return ' &hellip;' . startup_continue_reading_link();
}
add_filter( 'excerpt_more', 'startup_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function startup_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= startup_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'startup_custom_excerpt_more' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function startup_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'startup_page_menu_args' );

/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since   1.0
 */
function startup_widgets_init() {

	$options = startup_get_theme_options();
	
	register_widget( 'Custom_Content_Widget' );	 
	register_widget( 'JS_Snippet_Widget' );
	register_widget( 'PHP_Snippet_Widget' );
	
	register_sidebar( array(
		'name' => __( 'Top Page Widgets' ),
		'id' => 'sidebar-top',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'description' => __( 'Widgets in this area will be shown on the top part of the content.' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	
	register_sidebar( array(
		'name' => __( 'Middle Page Widgets' ),
		'id' => 'sidebar-middle',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'description' => __( 'Widgets in this area will be shown on the middle part of the content.' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Sidebar-Left Widgets' ),
		'id' => 'sidebar-left',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => "</li>",
		'description' => __( 'Widgets in this area will be shown on the sidebar at the left side of the content.' ),
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );	

	register_sidebar( array(
		'name' => __( 'Sidebar-Right Widgets' ),
		'id' => 'sidebar-right',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'description' => __( 'Widgets in this area will be shown on the sidebar at the right side of the content.' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Sidebar#1 Left Side Widgets' ),
		'id' => 'sidebar-1-left',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'description' => __( 'Widgets in this area will be shown on the first sidebar on the left side of the content.' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );		
		
	register_sidebar( array(
		'name' => __( 'Sidebar#2 Left Side Widgets' ),
		'id' => 'sidebar-2-left',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'description' => __( 'Widgets in this area will be shown on the second sidebar on the left side of the content.' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );			

	
	register_sidebar( array(
		'name' => __( 'Sidebar#1 Right Side Widgets' ),
		'id' => 'sidebar-1-right',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'description' => __( 'Widgets in this area will be shown on the first sidebar on the right side of the content.' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );		
		
	register_sidebar( array(
		'name' => __( 'Sidebar#2 Right Side Widgets' ),
		'id' => 'sidebar-2-right',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'description' => __( 'Widgets in this area will be shown on the second sidebar on the right side of the content.' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	

	register_sidebar( array(
		'name' => __( 'Footer Widgets' ),
		'id' => 'sidebar-footer',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'description' => __( 'Widgets in this area will be shown on the footer of the page.' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	for($i=1;$i<=$options['footer_areas'];++$i) {
		register_sidebar( array(
			'name' => __( 'Footer Area #'.$i.' Widgets' ),
			'id' => 'sidebar-footer-area-'.$i,
			'before_widget' => '<div class="sidebar-footer-areas"><div id="%1$s" class="widget %2$s">',
			'after_widget' => "</div></div>",
			'description' => __( 'Widgets in this area will be shown on the footer area #'.$i .' of the page.' ),
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}

	register_sidebar( array(
		'name' => __( 'Head Widgets' ),
		'id' => 'sidebar-head',
		'before_widget' => '',
		'after_widget' => "",
		'description' => __( 'Widgets in this area will be included in the <head> of the page.' ),
		'before_title' => '<span class="widget-title">',
		'after_title' => '</span>',
	) );
		
	 
	 
	
	
	
}
add_action( 'widgets_init', 'startup_widgets_init' );

/*
 * menu arguments settings
 */

if( ! function_exists('my_wp_nav_menu_args')) {
	function my_wp_nav_menu_args( $args = '' )
	{
		//$args['container'] = false;
		return $args;
	}  

}
add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' ); 
 

if ( ! function_exists( 'startup_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function startup_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'startup' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'startup' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'startup' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}
endif; // startup_content_nav

/**
 * Return the URL for the first link found in the post content.
 *
 * 
 * @return string|bool URL or false when no link is present.
 */
function startup_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function startup_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}

if ( ! function_exists( 'startup_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own startup_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since   1.0
 */
function startup_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'startup' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'startup' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'startup' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'startup' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'startup' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'startup' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'startup' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for startup_comment()

if ( ! function_exists( 'startup_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own startup_posted_on to override in a child theme
 *
 * @since   1.0
 */
function startup_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'startup' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'startup' ), get_the_author() ) ),
		get_the_author()
	);
}
endif;



    





