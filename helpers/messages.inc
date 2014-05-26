<?php
class Messages {
    public static function set_message($message, $type='messages', $element=NULL) {
        if (isset($_SESSION)) {
            if (!isset($_SESSION['messages']))
                $_SESSION['messages'] = array();
            if (!empty($element))
                $_SESSION['messages'][$type][$element] = $message;
            else
                $_SESSION['messages'][$type][] = $message;
        }
    }
    
    public static function dpm($message) {
        Messages::set_message($message, 'messages');
    }

    public static function form_error($element, $message) {
        Messages::set_message($message, 'errors', $element);
    }
    
    public static function has_error($element) {
        return isset($_SESSION['messages']['errors'][$element]);
    }
    
    public static function get_messages($type = 'messages', $clear=TRUE) {
        if (!empty($_SESSION['messages'][$type])) {
            $result = $_SESSION['messages'][$type]; 
            if ($clear)
                $_SESSION['messages'][$type] = array();
            return $result;
        }
        return array();
    }
}
