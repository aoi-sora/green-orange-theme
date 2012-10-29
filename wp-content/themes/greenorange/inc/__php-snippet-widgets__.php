<?php
/* other widgets */
class PHP_Snippet_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function PHP_Snippet_Widget() {
 
		/* additional widgets */
		$widget_ops = array( 'classname' => 'widget_php_snippet', 'description' => __( 'Use this widget to create executable php code', 'twentyeleven' ) );
		$this->WP_Widget( 'widget_php_snippet', __( 'PHP Snippet', 'twentyeleven' ), $widget_ops );
		$this->alt_option_name = 'widget_php_snippet';		
		/* end */
		
		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_php_snippet', 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( '', 'twentyeleven' ) : $instance['title'], $instance, $this->id_base);

		 

		if ( 1 ) :
			 
			echo $before_widget;
			echo $before_title;
			echo $title; // Can set this with a widget option, or omit altogether
			echo $after_title;
			?>
			 
			<?php
			  eval($instance['php_snippet']);
			 
			echo $after_widget;

			 
		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_php_snippet', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['php_snippet'] =   $new_instance['php_snippet'] ;
		
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_php_snippet'] ) )
			delete_option( 'widget_php_snippet' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_php_snippet', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
		$content = isset( $instance['php_snippet']) ? esc_attr( $instance['php_snippet'] ) : '';
		 
?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'twentyeleven' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>


			<p><label for="<?php echo esc_attr( $this->get_field_id( 'php_snippet' ) ); ?>"><?php _e( 'Content:', 'twentyeleven' ); ?></label>
			<textarea class="widefat" cols="20" rows="16"   id="<?php echo esc_attr( $this->get_field_id( 'php_snippet' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'php_snippet' ) ); ?>" type="text"><?php echo esc_attr( $content ); ?></textarea></p>
			
		<?php
	}
}