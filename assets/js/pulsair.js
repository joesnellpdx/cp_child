/*! Pulsair Theme - v0.1.0
 * http://www.pulsair.com/
 * Copyright (c) 2016; * Licensed GPL-2.0+ */
( function( window, undefined ) {
	'use strict';

	var document = window.document;

	var elems = {
		html: document.getElementById('html'),
		pnmenu: document.getElementById('pn-menu__items'),
		body: document.body,
		menuToggle: document.querySelectorAll('.pn-menu__toggle'),
		menuMask: document.querySelector('.pn-menu__mask'),
		menuSubOpen: document.querySelectorAll('.pn-menu__items > .menu-item-has-children > a'),
		menuSubClose: document.querySelector('.pm-menu__subnav-close a'),
		imgfit: document.querySelectorAll('.img-fit'),
	};

	triggerMenuToggle();
	triggerSubNav();
	fadeInImages();
	subNavCloseTrigger();
	imgFit();

	/**
	 * Menu toggle element action
	 */
	function triggerMenuToggle(){
		var elements = elems.menuToggle;
		for (var i = 0; i < elements.length; i++){
			elements[i].addEventListener('click', toggleMenu);
		}
	}

	/**
	 * Toggle the menu
	 * Open if closed, close if opened.
	 * Accomplished by adding and removing the class .is-open
	 */
	function toggleMenu(e) {
		e.preventDefault();

		var el = elems.html,
			className = 'js-nav-open',
			menuToggle = elems.menuToggle;

		for (var i = 0; i < menuToggle.length; i++){
			var ariaToggle = menuToggle[i].getAttribute('aria-expanded');

			if(ariaToggle === 'false'){
				menuToggle[i].setAttribute('aria-expanded', 'true');
			} else {
				menuToggle[i].setAttribute('aria-expanded', 'false');
			}
		}

		if (el.classList) {
			if(hasClass(el,className)){
				subNavClose(elems.menuSubClose);
			}
			el.classList.toggle(className);
		} else {
			var classes = el.className.split(' ');
			var existingIndex = classes.indexOf(className);

			if (existingIndex >= 0)
				classes.splice(existingIndex, 1);
			else
				classes.push(className);

			el.className = classes.join(' ');
		}
	}

	/**
	 * Menu sub-navigation element action
	 */
	function triggerSubNav(){
		var elements = elems.menuSubOpen;
		for (var i = 0; i < elements.length; i++){
			elements[i].addEventListener('click', toggleSubMenu, false);
		}
	}

	/**
	 * Toggle the sub-menu
	 * Open if closed, close if opened.
	 * Accomplished by adding and removing the class .is-open
	 */
	function toggleSubMenu(e) {
		var subNavClass = 'menu-item-has-children--open',
			pnmenuSubOpen = 'js-subnav-open',
			subNavLi = e.currentTarget.parentNode;

		e.preventDefault();
		subNavLi.classList.add(subNavClass);
		elems.pnmenu.classList.add(pnmenuSubOpen);
	}

	function subNavCloseTrigger(){
		elems.menuSubClose.addEventListener('click', subNavClose, false);
	}

	function subNavClose(e){
		var subNavOpen = document.querySelectorAll('.menu-item-has-children--open'),
			subNavClass = 'menu-item-has-children--open',
			pnmenuSubOpen = 'js-subnav-open';
		
		if(e.currentTarget){
			e.preventDefault();
		}

		for (var i = 0; i < subNavOpen.length; i++){
			subNavOpen[i].classList.remove(subNavClass);
		}
		elems.pnmenu.classList.remove(pnmenuSubOpen);
	}

	/**
	 * Fade in images with imagesloaded.js
	 * @link http://imagesloaded.desandro.com/
	 */
	function fadeInImages(){
		imagesLoaded( document.body, function( instance ) {
			document.body.className += ' ' + 'js-images-loaded';
		});
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

} )( this );