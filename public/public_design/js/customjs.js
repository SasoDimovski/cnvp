/**
 *   1- Main menu
 *   2- Mobile menu
 *   3- OwlCarousel
 *   4- Bootstrap Carousel
 *   5- Breadking News
 *   6- Bootstrap Popup
 *   7- PrettyPhoto
 *   8- Slider Pro
 *   9- Bootstrap Tab
 *   10- UISearch
 *   11- Accordion & Toggle
 *   12- Back to top
 
 *-----------------------------------------------------------------
 **/

"use strict";

jQuery(document).ready(function() {

// -------------------------------
// 1- Main menu
// -------------------------------

jQuery('ul.sf-menu').superfish();

// -------------------------------
// 2- Mobile menu
// -------------------------------
jQuery(".master-menu-mobile .master-menu").hide();

jQuery(".menu-mobile").on('click', function(e) {
    e.preventDefault();
    jQuery(".master-menu-mobile .master-menu").slideToggle(800);
});
jQuery(".master-menu").navgoco({accordion: true});

// -------------------------------
// 3- OwlCarousel
// -------------------------------

// -------------------------------
// Slider home 1
// -------------------------------
  var sliders = jQuery('.master-widget-slider');
  if(sliders.length) {
    jQuery.each(sliders, function(index, item) {
      var current_slider = jQuery(this).find('.owl-carousel');

      var is_lazyload = ('true' == current_slider.attr('data-lazyload')) ? true :false;

      var is_navigation = ('true' == current_slider.attr('data-navigation')) ? true : false;

      var items = ('' != current_slider.attr('data-items') && undefined != current_slider.attr('data-items')) ? current_slider.attr('data-items') : 3;
        items =   parseInt(items, 10);

      var autoplay = ('' != current_slider.attr('data-autoplay') && undefined != current_slider.attr('data-autoplay')) ? current_slider.attr('data-autoplay') : 3000;
        autoplay =   parseInt(autoplay, 10);

      var slideSpeed = ('' != current_slider.attr('data-slideSpeed') && undefined != current_slider.attr('data-slideSpeed')) ? current_slider.attr('data-slideSpeed') : 200;
        slideSpeed =   parseInt(slideSpeed, 10);

      current_slider.owlCarousel({
        autoPlay: autoplay,
        items : items,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3],
        itemsTablet: [768,3],
        itemsTabletSmall: [640,2],
        itemsMobile : [480,1],
        lazyLoad : is_lazyload,
        navigation : is_navigation,
        slideSpeed : slideSpeed,
          

      });
    });
  }
  var $widget = jQuery('.master-custom-row-section-4');
  if($widget.length) {
    var $tab_titles = $widget.find('.master-custom-row .master-widget-right');
    var $html = '';
  
    $html += '<div class="master-widget-list-video">';
    jQuery.each($tab_titles, function() {
      var $content = jQuery('.master-widget-list-video').html();
      $html += $content;
    });
    $html +=  '</div>';
    $widget.find('.master-widget-ipad-video').html($html);
  }

// -------------------------------
// Video
// -------------------------------
  var videos = jQuery('.master-widget-list-video');
  if(videos.length) {
    jQuery.each(videos, function(index , item) {
      var current_video = jQuery(this).find('.video');
      var current_content = jQuery(this).find('.master-video-content');

      var sync1 = jQuery(".video");
      var sync2 = jQuery(".master-video-content");

      var is_singleItem = ('true' == current_video.attr('data-singleItem')) ? true : false;
      var is_navigation = ('true' == current_video.attr('data-navigation')) ? true : false;
      var is_pagination = ('true' == current_video.attr('data-pagination')) ? true : false;

      var is_pagination = ('true' == current_content.attr('data-pagination')) ? true : false;

      var slideSpeed = ('' != current_video.attr('data-slideSpeed') && undefined != current_video.attr('data-slideSpeed')) ? current_video.attr('data-slideSpeed') : 1000;
        slideSpeed =   parseInt(slideSpeed, 10);

      var RefreshRate = ('' != current_video.attr('data-RefreshRate') && undefined != current_video.attr('data-RefreshRate')) ? current_video.attr('data-RefreshRate') : 200;
        RefreshRate =   parseInt(RefreshRate, 10);

      var items = ('' != current_content.attr('data-items') && undefined != current_content.attr('data-items')) ? current_content.attr('data-items') : 1;
        items =   parseInt(items, 10);

      var slideSpeed = ('' != current_content.attr('data-slideSpeed') && undefined != current_content.attr('data-slideSpeed')) ? current_content.attr('data-slideSpeed') : 1000;
        slideSpeed =   parseInt(slideSpeed, 10);

      var RefreshRate = ('' != current_content.attr('data-RefreshRate') && undefined != current_content.attr('data-RefreshRate')) ? current_content.attr('data-RefreshRate') : 200;
        RefreshRate =   parseInt(RefreshRate, 10);

      sync1.owlCarousel({
        singleItem : is_singleItem,
        slideSpeed : slideSpeed,
        navigation : is_navigation,
        pagination : is_pagination,
        afterAction: syncPosition,
        mouseDrag : false,
        responsiveRefreshRate : RefreshRate,
      });

      sync2.owlCarousel({
        items : items,
        itemsDesktop      : [1199,1],
        itemsDesktopSmall : [979,1],
        itemsTablet       : [768,1],
        itemsMobile       : [479,1],
        mouseDrag : false,
        slideSpeed : slideSpeed,
        pagination:is_pagination,
        responsiveRefreshRate : RefreshRate,
        afterInit : function(el){
          el.find(".owl-item").eq(0).addClass("synced");
        }
      });

      function syncPosition(el){
        var current = this.currentItem;
        jQuery(".master-video-content")
          .find(".owl-item")
          .removeClass("synced")
          .eq(current)
          .addClass("synced")
        if(jQuery(".master-video-content").data("owlCarousel") !== undefined){
          center(current)
        }

      }

      jQuery(".master-video-content").on("click", ".owl-item", function(e){
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync1.trigger("owl.goTo",number);
      });

      function center(number){
        var sync2visible = sync2.data("owlCarousel").owl.visibleItems;

        var num = number;
        var found = false;
        for(var i in sync2visible){
          if(num === sync2visible[i]){
            var found = true;
          }
      }

      if(found===false){
        if(num>sync2visible[sync2visible.length-1]){
          sync2.trigger("owl.goTo", num - sync2visible.length+2)
        }else{
          if(num - 1 === -1){
              num = 0;
            }
            sync2.trigger("owl.goTo", num);
          }
        } else if(num === sync2visible[sync2visible.length-1]){
          sync2.trigger("owl.goTo", sync2visible[1])
        } else if(num === sync2visible[0]){
         sync2.trigger("owl.goTo", num-1)
        }
      } 
    });
  }

// -------------------------------
// Slide home 2
// -------------------------------
  var slider2home2 = jQuery('.master-article-thum-large');
  if(slider2home2.length) {
    jQuery.each(slider2home2, function(index , item) {
      var current_slider2 = jQuery(this).find('.owl-carousel');

      var is_lazyLoad = ('true' == current_slider2.attr('data-lazyLoad')) ? true : false;
      var is_navigation = ('true' == current_slider2.attr('data-navigation')) ? true : false;

      var items = ('' != current_slider2.attr('data-items') && undefined != current_slider2.attr('data-items')) ? current_slider2.attr('data-items') : 1;
        items =   parseInt(items, 10);

      current_slider2.owlCarousel({
        items : items,
        lazyLoad : is_lazyLoad,
        navigation : is_navigation,
        itemsDesktop      : [1199,1],
        itemsDesktopSmall : [979,1],
        itemsTablet       : [768,1],
        itemsMobile       : [479,1],
      });
    });
  }
  
// --------------------------------
// 4- Bootstrap Carousel
// --------------------------------
  var sliderhome2 = jQuery('.carousel');
  if(sliderhome2.length) {
    jQuery.each(sliderhome2 , function(index , item) {
      var current_sliderhome2 = jQuery(this).find('.carousel');

      current_sliderhome2.carousel();
    });
  }


// -------------------------------
// 5- Breadking News
// -------------------------------
  var tickers = jQuery('.master-top-right');
  var ticker_ipad = jQuery('.master-breaking');
  if(tickers.length) {
    jQuery.each(tickers, function(index , item) {
      var current_ticker = jQuery(this).find('.js-hidden');

      current_ticker.ticker();
    });
  }
  if(ticker_ipad.length) {
    jQuery.each(ticker_ipad, function(index , item) {
      var current_ticker = jQuery(this).find('.js-news2');

      current_ticker.ticker();
    });
  }

// -------------------------------
// 6- Bootstrap Popup
// -------------------------------
  var login = jQuery('.master-top-right');
  if(login.length) {
    jQuery.each(login, function(index, item) {
      var current_login = jQuery(this).find('.modal');
        current_login.on('shown.bs.modal' , function() {
          current_login.focus();
        });
        
      });
  }



// -------------------------------
// 7- PrettyPhoto
// -------------------------------
  var gallery = jQuery('.master-gallery');
  if(gallery.length) {
    jQuery.each(gallery, function(index , item) {
      var current_gallery = jQuery(this).find('.owl-carousel');

      var is_lazyLoad = ('true' == current_gallery.attr('data-lazyLoad')) ? true : false;
      var is_navigation = ('true' == current_gallery.attr('data-navigation')) ? true : false;

      var items = ('' != current_gallery.attr('data-items') && undefined != current_gallery.attr('data-items')) ? current_gallery.attr('data-items') : 1;
        items =   parseInt(items, 10);

      current_gallery.owlCarousel({
        items : items,
        lazyLoad : is_lazyLoad,
        navigation : true,
        itemsDesktop      : [1199,1],
        itemsDesktopSmall : [979,1],
        itemsTablet       : [768,1],
        itemsMobile       : [479,1],
      });
      jQuery("area[rel^='prettyPhoto']").prettyPhoto();
  
      jQuery(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:30000, autoplay_slideshow: true});
      jQuery(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:100000, hideflash: true});

      jQuery("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
        custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
        changepicturecallback: function(){ initialize(); }
      });

      jQuery("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
        custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
        changepicturecallback: function(){ _bsap.exec(); }
      });
    });
  }

  var $widget = jQuery('.master-custom-section-1 .master-custom-left');

  if($widget.length) {
    var $tab_titles = $widget.find('.nav-tabs > li > a');
    var $html = '';
    $html += '<ul>';

    jQuery.each($tab_titles, function() {
      var $title      = jQuery(this).text();
      var $content_id = jQuery(this).attr('href');
      var $content    = jQuery($content_id).html();

      $html +=  '<li class="has-sub active">';
      $html +=  '<a href="#"><span>'+ $title +'</span></a>';
      $html +=  '<ul>';
      $html +=  $content;
      $html +=  '</ul>';
      $html +=  '</li>';
    });

    $html +=  '</ul>';
    $widget.find('.master-widget-menu-vertical-left .cssmenu').html($html);
  }

