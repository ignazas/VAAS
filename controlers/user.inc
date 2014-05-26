<?php

require_once dirname(__FILE__) . '/../models/user.inc';
require_once dirname(__FILE__) . '/../helpers/messages.inc';

class UserControler {
    private $user_model;
    private $view;

    public function UserControler() {
        $this->view = dirname(__FILE__) . '/../templates/user.php';
    }

    private function Validate($user) {
        if (empty($_POST['name'])) {
            Messages::form_error('name', "Vardas negali būti tuščias.");
        }
        if (!empty($_POST['email'])) {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                Messages::form_error('email', "Elektroninis adresas $_POST[email] yra neteisingas.");
        }
        if (!empty($_POST['website'])) {
            if (!filter_var($_POST['website'], FILTER_VALIDATE_URL))
                Messages::form_error('website', "Internetinis adresas $_POST[website] yra neteisingas.");
        }
        if (!empty($_POST['password']) && (!empty($_POST['new_password_1']) || !empty($_POST['new_password_2']))) {
            if (md5($_POST['password']) != $user->password)
                Messages::form_error('password', "Neteisintas senas slaptažodis.");
            else if ($_POST['new_password_1'] != $_POST['new_password_2'])
                Messages::form_error('password', "Įvestas naujas slaptažodis nesutampa.");
            else if (empty($_POST['new_password_1']) || empty($_POST['new_password_2']))
                Messages::form_error('password', "Naujas slaptažodis negali būti tuščias.");
        }
        
        $messages = Messages::get_messages('errors', false);
        return empty($messages);
    }
    
    public function Run() {
        if ($user_id = !empty($_SESSION['user']['id']) ? $_SESSION['user']['id'] : NULL) {
            $user_model = new User();
            $edit = array();
            $user = $user_model->Get($user_id);
            
            if ($user && $_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($this::Validate($user)) {
                    if (!empty($_POST['password']) && !empty($_POST['new_password_1'])) {
                        $edit['password'] = md5($_POST['new_password_1']);
                    }
                    
                    foreach (array('name', 'email', 'telephone1', 'website') as $key) {
                        if (isset($_POST[$key]) && $user->{$key} != $_POST[$key])
                            $edit[$key] = $_POST[$key];
                    }
    
                    if (!empty($_FILES["avatar"]) && $_FILES["avatar"]["error"] != 4) {
                        $moved = FALSE;
                        
                        if ($_FILES["avatar"]["error"] > 0) {
                            //print_r($_FILES["avatar"]);
                            die("Error: " . $_FILES["avatar"]["error"]);
                        }
                    
                        $filename = $user_id . '-' . $_FILES['avatar']['name'];
                        if (function_exists('imagecreatefromstring')) {
                            $MAX_WIDTH = 150;
                            $MAX_HEIGHT = 150;
                            
                            $source = imagecreatefromstring(file_get_contents($_FILES["avatar"]["tmp_name"]));
                            list($width, $height) = getimagesize($_FILES["avatar"]["tmp_name"]);
                            
                            if (!empty($source) && $width > 0 && $height > 0) {
                                $percent = 1;
                                if ($width / $height >= $MAX_WIDTH / $MAX_HEIGHT)
                                    $percent = $MAX_WIDTH / $width;                         
                                else
                                    $percent = $MAX_HEIGHT / $height;
                                $newwidth = $width * $percent;
                                $newheight = $height * $percent;
                                
                                $thumb = imagecreatetruecolor($MAX_WIDTH, $MAX_HEIGHT);
                                imagealphablending($thumb, false);
                                imagesavealpha($thumb, true);  
                                
                                $trans_layer_overlay = imagecolorallocatealpha($thumb, 220, 220, 220, 127);
                                imagefill($thumb, 0, 0, $trans_layer_overlay);
                                
                                imagecopyresampled($thumb, $source, ($MAX_WIDTH-$newwidth)/2, ($MAX_HEIGHT-$newheight)/2, 0, 0, $newwidth, $newheight, $width, $height);
                                
                                $filename = preg_replace('/\..+$/', '.' . 'png', $filename);
                                imagepng($thumb, dirname(__FILE__) . "/../uploads/users/$filename");
                                unlink($_FILES["avatar"]["tmp_name"]);
                                
                                $moved = TRUE;
                            } 
                        }
    
                        if (!$moved)
                            move_uploaded_file($_FILES["avatar"]["tmp_name"], dirname(__FILE__) . "/../uploads/users/$filename");
    
                        $edit['avatar'] = $filename;
                    }

                    if ($user_model->Put($user_id, $edit))
                        Messages::set_message('Informacija atnaujinta');
                    
                    if (!empty($edit['avatar']) && $user->avatar != $edit['avatar'])
                        unlink(dirname(__FILE__) . '/../uploads/users/' . $user->avatar);
                    
                    //update session values
                    foreach ($edit as $key => $value) {
                        $_SESSION['user'][$key] = $value;
                        $user->{$key} = $value;
                    }
                }
            }
            
            include $this->view;
        }
        else {
            header("Location: index.php",TRUE,307);
        }
    }
}
