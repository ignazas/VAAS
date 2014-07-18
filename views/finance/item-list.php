<div class="page-header"><h1>Skrydžių redagavimas</h1></div>
<div class="col-md-12">
  <table class="table table-striped">
    <thead>
      <tr>
	<th rowspan="2">#</th>
	<th rowspan="2">Narys</th>
	<th colspan="8">Mokesčiai</th>
	<th rowspan="2">Likutis</th>
	<th rowspan="2">Komentarai</th>
	<th rowspan="2">Atnaujinta</th>
<?php if ($this->HasPermission()) { ?>
	<th rowspan="2"></th>
<?php } ?>
      </tr>
      <tr>
	<th>Nario</th>
	<th>Darbų/talkos</th>
	<th>Patalpų</th>
	<th>Elektros</th>
	<th>Draudimas</th>
	<th>Kasko</th>
	<th>Skrydžių</th>
	<th>Už 2 %</th>
      </tr>
    </thead>
    <tbody>
<?php foreach ( $results['finances'] as $finance) { ?>
      <tr>
	<td>
	  <a href="admin.php?action=finance&amp;view=View&amp;id=<?php echo $finance->contact_id ?>"><?php echo $finance->contact_id ?></a>
	</td>
	<td>
	  <a href="index.php?action=user&amp;id=<?php echo $finance->user->id ?>"><?php echo $finance->user->name ?></a>
	</td>
	<td>
	  <?php echo $finance->member_fee ?>
	</td>
	<td>
	  <?php echo $finance->labor_fee ?>
	</td>
	<td>
	  <?php echo $finance->house_fee ?>
	</td>
	<td>
	  <?php echo $finance->electricity_fee ?>
	</td>
	<td>
	  <?php echo $finance->insurance_fee ?>
	</td>
	<td>
	  <?php echo $finance->casco_fee ?>
	</td>
	<td>
	  <?php echo $finance->flight_fee ?>
	</td>
	<td>
	  <?php echo $finance->debt_fee ?>
	</td>
	<td>
	  <?php echo (intval($finance->entry_fee)+intval($finance->member_fee)+intval($finance->labor_fee)+intval($finance->house_fee)+intval($finance->electricity_fee)+intval($finance->airworthiness_fee)+intval($finance->insurance_fee)+intval($finance->casco_fee)+intval($finance->flight_fee)+intval($finance->debt_fee)) ?>
	</td>
	<td>
 	  <?php echo $finance->fee_notes ?>
	</td>
	<td>
 	  <?php echo $finance->fee_last_updated ?>
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
