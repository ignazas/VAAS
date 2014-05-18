<?php require "common.php" ?>
<?php require "secure.php" ?>
<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>

<div class="container">
	<div class="page-header"><h1>Vartotojo nustatymai</h1></div>
      
      <div class="col-md-8">
      	<div class="col-md-6">
      		<img src="" style="width: 150px; height: 150px;" class="img-thumbnail" alt="150x150 Foto">
        </div>
        <div class="col-md-6">
        	<?php 
	        	echo "<b>Vardas:</b> " . $_SESSION['user']['name'] . "<br />"; 
	        	echo "<b>El. paštas:</b> " . $_SESSION['user']['email'] . "<br />";
				echo "<b>Telefonas:</b> " . $_SESSION['user']['telephone1'] . "<br />";
				echo "<b>Interneto svetainė:</b> " . $_SESSION['user']['website'] . "<br />";
				echo "<b>Vartotojo tipas:</b> " . $_SESSION['user']['usertype'] . "<br />";
				echo "<b>Užsiregistravo:</b> " . $_SESSION['user']['registerDate'] . "<br />";
				echo "<b>Paskutinis apsilankymas:</b> " . $_SESSION['user']['lastvisitDate'] . "<br />";
			 ?>
        </div>   

		</div>

      <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Info</h3>
            </div>
            <div class="panel-body">
              <p>Čia galite keisti savo slaptažodį ar asmeninius duomenis.</p>
            </div>
          </div>
        </div>
        
  
	
		
    </div> <!-- /container -->



        



<?php include "templates/include/footer.php" ?>