	<div id="footer">
		<div class="container">
           <p class="text-muted">2014<?php if (2014 < date('Y')) echo ' - ' . date('Y'); ?>, Vilniaus Aeroklubas</p>
      	</div>
    </div>
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/moment-with-locales.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <script src="js/jquery.bpopup.min.js"></script>
    <script src="js/scripts.js"></script>

    <script src="js/chosen.jquery.min.js"></script>

    <script type="text/javascript" src="libraries/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
tinymce.init({
    selector: "textarea.ritchtext",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
});
    </script>

<?php if (UserHelper::logged_in()) { ?>
<script type="text/javascript">
var _urq = _urq || [];
_urq.push(['initSite', 'c8b1fc13-8b14-4a07-b399-c12617d3f826']);
(function() {
var ur = document.createElement('script'); ur.type = 'text/javascript'; ur.async = true;
ur.src = ('https:' == document.location.protocol ? 'https://cdn.userreport.com/userreport.js' : 'http://cdn.userreport.com/userreport.js');
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ur, s);
})();
</script>
<?php } ?>
  </body>
</html>
