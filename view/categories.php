<?php
?>
<?php if (count($terms) > 0) : ?>

    <select name="catid">
        <option <?php selected( $options_cat, '0' ); ?> value="0"><?php echo contentpress_e( 'All Categories' ); ?></option>
        <?php
        $terms= $options_cat;
        if ($terms[0] == 0) $terms = get_terms( 'category', 'orderby=count&hide_empty=1' ); 
        else $terms = $options_cat; 
         foreach($terms as $term) { ?>
            <option <?php selected( $options_cat, $term->term_id ); ?> value="<?php echo $term->term_id ?>"><?php echo $term->name ?></option>
      <?php  } ?>
    </select>  

<?php endif; ?>