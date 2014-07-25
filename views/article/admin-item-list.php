<div class="page-header"><h1>Pranešimų administravimas</h1></div>
<div class="col-md-12">
  <table class="table table-striped">
    <thead>
      <tr>
	<th style="width:100px">Data</th>
	<th>Pranešimas</th>
	<th style="width:60px;"></th>
	<th style="width:69px;"></th>
      </tr>
    </thead>

    <tbody>
<?php foreach ( $results['articles'] as $article ) { ?>
      <tr>
	<td><?php echo date('Y-m-d', $article->publicationDate)?></td>
	<td>
          <a href="index.php?action=article&amp;view=View&amp;articleId=<?php echo $article->id ?>"><?php echo $article->title?></a>
	</td>
	<td>
 	  <a class="btn btn-xs btn-default" href="index.php?action=article&amp;view=Edit&amp;articleId=<?php echo $article->id ?>">Redaguoti</a>
	</td>
	<td>
 	  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti pranešimą?')" href="index.php?action=article&amp;view=Delete&amp;articleId=<?php echo $article->id ?>">Pašalinti</a>
	</td>
      </tr>
<?php } ?>
    </tbody>

  </table>
  <br />
  <a class="btn btn-sm btn-primary" href="index.php?action=article&amp;view=NewItem">Kurti naują pranešimą</a>
</div>
