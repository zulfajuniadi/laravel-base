//= require ../packages/dropzone/downloads/dropzone.js

Dropzone.autoDiscover = false;
window.onload = function(){
  var target = $("div#uploader");
  var options = target.data();
  var uploadOptions = { 
    headers: {
      'X-CSRF-Token': $('meta[name="_token"]').attr('content'),
      'X-Uploader-Class' : options.class,
      'X-Uploader-Id' : (options.id || ''),
    },
    url: '/uploader',
    addRemoveLinks: true,
  };
  if(options.size) 
    uploadOptions.maxFilesize = options.size;
  if(options.files)
    uploadOptions.maxFiles = options.files;
  if(options.type)
    uploadOptions.acceptedFiles = options.type;
  var dz = new Dropzone(target[0], uploadOptions);

  dz.on('success', function(file, response){
    file.response = response;
  });

  dz.on('removedfile', function(file){
    if(file.response) {
      $.ajax({
        method: 'DELETE',
        contentType: "application/json",
        dataType: "json",
        url: '/uploader/' + file.response.id 
      })  
    }
  });

}