<?php require "common.php" ?>
<?php require "secure.php" ?>
<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>

<div class="container">
    <?php include "templates/include/messages.inc" ?>
    <?php include "templates/include/errors.inc" ?>

	<div class="page-header"><h1>Vartotojo nustatymai</h1></div>
      
    <div class="col-md-8">
        <form action="index.php?action=user" method="post" id="user_edit" enctype= "multipart/form-data">
          	<div class="col-md-6">
          		<img src="<?php echo empty($user->avatar) ? 'images/users/avatar.jpg' : "uploads/users/$user->avatar" ?>" style="width: 150px; height: 150px;" class="img-thumbnail" alt="150x150 Foto">
          		<input type="file" name="avatar" id="avatar" value="Įkelti" />
            </div>
            <div class="col-md-6">
                <fieldset>
                    <legend>Pagrindinė informacija:</legend>
                    <?php echo theme('text', 'name', 'Vardas', $user, $edit) ?>
                    <?php echo theme('email', 'email', 'El. paštas', $user, $edit) ?>
                    <?php echo theme('text', 'telephone1', 'Telefonas', $user, $edit) ?>
                    <?php echo theme('url', 'website', 'Interneto svetainė', $user, $edit) ?>
                    
                    <?php echo theme('display', 'usertype', 'Vartotojo tipas', $user, $edit) ?>
                    <?php echo theme('display', 'registerDate', 'Užsiregistravo', $user, $edit) ?>
                    <?php echo theme('display', 'lastvisitDate', 'Paskutinis apsilankymas', $user, $edit) ?>
                </fieldset>

                <fieldset>
                    <legend>Slaptažodis:</legend>
                    <?php echo theme('password', 'password', 'Senas', $user, array('password' => '')) ?>
                    <?php echo theme('password', 'new_password_1', 'Naujas', $user, $edit) ?>
                    <?php echo theme('password', 'new_password_2', 'Pakartoti', $user, $edit) ?>
                </fieldset>
            </div>
            
            <div class="buttons">
                <input type="submit" value="Saugoti" />
            </div>   
        </form>
    </div>

      <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Info</h3>
            </div>
            <div class="panel-body">
              <p>Čia galite keisti savo slaptažodį ar asmeninius duomenis.</p>
            </div>
          </div>
        </div>
        
  
	
		
    </div> <!-- /container -->



        



<?php include "templates/include/footer.php" ?>