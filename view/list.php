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
            <table class="category" cellpadding="0" cellspacing="0">
                <?php //if ($this->params->get('show_headings')) :?>
                <thead>
                    <tr>
                        <th class="list-title" id="tableOrdering">
                           <?php echo contentpress_e( 'Title' ); ?>
                        </th>
                        <?php if ($options['show_category']) : ?> 
                        <th class="list-category" id="tableOrdering4">
                            <?php echo contentpress_e( 'Categories' ); ?> 
                        </th>
                        <?php endif; ?>
                        <?php if ($options['params_date']) : ?>
                        <th class="list-date" id="tableOrdering2">
                            <?php echo  contentpress_e( 'Date' ); ?> 
                        </th>
                        <?php endif; ?>   
                        <?php if ($options['filter_author']) : ?>
                        <th class="list-date" id="tableOrdering2">
                            <?php echo contentpress_e( 'Author' ); ?> 
                        </th>
                        <?php endif; ?> 
                        <?php if ($options['show_comment']) : ?>
                        <th class="list-hits" id="tableOrdering2">
                            <?php echo contentpress_e( 'Comments' ); ?>
                        </th>
                        <?php endif; ?>                                                                        
                    </tr>
                </thead>
                <?php //endif; ?>

                <tbody>

                <?php foreach ($posts_array as $i => $article) :  setup_postdata($article);
                    $post_id = $article->ID;        
                    $category = wp_get_post_terms( $post_id, 'category' );    
                 ?>
                    <?php if (count($posts_array) == 0) : ?>
                        <tr class="system-unpublished cat-list-row<?php echo $i % 2; ?>">
                    <?php else: ?>
                        <tr class="cat-list-row<?php echo $i % 2; ?>" >
                    <?php endif; ?>

                            <td class="list-title">
                                <a href="<?php echo get_permalink( $article->ID ); ?>">
                                    <?php echo $article->post_title; ?></a>                        
                            </td>
                            <?php if ($options['show_category']) : ?> 
                            <td class="list-category">                                         
                                <?php
                                    $array = array();    
                                    foreach ($category as $key=> $row){   
                                         $array[$key] = '<a href="'.get_category_link($row->term_id).'">'.$row->name.'</a>';  
                                    }   
                                    echo implode(", ", $array);    
                                 ?>
                            </td>
                            <?php endif; ?>
                            <?php if ($options['params_date']) : ?> 
                            <td class="list-date">
                                 <?php echo mysql2date( get_option( 'date_format' ), $article->post_date ); ?> 
                            </td>
                            <?php endif; ?>
                            <?php if ($options['filter_author']) : ?> 
                            <td class="list-date">
                                <?php echo get_the_author_meta( 'user_login', $article->post_author ); ?>
                            </td>
                            <?php endif; ?> 
                              
                            <?php if ($options['show_comment']) : ?> 
                            <td class="list-date">
                                <?php echo $article->comment_count; ?>
                            </td>
                            <?php endif; ?>                                                          
             
                        </tr>
                <?php endforeach; ?>
                </tbody>
            </table>    
            <?php echo $page_links; ?>
        <?php endif; ?>

        </form>
    </div>

</div>
