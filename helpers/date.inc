<?php
class DateHelper {
  public static function time_as_string($time) {
    if (empty($time) && $time != 0)
      return NULL;

    if (is_float($time))
      return intval(floor($time)) . ':' . round(60 * ($time - floor($time)));

    if (is_string($time))
      $time = str_replace(array(',', '.', ':', ';'), ':', $time);
    return $time;
  }

  public static function time_as_float($time) {
    if (empty($time))
      return 0.0;

    if (is_float($time))
      return $time;

    if (is_string($time))
      $time = str_replace(array(',', '.', ':', ';'), '.', $time);

    $value = explode('.', $time);

    return floatval($value[0]) + (!empty($value[1]) ? (floatval($value[1])/60.0) : 0.0);
  }
}
