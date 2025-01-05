<?php
if ( isset( $args['parent_property'] ) && ! empty( $args['parent_property'] ) ) { // brokers listing for space (space's parent property)
	$brokers = get_field( 'listing_brokers', $args['parent_property'] );
} else { // brokers listing for properties
	$brokers = get_field( 'listing_brokers' );
}
if ( ! empty( $brokers ) ) {
	?>
	<div class="agent-wrapper">
		<h3>Contact</h3>
		<div class="d-flex">
			<?php
			foreach ( $brokers as $broker ) {
				?>
				<div class="agent">
					<h5 class="agent-name"><a role="button" href="#" data-toggle="modal" class="team-modal-popup-btn" data-target="#teamModal<?php echo $broker; ?>"><?php echo get_the_title( $broker ); ?></a>
					</h5>
					<?php
					echo get_field( 'direct_number', $broker ) ? '<p>' . get_field( 'direct_number', $broker ) . '</p>' : '';
					echo get_field( 'cellular_number', $broker ) ? '<p>' . get_field( 'cellular_number', $broker ) . '</p>' : '';
					echo get_field( 'email_address', $broker ) ? '<a href="mailto:' . get_field( 'email_address', $broker ) . '">' . get_field( 'email_address', $broker ) . '</a>' : '';
					echo get_field( 'v_card', $broker ) ? '<a href="' . get_field( 'v_card', $broker ) . '">vCard</a>' : '';
					?>
				</div>
				<div class="modal fade" tabindex="-1" id="teamModal<?php echo $broker; ?>" aria-labelledby="teamModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
						<div class="modal-content">
							<div class="modal-header">
								<div class="modal-logo">
									<?php
									the_custom_logo();
									?>
								</div>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-sm-5 img-col">
										<div class="img-holder">
											<?php
											echo get_the_post_thumbnail( $broker, 'full' );
											?>
										</div>
									</div>
									<div class="col-sm-7 content-col">
										<div class="member-info">
											<?php
											echo '<h2>' . get_the_title( $broker ) . '</h2>';
											echo get_the_excerpt( $broker );
											$direct_number   = get_field( 'direct_number', $broker );
											$cellular_number = get_field( 'cellular_number', $broker );
											$email_address   = get_field( 'email_address', $broker );
											$v_card          = get_field( 'v_card', $broker );
											?>
										</div>
										<div class="member-contact-info">
											<?php
											echo $direct_number ? '<p>Direct ' . $direct_number . '</p>' : '';
											echo $cellular_number ? '<p>Cell ' . $cellular_number . '</p>' : '';
											echo $email_address ? '<p><a href="mailto:' . $email_address . '" class="mail">' . $email_address . '</a></p>' : '';
											echo $v_card ? '<p><a href="' . $v_card . '" class="mail">vCard</a></p>' : '';
											?>
										</div>
										<div class="content">
											<?php
											echo get_the_content( 'null', false, $broker );
											?>
										</div>
									</div>
									<div class="line"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}
