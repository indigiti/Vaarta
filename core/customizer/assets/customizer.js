/*===============================================================
# 1. Init Customizer
===============================================================*/

var cscoCustomizer = {

	initialized: false,

	/**
	 * Initialize the object.
	 *
	 * @since 3.0.17
	 * @returns {null}
	 */
	initialize: function() {
		var self = this;

		// We only need to initialize once.
		if ( self.initialized ) {
			return;
		}

		setTimeout( function() {
			cscoCustomizer.util.webfonts.standard.initialize();
			cscoCustomizer.util.webfonts.google.initialize();
		}, 150 );

		// Mark as initialized.
		self.initialized = true;
	}
};

cscoCustomizer.initialize();

var cscoCustomizer = cscoCustomizer || {};

cscoCustomizer = jQuery.extend( cscoCustomizer, {
	/**
	 * A collection of utility methods.
	 *
	 * @since 3.0.17
	 */
	util: {

		/**
		 * A collection of utility methods for webfonts.
		 *
		 * @since 3.0.17
		 */
		webfonts: {

			/**
			 * Google-fonts related methods.
			 *
			 * @since 3.0.17
			 */
			google: {

				/**
				 * An object containing all Google fonts.
				 *
				 * to set this call this.setFonts();
				 *
				 * @since 3.0.17
				 */
				fonts: {},

				/**
				 * Init for google-fonts.
				 *
				 * @since 3.0.17
				 * @returns {null}
				 */
				initialize: function() {
					var self = this;

					self.setFonts();
				},

				/**
				 * Set fonts in this.fonts
				 *
				 * @since 3.0.17
				 * @returns {null}
				 */
				setFonts: function() {
					var self = this;

					// No need to run if we already have the fonts.
					if ( !_.isEmpty( self.fonts ) ) {
						return;
					}

					// Make an AJAX call to set the fonts object (alpha).
					jQuery.post( ajaxurl, { 'action': 'csco_typography_fonts_google_all_get' }, function( response ) {

						// Get fonts from the JSON array.
						self.fonts = JSON.parse( response );

						// Convert array to object.
						if ( Array.isArray( self.fonts.items ) ) {
							let fontsBuffer = {};

							self.fonts.items.forEach(font => {
								fontsBuffer[font.family] = font;
							});

							self.fonts.items = fontsBuffer;
						}
					} );
				},

				/**
				 * Gets all properties of a font-family.
				 *
				 * @since 3.0.17
				 * @param {string} family - The font-family we're interested in.
				 * @returns {Object}
				 */
				getFont: function( family ) {
					var self = this,
						fonts = self.getFonts();

					if ( 'undefined' === typeof fonts[ family ] ) {
						return false;
					}
					return fonts[ family ];
				},

				/**
				 * Gets all properties of a font-family.
				 *
				 * @since 3.0.17
				 * @param {string} order - How to order the fonts (alpha|popularity|trending).
				 * @param {int}    number - How many to get. 0 for all.
				 * @returns {Object}
				 */
				getFonts: function( order, category, number ) {
					var self = this,
						ordered = {},
						categorized = {},
						plucked = {};

					// Make sure order is correct.
					order = order || 'alpha';
					order = ( 'alpha' !== order && 'popularity' !== order && 'trending' !== order ) ? 'alpha' : order;

					// Make sure number is correct.
					number = number || 0;
					number = parseInt( number, 10 );

					// Order fonts by the 'order' argument.
					if ( 'alpha' === order ) {
						ordered = jQuery.extend( {}, self.fonts.items );
					} else {
						_.each( self.fonts.order[ order ], function( family ) {
							ordered[ family ] = self.fonts.items[ family ];
						} );
					}

					// If we have a category defined get only the fonts in that category.
					if ( '' === category || !category ) {
						categorized = ordered;
					} else {
						_.each( ordered, function( font, family ) {
							if ( category === font.category ) {
								categorized[ family ] = font;
							}
						} );
					}

					// If we only want a number of font-families get the 1st items from the results.
					if ( 0 < number ) {
						_.each( _.first( _.keys( categorized ), number ), function( family ) {
							plucked[ family ] = categorized[ family ];
						} );
						return plucked;
					}

					return categorized;
				},

				/**
				 * Gets the variants for a font-family.
				 *
				 * @since 3.0.17
				 * @param {string} family - The font-family we're interested in.
				 * @returns {Array}
				 */
				getVariants: function( family ) {
					var self = this,
						font = self.getFont( family );

					// Early exit if font was not found.
					if ( !font ) {
						return false;
					}

					// Early exit if font doesn't have variants.
					if ( _.isUndefined( font.variants ) ) {
						return false;
					}

					// Return the variants.
					return font.variants;
				}
			},

			/**
			 * Standard fonts related methods.
			 *
			 * @since 3.0.17
			 */
			standard: {

				/**
				 * An object containing all Standard fonts.
				 *
				 * to set this call this.setFonts();
				 *
				 * @since 3.0.17
				 */
				fonts: {},

				/**
				 * Init for google-fonts.
				 *
				 * @since 3.0.17
				 * @returns {null}
				 */
				initialize: function() {
					var self = this;

					self.setFonts();
				},

				/**
				 * Set fonts in this.fonts
				 *
				 * @since 3.0.17
				 * @returns {null}
				 */
				setFonts: function() {
					var self = this;

					// No need to run if we already have the fonts.
					if ( !_.isEmpty( self.fonts ) ) {
						return;
					}

					// Make an AJAX call to set the fonts object.
					jQuery.post( ajaxurl, { 'action': 'csco_typography_fonts_standard_all_get' }, function( response ) {

						// Get fonts from the JSON array.
						self.fonts = JSON.parse( response );
					} );
				},

				/**
				 * Gets the variants for a font-family.
				 *
				 * @since 3.0.17
				 * @returns {Array}
				 */
				getVariants: function() {
					return [ 'regular', 'italic', '700', '700italic' ];
				}
			},

			/**
			 * Figure out what this font-family is (google/standard)
			 *
			 * @since 3.0.20
			 * @param {string} family - The font-family.
			 * @returns {string|false} - Returns string if found (google|standard)
			 *                           and false in case the font-family is an arbitrary value
			 *                           not found anywhere in our font definitions.
			 */
			getFontType: function( family ) {
				var self = this;

				// Check for standard fonts first.
				if (
					'undefined' !== typeof self.standard.fonts[ family ] || (
						'undefined' !== typeof self.standard.fonts.stack &&
						'undefined' !== typeof self.standard.fonts.stack[ family ]
					)
				) {
					return 'standard';
				}

				// Check in googlefonts.
				if ( 'undefined' !== typeof self.google.fonts.items[ family ] ) {
					return 'google';
				}
				return false;
			}
		},

		/**
		 * Parses HTML Entities.
		 *
		 * @since 3.0.34
		 * @param {string} str - The string we want to parse.
		 * @returns {string}
		 */
		parseHtmlEntities: function( str ) {
			var parser = new DOMParser,
				dom = parser.parseFromString(
					'<!doctype html><body>' + str, 'text/html'
				);

			return dom.body.textContent;
		}
	}
} );

