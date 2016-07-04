/********************************************************
 *
 * Custom Javascript code for Enkel Bootstrap theme
 * Written by Themelize.me (http://themelize.me)
 *
 *******************************************************/
$(document).ready(function() {
  
  // Bootstrap tooltip
  // ----------------------------------------------------------------
  // invoke by adding _tooltip to a tags (this makes it validate)
  $('body').tooltip({
    selector: "a[class*=_tooltip]"
  });
    
  // Bootstrap popover
  // ----------------------------------------------------------------
  // invoke by adding _popover to a tags (this makes it validate)
  $('body').popover({
    selector: "a[class*=_popover]",
    trigger: "hover"
  });

  // colour switch
  // ----------------------------------------------------------------
  $('.colour-switcher a').click(function() {
    var c = $(this).attr('href').replace('#','');
    var cacheBuster = 4 * Math.floor(Math.random() * 6);
    $('.colour-switcher a').removeClass('active');
    $('.colour-switcher a.'+ c).addClass('active');
    $('#colour-scheme').attr('href','css/colour-'+ c +'.css?x='+ cacheBuster);
  });
  
  //flexslider
  // ----------------------------------------------------------------
  $('.flexslider').each(function() {
    var sliderSettings =  {
      animation: $(this).attr('data-transition'),
      selector: ".slides > .slide",
      controlNav: true,
      smoothHeight: true,
      animationLoop: false,
    };
    
    var sliderNav = $(this).attr('data-slidernav');
    if (sliderNav !== 'auto') {
      sliderSettings = $.extend({}, sliderSettings, {
        manualControls: sliderNav +' li a',
        controlsContainer: '.flexslider-wrapper'
      });
    }
    
    $(this).flexslider(sliderSettings);
  });

  // jQuery Isotope Plugin
  // ----------------------------------------------------------------
  var $filters = $('#quicksand-categories');
  var $holder = $('ul#quicksand');
  
  if ($holder.length > 0) {
    $holder.isotope(
    {
      animationOptions:
      {
        animationEngine: 'best-available',
        duration: 750,
        easing: 'linear',
        queue: false
      }
    });
    
    // If imagesLoaded avaliable use it
    if (jQuery().imagesLoaded) {
      $holder.imagesLoaded( function() {
        $holder.isotope('layout');
      });
    }
    
    $('body').addClass('has-isotope');
    
    $filters.find('li a').click(function()
    {
      $filters.find('li').removeClass('active');
      var $filterType = $(this).attr('href');
      $filterType = $filterType.substr(1);
      $(this).parent().addClass('active');
      var selector = 'li[data-type=' + $filterType + ']';
  
       if ($filterType === 'all') {
        selector = 'li';
      }

      $holder.isotope({filter: selector});
      return false;
    });
  }

});