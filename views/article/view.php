    <?php IF(isset($_GET['edit'])) { ?>
    	
    <?php } elseif(isset($_GET['insert'])) {?>
    	<div class="page-header"><h1>Rašyti pranešimą</h1></div>
		<div class="col-md-8">
	      <form role="form" action="?action=singleNews&insert=1" method="post">
	      	<input type="text" class="form-control input-lg" placeholder="Pavadinimas" /><br />
			<textarea class="form-control" rows="15" placeholder="Pranešimas"></textarea><br />
			<button type="submit" class="btn btn-primary">Paskelbti</button>
	      </form>
      	</div>
    <?php } else {?>
	<div class="page-header"><h1>Pranešimai</h1></div>
      <div class="col-md-8">
	      <h2 style="width: 75%;"><?php echo htmlspecialchars( $results['article']->title )?></h2>
	      <p class="pubDate">Paskelbta <i><?php echo date('Y-m-d', $results['article']->publicationDate)?></i></p>
	      <?php echo $results['article']->content ?>
      </div>
      
    <?php } ?>
      <div class="col-md-4">

		    <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Info</h3>
            </div>
            <div class="panel-body">
              <p>Čia yra talpinama visa vidinė informacija klubo nariams.</p>
              <p>Visi šie pranešimai buvo automatiškai išsiųsti nariams el. paštu.</p>
            </div>
          </div>
        </div>
