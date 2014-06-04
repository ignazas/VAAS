

<div class="col-md-6" id="dienos">
  <link href="css/cal.css" rel="stylesheet" type="text/css">
  <div id="registracija"></div>
  <div id="registruotis"></div>
  <h2>Šiandien skrenda</h2>
  <ul class="list-group">
	<?php if (!empty($elements['calendar']['events']['results'])) { ?>
    <?php foreach ($elements['calendar']['events']['results'] as $event) { $title = $event->event_time . ' ' . ($event->event_type != 'registracija' ? $event->event_desc : $event->event_title); ?>
    <li class="list-group-item">
      <a class="<?php echo $event->event_type ?>" href="?id=<?php echo $event->event_id ?>" title="<?php echo $title ?>"><?php echo $title ?></a>
<?php if ($event->event_type != 'registracija') { ?>
      <span class="badge"><?php echo $event->event_type ?></span>
<?php } ?>
    </li>
    <?php } } else { echo "<li class=\"list-group-item\">Registracijų nėra.</li>";} ?>
	<?php IF (!empty($elements['calendar']['days']['results'])) { ?>
    <?php foreach ($elements['calendar']['days']['results'] as $day) { ?>
    <li class="<?php echo $day->status ?> alert <?php echo $day->status == 'nevyksta' ? 'alert-danger' : 'alert-info' ?>"><?php echo $day->reason ?></li>
    <?php } } ?>
  </ul>
  <div class="buttons">
    <a class="add btn btn-sm btn-primary" href="?day=<?php echo date('j', time()) ?>&amp;month=<?php echo date('n', time()) ?>&amp;year=<?php echo date('Y', time()) ?>&amp;destination=<?php echo $_SERVER['REQUEST_URI'] ?>"><i class="glyphicon glyphicon-plus"></i> Šiandien</a>
    <?php $bookingIdList = array(); if (!empty($elements['calendar']['events']['results'])) foreach ($elements['calendar']['events']['results'] as $event) if (!empty($_SESSION['user']['id']) && $event->user_id == $_SESSION['user']['id']) $bookingIdList[] = $event->event_id; ?>
    <?php if (!empty($bookingIdList)) { ?>
    <a class="delete btn btn-danger" onclick="return confirm('Ar tikrai norite atsisakyti registracijos?')" href="index.php?action=deleteBooking&amp;bookingId=<?php echo implode(',', $bookingIdList) ?>&amp;destination=<?php echo $_SERVER['REQUEST_URI'] ?>"><i class="glyphicon glyphicon-minus"></i> Atsisakyti</a>
    <?php } ?>
  </div>
</div>
