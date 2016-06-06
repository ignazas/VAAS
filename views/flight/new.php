<?php if (!empty($results['flights']['results'])) { ?>
<div class="col-md-12">
  <label><?php echo $results['date'] ?> dienos įrašų: <?php echo $results['flights']['totalRows'] ?></label>
  <table class="table table-striped">
    <thead>
      <tr>
	<th style="width:90px;">Data</th>
	<th>Orlaivis</th>
	<th>Skrydis</th>
	<th>Pilotas</th>
	<th>Instruktorius</th>
	<th>Kiekis /
	    Trukmė</th>
	<th>Nuskaityta</th>
<?php   if ($this->HasPermission('Flight Manager')) { ?>
	<th>Instruktoriui</th>
<?php   } ?>
      </tr>
    </thead>
    <tbody>
<?php foreach ( $results['flights']['results'] as $flight) { ?>
      <tr>
	<td>
	  <?php echo theme('display', 'date', NULL, $flight) ?>
	</td>
	<td>
	  <?php echo !empty($results['airplanes'][$flight->airplane_id]) ? ($results['airplanes'][$flight->airplane_id]->name . ' (' . $results['airplanes'][$flight->airplane_id]->reg_num . ')') : NULL ?>
	</td>
	<td>
	  <?php echo !empty($results['services'][$flight->service_id]) ? $results['services'][$flight->service_id]->title : NULL ?>
	</td>
	<td>
	  <?php echo !empty($results['users'][$flight->payer]) ? $results['users'][$flight->payer]->name : NULL ?>
	</td>
	<td>
	  <?php echo !empty($results['users'][$flight->instructor]) ? $results['users'][$flight->instructor]->name : NULL ?>
	</td>
	<td>
	  <?php echo theme('display', 'amount_time', NULL, $flight, array('amount_time' => $flight->amount . (!empty($flight->duration) ? (' / ' . DateHelper::time_as_string(floatval($flight->duration))) : NULL))) ?>
	</td>
	<td>
	  <?php echo theme('display_money', 'price', NULL, $flight) ?>
	</td>
<?php   if ($this->HasPermission('Flight Manager')) { ?>
	<td>
<?php     if (!empty($flight->price_instructor)) { ?>
	  <?php echo theme('display_money', 'price_instructor', NULL, $flight) ?>
<?php     } ?>
	</td>
<?php   } ?>
      </tr>
<?php } ?>
    </tbody>
  </table>
</div>
<?php } ?>

<div class="col-md-12">
  <form id="flight-add" class="form-horizontal" action="" method="POST">
    <fieldset>

      <!-- Form Name -->
      <legend>Įtraukti skrydį</legend>

      <table class="table table-bordered table-hover">
	<thead>
	  <tr>
	    <th class="date" rowspan="2">Data</th>
	    <th class="service" rowspan="2">Skrydis</th>
	    <th class="user student">Pilotas</th>
	    <th class="glider" colspan="2">Orlaivis</th>
	    <th class="price">Kaina,&#160;€</th>
	  </tr>
	  <tr>
	    <!-- <th class="service">Pratimas</th> -->
	    <th class="instructor">Instruktorius</th>
	    <th class="quantity">Kiekis</th>
	    <th class="time">Laikas</th>
	    <th class="actions"></th>
	  </tr>
	</thead>
	<tbody>
	</tbody>
      </table>

      <label class="control-label" for="singlebutton"></label>
      <button id="submit" name="saveChanges" name="saveChanges" class="btn btn-primary">Saugoti</button>
      <a href="#" class="add" class="btn">Pridėti eilutę</a>
    </fieldset>
  </form>
</div>

<script language="javascript">
jQuery(document).ready(function($) {
<?php if (!empty($_POST['date'])) foreach ($_POST['date'] as $key => $value) { ?>
  window.flightEntity.addRow($('form#flight-add'), {
    date: '<?php echo isset($_POST['date'][$key]) ? $_POST['date'][$key] : NULL ?>'
    , service_id: '<?php echo isset($_POST['service_id'][$key]) ? $_POST['service_id'][$key] : NULL ?>'
    , payer: '<?php echo isset($_POST['payer'][$key]) ? $_POST['payer'][$key] : NULL ?>'
    , practice: '<?php echo isset($_POST['practice'][$key]) ? $_POST['practice'][$key] : NULL ?>'
    , instructor: '<?php echo isset($_POST['instructor'][$key]) ? $_POST['instructor'][$key] : NULL ?>'
    , airplane_id: '<?php echo isset($_POST['airplane_id'][$key]) ? $_POST['airplane_id'][$key] : NULL ?>'
    , amount: '<?php echo isset($_POST['amount'][$key]) ? $_POST['amount'][$key] : NULL ?>'
    , amount_unit: '<?php echo isset($_POST['amount_unit'][$key]) ? $_POST['amount_unit'][$key] : NULL ?>'
    , time: '<?php echo isset($_POST['time'][$key]) ? $_POST['time'][$key] : NULL ?>'
    , price: '<?php echo isset($_POST['price'][$key]) ? $_POST['price'][$key] : NULL ?>'
  });

<?php } ?>
  //add row if there is none
  if ($('form#flight-add').length && !window.flightEntity.rows($('form#flight-add')).length)
    window.flightEntity.addRow($('form#flight-add'));
});
</script>

