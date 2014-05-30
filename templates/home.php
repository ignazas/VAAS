<?php require "common.php" ?>
<?php require "secure.php" ?>
<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>
<?php 

	$quote = array(
	"<p>“Once you have tasted flight, you will forever walk the earth with your eyes turned skyward, for there you have been, and there you will always long to return.”</p><small>Leonardo da Vinci</small>",
	"<p>“You wanna fly, you got to give up the shit that weighs you down.”</p><small>Toni Morrison, Song of Solomon</small>",
	"<p>“Less flapping, more flying!”</p><small>Silvia Hartmann</small>",
	"<p>“If you want success in life, then just learn how to walk like a turtle instead of flying.”</p><small>Vikrant Parsai</small>",
	"<p>“Other people had flying dreams. I had falling nightmares.”</p><small>Kami Garcia and Margaret Stohl, Beautiful Redemption</small>",
	"<p>“The reason birds can fly and we can't is simply because they have perfect faith, for to have faith is to have wings.”</p><small> J.M. Barrie, The Little White Bird</small>");

?>

    <div class="container">
	      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Sveiki!</h1>
        <p>Tai yra Vilniaus Aeroklubo Administravimo Sistema - VAAS.</p>
      </div>
	<div class="row">
	  <div class="col-xs-12 col-md-8">
	  	<blockquote class="pull-right">
		<?php echo $quote[array_rand($quote)];?>
		</blockquote>
	  </div>
	  <?php
	  		$query = "
            SELECT entry_fee,member_fee,labor_fee,house_fee,electricity_fee,airworthiness_fee,insurance_fee,casco_fee,flight_fee,debt_fee,fee_last_updated
            FROM jos_users
            LEFT JOIN jos_contxtd_details
            ON jos_users.id = jos_contxtd_details.user_id
            LEFT JOIN vak_contxtd_debt
            ON jos_contxtd_details.id = vak_contxtd_debt.contact_id
            WHERE
                jos_users.id = :username";
        
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
        
	  
	  ?>
	  <div class="col-xs-6 col-md-4"><div class="jumbotron"><h2>Likutis: <?php echo $balance; ?> Lt</h2></div></div>
	</div>	
    </div> <!-- /container -->

<?php include "templates/include/footer.php" ?>