<?php //phpcs:ignore
/**
 * About Page Content
 *
 * @package horrell
 *
 * cSpell: ignore phpcs, horrell
 */

$featured_image        = get_field( 'about_featured_image' );
$history_section_title = get_field( 'history_section_title' );
$history_image         = get_field( 'history_image' );
$history_year          = get_field( 'history_year' );
$history_content       = get_field( 'history_content' );
?>

<section class="page-title">
	<div class="container d-flex justify-content-between align-items-end">
		<?php
		//phpcs:ignore
		the_title( '<h2>', '</h2>' );
		//phpcs:ignore
		echo horrell_breadcrumb_html();
		?>
	</div>
</section><!-- .page-title -->

<section class="abt-service-section dark-section">
	<div class="container">
		<div class="service-wrapper">
			<?php
			the_content();
			?>
		</div>
	</div>
</section><!-- .abt-service-section -->

<section class="abt-history-section">
	<div class="container">
		<?php
		echo $history_section_title ? '<h2>' . esc_html( $history_section_title ) . '</h2>' : '';

		if ( have_rows( 'histories' ) ) :
			while ( have_rows( 'histories' ) ) :
				the_row();
				$history_image   = get_sub_field( 'history_image' );
				$history_year    = get_sub_field( 'history_year' );
				$history_content = get_sub_field( 'history_content' );
				?>
				<div class="d-flex flex-wrap">
					<div class="founder-image">
						<?php
						if ( isset( $history_image['ID'] ) ) {
							echo wp_get_attachment_image( $history_image['ID'], 'full' );
						}
						?>
					</div>
					<div class="history-content d-flex">
						<div class="year">
							<?php
							echo $history_year ? '<h4>' . esc_html( $history_year ) . '</h4>' : '';
							?>
						</div>
						<div class="content">
							<?php
							if ( $history_content ) {
								echo $history_content; //phpcs:ignore
							}
							?>
						</div>
					</div>
				</div>
				<?php
			endwhile;
		endif;
		?>
	</div>
</section><!-- .abt-history-section -->

<section class="about-image">
	<div class="container">
		<?php
		if ( isset( $featured_image['ID'] ) ) {
			echo wp_get_attachment_image( $featured_image['ID'], 'full' );
		}
		?>
	</div>
</section><!-- .about-image -->

<section class="abt-experience-section">
	<div class="container">
		<div class="experience-wrapper">
			<h3><?php echo esc_html_e( 'Experience', 'horrell' ); ?></h3>
			<?php
			if ( have_rows( 'experiences' ) ) :
				// Loop through rows.
				while ( have_rows( 'experiences' ) ) :
					the_row();
					$exp_year    = get_sub_field( 'year' );
					$description = get_sub_field( 'description' );
					?>
					<div class="experience d-flex">
						<div class="year">
							<h4><?php echo esc_html( $exp_year ); ?></h4>
						</div>
						<div class="content">
							<?php echo $description; //phpcs:ignore ?>
						</div>
					</div>
					<?php
				endwhile;
			endif;
			?>
		</div>
	</div>
</section><!-- .abt-experience-section -->
