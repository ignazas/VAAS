	<div class="page-header"><h1>Vartotojo nustatymai</h1></div>
      	<div class="row">

        <form action="" method="post" id="user_edit" enctype= "multipart/form-data">
	<div class="col-md-4">
        <img src="<?php echo empty($user->avatar) ? 'images/users/avatar.jpg' : "uploads/users/$user->avatar" ?>" style="width: 150px; height: 150px;" class="img-thumbnail" alt="150x150 Foto">
        <input type="file" name="avatar" id="avatar" value="Įkelti" /><br />
<?php if (UserHelper::has_permission()) { ?>
                    <?php echo theme('display', 'usertype', 'Vartotojo tipas', $user, $edit) ?>
                    <?php echo theme('checkbox', 'usertype|Super_Administrator', 'Super Administratorius', $user, $edit) ?>
                    <?php echo theme('checkbox', 'usertype|Administrator', 'Administratorius', $user, $edit) ?>
                    <?php echo theme('checkbox', 'usertype|Flight_Manager', 'Skydžių administratorius', $user, $edit) ?>
                    <?php echo theme('checkbox', 'usertype|Publisher', 'Naujienų rašytojas', $user, $edit) ?>
                    <?php echo theme('checkbox', 'usertype|Registered', 'Registruotas', $user, $edit) ?>
                    <?php echo theme('checkbox', 'usertype|Planner', 'Planuotojas', $user, $edit) ?>
                    <?php echo theme('checkbox', 'instructor', 'Instruktorius', $user, $edit) ?>
<?php } else { ?>
                    <?php echo theme('display', 'usertype', 'Vartotojo tipas', $user, $edit) ?>
<?php } ?>
                    <?php echo theme('display', 'registerDate', 'Užsiregistravo', $user, $edit) ?>
                    <?php echo theme('display', 'lastvisitDate', 'Paskutinis apsilankymas', $user, $edit) ?>
            	</div>
            <div class="col-md-4">
                <fieldset>
                    <legend>Pagrindinė informacija:</legend>
                    <?php echo empty($user->id) ? theme('text', 'username', 'Vartotojo vardas', $user) : NULL ?>
                    <?php echo theme('text', 'name', 'Vardas', $user, $edit) ?>
                    <?php echo theme('email', 'email', 'El. paštas', $user, $edit) ?>
                    <?php echo theme('text', 'telephone1', 'Telefonas', $user, $edit) ?>
                    <?php echo theme('url', 'website', 'Interneto svetainė', $user, $edit) ?>
<?php if (UserHelper::has_permission()) { ?>
                    <?php echo theme('number', 'discount', 'Nuolaida, %', $user, $edit) ?>
<?php } else { ?>
                    <?php echo theme('display', 'discount', 'Nuolaida, %', $user, $edit) ?>
<?php } ?>
                    <?php echo theme('text', 'licenseNo', 'Licencijos numeris', $user, $edit) ?>
                    <?php echo theme('date', 'licenseValidTill', 'Licencija galioja iki', $user, $edit) ?>
                    <?php echo theme('text', 'healthNo', 'Sveikatos paž. numeris', $user, $edit) ?>
                    <?php echo theme('date', 'healthValidTill', 'Sveikatos paž. galioja iki', $user, $edit) ?>
<?php  if (UserHelper::is_student($user)) { ?>
                    <div class="form-group">
		      <label class="control-label" for="instructor_id">Instruktorius</label>
		      <select name="instructor_id" id="instructor_id" class="form-control">
			<option value=""></option>
<?php foreach ($instructors['results'] as $instr) { ?>
			<option value="<?php echo $instr->id ?>"<?php echo !empty($user->instructor_id) && $user->instructor_id == $instr->id || !empty($_POST['instructor_id']) && $_POST['instructor_id'] == $instr->id ? ' selected="selected"' : NULL ?>><?php echo $instr->name ?></option>
<?php } ?>
                      </select>
                    </div>
<?php } ?>
                </fieldset>
		</div>
		<div class="col-md-4">
                <fieldset>
                    <legend>Slaptažodis:</legend>
                    <?php echo !empty($user->id) ? theme('password', 'password', 'Senas', $user, array('password' => '')) : NULL ?>
                    <?php echo theme('password', 'new_password_1', 'Naujas', $user, $edit) ?>
                    <?php echo theme('password', 'new_password_2', 'Pakartoti', $user, $edit) ?>
                </fieldset>
            </div>
            </div>
            <div class="buttons">
                <input type="submit" class="btn btn-sm btn-primary" value="Saugoti" />
                <a href="index.php?action=user" class="btn btn-sm">Atšaukti</a>
            </div>
        </form>
    </div>
