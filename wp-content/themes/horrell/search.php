<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package horrell
 */

get_header();
?>

    <main id="primary" class="site-main search-result-page">
        <!-- Top banner and breadcrumb menu -->
		<?php
		get_template_part( "template-parts/content", "top-banner" );
		get_template_part( "template-parts/content", "title-breadcrumb", array( "title" => esc_html__( 'Search Results for: ' . get_search_query(), 'horrell' ) ) );
		?>

        <div class="container">
            <div class="row">
                <div class="col-lg-9 order-1 order-lg-2">
					<?php if ( have_posts() ) : ?>
						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();
							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );
						endwhile;
						?>
                        <div class="pagination-wrapper d-flex justify-content-sm-end align-items-center flex-wrap">
							<?php
							global $wp_query;
							$big = 999999999; // need an unlikely integer
							echo isset( $paged ) && $paged > 1 ? "<a class='prev' href='" . get_pagenum_link( 1 ) . "'>‹‹</a>" : "";
							the_posts_pagination( array(
								'show_all'           => false,
								'screen_reader_text' => ' ',
								'prev_text'          => __( '‹', 'horrell' ),
								'next_text'          => __( '›', 'horrell' ),
								'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( '', 'horrell' ) . ' </span>',
							) );
							echo isset( $paged ) && isset( $wp_query->max_num_pages ) && $paged != $wp_query->max_num_pages ? "<a class='next' href='" . get_pagenum_link( $wp_query->max_num_pages ) . "'>››</a>" : "";
							?>
                        </div>

					<?php
					else :
						get_template_part( 'template-parts/content', 'none' );
					endif;
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
