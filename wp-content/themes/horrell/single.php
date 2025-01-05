<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package horrell
 */

get_header();
?>

	<main id="primary" class="site-main blog-single-page">
		<!-- Top banner and breadcrumb menu -->
		<?php
		get_template_part( "template-parts/content", "top-banner" );
		get_template_part( "template-parts/content", "title-breadcrumb" );
		?>

		<div class="container">
			<div class="row">
				<div class="col-lg-9 order-1 order-lg-2 article-wrapper">
					<?php
					while ( have_posts() ) :
						the_post();
			
						get_template_part( 'template-parts/content', get_post_type() );
			
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
			
					endwhile; // End of the loop.
					?>
				</div>
		
				<!-- sidebar -->
				<div class="col-lg-3 order-2 order-lg-1">
					<?php
					get_sidebar();
					?>
				</div>
			</div>
		</div>


	</main><!-- #main -->

<?php
get_footer();
