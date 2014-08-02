/**
 *= require jquery/dist/jquery
 *= require bootstrap/dist/js/bootstrap
 *= require bootbox/bootbox
 *= require datatables/media/js/jquery.dataTables
 *= require datatables-bootstrap/dist/dataTables.bootstrap
 *= require _custom
 *= require_self
 */

$('.DT').each(function(){
  var target = $(this);
  var path = target.data('path');
  var DT = target.DataTable({
    ajax: path
  });
});