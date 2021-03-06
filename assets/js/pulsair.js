/*! Pulsair Theme - v0.1.0
 * http://www.pulsair.com/
 * Copyright (c) 2016; * Licensed GPL-2.0+ */
/*!
 * FitVids 1.1
 *
 * Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
 * Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
 * Released under the WTFPL license - http://sam.zoy.org/wtfpl/
 *
 */

;(function( $ ){

    'use strict';

    $.fn.fitVids = function( options ) {
        var settings = {
            customSelector: null,
            ignore: null
        };

        if(!document.getElementById('fit-vids-style')) {
            // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
            var head = document.head || document.getElementsByTagName('head')[0];
            var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
            var div = document.createElement("div");
            div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
            head.appendChild(div.childNodes[1]);
        }

        if ( options ) {
            $.extend( settings, options );
        }

        return this.each(function(){
            var selectors = [
                'iframe[src*="player.vimeo.com"]',
                'iframe[src*="youtube.com"]',
                'iframe[src*="youtube-nocookie.com"]',
                'iframe[src*="kickstarter.com"][src*="video.html"]',
                'object',
                'embed'
            ];

            if (settings.customSelector) {
                selectors.push(settings.customSelector);
            }

            var ignoreList = '.fitvidsignore';

            if(settings.ignore) {
                ignoreList = ignoreList + ', ' + settings.ignore;
            }

            var $allVideos = $(this).find(selectors.join(','));
            $allVideos = $allVideos.not('object object'); // SwfObj conflict patch
            $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

            $allVideos.each(function(){
                var $this = $(this);
                if($this.parents(ignoreList).length > 0) {
                    return; // Disable FitVids on this video.
                }
                if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
                if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width'))))
                {
                    $this.attr('height', 9);
                    $this.attr('width', 16);
                }
                var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
                    width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
                    aspectRatio = height / width;
                if(!$this.attr('name')){
                    var videoName = 'fitvid' + $.fn.fitVids._count;
                    $this.attr('name', videoName);
                    $.fn.fitVids._count++;
                }
                $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+'%');
                $this.removeAttr('height').removeAttr('width');
            });
        });
    };

    // Internal counter for unique video names.
    $.fn.fitVids._count = 0;

// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );
( function( $, window, undefined ) {
	'use strict';

	var document = window.document;

	var elems = {
		imgfit: document.querySelectorAll('.img-fit')
	};
	
	imgFit();

	/**
	 *  fallback for object-fit elements - background images
	 */
	function imgFit(){

		if ( ! Modernizr.objectfit ) {
			var elements = elems.imgfit;
			for (var i = 0; i < elements.length; i++){
				if(hasClass(elements[i], 'compat-object-fit')){
					// do nothing
				} else {
					var el = elements[i],
						fbimg = el.getElementsByTagName('img').attr(data-fallback-img);

					if(fbimg !== '') {
						el.classList.add('compat-object-fit');
						el.style.backgroundImage = 'url("' + fbimg + '")';
					}
				}

			}
		}
	}

	/**
	 * Fitvids
     */
	function fitVideo() {
		$(".video, .tm-vid, .puls-video").fitVids();
		$("#content").fitVids();
	}

	/**
	 *  hasClass, takes two params: element and classname
	 * @param element
	 * @param classname
	 * @returns {string|*|boolean}
	 */
	function hasClass(el, cls) {
		return el.className && new RegExp("(\\s|^)" + cls + "(\\s|$)").test(el.className);
	}

	var tabScrollToParent = function() {

	   var trigger = '.puls-tab-item__close';

	   $('body').on('click', trigger, function(e) {
	       var target = $(this.hash),
	           tabId = $(this).data('tab-id'),
	           tabItem = $('#' + tabId);
	       tabTab = $('a[href=#' + tabId + ']');

	       tabItem.removeClass('sr-active');
	       tabTab.removeClass('sr-active');

	       // (tabId, tabTab).removeClass('sr-active');

	       if (target.length) {
	           $('html,body').animate({
	               scrollTop: target.offset().top
	           }, 1000);
	           // return false;
	       }

	   });
	};

	var tabsTabActive = function(){
	   var trigger = '.puls-tabs__tab-link',
	       scrollTarget = '';

	   //$('body').find('.puls-tabs-container').parents('.section-inner').css('padding', '0px');

	   $('body').on('click', trigger, function(evt) {
	       evt.preventDefault();
	       var target = $(this.hash),
	           tabs = '.puls-tab-item, .puls-tabs__tab a';
	       $(tabs).removeClass('sr-active');
	       $(this).addClass('sr-active');
	       target.addClass('sr-active');
	       //if (matchMedia('only screen and (min-width: 768px)').matches) {
	       //    scrollTarget = target.closest('.section-inner');
	       //} else {
	       //    scrollTarget = target.parents('.puls-tabs-container').find('.panel-container');
	       //}

	       //$('#outer-wrap').animate({
	       //    scrollTop: scrollTarget.offset().top
	       //}, 1000);

	       var scrollTarg = $('.puls-tabs');
		   $('html,body').animate({
				   scrollTop: scrollTarg.offset().top},
			   'slow');

	   });
	};

	var pulsTabOpen = function(){
	   $('body').find('.puls-tabs:first').find('.puls-tabs__tab-link:first, .puls-tab-item:first').addClass('sr-active');
	};

	$(document).ready(function( $ ) {
		tabScrollToParent();
		tabsTabActive();
		pulsTabOpen();
		fitVideo();
	});


} )( jQuery, window );
