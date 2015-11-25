jQuery(document).ready(function(){
   jQuery('#search').bind("keyup", function(){
      searchFile();
   })
});
/*
* functionallity of the filesearch
*/
function searchFile() {
   var searchValueTmp = jQuery('#search').val();
   var searchValue = jQuery('#search').val().toLowerCase();
   jQuery('.mediaContent').each(function(index, elem){
          if(searchValue == "") {
                  jQuery(elem).css('display', 'block');

                  jQuery(elem).find('span').each(function(subIndex, subElem){
                          jQuery(subElem).html(jQuery(subElem).text());
                  });
          }
          else if(jQuery(elem).text().toLowerCase().indexOf(searchValue) > -1) {
                  jQuery(elem).css('display', 'block');
                  jQuery(elem).find('span').each(function(subIndex, subElem){
                          jQuery(subElem).html(jQuery(subElem).text().replace(new RegExp("("+searchValue+")", "gi"), '<b>$1</b>'));
                  });
          }
          else {
                  jQuery(elem).css('display', 'none');
          }
       });
}
