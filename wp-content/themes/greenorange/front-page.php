<?php
/**
 * The template for displaying front page.
 *
 **/

get_header();
$options = startup_get_theme_options();
// debug($options);
?>

                        <div id="content">
                            <?php the_post(); ?>
                            <div class="post">
                                <h2 class="title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                                <p class="meta"><span class="date"><?php the_date();?></span><span class="posted">Posted by <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author();?></a></?php> </span></p>
                                <div class="clear">&nbsp;</div>
                                <div class="entry">
                                    <?php the_content();?>                                    
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <!-- end #content -->
                        
                        <?php get_sidebar(); ?>
<?php get_footer();?>