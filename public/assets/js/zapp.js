;(function(){
  $('.confirm-action').click(function(e){
    e.preventDefault();
    bootbox.confirm('Are you sure that you want to do this?', function(response){
      if(response)
        window.location.href = e.target.href;
    });
    return false;
  });
  $('.has-datetime').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss'
  });
  $('.has-date').datetimepicker({
    format: 'YYYY-MM-DD'
  });
  $('.has-time').datetimepicker({
    format: 'HH:mm:ss'
  });
}).call(this);