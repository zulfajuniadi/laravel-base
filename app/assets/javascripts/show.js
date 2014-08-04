/**
 *= require_self
 */
$('input:not([type=hidden]),select,textarea', 'form').attr({
  disabled: true,
  readonly: true
});