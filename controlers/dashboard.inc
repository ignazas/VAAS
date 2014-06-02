<?php

require_once dirname(__FILE__) . '/../helpers/messages.inc';

class DashboardControler {
  private $view;

  public function DashboardControler() {
    $this->view = dirname(__FILE__) . '/../templates/dashboard.php';
  }

  public function Index() {
    return $this->View();
  }

  private function QuoteBlock(&$elements) {
      $elements['quote'] = array(
	  "<p>“Once you have tasted flight, you will forever walk the earth with your eyes turned skyward, for there you have been, and there you will always long to return.”</p><small>Leonardo da Vinci</small>",
	  "<p>“You wanna fly, you got to give up the shit that weighs you down.”</p><small>Toni Morrison, Song of Solomon</small>",
	  "<p>“Less flapping, more flying!”</p><small>Silvia Hartmann</small>",
	  "<p>“If you want success in life, then just learn how to walk like a turtle instead of flying.”</p><small>Vikrant Parsai</small>",
	  "<p>“Other people had flying dreams. I had falling nightmares.”</p><small>Kami Garcia and Margaret Stohl, Beautiful Redemption</small>",
	  "<p>“The reason birds can fly and we can't is simply because they have perfect faith, for to have faith is to have wings.”</p><small> J.M. Barrie, The Little White Bird</small>",
      );
  }

  private function CalendarBlock(&$elements) {
      require_once dirname(__FILE__) . '/../models/calendar.inc';

      $model = new Calendar();;
      $elements['calendar'] = $model->getByDate(time());
  }

  public function View() {
    $this->view = dirname(__FILE__) . '/../views/dashboard/view.php';

    $elements = array();
    $this->QuoteBlock($elements);
    $this->CalendarBlock($elements);

    include dirname(__FILE__) . '/../views/_layout.php';
  }
}
