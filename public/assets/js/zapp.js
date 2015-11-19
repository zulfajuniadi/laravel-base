;(function(){
  $('.confirm-action').click(function(e){
    e.preventDefault();
    bootbox.confirm('Are you sure that you want to do this?', function(response){
      window.location.href = e.target.href;
    });
    return false;
  });
}).call(this);