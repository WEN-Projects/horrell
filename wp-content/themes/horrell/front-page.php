<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package horrell
 */

get_header();
?>
<?php
if ( have_posts() ) {
	/* Start the Loop */
	while ( have_posts() ) {
		the_post();
		$banner_gallery = get_field( "banner_gallery" );
		?>
		<?php
		echo do_shortcode( '[smartslider3 slider="3"]' );
		?>
        <main id="primary" class="site-main">
            <section class="home-content">
                <div class="container text-center">
					<?php
					the_content();
					?>
                </div>
            </section>
        </main><!-- #main -->

		<?php
	}
}
get_footer();
