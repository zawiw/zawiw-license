var images = jQuery('body').find('img').map(function(){
   return this.src;
}).get();
alert(images);
