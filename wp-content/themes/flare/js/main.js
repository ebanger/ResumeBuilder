/* Simulate some mouse events on touch devices */
function btp_touch_handler(e) {
	var touches = e.changedTouches,
    first = touches[0],
    type = '';

    switch ( e.type ) {
    	case 'touchstart': 
    		type = 'mousedown'; 
    		break;
    	case 'touchmove':  
    		type = 'mousemove'; 
    		break;        
    	case 'touchend':   
    		type = 'mouseup'; 
    		break;
    	default: 
    		return;
    }
    
    var simulatedEvent = document.createEvent( 'MouseEvent' );
    simulatedEvent.initMouseEvent(type, true, true, window, 1,
                          first.screenX, first.screenY,
                          first.clientX, first.clientY, false,
                          false, false, false, 0, null);

    first.target.dispatchEvent(simulatedEvent);
    e.preventDefault();
}

function btp_touch_handler_init( domEl ) {	
	if ( domEl ) {
		domEl.addEventListener( 'touchstart',	touchHandler, true);
		domEl.addEventListener( 'touchmove',	touchHandler, true);
		domEl.addEventListener( 'touchend', 	touchHandler, true);
		domEl.addEventListener( 'touchcancel', 	touchHandler, true);
	}	
}




/* Tabs */
;(function($){
	var ver = '1.0.0';
	
	var methods = {			
		init : function( options ) { 
			return this.each(function(){
				options = options || {};
				
				var $this = $(this);
				var data = $this.data('btpTabs');
				
				/* If the plugin hasn't been initialized yet */
		        if ( !data ) {
		        	
		        	/* support metadata plugin (v1.0 and v2.0) */
				    options = $.extend({}, $.fn.btpTabs.defaults, options, $.metadata ? $this.metadata() : $.meta ? $this.data() : {});
		        	
		        	$this.data('btpTabs', {
		        		'target' 	: $this,
		        		'options' 	: options
		        	});
		        	
		        	var $navigation = $('<ul class="tabs-nav"></ul>');
		        	var $viewport = $('<div class="tabs-viewport"></div>');
		        	
		        	$this.find( options.cssSelectorTitle ).each(function(){
		        		var $div = $('<div class="tabs-viewport-item"></div' );
		        		$div.append( $(this).next( options.cssSelectorContent ).detach() );
		        		
		        		
		        		var $li = $('<li class="tabs-nav-item"></li>');
		        		$li.append( $(this).detach() );
		        		
		        		
		        		$navigation.append( $li );			
		        		$viewport.append( $div );
		        		
		        		$li.bind( options.event, function() {	
		        			$this.find('.tabs-nav-item').removeClass('current');
		        			$(this).addClass('current');
		        			$this.find('.tabs-viewport-item').hide();
		        			$div.show();				
		        		});
		        	});
	
		        	$this.find('*').remove();	
		        	
		        	if ( $this.is( '.tabs-bottom' ) ) {
		        		$this.prepend( $navigation );
		        		$this.prepend( $viewport );
		        	} else {
		        		$this.prepend( $viewport );
		        		$this.prepend( $navigation );
		        	}		        	
		        	
		        	$this.find('.tabs-nav-item:first').addClass('current');
		        	$this.find('.tabs-viewport-item').hide();
		        	$this.find('.tabs-viewport-item:first').show();
		        	
		        	$(window).bind( 'load', function(){
		        		$this.btpTabs( 'adjustHeight' );	
		        	});
		        }				
			});	
	    },
	    
	    adjustHeight : function() {
	    	return this.each(function(){
	    		var $this = $(this);
	    		
				if ( $this.btpTabs( 'isPositionVertical') ) {
					if ( $this.find( '.tabs-nav').height() > $this.find( '.tabs-viewport').height() ) {
						
						
						$this.find( '.tabs-viewport' ).css( 'min-height', $this.find( '.tabs-nav' ).height() );
					}
				}
	    	});
	    	
	    },	
	    
	    isPositionHorizontal : function() {
	    	if ( $(this).is( '.position-top-left, .position-top-center, .position-top-right, .position-bottom-left, .position-bottom-center, .position-bottom-right' ) ) {
	    		return true;
	    	} else {
	    		return false;
	    	}	
	    },	
	    
	    isPositionVertical : function() {
	    	return !( $(this).btpTabs( 'isPositionHorizontal') );	    	
	    },
	    
	    next : function( ) {
	    	return this.each(function(){
	    		var $this = $(this);
	    		var data = $this.data('btpTabs');
				
	    		console.log(data.options);
	    	});
	    },
	    
	    
	    prev : function( ) { 
	    },
	    
	    select : function( ) {	    	
	    },
	    
	    destroy : function( ) {
//	        return this.each(function(){
//	        	$(window).unbind('.tooltip');
//	        }); 
	    }
	};
	
	$.fn.btpTabs = function( method ) {
	    /* Method calling logic */
	    if ( methods[method] ) {
	      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
	    } else if ( typeof method === 'object' || ! method ) {
	      return methods.init.apply( this, arguments );
	    } else {
	      $.error( 'Method ' +  method + ' does not exist on jQuery.tabs' );
	    }
	};
	
	$.fn.btpTabs.defaults = {
		event:					'click',	
	    cssSelectorTitle: 		'.tab-title',
	    cssSelectorContent: 	'.tab-content'
	};
 })(jQuery);



