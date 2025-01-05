<?php
/**
 * The archive template file
 *
 * @package horrell
 *
 * cspell: ignore horrell ptype
 */

get_header();
?>
	<main class="properties-archive-page">
		<section class="page-title">
			<div class="container d-flex justify-content-between align-items-end">
				<?php
				if ( isset( $_GET['ptype'] ) && ! empty( $_GET['ptype'] ) ) {
					echo '<h2>' . esc_html( ucfirst( $_GET['ptype'] ) ) . ' Properties' . '</h2>';
				} else {
					echo '<h2>' . esc_html( get_queried_object()->label ) . '</h2>';
				}
				echo horrell_breadcrumb_html();
				?>
			</div>
		</section><!-- .page-title -->

		<?php
		get_template_part( 'template-parts/property/content', 'header-links' );
		get_template_part( 'template-parts/property/content', 'listing' );
		?>
	</main>
	<style>
		.ajax-loader {
			display: inline-block;
			border: 3px solid #f3f3f3; /* Light grey */
			border-top: 3px solid #b99c64;
			border-radius: 50%;
			width: 20px;
			height: 20px;
			animation: spin 1s linear infinite;
		}

		@keyframes spin {
			0% {
				transform: rotate(0deg);
			}
			100% {
				transform: rotate(360deg);
			}
		}
	</style>

<?php
get_template_part( 'template-parts/property/content', 'advanced-search-form' );
?>
<?php
get_footer();
