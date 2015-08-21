<div class="page-header"><h1>Orlaivis</h1></div>
<div class="row">
  <div class="col-md-8<?php echo !empty($results['aircraft']->deleted) ? " bg-danger" : NULL?>">
    <?php echo !empty($results['aircraft']->deleted) ? theme('display', 'reg_num', 'Ištrintas', $results['aircraft']) : NULL ?>
    <?php echo theme('display', 'reg_num', 'Registracijos numeris', $results['aircraft']) ?>
    <?php echo theme('display', 'name', 'Modelis', $results['aircraft']) ?>
    <?php echo theme('display', 'serial_num', 'Serijinis numeris', $results['aircraft']) ?>
    <?php echo theme('display', 'first_pilot', 'Pirmas pilotas', $results['aircraft']) ?>
    <?php echo theme('display', 'second_pilot', 'Antras pilotas', $results['aircraft']) ?>
    <?php echo theme('display', 'third_pilot', 'Trečias pilotas', $results['aircraft']) ?>
    <?php echo theme('display', 'remarks', 'Pastabos', $results['aircraft']) ?>

    <?php echo theme('display', 'time_since_new', 'Praskrista iš viso', $results['aircraft']) ?>
    <?php echo theme('display', 'flights_since_new', 'Skrydžių kiekis iš viso', $results['aircraft']) ?>

    <!--<?php echo theme('display', 'moh_date', 'MOH', $results['aircraft']) ?>-->
    <!--<?php echo theme('display', 'time_since_mo', 'Laikas nuo MO', $results['aircraft']) ?>-->
    <!--<?php echo theme('display', 'flights_since_mo', 'Skrydžių nuo MO', $results['aircraft']) ?>-->

    <?php echo theme('display', 'time_left', 'Laiko liko', $results['aircraft']) ?>
    <?php echo theme('display', 'flights_left', 'Skrydžių liko', $results['aircraft']) ?>

    <?php echo theme('display', 'time_last_year', 'Praskrista pernai', $results['aircraft']) ?>
    <?php echo theme('display', 'flights_last_year', 'Skrydžių kiekis pernai', $results['aircraft']) ?>

    <?php echo theme('display_date', 'coa_expiry_date', 'Tinkamumas baigiasi', $results['aircraft']) ?>
    <?php echo theme('display_date', 'civ_insur_expiry_date', 'Civilinis draudimas baigiasi', $results['aircraft']) ?>
    <?php echo theme('display_date', 'kasko_insur_expiry_date', 'Kasko draudimas baigiasi', $results['aircraft']) ?>

    <?php echo theme('display_date', 'manuf_date', 'Pagaminimo data', $results['aircraft']) ?>
  </div>

  <div class="col-md-4">

    <div class="panel panel-default">
      <div class="panel-heading">
	<h3 class="panel-title">Info</h3>
      </div>
      <div class="panel-body">
<?php if (UserHelper::has_permission()) { ?>
        <div class="buttons">
	  <a href="index.php?action=aircraft&amp;view=Edit&amp;id=<?php echo $results['aircraft']->id ?>" class="btn btn-sm btn-primary">Redaguoti</a>
<?php   if (!empty($results['aircraft']->deleted)) { ?>
	  <a href="index.php?action=aircraft&amp;view=Restore&amp;id=<?php echo $results['aircraft']->id ?>" class="btn btn-success">Sugražinti</a>
<?php   } else { ?>
 	  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti orlaivį <?php echo $results['aircraft']->reg_num ?>?')" href="admin.php?action=aircraft&amp;view=Delete&amp;id=<?php echo $results['aircraft']->id ?>">Pašalinti</a>
<?php   } ?>
	</div>
<?php } ?>
      </div>
    </div>
  </div>
</div>
