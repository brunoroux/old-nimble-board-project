$(function(){
  if ($('#stories_sprint_drag').length > 0) {
    var pb = $('.product_backlog');
    var sb = $('.sprint_backlog');
    var width = parseInt(pb.css('width'));
    pb.resizable({
      minWidth: width,
      maxWidth: width
    });
    width = parseInt(sb.css('width'));
    sb.resizable({
      minWidth: width,
      maxWidth: width
    });
    $('.story').draggable({
      containment: '#stories_sprint_drag',
      stack: '.story',
      revert: 'invalid'
    });
    pb.droppable({
      drop: function(event, ui) {
        setStoryTarget(event, ui, 'product_backlog');
      }
    });
    sb.droppable({
      drop: function(event, ui) {
        setStoryTarget(event, ui, 'sprint_backlog');
      }
    });
  } else if ($('.product_backlog').length > 0) {
    var width = parseInt($('.product_backlog').css('width'));
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
  }
});

function setStoryTarget(event, ui, target)
{
  if (target == "product_backlog") {
    var sprint = "null";
  } else {
    var sprint = sprintId;
  }
  var id = ui.draggable.attr('id');
  var numid = id.substr(6);
  $.ajax(setStoryTargetUrl, {
    data: {'storyId': numid, 'sprintId': sprint}
  });
}