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
    <?php $finance = $results['finance']; $balance = (intval($finance->entry_fee)+intval($finance->member_fee)+intval($finance->labor_fee)+intval($finance->house_fee)+intval($finance->electricity_fee)+intval($finance->airworthiness_fee)+intval($finance->insurance_fee)+intval($finance->casco_fee)+intval($finance->flight_fee)+intval($finance->debt_fee)); ?>
    <?php echo theme('display', 'balance', 'Balansas', (object)array('balance' => $balance)) ?>
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

<?php if (!empty($results['journal'])) { ?>
<div class="row">
  <div class="col-md-12">
    <h2>Mokėjimai</h2>
    <table class="table table-striped">
      <thead>
	<tr>
	  <th>Skrydžiai</th>
	  <th>Nario mokestis</th>
	  <th>Darbų/talkos mokestis</th>
	  <th>Patalpų mokestis</th>
	  <th>Elektros mokestis</th>
	  <th>Draudimas</th>
	  <th>Kasko mokestis</th>
	  <th>Už 2%</th>
    <th>Balansas</th>
	  <th>Komentarai</th>
	  <th>Data</th>
	</tr>
      </thead>
      <tbody>
<?php  foreach ($results['journal'] as $r) { $row = (object)$r; ?>
        <tr>
	  <td><?php echo theme('display_money', 'flight_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'member_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'labor_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'house_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'electricity_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'insurance_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'casco_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'debt_fee', NULL, $row) ?></td>
    <?php $finance = $row; $balance = (intval($finance->entry_fee)+intval($finance->member_fee)+intval($finance->labor_fee)+intval($finance->house_fee)+intval($finance->electricity_fee)+intval($finance->airworthiness_fee)+intval($finance->insurance_fee)+intval($finance->casco_fee)+intval($finance->flight_fee)+intval($finance->debt_fee)); ?>
    <td><?php echo theme('display', 'balance', NULL, (object)array('balance' => $balance)) ?></td>
	  <td><?php echo theme('display', 'fee_notes', NULL, $row) ?></td>
	  <td><?php echo theme('display', 'fee_updated', NULL, $row) ?></td>
        </tr>
<?php  } ?>
      </tbody>
    </table>
  </div>
</div>
<?php } ?>