// -------------------------------
// 8- Slider Pro
// -------------------------------
  var sliderpro = jQuery('.master-tag-article-content');
  if(sliderpro.length) {
    jQuery.each(sliderpro , function(index , item) {
      var current_sliderpro = jQuery(this).find('.slider-pro');

      current_sliderpro.sliderPro({
        orientation: 'vertical',
        loop: false,
        arrows: true,
        buttons: false,
        thumbnailsPosition: 'right',
        thumbnailPointer: true,
        thumbnailWidth: 380,
        breakpoints: {
          500: {
            thumbnailsPosition: 'bottom',
            thumbnailWidth: 120,
            thumbnailHeight: 50
          },
          800: {
            thumbnailsPosition: 'bottom',
            thumbnailWidth: 270,
            thumbnailHeight: 100
          }
          
        }
      });
    });
  }

  
// -------------------------------
// 9- Bootstrap Tab
// -------------------------------
  var mytabs = jQuery('.master-widget-category3-tab');
  if(mytabs.length) {
    jQuery.each(mytabs , function(index , item) {
      var current_mytab = jQuery(this).find('.nav-tabs');

      current_mytab.on('click' , 'a', function(e) {
        e.preventDefault();
        jQuery(this).tab('show');
      });
    });
  }

// -------------------------------
// 10- UISearch
// -------------------------------
  new UISearch(document.getElementById('sb-search'));
  new UISearch(document.getElementById('ipad-search'));

