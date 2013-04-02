<?php



/*



 * Template Name: Edit Employment



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







						<?php include ('custompages/employment.html'); ?>







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



$link = mysql_connect('localhost', 'themaro0_dev1', 'buildaresume!1');
if (!link) {
die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db('themaro0_dev1', $link);
if (!db_selected){
die('Cant use DB: ' . mysql_error());
}

$result = json_decode($o);
foreach($result as $key => $value) {
    if($value) {

            //how to use json array to insert data in Database
        mysql_query("INSERT INTO tablename (company, Title, city, State, country) VALUES ($value->company, $value->Title,$value->city, $value->State, $value->country)");
    }
    mysql_close($link);



<?php get_footer(); ?>
