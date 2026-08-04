/**
 * Switch the front-page header from a hero overlay to a readable sticky bar.
 */
( () => {
	'use strict';

	const header = document.querySelector( '.front-page-overlay-header' );
	const hero = header?.nextElementSibling;

	if ( ! header || ! hero ) {
		return;
	}

	let frameRequested = false;

	const updateHeader = () => {
		const headerHeight = header.getBoundingClientRect().height;
		const heroBottom = hero.getBoundingClientRect().bottom;

		header.classList.toggle( 'is-past-hero', heroBottom <= headerHeight );
		frameRequested = false;
	};

	const requestUpdate = () => {
		if ( frameRequested ) {
			return;
		}

		frameRequested = true;
		window.requestAnimationFrame( updateHeader );
	};

	window.addEventListener( 'scroll', requestUpdate, { passive: true } );
	window.addEventListener( 'resize', requestUpdate );
	updateHeader();
} )();
