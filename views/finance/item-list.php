<div class="page-header"><h1>Skrydžių redagavimas</h1></div>
<div class="col-md-12">
  <div class="table-responsive">
    <table class="table table-striped ">
      <thead>
	<tr>
	  <th rowspan="2">#</th>
	  <th rowspan="2">Narys</th>
	  <th rowspan="2">Likutis</th>
	  <th colspan="7">Mokesčiai</th>
	  <th rowspan="2">Komentarai</th>
	  <th rowspan="2" style="width:90px;">Atnaujinta</th>
<?php if ($this->HasPermission()) { ?>
	  <th rowspan="2"></th>
<?php } ?>
	</tr>
	<tr>
	  <th>Skrydžiai</th>
	  <th>Nario</th>
	  <th>Namelis</th>
	  <th>Elektra</th>
	  <th>Draudimas</th>
	  <th>2%</th>
	  <th>Darbai</th>
	</tr>
      </thead>
      <tbody>
<?php foreach ( $results['finances'] as $finance) { ?>
<?php   $balance = (intval($finance->entry_fee)+intval($finance->member_fee)+intval($finance->labor_fee)+intval($finance->house_fee)+intval($finance->electricity_fee)+intval($finance->airworthiness_fee)+intval($finance->insurance_fee)+intval($finance->casco_fee)+intval($finance->flight_fee)+intval($finance->debt_fee)); ?>
        <tr>
	  <td>
	    <a href="admin.php?action=finance&amp;view=View&amp;id=<?php echo $finance->contact_id ?>"><?php echo $finance->contact_id ?></a>
	  </td>
	  <td>
	    <a href="index.php?action=user&amp;id=<?php echo $finance->user->id ?>"><?php echo $finance->user->name ?></a>
	  </td>
	  <td title="Likutis" class="<?php echo empty($balance) ? 'warning' : ($balance < 0 ? 'danger' : 'success') ?>">
 	    <?php echo $balance ?>
	  </td>
	  <td title="Skrydžiai">
	    <?php echo theme('display', 'flight_fee', NULL, $finance) ?>
	  </td>
	  <td title="Nario">
	    <?php echo theme('display', 'member_fee', NULL, $finance) ?>
	  </td>
	  <td title="Namelis">
	    <?php echo theme('display', 'house_fee', NULL, $finance) ?>
	  </td>
	  <td title="Elektra">
	    <?php echo theme('display', 'electricity_fee', NULL, $finance) ?>
	  </td>
	  <td title="Draudimas">
	    <?php echo theme('display', 'insurance_fee', NULL, $finance) ?>
	  </td>
	  <td title="2%">
	    <?php echo theme('display', 'debt_fee', NULL, $finance) ?>
	  </td>
	  <td title="Darbai">
	    <?php echo theme('display', 'labor_fee', NULL, $finance) ?>
	  </td>
	  <td title="Komentarai">
 	    <?php echo theme('display', 'fee_notes', NULL, $finance) ?>
	  </td>
	  <td title="Atnaujinta">
 	    <?php echo theme('display', 'fee_last_updated', NULL, $finance) ?>
	  </td>
<?php if ($this->HasPermission()) { ?>
	  <td>
 	    <a class="btn btn-xs btn-default" href="index.php?action=finance&amp;view=Edit&amp;id=<?php echo $finance->user->id ?>">Redaguoti</a>
	  </td>
<?php } ?>
	</tr>
<?php } ?>
      </tbody>
    </table>
  </div>
</div>
