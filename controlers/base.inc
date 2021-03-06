<?php

require_once dirname(__FILE__) . '/../helpers/messages.inc';

class BaseControler {
  private $view;

  public function BaseControler() {
    $this->view = NULL;
  }

  public static function HasPermission($permission = 'administer') {
    require_once dirname(__FILE__) . '/../helpers/user.inc';
    return UserHelper::has_permission($permission);
  }

  /*
    Transfer to controler
  */
  public function Transfer($controler=NULL, $action='Index', $params = NULL) {
    $return = NULL;
    if (isset($params['return']))
      $return = $params['return'];
    if (!empty($return))
      $this->Redirect($return, $code);

    if (empty($controler))
      $controler = strtolower(preg_replace('/Controler$/', '', get_class($this)));
    $code = 302;
    if (empty($params))
      $code = 302;
    elseif (is_numeric($params))
      $code = $params;
    elseif (!empty($params['code'])) {
      $code = $params['code'];
      unset($params['code']);
    }

    if (empty($params['skip_destination']) || $params['skip_destination'] != TRUE) {
      $destination = $this->Destination();
      if (!empty($destination))
        $this->Redirect($destination, $code);
    }

    $q = NULL;
    if (!empty($params) && is_array($params))
      $q = '&' . http_build_query($params, '', '&');

    $this->Redirect("?action=$controler&view=$action$q", $code);
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
      if (!empty($url) && $url[0] == '/')
        $base .= '';
      else if (!empty($url) && $url[0] == '?')
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

  static public function Referrer() {
    if (isset($_GET['return']))
      return $_GET['return'];
    if (isset($_POST['return']))
      return $_POST['return'];
    if (isset($_SERVER['return']))
      return $_SERVER['return'];
    if (isset($_POST['destination']))
      return $_POST['destination'];
    if (isset($_SERVER['HTTP_REFERER'])) {
      parse_str(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY), $array);
      if (isset($array['return']))
        return $array['return'];
      return $_SERVER['HTTP_REFERER'];
    }
    return NULL;
  }

  static public function Destination() {
    return !empty($_POST['destination']) ? $_POST['destination'] : NULL;
  }
}