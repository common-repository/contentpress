 <div>
    <h1><?php echo contentpress_e('Content press plugin') ?></h1>

    <p><?php echo contentpress_e('Thank you for using content press plugin. This plugin is just for front-end of the website. We will use wordpress\'s content and categories for the listing.') ?> </p>
    <p><?php echo contentpress_e('For using the plugin at the front-end. You will need to config with show list or blog layout') ?>.</p>
    <ol>
        <li><?php echo contentpress_e('On') ?> <b><?php echo contentpress_e('List layout') ?></b>, <?php echo contentpress_e('please insert shortcode to editor page') ?>: <b>[contentpress name="list"]</b></li>
        <li><?php echo contentpress_e('On') ?>On <b><?php echo contentpress_e('Blog layout') ?></b>, <?php echo contentpress_e('please insert shortcode to editor page:') ?>: <b>[contentpress name="blog"]</b></li>
    </ol>
    </p>
    <p><?php echo contentpress_e('You can also view this video for the guide in') ?> <a href="http://www.xipat.com/products/content-press/quick-tours.html"><?php echo contentpress_e('here') ?></a>
    </p>
    <p><?php echo contentpress_e('If you have any questions, or need any support. Don\'t hesitate to tell us by email to') ?> <a href="mailto:contact@omegatheme.com">contact@omegatheme.com</a></p>
    <hr />
