<?php
/*
Template Name: About
*/
get_header();
?>
<main class="about-page">
	<?php
	if ( have_posts() ) {
		/* Start the Loop */
		while ( have_posts() ) {
			the_post();
			get_template_part( "template-parts/content", "about" );
		}
	}
	?>
</main>
<?php
get_footer();