<?php
/*
  Template Name: Portfolios
*/
extract($GLOBALS['def_path']);
get_header();
$options = startup_get_theme_options();
// debug($options);
the_post();
?>

	<div id="content-full">
		<h2 class="title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
        <div id="slider">
             <div class="scroll">
                <div class="scrollContainer">
					<?php query_posts(array('post_type'=>'portfolio'));
						while(have_posts()) :
					?>
							<div class="panel">
								<?php the_post();?>
								<h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
								<?php the_content();?>
								
								<div>
									<?php
										$meta = get_post_meta(get_the_ID(),'su_thumbnail',true);
										$post_image_id = get_post_meta(get_the_ID(), 'su_thumbnail_id', true);
										
										$post_image_alt 	= strip_tags(get_post_meta($post_image_id,  '_wp_attachment_image_alt', true));
										$post_image_title 	= strip_tags(get_the_title($post_image_id));
                                                                               
									?>
									<img src="<?php echo $meta;?>" title="<?php echo $post_image_title;?>" alt="<?php echo $post_image_alt; ?>"/>
								</div>
							</div>
					<?php endwhile; ?>
					<!--/panel -->
                     

                </div>
            </div> 
        </div>		
		<div class="clear"></div>
	</div>
	<!-- end #content -->
                        
<?php get_footer();?> 