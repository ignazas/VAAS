<div class="page-header"><h1>Finansų redagavimas</h1></div>

<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Filtrai</h3>
    </div>
    <div class="panel-body">
      <div id="addDay">
	<form role="form" method="get" action="" class="col-xs-12 form-horizontal">
	  <input type="hidden" name="action" value="finance" />
	  <input type="hidden" name="view" value="ItemList" />
	  <div class="form-group">
	    <label for="status" class="col-sm-3 control-label">Paieška</label>
	    <div class="col-sm-9">
	      <input type="text" name="search" class="form-control" value="<?php echo !empty($_GET['search']) ? $_GET['search'] : NULL ?>" />
            </div>
          </div>
	  <div class="form-group">
	    <label for="status" class="col-sm-3 control-label">Būsena</label>
	    <div class="col-sm-9">
	      <select name="group" class="form-control">
		<option value="">Visi</option>
<?php foreach ($results['groups']['results'] as $group) { ?>
		<option value="<?php echo $group->id ?>"<?php echo !empty($_GET['group']) && $group->id == $_GET['group'] ? 'selected="selected"' : NULL ?>><?php echo $group->title ?></option>
<?php } ?>
              </select>
            </div>
          </div>
	  <div class="form-group">
	    <label for="status" class="col-sm-3 control-label">Instruktorius</label>
	    <div class="col-sm-9">
	      <select name="instructor" class="form-control">
		<option value="">Visi</option>
		<option value="0"<?php echo !empty($_GET['instructor']) && 0 == $_GET['instructor'] ? 'selected="selected"' : NULL ?>>Ne</option>
		<option value="1"<?php echo !empty($_GET['instructor']) && 1 == $_GET['instructor'] ? 'selected="selected"' : NULL ?>>Taip</option>
              </select>
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
  <label>Įrašų: <?php echo $results['finances']['totalRows'] ?></label>
  <div class="table-responsive">
    <table class="table table-striped ">
      <thead>
	<tr>
	  <th rowspan="2">Narys</th>
	  <th rowspan="2">Likutis</th>
	  <th colspan="7">Mokesčiai</th>
	  <th rowspan="2">Komentarai</th>
	  <th rowspan="2" style="width:90px;">Atnaujinta</th>
	  <th rowspan="2"></th>
	</tr>
	<tr>
	  <th>Skrydžiai</th>
	  <th>Nario</th>
	  <th>Namelis</th>
	  <th>Elektra</th>
	  <th>Draudimas</th>
	  <th>2%</th>
	  <th>Darbai</th>
	</tr>
      </thead>
      <tbody>
<?php foreach ( $results['finances']['results'] as $finance) { ?>
<?php   $balance = (intval($finance->entry_fee)+intval($finance->member_fee)+intval($finance->labor_fee)+intval($finance->house_fee)+intval($finance->electricity_fee)+intval($finance->airworthiness_fee)+intval($finance->insurance_fee)+intval($finance->casco_fee)+intval($finance->flight_fee)+intval($finance->debt_fee)); ?>
        <tr>
	  <td>
	    <a href="index.php?action=user&amp;id=<?php echo $finance->user->id ?>"><?php echo $finance->user->name ?></a>
	  </td>
	  <td title="Likutis" class="<?php echo empty($balance) ? 'warning' : ($balance < 0 ? 'danger' : 'success') ?>">
      <?php echo theme('display_money', 'balance', NULL, (object)array('balance' => $balance, 'date' => !empty($finance->date) ? $finance->date : NULL)) ?>
	  </td>
	  <td title="Skrydžiai">
	    <?php echo theme('display_money', 'flight_fee', NULL, $finance) ?>
	  </td>
	  <td title="Nario">
	    <?php echo theme('display_money', 'member_fee', NULL, $finance) ?>
	  </td>
	  <td title="Namelis">
	    <?php echo theme('display_money', 'house_fee', NULL, $finance) ?>
	  </td>
	  <td title="Elektra">
	    <?php echo theme('display_money', 'electricity_fee', NULL, $finance) ?>
	  </td>
	  <td title="Draudimas">
	    <?php echo theme('display_money', 'insurance_fee', NULL, $finance) ?>
	  </td>
	  <td title="2%">
	    <?php echo theme('display_money', 'debt_fee', NULL, $finance) ?>
	  </td>
	  <td title="Darbai">
	    <?php echo theme('display_money', 'labor_fee', NULL, $finance) ?>
	  </td>
	  <td title="Komentarai">
 	    <?php echo theme('display', 'fee_notes', NULL, $finance) ?>
	  </td>
	  <td title="Atnaujinta">
 	    <?php echo theme('display', 'fee_last_updated', NULL, $finance) ?>
	  </td>
	  <td>
 	    <a class="btn btn-xs btn-default" href="index.php?action=finance&amp;view=View&amp;id=<?php echo $finance->contact_id ?>">Istorija</a>
<?php if ($this->HasPermission()) { ?>
 	    <a class="btn btn-xs btn-default" href="index.php?action=finance&amp;view=Edit&amp;id=<?php echo $finance->user->id ?>">Redaguoti</a>
<?php } ?>
	  </td>
	</tr>
<?php } ?>
      </tbody>
    </table>
  </div>
</div>
