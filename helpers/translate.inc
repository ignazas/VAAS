<?php
class Translate {
  private static $accountKey = 'lBeJ0gPJnuaLbv2V8cD7IatdVe0u9dzWfgq8gUsU9ls';
  private static $context = NULL;

  /**
   * Authentication of Application key
   *
   * @return unknown
   */
  private static function getContext()
  {
    if (!isset(Translate::$context))
      Translate::$context = stream_context_create(array(
                             'http' => array(
                               'request_fulluri' => true,
                               'header'  => "Authorization: Basic " . base64_encode(Translate::$accountKey . ":" . Translate::$accountKey)
                             )
                           ));
    return Translate::$context;
  }

  public static function t($word, $from = 'en', $to = 'lt') {
    require_once dirname(__FILE__) . '/cache.inc';
    $value = Cache::get($word);
    if ($value === FALSE) {
      $request = "https://api.datamarket.azure.com/Bing/MicrosoftTranslator/v1/Translate?Text=" . urlencode("'$word'") . "&To=" . urlencode("'$to'") . "&From=" . urlencode("'$from'") . "&\$format=Raw";
      $value = file_get_contents($request, 0, Translate::getContext());
      Cache::set($word, $value);
    }
    return $value;
  }


}
