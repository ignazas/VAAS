<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>

	<div class="container">
  		<p>Jūs negalite peržiūrėti šio puslapio, kadangi esate neprisijungęs.</p>
  		<p>Norėdami prisijungti, spauskite <a href="index.php?action=on&amp;destination=<?php echo isset($_GET['destination']) ? $_GET['destination'] : $_SERVER['REQUEST_URI'] ?>">čia</a>.</p> 
      </div>

    </div> <!-- /container -->


<?php include "templates/include/footer.php" ?>