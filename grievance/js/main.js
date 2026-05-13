jQuery(document).ready(function($){

  var horizontal = $('body').hasClass('horizontal-menu');

  if (!horizontal) {
    var min_height = jQuery(window).height();
    var win_width = jQuery(window).width();
    if (win_width >= 980) {
      jQuery('div.sidebar').css('min-height', min_height);
    }

    $(window).resize(function(){
      var min_height = jQuery(window).height();
      var win_width = jQuery(window).width();
      if (win_width >= 980) {
        jQuery('div.sidebar').css('min-height', min_height);
      }
    });
  }

});
jQuery(document).ready(function($){

  /*** Display menu children if it has some ***/
  $('li.parent>a', 'ul.menu').on('click',function(){
    var link = $(this);
    var obj = $(this).parent();
    var child = $('ul.child', obj);

    if ($(child).is(':visible')) {
      $(child).slideUp(400);
      $(link).removeClass('close-child');
    } else {
      $(child).slideDown(400);
      $(link).addClass('close-child');
    }

    return false;
  });

 /*** sidebar tab click page center ***/
 $(document).ready(function () {
    
	if($(window).width() > 767){
		$('li.parent a').on('click', function() {
        $('html,body').animate({ scrollTop: $(this).offset().top - ( $(window).height() - $(this).outerHeight(true) ) / 2  }, 350);
    });
	}
});
  /**** TO TOP *****/
   $(function(){
$('#totopscroller').totopscroller();
})
  /*** Close container elements ***/
  $('a', '.close-box').on('click',function(){
    var obj = $(this);
    var box   = $(obj).parents('.box');
    var chart = $(obj).parents('.chart');

    if ($(box).length) {
      $(box).fadeOut(400);
    } else if ($(chart).length) {
      $(chart).fadeOut(400);
    }

    return false;
  });

  /*** Responsive Menu ***/
  $('.responsive-menu>a').on('click',function(){
    var menu = $('ul.menu', '.sidebar');
    if ($(menu).is(':visible')) {
      $(menu).slideUp(800);
    } else {
      $(menu).slideDown(800);
    }
  });
  $(document).on('click', '.left-icons .collapse-sidebar', function(){ 
    $('body').toggleClass( "full" );
 });
 $("[data-toggle='tooltip']").tooltip();
	 $('.popovers').popover();
  /*** Close container elements ***/
  $('a.close-box', '.boxed').on('click',function(){
    var obj = $(this);
    var box   = $(obj).parents('.boxed');
    var chart = $(obj).parents('.chart');

    if ($('.inner', box).length) {
      if ($('.inner', box).is(':visible')) {
        $('.inner', box).slideUp(400);
        $('i', obj).removeClass('fa-chevron-up').addClass('fa-chevron-down');
      } else {
        $('.inner', box).slideDown(400);
        $('i', obj).removeClass('fa-chevron-down').addClass('fa-chevron-up');
      }
    } else if ($(chart).length) {
      if ($('.inner', chart).is(':visible')) {
        $('.inner', chart).slideUp(400);
        $('i', chart).removeClass('fa-chevron-up').addClass('fa-chevron-down');
      } else {
        $('.inner', chart).slideDown(400);
        $('i', chart).removeClass('fa-chevron-down').addClass('fa-chevron-up');
      }
    }

    return false;
  });

  /*** Close container elements ***/
  $('a.remove-box', '.boxed').on('click',function(){
    var link = $(this);
    var icon = $('i', link);
    var parent = $(this).parent().parent().parent().parent();

    if ($(parent).length) {
      $(parent).slideUp(400);
    }

    return false;
  });

 // Div Slimscroll
	$('.scroll-content').slimscroll({
	  height: '250px',
	  color: '#1e7994',
	  railVisible: true,
		railColor: '#73d1eb'
	});
  $('[data-hover="dropdown"]').dropdownHover();
  /*** ToolTips ***/
  $('[data-toggle="tooltip"]').each(function(i, item) {
    $(item).tooltip();
  });

  /*** PopOvers ***/
  $('[data-toggle="popover"]').each(function(i, item) {
    $(item).popover();
  });
  
  
  /*** CHAT *****/
	

	$('.header-bar div.col-sm-12').first().append(' <ul class="left-icons"><li><a href="#" class="collapse-sidebar"><i class="fa fa-bars"></i></a></li></ul>');


	
  
	 var a = $(".chatui-talk"),
                t = $(".chatui-form"),
                i = $("#chat-message"),
                n = "";
            t.find("form").submit(function(t) {
                n = i.val(), n && (a.find("ul").append('<li class="chatui-talk-msg chatui-talk-msg-right animation-expandUp"><img src="images/chat-avatar2.jpg" alt="Avatar" class="img-circle chatui-talk-msg-avatar">' + $("<div />").text(n).html() + "</li>"), a.animate({
                    scrollTop: a[0].scrollHeight
                }, 200), i.val("")), t.preventDefault()
            }), $(".chatui-action-open").on("click", function() {
                $(this).parents(".chatui").removeClass("chatui-window-close"), a.animate({
                    scrollTop: a[0].scrollHeight
                }, 0), i.focus()
            }), $(".chatui-action-close").on("click", function() {
                $(this).parents(".chatui").addClass("chatui-window-close")
            })
  

});




 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-83974351-1', 'auto');
  ga('send', 'pageview');;