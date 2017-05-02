<div class="row">
  <h2>Paluknio aerodromas</h2>
  <iframe id="playeriframe" src="http://ipcamlive.com/player/player.php?alias=paluknyscam1&amp;autoplay=1&amp;disablevideofit=1&amp;token=9506138d&amp;debug=1" width="1024px" height="838px" frameborder="0" allowfullscreen=""></iframe>
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
