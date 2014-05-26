<?php include "templates/include/header.php"
?>
<?php include "templates/include/top-menu.php"
?>

<div class="container">
	<div class="page-header">
		<h1>Atsijungti</h1>
	</div>

	<div class="col-md-4"></div>
	<div class="col-md-4">
		<?php

        // First we execute our common code to connection to the database and start the session
        require ("common.php");

        // The parameter values
        $query_params = array(':username' => $_SESSION['user']['username']);

        //log it
        require_once dirname(__FILE__) . '/../functions.php';
        log_event($_SESSION['user']['username'], 'Leaves', '');

        // We remove the user's data from the session

        unset($_SESSION['user']);

        // We redirect them to the login page
        header("Location: index.php");
        die("Redirecting to: index.php");
		?>
	</div>

</div>
<!-- /container -->

<?php include "templates/include/footer.php"
?>