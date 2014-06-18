<div class="page-header"><h1>Skrydis</h1></div>
<div class="row">
  <div class="col-md-8">
    <?php echo theme('display', 'date', 'Data', $results['flight']) ?>
    <?php echo theme('display', 'callsign', 'Orlaivis', $results['flight']) ?>
    <?php echo theme('display', 'pilot', 'Pilotas', $results['flight']) ?>
    <?php echo theme('display', 'passenger', 'Keleivis', $results['flight']) ?>
    <?php echo theme('display', 'task', 'Užduotis', $results['flight']) ?>
    <?php echo theme('display', 'amount', 'Kiekis', $results['flight']) ?>
    <?php echo theme('display', 'duration', 'Trukmė', $results['flight']) ?>
    <br />
  </div>

  <div class="col-md-4">

    <div class="panel panel-default">
      <div class="panel-heading">
	<h3 class="panel-title">Info</h3>
      </div>
      <div class="panel-body">
	<p>Čia yra talpinama skrydžių informacija.</p>
      </div>
    </div>
  </div>
</div>
