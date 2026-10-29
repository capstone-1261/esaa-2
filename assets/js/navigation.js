/**
 * Header navigation: the mobile Menu panel, submenu toggles (Articles) and the desktop search panel.
 * Loaded with defer. Without JavaScript the whole menu stays visible (see header.css).
 */
( function () {
	const header = document.querySelector( '.site-header' );
	if ( ! header ) {
		return;
	}

	// Must match the 60em breakpoint in header.css.
	const desktop = window.matchMedia( '(min-width: 60em)' );
	const menuToggle = header.querySelector( '.menu-toggle' );
	const menuLabel = menuToggle ? menuToggle.querySelector( '.menu-toggle__label' ) : null;
	const searchWrap = header.querySelector( '.site-search' );
	const searchToggle = header.querySelector( '.search-toggle' );
	const submenus = [];

	// Backdrop behind the open mobile panel: tapping it closes the menu.
	const backdrop = document.createElement( 'div' );
	backdrop.className = 'menu-backdrop';
	backdrop.hidden = true;
	header.after( backdrop );

	/* Submenus (Articles) */

	function setSubmenu( item, open ) {
		item.classList.toggle( 'is-open', open );
		item.querySelector( ':scope > .submenu-toggle' ).setAttribute( 'aria-expanded', String( open ) );
	}

	header.querySelectorAll( '.submenu-toggle' ).forEach( function ( button, index ) {
		const item = button.closest( 'li' );
		const list = item.querySelector( ':scope > .sub-menu' );
		if ( ! list ) {
			return;
		}
		list.id = list.id || 'submenu-' + ( index + 1 );
		button.setAttribute( 'aria-controls', list.id );
		submenus.push( { item: item, button: button } );

		button.addEventListener( 'click', function () {
			setSubmenu( item, button.getAttribute( 'aria-expanded' ) !== 'true' );
		} );

		// Desktop dropdown closes when keyboard focus moves out of it.
		item.addEventListener( 'focusout', function ( event ) {
			if ( desktop.matches && ! item.contains( event.relatedTarget ) ) {
				setSubmenu( item, false );
			}
		} );

		// Escape hides a hover-opened dropdown until the pointer leaves it.
		item.addEventListener( 'pointerleave', function () {
			item.classList.remove( 'is-hover-suppressed' );
		} );
	} );

	/* Mobile menu panel */

	function isMenuOpen() {
		return !! menuToggle && menuToggle.getAttribute( 'aria-expanded' ) === 'true';
	}

	// The menu panel and the search bar both cover the page: dim it, lock scrolling, and put everything
	// outside the header out of reach until they close.
	function coverPage( open ) {
		document.documentElement.classList.toggle( 'page-covered', open );
		backdrop.hidden = ! open;
		document.querySelectorAll( 'body > *:not(.site-header):not(.menu-backdrop):not(script)' ).forEach( function ( element ) {
			element.inert = open;
		} );
	}

	function setMenu( open, returnFocus ) {
		if ( ! menuToggle ) {
			return;
		}
		menuToggle.setAttribute( 'aria-expanded', String( open ) );
		menuLabel.textContent = open ? menuToggle.dataset.labelClose : menuToggle.dataset.labelOpen;
		document.documentElement.classList.toggle( 'menu-open', open );
		coverPage( open );

		// Open the current section's submenu (for example Articles on a zine page), close the rest.
		submenus.forEach( function ( submenu ) {
			setSubmenu( submenu.item, open && submenu.item.matches( '.current-menu-ancestor, .current-menu-parent' ) );
		} );

		if ( ! open && returnFocus ) {
			menuToggle.focus();
		}
	}

	if ( menuToggle ) {
		menuToggle.addEventListener( 'click', function () {
			setMenu( ! isMenuOpen(), false );
		} );
	}

	backdrop.addEventListener( 'click', function () {
		if ( isMenuOpen() ) {
			setMenu( false, true );
		} else {
			setSearch( false, true );
		}
	} );

	/* Desktop search panel */

	function setSearch( open, returnFocus ) {
		if ( ! searchToggle || open === searchWrap.classList.contains( 'is-open' ) ) {
			return;
		}
		searchToggle.setAttribute( 'aria-expanded', String( open ) );
		searchWrap.classList.toggle( 'is-open', open );
		coverPage( open );

		if ( open ) {
			const field = searchWrap.querySelector( 'input[type="search"]' );
			if ( field ) {
				field.focus();
			}
		} else if ( returnFocus ) {
			searchToggle.focus();
		}
	}

	if ( searchToggle ) {
		searchToggle.addEventListener( 'click', function () {
			setSearch( searchToggle.getAttribute( 'aria-expanded' ) !== 'true', false );
		} );

		searchWrap.addEventListener( 'focusout', function ( event ) {
			if ( desktop.matches && ! searchWrap.contains( event.relatedTarget ) ) {
				setSearch( false, false );
			}
		} );
	}

	/* Escape closes the innermost open thing and puts focus back on the button that opened it. */

	document.addEventListener( 'keydown', function ( event ) {
		if ( event.key !== 'Escape' ) {
			return;
		}

		const openSubmenu = submenus.find( function ( submenu ) {
			return submenu.item.classList.contains( 'is-open' ) && submenu.item.contains( document.activeElement );
		} );

		if ( openSubmenu ) {
			setSubmenu( openSubmenu.item, false );
			openSubmenu.button.focus();
		} else if ( searchWrap && searchWrap.classList.contains( 'is-open' ) ) {
			setSearch( false, true );
		} else if ( isMenuOpen() ) {
			setMenu( false, true );
		} else {
			header.querySelectorAll( '.menu-item-has-children:hover' ).forEach( function ( item ) {
				item.classList.add( 'is-hover-suppressed' );
			} );
		}
	} );

	/* Desktop: a click anywhere else closes an open dropdown or the search panel. */

	document.addEventListener( 'click', function ( event ) {
		if ( ! desktop.matches ) {
			return;
		}
		submenus.forEach( function ( submenu ) {
			if ( ! submenu.item.contains( event.target ) ) {
				setSubmenu( submenu.item, false );
			}
		} );
		if ( searchWrap && ! searchWrap.contains( event.target ) ) {
			setSearch( false, false );
		}
	} );

	/* Start fresh when the layout switches between the mobile panel and the desktop bar. */

	desktop.addEventListener( 'change', function () {
		setMenu( false, false );
		setSearch( false, false );
		submenus.forEach( function ( submenu ) {
			setSubmenu( submenu.item, false );
		} );
	} );
}() );
