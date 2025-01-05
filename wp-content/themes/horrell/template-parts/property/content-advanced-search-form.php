<?php

/**
 * Advanced Search Template
 *
 * @package horrell
 *
 * cspell: ignore horrell zipcode ptype sqft
 */

?>

<div class='advanced-search-popup'>
	<div class='search-form-wrapper'>
		<h3>Advanced Search</h3>
		<button class='close-btn' aria - label='Close'>&times;</button>
		<form action="<?php echo esc_url( get_post_type_archive_link( 'property' ) ); ?>" method='get' class='advanced-search-form'>
			<div class='sale-lease-selector'>
				<?php
				// Check if form fields(GET REQUEST) and populate in the advanced search form.
				global $Horrell_Property;
				$keyword               = $Horrell_Property->get_param_value( 'keyword' );
				$selected_p_offer_type = $Horrell_Property->get_param_value( 'p_offer_type' );
				$selected_ptype        = $Horrell_Property->get_param_value( 'ptype' );
				$zipcode               = $Horrell_Property->get_param_value( 'zipcode' );
				$zipcode               = $Horrell_Property->get_param_value( 'zipcode' );
				$min_sale_price        = $Horrell_Property->get_param_value( 'min_sale_price' );
				$min_rental_price      = $Horrell_Property->get_param_value( 'min_rental_price' );
				$max_sale_price        = $Horrell_Property->get_param_value( 'max_sale_price' );
				$max_rental_price      = $Horrell_Property->get_param_value( 'max_rental_price' );
				$min_sq_ft             = $Horrell_Property->get_param_value( 'min_sq_ft' );
				$max_sq_ft             = $Horrell_Property->get_param_value( 'max_sq_ft' );
				$min_acreage           = $Horrell_Property->get_param_value( 'min_acreage' );
				$max_acreage           = $Horrell_Property->get_param_value( 'max_acreage' );

				?>
				<input type="radio" id="sale-selector" name="p_offer_type" value="sale" <?php echo ( 'lease' !== $selected_p_offer_type ) ? 'checked' : ''; ?>>
				<label for="sale-selector">For Sale</label>
				<input type="radio" id="lease-selector" name="p_offer_type" value="lease" <?php echo ( 'lease' === $selected_p_offer_type ) ? 'checked' : ''; ?>>
				<label for="lease-selector">For Lease</label>
			</div>
			<div class="input-wrapper">
				<div class="input-field keyword-wrap">
					<input type="text" class="sale-keyword" name="keyword" placeholder="Search Keyword" value="<?php echo esc_attr( $keyword ); ?>">
				</div>
				<div class="select-field">
					<select name="ptype">
						<option value="0" selected>Select Type</option>
						<option value="industrial" <?php echo ( 'industrial' === $selected_ptype ) ? 'selected' : ''; ?>>Industrial</option>
						<option value="land" <?php echo ( 'land' === $selected_ptype ) ? 'selected' : ''; ?>>Land</option>
						<option value="office" <?php echo ( 'office' === $selected_ptype ) ? 'selected' : ''; ?>>Office</option>
						<option value="retail" <?php echo ( 'retail' === $selected_ptype ) ? 'selected' : ''; ?>>Retail</option>
					</select>
				</div>
				<div class="input-field">
					<input type="text" name="zipcode" placeholder="Zip Code" value="<?php echo $zipcode ? esc_attr( $zipcode ) : ''; ?>">
				</div>
				<div class="input-field min-price">
					<label class="min-sale">
						<input type="text" name="min_sale_price" placeholder="Min Sale Price" value="<?php echo esc_attr( $min_sale_price ); ?>">
					</label>
					<label class="min-rental">
						<span>$PSF/Year</span>
						<input type="text" name="min_rental_price" placeholder="Min Rental Price" value="<?php echo esc_attr( $min_rental_price ); ?>">
					</label>
				</div>
				<div class="input-field max-price">
					<label class="max-sale">
						<input type="text" name="max_sale_price" placeholder="Max Sale Price" value="<?php echo esc_attr( $max_sale_price ); ?>">
					</label>
					<label class="max-rental">
						<span>$PSF/Year</span>
						<input type="text" name="max_rental_price" placeholder="Max Rental Price" value="<?php echo esc_attr( $max_rental_price ); ?>">
					</label>
				</div>
				<div class="input-field min-sqft">
					<label>
						<span>Building Size</span>
						<input type="text" name="min_sq_ft" placeholder="Min Sq Ft" value="<?php echo ( $min_sq_ft ) ? esc_attr( $min_sq_ft ) : ''; ?>">
					</label>
				</div>
				<div class="input-field max-sqft">
					<label>
						<span>Building Size</span>
						<input type="text" name="max_sq_ft" placeholder="Max Sq Ft" value="<?php echo ( $max_sq_ft ) ? esc_attr( $max_sq_ft ) : ''; ?>">
					</label>
				</div>
				<div class="input-field min-acre">
					<label>
						<span>Land Size</span>
						<input type="text" name="min_acreage" placeholder="Min Acreage" value="<?php echo ( $min_acreage ) ? esc_attr( $min_acreage ) : ''; ?>">
					</label>
				</div>
				<div class="input-field max-acre">
					<label>
						<span>Land Size</span>
						<input type="text" name="max_acreage" placeholder="Max Acreage" value="<?php echo $max_acreage ? esc_attr( $max_acreage ) : ''; ?>">
					</label>
				</div>
				<div class="submit-field">
					<button class="search-btn" type="submit">Search</button>
				</div>
			</div>
		</form>
	</div>
</div>
