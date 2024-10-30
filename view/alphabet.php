<?php global $wpdb; 
$alphabet =isset($_POST["falphabet"])?$_POST["falphabet"]:'all';
?> 
<ul class="filter-alphabet">
	<li>
		<input <?php checked( $alphabet, 'all' ); ?> type="radio" name="falphabet" id="falphabet" value="all"><label for="falphabet"><?php echo contentpress_e( 'All' ); ?></label>	
	</li>
	<?php foreach (range('a','z') as $i) { ?>
		<li><input <?php checked( $alphabet, $i ); ?> type="radio" name="falphabet" id="falphabet<?php echo $i ?>" value="<?php echo $i ?>"><label for="falphabet<?php echo $i ?>"><?php echo strtoupper ($i) ?></label></li>
	<?php
	} ?>
</ul>