(function( $ ){
	$.fn.btpCollapseMenu = function() {
		var $select = $("<select />");
		
		var $menu = $(this).clone();
		$menu.find( 'li li > a' ).prepend( '- ');
		$menu.find( 'li li li > a' ).prepend( '- ');
		
		/* Populate dropdown with menu items */
		$menu.find( 'a').each(function() {
			var el = $(this);
			$("<option />", {
				"value"   : el.attr("href"),
				"text"    : el.text()
			}).appendTo($select);
		});
		$menu = null;
		
		return $select;
				
	};	
})( jQuery );



(function( $ ){
	/* IMAGE PRELOADER */
	$.fn.btpAddImagePreloader = function() {
		return this.each(function() {
			$(this).addClass( 'preloader' ).one( 'load', function(){
				$(this).removeClass( 'preloader' );
			}).error(function(){
				$(this).removeClass( 'preloader' );
			}).each(function(){
				if( this.complete ) {
					$(this).trigger( 'load' );
				}	
			});
		});
	};
})( jQuery );



(function( $ ){ $(window).load(function(){
	
	/* --------------------------------------------------------------------- */
	/* FLEX SLIDER */
	/* --------------------------------------------------------------------- */
	if ( $.fn.flexslider ) {
		
		$( '.flexslider' ).each( function() {
			var $this = $( this );
			
			var totalSlideCount = $this.find( '.slides li' ).length;
			
			/* Slider makes sense when there are more than 2 slides */
			if ( totalSlideCount < 2 ) {
				return;
			}	
			
			/* Remove empty slide descriptions */
			$this.find('.slide-description').filter(function (index) { 
			    return $(this).children().length < 1; 
			}).remove();

		
			/* Compose configuration */
			var config = new Array();
			var data = $this.metadata( { type: 'attr', name: 'data-config' });
			
			config[ 'animation' ]			= data.animation ? data.animation.replace( /[^0-9a-zA-z_-]/g, '' ) : 'fade';
			config[ 'animation' ]			= config[ 'animation' ].replace( /-/g, '_' );				
			config[ 'animationDuration' ]	= data.animationDuration ? parseInt( data.animationDuration ) : 1000;
			config[ 'slideshowSpeed' ]		= data.slideshowSpeed ? parseInt( data.slideshowSpeed ) : 4000;			
			config[ 'controlsContainer' ] 	= '.flex-nav';		
			config[ 'start' ]				= function(slider){
				if (typeof Cufon !== 'undefined') {
					Cufon.refresh();
				}	
			};
			
			/* Start slider */
			$this.flexslider( config );
		});
	}
	
	
	/* --------------------------------------------------------------------- */
	/* ISOTOPE JQUERY PLUGIN */
	/* --------------------------------------------------------------------- */
	if ( $.fn.isotope ) {
		$('.isotope-wrapper').each(function(){
			$this = $(this);
			$container = $this.find('.collection.filterable ul:eq(0)');
			$filters = $this.find('.isotope-toolbar .filters ul:eq(0)');			
			
			/* Start Isotope */
			$container.isotope({
				resizable: false,
				containerStyle: { position: 'relative', overflow: 'visible' },
				itemSelector : '.item',
				layoutMode : 'fitRows'
			});
			
			/* Set up filters */
			$filters.find('a').click(function(){
				/* Add|remove some classes for proper styling */
				$filters.find('li.current').removeClass('current');
				$(this).parent('li').addClass('current');
				
				/* Filter */
				var selector = $(this).attr('data-filter');
				$container.isotope({ filter: selector });
				
				return false;
			});
			
		});						
		
		/* smartresize */
	    $(window).smartresize(function(){
	    	/* Leave it empty so that column width can be controlled from CSS  */
	    	$('.isotope-wrapper .collection.filterable ul:eq(0)').isotope({
	    		
	    	});
	    });
	}	
	
}); })( jQuery );


