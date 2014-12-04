/**
 *= require datatables/media/js/jquery.dataTables
 *= require datatables-bootstrap/dist/dataTables.bootstrap
 *= require_self
 */
$('input:not([type=hidden]),select,textarea', 'form').attr({
  disabled: true,
  readonly: true
});