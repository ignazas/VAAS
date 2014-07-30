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
        "<p>“Refuse to be average. Let your heart soar as high as it will.”</p><small>A. W. Tozer</small>",
        "<p>“The higher we soar, the smaller we appear to those who cannot fly.”</p><small>Friedrich Nietzsche</small>",
        "<p>“Celebrate your success and stand strong when adversity hits, for when the storm clouds come in, the eagles soar while the small birds take cover”</p><small>Similar&nbsp;Quotes</small>",
        "<p>“There is an eagle in me that wants to soar, and there is a hippopotamus in me that wants to wallow in the mud”</p><small>Carl Sandburg</small>",
        "<p>“We have not wings we cannot soar; but, we have feet to scale and climb, by slow degrees, by more and more, the cloudy summits of our time.”</p><small>Henry Wadsworth Longfellow</small>",
        "<p>“Man is now able to soar into outer space and reach up to the moon; but he is not moral enough to live at peace with his neighbor!”</p><small>Sri Sathya Sai Baba</small>",
        "<p>“People who soar are those who refuse to sit back, sigh and wish things would change. They neither complain of their lot nor passively dream of some distant ship coming in. Rather, they visualize in their minds that they are not quitters; they will not allow life's circumstances to push them down and hold them under.”</p><small>Similar&nbsp;Quotes</small>",
        "<p>“One can never consent to creep when one feels an impulse to soar.”</p><small>Helen Keller</small>",
        "<p>“Eagles may soar, but weasels don't get sucked into jet engines”</p><small>John Benfield</small>",
        "<p>“Those who can soar to the highest heights can also plunge to the deepest depths, and the natures which enjoy most keenly are those which also suffer most sharply”</p><small>Lucy Maud Montgomery</small>",
        "<p>“In almost everything that touches our everyday life on earth, God is pleased when we're pleased. He wills that we be as free as birds to soar and sing our maker's praise without anxiety.”</p><small>A. W. Tozer</small>",
        "<p>“No matter how big a nation is, it is no stronger that its weakest people, and as long as you keep a person down, some part of you has to be down there to hold him down, so it means you cannot soar as you might otherwise”</p><small>Marian Anderson</small>",
        "<p>“Let your mind start a journey thru a strange new world. Leave all thoughts of the world you knew before. Let your soul take you where you long to be...Close your eyes let your spirit start to soar, and you'll live as you've never lived before.”</p><small>Erich Fromm</small>",
        "<p>“If I have freedom in my love, And in my soul am free, -- Angels alone that soar above, Enjoy such liberty.”</p><small>Richard Lovelace</small>",
        "<p>“When you soar like an eagle, you attract the hunters.”</p><small>Milton S. Gould</small>",
        "<p>“The spirit that does not soar is destined to grovel”</p><small>Benjamin Disraeli</small>",
        "<p>“Wisdom is oftentimes nearer when we stoop than when we soar.”</p><small>William Wordsworth</small>",
        "<p>“Wisdom is oft times nearer when we stoop than when we soar”</p><small>William Wordsworth</small>",
        "<p>“Half dust, half deity, unfit alike to sink or soar”</p><small>Lord Byron</small>",
        "<p>“I too must attempt a way by which I can raise myself above the ground, and soar triumphant through the lips of men.”</p><small>Virgil</small>",
        "<p>“Let your mind start a journey thru a strange new world. Leave all thoughts of the world you knew before. Let your soul take you where you long to be...Close your eyes let your spirit start to soar, and you'll live as you've never live”</p><small>Philip Massinger</small>",
        "<p>“No one can prepare you for what heights you will soar until you spread your wings.”</p><small>Hot_Dawg</small>",
        "<p>“Keep your feet on the ground, but let your heart soar as high as it will. Refuse to be average or to surrender to the chill of your spiritual environment. [The Root Of The Righteous]”</p><small>Arthur Helps</small>",
        "<p>“May your love soar on the wings of a dove in flight”</p><small>Debbie Crabtree</small>",
        "<p>“As long as you keep a person down, some part of you has to be down there to hold him down, so it means you cannot soar as you otherwise might.”</p><small>Marian Anderson</small>",
        "<p>“It came into him life, it went out from him truth. It came to him short-lived actions; it went from him poetry. It was a dead fact; now, it is quick thought. It can stand, and it can go. It now endures, it now flies, it now inspires. Precisely in porportion to the depth of mind from which it issued, so high does it soar, so long does it live.”</p><small>linzbaby</small>",
        "<p>“All is going on as it was wont. The waves are hoarse with repetition of their mystery; the dust lies piled upon the shore; the sea-birds soar and hover; the winds and clouds go forth upon their trackless flight; the white arms beckon, in the moonlight, to the invisible country far away.”</p><small>Charles Dickens</small>",
        "<p>“Imagination allows us to escape the predictable. It enables us to reply to the common wisdom that we cannot soar by saying, \"Just watch!\"”</p><small>Bill Bradley</small>",
        "<p>“Why all this toil for triumphs of an hour? What tho' we wade in Wealth, or soar in Fame? Earth's highest station ends in \"Here he lies;\" and \"Dust to dust\" concludes the noblest songs”</p><small>Edward Young</small>",
        "<p>“The seven deadly sins... food, clothing, firing, rent, taxes,respectability and children. Nothing can lift those seven millstones from man's neck but money; and the spirit cannot soar until the millstones are lifted.”</p><small>George Bernard Shaw</small>",
        "<p>“The eagle may soar; beavers build dams.”</p><small>french_horn_quee</small>",
        "<p>“Ambition can creep as well as soar.”</p><small>Edmund Burke</small>",
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
