<div class="fil-ariane">
	<?php
		if (isset($_GET['p']) && $_GET['p'] != 'home') {
			echo '<a href="'.$_SERVER['PHP_SELF'].'?p=home">Home</a> > <span>'.ucwords($_GET['p'])."</span>\n";
		} else if (isset($_GET['cat'])) {
			if (isset($Thesaurus[$_GET['cat']])) {
				print_r($father);
			} else {
				echo 'Pas de père';
			}
		} else {
			echo '<span>Home</span>';
		}
	?>
	
    <!-- <a href="#">Viandes</a> &gt; <a href="#">Dinde</a> -->
</div>
