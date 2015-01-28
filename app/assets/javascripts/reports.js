//= require ../packages/datatables/media/js/jquery.dataTables.js
//= require ../packages/bootstrap3-datepicker/js/bootstrap-datepicker.js

$('select').prepend('<option value="" disabled readonly>Select One</option>');
$('select').each(function(){
    var target = $(this);
    if(target.data('value') === undefined) {
        target.val('');
    }
});
$('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
});
$('#reset-form').click(function(e){
    var loc = window.location;
    window.location = loc.protocol + '//' + loc.host + loc.pathname + loc.search;
});