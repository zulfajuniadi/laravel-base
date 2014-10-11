/*
 *= require datatables/media/js/jquery.dataTables
 *= require datatables-bootstrap/dist/dataTables.bootstrap
 *= require_self
 */
$('.DT').each(function(){
  var target = $(this);
  var path = target.data('path');
  var DT = target.DataTable({
    stateSave: true,
    ajax: path
  });
});