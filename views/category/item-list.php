<div class="page-header"><h1>Kategorijos</h1></div>

<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Filtrai</h3>
    </div>
    <div class="panel-body">
      <div id="addDay">
	<form role="form" method="get" action="" class="col-xs-12 form-horizontal">
	  <input type="hidden" name="action" value="category" />
	  <input type="hidden" name="view" value="ItemList" />
	  <div class="form-group">
	    <label for="status" class="col-sm-3 control-label">Paieška</label>
	    <div class="col-sm-9">
	      <input type="text" name="search" class="form-control" value="<?php echo !empty($_GET['search']) ? $_GET['search'] : NULL ?>" />
            </div>
          </div>
          <div class="form-group">
	    <div class="col-sm-offset-3 col-sm-9">
	      <button type="submit" class="btn btn-primary">Filtruoti</button>
	    </div>
	  </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="col-md-12">
  <label>Įrašų: <?php echo $results['totalRows'] ?></label>
  <table class="table table-striped">
    <thead>
      <tr>
	<th>Pavadinimas</th>
	<th>Aprasymas</th>
	<th style="width:20px">Rikiavimas</th>
<?php if ($this->HasPermission()) { ?>
	<th style="width:60px;"></th>
	<th style="width:69px;"></th>
<?php } ?>
      </tr>
    </thead>
	<tbody>
<?php foreach ( $results['categorys'] as $category) { ?>
      <tr>
	<td>
	  <a href="admin.php?action=category&amp;view=View&amp;id=<?php echo $category->id ?>">
	    <?php echo theme('display', 'title', NULL, $category) ?>
	    <?php echo empty($category->title) ? '---' : NULL ?>
	  </a>
	</td>
	<td>
	  <?php echo theme('display', 'description', NULL, $category) ?>
	</td>
	<td>
	  <?php echo theme('display', 'ordering', NULL, $category) ?>
	</td>
<?php if ($this->HasPermission()) { ?>
	<td>
 	  <a class="btn btn-xs btn-default" href="admin.php?action=category&amp;view=Edit&amp;id=<?php echo $category->id ?>">Redaguoti</a>
	</td>
	<td>
 	  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti kategorija <?php echo $category->title ?>?')" href="admin.php?action=category&amp;view=Delete&amp;id=<?php echo $category->id ?>">Pašalinti</a>
	</td>
<?php } ?>
      </tr>
<?php } ?>
	</tbody>
  </table>
<?php if (UserHelper::has_permission()) { ?>
  <br />
  <div class="buttons">
    <a class="btn btn-sm btn-primary" href="index.php?action=category&amp;view=NewItem">Kurti naują kategorją</a>
  </div>
<?php } ?>
</div>
