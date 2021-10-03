document.addEventListener('DOMContentLoaded', function(){

   let form = document.getElementById('custom-form');
   
   if(form) {
	   
	function getSelectValues(select) {
	  var result = [];
	  var options = select && select.options;
	  var opt;

	  for (var i=0, iLen=options.length; i<iLen; i++) {
		opt = options[i];

		if (opt.selected) {
		  result.push(opt.value || opt.text);
		}
	  }
	  return result;
	}

   	 form.addEventListener('submit', function(e){ //say this is an anchor

     e.preventDefault();
    
    let nonce     = document.getElementById('custom_nonce_field').value;
    let title     = document.getElementById('title').value;
    let desc      = document.getElementById('desc').value;
    let image     = document.getElementById('image').files[0].name;
    let size      = document.getElementById('size')
    let size_val  = getSelectValues(size).toString();
    let color     = document.getElementById('color')
    let color_val = getSelectValues(color).toString();
    let sex       = document.getElementById('sex')
    let sex_val   = getSelectValues(sex).toString();
    let term      = document.getElementById('term')
    let term_val  = getSelectValues(term).toString();

	if (title == "" || desc == "" || image == ""|| size_val == "" || color_val == "" || sex_val == ""  || term_val == "") {
	alert("Fill the form!");
	return false;
	} 
		 
	var request = new XMLHttpRequest();

    request.open('POST', my_ajax_object.ajax_url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
    request.onload = function () {
        if (this.status >= 200 && this.status < 400) {
            // If successful
            console.log(this.response);
        } else {
            // If fail
            console.log(this.response);
        }
    };
    request.onerror = function() {
        // Connection error
    };
    request.send('action=create_clothes&ajax_nonce=' + nonce + '&title=' + title + '&desc=' + desc + '&image=' + image + '&size_val=' + size_val + '&color_val=' + color_val + '&sex_val=' + sex_val + '&term_val=' + term_val);
    //

   });
   }
	
});