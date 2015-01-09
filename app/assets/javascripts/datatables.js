//= require ../packages/datatables/media/js/jquery.dataTables.js
//= require ../packages/datatables-bootstrap/dist/dataTables.bootstrap.js

$('.DT').each(function(){
  var target = $(this);
  var path = target.data('path');
  var DT = target.DataTable({
    stateSave: true,
    ajax: path
  });
});