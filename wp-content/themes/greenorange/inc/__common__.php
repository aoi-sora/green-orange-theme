<?php
 /*
 * Generic Functions
 * 
 */

 
/**
 * popular post
 **/ 
function BP_popularPosts($num) {
    global $wpdb;
    $posts = $wpdb->get_results("SELECT comment_count, ID, post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , $num");
    foreach ($posts as $post) {
        setup_postdata($post);
        $id = $post->ID;
        $title = $post->post_title;
        $count = $post->comment_count;

        if ($count != 0) {
            $popular .= '<li>';
            $popular .= '<a href="' . get_permalink($id) . '" title="' . $title . '">' . $title . '</a> ';
            $popular .= '</li>';
        }
    }
    return $popular;
}

 
/**
 * seo title
 **/ 
function BP_seo_title($custom_field = '_aioseop_title') {
    global $post;
    $t = get_post_custom($post->ID);
    $title = $t[$custom_field][0];
    return (  htmlspecialchars(stripcslashes($title))  );
}

/**
 * related posts
 **/
function BP_related_posts($post) {
    $tags = wp_get_post_tags($post->ID);
    if ($tags) {
        $tag_ids = array();
        foreach ($tags as $individual_tag)
            $tag_ids[] = $individual_tag->term_id;

        $args = array(
            'tag__in' => $tag_ids,
            'post__not_in' => array($post->ID),
            'showposts' => 4, // Number of related posts that will be shown.
            'caller_get_posts' => 1
        );
        $my_query = new wp_query($args);
        /* if( $my_query->have_posts() ) {
          echo '<h3>Related Posts</h3><ul>';
          while ($my_query->have_posts()) {
          $my_query->the_post();
          ?>
          <li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
          <?php
          }
          echo '</ul>';
          }
         */
        return $my_query;
    } else {
        return array();
    }
}
    
/**
 * get posts by custom fields
 **/
function get_special_content($meta_key, $meta_value) {
   global $wpdb;
   $querystr = "
        SELECT $wpdb->posts.* 
        FROM $wpdb->posts, $wpdb->postmeta
        WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
        AND $wpdb->postmeta.meta_key = '{$meta_key}' 
        AND $wpdb->postmeta.meta_value = '{$meta_value}' 
        AND $wpdb->posts.post_status = 'publish' 
        AND $wpdb->posts.post_type = 'page'
        ORDER BY $wpdb->posts.ID ASC
    ";

     
    $pageposts = $wpdb->get_results($querystr, OBJECT);
    
    
    return $pageposts;
    
}    

/*
 * Usage : 
 * @post_id : may pass post id, if none, id of current post is used
 * @columns : # of columns
 * @size : thumbnail, medium, large or full
 * @links : | separated urls to which the image links to, otherwise retrieves the guid of the attachment post
 * 
 * Sample
 * [inline-gallery]
 * [inline-gallery columns="3" size="thumbnail"]
 * [inline-gallery columns="1" size="thumbnail" ]
 */

function inline_gallery_func($atts, $content = null) {
    global $post;
    extract(shortcode_atts(array(
                'post_id' => $post->ID,
                'columns' => 2,
                'size' => 'medium',
                'links' => ''
                    ), $atts));

    $attachments = get_children(array('post_parent' => $post->ID, 'order' => 'ASC'));
    if (count(explode('|', $links)) == 0) {
        
    } else {
        $url = explode('|', $links);
    }

    $col = 0;
    ob_start();
    ?>

    <br/>
    <div class="inline-gallery-container" style="clear:both;margin:10px;">
        <div class="content"><?php echo $content; ?></div>
        <?php
        foreach ($attachments as $v) {

            $style = $col < $columns ? 'float:left;margin-top:10px;margin-right:10px;' : 'clear:both;float:left;margin-top:10px;margin-right:10px;';
            $col = $col < $columns ? $col : 0;
            ?>    
            <div class="inline-gallery-div" style="<?php echo $style; ?>">
                <?php
                echo wp_get_attachment_image($v->ID, $size, '', array('class' => 'inline-gallery-img',
                    'alt' => trim(strip_tags(get_post_meta($v->ID, '_wp_attachment_image_alt', true))),
                    'title' => trim(strip_tags($v->post_title)),
                        )
                );
                ?>
                <br/><?php echo $v->post_excerpt; ?>

            </div>

            <?php
            ++$col;
        }
        ?>
    </div>
    <?php
    $out = ob_get_contents();
    ob_end_clean();
    return $out;
}

add_shortcode('inline-gallery', 'inline_gallery_func');


/*
 * Usage : 
 * @post_id : may pass post id, if none, id of current post is used
 * @columns : # of columns
 * @image :  | separated image urls
 * @caption : image separated by |  
 * @links : | separated urls to which the image links to, otherwise retrieves the guid of the attachment post
 * @align : left, or center default is left
 * [inline-image image="wp-content/uploads/2012/04/images2-150x150.jpg|wp-content/uploads/2012/04/Ice-Cream-Sandwich-Desserts-Photos-300x288-150x150.jpg" caption="caption1|caption2" links="http://yahoo.com|http://google.com"][inline-image image="wp-content/uploads/2012/04/images2-150x150.jpg|wp-content/uploads/2012/04/Ice-Cream-Sandwich-Desserts-Photos-300x288-150x150.jpg" caption="caption1|caption2" links="http://yahoo.com|http://google.com"]
 */

