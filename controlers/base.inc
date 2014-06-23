<?php

require_once dirname(__FILE__) . '/../helpers/messages.inc';

class BaseControler {
  private $view;

  public function BaseControler() {
    $this->view = NULL;
  }

  public function HasPermission($permission = 'administer') {
    switch ($permission) {
      case 'administer':
        return !empty($_SESSION['user']['usertype']) &&
          ($_SESSION['user']['usertype']=="Administrator" || $_SESSION['user']['usertype']=="Super Administrator");
    }
  }

  /*
    Transfer to controler
  */
  public function Transfer($controler=NULL, $action='Index', $code=302) {
    if (empty($controler))
      $controler = strtolower(preg_replace('/Controler$/', '', get_class($this)));
    $this->Redirect("?action=$controler&view=$action", $code);
  }

  /*
    Redirect to defined url
    301 - Moved Permanently
    302 - Found
    303 - See Other
    307 - Temporary Redirect (HTTP/1.1)
  */
  static public function Redirect($url, $code=302) {
    if (strpos($url, '//') === FALSE && !empty($_SERVER['HTTP_HOST'])) {
      $base = 'http://' . $_SERVER['HTTP_HOST'];
      if (!empty($url) && $url[0] == '?')
        $base .= $_SERVER['PHP_SELF'];
      else
        $base .= dirname($_SERVER['PHP_SELF']);
      $url = $base . $url;
    }

    if (headers_sent() === false)
      header('Location: ' . $url, true, $code);
    else
      echo '<meta http-equiv="Location" content="' . $url . '"><script>window.location="'.$url.'";</script>';
    die();
  }
}