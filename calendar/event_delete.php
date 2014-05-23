<?php
require_once dirname(__FILE__) . '/../functions.php';
require_once dirname(__FILE__) . '/const.inc';

session_start();

$query = "SELECT admin_id FROM ".$TBL_PR."admins WHERE admin_username='".addslashes($_POST['USER'])."' AND admin_password='".addslashes(md5($_POST['PASS']))."' LIMIT 1";
$query_result = DB::query($query);
while ($info = mysql_fetch_array($query_result))
{
	$admin_id = $info['admin_id'];
}

if (isset($admin_id))
{
	DB::query("DELETE FROM " . TBL_EVENTS . " WHERE event_id='".addslashes($_POST['id'])."' LIMIT 1");
	$_POST['month'] = $_POST['month'] + 1;
    ?>
                <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
                <html>
                <head>
                <title>Calendar - Delete Event</title>
                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                <script language='javascript' type="text/javascript">
                <!--
                 function redirect_to(where, closewin)
                 {
                         opener.location= 'index.php?' + where;
                         
                         if (closewin == 1)
                         {
                                 self.close();
                         }
                 }
                  //-->
                 </script>
                </head>
                <body onLoad="javascript:redirect_to('month=<? echo $_POST['month']."&year=".$_POST['year']; ?>',1);">
                </body>
                </html>
	<?
	exit;
}
else
{
	header("Location: event_delete.php?day=".$_POST['day']."&month=".$_POST['month']."&year=".$_POST['year']."&id=".$_POST['id']);
	exit;
}
