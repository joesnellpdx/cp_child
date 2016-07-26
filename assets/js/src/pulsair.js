/**
 * Pulsair
 * http://www.pulsair.com/
 *
 * Copyright (c) 2016 Joe Snell
 * Licensed under the GPL-2.0+ license.
 *
 * Theme functions file.
 */

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
	});


} )( jQuery, window );
