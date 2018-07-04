<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>

<div class="container">
  <p>Jūs negalite peržiūrėti šio puslapio, kadangi esate neprisijungęs.</p>
  <p>Norėdami prisijungti, spauskite <a href="index.php?action=on&amp;destination=<?php echo isset($_GET['destination']) ? $_GET['destination'] : $_SERVER['REQUEST_URI'] ?>">čia</a>.</p> 
</div> <!-- /container -->

<div class="container">
  <p>Jei kyla problemų, susisiekite: <a href="mailto:mantas@kurti.lt">mantas@kurti.lt</a>.</p>
</div> <!-- /container -->

<?php include "templates/include/footer.php" ?>
