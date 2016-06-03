<?php $finance = $results['finance']; $balance = (intval($finance->entry_fee)+intval($finance->member_fee)+intval($finance->labor_fee)+intval($finance->house_fee)+intval($finance->electricity_fee)+intval($finance->airworthiness_fee)+intval($finance->insurance_fee)+intval($finance->casco_fee)+intval($finance->flight_fee)+intval($finance->debt_fee)); ?>

<form role="form" id="finance-edit" class="form-horizontal" action="" method="POST">
  <fieldset>

    <!-- Form Name -->
    <legend>Redaguoti <?php echo $results['finance']->user->name ?> mokesčius</legend>

   <input type="hidden" name="contact_id" value="<?php echo $results['finance']->contact_id ?>" />

   <div class="form-group">
     <label class="col-sm-2 control-label">Balansas</label>
     <div class="col-sm-10">
       <?php echo theme('display_money', 'balance', NULL, (object)array('balance' => $balance, 'date' => !empty($results['finance']->date) ? $results['finance']->date : NULL)) ?>
     </div>
   </div>
   <div class="form-group">
     <label class="col-sm-2 control-label" for="flight_fee">Skrydžiai</label>
     <div class="col-sm-10">
       <input id="flight_fee" name="flight_fee" class="form-control input-md" type="number" step="any" pattern="[0-9]+([\,|\.][0-9]+)?" value="<?php echo $results['finance']->flight_fee ?>">
     </div>
   </div>
   <div class="form-group">
     <label class="col-sm-2 control-label" for="member_fee">Nario mokestis</label>
     <div class="col-sm-10">
       <input id="member_fee" name="member_fee" class="form-control input-md" type="number" step="any" pattern="[0-9]+([\,|\.][0-9]+)?" value="<?php echo $results['finance']->member_fee ?>">
     </div>
   </div>
   <div class="form-group">
     <label class="col-sm-2 control-label" for="labor_fee">Darbų mokestis</label>
     <div class="col-sm-10">
       <input id="labor_fee" name="labor_fee" class="form-control input-md" type="number" step="any" pattern="[0-9]+([\,|\.][0-9]+)?" value="<?php echo $results['finance']->labor_fee ?>">
     </div>
   </div>
   <div class="form-group">
     <label class="col-sm-2 control-label" for="house_fee">Patalpų mokestis</label>
     <div class="col-sm-10">
       <input id="house_fee" name="house_fee" class="form-control input-md" type="number" step="any" pattern="[0-9]+([\,|\.][0-9]+)?" value="<?php echo $results['finance']->house_fee ?>">
     </div>
   </div>
   <div class="form-group">
     <label class="col-sm-2 control-label" for="electricity_fee">Elektros mokestis</label>
     <div class="col-sm-10">
       <input id="electricity_fee" name="electricity_fee" class="form-control input-md" type="number" step="any" pattern="[0-9]+([\,|\.][0-9]+)?" value="<?php echo $results['finance']->electricity_fee ?>">
     </div>
   </div>
   <div class="form-group">
     <label class="col-sm-2 control-label" for="insurance_fee">Draudimas</label>
     <div class="col-sm-10">
       <input id="insurance_fee" name="insurance_fee" class="form-control input-md" type="number" step="any" pattern="[0-9]+([\,|\.][0-9]+)?" value="<?php echo $results['finance']->insurance_fee ?>">
     </div>
   </div>
   <!-- <div class="form-group">
     <label class="col-sm-2 control-label" for="casco_fee">Kasko mokestis</label>
     <div class="col-sm-10">
       <input id="casco_fee" name="casco_fee" class="form-control input-md" type="number" step="any" pattern="[0-9]+([\,|\.][0-9]+)?" value="<?php echo $results['finance']->casco_fee ?>">
     </div>
   </div> -->
   <div class="form-group">
     <label class="col-sm-2 control-label" for="debt_fee">Už 2%</label>
     <div class="col-sm-10">
       <input id="debt_fee" name="debt_fee" class="form-control input-md" type="number" step="any" pattern="[0-9]+([\,|\.][0-9]+)?" value="<?php echo $results['finance']->debt_fee ?>">
     </div>
   </div>
   <div class="form-group">
     <label class="col-sm-2" for="fee_notes">Komentarai</label>
     <div class="col-sm-10">
       <input type="text" id="fee_notes" name="fee_notes" class="form-control input-md" value="<?php echo $results['finance']->fee_notes ?>" />
     </div>
   </div>
   <div class="form-group">
     <label class="control-label" for="singlebutton"></label>
     <button id="submit" name="saveChanges" class="btn btn-primary">Įtraukti</button>
     <a href="index.php?action=finance" class="btn btn-sm">Atšaukti</a>
   </div>

  </fieldset>
</form>


<?php if (!empty($results['journal'])) { ?>
<div class="row">
  <div class="col-md-12">
    <h2>Mokėjimai</h2>
    <table class="table table-striped">
      <thead>
	<tr>
    <th>Balansas</th>
	  <th>Skrydžiai</th>
	  <th>Nario mokestis</th>
	  <th>Darbų/talkos mokestis</th>
	  <th>Patalpų mokestis</th>
	  <th>Elektros mokestis</th>
	  <th>Draudimas</th>
	  <!-- <th>Kasko mokestis</th> -->
	  <th>Už 2%</th>
	  <th>Komentarai</th>
	  <th>Data</th>
	</tr>
      </thead>
      <tbody>
<?php  foreach ($results['journal'] as $r) { $r['date'] = $r['fee_updated']; $row = (object)$r; ?>
    <?php $finance = $row; $balance = (intval($finance->entry_fee)+intval($finance->member_fee)+intval($finance->labor_fee)+intval($finance->house_fee)+intval($finance->electricity_fee)+intval($finance->airworthiness_fee)+intval($finance->insurance_fee)+intval($finance->casco_fee)+intval($finance->flight_fee)+intval($finance->debt_fee)); ?>
        <tr>
	  <td title="Likutis" class="<?php echo empty($balance) ? 'warning' : ($balance < 0 ? 'danger' : 'success') ?>">
	    <?php echo theme('display_money', 'balance', NULL, (object)array('balance' => $balance, 'date' => $finance->date)) ?>
	  </td>
	  <td><?php echo theme('display_money', 'flight_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'member_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'labor_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'house_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'electricity_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display_money', 'insurance_fee', NULL, $row) ?></td>
	  <!-- <td><?php echo theme('display_money', 'casco_fee', NULL, $row) ?></td> -->
	  <td><?php echo theme('display_money', 'debt_fee', NULL, $row) ?></td>
	  <td><?php echo theme('display', 'fee_notes', NULL, $row) ?></td>
	  <td><?php echo theme('display', 'fee_updated', NULL, $row) ?></td>
        </tr>
<?php  } ?>
      </tbody>
    </table>
  </div>
</div>
<?php } ?>
