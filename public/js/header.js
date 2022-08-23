var isMouseHoverInHeader = false;
var handleScrolling = {
  duration: 1.5,
  current_time: 0,
  interval: null,
  element_ids: ['#main-header']
};

$(function(){
  $(document).scroll(() => handleShowHeader());

  $(document).mousemove(function(e) {
    let distant = e.pageY - $(document).scrollTop();
    isMouseHoverInHeader = distant <= 63;

    if(isMouseHoverInHeader) handleShowHeader();
  });
})

function handleShowHeader(){
  $(handleScrolling.element_ids.join(', ')).show('slow');
  handleScrolling.current_time = handleScrolling.duration;
  if(handleScrolling.interval) clearInterval(handleScrolling.interval);

  handleScrolling.interval = setInterval(() => {
    if(handleScrolling.current_time === 0){
      if(!$('#main-header').hasClass('show') && !isMouseHoverInHeader){
        clearInterval(handleScrolling.interval);
        $(handleScrolling.element_ids.join(', ')).hide('slow');
      }
      else handleScrolling.current_time = handleScrolling.duration;
    }
    else handleScrolling.current_time-= 0.5;
  },500);
}