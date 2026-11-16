/**
 * Slogan banner on the home page.
 * - Keeps the loop seamless on any screen. The band scrolls by half its track, so each half has to be wider than the
 *   band, or the end of the slogans shows before the loop restarts. The page prints enough copies for most screens;
 *   this adds more on wide screens or when zoomed out.
 * - Keeps the same speed whatever the slogans' length, by setting the scroll time from the track's length.
 * - Shows the round Pause button and switches the scrolling off and on (WCAG 2.2.2 Pause, Stop, Hide). The button
 *   stays hidden without JavaScript, and CSS hides it when the visitor prefers reduced motion (nothing moves then).
 */
( function () {
	const banner = document.querySelector( '.slogan-banner' );
	const toggle = banner ? banner.querySelector( '.slogan-banner__toggle' ) : null;

	if ( ! toggle ) {
		return;
	}

	const band = banner.querySelector( '.slogan-banner__band' );
	const track = banner.querySelector( '.slogan-banner__track' );
	const first = track.querySelector( '.slogan-banner__list' );
	const label = toggle.querySelector( '.screen-reader-text' );
	const speed = 60; // Pixels per second.

	function addCopy() {
		const copy = first.cloneNode( true );
		copy.setAttribute( 'aria-hidden', 'true' );
		track.append( copy );
	}

	function fill() {
		const listWidth = first.offsetWidth;

		if ( ! listWidth ) {
			return;
		}

		// Copies go in pairs so both halves of the track stay identical.
		while ( ( track.children.length / 2 ) * listWidth < band.offsetWidth + listWidth ) {
			addCopy();
			addCopy();
		}

		track.style.animationDuration = ( ( track.children.length / 2 ) * listWidth ) / speed + 's';
	}

	// Runs once now, then again whenever the band or the slogans change size (resize, zoom, web font loading).
	if ( 'ResizeObserver' in window ) {
		const observer = new ResizeObserver( fill );
		observer.observe( band );
		observer.observe( first );
	} else {
		fill();
	}

	toggle.hidden = false;
	toggle.addEventListener( 'click', function () {
		const paused = banner.classList.toggle( 'is-paused' );
		label.textContent = paused ? toggle.dataset.labelPlay : toggle.dataset.labelPause;
	} );
}() );
