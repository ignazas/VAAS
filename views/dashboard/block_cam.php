<?php
  function GetAddress() {
    $opts = array('http' => array(
                'method'  => 'GET',
                'timeout' => 5
            )
    );
    $context  = stream_context_create($opts);
    $content = @file_get_contents("http://ipcamlive.com/paluknyscam1", false, $context, -1);
    if (!empty($content)) {
      preg_match_all("/var token = '([^']+)';/s", $content, $matches);
      if (!empty($matches[1][0])) {
        $token = $matches[1][0];
        return "http://ipcamlive.com/player/player.php?alias=paluknyscam1&amp;autoplay=1&amp;disablevideofit=1&amp;token=$token&amp;debug=1";
      }
    }
    return ;
  }
  $videoAddress = GetAddress();
?>

<?php if (!empty($videoAddress)) { ?>

<div class="row">
  <h2>Paluknio aerodromas</h2>
  <iframe id="playeriframe" src="<?php echo $videoAddress ?>" width="1024px" height="838px" frameborder="0" allowfullscreen=""></iframe>
  <script>
$( document ).ready(function() {
  function UpdateWidth() {
    var currentWidth = $('#playeriframe').width();
    var currentHeight = $('#playeriframe').height();

    $('#playeriframe').css({'width': '100%'});
    var newWidth = $('#playeriframe').width();
    var newHeight = newWidth/currentWidth*currentHeight;
    $('#playeriframe').css({'width': newWidth, 'height': newHeight});
  }
  $( window ).resize(function() {
    UpdateWidth();
  });
  UpdateWidth();
});
  </script>
</div>

<?php } ?>
