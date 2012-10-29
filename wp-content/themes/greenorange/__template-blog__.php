<?php
/*
  Template Name: Blog
*/
get_header();
$options = startup_get_theme_options();
// debug($options);
?>

                        <div id="content">
                            <?php the_post(); ?>
                            <div class="post">
                                <h2 class="title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>                            
                                <div class="clear">&nbsp;</div>
                                <div class="entry">
                                    <?php the_content();?>                                    
                                </div>
                            </div>
                            <div class="clear"></div>
                            <?php query_posts('posts_per_page='.get_option('post_per_page').'&paged='.get_query_var('paged')); ?>
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
                            <div class="clear"></div>                            
                            
                            <div id="pagination"><?php pagination();?></div>
                        </div>
                        <!-- end #content -->
                        
                        <?php get_sidebar(); ?>
<?php get_footer();?>
