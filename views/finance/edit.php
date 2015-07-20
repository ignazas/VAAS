<form role="form" id="finance-edit" class="form-horizontal" action="" method="POST">
  <fieldset>

    <!-- Form Name -->
    <legend>Redaguoti <?php echo $results['finance']->user->name ?> mokesčius</legend>

   <input type="hidden" name="contact_id" value="<?php echo $results['finance']->contact_id ?>" />

   <!-- Text input-->
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
     <label class="control-label" for="fee_notes">Komentarai</label>
     <textarea id="fee_notes" name="fee_notes" class="form-control input-md"><?php echo $results['finance']->fee_notes ?></textarea>
   </div>
   <div class="form-group">
     <label class="control-label" for="singlebutton"></label>
     <button id="submit" name="saveChanges" class="btn btn-primary">Įtraukti</button>
     <a href="index.php?action=finance" class="btn btn-sm">Atšaukti</a>
   </div>

  </fieldset>
</form>
