<?php
class DateHelper {
  public static function time_as_string($time) {
    if (empty($time) && $time != 0)
      return NULL;

    if (is_float($time))
      return intval(floor($time)) . ':' . str_pad(round(60 * ($time - floor($time))), 2, '0', STR_PAD_LEFT);

    if (is_string($time))
      $time = str_replace(array(',', '.', ':', ';'), ':', $time);

    $value = explode(':', $time);

    return str_pad($value[0], 2, '0', STR_PAD_LEFT) . ':' . str_pad(!empty($value[1]) ? $value[1] : '', 2, '0', STR_PAD_LEFT);
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
