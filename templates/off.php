<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>

<div class="container">
		<div class="page-header"><h1>Atsijungti</h1></div>
		
		<div class="col-md-4">
		</div>
		<div class="col-md-4">
		 <?php

    // First we execute our common code to connection to the database and start the session
    require("common.php");
	
	// The parameter values
	$query_params = array(
            ':username' => $_SESSION['user']['username']
        );
		
	
    //log it
            $query = "INSERT INTO log(user, event) VALUES (:username,'Leaves')";
			$stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
			
    // We remove the user's data from the session
    
    unset($_SESSION['user']);
    
    // We redirect them to the login page
    header("Location: index.php");
    die("Redirecting to: index.php"); 
        ?>
        
        </div>
		
</div> <!-- /container -->

<?php include "templates/include/footer.php" ?>