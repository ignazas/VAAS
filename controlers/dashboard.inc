<?php

require_once dirname(__FILE__) . '/base.inc';

class DashboardControler extends BaseControler {
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
      require_once dirname(__FILE__) . '/../models/calendar_event.inc';
      require_once dirname(__FILE__) . '/../models/calendar_day.inc';

      $model_event = new CalendarEvent();
      $model_day = new CalendarDay();

      $today = time();
      $elements['calendar-today']['events'] = $model_event->getByDate($today);
      $elements['calendar-today']['days'] = $model_day->getByDate($today);

      $tomorrow = $today + 86400; /*1 Day = 24*60*60 = 86400*/
      $elements['calendar-tomorrow']['events'] = $model_event->getByDate($tomorrow);
      $elements['calendar-tomorrow']['days'] = $model_day->getByDate($tomorrow);
  }

  private function ArticleBlock(&$elements) {
      require_once dirname(__FILE__) . '/../models/article.inc';
      $model = new Article();;
      $elements['article'] = $model->getList(5);
  }

  public function View() {
    $this->view = dirname(__FILE__) . '/../views/dashboard/view.php';

    $elements = array();
    $this->QuoteBlock($elements);
    $this->CalendarBlock($elements);
    $this->ArticleBlock($elements);

    include dirname(__FILE__) . '/../views/_layout.php';
  }
}