if ( _.isUndefined( window.cscoSetSettingValue ) ) {
	var cscoSetSettingValue = { // eslint-disable-line vars-on-top

		/**
		 * Set the value of the control.
		 *
		 * @since 3.0.0
		 * @param string setting The setting-ID.
		 * @param mixed  value   The value.
		 */
		set: function( setting, value ) {

			/**
			 * Get the control of the sub-setting.
			 * This will be used to get properties we need from that control,
			 * and determine if we need to do any further work based on those.
			 */
			var $this = this,
				subControl = wp.customize.settings.controls[ setting ],
				valueJSON;

			// If the control doesn't exist then return.
			if ( _.isUndefined( subControl ) ) {
				return true;
			}

			// First set the value in the wp object. The control type doesn't matter here.
			$this.setValue( setting, value );

			// Process visually changing the value based on the control type.
			switch ( subControl.type ) {
				case 'group-background':
					if ( ! _.isUndefined( value['background-color'] ) ) {
						$this.setColorPicker( $this.findElement( setting, '.csco-color-control' ), value['background-color'] );
					}
					$this.findElement( setting, '.placeholder, .thumbnail' ).removeClass().addClass( 'placeholder' ).html( 'No file selected' );
					_.each( [ 'background-repeat', 'background-position' ], function( subVal ) {
						if ( ! _.isUndefined( value[ subVal ] ) ) {
							$this.setSelectWoo( $this.findElement( setting, '.' + subVal + ' select' ), value[ subVal ] );
						}
					} );
					_.each( [ 'background-size', 'background-attachment' ], function( subVal ) {
						jQuery( $this.findElement( setting, '.' + subVal + ' input[value="' + value + '"]' ) ).prop( 'checked', true );
					} );
					valueJSON = JSON.stringify( value ).replace( /'/g, '&#39' );
					jQuery( $this.findElement( setting, '.background-hidden-value' ).attr( 'value', valueJSON ) ).trigger( 'change' );
					break;
				case 'color-alpha':
					$this.setColorPicker( $this.findElement( setting, '.color-alpha-control' ), value );
					break;
				case 'multicheck':
					$this.findElement( setting, 'input' ).each( function() {
						jQuery( this ).prop( 'checked', false );
					} );
					_.each( value, function( subValue, i ) {
						jQuery( $this.findElement( setting, 'input[value="' + value[ i ] + '"]' ) ).prop( 'checked', true );
					} );
					break;
				case 'radio':
					jQuery( $this.findElement( setting, 'input[value="' + value + '"]' ) ).prop( 'checked', true );
					break;

				case 'typography':
					_.each( [ 'font-family', 'variant' ], function( subVal ) {
						if ( ! _.isUndefined( value[ subVal ] ) ) {
							$this.setSelectWoo( $this.findElement( setting, '.' + subVal + ' select' ), value[ subVal ] );
						}
					} );
					_.each( [ 'font-size', 'line-height', 'letter-spacing', 'word-spacing' ], function( subVal ) {
						if ( ! _.isUndefined( value[ subVal ] ) ) {
							jQuery( $this.findElement( setting, '.' + subVal + ' input' ) ).prop( 'value', value[ subVal ] );
						}
					} );

					valueJSON = JSON.stringify( value ).replace( /'/g, '&#39' );
					jQuery( $this.findElement( setting, '.typography-hidden-value' ).attr( 'value', valueJSON ) ).trigger( 'change' );
					break;
				default:
					jQuery( $this.findElement( setting, 'input' ) ).prop( 'value', value );
			}
		},

		/**
		 * Set the value for colorpickers.
		 * CAUTION: This only sets the value visually, it does not change it in th wp object.
		 *
		 * @since 3.0.0
		 * @param object selector jQuery object for this element.
		 * @param string value    The value we want to set.
		 */
		setColorPicker: function( selector, value ) {
			selector.attr( 'data-default-color', value ).data( 'default-color', value ).wpColorPicker( 'color', value );
		},

		/**
		 * Sets the value in a selectWoo element.
		 * CAUTION: This only sets the value visually, it does not change it in th wp object.
		 *
		 * @since 3.0.0
		 * @param string selector The CSS identifier for this selectWoo.
		 * @param string value    The value we want to set.
		 */
		setSelectWoo: function( selector, value ) {
			jQuery( selector ).selectWoo().val( value ).trigger( 'change' );
		},

		/**
		 * Sets the value in textarea elements.
		 * CAUTION: This only sets the value visually, it does not change it in th wp object.
		 *
		 * @since 3.0.0
		 * @param string selector The CSS identifier for this textarea.
		 * @param string value    The value we want to set.
		 */
		setTextarea: function( selector, value ) {
			jQuery( selector ).prop( 'value', value );
		},

		/**
		 * Finds an element inside this control.
		 *
		 * @since 3.0.0
		 * @param string setting The setting ID.
		 * @param string element The CSS identifier.
		 */
		findElement: function( setting, element ) {
			return wp.customize.control( setting ).container.find( element );
		},

		/**
		 * Updates the value in the wp.customize object.
		 *
		 * @since 3.0.0
		 * @param string setting The setting-ID.
		 * @param mixed  value   The value.
		 */
		setValue: function( setting, value, timeout ) {
			timeout = ( _.isUndefined( timeout ) ) ? 100 : parseInt( timeout, 10 );
			wp.customize.instance( setting ).set( {} );
			setTimeout( function() {
				wp.customize.instance( setting ).set( value );
			}, timeout );
		}
	};
}

/*===============================================================
# 2. Control Background
===============================================================*/

wp.customize.controlConstructor['group-background'] = wp.customize.Control.extend( {

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this;

		// Init the control.
		if ( ! _.isUndefined( window.cscoControlLoader ) && _.isFunction( cscoControlLoader ) ) {
			cscoControlLoader( control );
		} else {
			control.initCSCOControl();
		}
	},

	initCSCOControl: function() {

		var control = this,
			value   = control.setting._value,
			picker  = control.container.find( '.csco-color-control' );

		// Hide unnecessary controls if the value doesn't have an image.
		if ( _.isUndefined( value['background-image'] ) || '' === value['background-image'] ) {
			control.container.find( '.background-wrapper > .background-repeat' ).hide();
			control.container.find( '.background-wrapper > .background-position' ).hide();
			control.container.find( '.background-wrapper > .background-size' ).hide();
			control.container.find( '.background-wrapper > .background-attachment' ).hide();
		}

		// Color.
		picker.wpColorPicker( {
			change: function() {
				setTimeout( function() {
					control.saveValue( 'background-color', picker.val() );
				}, 100 );
			}
		} );

		// Background-Repeat.
		control.container.on( 'change', '.background-repeat select', function() {
			control.saveValue( 'background-repeat', jQuery( this ).val() );
		} );

		// Background-Size.
		control.container.on( 'change click', '.background-size input', function() {
			control.saveValue( 'background-size', jQuery( this ).val() );
		} );

		// Background-Position.
		control.container.on( 'change', '.background-position select', function() {
			control.saveValue( 'background-position', jQuery( this ).val() );
		} );

		// Background-Attachment.
		control.container.on( 'change click', '.background-attachment input', function() {
			control.saveValue( 'background-attachment', jQuery( this ).val() );
		} );

		// Background-Image.
		control.container.on( 'click', '.background-image-upload-button', function( e ) {
			var image = wp.media( { multiple: false } ).open().on( 'select', function() {

				// This will return the selected image from the Media Uploader, the result is an object.
				var uploadedImage = image.state().get( 'selection' ).first(),
					previewImage   = uploadedImage.toJSON().sizes.full.url,
					imageUrl,
					imageID,
					imageWidth,
					imageHeight,
					preview,
					removeButton;

				if ( ! _.isUndefined( uploadedImage.toJSON().sizes.medium ) ) {
					previewImage = uploadedImage.toJSON().sizes.medium.url;
				} else if ( ! _.isUndefined( uploadedImage.toJSON().sizes.thumbnail ) ) {
					previewImage = uploadedImage.toJSON().sizes.thumbnail.url;
				}

				imageUrl    = uploadedImage.toJSON().sizes.full.url;
				imageID     = uploadedImage.toJSON().id;
				imageWidth  = uploadedImage.toJSON().width;
				imageHeight = uploadedImage.toJSON().height;

				// Show extra controls if the value has an image.
				if ( '' !== imageUrl ) {
					control.container.find( '.background-wrapper > .background-repeat, .background-wrapper > .background-position, .background-wrapper > .background-size, .background-wrapper > .background-attachment' ).show();
				}

				control.saveValue( 'background-image', imageUrl );
				preview      = control.container.find( '.placeholder, .thumbnail' );
				removeButton = control.container.find( '.background-image-upload-remove-button' );

				if ( preview.length ) {
					preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
				}
				if ( removeButton.length ) {
					removeButton.show();
				}
			} );

			e.preventDefault();
		} );

		control.container.on( 'click', '.background-image-upload-remove-button', function( e ) {

			var preview,
				removeButton;

			e.preventDefault();

			control.saveValue( 'background-image', '' );

			preview      = control.container.find( '.placeholder, .thumbnail' );
			removeButton = control.container.find( '.background-image-upload-remove-button' );

			// Hide unnecessary controls.
			control.container.find( '.background-wrapper > .background-repeat' ).hide();
			control.container.find( '.background-wrapper > .background-position' ).hide();
			control.container.find( '.background-wrapper > .background-size' ).hide();
			control.container.find( '.background-wrapper > .background-attachment' ).hide();

			if ( preview.length ) {
				preview.removeClass().addClass( 'placeholder' ).html( 'No file selected' );
			}
			if ( removeButton.length ) {
				removeButton.hide();
			}
		} );
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( property, value ) {

		var control = this,
			input   = jQuery( '#customize-control-' + control.id.replace( '[', '-' ).replace( ']', '' ) + ' .background-hidden-value' ),
			val     = Object.keys( control.setting._value ).length === 0 ? new Object() : control.setting._value;

		val[ property ] = value;

		jQuery( input ).attr( 'value', JSON.stringify( val ) ).trigger( 'change' );

		control.setting.set( val );
	}
} );


/*===============================================================
# 3. Control Dimension
===============================================================*/

wp.customize.controlConstructor[ 'dimension' ] = wp.customize.Control.extend( {
	/**
	 * Set up.
	 *
	 * @returns {void}
	 */
	ready: function() {
		var control = this;

		// Notifications.
		control.themeNotifications();
	},

	/**
	 * Handles notifications.
	 *
	 * @returns {void}
	 */
	themeNotifications: function() {
		var control = this;

		wp.customize( control.id, function( setting ) {
			setting.bind( function( value ) {
				var code = 'long_title';

				if ( false === control.validateCssValue( value ) ) {
					setting.notifications.add( code, new wp.customize.Notification( code, {
						type: 'error',
						message: 'Invalid Value'
					} ) );
				} else {
					setting.notifications.remove( code );
				}
			} );
		} );
	},

	validateCssValue: function( value ) {

		var validUnits = [ 'fr', 'rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax' ],
			numericValue,
			unit;

		// Whitelist values.
		if ( !value || '' === value || 0 === value || '0' === value || 'auto' === value || 'inherit' === value || 'initial' === value ) {
			return true;
		}

		// Skip checking if calc().
		if ( 0 <= value.indexOf( 'calc(' ) && 0 <= value.indexOf( ')' ) ) {
			return true;
		}

		// Get the numeric value.
		numericValue = parseFloat( value );

		// Get the unit
		unit = value.replace( numericValue, '' );

		// Allow unitless.
		if ( !unit ) {
			return true;
		}

		// Check the validity of the numeric value and units.
		return ( !isNaN( numericValue ) && -1 !== validUnits.indexOf( unit ) );
	}
} );

/*===============================================================
# 4. Control Multicheck
===============================================================*/
wp.customize.controlConstructor['multicheck'] = wp.customize.Control.extend( {
	/**
	 * Set up.
	 *
	 * @returns {void}
	 */
	ready: function() {

		var control = this;

		// Save the value
		control.container.on( 'change', 'input', function() {
			var value = [],
				i = 0;

			// Build the value as an object using the sub-values from individual checkboxes.
			jQuery.each( control.params.choices, function( key ) {
				if ( control.container.find( 'input[value="' + key + '"]' ).is( ':checked' ) ) {
					control.container.find( 'input[value="' + key + '"]' ).parent().addClass( 'checked' );
					value[ i ] = key;
					i++;
				} else {
					control.container.find( 'input[value="' + key + '"]' ).parent().removeClass( 'checked' );
				}
			} );

			// Update the value in the customizer.
			control.setting.set( value );
		} );
	}
} );

/*===============================================================
# 5. Control Typography
===============================================================*/

wp.customize.controlConstructor[ 'typography' ] = wp.customize.Control.extend( {
	/**
	 * Embed the control in the document.
	 *
	 * Override the embed() method to do nothing,
	 * so that the control isn't embedded on load,
	 * unless the containing section is already expanded.
	 *
	 * @returns {null}
	 */
	embed: function() {
		var control = this,
			sectionId = control.section();

		if ( !sectionId ) {
			return;
		}

		wp.customize.section( sectionId, function( section ) {
			if ( section.expanded() || wp.customize.settings.autofocus.control === control.id ) {
				control.actuallyEmbed();
			} else {
				section.expanded.bind( function( expanded ) {
					if ( expanded ) {
						control.actuallyEmbed();
					}
				} );
			}
		} );
	},

	/**
	 * Deferred embedding of control when actually
	 *
	 * This function is called in Section.onChangeExpanded() so the control
	 * will only get embedded when the Section is first expanded.
	 *
	 * @returns {null}
	 */
	actuallyEmbed: function() {
		var control = this;
		if ( 'resolved' === control.deferred.embedded.state() ) {
			return;
		}
		control.renderContent();

		initControlCollapsible();

		// This triggers control.ready().
		control.deferred.embedded.resolve();
	},

	/**
	 * Set up.
	 *
	 * @returns {void}
	 */
	ready: function() {
		var control = this,
			value = control.setting._value;

		control.deferred.embedded.done( function() {
			control.renderFontSelector();
			control.renderVariantSelector();

			// Font-size.
			if ( 'undefined' !== typeof control.params.default[ 'font-size' ] ) {
				control.container.on( 'change keyup paste', '.font-size input', function() {
					control.saveValue( 'font-size', jQuery( this ).val() );
				} );
			}

			// Line-height.
			if ( 'undefined' !== typeof control.params.default[ 'line-height' ] ) {
				control.container.on( 'change keyup paste', '.line-height input', function() {
					control.saveValue( 'line-height', jQuery( this ).val() );
				} );
			}

			// Letter-spacing.
			if ( 'undefined' !== typeof control.params.default[ 'letter-spacing' ] ) {
				value[ 'letter-spacing' ] = ( jQuery.isNumeric( value[ 'letter-spacing' ] ) ) ? value[ 'letter-spacing' ] + 'px' : value[ 'letter-spacing' ];
				control.container.on( 'change keyup paste', '.letter-spacing input', function() {
					value[ 'letter-spacing' ] = ( jQuery.isNumeric( jQuery( this ).val() ) ) ? jQuery( this ).val() + 'px' : jQuery( this ).val();
					control.saveValue( 'letter-spacing', value[ 'letter-spacing' ] );
				} );
			}

			// Word-spacing.
			if ( 'undefined' !== typeof control.params.default[ 'word-spacing' ] ) {
				control.container.on( 'change keyup paste', '.word-spacing input', function() {
					control.saveValue( 'word-spacing', jQuery( this ).val() );
				} );
			}

			// Text-align.
			if ( 'undefined' !== typeof control.params.default[ 'text-align' ] ) {
				control.container.on( 'change', '.text-align input', function() {
					control.saveValue( 'text-align', jQuery( this ).val() );
				} );
			}

			// Text-transform.
			if ( 'undefined' !== typeof control.params.default[ 'text-transform' ] ) {
				jQuery( control.selector + ' .text-transform select' ).selectWoo().on( 'change', function() {
					control.saveValue( 'text-transform', jQuery( this ).val() );
				} );
			}

			// Text-decoration.
			if ( 'undefined' !== typeof control.params.default[ 'text-decoration' ] ) {
				jQuery( control.selector + ' .text-decoration select' ).selectWoo().on( 'change', function() {
					control.saveValue( 'text-decoration', jQuery( this ).val() );
				} );
			}
		} );
	},

	/**
	 * Adds the font-families to the font-family dropdown
	 * and instantiates selectWoo.
	 */
	renderFontSelector: function() {

		var control = this,
			selector = control.selector + ' .font-family select',
			data = [],
			standardFonts = [],
			googleFonts = [],
			value = control.setting._value,
			fonts = control.getFonts(),
			fontSelect,
			controlFontFamilies;

		// Format standard fonts as an array.
		if ( !_.isUndefined( fonts.standard ) ) {
			_.each( fonts.standard, function( font ) {
				standardFonts.push( {
					id: font.family.replace( /&quot;/g, '&#39' ),
					text: font.label
				} );
			} );
		}

		// Format google fonts as an array.
		if ( !_.isUndefined( fonts.google ) ) {
			_.each( fonts.google, function( font ) {
				googleFonts.push( {
					id: font.family,
					text: font.family
				} );
			} );
		}

		// Do we have custom fonts?
		controlFontFamilies = {};
		if ( !_.isUndefined( control.params ) && !_.isUndefined( control.params.choices ) && !_.isUndefined( control.params.choices.fonts ) && !_.isUndefined( control.params.choices.fonts.families ) ) {
			controlFontFamilies = control.params.choices.fonts.families;
		}

		// Combine forces and build the final data.
		data = jQuery.extend( {}, controlFontFamilies, {
			default: {
				text: cscoCustomizerConfig.defaultCSSValues,
				children: [
					{ id: '', text: cscoCustomizerConfig.defaultBrowserFamily },
					{ id: 'initial', text: 'initial' },
					{ id: 'inherit', text: 'inherit' }
				]
			},
			standard: {
				text: cscoCustomizerConfig.standardFonts,
				children: standardFonts
			},
			google: {
				text: cscoCustomizerConfig.googleFonts,
				children: googleFonts
			}
		} );

		data = _.values( data );

		// Instantiate selectWoo with the data.
		fontSelect = jQuery( selector ).selectWoo( {
			data: data
		} );

		// Set the initial value.
		if ( value[ 'font-family' ] || '' === value[ 'font-family' ] ) {
			value[ 'font-family' ] = cscoCustomizer.util.parseHtmlEntities( value[ 'font-family' ].replace( /'/g, '"' ) );
			fontSelect.val( value[ 'font-family' ] ).trigger( 'change' );
		}

		// When the value changes
		fontSelect.on( 'change', function() {

			// Set the value.
			control.saveValue( 'font-family', jQuery( this ).val() );

			// Re-init variants selector.
			control.renderVariantSelector();
		} );
	},

	/**
	 * Renders the variants selector using selectWoo
	 * Displays font-variants for the currently selected font-family.
	 */
	renderVariantSelector: function() {

		var control = this,
			value = control.setting._value,
			fontFamily = value[ 'font-family' ],
			selector = control.selector + ' .variant select',
			data = [],
			isValid = false,
			fontType = cscoCustomizer.util.webfonts.getFontType( fontFamily ),
			variants = [ '', 'regular', 'italic', '700', '700italic' ],
			fontWeight,
			variantSelector,
			fontStyle;

		if ( 'google' === fontType ) {
			variants = cscoCustomizer.util.webfonts.google.getVariants( fontFamily );
		}

		// Check if we've got custom variants defined for this font.
		if ( !_.isUndefined( control.params ) && !_.isUndefined( control.params.choices ) && !_.isUndefined( control.params.choices.fonts ) && !_.isUndefined( control.params.choices.fonts.variants ) ) {

			// Check if we have variants for this font-family.
			if ( !_.isUndefined( control.params.choices.fonts.variants[ fontFamily ] ) ) {
				variants = control.params.choices.fonts.variants[ fontFamily ];
			}
		}

		if ( 'inherit' === fontFamily || 'initial' === fontFamily || '' === fontFamily ) {
			value.variant = 'inherit';
			variants = [ '' ];
			jQuery( control.selector + ' .variant' ).hide();
		}

		if ( 1 >= variants.length ) {
			jQuery( control.selector + ' .variant' ).hide();

			value.variant = variants[ 0 ];

			control.saveValue( 'variant', value.variant );

			if ( '' === value.variant || !value.variant ) {
				fontWeight = '';
				fontStyle = '';
			} else {
				fontWeight = ( !_.isString( value.variant ) ) ? '400' : value.variant.match( /\d/g );
				fontWeight = ( !_.isObject( fontWeight ) ) ? '400' : fontWeight.join( '' );
				fontStyle = ( value.variant && -1 !== value.variant.indexOf( 'italic' ) ) ? 'italic' : 'normal';
			}

			control.saveValue( 'font-weight', fontWeight );
			control.saveValue( 'font-style', fontStyle );

			return;
		}

		jQuery( control.selector + ' .font-backup' ).show();

		jQuery( control.selector + ' .variant' ).show();
		_.each( variants, function( variant ) {
			if ( value.variant === variant ) {
				isValid = true;
			}
			data.push( {
				id: variant,
				text: variant
			} );
		} );
		if ( !isValid ) {
			value.variant = 'regular';
		}

		if ( jQuery( selector ).hasClass( 'select2-hidden-accessible' ) ) {
			jQuery( selector ).selectWoo( 'destroy' );
			jQuery( selector ).empty();
		}

		// Instantiate selectWoo with the data.
		variantSelector = jQuery( selector ).selectWoo( {
			data: data
		} );
		variantSelector.val( value.variant ).trigger( 'change' );
		variantSelector.on( 'change', function() {
			control.saveValue( 'variant', jQuery( this ).val() );
			if ( 'string' !== typeof value.variant ) {
				value.variant = variants[ 0 ];
			}

			fontWeight = ( !_.isString( value.variant ) ) ? '400' : value.variant.match( /\d/g );
			fontWeight = ( !_.isObject( fontWeight ) ) ? '400' : fontWeight.join( '' );
			fontStyle = ( -1 !== value.variant.indexOf( 'italic' ) ) ? 'italic' : 'normal';

			control.saveValue( 'font-weight', fontWeight );
			control.saveValue( 'font-style', fontStyle );
		} );
	},

	/**
	 * Get fonts.
	 */
	getFonts: function() {
		var control = this,
			initialGoogleFonts = cscoCustomizer.util.webfonts.google.getFonts(),
			googleFonts = {},
			googleFontsSort = 'alpha',
			googleFontsNumber = 0,
			standardFonts = {};

		// Get google fonts.
		if ( !_.isEmpty( control.params.choices.fonts.google ) ) {
			if ( 'alpha' === control.params.choices.fonts.google[ 0 ] || 'popularity' === control.params.choices.fonts.google[ 0 ] || 'trending' === control.params.choices.fonts.google[ 0 ] ) {
				googleFontsSort = control.params.choices.fonts.google[ 0 ];
				if ( !isNaN( control.params.choices.fonts.google[ 1 ] ) ) {
					googleFontsNumber = parseInt( control.params.choices.fonts.google[ 1 ], 10 );
				}
				googleFonts = cscoCustomizer.util.webfonts.google.getFonts( googleFontsSort, '', googleFontsNumber );

			} else {
				_.each( control.params.choices.fonts.google, function( fontName ) {
					if ( 'undefined' !== typeof initialGoogleFonts[ fontName ] && !_.isEmpty( initialGoogleFonts[ fontName ] ) ) {
						googleFonts[ fontName ] = initialGoogleFonts[ fontName ];
					}
				} );
			}
		} else {
			googleFonts = cscoCustomizer.util.webfonts.google.getFonts( googleFontsSort, '', googleFontsNumber );
		}

		// Get standard fonts.
		if ( !_.isEmpty( control.params.choices.fonts.standard ) ) {
			_.each( control.params.choices.fonts.standard, function( fontName ) {
				if ( 'undefined' !== typeof cscoCustomizer.util.webfonts.standard.fonts[ fontName ] && !_.isEmpty( cscoCustomizer.util.webfonts.standard.fonts[ fontName ] ) ) {
					standardFonts[ fontName ] = {};
					if ( 'undefined' !== cscoCustomizer.util.webfonts.standard.fonts[ fontName ].stack && !_.isEmpty( cscoCustomizer.util.webfonts.standard.fonts[ fontName ].stack ) ) {
						standardFonts[ fontName ].family = cscoCustomizer.util.webfonts.standard.fonts[ fontName ].stack;
					} else {
						standardFonts[ fontName ].family = googleFonts[ fontName ];
					}
					if ( 'undefined' !== cscoCustomizer.util.webfonts.standard.fonts[ fontName ].label && !_.isEmpty( cscoCustomizer.util.webfonts.standard.fonts[ fontName ].label ) ) {
						standardFonts[ fontName ].label = cscoCustomizer.util.webfonts.standard.fonts[ fontName ].label;
					} else if ( !_.isEmpty( standardFonts[ fontName ] ) ) {
						standardFonts[ fontName ].label = standardFonts[ fontName ];
					}
				} else {
					standardFonts[ fontName ] = {
						family: fontName,
						label: fontName
					};
				}
			} );
		} else {
			_.each( cscoCustomizer.util.webfonts.standard.fonts, function( font, id ) {
				standardFonts[ id ] = {
					family: font.stack,
					label: font.label
				};
			} );
		}
		return {
			google: googleFonts,
			standard: standardFonts
		};
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( property, value ) {

		var control = this,
			input = control.container.find( '.typography-hidden-value' ),
			val = control.setting._value;

		val[ property ] = value;

		jQuery( input ).attr( 'value', JSON.stringify( val ) ).trigger( 'change' );

		control.setting.set( val );
	}
} );

/*===============================================================
# 6. Control Color and Color Alpha Contrast
===============================================================*/

wp.customize.bind( 'ready', function() {
	var colors = document.querySelectorAll( '.customize-control-color[id*="is_contrast"], .customize-control-color-alpha[id*="is_contrast"]' );

	[].forEach.call( colors, function( color ) {
		let expand = document.createElement( 'span' );
		expand.classList.add( 'expand-setting' );

		expand.setAttribute( 'title', cscoCustomizerConfig.advanced_settings );

		expand.onclick = function() {
			if ( color.matches( '.customize-control-color-open' ) ) {
				color.classList.remove( 'customize-control-color-open' );
			} else {
				color.classList.add( 'customize-control-color-open' );
			}
		}

		color.prepend( expand );
	} );
} );

/*===============================================================
# 7. Control Collapsible
===============================================================*/

function initControlCollapsible() {
	var collapsibles = document.querySelectorAll( '.customize-control-collapsible' );

	[].forEach.call( collapsibles, function( collapsible ) {
		var subControls = collapsible.nextElementSibling;

		// Initialization.
		if ( !collapsible.contains( collapsible.querySelector( '.customize-collapsed' ) ) ) {
			collapsible.classList.add( 'customize-control-collapsed' );

			while ( subControls ) {
				if ( subControls.matches( '.customize-control-collapsible' ) ) break;

				subControls.classList.add( 'customize-control-hidden' );

				subControls = subControls.nextElementSibling;
			}
		}

		// Add event onclick to collapsible.
		collapsible.onclick = function() {
			var status = this.matches( '.customize-control-collapsed' ) ? 'visible' : 'hidden';

			// Switch control collapsed.
			if ( 'visible' === status ) {
				this.classList.remove( 'customize-control-collapsed' );
			} else {
				this.classList.add( 'customize-control-collapsed' );
			}

			var subControls = this.nextElementSibling;

			// Switch visibility for subcontrols.
			while ( subControls ) {
				if ( subControls.matches( '.customize-control-collapsible' ) ) break;

				if ( 'visible' === status ) {
					subControls.classList.remove( 'customize-control-hidden' );
				} else {
					subControls.classList.add( 'customize-control-hidden' );
				}

				subControls = subControls.nextElementSibling;
			}
		};
	} );
}
wp.customize.bind( 'ready', initControlCollapsible );


/*===============================================================
# 8. Control Alpha Color
===============================================================*/

/**
 * Override the stock color.js toString() method to add support for
 * outputting RGBa or Hex.
 */
Color.prototype.toString = function( flag ) {

	// If our no-alpha flag has been passed in, output RGBa value with 100% opacity.
	// This is used to set the background color on the opacity slider during color changes.
	if ( 'no-alpha' == flag ) {
		return this.toCSS( 'rgba', '1' ).replace( /\s+/g, '' );
	}

	// If we have a proper opacity value, output RGBa.
	if ( 1 > this._alpha ) {
		return this.toCSS( 'rgba', this._alpha ).replace( /\s+/g, '' );
	}

	// Proceed with stock color.js hex output.
	var hex = parseInt( this._color, 10 ).toString( 16 );
	if ( this.error ) { return ''; }
	if ( hex.length < 6 ) {
		for ( var i = 6 - hex.length - 1; i >= 0; i-- ) {
			hex = '0' + hex;
		}
	}

	return '#' + hex;
};

/**
 * Given an RGBa, RGB, or hex color value, return the alpha channel value.
 */
function csco_get_alpha_value_from_color( value ) {
	var alphaVal;

	// Remove all spaces from the passed in value to help our RGBa regex.
	value = value.replace( / /g, '' );

	if ( value.match( /rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/ ) ) {
		alphaVal = parseFloat( value.match( /rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/ )[1] ).toFixed(2) * 100;
		alphaVal = parseInt( alphaVal );
	} else {
		alphaVal = 100;
	}

	return alphaVal;
}

/**
 * Force update the alpha value of the color picker object and maybe the alpha slider.
 */
 function csco_update_alpha_value_on_color_control( alpha, $control, $alphaSlider, update_slider ) {
	var iris, colorPicker, color;

	iris = $control.data( 'a8cIris' );
	colorPicker = $control.data( 'wpWpColorPicker' );

	// Set the alpha value on the Iris object.
	iris._color._alpha = alpha;

	// Store the new color value.
	color = iris._color.toString();

	// Set the value of the input.
	$control.val( color );

	// Update the background color of the color picker.
	colorPicker.toggler.css({
		'background-color': color
	});

	// Maybe update the alpha slider itself.
	if ( update_slider ) {
		csco_update_alpha_value_on_alpha_slider( alpha, $alphaSlider );
	}

	// Update the color value of the color picker object.
	$control.wpColorPicker( 'color', color );
}

/**
 * Update the slider handle position and label.
 */
function csco_update_alpha_value_on_alpha_slider( alpha, $alphaSlider ) {
	$alphaSlider.slider( 'value', alpha );
	$alphaSlider.find( '.ui-slider-handle' ).text( alpha.toString() );
}

/**
 * Initialization trigger.
 */
jQuery( document ).ready( function( $ ) {

	// Loop over each control and transform it into our color picker.
	$( '.color-alpha-control' ).each( function() {

		// Scope the vars.
		var $control, startingColor, paletteInput, showOpacity, defaultColor, palette,
			colorPickerOptions, $container, $alphaSlider, alphaVal, sliderOptions;

		// Store the control instance.
		$control = $( this );

		// Get a clean starting value for the option.
		startingColor = $control.val().replace( /\s+/g, '' );

		// Get some data off the control.
		paletteInput = $control.attr( 'data-palette' );
		showOpacity  = $control.attr( 'data-alpha' );
		defaultColor = $control.attr( 'data-default-color' );

		// Process the palette.
		if ( paletteInput.indexOf( '|' ) !== -1 ) {
			palette = paletteInput.split( '|' );
		} else if ( 'false' == paletteInput ) {
			palette = false;
		} else {
			palette = true;
		}

		// Set up the options that we'll pass to wpColorPicker().
		colorPickerOptions = {
			change: function( event, ui ) {
				var key, value, alpha, $transparency;

				key = $control.attr( 'data-customize-setting-link' );
				value = $control.wpColorPicker( 'color' );

				// Set the opacity value on the slider handle when the default color button is clicked.
				if ( defaultColor == value ) {
					alpha = csco_get_alpha_value_from_color( value );
					$alphaSlider.find( '.ui-slider-handle' ).text( alpha );
				}

				// Send ajax request to wp.customize to trigger the Save action.
				wp.customize( key, function( obj ) {
					obj.set( value );
				});

				$transparency = $container.find( '.transparency' );

				// Always show the background color of the opacity slider at 100% opacity.
				$transparency.css( 'background-color', ui.color.toString( 'no-alpha' ) );
			},
			palettes: palette // Use the passed in palette.
		};

		// Create the colorpicker.
		$control.wpColorPicker( colorPickerOptions );

		$container = $control.parents( '.wp-picker-container:first' );

		// Insert our opacity slider.
		$( '<div class="color-alpha-picker-container">' +
				'<div class="min-click-zone click-zone"></div>' +
				'<div class="max-click-zone click-zone"></div>' +
				'<div class="alpha-slider"></div>' +
				'<div class="transparency"></div>' +
			'</div>' ).appendTo( $container.find( '.wp-picker-holder' ) );

		$alphaSlider = $container.find( '.alpha-slider' );

		// If starting value is in format RGBa, grab the alpha channel.
		alphaVal = csco_get_alpha_value_from_color( startingColor );

		// Set up jQuery UI slider() options.
		sliderOptions = {
			create: function( event, ui ) {
				var value = $( this ).slider( 'value' );

				// Set up initial values.
				$( this ).find( '.ui-slider-handle' ).text( value );
				$( this ).siblings( '.transparency ').css( 'background-color', startingColor );
			},
			value: alphaVal,
			range: 'max',
			step: 1,
			min: 0,
			max: 100,
			animate: 300
		};

		// Initialize jQuery UI slider with our options.
		$alphaSlider.slider( sliderOptions );

		// Maybe show the opacity on the handle.
		if ( 'true' == showOpacity ) {
			$alphaSlider.find( '.ui-slider-handle' ).addClass( 'alpha' );
		}

		// Bind event handlers for the click zones.
		$container.find( '.min-click-zone' ).on( 'click', function() {
			csco_update_alpha_value_on_color_control( 0, $control, $alphaSlider, true );
		});
		$container.find( '.max-click-zone' ).on( 'click', function() {
			csco_update_alpha_value_on_color_control( 100, $control, $alphaSlider, true );
		});

		// Bind event handler for clicking on a palette color.
		$container.find( '.iris-palette' ).on( 'click', function() {
			var color, alpha;

			color = $( this ).css( 'background-color' );
			alpha = csco_get_alpha_value_from_color( color );

			csco_update_alpha_value_on_alpha_slider( alpha, $alphaSlider );

			// Sometimes Iris doesn't set a perfect background-color on the palette,
			// for example rgba(20, 80, 100, 0.3) becomes rgba(20, 80, 100, 0.298039).
			// To compensante for this we round the opacity value on RGBa colors here
			// and save it a second time to the color picker object.
			if ( alpha != 100 ) {
				color = color.replace( /[^,]+(?=\))/, ( alpha / 100 ).toFixed( 2 ) );
			}

			$control.wpColorPicker( 'color', color );
		});

		// Bind event handler for clicking on the 'Clear' button.
		$container.find( '.button.wp-picker-clear' ).on( 'click', function() {
			var key = $control.attr( 'data-customize-setting-link' );

			// The #fff color is delibrate here. This sets the color picker to white instead of the
			// defult black, which puts the color picker in a better place to visually represent empty.
			$control.wpColorPicker( 'color', '#ffffff' );

			// Set the actual option value to empty string.
			wp.customize( key, function( obj ) {
				obj.set( '' );
			});

			csco_update_alpha_value_on_alpha_slider( 100, $alphaSlider );
		});

		// Bind event handler for clicking on the 'Default' button.
		$container.find( '.button.wp-picker-default' ).on( 'click', function() {
			var alpha = csco_get_alpha_value_from_color( defaultColor );

			csco_update_alpha_value_on_alpha_slider( alpha, $alphaSlider );
		});

		// Bind event handler for typing or pasting into the input.
		$control.on( 'input', function() {
			var value = $( this ).val();
			var alpha = csco_get_alpha_value_from_color( value );

			csco_update_alpha_value_on_alpha_slider( alpha, $alphaSlider );
		});

		// Update all the things when the slider is interacted with.
		$alphaSlider.slider().on( 'slide', function( event, ui ) {
			var alpha = parseFloat( ui.value ) / 100.0;

			csco_update_alpha_value_on_color_control( alpha, $control, $alphaSlider, false );

			// Change value shown on slider handle.
			$( this ).find( '.ui-slider-handle' ).text( ui.value );
		});

	});
});

/*===============================================================
# 9. Active Callback
===============================================================*/

wp.customize.bind( 'ready', function() {
	var cscoCustomizerDependencies = {

		listenTo: {},

		init: function() {
			var self = this;

			_.each( window.cscoCustomizerConfig.dependencies, function( requires, controlID ) {
				var control = wp.customize.control( controlID );
				if ( control ) {
					wp.customize.control( controlID ).params.required = requires;
					self.showThemeCustomizerControl( control );
				}
			} );

			_.each( self.listenTo, function( slaves, master ) {
				_.each( slaves, function( slave ) {
					wp.customize( master, function( setting ) {
						var setupControl = function( control ) {
							var setActiveState,
								isDisplayed;

							isDisplayed = function() {
								return self.showThemeCustomizerControl( wp.customize.control( slave ) );
							};
							setActiveState = function() {
								control.active.set( isDisplayed() );
							};

							setActiveState();
							setting.bind( setActiveState );
							control.active.validate = isDisplayed;
						};
						wp.customize.control( slave, setupControl );
					} );
				} );
			} );
		},

		/**
		 * Should we show the control?
		 *
		 * @since 3.0.17
		 * @param {string|object} control - The control-id or the control object.
		 * @returns {bool} - Whether the control should be shown or not.
		 */
		showThemeCustomizerControl: function( control ) {
			var self = this,
				show = true,
				i;

			if ( _.isString( control ) ) {
				control = wp.customize.control( control );
			}

			// Exit early if control not found or if "required" argument is not defined.
			if ( 'undefined' === typeof control || ( control.params && _.isEmpty( control.params.required ) ) ) {
				return true;
			}

			// Loop control requirements.
			for ( i = 0; i < control.params.required.length; i++ ) {
				if ( !self.checkCondition( control.params.required[ i ], control, 'AND' ) ) {
					show = false;
				}
			}
			return show;
		},

		/**
		 * Check a condition.
		 *
		 * @param {Object} requirement - The requirement, inherited from showThemeCustomizerControl.
		 * @param {Object} control - The control object.
		 * @param {string} relation - Can be one of 'AND' or 'OR'.
		 * @returns {bool} - Returns the results of the condition checks.
		 */
		checkCondition: function( requirement, control, relation ) {
			var self = this,
				childRelation = ( 'AND' === relation ) ? 'OR' : 'AND',
				nestedItems,
				value,
				i;

			// If an array of other requirements nested, we need to process them separately.
			if ( 'undefined' !== typeof requirement[ 0 ] && 'undefined' === typeof requirement.setting ) {
				nestedItems = [];

				// Loop sub-requirements.
				for ( i = 0; i < requirement.length; i++ ) {
					nestedItems.push( self.checkCondition( requirement[ i ], control, childRelation ) );
				}

				// OR relation. Check that true is part of the array.
				if ( 'OR' === childRelation ) {
					return ( -1 !== nestedItems.indexOf( true ) );
				}

				// AND relation. Check that false is not part of the array.
				return ( -1 === nestedItems.indexOf( false ) );
			}

			// Early exit if setting is not defined.
			if ( 'undefined' === typeof wp.customize.control( requirement.setting ) ) {
				return true;
			}

			self.listenTo[ requirement.setting ] = self.listenTo[ requirement.setting ] || [];
			if ( -1 === self.listenTo[ requirement.setting ].indexOf( control.id ) ) {
				self.listenTo[ requirement.setting ].push( control.id );
			}

			value = wp.customize( requirement.setting ).get();
			if ( wp.customize.control( requirement.setting ).setting ) {
				value = wp.customize.control( requirement.setting ).setting._value;
			}

			return self.evaluate( requirement.value, value, requirement.operator, requirement.choice );
		},

		/**
		 * Figure out if the 2 values have the relation we want.
		 *
		 * @since 3.0.17
		 * @param {mixed} value1 - The 1st value.
		 * @param {mixed} value2 - The 2nd value.
		 * @param {string} operator - The comparison to use.
		 * @param {string} choice - If we want to check an item in an object value.
		 * @returns {bool} - Returns the evaluation result.
		 */
		evaluate: function( value1, value2, operator, choice ) {
			var found = false;

			if ( choice && 'object' === typeof value2 ) {
				value2 = value2[ choice ];
			}

			if ( '===' === operator ) {
				return value1 === value2;
			}
			if ( '==' === operator || '=' === operator || 'equals' === operator || 'equal' === operator ) {
				return value1 == value2;
			}
			if ( '!==' === operator ) {
				return value1 !== value2;
			}
			if ( '!=' === operator || 'not equal' === operator ) {
				return value1 != value2;
			}
			if ( '>=' === operator || 'greater or equal' === operator || 'equal or greater' === operator ) {
				return value2 >= value1;
			}
			if ( '<=' === operator || 'smaller or equal' === operator || 'equal or smaller' === operator ) {
				return value2 <= value1;
			}
			if ( '>' === operator || 'greater' === operator ) {
				return value2 > value1;
			}
			if ( '<' === operator || 'smaller' === operator ) {
				return value2 < value1;
			}
			if ( 'contains' === operator || 'in' === operator ) {
				if ( _.isArray( value1 ) && _.isArray( value2 ) ) {
					_.each( value2, function( value ) {
						if ( value1.includes( value ) ) {
							found = true;
							return false;
						}
					} );
					return found;
				}
				if ( _.isArray( value2 ) ) {
					_.each( value2, function( value ) {
						if ( value == value1 ) { // jshint ignore:line
							found = true;
						}
					} );
					return found;
				}
				if ( _.isObject( value2 ) ) {
					if ( !_.isUndefined( value2[ value1 ] ) ) {
						found = true;
					}
					_.each( value2, function( subValue ) {
						if ( value1 === subValue ) {
							found = true;
						}
					} );
					return found;
				}
				if ( _.isString( value2 ) ) {
					if ( _.isString( value1 ) ) {
						return ( -1 < value1.indexOf( value2 ) && -1 < value2.indexOf( value1 ) );
					}
					return -1 < value1.indexOf( value2 );
				}
			}
			if ( 'does not contain' === operator || 'not in' === operator ) {
				return ( !this.evaluate( value1, value2, 'contains', choice ) );
			}

			return value1 == value2;
		}
	};

	cscoCustomizerDependencies.init();
} );
