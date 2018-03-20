<?php $finance = $results['finance']; $balance = (intval($finance->entry_fee)+intval($finance->member_fee)+intval($finance->labor_fee)+intval($finance->house_fee)+intval($finance->electricity_fee)+intval($finance->airworthiness_fee)+intval($finance->insurance_fee)+intval($finance->casco_fee)+intval($finance->flight_fee)+intval($finance->debt_fee)); ?>

<div class="page-header"><h1><?php echo $results['finance']->user->name ?> mokesčiai</h1></div>

<div class="row">
  <div class="col-md-8">
    <?php echo theme('display_money', 'balance', 'Likutis', (object)array('balance' => $balance, 'date' => !empty($results['finance']->date) ? $results['finance']->date : NULL)) ?>
    <?php echo theme('display_money', 'flight_fee', 'Skrydžiai', $results['finance']) ?>
    <?php echo theme('display_money', 'member_fee', 'Nario mokestis', $results['finance']) ?>
    <?php echo theme('display_money', 'house_fee', 'Namelis', $results['finance']) ?>
    <?php echo theme('display_money', 'electricity_fee', 'Elektra', $results['finance']) ?>
    <?php echo theme('display_money', 'insurance_fee', 'Draudimas', $results['finance']) ?>
    <!--<?php echo theme('display_money', 'casco_fee', 'Kasko mokestis', $results['finance']) ?>-->
    <?php echo theme('display_money', 'debt_fee', 'Už 2%', $results['finance']) ?>
    <?php echo theme('display_money', 'labor_fee', 'Darbai', $results['finance']) ?>
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

<?php if (!empty($results['journal'])) { ?>
<div class="row">
  <div class="col-md-12">
    <h2>Mokėjimai</h2>
    <table class="table table-striped">
      <thead>
	<tr>
    <th>Likutis</th>
	  <th>Skrydžiai</th>
	  <th>Nario mokestis</th>
	  <th>Namelis</th>
	  <th>Elektra</th>
	  <th>Draudimas</th>
	  <!-- <th>Kasko mokestis</th> -->
	  <th>Už 2%</th>
	  <th>Darbai</th>
	  <th>Komentarai</th>
	  <th>Data</th>
	</tr>
      </thead>
      <tbody>
<?php  foreach ($results['journal'] as $r) { $r['date'] = $r['fee_updated']; $row = (object)$r; ?>
    <?php $finance = $row; $balance = (intval($finance->entry_fee)+intval($finance->member_fee)+intval($finance->labor_fee)+intval($finance->house_fee)+intval($finance->electricity_fee)+intval($finance->airworthiness_fee)+intval($finance->insurance_fee)+intval($finance->casco_fee)+intval($finance->flight_fee)+intval($finance->debt_fee)); ?>
        <tr>
	  <td title="Likutis" class="<?php echo empty($balance) ? 'warning' : ($balance < 0 ? 'danger' : 'success') ?>">
	    <?php echo theme('display_money', 'balance', NULL, (object)array('balance' => $balance, 'date' => $finance->date)) ?>
	  </td>
	  <td><?php echo theme('display_money', 'flight_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'member_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'house_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'electricity_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'insurance_fee', NULL, $row) ?></td>
	  <!-- <td><?php echo theme('display_money', 'casco_fee', NULL, $row) ?></td> -->
	  <td><?php echo theme('display_money', 'debt_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'labor_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display', 'fee_notes', NULL, $row) ?></td>
	  <td><?php echo theme('display', 'fee_updated', NULL, $row) ?></td>
        </tr>
<?php  } ?>
      </tbody>
    </table>
  </div>
</div>
<?php } ?>
