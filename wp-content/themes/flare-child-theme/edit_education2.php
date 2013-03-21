<?php

/*

 * Template Name: Edit Education 2

 *

 */



?>

<?php get_header(); ?>

	<?php  the_post(); ?>

		<?php get_template_part( 'precontent' ); ?>

<div id="content">

		<div id="content-inner" class="<?php echo btp_content_get_class(); ?>">

			<div class="grid">

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'c-three-fourth' ); ?>>									

					<div class="entry-content">	

						<?php include ('custompages/education.html'); ?>

						<?php btp_wp_link_pages(); ?>

					</div><!-- .entry-content -->

					

					<div class="entry-utility">		

						<?php edit_post_link( __( 'Edit', 'btp_theme' ), '<span class="edit-link">', '</span>' ); ?>

					</div><!-- .entry-utility -->

				</article>

				

				<aside class="c-one-fourth sidebar after">

					<div class="helper"></div>

					<div class="inner">

						<?php get_template_part( 'page_nav' ); ?>

					</div>

					<div class="helper"></div>

				</aside>

			</div>

				

		</div><!-- #content-inner -->

		<div class="background"><div></div></div>

	</div><!-- #content -->

		

<?php get_footer(); ?>
