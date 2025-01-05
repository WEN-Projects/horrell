<?php
/*
Template Name: Team
*/
get_header();
?>
    <main class="team-page">
        <section class="site-banner">
			<?php
			echo do_shortcode('[smartslider3 slider="4"]');
			?>
        </section>

		<?php

		get_template_part( "template-parts/content", "title-breadcrumb" );
		$args  = array(
			"post_type"      => "team",
			"posts_per_page" => - 1,
			"post_status"    => "publish"
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			?>
            <section class="team-section">
                <div class="container">
                    <div class="row">
						<?php
						while ( $query->have_posts() ) {
							$query->the_post();
							?>
                            <div class="col-md-4 col-sm-6">
                                <div class="team-member">
                                    <a role="button" href="#" data-toggle="modal" class="team-modal-popup-btn"
                                       data-target="#teamModal<?php echo get_the_ID(); ?>" data-id="team-1">
                                        <div class="team-img">
											<?php
											echo the_post_thumbnail( get_the_ID(), "full" );
											?>
                                        </div>
                                        <div class="team-detail">
											<?php
											the_title( "<h2>", "</h2>" );
											$company_posts = get_field( "company_posts" );
											echo $company_posts ? "<p>" . $company_posts . "</p>" : '';
											?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="teamModal<?php echo get_the_ID(); ?>"
                                 aria-labelledby="teamModalLabel" aria-hidden="true">
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
														echo the_post_thumbnail( get_the_ID(), "full" );
														?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7 content-col">
                                                    <div class="member-info">
														<?php
														the_title( "<h2>", "</h2>" );
														the_excerpt();
														$direct_number   = get_field( "direct_number" );
														$cellular_number = get_field( "cellular_number" );
														$email_address   = get_field( "email_address" );
														$v_card          = get_field( "v_card" );
														?>
                                                    </div>
                                                    <div class="member-contact-info">
														<?php
														echo $direct_number ? "<p>Direct " . $direct_number . "</p>" : "";
														echo $cellular_number ? "<p>Cell " . $cellular_number . "</p>" : "";
														echo $email_address ? "<p><a href=\"mailto:" . $email_address . "\" class=\"mail\">" . $email_address . "</a></p>" : "";
														echo $v_card ? "<p><a href=\"" . $v_card . "\" class=\"mail\">vCard</a></p>" : "";
														?>
                                                    </div>
                                                    <div class="content">
														<?php
														the_content();
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
            </section>
			<?php
		}
		?>
    </main>


<?php
get_footer();