</div>
<div>
    <h2><?php echo contentpress_e( 'Settings' ); ?></h2>
    <form method="post" action="options.php" id="contentpress_options_form" name="contentpress_options_form">
        <?php
             settings_fields('contentpress-options'); 
             do_settings_sections( 'contentpress-options' );
             $options = get_option('contentpress-options');    
             $options_cat = get_option('params_category');  
             $options_year = get_option('params_year');  

             $i=0; $j=0;                                  
         ?>  

        <table>
            <tr valign="top">
                <td><?php echo contentpress_e( 'Choose Categories *' ); ?></td>
                <td>  
                    <select multiple="multiple" name="params_category[]">
                        <option <?php if($options_cat[$i] == 0) echo 'selected = "selected"'; ?> value="0"><?php echo contentpress_e( 'All Categories' ); ?></option>
                        <?php
                         $terms = get_terms( 'category', 'orderby=count&hide_empty=1' ); 
                         foreach($terms as $term) { ?>
                            <option <?php selected( $options_cat, $term->term_id ); ?> value="<?php echo $term->term_id ?>"><?php echo $term->name ?></option> 
                      <?php  } ?>
                    </select>                             
                </td>
            </tr>
            <tr valign="top">
                <td><?php echo contentpress_e( 'Choose years *' ); ?></td>
                <td>
                    <select multiple="multiple" name="params_year[]">
                        <option <?php selected( $options_year[$j], '0' ); ?> value="0"><?php echo contentpress_e( 'All Year' ); ?></option>
                        <?php for ($i=1999;$i<=2030;$i++) { ?>
                            <option <?php selected( $options_year, $i ); ?> value="<?php echo $i ?>"><?php echo $i; ?></option> 
                      <?php } ?>
                    </select>                        
                </td>
            </tr>
            <tr>
                <td><?php echo contentpress_e( 'Filter Field' ); ?></td>
                <td>
                    <select name="contentpress-options[filter_field]">
                        <option <?php selected($options['filter_field'], '1' ); ?> value="1"><?php echo contentpress_e( 'Show' ); ?></option>
                        <option <?php selected($options['filter_field'], '0' ); ?> value="0"><?php echo contentpress_e( 'Hide' ); ?></option>
                    </select>
                </td>
            </tr>                             
            <tr>
                <td><?php echo contentpress_e( 'Display filter Authors' ); ?></td>
                <td>
                    <select name="contentpress-options[filter_author]">
                        <option <?php selected( $options['filter_author'], '1' ); ?> value="1"><?php echo contentpress_e( 'Show' ); ?></option>
                        <option <?php selected( $options['filter_author'], '0' ); ?> value="0"><?php echo contentpress_e( 'Hide' ); ?></option>
                    </select>
                </td>
            </tr>   
            <tr>
                <td><?php echo contentpress_e( 'Display filter Category' ); ?></td>
                <td>
                    <select name="contentpress-options[filter_category]">
                        <option <?php selected( $options['filter_category'], '1' ); ?> value="1"><?php echo contentpress_e( 'Show' ); ?></option>
                        <option <?php selected( $options['filter_category'], '0' ); ?> value="0"><?php echo contentpress_e( 'Hide' ); ?></option>
                    </select>
                </td>
            </tr>  
            <tr>
                <td><?php echo contentpress_e( 'Display filter Year' ); ?></td>
                <td>
                    <select name="contentpress-options[filter_year]">
                        <option <?php selected( $options['filter_year'], '1' ); ?> value="1"><?php echo contentpress_e( 'Show' ); ?></option>
                        <option <?php selected( $options['filter_year'], '0' ); ?> value="0"><?php echo contentpress_e( 'Hide' ); ?></option>
                    </select>
                </td>
            </tr>    
            <tr>
                <td><?php echo contentpress_e( 'Display filter Alphabetic' ); ?></td>
                <td>
                    <select name="contentpress-options[filter_alphabetic]">
                        <option <?php selected( $options['filter_alphabetic'], '1' ); ?> value="1"><?php echo contentpress_e( 'Show' ); ?></option>
                        <option <?php selected( $options['filter_alphabetic'], '0' ); ?> value="0"><?php echo contentpress_e( 'Hide' ); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo contentpress_e( 'Show Date' ); ?></td>
                <td>
                    <select name="contentpress-options[params_date]">
                        <option <?php selected( $options['params_date'], '1' ); ?> value="1"><?php echo contentpress_e( 'Show' ); ?></option>
                        <option <?php selected( $options['params_date'], '0' ); ?> value="0"><?php echo contentpress_e( 'Hide' ); ?></option>
                    </select>
                </td>
            </tr>  
            <tr>
                <td><?php echo contentpress_e( 'Show Category in List' ); ?></td>
                <td>
                    <select name="contentpress-options[show_category]">
                        <option <?php selected( $options['show_category'], '1' ); ?> value="1"><?php echo contentpress_e( 'Show' ); ?></option>
                        <option <?php selected( $options['show_category'], '0' ); ?> value="0"><?php echo contentpress_e( 'Hide' ); ?></option>
                    </select>
                </td>
            </tr>   
            <tr>
                <td><?php echo contentpress_e( 'Show Comment count' ); ?></td>
                <td>
                    <select name="contentpress-options[show_comment]">
                        <option <?php selected( $options['show_comment'], '1' ); ?> value="1"><?php echo contentpress_e( 'Show' ); ?></option>
                        <option <?php selected( $options['show_comment'], '0' ); ?> value="0"><?php echo contentpress_e( 'Hide' ); ?></option>
                    </select>
                </td>
            </tr>                                                               
            <tr>
                <td><?php echo contentpress_e( 'Display filter tag' ); ?></td>
                <td>
                    <select name="contentpress-options[filter_tag]">
                        <option <?php selected( $options['filter_tag'], '1' ); ?> value="1"><?php echo contentpress_e( 'Show' ); ?></option>
                        <option <?php selected( $options['filter_tag'], '0' ); ?> value="0"><?php echo contentpress_e( 'Hide' ); ?></option>
                    </select>
                </td>
            </tr>                                                                                                         
            <tr>
                <td><?php echo contentpress_e( 'Tag Filter' ); ?></td>
                <td>
                    <textarea name="contentpress-options[tags_filter]" cols="30" rows="4"><?php echo $options['tags_filter'] ?></textarea>
                </td>
            </tr> 
            <tr>
                <td><?php echo contentpress_e( 'Show Thumbnail' ); ?></td>
                <td>
                    <select name="contentpress-options[list_show_thumbnail]">
                        <option <?php selected( $options['list_show_thumbnail'], '1' ); ?> value="1"><?php echo contentpress_e( 'Show' ); ?></option>
                        <option <?php selected( $options['list_show_thumbnail'], '0' ); ?> value="0"><?php echo contentpress_e( 'Hide' ); ?></option>
                    </select>
                </td>
            </tr>                     
            <tr>
                <td><?php echo contentpress_e( 'Thumbnail Width' ); ?></td>
                <td>
                    <input name="contentpress-options[thumbnail_width]" value="<?php echo $options['thumbnail_width'] ?>"/>
                </td>
            </tr>  
            <tr>
                <td><?php echo contentpress_e( 'Thumbnail Height' ); ?></td>
                <td>
                    <input name="contentpress-options[thumbnail_height]" value="<?php echo $options['thumbnail_height'] ?>"/>
                </td>
            </tr>
            <tr>
                <td><?php echo contentpress_e( 'Count charater show' ); ?></td>
                <td>
                    <input name="contentpress-options[count_charater]" value="<?php echo $options['count_charater'] ? $options['count_charater'] : '100'; ?>"/>
                </td>
            </tr>                                                                                                                          
        </table>
        <p>
        <input type="submit" value="<?php _e('Save Changes') ?>" />
        </p>

    </form>            
</div>
