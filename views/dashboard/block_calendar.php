  <link href="css/cal.css" rel="stylesheet" type="text/css">

<div class="row">

<div class="col-md-6 flight-plan">
  <h2>Šiandien skrenda</h2>
  <?php $today = time(); ?>
  <ul class="list-group">
	<?php if (!empty($elements['calendar-today']['events']['results'])) { ?>
    <?php foreach ($elements['calendar-today']['events']['results'] as $event) { ?>
    <li class="list-group-item">
      <a class="<?php echo $event->event_type ?>" href="?id=<?php echo $event->event_id ?>" title="<?php echo $event->event_title ?>">
        <?php echo $event->event_time ?>
        <?php echo $event->event_type != 'registracija' ? $event->event_desc : $event->event_title ?>
<?php if (!empty($event->user->avatar)) { ?>
        <img src="<?php echo (CATALOG != '' ? '/' . CATALOG : NULL) . '/uploads/users/' . $event->user->avatar ?>" class="img-rounded" style="height:22px;" alt="<?php echo /*htmlentities*/($event->user->name) ?>">
<?php } ?>
	<?php if ($event->event_type == 'registracija') { ?>
	<em title="<?php echo $event->event_desc ?>"><?php echo $event->event_desc ?></em>
        <?php } ?>
      </a>
<?php if ($event->event_type != 'registracija') { ?>
        <span class="badge"><?php echo $event->event_type ?></span>
<?php } ?>
    </li>
    <?php } } else { echo "<li class=\"list-group-item\">Registracijų nėra.</li>";} ?>
	<?php IF (!empty($elements['calendar-today']['days']['results'])) { ?>
    <?php foreach ($elements['calendar-today']['days']['results'] as $day) { ?>
    <li class="list-group-item <?php echo $day->status ?> list-group-item-<?php echo $day->status == 'nevyksta' ? 'danger' : 'info' ?>"><?php echo $day->reason ?></li>
    <?php } } ?>
  </ul>
  <div class="buttons">
    <a class="add btn btn-sm btn-primary" href="?day=<?php echo date('j', $today) ?>&amp;month=<?php echo date('n', $today) ?>&amp;year=<?php echo date('Y', $today) ?>&amp;destination=<?php echo $_SERVER['REQUEST_URI'] ?>"><i class="glyphicon glyphicon-plus"></i> Šiandien</a>
    <?php $bookingIdList = array(); if (!empty($elements['calendar-today']['events']['results'])) foreach ($elements['calendar-today']['events']['results'] as $event) if (!empty($_SESSION['user']['id']) && $event->user_id == $_SESSION['user']['id']) $bookingIdList[] = $event->event_id; ?>
    <?php if (!empty($bookingIdList)) { ?>
    <a class="delete btn btn-danger" onclick="return confirm('Ar tikrai norite atsisakyti registracijos?')" href="index.php?action=deleteBooking&amp;bookingId=<?php echo implode(',', $bookingIdList) ?>&amp;destination=<?php echo $_SERVER['REQUEST_URI'] ?>"><i class="glyphicon glyphicon-minus"></i> Atsisakyti</a>
    <?php } ?>
  </div>
</div>

<div class="col-md-6 flight-plan">
  <h2>Rytoj skris</h2>
  <ul class="list-group">
	<?php if (!empty($elements['calendar-tomorrow']['events']['results'])) { ?>
    <?php foreach ($elements['calendar-tomorrow']['events']['results'] as $event) { $title = $event->event_time . ' ' . ($event->event_type != 'registracija' ? $event->event_desc : $event->event_title); ?>
    <li class="list-group-item">
      <a class="<?php echo $event->event_type ?>" href="?id=<?php echo $event->event_id ?>" title="<?php echo $title ?>">
        <?php echo $event->event_time ?>
        <?php echo $event->event_type != 'registracija' ? $event->event_desc : $event->event_title ?>
<?php if (!empty($event->user->avatar)) { ?>
        <img src="<?php echo (CATALOG != '' ? '/' . CATALOG : NULL) . '/uploads/users/' . $event->user->avatar ?>" class="img-rounded" style="height:22px;" alt="<?php echo /*htmlentities*/($event->user->name) ?>">
	<?php } ?>
	<?php if ($event->event_type == 'registracija') { ?>
	<em title="<?php echo $event->event_desc ?>"><?php echo $event->event_desc ?></em>
        <?php } ?>
      </a>
    </li>
    <?php } } else { echo "<li class=\"list-group-item\">Registracijų nėra.</li>";} ?>
	<?php IF (!empty($elements['calendar-tomorrow']['days']['results'])) { ?>
    <?php foreach ($elements['calendar-tomorrow']['days']['results'] as $day) { ?>
    <li class="list-group-item <?php echo $day->status ?> list-group-item-<?php echo $day->status == 'nevyksta' ? 'danger' : 'info' ?>"><?php echo $day->reason ?></li>
    <?php } } ?>
  </ul>
  <div class="buttons">
    <?php $tomorrow = $today + 86400; ?>
    <a class="add btn btn-sm btn-primary" href="?day=<?php echo date('j', $tomorrow) ?>&amp;month=<?php echo date('n', $tomorrow) ?>&amp;year=<?php echo date('Y', $tomorrow) ?>&amp;destination=<?php echo $_SERVER['REQUEST_URI'] ?>"><i class="glyphicon glyphicon-plus"></i> Rytoj</a>
    <?php $bookingIdList = array(); if (!empty($elements['calendar-tomorrow']['events']['results'])) foreach ($elements['calendar-tomorrow']['events']['results'] as $event) if (!empty($_SESSION['user']['id']) && $event->user_id == $_SESSION['user']['id']) $bookingIdList[] = $event->event_id; ?>
    <?php if (!empty($bookingIdList)) { ?>
    <a class="delete btn btn-danger" onclick="return confirm('Ar tikrai norite atsisakyti registracijos?')" href="index.php?action=deleteBooking&amp;bookingId=<?php echo implode(',', $bookingIdList) ?>&amp;destination=<?php echo $_SERVER['REQUEST_URI'] ?>"><i class="glyphicon glyphicon-minus"></i> Atsisakyti</a>
    <?php } ?>
  </div>
</div>

</div>

<div id="registracija"></div>
<div id="registruotis"></div>
