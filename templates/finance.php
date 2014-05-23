<?php require "common.php" ?>
<?php require "secure.php" ?>
<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>

     <div class="container">
		<div class="page-header"><h1>Finansai</h1></div>
		
		<div class="col-md-8">

			<?php
			$query = "
            SELECT entry_fee,member_fee,labor_fee,house_fee,electricity_fee,airworthiness_fee,insurance_fee,casco_fee,flight_fee,debt_fee,fee_last_updated
            FROM jos_users
            LEFT JOIN jos_contxtd_details
            ON jos_users.id = jos_contxtd_details.user_id
            LEFT JOIN vak_contxtd_debt
            ON jos_contxtd_details.id = vak_contxtd_debt.contact_id
            WHERE
                jos_users.id = :username
        ";
        
        // The parameter values
        $query_params = array(
            ':username' => $_SESSION['user']['id']
        );
        
        try
        {
            // Execute the query against the database
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            // Note: On a production website, you should not output $ex->getMessage().
            // It may provide an attacker with helpful information about your code. 
            die("Failed to run query: " . $ex->getMessage());
        }
       
        $row = $stmt->fetch();

        $balance = $row['entry_fee'] + $row['member_fee'] + $row['labor_fee'] + $row['house_fee'] + $row['electricity_fee'] + $row['airworthiness_fee'] + $row['insurance_fee'] + $row['casco_fee'] + $row['flight_fee'] + $row['debt_fee'];
        
        
        
        if ($balance < '0') {
            ?><div class="alert alert-danger"><strong>Įspėjimas!</strong> Jūsų likutis neigiamas. Prašome apmokėti susidariusia skolą.</div><?}?>
        <table class="table table-striped">
        <tr>
		  <td>Skrydžių mokesčiai</td>
		  <td><?php echo $row['flight_fee'];?></td>
		 </tr>
        <tr>
		  <td>Nario mokesčiai</td>
		  <td><?php echo $row['member_fee'];?></td>
		 </tr>
		 <tr>
		  <td>Mokestis už namelį</td>
		  <td><?php echo $row['house_fee'];?></td>
		 </tr>       
        <tr>
		  <td>Mokestis už elektrą</td>
		  <td><?php echo $row['electricity_fee'];?></td>
		 </tr>
        <tr>
		  <td>Draudimas</td>
		  <td><?php echo $row['insurance_fee'];?></td>
		</tr>
        <tr>
		  <td>Už surinktus 2%</td>
		  <td><?php echo $row['debt_fee'];?></td>
		 </tr>
		 <tr>
		  <td>Darbai/Talkos</td>
		  <td><?php echo $row['labor_fee'];?></td>
		 </tr>       
        <tr>
		  <td><b>Likutis</b></td>
		  <td><b><?php echo $balance;?> Lt</b></td>
		 </tr> 
		 <tr>
		  <td><b>Duomenu data</b></td>
		  <td><b><?php echo $row['fee_last_updated'];?></b></td>
		 </tr>       
        </table>

		</div>
		<div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Info</h3>
            </div>
            <div class="panel-body">
              <p>Čia yra talpinama informacija apie Jūsų finansus.<br />
              	Jei nematote savo įmokų - pabandykite užeiti kitą dieną.<br />
              	Sistema tobulinama, daugiau funcijų atsiras artimiausiu laiku.
              </p>
            </div>
          </div>
        </div>
		
    </div> <!-- /container -->

<?php include "templates/include/footer.php" ?>