// -------------------------------
// 11- Accordion & Toggle
// -------------------------------

  var elementMenu = jQuery('.master-widget-menu-vertical-left');
  if(elementMenu.length) {
    jQuery.each(elementMenu , function(index , item) {
      var current_elementMenu = jQuery(this).find('.cssmenu > ul > li > a');
      current_elementMenu.on('click', function(e) {

        e.preventDefault();
        $('.cssmenu li').removeClass('active');
        $(this).closest('li').addClass('active'); 
        var checkElement = $(this).next();
        if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
          $(this).closest('li').removeClass('active');
          checkElement.slideUp('normal');
        }
        if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
          $('.cssmenu ul ul:visible').slideUp('normal');
          checkElement.slideDown('normal');
        }
        if($(this).closest('li').find('ul').children().length == 0) {
          return true;
        } else {
          return false; 
        }   
      });
    });
  }

  var elementMenu = jQuery('.master-widget-menu-vertical-right');
  if(elementMenu.length) {
    jQuery.each(elementMenu , function(index , item) {
      var current_elementMenu2 = jQuery(this).find('.cssmenu2 > ul > li > a');
      
      current_elementMenu2.on('click', function(e) {
        
        e.preventDefault();
        $('.cssmenu2 li').removeClass('active');
        $(this).closest('li').addClass('active'); 
        var checkElement = $(this).next();
        if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
          $(this).closest('li').removeClass('active');
          checkElement.slideUp('normal');
        }
        if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
          checkElement.slideDown('normal');
        }
        if($(this).closest('li').find('ul').children().length == 0) {
          return true;
        } else {
          return false; 
        }   
      });
    });
  }

// -------------------------------
// 12- Back to top
// -------------------------------

  // browser window scroll (in pixels) after which the "back to top" link is shown
  var offset = 300,
    //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
    offset_opacity = 1200,
    //duration of the top scrolling animation (in ms)
    scroll_top_duration = 700,
    //grab the "back to top" link
    $back_to_top = $('.cd-top');

  //hide or show the "back to top" link
  jQuery(window).scroll(function(){
    ( jQuery(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
    if( $(this).scrollTop() > offset_opacity ) { 
      $back_to_top.addClass('cd-fade-out');
    }
  });

  //smooth scroll to top
  $back_to_top.on('click', function(event){
    event.preventDefault();
    jQuery('body,html').animate({
      scrollTop: 0 ,
      }, scroll_top_duration
    );
  });

});