function inline_image_func($atts, $content = null) {
    extract(shortcode_atts(array(
                'columns' => 2,
                'image' => '',
                'caption' => '',
                'links' => '',
                'align' => 'left'
                    ), $atts));

    $img = explode('|', $image);
    $url = explode('|', $links);
    $caption = explode('|', $caption);
    $to_center = $align =='center' ? 'margin-left:auto;margin-right:auto;' : '';
    $first_row = 1;
    $columns = $columns == 1 ? 0 : $columns;
    ob_start();
    ?>

    <div class="inline-image-container" style="clear:both;margin:10px;">            
        <table class="inline-image-table" style="clear:both;<?php echo $to_center;?>">
            <tr><td colspan="<?php echo $columns?>">
                <div class="content"><?php echo $content; ?></div>
                </td>
            </tr>
            <tr>
            <?php
            foreach ($img as $k => $v) {
                $style = $col < $columns ? 'float:left;margin-top:10px;margin-right:10px;' : 'clear:both;float:left;margin-top:10px;margin-right:10px;';
                $tr = $col < $columns  ? '' : '<tr>';
                $tr_end = $col < $columns  ? '' : '</tr>';
                $first_row = 0;
                echo $tr;
                ?>

                <td>
                    <div class="inline-image-div" style="<?php echo $style; ?>">

                        <a class="inline-image-a" href="<?php echo (empty($url[$k]) ? 'javascript:void(0);' : $url[$k]); ?>" title="<?php echo $caption[$k]; ?>"><img src="<?php echo $v; ?>" class="inline-image-img"/></a>
                        <br/><?php echo $caption[$k]; ?>
                    </div>
                </td>

                <?php
                if($first_row && $columns == $col)
                    echo '</tr>';
                else
                    echo $tr_end;
            }
            ?>
        </table>
        <?php
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

add_shortcode('inline-image', 'inline_image_func');

// shortcode support for videojs html 5  - usually mp4
/* http://videojs.com/tag-builder/
 * http://videojs.com/docs/options/
 * http://videojs.com/docs/api/
 */
function inline_videojs_func($atts, $content = null) {
    extract(shortcode_atts(array(
                'type' => 'video/mp4',
                'src' => '',
                'caption' => '',
                'height' => '280',
                'width' => '320',
                'links' => ''
                    ), $atts));

    $snippet =
            '<!-- Begin Video.js -->
<video loop class="video-js vjs-default-skin" width="' . $width . '" height="' . $height . '" controls 0 autoplay data-setup="{}">
<source src="' . $src . '" type="' . $type . '" />
</video>
<!-- End Video.js -->';

    $style = 'clear:both;;margin-top:10px';
    ob_start();
    ?>

    <div class="inline-videojs-container" style="clear:both;margin:10px;">
        <div class="content"><?php echo $content; ?></div>
        <div class="inline-videojs-div" style="<?php echo $style; ?>">

            <a class="inline-videojs-a" href="<?php echo (empty($links) ? 'javascript:void(0);' : $links); ?>" title="<?php echo $caption ?>">
            <?php echo $snippet; ?>
            </a>
            <br/><?php echo $caption; ?>
        </div>

        <?php
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

add_shortcode('inline-videojs', 'inline_videojs_func');

/**
 * retrieves the ids of posts with video thumbnails meta
 **/ 
function video_post_ids($post_rows_qry) {
    $video_post_id = array();
    while ($post_rows_qry->have_posts()) : $post_rows_qry->the_post();
        $video_post_id[] = get_the_ID();
    endwhile;
    return $video_post_id;
}

/**
 * thumbnail_video_list()
 **/
function thumbnail_video_list() {
    //$args_pair = array('key' => '_video_thumbnail', 'value' =>'http://goldpop.truelogical.com/wp-content/uploads/2012/04/01.jpg' , 'compare' => '=', 'type' => 'CHAR');

    $args_pair = array('key' => '_video_thumbnail', 'value' => '""', 'compare' => '!=', 'type' => 'CHAR');
    $args[] = $args_pair;
    $video_posts = get_posts_by_custom_fields($args, 'video_posts');
}

/**
 * get_posts_by_custom_fields
 **/ 
function get_posts_by_custom_fields($fields_query = array(), $cb = '', $post_type = 'page') {
    // this also works or $wpdb->get_results(); we have 3 options
    //$post_rows = get_posts(array( 'meta_query' => $fields_query, 'post_type' => $post_type, 'orderby' => 'post_date','order' =>'DESC'  ));
    // $myrows = $wpdb->get_results( "SELECT id, name FROM mytable" );
    $post_rows = new WP_Query(array('meta_query' => $fields_query, 'post_type' => $post_type, 'orderby' => 'post_date', 'order' => 'DESC'));
    if (!empty($cb)) {
        $cb($post_rows);
    }
    return $post_rows;
}

/**
 * video_posts
 **/
function video_posts($post_rows = array()) {
    while ($post_rows->have_posts()) : $post_rows->the_post();
        $video_thumbnail = get_video_thumbnail(get_the_ID());
        ?>      
        <div class="video">
            <img src="<?php echo $video_thumbnail; ?>" />
            <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
            <span class="date"><?php the_date(); ?></span>
        </div>

        <?php
    endwhile;
}
            
            
/**
* [sitemap]content[/sitemap]
**/
function sitemap_func($attr=array(),$content) {
    ob_start();
?>   
       <ul class="sitemap"><?php wp_list_pages(array('sort_column' => 'menu_order', 'title_li' => null, )); ?>
       </ul>                      
     <?php $content = ob_get_contents();
       ob_end_clean();
       return $content;
}
add_shortcode('sitemap','sitemap_func');
   

/**
* pagination
**/
function pagination() {
   global $wp_query;

   $big = 999999999; // need an unlikely integer
   
   echo  paginate_links( array(
       'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
       'format' => '?paged=%#%',
       'current' => max( 1, get_query_var('paged') ),
       'total' => $wp_query->max_num_pages ,
    
   ) );	
}

/**
* post thumbnail
**/
function show_post_thumbnail($post_id=null,
                            $attr=array('class' => 'thumbnail-image',
                                        'alt' => '', 'title' => ''),
                            $size='thumbnail') {
    $post_id = empty($post_id) ? get_the_ID() : $post_id;
    extract($attr);
    echo get_the_post_thumbnail(   $post_id,
                                   $size,  
                                   array('class' => $class,
                                         'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true))),
                                         'title' => trim(strip_tags(get_the_title(get_post_thumbnail_id($post_id)) ))
                                    )
                               );               
}

/**
* top image slider
**/
function show_top_slider($post_id=null,
                         $attr=array('class' => 'sliding-image',
                                        'alt' => '', 'title' => ''),
                         $size='full', $post_type = 'top-sliding-image') {
   $post_id = empty($post_id) ? get_the_ID() : $post_id;
   $sliders =  get_sliding_images($post_id);            
?>
   <div id="top-slider">
       <div id="contents-slider">
           <div class="contents-slides">
               <?php
                   foreach($sliders as $slider) {
                       extract($attr); ?>
                       <div class="slide-box">
                           <?php echo get_the_post_thumbnail( $slider->ID,
                                                   $size,  
                                                   array('class' => $class,
                                                         'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($slider->ID), '_wp_attachment_image_alt', true))),
                                                         'title' => trim(strip_tags(get_the_title(get_post_thumbnail_id($slider->ID)) ))
                                                    )
                                               );
                                      
                           ?>                        
                       </div>
               <?php } ?>
           </div>
       </div>
   </div>

<?php        
}

/**
*
* get_sliding_images
* check if page is associated with sliding image
**/
function get_sliding_images($post_id=null,$post_type = 'top-sliding-image') {
    $post_id = empty($post_id) ? get_the_ID() : $post_id;
    global $wpdb;
    $query = "SELECT p.ID, pm.* FROM $wpdb->posts p
           INNER JOIN $wpdb->postmeta pm ON p.ID = pm.post_id
    WHERE  p.post_type = '{$post_type}' AND post_status = 'publish' AND pm.meta_key = 'su_slide_to_page'
    ORDER BY post_date DESC";
    
    $images = $wpdb->get_results($query, OBJECT);
    
    foreach($images as $image) {
       $page_ids = empty($image->meta_value) ? array() :  unserialize($image->meta_value);
       if(in_array($post_id,$page_ids)) {
           $sliders[] = $image;
       }
    }
    
    return $sliders;
}

/**
* inline gallery slider feature
**/

function gallery_slider_func($attr, $post_id=null, $size='full' ) {
    global $post;
    
    extract(shortcode_atts(array(   'size'  => 'full',
                                   'class' => 'gallery-image'
                               ),
                          $attr)
          );
    
    $post_id =  get_the_ID()  ;
    $images = get_children( array( 'post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
    ob_start();
    ?>  <div id="gallery-slide">
       <div class="gallery-slides"> 
       <?php foreach( $images as $image ) :
       ?>      <div class="gallery-slide-box"> 
                   <?php $image_img_tag = wp_get_attachment_image(  $image->ID, $size, false,
                                                               array('class' => $size,
                                                                         'alt' => trim(strip_tags(get_post_meta( $image->ID , '_wp_attachment_image_alt', true))),
                                                                         'title' => trim(strip_tags(get_the_title( $image->ID ) ))
                                                                    )
                                                           );
                       echo $image_img_tag;
                   ?>
               </div>
       <?php endforeach; ?>
       </div>
    </div>
    <?php   $content = ob_get_contents();
       ob_end_clean();
       return $content;
}
add_shortcode('slide-gallery','gallery_slider_func');
?>
        