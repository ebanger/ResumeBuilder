<?php

/*

 * Template Name: Edit Contact

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

						<?php the_content() ?>

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
<?php

global $wpdb;

//for the form can't we just do something like this:
<form method ="post" action = "">

<p><strong>Street Address:</strong><br/>
<input type="text" name="address1" > </br>
<input type="text" name="address2">
</p>

<p><strong>State:</strong><br/>
<input type="text" name="state" /> </br>

<p><strong>Country:</strong><br/>
<input type="text" name="country" /> </br>

<p><strong>City:</strong><br/>
<input type="text" name="city" > </br>

<p><strong>Postal Code:</strong><br/>
<input type="text" name="zip" > </br>

<p><strong>Primary Phone:</strong><br/>
<input type="text" name="phone1" > </br>

<p><strong>Secondary Phone:</strong><br/>
<input type="text" name="phone2" > </br>

<p><strong>Email Address:</strong><br/>
<input type="text" name="email" > </br>
<p>
<form method="link" action="education.php">
<input type="submit" value="Next">
</form></p> 
</form>

$link = mysql_connect('localhost', 'themaro0_dev1', 'buildaresume!1');
if (!link) {
die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db('themaro0_dev1', $link);
if (!db_selected){
die('Cant use DB: ' . mysql_error());
}

$sSql = "INSERT INTO users (address1, address2, state, country, city, zip, phone1, phone2, email) 
                    VALUES ('" . $address1 . "', '" . $address2 . "', '" . $state . "', '" . $country . "', '" . $city . "', '" . $zip . "', '" . $phone1 . "', '" . $phone2 . "', '" . $email . "')";
                    
                    mysql_query($sSql);
                    mysql_close($link);
                    
?>
                    
                    
                    
		

<?php get_footer(); ?>