(function( $ ){ $(document).ready(function() {		
	/* JAVASCRIPT IS ENABLED */
	$( 'html' ).removeClass( 'no-js').addClass( 'js' );


    /* CHECK FOR A TOUCH DEVICE */
    if ( !!('ontouchstart' in window) ) {
        $( 'html' ).addClass( 'touch' );
    }
	
	
	/*
	 * Preventing the page to scale larger than 1.0, when changing the device to landscape orientation
	 * Based on: http://adactio.com/journal/4470/
	 */
	if ( navigator.userAgent.match( /iPhone/i ) || navigator.userAgent.match( /iPad/i ) ) {
		$('meta[name="viewport"]').each(function(){
			$this = $(this);
			
			$this.prop('content', 'width=device-width, minimum-scale=1.0, maximum-scale=1.0');
		    
			$('body').bind( 'gesturestart', function() {
		    	$this.prop('content', 'width=device-width, minimum-scale=0.25, maximum-scale=1.6');
		    });
		});
	}
	
	
	
	/* ENABLE TABS */
	$('.tabs').btpTabs();	
	
	
	
	/* BEFORE & AFTER EFFECT */
	$('before-after > .fluid-wrapper > .inner').each(function() {
		btp_touch_handler_init( $(this).get(0) );
	});	
	
	$( '.before-after > .fluid-wrapper > .inner').mousemove( function(event){
		var $this = $(this);
		var width = $this.width();
		var offset =$this.offset();		
		var x = event.pageX - offset.left;
		
		var delta = x/width * 100;
		$this.find('.layer-after, .handle').css('left', delta + '%');
		$this.find('.layer-after img').css('right', delta + '%');		
	});
	
	
	
	/* ENHANCE THE SEARCH FORM IN THE HEADER */
	$( '#secondary-bar-inner .searchform').each( function(){
		var $this = $(this);
		var $a = $('<a href="#"></a>');
		var $form = $(this).find( 'form' );
		
		$a.bind( 'click', function(e){
			$this.toggleClass('on');				
			e.preventDefault();				
			$form.toggle();
		}); 
		
		$(this).prepend( $a );	
	});
	
	
	
	/* COLLAPSE PRIMARY NAVIGATION */
	$('#primary-nav').each(function(){
		var $this = $(this);
		var $menu = $this.find('#primary-nav-menu');
				
		if ( $menu.length ) {		
			var $select = $menu.btpCollapseMenu();

            /* Create default option, something like "Go to..." */
            $("<option />", {
                "selected": "selected",
                "value"   : "",
                "text"    : $( '#primary-nav-tip').text()
            }).prependTo($select);

			$select.prop('id', 'primary-nav-select');
			
			$select.change(function() {
				window.location = $(this).find("option:selected").val();
			});	
			
			$this.append($select);
		}
	});
	
	
	
	/* PREHADER */
	$( '#content + #preheader' ).each(function() {
		$( '#header' ).addClass( 'after-preheader' );
		
		var $this = $(this);
				
		$this.hide();
		
		$( 'body' ).append( $this.detach() );
		
		var top = $( 'html ').css('marginTop');
		$this.css('top', top);		
		$this.show();
		
		
		$('#preheader-toggle .arrow').each(function(){
			var $this = $(this);
			
			/* By default preheader is collapsed */
			if(window.location.href.indexOf('preheader=on') == -1){				
				$this.addClass('arrow-down');
				$('#preheader-inner').addClass('off');
			}
			/* But you can expand it by adding 'preheader=on' to the query string */
			else {
				$this.addClass('arrow-up');
				$('#preheader-inner').addClass('on').show();
			}	
			
			$this.click(function(){ 				
				$(this).toggleClass('on').toggleClass('off').toggleClass('arrow-up').toggleClass('arrow-down');
				$('#preheader-inner').slideToggle( 500, 'easeOutQuint' );
			});
		});
	}); 
	
	
	$( 'img' ).btpAddImagePreloader();
	
	
	/* --------------------------------------------------------------------- */
	/* JPLAYER */
	/* --------------------------------------------------------------------- */
	if ( $.fn.jPlayer ) {
		/* Build jPlayer */
		var jPlayerMarkup = new Array(			
			'<div id="__id__" class="jp-jplayer"></div>',
			'<div id="__selector__" class="jp-audio">',
				'<div class="jp-type-single">',
					'__title__',
					'<div class="jp-gui jp-interface">',
						'<ul class="jp-controls">',
							'<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>',
							'<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>',
							'<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>',
							'<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>',
						'</ul>',
						'<div class="jp-progress">',
							'<div class="jp-seek-bar">',
								'<div class="jp-play-bar"></div>',
							'</div>',
						'</div>',
						'<div class="jp-volume-bar">',
							'<div class="jp-volume-bar-value"></div>',
						'</div>',
						'<div class="jp-current-time"></div>',
						'<div class="jp-duration"></div>',
					'</div>',
					'<div class="jp-no-solution">',
						'<span>Update Required</span>',
						'To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.',
					'</div>',
				'</div>',
			'</div>'		
		).join("\n");		
		
		$( 'figure.media-audio' ).each( function() {
			var $this = $( this );			
			var player = jPlayerMarkup;
			
			var id			= $this.attr( 'id' ) + '-1';
			var selector	= $this.attr( 'id' ) + '-2';
			var title 		= $this.find( 'figcaption' ).text();
					
			var source 		= $this.find('audio').attr( 'src' );		
			
			title = title.length ? '<div class="jp-title"><ul><li>' + title + '</li></ul></div>' : '';
					
			/* Fill in the id and selector */
			player = player.replace( '__id__', id );
			player = player.replace( '__selector__', selector );
			
			/* Fill in the title */
			player = player.replace( '__title__', title );			

			/* Remove all elements inside */
			$this.empty();
			
			/* Append player markup */
			$this.append( player );
			
			/* Compose configuration */
			var config = new Array();
			config[ 'ready' ] 				= function() { $(this).jPlayer("setMedia", { mp3: source }); };
			config[ 'play' ] 				= function() { $(this).jPlayer( 'pauseOthers' ); };
			config[ 'cssSelectorAncestor' ] = '#' + selector;
			config[ 'swfPath' ] 			= btpTheme.uri + '/js/jquery.jplayer/Jplayer.swf';			
			config[ 'supplied' ] 			= 'mp3';
			config[ 'wmode' ] 				= 'window';
			
			/* Init player */
			$this.find( '#' + id ).jPlayer( config );
		}); 
	}	
		
	
	
	/* DROPDOWN MENU */
	$( '.dd-menu' ).each(function(){
		var $this = $(this);
		
		$this.find('li:has(ul) > a').addClass('dd-submenu-title').append('<span class="dd-arrow"><span></span></span>');
		
		
		$this.find('li').hoverIntent({			
			interval: 100, 		// delay before onMouseOver
			over: function(){
				$( 'ul:first' , this ).css({visibility: "visible",display: "none"}).slideDown(250);
				
				var path_set = $(this).parents('.dd-menu li').find('a:first');
				$('.dd-menu li a.dd-path').not(path_set).removeClass('dd-path');
			}, 
			timeout: 200, 		// delay before onMouseOut
			out: function(){
				$( 'ul:first', this ).css({visibility: "hidden"});
			}		
		}).hover(
			function(){
				/* HOVER IN HANDLER */		
				var path_set = $(this).parents('.dd-menu li').find('a:first');
				$(path_set).addClass('dd-path');
			},
			function(){
				/* HOVER OUT HANDLER */
			}		
		);		
		
		$this.hoverIntent(
				function() {
					/* HOVER IN HANDLER */			
				},
				function() {			
					/* HOVER OUT HANDLER */		
					$('a.dd-path', this).removeClass('dd-path');
				}	
			);
	});
	
	
	
	
	/* Helpers for togglers and accordions */
	var plusHelper = '<span class="plus"><span><span></span><span></span></span></span>';
	var minusHelper = '<span class="minus"><span><span></span><span></span></span></span>';
		
	
	
	/* TOGGLE */	
	$( '.toggle' ).each( function(){
		var $this = $(this);
		var $title = $this.find('.toggle-title');
		var $content = $this.find('.toggle-content');
		
		if ( $this.hasClass( 'toggle-off' ) ) {
			$title.prepend(plusHelper);
			$content.hide();
		} else {
			$title.prepend(minusHelper);	
		}	
			
		$title.click(function() {
			$('span', this).eq(0).toggleClass('plus').toggleClass('minus');
			/* Switch toggle (from 'off' to 'on' or from 'on' to 'off' ) on mouseclick */
			$this.toggleClass('toggle-on').toggleClass('toggle-off');		
			/* Show or hide content */
			$content.slideToggle();
		});
	});
	
	
	/* ACCORDIONS */
	$('.accordion').each(function(){
		var $this = $( this );		
		/* Remove empty paragraphs */
		$this.find('p:empty').remove();
		
		$this.find('.accordion-panel').each(function(index){
			
			/* Non-first accordion panels should be collapsed */
			if(index){
				$(this).addClass('accordion-panel-off');
				$('.accordion-panel-title', this).prepend(plusHelper);
				$('.accordion-panel-content', this).hide();
			}
			/* First accordion panel should be expanded */
			else {
				$(this).addClass('accordion-panel-on');
				$('.accordion-panel-title', this).prepend(minusHelper);
			}
		});
		
		$this.find('.accordion-panel-title', this).click(function(){				
			$(this).parent('.accordion-panel-off').each(function(){				
				/* Expand => Collapse */
				$(this).siblings('.accordion-panel-on').each(function(){
					$(this).toggleClass('accordion-panel-on').toggleClass('accordion-panel-off');
					$('.accordion-panel-title span', this).eq(0).toggleClass('plus').toggleClass('minus');
					$('.accordion-panel-content', this).slideUp(500);
				});			
				
				/* Collapse => Expand */
				$(this).toggleClass('accordion-panel-on').toggleClass('accordion-panel-off');
				$('.accordion-panel-title span', this).eq(0).toggleClass('plus').toggleClass('minus');		
				$('.accordion-panel-content', this).slideDown(500);
				
			});											
		});			
	});
	
		
	/* REPLACE SUBMIT BUTTONS WITH SOMETHING EASIER TO STYLE:) */
	$( '#page input[type=submit]:not(.no-replace), #preheader input[type=submit]:not(.no-replace)' ).each( function() {
		var $this = $( this );	
		
		var $a = $( '<a class="button primary small"><span><span>' + $this.val() + '</span></span></a>' );
		
		$this.after( $a );
		/* Don't remove a submit button, just hide it  */
		$this.hide();
		
		/* Bind "click" event  */
		$a.click( function( event ) {
			event.preventDefault();
			
			$this.trigger( 'click' );
		});
	});

	

	/* LINKS OPENED IN NEW WINDOW */
	$('a[class~=new-window]').attr('target', '_blank');	
	
	
	/* DISABLED LINKS IN A CUSTOM MENU */
	$('.menu-item.no-link > a').click(function(e) {
		e.preventDefault();
	});
	
	
	/* PRETTYPHOTO PLUGIN */
	/* PrettyPhoto doesn't filter duplicated items, thus we must emulate it */
	var prettyGroups = new Array();
	$( "a[rel^='prettyPhoto']").each( function(){
		var $this = $( this );
		
		/* remove "undefined" as description if the title attribute doesn't exist*/		
		if ( ! $this.attr( 'title') ) {
			$this.attr( 'title', ' ');
		}		
		
		var rel = $this.attr( 'rel' ); 
		
		if ( typeof prettyGroups[rel] == 'undefined' ) {			
			prettyGroups[rel] = new Array();	
		}		
		prettyGroups[rel].push( $this );
	});	
	
	for( key in prettyGroups ) {
		var uniques = new Array();
		
		for( i = 0; i < prettyGroups[key].length; i++) {
			var href = prettyGroups[key][i].attr( 'href' );
			
			if ( typeof uniques[href] == 'undefined' ) {			
				uniques[href] = prettyGroups[key][i];				
			} else {
				prettyGroups[key][i].removeAttr( 'rel' ).click( function( event ) {
					event.preventDefault();
					uniques[ $( this ).attr( 'href' ) ].trigger( 'click' );
				});
			}	
		}	
	}
	$("a[rel^='prettyPhoto']").prettyPhoto({
		theme: 'pp_default',
		overlay_gallery: false,
		social_tools: ''
	});	
	
}); })( jQuery );