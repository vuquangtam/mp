$('.flags li > a').click(function(e){
  language = $( this ).attr('id');
  $.ajax({
     url: $('#url_prefix').val()+'/user-setting/setlanguage',
     data: { 'language': language },
     success: function(data) {
       return true;
     }
  });
});
