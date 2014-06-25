<?php

require_once dirname(__FILE__) . '/base.inc';
require_once dirname(__FILE__) . '/../models/user.inc';

class WeatherControler extends BaseControler {
  private $view;
  public $data;
  public $prognosis;

  public function UserControler() {
  }

  public function Index() {
    return $this->View();
  }

  public function View() {
    $this->view = dirname(__FILE__) . '/../views/weather/view.php';

    $file = dirname(__FILE__) . "/../uploads/meteo_paluknis.png";
    if (!file_exists($file) || round(abs(time() - filemtime($file)) / 60, 2) > 10) { // min
      file_put_contents($file, file_get_contents('http://meteo.lt/dokumentai/operatyvi_inf/skaitmenine_prog/meteo_paluknis.png'));
    }
    $this->prognosis = '/' . CATALOG . '/uploads/meteo_paluknis.png';

    $content = file_get_contents('http://www.weatherlink.com/user/eyvp/index.php?view=summary&headers=0');
    if (!empty($content)) {
      $pattern = "~<tr>\s*<td\s+width=\"190\"\s+class=\"summary_data\">([^<]*)</td>\s*(<td\s+width=\"170\"\s+class=\"summary_data\">([^<]*)</td>\s*<td\s+width=\"100\"\s+class=\"summary_data\">([^<]*)</td>\s*<td\s+width=\"100\"\s+class=\"summary_data\">([^<]*)</td>\s*<td\s+width=\"100\"\s+class=\"summary_data\">([^<]*)</td>\s*<td\s+width=\"100\"\s+class=\"summary_data\">([^<]*)</td>|<td\s+width=\"570\"\s+class=\"summary_data\"\s+colspan=\"5\">([^<]*)</td>)\s*</tr>~";
      //$pattern = "~<tr>\s*<td\s+width=\"190\"\s+class=\"summary_data\">([^<]*)</td>\s*<td\s+width=\"170\"\s+class=\"summary_data\">([^<]*)</td>\s*<td\s+width=\"100\"\s+class=\"summary_data\">([^<]*)</td>\s*<td\s+width=\"100\"\s+class=\"summary_data\">([^<]*)</td>\s*<td\s+width=\"100\"\s+class=\"summary_data\">([^<]*)</td>\s*<td\s+width=\"100\"\s+class=\"summary_data\">([^<]*)</td>\s*</tr>~";
      preg_match_all($pattern, $content, $this->data, PREG_SET_ORDER);
    }
    else
      $this->data = NULL;

    include dirname(__FILE__) . '/../views/_layout.php';
  }
}
