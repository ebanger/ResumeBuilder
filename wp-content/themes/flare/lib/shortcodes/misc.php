<?php
/**
 * This file is part of the BTP_Flare_Theme package.
 *
 * For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 * 
 * @package			BTP_Flare_Theme
 * @subpackage		BTP_Shortcodes
 */



/* Prevent direct script access */
if ( !defined( 'BTP_FRAMEWORK_VERSION' ) ) exit( 'No direct script access allowed' );



/* Add "Columns" subgroup to the global shortcode generator */
btp_shortgen_add_subgroup( 
	'misc', 
	array( 
		'label' => __( 'Misc', 'btp_theme' ),
	), 
	'general', 
	450
);



/* Add [audio] shortcode to the global shortcode generator */
btp_shortgen_add_item( 
	'audio',
	array(
		'label'			=> '[audio]',
		'atts'			=> array(
			'title' 			=> array( 
				'view' 			=> 'String',
				'hint'			=> __( 'The title of the audio file.', 'btp_theme' ),	 
			),
			'mp3' 		=> array( 
				'view'			=> 'String',
				'hint'			=> __( 'The source of the mp3 file', 'btp_theme' ), 
			),
		),
		'display'		=> 'block',
		'group'			=> 'general',
		'subgroup'		=> 'misc',	
		'position'		=> 10,
	)						 
); 
	


/**
 * [audio] shortcode callback function.
 * 
 * @param 			array $atts
 * @param			string $content
 * @return			string
 */
function btp_shortcode_audio($atts, $content = null) {
	/* We need a static counter to trace a shortcode without the id attribute */
	static $counter = 0;
	$counter++;
	
	extract( shortcode_atts( array(
		'id'			=> '',
		'class'			=> '',	
		'title'			=> '',
		'mp3' 			=> '#',
		), $atts ) );
	
	if ( !strlen( $mp3 ) ) {
		return '';
	}
	
	/* Compose final HTML id attribute */
	$final_id = strlen( $id ) ? $id : 'media-audio-counter-' . $counter;
		
	/* Compose final HTML class attribute */
	$final_class = '';
	$final_class .= 'media-audio ';
	$final_class .= sanitize_html_classes( $class );
	$final_class = trim( $final_class ); 
	
	
	/* Install jPlayer. Not every page needs to load additional javascrips */
	add_action('wp_footer', 'btp_shortcode_install_audio_player');
	
	/* Compose output */
	$out = '';
	$out .= '<figure id="' . esc_attr( $final_id ) . '" class="' . $final_class . '">'."\n";
		$out .= '<audio src="' . esc_url( $mp3 ) .'">'."\n";			
		$out .= '</audio>'."\n";
		if ( strlen( $title ) ) {
			$out .= '<figcaption>' . esc_html( $title ) . '</figcaption>'."\n";
		}
	$out .= '</figure>'."\n";
	
	return $out;
}
add_shortcode( 'audio', 'btp_shortcode_audio' );



/**
 * Enqueues javascripts required for the jPlayer to work
 */
function btp_shortcode_install_audio_player() {
	wp_enqueue_script('jplayer', get_template_directory_uri().'/js/jquery.jplayer/jquery.jplayer.min.js', array('jquery'));
	wp_print_scripts( 'jplayer' );		
}



/* Add [twitter] shortcode to the global shortcode generator */
btp_shortgen_add_item(
	'twitter', 
	array(
		'label' 	=> '[twitter]',
		'atts' 		=> array(
			'username' 	=> array( 
				'view' 		=> 'String' 
			),
			'max' 		=> array( 
				'view' 		=> 'String',
				'hint'		=> __( 'Maximum items to display', 'btp_theme' ), 
			),				    	
		),
		'display' 		=> 'block',
		'group'		=> 'general',
		'subgroup'	=> 'misc',
		'position'	=> 500,			
	)	
);
	
	
/**
 * [twitter] shortcode callback function.
 * 
 * Based on http://www.zetalight.com/how-to-add-twitter-in-wordpress-using-a-simple-php-function/
 * Based on http://davidwalsh.name/linkify-twitter-feed
 * 
 * @param 			array $atts
 * @param			string $content
 * @return			string
 */
