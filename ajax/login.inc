<?php
session_start();

if (isset($_POST['action']) && $_POST['action'] == 'reset' &&
    ($username = !empty($_POST['username']) ? $_POST['username'] : NULL)) {
        
    require_once dirname(__FILE__) . '/../models/user.inc';
    require_once dirname(__FILE__) . '/../helpers/password.inc';
    require_once dirname(__FILE__) . '/../functions.php';
    $user_model = new User();
    $edit = array();
    $user = $user_model->get_by_username($username);

    $new_password = Password::generate_password();
    $edit['password'] = md5($new_password);
    
    if ($user_model->Put($user->id, $edit)) {
        send_mail($user->email, 'Naujas sklandymas.lt slaptažodis', "Sveiki, $user->name,\r\nSiunčiame Jums naują prisijungimo slaptažodį.\r\n\r\nJūsų vartotojo vardas: $user->username\r\nSlaptažodis: $new_password\r\n");
        echo 'Naujas slaptažodis sugeneruotas ir išsiųstas adresu ' . $user->email;
    }
    else {
        echo 'Nepavyko pakeisti slaptažodžio';
    }
}
else {
    echo 'Nežinomas veiksmas';
}
