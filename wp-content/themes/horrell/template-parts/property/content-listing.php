<?php

/**
 * The Property listing template
 *
 * @package horrell
 *
 * cspell:ignore horrell
 */

?>
<section class="properties-listing">
    <div class="container">
        <!-- ADD SORTING FORM HERE -->
        <div class="sort-form-wrapper">
            <form class="sort-form grid-sort-form layout-sort-form"
                  action="<?php echo esc_url( get_post_type_archive_link( 'property' ) ); ?>"
                  method="GET"
				<?php
				if ( ! isset( $_GET['layout_view'] ) || ( isset( $_GET['layout_view'] ) && 'list' == $_GET['layout_view'] ) ) {
					echo 'style="display:none"';
				}
				?>
            >
				<?php
				if ( ! empty( $_GET ) ) { // check the GET request parameters from the Advanced Search form (Merge the Sorting with Advanced Search Functionality).
					foreach ( $_GET as $key => $parm ) {
						if ( 'p_offer_type' === $key || 'sort_by' === $key ) { // hidden input fields to merge Advanced Search with Sorting.
							continue;
						}
						if ( ! empty( $parm ) ) {
							?>
                            <input name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $parm ); ?>"
                                   type="hidden"/>
							<?php
						}
					}
				}
				?>
                <label><?php esc_html_e( 'Sort By:', 'horrell' ); ?> </label>
                <select name="p_offer_type" id="p_type">
                    <option value="0" disabled="disabled"
                            selected><?php esc_html_e( 'Select Type', 'horrell' ); ?></option>
                    <option value="lease" <?php echo ( isset( $_GET['p_offer_type'] ) && 'lease' === $_GET['p_offer_type'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'For Lease', 'horrell' ); ?></option>
                    <option value="sale" <?php echo ( isset( $_GET['p_offer_type'] ) && 'sale' === $_GET['p_offer_type'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'For Sale', 'horrell' ); ?></option>
                </select>
                <select name="sort_by" id="sorting-lease" class="disabled">
					<?php
					// all lease parameters for sorting.
					$lease_sorting_options = array(
						array(
							'value' => '',
							'label' => 'Select sort option',
						),
						array(
							'value' => 'actual_size_in_sf desc',
							'label' => 'Available (High to Low)',
						),
						array(
							'value' => 'actual_size_in_sf asc',
							'label' => 'Available (Low to High)',
						),
						array(
							'value' => 'actual_rental_rate desc',
							'label' => 'Rental Rate (High to Low)',
						),
						array(
							'value' => 'actual_rental_rate asc',
							'label' => 'Rental Rate (Low to High)',
						),
						// array( "value" => "property_type asc", "label" => "Property Type (A to Z)" ),
						// array( "value" => "property_type desc", "label" => "Property Type (Z to A)" ),
						array(
							'value' => 'street_name asc',
							'label' => 'Street (A to Z)',
						),
						array(
							'value' => 'street_name desc',
							'label' => 'Street (Z to A)',
						),
					);
					foreach ( $lease_sorting_options as $lease_sorting_options ) {
						?>
                        <option <?php echo ( isset( $_GET['sort_by'] ) && $_GET['sort_by'] === $lease_sorting_options['value'] ) ? 'selected' : ''; ?>
                                value="<?php echo esc_attr( $lease_sorting_options['value'] ); ?>">
							<?php echo esc_html( $lease_sorting_options['label'] ); ?>
                        </option>
						<?php
					}
					?>
                </select>
                <select name="sort_by" id="sorting-sale" class="disabled">
					<?php
					// all sale parameters for sorting.
					$sale_sorting_options = array(
						array(
							'value' => '',
							'label' => 'Select sort option',
						),
						array(
							'value' => 'sale_building_size desc',
							'label' => 'Building Size (High to Low)',
						),
						array(
							'value' => 'sale_building_size asc',
							'label' => 'Building Size (Low to High)',
						),
						array(
							'value' => 'sale_lot_size desc',
							'label' => 'Lot Size (High to Low)',
						),
						array(
							'value' => 'sale_lot_size asc',
							'label' => 'Lot Size (Low to High)',
						),
						array(
							'value' => 'sale_price desc',
							'label' => 'Sale Price (High to Low)',
						),
						array(
							'value' => 'sale_price asc',
							'label' => 'Sale Price (Low to High)',
						),
						// array( "value" => "property_type asc", "label" => "Property Type (A to Z)" ),
						// array( "value" => "property_type desc", "label" => "Property Type (Z to A)" ),
						array(
							'value' => 'street_name asc',
							'label' => 'Street (A to Z',
						),
						array(
							'value' => 'street_name desc',
							'label' => 'Street (Z to A)',
						),
					);
					foreach ( $sale_sorting_options as $sale_sorting_options ) {
						?>
                        <option <?php echo ( isset( $_GET['sort_by'] ) && $_GET['sort_by'] === $sale_sorting_options['value'] ) ? 'selected' : ''; ?>
                                value="<?php echo esc_attr( $sale_sorting_options['value'] ); ?>">
							<?php echo esc_html( $sale_sorting_options['label'] ); ?>
                        </option>
						<?php
					}
					?>
                </select>
                <input type="submit" value="Sort" class="sort-btn">
            </form>
            <div class="layout-switcher">
				<?php $selected_layout_view = ( isset( $_GET['layout_view'] ) && 'grid' === $_GET['layout_view'] ) ? 'layout-grid' : 'layout-list'; ?>
                <label><?php esc_html_e( 'View:', 'horrell' ); ?> </label>
                <select id="property_layout_view">
                    <option <?php echo ( 'layout-grid' === $selected_layout_view ) ? 'selected' : ''; ?>
                            value="grid"><?php esc_html_e( 'Grid', 'horrell' ); ?></option>
                    <option <?php echo ( 'layout-list' === $selected_layout_view ) ? 'selected' : ''; ?>
                            value="list"><?php esc_html_e( 'List', 'horrell' ); ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="container <?php echo esc_attr( $selected_layout_view . '-container' ); ?>">
        <div class="row properties-list <?php echo esc_attr( $selected_layout_view ); ?>">
            <div class="table-header
">
                <form class="layout-sort-form">
					<?php
					if ( ! empty( $_GET ) ) { // check the GET request parameters from the Advanced Search form (Merge the Sorting with Advanced Search Functionality).
						foreach ( $_GET as $key => $parm ) {
							if ( 'p_offer_type' === $key || 'sort_by' === $key || 'layout_view' === $key ) { // hidden input fields to merge Advanced Search with Sorting.
								continue;
							}
							if ( ! empty( $parm ) ) {
								?>
                                <input name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $parm ); ?>"
                                       type="hidden"/>
								<?php
							}
						}
					}
					$layout_view = isset( $_GET['layout_view'] ) && 'grid' == $_GET['layout_view'] ? 'grid' : 'list';
					?>
                    <input name="layout_view" value="<?php echo $layout_view; ?>" type="hidden"/>
                    <ul>
                        <li></li>
                        <li>Address</li>
                        <li>Type</li>
                        <li class="has-dropdown">
                            <span>SQ FT/LOT size</span>
                            <div class="asc-des-sort">
                                <label><input type="radio" class="list-view-sort" name="sort_by"
                                              value="actual_size_in_sf asc"
										<?php
										if ( isset( $_GET['sort_by'] ) && $_GET['sort_by'] === 'actual_size_in_sf asc' ) {
											echo 'checked';
										}
										?>
                                    >Ascending Order</label>
                                <label><input type="radio" class="list-view-sort" name="sort_by"
                                              value="actual_size_in_sf desc"
										<?php
										if ( isset( $_GET['sort_by'] ) && $_GET['sort_by'] === 'actual_size_in_sf desc' ) {
											echo 'checked';
										}
										?>
                                    >Descending Order</label>
                            </div>
                        </li>
                        <li>
                            <span>Warehouse/Office SQ FT</span>
                        </li>
                        <li class="has-dropdown">
                            <span>Lease Rate</span>
                            <div class="asc-des-sort">
                                <label><input type="radio" class="list-view-sort" name="sort_by"
                                              value="actual_rental_rate asc"
										<?php
										if ( isset( $_GET['sort_by'] ) && $_GET['sort_by'] === 'actual_rental_rate asc' ) {
											echo 'checked';
										}
										?>
                                    >Ascending
                                    Order</label>
                                <label><input type="radio" class="list-view-sort" name="sort_by"
                                              value="actual_rental_rate desc"
										<?php
										if ( isset( $_GET['sort_by'] ) && $_GET['sort_by'] === 'actual_rental_rate desc' ) {
											echo 'checked';
										}
										?>
                                    >Descending
                                    Order</label>
                            </div>
                        </li>
                        <li class="has-dropdown">
                            <span>Sale Price</span>
                            <div class="asc-des-sort">
                                <label><input type="radio" class="list-view-sort" name="sort_by" value="sale_price asc"
										<?php
										if ( isset( $_GET['sort_by'] ) && $_GET['sort_by'] === 'sale_price asc' ) {
											echo 'checked';
										}
										?>
                                    >Ascending
                                    Order</label>
                                <label><input type="radio" class="list-view-sort" name="sort_by"
                                              value="sale_price desc"
										<?php
										if ( isset( $_GET['sort_by'] ) && $_GET['sort_by'] === 'sale_price desc' ) {
											echo 'checked';
										}
										?>
                                    >Descending
                                    Order</label>
                            </div>
                        </li>
                        <li>Brochure</li>
                        <li>Specs</li>
                    </ul>
                </form>
            </div>

			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/property/content', 'grid-property' );
					get_template_part( 'template-parts/property/content', 'tbl-row-property' );
				}
			} else {
				echo 'Please consider modifying the search criteria. No listings found.<br> Need assistance? Feel free to call 615.256.7114 to speak with a team member.';
			}
			?>
        </div>
		<?php
		global $wp_query;
		if ( $wp_query->max_num_pages > 1 ) {
			?>
            <div class="btn-wrapper text-center">
                <a href="#" role="button" class="load-more-btn">Loading
                    <div style="display: none" class="ajax-loader"></div>
                </a>
            </div>
			<?php
		}
		?>
    </div>
</section>
