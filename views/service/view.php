<div class="page-header"><h1>Paslauga</h1></div>

<div class="row">
  <div class="col-md-8">
    <?php echo theme('display_checkbox', 'is_flight', 'Ar skrydis', $results['service']) ?>
    <?php echo theme('display', 'title', 'Pavadinimas', $results['service']) ?>
    <?php echo theme('display', 'amount', 'Kaina, €', $results['service']) ?>
<?php if (!empty($results['service']->amount_unit)) { ?>
    <?php echo theme('display', 'amount_unit_title', 'Papildoma kaina už vienetą', $results['service'], array('amount_unit_title' => $results['service']->amount_unit . '€/' . $results['service']->unit )) ?>
<?php } ?>
    <?php echo theme('display_checkbox', 'is_price_for_duration', 'Ar kaina už skrydžio laiką', $results['service']) ?>
    <?php echo theme('display_time', 'default_duration', 'Trukmė pagal nutylėjimą', $results['service'], array('default_duration' => !empty($results['service']->default_duration) ? floatval($results['service']->default_duration) : NULL)) ?>
    <?php echo theme('display', 'price_for_instructor', 'Mokestis instruktoriui, €', $results['service']) ?>
    <?php echo theme('display', 'description', 'Aprašymas', $results['service']) ?>
    <?php echo theme('display_checkbox', 'is_discount', 'Antkainis taikomas', $results['service']) ?>
    <br />
  </div>

  <div class="col-md-4">

    <div class="panel panel-default">
      <div class="panel-heading">
	<h3 class="panel-title">Info</h3>
      </div>
      <div class="panel-body">
	<p>Čia yra talpinama kainų informacija.</p>
      </div>
    </div>
  </div>
</div>

<?php if (UserHelper::has_permission()) { ?>
<div class="buttons">
  <a class="btn btn-sm btn-primary" href="index.php?action=service&amp;view=Edit&amp;id=<?php echo $results['service']->id ?>">Redaguoti</a>
<?php  if (UserHelper::has_permission()) { ?>
  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti įrašą <?php echo $results['service']->title ?>?')" href="index.php?action=service&amp;view=Delete&amp;id=<?php echo $results['service']->id ?>">Pašalinti</a>
<?php  } ?>
</div>
<?php } ?>
