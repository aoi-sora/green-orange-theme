<?php
/**
 * The Sidebar containing the main widget area.
 **/
?>
<div id="sidebar">
    <?php if ( ! dynamic_sidebar( 'sidebar-left' ) ) : ?>

    <ul>
        <li>
            <?php get_search_form();?>
        </li>
        <li>
            <h2>Aliquam tempus</h2>
            <p>Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.</p>
        </li>
        <li>
            <h2>Categories</h2>
            <ul>
               <?php
                    $cat_args['title_li'] = '';
                    wp_list_categories(apply_filters('widget_categories_args', $cat_args));
                ?>
            </ul>
        </li>
        <li>
       
            <?php     
                wp_list_bookmarks(apply_filters('widget_links_args',$args));
            ?>
        </li>
        <li>
            <h2>Archives</h2>
            <ul>
                 <?php wp_get_archives(apply_filters('widget_archives_args', array('type' => 'monthly', 'show_post_count' =>  0))); ?>
            </ul>
        </li>
    </ul>
    <?php endif; ?>
</div>
<!-- end #sidebar -->
 
 

 