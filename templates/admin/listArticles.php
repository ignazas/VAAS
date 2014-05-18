<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>
 
      <div class="container">
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
			<form action="admin.php">
          		<input type="hidden" name="articleId" value="<?php echo $article->id ?>"/>
 				<button type="submit" name="action" class="btn btn-xs btn-default" value="editArticle">Redaguoti</button>
			</form>
          </td>
          <td>
          	<form action="admin.php">
          		<input type="hidden" name="articleId" value="<?php echo $article->id ?>"/>
 				<button type="submit" name="action" onclick="return confirm('Ar tikrai norite pašalinti pranešimą?')" class="btn btn-xs btn-danger" value="deleteArticle">Pašalinti</button>
			</form>
          </td>
          
        </tr>
 
<?php } ?>
 
      </table>
 	<br />
 	<form action="admin.php">
 		<button type="submit" name="action" class="btn btn-sm btn-primary" value="newArticle">Kurti naują pranešimą</button>
	</form>
 	</div>
 </div> <!-- /container -->
 
<?php include "templates/include/footer.php" ?>