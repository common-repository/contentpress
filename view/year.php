<?php 
$years= $options_year;   
     $arrayyear = array();
    $j=0;  
    if ($years[0] == 0) {
        for($i=1999;$i<=2030;$i++) {
           $arrayyear[$j++] = $i;  
        } 
        $years = $arrayyear; 
    } 
    else $years= $options_year; 
      
if (count($years) > 0) : ?>

<select name="y" class="">
    <option value="0"><?php echo contentpress_e( 'All Year' ); ?></option>
    <?php foreach($years as  $y) : ?>           
        <option value="<?php echo $y;?>" <?php selected( $_POST['y'], $y ); ?>><?php echo $y; ?></option>
    <?php endforeach; ?>
</select>

<?php endif; ?>