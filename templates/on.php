<?php
require_once dirname(__FILE__) . '/../helpers/user.inc';
if (UserHelper::logged_in()) {
    header("Location: index.php");
    die("Redirecting to: index.php");
}
UserHelper::log_in();
?>
<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>
<link href="css/signin.css" rel="stylesheet">

<div class="container">
    <?php include "templates/include/messages.inc" ?>
    <?php include "templates/include/errors.inc" ?>

    <form class="form-signin" role="form" action="" method="post">
      <h2 class="form-signin-heading">Prisijunkite</h2>
	  <div class="form-group">
        <label for="username">Naudotojo vardas arba el. paštas</label>
        <input class="form-control" required="" placeholder="Naudotojo vardas arba el. paštas" type="text" id="username" name="username" value="<?php echo !empty($_POST['username']) ? htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8') : NULL ?>" autofocus="" />
      </div>
	  <div class="form-group">
        <label for="password">Slaptažodis</label>
        <input class="form-control" required="" placeholder="Slaptažodis" type="password" id="password" name="password" value="" />
      </div>

      <a href="#" id="reminder">Atsiųsti naują slaptažodį</a>

      <br />
      <br />

      <input class="btn btn-lg btn-primary btn-block" type="submit" value="Prisijungti" />
    </form>
</div> <!-- /container -->

<?php include "templates/include/footer.php" ?>