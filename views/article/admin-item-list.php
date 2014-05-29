		<div class="page-header"><h1>Pranešimų administravimas</h1></div>
  		<div class="col-md-8">
<?php if ( isset( $results['errorMessage'] ) ) { ?>
	<div class="alert alert-danger">
        <strong>Klaida!</strong> <?php echo $results['errorMessage'] ?>
      </div>
<?php } ?>


<?php if ( isset( $results['statusMessage'] ) ) { ?>
		<div class="alert alert-success">
        <strong>Atlikta!</strong> <?php echo $results['statusMessage'] ?>
      </div>
<?php } ?>

      <table>
        <tr>
          <th style="width:100px">Data</th>
          <th style="width:350px">Pranešimas</th>
          <th></th>
          <th></th>
        </tr>

<?php foreach ( $results['articles'] as $article ) { ?>

        <tr >
          <td><?php echo date('Y-m-d', $article->publicationDate)?></td>
          <td>
            <?php echo $article->title?>
          </td>
          <td>
 	    <a class="btn btn-xs btn-default" href="index.php?action=article&amp;view=Edit&amp;articleId=<?php echo $article->id ?>">Redaguoti</button>
          </td>
          <td>
 	    <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti pranešimą?')" href="index.php?action=article&amp;view=Delete&amp;articleId=<?php echo $article->id ?>">Pašalinti</button>
          </td>

        </tr>

<?php } ?>

      </table>
 	<br />
 	<a class="btn btn-sm btn-primary" href="index.php?action=article&amp;view=NewItem">Kurti naują pranešimą</a>
 	</div>
