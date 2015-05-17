<form id="flight-add" class="form-horizontal" action="" method="POST">
  <fieldset>

    <!-- Form Name -->
    <legend>Įtraukti skrydį</legend>

    <table class="table">
      <thead>
	<tr>
	  <th class="date">Data</th>
	  <th class="service">Paslauga</th>
	  <th class="user student">Pilotas/Pratimas</th>
	  <th class="user instructor">Instruktorius</th>
	  <th class="glider">Orlaivis</th>
	  <th class="quantity">Kiekis/Laikas</th>
	  <th class="price">Kaina, Lt</th>
	  <th></th>
	</tr>
      </thead>
      <tbody>
      </tbody>
    </table>

    <label class="control-label" for="singlebutton"></label>
	<button id="submit" name="saveChanges" name="saveChanges" class="btn btn-primary">Įtraukti</button>
	<a href="#" class="add" class="btn">Pridėti eilutę</a>
    </div>
  </fieldset>
</form>

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
    , time: '<?php echo isset($_POST['time'][$key]) ? $_POST['time'][$key] : NULL ?>'
    , price: '<?php echo isset($_POST['price'][$key]) ? $_POST['price'][$key] : NULL ?>'
  });

<?php } ?>
  //add row if there is none
  if ($('form#flight-add').length && !window.flightEntity.rows($('form#flight-add')).length)
    window.flightEntity.addRow($('form#flight-add'));
});
</script>
