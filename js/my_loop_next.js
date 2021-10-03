document.addEventListener('DOMContentLoaded', function(){
    let elem = document.getElementById('custom-next');

    function handler() {
      let marker = false;
      let y = 0;
      let items = document.getElementsByClassName('item'); 
        for (let i = 0; i < items.length; i++) { 
		  if (items[i].classList.contains('custom-child')){
		  	items[i].classList.toggle('custom-child');
		  	items[i].classList.toggle('child-hidden');
		  	marker = true;
		  } else {
            
		  	if (marker) {
		        y++; 
			  	if (y < 5){
	            items[i].classList.toggle('custom-child');
			  	items[i].classList.toggle('child-hidden');
			  	}
		   }
		  }
		  if (i === items.length - 1) {
	        if (y == 0) {
	        	 for (let z = 0; z < 4; z++) {
	        	 	items[z].classList.toggle('custom-child');
	        	 	items[z].classList.toggle('child-hidden');
	        	 }
	        }
	      }
		}
    };
   
   if(elem) {
   	 elem.addEventListener("click", handler); 
   }
	
});