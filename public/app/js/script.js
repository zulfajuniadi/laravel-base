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