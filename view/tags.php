<?php
$tags = $options['tags_filter']; 
?>
<?php if (count($tags) > 0) : ?>

    <select name="tags">
        <option <?php selected( $options['tags_filter'], '0' ); ?> value=""><?php echo contentpress_e( 'All Tags' ); ?></option>
        <?php
        $tags = explode(',',$tags);
         foreach($tags as $tag) { ?>
            <option <?php selected( $_POST['tags'], $tag ); ?> value="<?php echo $tag ?>"><?php echo $tag; ?></option> 
      <?php  } ?>
    </select>  

<?php endif; ?>