$(function(){
  var width = parseInt($('.product_backlog').css('width'));
  console.log(width);
  $('.product_backlog').resizable({
    containment: '.content',
    minHeight: minheight,
    minWidth: width,
    maxWidth: width
  });
  $('.story').draggable({
    containment: '.product_backlog',
    stack: '.story',
    stop: function() {
      var left = parseInt($(this).css('left'));
      var top = parseInt($(this).css('top'));
      var id = $(this).attr('id');
      var numid = id.substr(6);

      $.ajax(setCoordinatesUrl, {
        data: {'id': numid, 'left': left, 'top': top}
      });
    }
  });
});