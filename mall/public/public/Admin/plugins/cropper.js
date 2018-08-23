// vars
var result = document.querySelector('.result-logo'),
    img_result = document.querySelector('.img-result'),
    img_w = document.querySelector('.img-w'),
    img_h = document.querySelector('.img-h'),
    options = document.querySelector('.options'),
    save = document.querySelector('#saveLogo'),
    cropped = document.querySelector('.cropped'),
    dwn = document.querySelector('.download'),
    upload = document.querySelector('#logoF'),
    cropper = '';

// on change show image with crop options
upload.addEventListener('change', function (e) {
  if (e.target.files.length) {
    // start file reader
    var reader = new FileReader();
    reader.onload = function (e) {
      if (e.target.result) {
        // create new image
        var img = document.createElement('img');
        img.id = 'image';
        img.src = e.target.result;
        // clean result before
        result.innerHTML = '';
        // append new image
        result.appendChild(img);
        // show save btn and options
        save.classList.remove('hide');
        options.classList.remove('hide');
        // init cropper
        cropper = new Cropper(img, {
			    aspectRatio: 1.5,
				dragMode: 'move',
				cropBoxMovable: true,
				cropBoxResizable: false,
                                zoom : - 0.1,
				built: function () {
				  $toCrop.cropper("setCropBoxData", { width: "150", height: "100" });
				}
			});
      }
    };
    reader.readAsDataURL(e.target.files[0]);
  }
});

// save on click
save.addEventListener('click', function (e) {
     e.preventDefault();
    var form = $('#store_save');
    var formdata = false;
    if (window.FormData){
        formdata = new FormData(form[0]);
    }
                
    if($("#logoF").val() == "")
    {      
        formdata.append("logo_img_url", '');
        $.ajax({
                    url: "/admin/acl/Miscellaneous/storeSettings/add",
                    type: 'post',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    //   dataType: 'json',
                    beforeSend: function () {
                        // $("#barerr" + id).text('Please wait');
                    },
                    success: function (res) {
                        window.location.href = "";
                    }
                });
    }
    else
    {
        var fileUpload = $("#logoF")[0];
        //Check whether the file is valid Image.
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
        if (regex.test(fileUpload.value.toLowerCase())) {
             //Check whether HTML5 is supported.
            if (typeof (fileUpload.files) != "undefined") {                
                
                var ImageURL = cropper.getCroppedCanvas({
                            width: 150 // input value
                          }).toDataURL();                
                formdata.append("logo_img_url", ImageURL);
                
                $.ajax({
                    url: "/admin/acl/Miscellaneous/storeSettings/add",
                    type: 'post',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    //   dataType: 'json',
                    beforeSend: function () {
                        // $("#barerr" + id).text('Please wait');
                    },
                    success: function (res) {
                        window.location.href = "";
                    }
                });

            }
            else
            {
                $("#error-logo").html("This browser does not support HTML5.");
                return false;
            }
        }
        else
        {
            $("#error-logo").html("Please select a valid Image file.");
            return false;            
        }
    } 



//  var imgSrc = cropper.getCroppedCanvas({
//    width: 200 // input value
//  }).toDataURL();
//  // remove hide class of img
//  cropped.classList.remove('hide');
//  img_result.classList.remove('hide');
//  // show image cropped
//  cropped.src = imgSrc;
//  dwn.classList.remove('hide');
//  dwn.download = 'imagename.png';
//  dwn.setAttribute('href', imgSrc);
//  
  
  
});


function b64toBlob(b64Data, contentType, sliceSize) {
        contentType = contentType || '';
        sliceSize = sliceSize || 512;

        var byteCharacters = atob(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

      var blob = new Blob(byteArrays, {type: contentType});
      return blob;
}