function btp_shortcode_twitter( $atts, $content = null ) {		
	extract( shortcode_atts( array(
		'username' 	=> 'bringthepixel',
		'max' 		=> 1		
	    ), $atts 
	));
	
	/* Sanitize arguments */
	$username = preg_replace( '/[^0-9a-zA-Z_-]/', '', $username );
	$max = absint( $max );
	
	/* Compose the transient name */
	$transient = 'btp_twitter_'.$username.'_'.$max;		
	
	$out = get_transient($transient);		
			
	//if ( false === $out ) {
		/* Compose the resource URL */	
		$resource = 'http://api.twitter.com/1/statuses/user_timeline.json?screen_name=' . $username . '&count=' . $max;
			
		$out = '';
		
		$result = wp_remote_get($resource);
		if ( is_wp_error( $result ) ) {
			return $out;		
		}
		
		$json = $result['body'];
		/*Convert JSON String to PHP Array */
		$tweets = json_decode($json);	
		
		/* Compose output */
		foreach ( (array) $tweets as $tweet) {			
			$_out = "\t\t" . '<li>' . "\n" .
						"\t\t\t" . '<div class="tweet">' . "\n" .
							"\t\t\t\t" . '<p class="tweet-text">%tweet_text%</p>' . "\n" .
							"\t\t\t\t" . '<p class="meta"><a href="%tweet_href%" rel="bookmark">%tweet_time%, %tweet_date%</a></p>' . "\n" .
						"\t\t\t" . '</div>' . "\n" .
					"\t\t" . '</li>' . "\n"; 

			$_out = str_replace(
				array(
					'%tweet_text%',
					'%tweet_href%',
					'%tweet_time%',
					'%tweet_date%',
				),
				array(
					btp_twitter_linkify( $tweet->text ),
					esc_url( 'http://twitter.com/' . $username . '/status/' . $tweet->id ), 
					date( get_option( 'time_format' ), strtotime( $tweet->created_at ) ),
					date( get_option( 'date_format' ), strtotime( $tweet->created_at ) ),
				),
				$_out
			);
			
			$out .= $_out;
		}
		$out = 	'<div class="twitter">' . "\n" .
					"\t" . '<ul class="tweets">' . "\n" .	
						$out . 
					"\t" . '</ul>' . "\n" .
					"\t" . '<p><a href="' . esc_url( 'http://twitter.com/' . $username ) . '"><span>' . sprintf( __( 'Follow @%s', 'btp_theme' ), esc_html( $username ) ) . '</span></a>' . '</p>' . "\n" .
				'</div>';						
						
		/* Set transient, 10 minutes */
		set_transient($transient, $out, 60*10);
	//}
	
	return $out;	
}
add_shortcode( 'twitter', 'btp_shortcode_twitter' );



/**
 * Linkifies twitter statuses
 * 
 * @param 			string $status_text
 * @return			string
 */
function btp_twitter_linkify( $status_text ) {
  	/* linkify URLs */
  	$status_text = preg_replace(
    	'/(https?:\/\/\S+)/',
    	'<a href="\1">\1</a>',
    	$status_text
  	);

  	/* linkify twitter users */
  	$status_text = preg_replace(
    	'/(^|\s)@(\w+)/',
    	'\1@<a href="http://twitter.com/\2">\2</a>',
    $status_text
  	);

	/* linkify tags */
  	$status_text = preg_replace(
    	'/(^|\s)#(\w+)/',
    	'\1#<a href="http://search.twitter.com/search?q=%23\2">\2</a>',
    $status_text
  	);

  	return $status_text;
}



/**
 * Encodes captcha 'secret' value 
 * 
 * @param 			string $v
 * @return			string
 */
