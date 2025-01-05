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

    <main id="primary" class="site-main blog-page">
        <!-- Top banner and breadcrumb menu -->
		<?php
		get_template_part( "template-parts/content", "top-banner" );
		get_template_part( "template-parts/content", "title-breadcrumb", array( "title" => "Blog" ) );
		?>

        <!-- blog listing wrapper -->
        <div class="container">
            <div class="row">
                <!-- blog lists -->
                <div class="blog-list-wrapper col-lg-9 order-1 order-lg-2">
					<?php
					if ( have_posts() ) :
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();
							?>
                            <div class="row blog-item"><!--blog starts-->
								<?php if ( has_post_thumbnail() ) { ?>
                                    <div class="col-sm-4">
										<?php
										the_post_thumbnail( 'medium' );
										?>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="blog-title">
                                            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                                        </div>
                                        <p><?php the_excerpt(); ?></p>
                                        <a href="<?php the_permalink(); ?>" class="readmore">Continue Reading</a>
                                    </div>
                                    <hr>
								<?php } else { ?>
                                    <div class="col-sm-12">
                                        <div class="blog-title">
                                            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                                        </div>
                                        <p><?php the_excerpt(); ?></p>
                                        <a href="<?php the_permalink(); ?>" class="readmore">Continue Reading</a>
                                    </div>
                                    <hr>
								<?php } ?>
                            </div>
						<?php
						endwhile;
                        ?>

                        <div class="pagination-wrapper d-flex justify-content-sm-end align-items-center flex-wrap">
                            <?php
                            global $wp_query;
                            $big = 999999999; // need an unlikely integer
                            echo isset( $paged ) && $paged > 1 ? "<a class='prev' href='" . get_pagenum_link( 1 ) . "'>‹‹</a>" : "";
                            the_posts_pagination( array(
                                'show_all'           => true,
                                'screen_reader_text' => ' ',
                                'prev_text'          => __( '‹', 'horrell' ),
                                'next_text'          => __( '›', 'horrell' ),
                                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( '', 'horrell' ) . ' </span>',
                            ) );
                            echo isset( $paged ) && isset( $wp_query->max_num_pages ) && $paged != $wp_query->max_num_pages ? "<a class='next' href='" . get_pagenum_link( $wp_query->max_num_pages ) . "'>››</a>" : "";
                            ?>
                        </div>
                    <?php
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