//Dropzone.autoDiscover = false;
  Dropzone.options.myDropzone = {
    init: function() {


      this.on("complete", function (file) {


        let json = $.parseJSON(file.xhr.response);

        console.log(file.xhr.response);

        gallery.addImg(json.newImages);
        //gallery.init();
      });

      thisDropzone = this;
        
    }
  }


  var gallery = {};


  gallery = {
    imagesData: $('.flexbin'), 
    init: function () {

      let images;
      let html = '';
      let data = this.imagesData;

      $.ajax({
        method: "POST",
        url: "gallery-images.json",
        dataType: "json",
        async: false ,
        cache: false,
        success: function (data) {
          images = data;
        }
      }); 


      data.html('');
      this.addImg(images);
     

    },
    addImg: function(images) {
      let data = this.imagesData;
      $.each(images, function (k, v) {
        $.each(v, function (name, value) {
          data.prepend('<img class="lozad" data-src="'+ value.url +'">');
        });
      });
    }
  };
  
$(document).ready(function(){

  $(document).on('change', '.fileUploads', function(){

    var $this    = $(this);
    var formData = new FormData();
    var files    = $this[0].files;
    

    $.each(files, function(i, file) {
        formData.append('file-'+i, file);
    });


    $.ajax({
        url: 'upload_ajax.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        //dataType: "json",
        success: function(response){

            let json = $.parseJSON(response);
            try {
              if(json.r == 1) {
                //alert(json.text);
                console.log(json);
                gallery.addImg(json.newImages);
              } else {
                alert(json.text);
              }
            } catch (e) {
                console.log('error response');
            }

            console.log(json);

        },
    });

  });


  gallery.init();



const observer = lozad(); // lazy loads elements with default selector as '.lozad'
observer.observe();


});