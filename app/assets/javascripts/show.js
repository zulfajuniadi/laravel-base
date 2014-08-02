/**
 *= require jquery/dist/jquery
 *= require bootstrap/dist/js/bootstrap
 *= require bootbox/bootbox
 *= require _custom
 *= require_self
 */
$('input:not([type=hidden]),select,textarea', 'form').attr({
  disabled: true,
  readonly: true
});