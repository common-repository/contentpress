<?php global $wpdb; 
$rows = $wpdb->get_results("SELECT DISTINCT post_author, u.* FROM $wpdb->posts
JOIN $wpdb->users AS u ON u.ID = post_author 
 WHERE post_type = 'post' AND post_status = 'publish'");
?> 
<select name="fauthor" class="">
    <option value="0"><?php echo contentpress_e( 'Authors' ); ?></option>
    <?php foreach($rows as  $a) : ?>
        <option value="<?php echo $a->ID;?>" <?php selected( $_POST['fauthor'], $a->ID ); ?>><?php echo get_the_author_meta( 'user_login', $a->ID ); ?></option>
    <?php endforeach; ?>
</select>

