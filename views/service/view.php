<div class="page-header"><h1>Paslauga</h1></div>

<div class="row">
  <div class="col-md-8">
    <?php echo theme('display', 'title', 'Pavadinimas', $results['service']) ?>
    <?php echo theme('display', 'amount', 'Kaina, Lt', $results['service']) ?>
    <?php echo theme('display', 'discount_disabled', 'Nuolaidos netaikomos', $results['service']) ?>
    <?php echo theme('display', 'description', 'Aprašymas', $results['service']) ?>
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
