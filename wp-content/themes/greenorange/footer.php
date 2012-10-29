<?php
/**
 * The Header for our theme.
 * 
 */
extract($GLOBALS['def_path']);
 $options = startup_get_theme_options();
?>
<div style="clear: both;">&nbsp;</div>
                    </div>
                </div>
            </div>
            <!-- end #page -->
        </div>
        <div id="footer">
			 <?php if($options['footer_areas'] >= 1) : ?>
				<div id="footer-areas">
						<?php 
								    if(!dynamic_sidebar('sidebar-footer-area-1')) :			 
						   ?>
										<div class="sidebar-footer-areas">
										   <div id="meta-2" class="widget widget_meta">
												   <h3 class="widget-title">Meta</h3>			 
												   <ul>
														   <?php wp_register(); ?>
														   <li><?php wp_loginout(); ?></li>
														   <li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php echo esc_attr(__('Syndicate this site using RSS 2.0')); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
														   <li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php echo esc_attr(__('The latest comments to all posts in RSS')); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
														   <li><a href="<?php esc_attr_e( 'http://wordpress.org/' ); ?>" title="<?php echo esc_attr(__('Powered by WordPress, state-of-the-art semantic personal publishing platform.')); ?>"><?php
														   /* translators: meta widget link text */
														   _e( 'WordPress.org' );
														   ?></a></li>
														   <?php wp_meta(); ?>
												   </ul>						
										   </div>			 
										</div>
						
						<?php      endif;
							    ?>
						<?php 
								   if(!dynamic_sidebar('sidebar-footer-area-2')) :			 
						   ?>
										<div class="sidebar-footer-areas">
										   <div id="recent-posts" class="widget widget_recent_entries">
												<h3 class="widget-title">Recent Posts</h3>
												<?php 
												
														$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => 10, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
														if ($r->have_posts()) :
												?>
														<?php echo $before_widget; ?>
														<?php if ( $title ) echo $before_title . $title . $after_title; ?>
														<ul>
																<?php  while ($r->have_posts()) : $r->the_post(); ?>
																		<li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></li>
																<?php endwhile; ?>
														</ul>
														<?php endif;  ?>
										   </div>			 
										</div>
						
						<?php       endif;
							    ?>
								
						  <?php 
								    if(!dynamic_sidebar('sidebar-footer-area-3')) :			 
						   ?>
										<div class="sidebar-footer-areas">
										   <div id="calendar" class="widget widget_calendar">
												<h3 class="widget-title">Calendar</h3>			    
												<div id="calendar_wrap"> 
													   <?php get_calendar(); ?>
												</div> 												   
										   </div>			 
										</div>
						
						<?php      endif;
							    ?>
						<div class="clear"></div>		
				</div>		   
				
			<?php endif; ?>
			<div class="clear"></div>
			<div id="footer-menu">
				<?php wp_nav_menu( array( 'theme_location' => 'footer_menu', 'link_after' => '<span>&nbsp;|&nbsp;</span>' ) ); ?>
				
			</div>
			<div class="clear"></div>
			<?php if(!dynamic_sidebar('sidebar-footer')) :?>	
				<p>Copyright (c) 2011 Sitename.com. All rights reserved. Design by <a href="http://www.freecsstemplates.org">FCT</a>.</p>
		    <?php endif; ?>
        </div>
        <!-- end #footer -->
        <?php wp_footer();?>
    </body>
</html>


	 