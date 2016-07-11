/**
 * Pulsair
 * http://www.pulsair.com/
 *
 * Copyright (c) 2016 Joe Snell
 * Licensed under the GPL-2.0+ license.
 *
 * Theme functions file.
 */

( function( window, undefined ) {
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

} )( this );