function btp_captcha_encode( $v ) {
	return md5( $v . '41' );
}
	


/* Add [contact_form] shortcode to the global shortcode generator */
btp_shortgen_add_item( 
	'contact_form',
	array(
		'label'			=> '[contact_form]',
		'atts'			=> array(
			'email' 			=> array( 
				'view' 		=> 'String',
				'hint'		=> __( 'The recipient\'s email', 'btp_theme' ),
			),
			'name' 				=> array( 
				'view' 		=> 'String',
				'hint'		=> __( 'The recipient\'s name', 'btp_theme' ), 
			),
			'subject' 			=> array( 
				'view' 		=> 'String',
				'hint'		=> __( 'The subject of the email', 'btp_theme' ), 
			),
			'success_text'		=> array( 
				'view' 		=> 'String',
				'hint'		=> __( 'The text to display after sending an email uccessfully', 'btp_theme' ), 
			),
			'failure_text'		=> array( 
				'view' 		=> 'String',
				'hint'		=> __( 'The text to display, if the contact  form has errors', 'btp_theme' ), 
			),
		),
		'display'		=> 'block',
		'group'			=> 'general',
		'subgroup'		=> 'misc',
		'position'		=> 90,	
	)			 
); 
	


/**
 * [contact_form] shortcode callback function.
 * 
 * @param 			array $atts
 * @param			string $content
 * @return			string
 */
