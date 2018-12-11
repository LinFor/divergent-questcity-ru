 function log(html) {
      document.getElementById('progress_upload').innerHTML = html;
    }

    function onSuccess() {
      log('success');
    }

    function onError() {
      log('error');
    }

    function onProgress(loaded, total) {
	
      log('' +loaded + ' / ' + total + '');
    }

    document.forms.upload.onsubmit = function() {
      var file = this.elements.input_img.files[0];
      if (file) {
        upload(file);
      }
      return false;
    }


    function upload(file) {

      var xhr = new XMLHttpRequest();

      
      // обработчик для закачки
      xhr.upload.onprogress = function(event) {
	var percentComplete = Math.ceil(event.loaded / event.total * 100);  
       
		//document.getElementById('upload_block').classList.remove('wait');
	    document.getElementById('upload_button').classList.add('upload_in_progress');
		log('<div class=load_bar style=width:' + percentComplete + '%>' + percentComplete + '%</div>');
		//log('' + percentComplete + '%');
      }

      xhr.open("POST", "upload", true);
      xhr.send(file);
	  
var formData = new FormData();
formData.append("input_img", file);
xhr.send(formData);

    }