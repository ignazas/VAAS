<?php require "common.php" ?>
<?php require "secure.php" ?>
<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>

<script src="js/jquery-1.11.0.js"></script>
<script src="js/jquery.bpopup.min.js"></script>

<link href="css/popup.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<div id="addDay">

Pasirinkite dieną, kad atžymėti: <br/> <br/>

<form role="form" action="admin.php">
	<input id="day" placeholder="2014-01-01" type="text" class="form-control" name="day"><div id="my_holder_div"></div><br/>
	<select name="status" class="form-control">
	  <option value="vyksta">Vyksta</option>
	  <option value="nevyksta">Nevyksta</option>
	  <option value="talka">Dalyvavimas būtinas</option>
	</select> 
	<input type="hidden" name="confirmed" value="<?php echo $_SESSION['user']['name']; ?>"/><br/>
	<center><button type="submit" name="action" class="btn btn-primary" value="addDay">Atžymėti</button></center>
</form>

</div>
<div class="container">
	<div class="page-header"><h1>Darbo dienų atžymėjimas</h1></div>

<div class="col-md-8">
	<?php if ( isset( $workingDays['errorMessage'] ) ) { ?>
		<div class="alert alert-danger">
			<strong>Klaida!</strong> <?php echo $workingDays['errorMessage'] ?>
		</div>
	<?php } ?>
	<?php if ( isset( $workingDays['statusMessage'] ) ) { ?>
		<div class="alert alert-success">
        <strong>Atlikta!</strong> <?php echo $workingDays['statusMessage'] ?>
      </div>
	<?php } ?>
      	<table class="table">
      		<tr class="active">
			<th>Data</th>
			<th>Statusas</th>
			<th>Patvirtino</th>
			<th>Pastaba</th>
			<th></th>
          	</tr>
          <?php if(isset($workingDays['days'])){
	          	foreach ( $workingDays['days'] as $day ) { 
	          	    if($day['status']=="vyksta") {echo "<tr class=\"success\">";} else {echo "<tr class=\"danger\">";}
	          		echo "<td>".$day['day']."</td>";
					echo "<td>".$day['status']."</td>";
					echo "<td>".$day['confirmed']."</td>";
					echo "<td>".$day['reason']."</td>";
					echo "<td>"; ?>
					<form action="admin.php">
	          		<input type="hidden" name="day" value="<?php echo $day['day']; ?>"/>
	 				<button type="submit" name="action" onclick="return confirm('Ar tikrai norite pašalinti dienos žymę?')" class="btn btn-xs btn-danger" value="deleteDay">Pašalinti</button>
					</form> <?php
	          		echo "</td></tr>";
		  			}
				}
		  ?>
		</table>
		<!--<div id="prideti">
			<a class="addDay" href="#">Pridėti dar vieną dieną</a>
		</div>-->
		
        </div>
        
      <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Info</h3>
            </div>
            <div class="panel-body">
              <p>Čia yra visos darbo dienos.</p>
            </div>
          </div>
        </div>    
        
    </div> <!-- /container -->

<?php include "templates/include/footer.php"; ?>