function btp_shortcode_contact_form( $atts, $content = null ) {
	/* We need a static counter to trace a shortcode without the id attribute */
	static $counter = 0;
	$counter++;
		
	extract( shortcode_atts( array(
		'id'			=> '',
		'class'			=> '',			
		'email'			=> '',
		'name'			=> '',		
		'subject'		=> '',
		'success'		=> '',
		'failure'		=> '',								
		), $atts ) );
		
	/* Compose final HTML id attribute */
	$final_id = strlen( $id ) ? $id : 'contact-form-counter-' . $counter;

	/* Compose final HTML class attribute */
	$final_class = '';
	$final_class .= 'contact-form ';
	$final_class .= sanitize_html_classes( $class );
	$final_class = trim( $final_class ); 
	
		
	$email 		= strlen( $email ) ? $email : get_option( 'admin_email' );	
	$name 		= strlen( $name ) ? $name : get_option( 'blogname' );
	$subject 	= strlen( $subject ) ? $subject : __( 'Website Contact Form', 'btp_theme' );
	$success 	= strlen( $success ) ? $success : __( 'We have received your email. Thank you.', 'btp_theme' ); 	
	$failure 	= strlen( $failure ) ? $failure : __( 'Ooops, something has gone wrong.', 'btp_theme' );
	
	$errors = array();
	$email_sent = null;
	
	/* Captcha vars */
	$captcha_n1 = rand(1, 15);
	$captcha_n2 = rand(1, 15);
	$captcha_hidden_hash = btp_captcha_encode($captcha_n1 + $captcha_n2);
			
	/* Initialize data */
	$field_name 			= '';
	$field_email 		= '';
	$field_message 		= '';
	$field_captcha		= '';
	
	/* Check if form has been submitted */
	if( isset($_POST['contact_form_submit_'.$counter]) ) {
		
		/* Filter input data */
		foreach ( $_POST as $key => $value ) {    
    		if( ini_get('magic_quotes_gpc') )
				$_POST[$key] = stripslashes( $_POST[$key] );	
			
    		$_POST[$key] = htmlspecialchars( strip_tags( $_POST[$key] ) );    
		}
		
		/* Get input data */
		$field_name 		= trim( $_POST['contact_form_name_'.$counter] );
		$field_email 		= trim( $_POST['contact_form_email_'.$counter] );
		$field_message 		= trim( $_POST['contact_form_message_'.$counter] );
		$field_captcha 		= trim( $_POST['contact_form_captcha_'.$counter] );
		$field_captcha_hash	= trim( $_POST['contact_form_captcha_hash_'.$counter] );			
		
		/* Validate input data */	
		if ( strlen( $field_name ) < 2 ) {
			$errors['name'] = true;
		}

		if ( !preg_match( '/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $field_email ) ) {
			$errors['email'] = true;
		}

		if ( strlen( $field_message ) < 2 ) {
			$errors['message'] = true;
		}

		if ( btp_captcha_encode( $field_captcha ) != $field_captcha_hash ) {
			$errors['captcha'] = true;
		}	
	
		if ( !count( $errors ) ) {
			// Send email 
       		
			$headers = 'From: ' . htmlspecialchars( strip_tags( $field_name ) ) . ' <'. htmlspecialchars( strip_tags( $field_email ) ) . '>' . "\r\n";
   			$email_sent = wp_mail( $email, $subject, $field_message, $headers);
		}	
	}
	
	/* Compose output */
	$out = '';	
	
				
	
	$out .= '<form action="' . get_permalink() . '#' . esc_attr( $final_id ) . '" method="post" id="' . esc_attr( $final_id ) . '" class="' . esc_attr( $final_class ) . '">';
	
		/* Notification message */
		if ( $email_sent === true )
			$out .= btp_shortcode_message(array( 'type' => 'success' ), esc_html( $success ) );
		elseif( $email_sent === false )
			$out .= btp_shortcode_message(array( 'type' => 'error'), esc_html( $failure ) );
	
		if ( count( $errors ) ) 
			$out .= btp_shortcode_message(array( 'type' => 'warning'), esc_html( __( 'Please correct the errors on this form.', 'btp_theme' ) ) );
		
		/* Name field */
		$out .= isset( $errors['name'] ) ? '<div class="form-row form-row-error">' : '<div class="form-row">';				
			$out .= '<label for="contact_form_name_' . esc_attr( $counter ) . '">';
				$out .= esc_html( __( 'Name', 'btp_theme' ) ) . ' <em class="meta">' . __( '(required)', 'btp_theme' );
			$out .=	'</em></label>';
			$out .= isset( $errors['name'] ) ? '<div class="form-message">'.esc_html(__('Please enter your name', 'btp_theme')).'</div>' : '' ;
			$out .= '<input type="text" id="contact_form_name_' . esc_attr( $counter ) . '" name="contact_form_name_'. esc_attr( $counter ) . '" value="' . $field_name . '" />';
		$out .= '</div>';
		
		/* Email field */
		$out .= isset( $errors['email'] ) ? '<div class="form-row form-row-error">' : '<div class="form-row">';				
			$out .= '<label for="contact_form_email_' . esc_attr( $counter ) . '">';
				$out .= esc_html( __( 'Email', 'btp_theme' ) ) . ' <em class="meta">' . __( '(required)', 'btp_theme' );
			$out .= '</em></label>';
			$out .= isset( $errors['email'] ) ? '<div class="form-message">'.esc_html( __('Please enter a valid email address', 'btp_theme') ).'</div>' : '' ;
			$out .= '<input type="text" id="contact_form_email_' . esc_attr( $counter ) . '" name="contact_form_email_' . esc_attr( $counter ) . '" value="' . $field_email . '" />';
		$out .= '</div>';
		
		/* Message field */
		$out .= isset( $errors['message'] ) ? '<div class="form-row form-row-error">' : '<div class="form-row">';
			$out .= '<label for="contact_form_message_' . esc_attr( $counter ) . '">' . esc_html( __( 'Message', 'btp_theme' ) ) . '</label>';
			$out .= isset( $errors['message'] ) ? '<div class="form-message">'.esc_html( __('Please leave a message', 'btp_theme') ).'</div>' : '' ;
			$out .= '<textarea id="contact_form_message_' . esc_attr( $counter ) . '" name="contact_form_message_' . esc_attr( $counter ) . '" rows="5" cols="5">' . esc_textarea( $field_message ) . '</textarea>';
		$out .= '</div>';
		
		/* Captcha field */
		$out .= isset( $errors['captcha'] ) ? '<div class="form-row form-row-error">' : '<div class="form-row">';
			$out .= '<label for="contact_form_captcha_' . esc_attr( $counter ) . '">';
				$out .= esc_html( $captcha_n1 . ' + ' . $captcha_n2 . ' ? ') . '<em class="meta">' . __( '(Are you human?)', 'btp_theme');
			$out .= '</em></label>';
			$out .= isset( $errors['captcha'] ) ? '<div class="form-message">' . esc_html( __( 'Please enter a valid result', 'btp_theme') ) . '</div>' : '' ;
			$out .= '<input type="text" class="u-2" id="contact_form_captcha_' . esc_attr( $counter ) . '" name="contact_form_captcha_' . esc_attr( $counter ) . '" value="" />';
		$out .= '</div>';				
		
		/* Hidden captcha hash */
		$out .= '<fieldset>';
			$out .= '<input type="hidden" id="contact_form_captcha_hash_' . esc_attr( $counter ) . '" name="contact_form_captcha_hash_' . esc_attr( $counter ) . '" value="' . $captcha_hidden_hash . '" />';
		$out .= '</fieldset>';			
		
		/* Submit button */
		$out .= '<div class="form-row">';
			$out .= '<input type="submit" name="contact_form_submit_' . esc_attr( $counter ) . '" id="contact_form_submit_' . esc_attr( $counter ) . '" value="' . __( 'Submit', 'btp_theme' ) . '" />';
		$out .= '</div>';			
		
	$out .= '</form>';
	
	return $out;
}
add_shortcode( 'contact_form', 'btp_shortcode_contact_form' );




/* Add [box] shortcode to the global shortcode generator */
btp_shortgen_add_item( 
	'box',
	array(
		'label'			=> '[box]',
		'atts'			=> array(
			'id' 			=> array( 
				'view' 			=> 'String',
				'hint'			=> 
					__( 'The id attribute specifies an id for an HTML element.', 'btp_theme' ) . '<br />' .
					__( 'It must be unique within the HTML document.', 'btp_theme' ) . '<br />' .
					__( '(Mainly for additional styling/scripting purposes)', 'btp_theme' ),	 
			),
			'class'			=> array(
				'view'			=> 'String',
				'hint'			=> 
					__( 'The class attribute specifies a class name for an HTML element.', 'btp_theme' ) . '<br />' .
					__( '(Mainly for additional styling/scripting purposes)', 'btp_theme' ),
			),
		),
		'content'		=> array( 
			'view' 	=> 'Text',
			'hint'	=> __( 'This shortcode should be use along with the box_header and the box_content shortcodes', 'btp_theme' ), 
		),
		'type'			=> 'block',
		'group'			=> 'general',
		'subgroup'		=> 'basic',	
		'position'		=> 150,
	)						 
);
/* Add [box_header] shortcode to the global shortcode generator */
btp_shortgen_add_item( 
	'box_header',
	array(
		'label'			=> '[box_header]',
		'atts'			=> array(
			'id' 			=> array( 
				'view' 			=> 'String',
				'hint'			=> 
					__( 'The id attribute specifies an id for an HTML element.', 'btp_theme' ) . '<br />' .
					__( 'It must be unique within the HTML document.', 'btp_theme' ) . '<br />' .
					__( '(Mainly for additional styling/scripting purposes)', 'btp_theme' ),	 
			),
			'class'			=> array(
				'view'			=> 'String',
				'hint'			=> 
					__( 'The class attribute specifies a class name for an HTML element.', 'btp_theme' ) . '<br />' .
					__( '(Mainly for additional styling/scripting purposes)', 'btp_theme' ),
			),
		),
		'content'		=> array( 
			'view' 	=> 'Text',
			'hint'	=> __( 'This shortcode should be use along with the box and the box_content shortcodes', 'btp_theme' ), 
		),
		'group'			=> 'general',
		'subgroup'		=> 'basic',	
		'position'		=> 151,
	)						 
); 
/* Add [box_content] shortcode to the global shortcode generator */
btp_shortgen_add_item( 
	'box_content',
	array(
		'label'			=> '[box_content]',
		'atts'			=> array(
			'id' 			=> array( 
				'view' 			=> 'String',
				'hint'			=> 
					__( 'The id attribute specifies an id for an HTML element.', 'btp_theme' ) . '<br />' .
					__( 'It must be unique within the HTML document.', 'btp_theme' ) . '<br />' .
					__( '(Mainly for additional styling/scripting purposes)', 'btp_theme' ),	 
			),
			'class'			=> array(
				'view'			=> 'String',
				'hint'			=> 
					__( 'The class attribute specifies a class name for an HTML element.', 'btp_theme' ) . '<br />' .
					__( '(Mainly for additional styling/scripting purposes)', 'btp_theme' ),
			),
		),
		'content'		=> array( 
			'view' 	=> 'Text',
			'hint'	=> __( 'This shortcode should be use along with the box and the box_header shortcodes', 'btp_theme' ), 
		),
		'type'			=> 'block',	
		'group'			=> 'general',
		'subgroup'		=> 'basic',	
		'position'		=> 152,
	)						 
);   
/* Add shortcode set to the global shortcode generator */
btp_shortgen_add_item(
	'*** Example Box 1',
	array(
		'label'		=> __('Example Box 1', 'btp_theme'),
		'result'	=> '[box]' . 
						"\n\n" .
						'[box_header]some header goes here...[/box_header]' .						 
						"\n\n" .
						'[box_content]' .
						"\n\n" .
						'some text goes here...' .
						"\n\n" .
						'[/box_content]' .
						"\n\n" .		
						'[/box]',
		'type'		=> 'block',	
		'group'		=> 'general',
		'subgroup'	=> 'basic',
		'position'	=> 153,														
	)
); 
/* Add shortcode set to the global shortcode generator */
btp_shortgen_add_item(
	'*** Example Box 2',
	array(
		'label'		=> __('Example Box 2', 'btp_theme'),
		'result'	=> '[box]' . 
						"\n\n" .
						'[box_header]' .
						"\n\n" .
						'<h3>some header goes here...</h3>' .
						"\n\n" .
						'[/box_header]' .						 
						"\n\n" .
						'[box_content]' .
						"\n\n" .
						'some text goes here...' .
						"\n\n" .
						'[/box_content]' .
						"\n\n" .		
						'[/box]',
		'type'		=> 'block',	
		'group'		=> 'general',
		'subgroup'	=> 'basic',
		'position'	=> 154,														
	)
); 




/**
 * [box] shortcode callback function.
 * 
 * @param 			array $atts
 * @param			string $content
 * @return			string
 */
function btp_shortcode_box( $atts, $content = null ) {
	/* We need a static counter to trace a shortcode without the id attribute */
	static $counter = 0;
	$counter++;
		
	extract( shortcode_atts( array(
		'id'			=> '',
		'class'			=> '',		
		), $atts ) );
		
	$content = preg_replace('#^<\/p>|<p>$#', '', $content);	
		
	/* Compose final HTML id attribute */
	$final_id = strlen( $id ) ? $id : 'box-counter-' . $counter;

	/* Compose final HTML class attribute */
	$final_class = '';
	$final_class .= 'box ';
	$final_class .= sanitize_html_classes( $class );
	$final_class = trim( $final_class ); 
		
	/* Compose output */
	$out = '';	
	
	$out .= '<div id="' . esc_attr( $final_id ) . '" ';
	$out .= 'class="' . esc_attr( $final_class ) . '" ';
	$out .= '>';
		$out .= do_shortcode(shortcode_unautop($content));
	$out .= '</div>';
	
	return $out;
}
add_shortcode( 'box', 'btp_shortcode_box' );



/**
 * [box_header] shortcode callback function.
 * 
 * @param 			array $atts
 * @param			string $content
 * @return			string
 */
function btp_shortcode_box_header( $atts, $content = null ) {
	/* We need a static counter to trace a shortcode without the id attribute */
	static $counter = 0;
	$counter++;
		
	extract( shortcode_atts( array(
		'id'			=> '',
		'class'			=> '',		
		), $atts ) );
		
	$content = preg_replace('#^<\/p>|<p>$#', '', $content);	
		
	/* Compose final HTML id attribute */
	$final_id = strlen( $id ) ? $id : 'box-header-counter-' . $counter;

	/* Compose final HTML class attribute */
	$final_class = '';
	$final_class .= 'box-header ';
	$final_class .= sanitize_html_classes( $class );
	$final_class = trim( $final_class ); 
		
	/* Compose output */
	$out = '';	
	
	$out .= '<div id="' . esc_attr( $final_id ) . '" ';
	$out .= 'class="' . esc_attr( $final_class ) . '" ';
	$out .= '>';
		$out .= do_shortcode(shortcode_unautop($content));
	$out .= '</div>';
	
	return $out;
}
add_shortcode( 'box_header', 'btp_shortcode_box_header' );



/**
 * [box_content] shortcode callback function.
 * 
 * @param 			array $atts
 * @param			string $content
 * @return			string
 */
function btp_shortcode_box_content( $atts, $content = null ) {
	/* We need a static counter to trace a shortcode without the id attribute */
	static $counter = 0;
	$counter++;
		
	extract( shortcode_atts( array(
		'id'			=> '',
		'class'			=> '',		
		), $atts ) );
		
	$content = preg_replace('#^<\/p>|<p>$#', '', $content);	
		
	/* Compose final HTML id attribute */
	$final_id = strlen( $id ) ? $id : 'box-content-counter-' . $counter;

	/* Compose final HTML class attribute */
	$final_class = '';
	$final_class .= 'box-content ';
	$final_class .= sanitize_html_classes( $class );
	$final_class = trim( $final_class ); 
		
	/* Compose output */
	$out = '';	
	
	$out .= '<div id="' . esc_attr( $final_id ) . '" class="' . esc_attr( $final_class ) . '" >'.
				'<div class="inner">' . 
					do_shortcode( shortcode_unautop( $content ) ) .
				'</div>' .
				'<div class="background"></div>' .		 
			'</div>';
	
	return $out;
}
add_shortcode( 'box_content', 'btp_shortcode_box_content' );







/* Add [button] shortcode to the global shortcode generator */
btp_shortgen_add_item( 
	'progress_bar',
	array(
		'label'			=> '[progress_bar]',
		'atts'			=> array(
			'id' 			=> array( 
				'view' 			=> 'String',
				'hint'			=> 
					__( 'The id attribute specifies an id for an HTML element.', 'btp_theme' ) . '<br />' .
					__( 'It must be unique within the HTML document.', 'btp_theme' ) . '<br />' .
					__( '(Mainly for additional styling/scripting purposes)', 'btp_theme' ),	 
			),
			'class'			=> array(
				'view'			=> 'String',
				'hint'			=> 
					__( 'The class attribute specifies a class name for an HTML element.', 'btp_theme' ) . '<br />' .
					__( '(Mainly for additional styling/scripting purposes)', 'btp_theme' ),
			),
			'value' 			=> array( 
				'view' 			=> 'String',
				'hint'			=> 
					__( '0-100 range', 'btp_theme' ),	 
			),
            'text_color'		=> array(
                'view' 			=> 'Color',
                'hint'			=> __( 'Text Color', 'btp_theme' ),
            ),
            'bg_color'		=> array(
                'view' 			=> 'Color',
                'hint'			=> __( 'Background Color', 'btp_theme' ),
            ),
		),
		'group'			=> 'general',
		'subgroup'		=> 'basic',	
		'position'		=> 1780,
	)						 
); 




/**
 * [progress_bar] shortcode callback function.
 * 
 * @param 			array $atts
 * @param			string $content
 * @return			string
 */
function btp_shortcode_progress_bar( $atts, $content = null ) {
	/* We need a static counter to trace a shortcode without the id attribute */
	static $counter = 0;
	$counter++;
		
	extract( shortcode_atts( array(
		'id'			=> '',
		'class'			=> '',	
		'value'			=> 50,
        'bg_color'      => '',
        'text_color'    => '',
		), $atts ) );
		
	$content = preg_replace('#^<\/p>|<p>$#', '', $content);

	$value = absint($value);
	if  ($value < 0 ) {
		$value = 0;
	}	

	if( $value > 100 ) {
		$value = 100;	
	}
		
	/* Compose final HTML id attribute */
	$final_id = strlen( $id ) ? $id : 'progress-bar-counter-' . $counter;

	/* Compose final HTML class attribute */
	$final_class = '';
	$final_class .= 'progress-bar ';
	$final_class .= sanitize_html_classes( $class );
	$final_class = trim( $final_class );


    /* Compose CSS */
    $css = '';
    if ( strlen( $text_color ) ) {
        $color = new BTP_Color($text_color);
        $css .= '#' . esc_attr($final_id) . '.progress-bar > .inner > span {' . "\n" .
            'color: #' . $color->get_hex() . ';' ."\n" .
            '}' ."\n";
    }

    if ( strlen( $bg_color ) ) {
        $color = new BTP_Color($bg_color);
        $hex = $color->get_hex();
        list($from, $to) = BTP_Colorgen::get_warm_gradient( $color );
        $from_hex = $from->get_hex();
        $to_hex = $to->get_hex();

        $css .= '#' . esc_attr($final_id) . '.progress-bar > .inner > span {' . "\n" .
            'background-color: #' . $to_hex . ';' . "\n" .
            '}' . "\n";

        $css .= '#' . esc_attr($final_id) . '.progress-bar > .inner {' . "\n" .
            'background-color: #' . $hex . ';' . "\n" .
            'filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, startColorstr=#' . $from_hex . ', endColorstr=#ff' . $to_hex . ');' . "\n" .
            '-ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=#' . $from_hex . ', endColorstr=#' . $to_hex. ')";' . "\n" .

            'background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#' . $from_hex . '), to(#'. $to_hex . '));' . "\n" .
            'background-image: -webkit-linear-gradient(top, #' . $from_hex . ', #' . $to_hex . ');' . "\n" .
            'background-image:    -moz-linear-gradient(top, #' . $from_hex . ', #' . $to_hex . ');' . "\n" .
            'background-image:     -ms-linear-gradient(top, #' . $from_hex . ', #' . $to_hex . ');' . "\n" .
            'background-image:      -o-linear-gradient(top, #' . $from_hex . ', #' . $to_hex . ');' . "\n" .
            'background-image:         linear-gradient(top, #' . $from_hex . ', #' . $to_hex . ');' . "\n" .
            '}' . "\n";

        $css .= '#' . esc_attr($final_id) . '.progress-bar > .inner > span:after {' . "\n" .
            'border-color: #' . $to_hex . ';' . "\n" .
            '}' . "\n";
    }
		
	/* Compose output */
	$out =  '%css%' .
            '<div id="%id%" class="%class%">' .
                '<div class="inner" style="width:%value%%;">' .
                    '<span>%value%</span>' .
                '</div>' .
            '</div>';

    $out = str_replace(
        array(
            '%css%',
            '%id%',
            '%class%',
            '%value%'
        ),
        array(
            strlen($css) ? "\n" . '<style type="text/css" scoped="scoped">' . $css . '</style>' . "\n" : '',
            esc_attr( $final_id ),
            esc_attr( $final_class ),
            $value
        ),
        $out
    );
	
	return $out;
}
add_shortcode( 'progress_bar', 'btp_shortcode_progress_bar' );

?>