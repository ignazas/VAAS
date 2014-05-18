<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>
 	<div class="container">
 		<div class="page-header"><h1>Redaguoti pranešimą</h1></div>
		<div class="col-md-8">
	      

      <form role="form" action="admin.php?action=<?php echo $results['formAction']?>" method="post">
        <input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>"/>
 
<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
 	      	<input type="text" name="title" id="title" class="form-control input-lg" placeholder="Pavadinimas" value="<?php echo htmlspecialchars( $results['article']->title )?>"><br />
 	      	<textarea name="summary" id="summary" class="form-control" rows="3" placeholder="Sąntrauka"><?php echo $results['article']->summary ?></textarea><br />
			<textarea name="content" id="content" class="form-control" rows="15" placeholder="Pranešimas"><?php echo $results['article']->content ?></textarea><br />
			<input type="hidden" name="publicationDate" id="publicationDate" value="<?php echo date("Y-m-d");?>"><br />
        <button type="submit" name="saveChanges" class="btn btn-primary">Išsaugoti</button>
        <button type="submit" name="cancel" formnovalidate class="btn btn-primary">Atšaukti</button>

 
      </form>
 		</div>
		<?php if ( $results['article']->id ) { ?>
		<div class="col-md-4">
		    <div class="panel panel-danger">
	            <div class="panel-heading">
	              <h3 class="panel-title">Administravimas</h3>
	            </div>
	            <div class="panel-body">
	              <p><a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']->id ?>" onclick="return confirm('Ar tikrai norite pašalinti pranešimą?')">Pašalinti pranešimą.</a></p>
	            </div>
          	</div>
        </div>

      
		<?php } ?>
 </div>
<?php include "templates/include/footer.php" ?>