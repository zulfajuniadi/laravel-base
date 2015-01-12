//= require ../packages/jquery/dist/jquery.js
//= require ../packages/bootstrap/dist/js/bootstrap.js
//= require ../packages/bootbox/bootbox.js
//= require ../packages/better-dom/dist/better-dom.js
//= require ../packages/better-i18n-plugin/dist/better-i18n-plugin.js
//= require ../packages/better-popover-plugin/dist/better-popover-plugin.js
//= require ../packages/better-form-validation/dist/better-form-validation.js

;(function(){
    $(document).on('click', '.confirm-delete', function(e){
        e.preventDefault();
        var form = $(this).parents('form')[0];
        bootbox.confirm('Are your sure you want to delete this?', function(res){
            if(res) {
                form.submit();
            }
        });
        return false;
    });
}).call(this);