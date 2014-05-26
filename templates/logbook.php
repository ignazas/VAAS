<?php 
require "common.php";
require "secure.php";
include "templates/include/header.php";
include "templates/include/top-menu.php";

?>

<div class="container">
	<div class="page-header"><h1>Log Book</h1></div>
      <div class="col-md-8">
          <?php
          
          	$query_result = DB::query("SELECT * FROM flights WHERE pilot ='" . $_SESSION['user']['id'] . "'");
			$skrydziai = array();
			foreach ($query_result as $eilute) {
				$skrydziai[$eilute['record_id']][] = $eilute['record_id'];
				$skrydziai[$eilute['record_id']]['record_id'] = $eilute['record_id'];
			    $skrydziai[$eilute['record_id']]['data'] = $eilute['date'];
			    $skrydziai[$eilute['record_id']]['airplane_registration'] = $eilute['airplane_registration'];
				$skrydziai[$eilute['record_id']]['task'] = $eilute['task'];
				$skrydziai[$eilute['record_id']]['amount'] = $eilute['amount'];
				$skrydziai[$eilute['record_id']]['duration'] = $eilute['duration'];
			}
          ?>

        <table class="table table-striped">
      		<tr>
          	<th>#</th>
			<th>Data</th>
			<th>Registracija</th>
			<th>Užduotis</th>
			<th>Skrydžių kiekis</th>
			<th>Skrydžių trukmė</th>
          	</tr>
          <?php foreach ( $skrydziai as $skrydis ) { 
          	
          		echo "<td>".$skrydis['record_id']."</td>";
				echo "<td>".$skrydis['data']."</td>";
				echo "<td>".$skrydis['airplane_registration']."</td>";
				echo "<td>".$skrydis['task']."</td>";
				echo "<td>".$skrydis['amount']."</td>";
				echo "<td>".$skrydis['duration']."</td>";
          		echo "</tr>";
				}
		  
		  ?>
		</table>
	 </div>
      <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Info</h3>
            </div>
            <div class="panel-body">
              <p>Čia bus visi įvykdyti skrydžiai registruoti aerodrome.</p>
            </div>
          </div>
        </div>
      

    </div> <!-- /container -->



<?php include "templates/include/footer.php" ?>