<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 */

get_header(); ?>
<div id="content">
		 
		<div class="post">
			<h2 class="title">
				<?php if ( is_day() ) : ?>
					<?php printf( __( 'Daily Archives: %s', 'twentyeleven' ), '<span>' . get_the_date() . '</span>' ); ?>
				<?php elseif ( is_month() ) : ?>
					<?php printf( __( 'Monthly Archives: %s', 'twentyeleven' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'twentyeleven' ) ) . '</span>' ); ?>
				<?php elseif ( is_year() ) : ?>
					<?php printf( __( 'Yearly Archives: %s', 'twentyeleven' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'twentyeleven' ) ) . '</span>' ); ?>
				<?php else : ?>
					<?php _e( 'Blog Archives', 'twentyeleven' ); ?>
				<?php endif; ?>
			</h2>                            
			<div class="clear">&nbsp;</div>
			<div class="entry">
				<?php the_content();?>                                    
			</div>
		</div>
		<div class="clear"></div>
		<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>
			<div class="post">
				<h2 class="title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
				<p class="meta"><span class="date"><?php echo get_the_date();?></span><span class="posted">Posted by <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author();?></a></?php> </span></p>
				<div class="clear">&nbsp;</div>
				<div class="entry">
					<?php if(has_post_thumbnail()) : ?>
						<div class="post-thumbnail">
							<?php show_post_thumbnail(); ?>
						</div>
					<?php endif; ?>
					<div class="<?php echo (has_post_thumbnail() ? 'excerpt' : '');?>" ><?php the_excerpt();?>
					<p class="links blog-readmore"><a href="<?php the_permalink();?>">Read More</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">Comments</a></p>
					</div>
					
				</div>
			</div>
			<div class="clear"></div>
		<?php endwhile; ?>
		<?php else : ?>
			<div class="post">
				<h2 class="title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
				<div class="clear">&nbsp;</div>
				<div class="entry">
					<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
					<div id="search-inner"><?php get_search_form(); ?></div>				
				</div>
			</div>
		<?php endif;?>
		<div class="clear"></div>                            
		
		<div id="pagination"><?php pagination();?></div>
	</div>
	<!-- end #content -->
	
	<?php get_sidebar(); ?>
<?php get_footer();?>

		 