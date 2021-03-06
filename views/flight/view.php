<?php
$payer = NULL;
if (isset($results['flight']->payer)) {
  require_once dirname(__FILE__) . '/../../models/user.inc';
  $payer = User::Get($results['flight']->payer);
}
$instructor = NULL;
if (isset($results['flight']->instructor)) {
  require_once dirname(__FILE__) . '/../../models/user.inc';
  $instructor = User::Get($results['flight']->instructor);
}
$service = NULL;
if (isset($results['flight']->service_id)) {
  require_once dirname(__FILE__) . '/../../models/service.inc';
  $service = Service::getById($results['flight']->service_id);
}
$airplane = NULL;
if (isset($results['flight']->airplane_id)) {
  require_once dirname(__FILE__) . '/../../models/aircraft.inc';
  $airplane = Aircraft::getById($results['flight']->airplane_id);
}
?>

<div class="page-header"><h1>Skrydis</h1></div>
<div class="row">
  <div class="col-md-8">
    <?php echo theme('display', 'date', 'Data', $results['flight']) ?>
    <?php echo theme('display', 'name', 'Orlaivis', $airplane, array('name' => $airplane->name . ' (' . $airplane->reg_num . ')')) ?>
    <?php echo theme('display', 'title', 'Skrydis', $service) ?>
    <?php echo theme('display', 'name', 'Instruktorius', $instructor) ?>
    <?php echo theme('display', 'name', 'Pilotas', $payer) ?>
    <?php //echo theme('display', 'task', 'Užduotis', $results['flight']) ?>
    <?php echo theme('display_time', 'time', 'Trukmė', $results['flight'], array('time' => !empty($results['flight']->duration) ? floatval($results['flight']->duration) : NULL)) ?>
    <?php echo theme('display', 'amount', 'Kiekis', $results['flight']) ?>
<?php if (!empty($service->unit)) { ?>
    <?php echo theme('display', 'amount_unit', 'Papildomai mokėta už <span class="service_unit" style="">' . $service->unit . '</span>', $results['flight']) ?>
<?php } ?>
    <?php echo theme('display_money', 'price', 'Suma', $results['flight']) ?>
<? if (!empty($instructor)) { ?>
    <?php echo theme('display_money', 'price_instructor', 'Instruktoriui', $results['flight']) ?>
<?php } ?>
    <?php echo theme('display', 'comments', 'Komentarai', $results['flight']) ?>
    <br />
  </div>

  <div class="col-md-4">

    <div class="panel panel-default">
      <div class="panel-heading">
	<h3 class="panel-title">Info</h3>
      </div>
      <div class="panel-body">
	<p>Čia yra talpinama skrydžių informacija.</p>

<?php if (UserHelper::has_permission()) { ?>
        <div class="buttons">
	  <a href="index.php?action=flight&amp;view=Edit&amp;id=<?php echo $results['flight']->record_id ?>" class="btn btn-sm btn-primary">Redaguoti</a>
	</div>
<?php } ?>
      </div>
    </div>
  </div>
</div>
