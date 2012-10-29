<?php
/**
 *   Theme Options
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since   1.0
 */

/**
 * Properly enqueue styles and scripts for our theme options page.
 *
 * This function is attached to the admin_enqueue_scripts action hook.
 *
 * @since   1.0
 *
 */
function startup_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style( 'startup-theme-options', get_template_directory_uri() . '/inc/theme-options.css', false, '2011-04-28' );
	wp_enqueue_script( 'startup-theme-options', get_template_directory_uri() . '/inc/theme-options.js', array( 'farbtastic' ), '2011-06-10' );
	
	// disable this until color scheme field color picker is added to this theme option
	//wp_enqueue_style( 'farbtastic' );
	// additional css and js from wp admin core
	wp_enqueue_style('postbox');
    wp_enqueue_style('media-upload');
    wp_enqueue_style('thickbox');	
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');	
}
add_action( 'admin_print_styles-appearance_page_theme_options', 'startup_admin_enqueue_scripts' );

/**
 * Register the form setting for our startup_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, startup_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are complete, properly
 * formatted, and safe.
 *
 * We also use this function to add our theme option if it doesn't already exist.
 *
 * @since   1.0
 */
function startup_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === startup_get_theme_options() )
		add_option( 'startup_theme_options', startup_get_default_theme_options() );

	register_setting(
		'startup_options',       // Options group, see settings_fields() call in startup_theme_options_render_page()
		'startup_theme_options', // Database option, see startup_get_theme_options()
		'startup_theme_options_validate' // The sanitization callback, see startup_theme_options_validate()
	);

	// Register our settings field group
	add_settings_section(
		'general', // Unique identifier for the settings section
		'', // Section title (we don't want one)
		'__return_false', // Section callback (we don't want anything)
		'theme_options' // Menu slug, used to uniquely identify the page; see startup_theme_options_add_page()
	);

	// favorite icon
	add_settings_field(		'favico',
							__( 'Favorite Icon', 'startup' ),
							'startup_settings_field_favico',
							'theme_options',
							'general'
					  );
	
	// footer areas 
	add_settings_field(		'footer_areas',
							__( 'Footer Areas', 'startup' ),
							'startup_settings_field_footer_area',
							'theme_options',
							'general'
					  );	
	 
	
}
add_action( 'admin_init', 'startup_theme_options_init' );

/**
 * Change the capability required to save the 'startup_options' options group.
 *
 * @see startup_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see startup_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * By default, the options groups for all registered settings require the manage_options capability.
 * This filter is required to change our theme options page to edit_theme_options instead.
 * By default, only administrators have either of these capabilities, but the desire here is
 * to allow for finer-grained control for roles and users.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function startup_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_startup_options', 'startup_option_page_capability' );

/**
 * Add our theme options page to the admin menu, including some help documentation.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since   1.0
 */
function startup_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'startup' ),   // Name of page
		__( 'Startup Theme', 'startup' ),   // Label in menu
		'edit_theme_options',                    // Capability required
		'theme_options',                         // Menu slug, used to uniquely identify the page
		'startup_theme_options_render_page' // Function that renders the options page
	);
	

	if ( ! $theme_page )
		return;

	 //debug(get_option( 'startup_theme_options'));
}
add_action( 'admin_menu', 'startup_theme_options_add_page' );

 
/**
 * Returns the default options for  .
 *
 * @since   1.0
 */
function startup_get_default_theme_options() {
	$default_theme_options = array(		 		 
		'favico' 		=>  '',
		'footer_areas'	=>   3
	);

 

	return apply_filters( 'startup_default_theme_options', $default_theme_options );
}
 
/**
 * Returns the options array for  .
 *
 * @since   1.0
 */
function startup_get_theme_options() {
	return get_option( 'startup_theme_options', startup_get_default_theme_options() );
}
 
/** favorite icons field
*
*/
function startup_settings_field_favico() {
	
	$options = startup_get_theme_options();?>
    <input type="text" name="startup_theme_options[favico]" id="favicon_url" size="76" value="<?php echo esc_attr( $options['favico'] ); ?>"/> <input id="favico_url_button" class="button" type="button" value="Upload" /> 
		<?php _e( 'Max width 32 px', 'free01' ); ?>
		<br/>
		<?php
			if ( $options['favico'] ) :
				$size = getimagesize($options['favico']);
		?>		<p><img src="<?php echo $options['favico']; ?>" <?php echo $size[3]; ?> alt=""/></p>
<?php	   endif;				
	
}


function startup_settings_field_footer_area() {
	$options = startup_get_theme_options();
?>	
	<input type="text" name="startup_theme_options[footer_areas]" id="footer_areas" size="1" maxlength="1" value="<?php echo esc_attr( $options['footer_areas'] ); ?>"/> 
		 	
<?php }

/**
 * Returns the options array    .
 *
 * @since   1.2
 */
function startup_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'startup' ), get_current_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'startup_options' );
				do_settings_sections( 'theme_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see startup_theme_options_init()
 * @todo set up Resset Options action
 *
 * @since   1.0
 */
function startup_theme_options_validate( $input ) {
	$output = $defaults = startup_get_default_theme_options();
 		
	// favorite icon
	$output['favico'] = $input['favico'];
	
	// footer areas
	$output['footer_areas'] = $input['footer_areas'];
 
	return apply_filters( 'startup_theme_options_validate', $output, $input, $defaults );
}

 

