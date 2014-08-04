/**
 *= require jquery/dist/jquery
 *= require bootstrap/dist/js/bootstrap
 *= require bootbox/bootbox
 *= require_self
 */
;(function(){
  $(document).on('click', '.confirm-delete', function(e){
    e.preventDefault();
    var form = $(this).parents('form')[0];
    bootbox.confirm('Are your sure you want to delete this?', function(res){
      if(res) {
        form.submit();
      }
    });
    return false;
  });
}).call(this);