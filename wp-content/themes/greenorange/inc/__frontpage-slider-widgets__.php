<?php
/* other widgets */
class Frontpage_Slider_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Frontpage_Slider_Widget() {
 
		/* additional widgets */
		$widget_ops = array( 'classname' => 'widget_frontpage_slider', 'description' => __( 'Use this widget to provide html for frontpage slider on homepage', 'twentyeleven' ) );
		$this->WP_Widget( 'widget_frontpage_slider', __( 'Frontpage Slider', 'twentyeleven' ), $widget_ops );
		$this->alt_option_name = 'widget_frontpage_slider';		
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
		$cache = wp_cache_get( 'widget_frontpage_slider', 'widget' );

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

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Custom Content Widget', 'twentyeleven' ) : $instance['title'], $instance, $this->id_base);

 
		if ( 1 ) :
			 echo $instance['content'];
			?>
			
			<?php

			echo $after_widget;

			 
		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_custom_content', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;		 
		$instance['content'] =   $new_instance['content'] ;
		
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_custom_content'] ) )
			delete_option( 'widget_custom_content' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_frontpage_slider', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		 
		$content = isset( $instance['content']) ? esc_attr( $instance['content'] ) : '';
		 
?>
			


			<p><label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php _e( 'Content:', 'twentyeleven' ); ?></label>
			<textarea class="widefat" cols="20" rows="16"   id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>" type="text"><?php echo esc_attr( $content ); ?></textarea></p>
			
		<?php
	}
}