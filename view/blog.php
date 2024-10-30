<?php   
    $terms = get_terms( 'category', 'orderby=count&hide_empty=1' );
    $cat_id = $_POST['catid'];   
    $tag = $_POST['tags'];   
    $years= $options_year;    
    $authors = $_POST["fauthor"];   
    // function filter with date
    add_filter( 'posts_where', array('Contentpress', 'filter_query') );
    // pagination

    $per_page = get_option('posts_per_page'); 
    $pagenum = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $offset = 0 < $pagenum ? $per_page * ( $pagenum - 1 ) : 0;

    $args = array(
        'posts_per_page'   => $per_page,
        'offset' => $offset,
        'paged' => $paged,
        'category'         => $cat_id,
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'include'          => '',
        'exclude'          => '',
        'meta_key'         => '',
        'meta_value'       => '',
        'post_type'        => 'post',
        'post_mime_type'   => '',
        'post_parent'      => '',
        'post_status'      => 'publish',
        'tag' => $tag,
        'suppress_filters' => false );
     
     //get content data       
    $posts_array = get_posts( $args );
   
   // pagination  
    $get_posts = new WP_Query;
    $posts = $get_posts->query( $args );
    if ( ! $get_posts->post_count ) {
        echo '<p class="notify">' . __( 'No items.' ) . '</p>';
        //return;
    }
    $num_pages = $get_posts->max_num_pages;
    
    $page_links = paginate_links( array(
        'base' => add_query_arg(
            array(
                'paged' => '%#%',
            )
        ),
        'format' => '',
        'prev_text' => __('&laquo;'),
        'next_text' => __('&raquo;'),
        'total' => $num_pages,
        'current' => $pagenum
    ));     
     
     remove_filter( 'posts_where', array('Contentpress', 'filter_query') );
    ?>
<div id="xpcontentpress" class="category-list">
       
    <div class="cat-items">
        <form action="" method="post">
            <?php if ($options['filter_field'] != 0) :?>
                <fieldset class="filters">
                    <?php if ($options['filter_field'] != 0) :?>
                    <div class="filter-search">
                        <input type="text" placeholder="<?php echo contentpress_e( 'Keyword...' ) ?>" title="<?php echo contentpress_e( 'Enter Keyword' ) ?>" class="inputbox" value="<?php echo $_POST["filter-search"] ?>" id="filter-search" name="filter-search">
                        <input type="submit" class="button" value="<?php echo contentpress_e( 'Search' ) ?>" id="filter-submit" name="filter-submit">
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($terms) || $options['filter_category'] != 0) : ?>
                    <div class="cat-children">
                        <div class="float-left"><?php include(Contentpress::file_path('view/categories.php')); ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($years) || $options['filter_year']!=0) : ?>
                    <div class="cat-children">
                        <div class="float-left"><?php include(Contentpress::file_path('view/year.php')); ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($authors) || $options['filter_author']!=0) : ?>
                    <div class="cat-children">
                        <div class="float-left"><?php include(Contentpress::file_path('view/authors.php')); ?></div>
                    </div>
                    <?php endif; ?>   
                    <?php if ($options['filter_tag']!=0 && $options['tags_filter'] != '') : ?>
                    <div class="cat-children">
                        <div class="float-left"><?php include(Contentpress::file_path('view/tags.php')); ?></div>
                    </div>
                    <?php endif; ?>                                                                      
                </fieldset>
                <?php if ($options['filter_alphabetic']!=0) : ?>
                    <div class="alphabet">
                        <?php include(Contentpress::file_path('view/alphabet.php')); ?>
                    </div>
                <?php endif; ?>  
            <?php endif; ?>
 
        <?php if (empty($posts_array)) : ?>

        <?php echo '<div>' . contentpress_e( 'No items.' ) . '</div>'; ?>

        <?php else : ?>
            <div id="xpblog-category" class="row">
                <?php foreach ($posts_array as $i => $article) :  setup_postdata($article);
                    $post_id = $article->ID;        
                    $category = wp_get_post_terms( $post_id, 'category' );    
                ?>
                    <div class="xpblog-item col-lg-3 col-md-4 col-sm-2 col-xs-12" style="padding: 15px;">
                        <div class="xppadding">
                            <h3><a href="<?php echo get_permalink( $post_id ); ?>"><?php echo $article->post_title; ?></a></h3>
                            <?php if ($options['params_date']) : ?> 
                                <div class="w100 float-left created"><?php echo mysql2date( get_option( 'date_format' ), $article->post_date ); ?></div>
                            <?php endif; ?>
                            <?php if ($options['list_show_thumbnail'] ) : ?> 
                                <div class="xpblog-item-img" style="text-align: center;">
                                    <?php if(has_post_thumbnail($post_id )) : ?>
                                        <a href="<?php echo get_permalink( $post_id ); ?>"><img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post_id ) ); ?>" width="<?php echo $options['thumbnail_width'] ?>" height="<?php echo $options['thumbnail_height'] ?>" class="contentpress-category-img" title="<?php echo $article->post_title; ?>"></a>
                                    <?php else : ?>
                                        <img src="<?php echo plugins_url('/images/noimg.jpg',__FILE__ ) ?>" class="contentpress-category-img">
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <div class="xpblock-content">
                                <?php
                                $text = strip_tags($article->post_excerpt);
                                $limit_word = $options['count_charater'];
                                if (strlen($text) < $limit_word){
                                    echo $text;       
                                } else {
                                    echo substr($text, 0, strpos($text, ' ', $limit_word)).'... <a href="'.get_permalink( $post_id ).'">'.contentpress_e( "Readmore" ).'</a>';
                                }
                                ?>
                            </div>
                        </div>
                        <?php if ($options['filter_author'] || $options['filter_category']) : ?> 
                            <div class="xpblog-item-info">
                                <div class="w100 float-left">
                                    <?php if ($options['filter_author']) : ?> 
                                        <div class="w50 float-left" style="line-height:200%;">
                                            <div class="w0 float-left">
                                                <?php echo get_the_author_meta( 'user_login', $article->post_author ); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($options['filter_category']) : ?> 
                                        <div class="w50 float-right text-right" style="line-height:200%;">
                                            <?php
                                                $array = array();    
                                                foreach ($category as $key=> $row){   
                                                     $array[$key] = '<a href="'.get_category_link($row->term_id).'">'.$row->name.'</a>';  
                                                }   
                                                echo implode(", ", $array);    
                                             ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="pagination">
                <?php echo $page_links; ?>
            </div>
            
        <?php endif; ?>

        </form>
    </div>

</div>
