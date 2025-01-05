<?php
/**
 * The Property header links file
 *
 * @package horrell
 *
 * cspell: ignore horrell bloginfo ptype
 */

?>

<section class="dark-section properties-dark-section">
	<div class="container-fluid">
		<div class="section-wrapper text-center">
			<?php
			// menu content rendered  using the details from nav menu "properties-page-search-menu".
			if ( isset( wp_get_nav_menu_object( 'properties-page-search-menu' )->term_id ) ) {
				$menu_id = wp_get_nav_menu_object( 'properties-page-search-menu' )->term_id;
				echo get_field( 'search_description_text', 'term_' . $menu_id );
				wp_nav_menu(
					array(
						'theme_location' => 'menu-properties',
						'container'      => false,
						'menu_class'     => 'properties-menu',
					)
				);
			}
			if ( get_field( 'show_download_menus', 'term_' . $menu_id ) ) { // only show if the option is checked in nav menu settings (custom field).
				?>
				<ul class="download-menu">
					<?php
					if ( get_field( 'gs_availability_list', 'option' ) ) {
						?>
						<li>
							<a href="<?php echo bloginfo( 'url' ); ?>/dynamic-pdf" target="_blank"><?php esc_html_e( 'DOWNLOAD AVAILABILITY LIST', 'horrell' ); ?></a>
						</li>
						<?php
					}
					if ( isset( $_GET['ptype'] ) && ! empty( $_GET['ptype'] ) ) {
						?>
						<li><a href="<?php echo bloginfo( 'url' ); ?>/dynamic-pdf?ptype=<?php echo $_GET['ptype']; ?>" target="_blank">Download <?php echo $_GET['ptype']; ?> Availability List</a></li>
						<?php
					}
					?>
				</ul>
				<?php
			}
			?>
		</div>
	</div>
</section><!-- .dark-section -->
