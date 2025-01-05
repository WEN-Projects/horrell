<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package horrell
 */

get_header();
?>

<main id="primary" class="site-main 404-page">
	<!-- Top banner and breadcrumb menu -->
	<?php
	get_template_part( 'template-parts/content', 'top-banner' );
	get_template_part( 'template-parts/content', 'title-breadcrumb', array( 'title' => 'Oops! The web page or commercial real estate listing cannot be found.' ) );
	?>

	<section class="error-404 not-found">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 order-1 order-lg-2">
					<div class="page-content">
						<p><?php esc_html_e( 'Please consider modifying the search criteria.', 'horrell' ); ?></p>
						<p><?php esc_html_e( 'Need assistance? Feel free to call 615.256.7114 to speak with a team member.', 'horrell' ); ?></p>
						<?php
						get_search_form();
						// the_widget( 'WP_Widget_Recent_Posts' );
						?>
						<?php
						/*
								<div class="widget widget_categories">
									<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'horrell' ); ?></h2>
									<ul>
										<?php
										wp_list_categories(
											array(
												'orderby'    => 'count',
												'order'      => 'DESC',
												'show_count' => 1,
												'title_li'   => '',
												'number'     => 10,
											)
										);
										?>
									</ul>
								</div><!-- .widget -->
								*/
						?>
						<?php
						/*
						 translators: %1$s: smiley */
						// $horrell_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'horrell' ), convert_smilies( ':)' ) ) . '</p>';
						// the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$horrell_archive_content" );
						// the_widget( 'WP_Widget_Tag_Cloud' );
						?>
					</div><!-- .page-content -->
				</div>

				<!-- sidebar -->
				<div class="col-lg-3 order-2 order-lg-1">
					<?php
					get_sidebar();
					?>
				</div>
			</div>
		</div>
	</section><!-- .error-404 -->

</main><!-- #main -->

<?php
get_footer();
