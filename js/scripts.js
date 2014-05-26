jQuery( document ).ready(function( $ ) {
  $('#reminder').click(function(event){
      event.preventDefault();
      
      var username = $('input[name=username]').val();
      
      if (username) {
          $.ajax({
            'url': 'index.php?action=ajax&method=login',
            'data': 'action=reset&username=' + username,
            'type': 'POST',
            'success': function (resp) {
                alert(resp);
            }
          });
      } else {
          alert('Neįvestas vartotojo vardas');
      }
  });
});