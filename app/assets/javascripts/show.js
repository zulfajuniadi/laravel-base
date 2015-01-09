//= require ../packages/datatables/media/js/jquery.dataTables.js
//= require ../packages/datatables-bootstrap/dist/dataTables.bootstrap.js

$('input:not([type=hidden]),select,textarea', 'form').attr({
  disabled: true,
  readonly: true
});