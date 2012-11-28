<?php 
/**
 * The Template Part for displaying Comments.
 * 
 * @package BTP_Flare_Theme
 */
?>
<?php

/* Prevent direct script access */
if ( !empty( $_SERVER[ 'SCRIPT_FILENAME' ] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die ( 'No direct script access allowed' );
}

?>  
<?php if ( post_password_required() ): ?>
	<section id="comments">
	<?php 
		$object = get_post_type_object( get_post_type() );
		$text = sprintf( __( "This %s is password protected. Enter the password to view any comments", 'btp_theme' ), $object->labels->singular_name );
		echo '<p class="no-password">' . esc_html( $text ) . '</p>';
	?>	
	</section><!-- #comments -->
<?php elseif( get_comments_number() || comments_open() ): ?>	
	<section id="comments">
	<?php if ( get_comments_number() ): ?>
		<header>
			<h3 id="comments-title">
			<?php
				printf( _n( 'One Comment', '%1$s Comments', get_comments_number(), 'btp_theme' ),
				number_format_i18n( get_comments_number() ) );
			?>
			</h3>	
		</header>
		
		<ol class="commentlist">
			<?php wp_list_comments(array( 'type' => 'comment', 'callback' => 'btp_wp_list_comments_callback' )); ?>
		</ol>			
	<?php endif; ?>
	
	<?php 
		$pagination = paginate_comments_links( array( 'echo' => false ) );
		
		if ( strlen( $pagination ) ) {
			echo '<nav class="comment-pagination"><p>' . $pagination . '</p></nav>';
		}	
	
		if ( comments_open() ) {
			global $post;	

			if ( is_front_page() ) {
				btp_helpmode_render(
					__( 'Do you want to hide comments?', 'btp_theme' ),
					'<ul>' .
						'<li>' . sprintf( __( 'When <a href="%s">editing this page</a> make sure the "Discussion" box is visible: configure your screen options in the top-right section of the WordPress Admin. Sometimes this box can be hidden.', 'btp_theme' ), get_edit_post_link() ) . '</li>' .
						'<li>' . __( 'Uncheck "Allow comments" and "Allow trackbacks and pingbacks on this page".', 'btp_theme' ) . '</li>' .
						'<li>' . __( 'Save changes', 'btp_theme' ) . '</li>' .
					'</ul>',
					'warning'
				);
			}
			
			comment_form();
		}	
	?>
	</section><!-- #comments -->
<?php endif; ?>