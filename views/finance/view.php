<div class="page-header"><h1><?php echo $results['finance']->user->name ?> mokesčiai</h1></div>

<div class="row">
  <div class="col-md-8">
    <?php echo theme('display_money', 'flight_fee', 'Skrydžiai', $results['finance']) ?>
    <?php echo theme('display_money', 'member_fee', 'Nario mokestis', $results['finance']) ?>
    <?php echo theme('display_money', 'labor_fee', 'Darbų/talkos mokestis', $results['finance']) ?>
    <?php echo theme('display_money', 'house_fee', 'Patalpų mokestis', $results['finance']) ?>
    <?php echo theme('display_money', 'electricity_fee', 'Elektros mokestis', $results['finance']) ?>
    <?php echo theme('display_money', 'insurance_fee', 'Draudimas', $results['finance']) ?>
    <?php echo theme('display_money', 'casco_fee', 'Kasko mokestis', $results['finance']) ?>
    <?php echo theme('display_money', 'debt_fee', 'Už 2%', $results['finance']) ?>
    <?php echo theme('display', 'fee_notes', 'Komentarai', $results['finance']) ?>
  </div>

  <div class="col-md-4">

    <div class="panel panel-default">
      <div class="panel-heading">
	<h3 class="panel-title">Info</h3>
      </div>
      <div class="panel-body">
	<p>Čia yra talpinama mokesčių informacija.</p>

<?php if (UserHelper::has_permission()) { ?>
        <div class="buttons">
 	    <a class="btn btn-xs btn-primary" href="index.php?action=finance&amp;view=Edit&amp;id=<?php echo $results['finance']->user->id ?>">Redaguoti</a>
	</div>
<?php } ?>
      </div>
    </div>
  </div>
</div>
