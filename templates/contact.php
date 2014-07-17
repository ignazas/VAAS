<?php
require_once dirname(__FILE__) . '/../helpers/user.inc';
UserHelper::check_access();

include "templates/include/header.php";
include "templates/include/top-menu.php";
?>

<div class="container">
	<div class="page-header"><h1>Kontaktai</h1></div>

		<div class="col-md-8">
			<div class="col-md-6">
			<h3>Vadovybė</h3>
				Dalia Vainienė<br />
				aeroklubas@sklandymas.lt
			</div>
			<div class="col-md-6">
			<h3>Rekvizitai</h3>
			 	Įmonės kodas: 193077337<br />
				Adresas: J. Basanavičiaus g. 16 / 5, LT-03224 Vilnius<br />
				Banko sąskaita: LT757300010002448926<br />
				Tinklalapis: http://www.sklandymas.lt<br />
			</div>
			<div class="col-md-8">
			<h3>VAAS priežiūra</h3>
			Ignas, +370 614 36408, ignas@igfe.eu
			</div>
		</div>


      <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Info</h3>
            </div>
            <div class="panel-body">
              <p>Jei kyla nesklandumai naudojantis sistema ar nėra reikiamos informacijos - kreipkitės nurodytais kontaktais.</p>
            </div>
          </div>
        </div>


    </div> <!-- /container -->



<?php include "templates/include/footer.php" ?>