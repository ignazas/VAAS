<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>

<div class="container">
	<div class="page-header"><h1>Orlaivių redagavimas</h1></div>
	<div class="col-md-8">
			<?php 
			foreach ( $ac as $aircraft) {
				echo $aircraft['callsign'] . " / " . $aircraft['model']. "<br />"; 
			}
			
			?>
	</div>
</div> <!-- /container -->


<?php include "templates/include/footer.php" ?>