<?php
/*
Template Name: browser template view
*/

$recipient_name = isset( $_GET["form_data"]["recipient_name"] ) ? $_GET["form_data"]["recipient_name"] : "";
$your_name      = isset( $_GET["form_data"]["your_name"] ) ? $_GET["form_data"]["your_name"] : "";
$message        = isset( $_GET["form_data"]["message"] ) ? $_GET["form_data"]["message"] : "Horrell Company has property listings that might interest you. For additional information test";
$saved_listings = isset( $_GET["listings"] ) ? $_GET["listings"] : array();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office">

<head>

    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->

    <!-- Your title goes here -->
	<?php
	$meta_title = get_field( 'meta_title', 'option' );
	if ( $meta_title ) {
		?>
        <title><?php echo esc_html( $meta_title ); ?></title>
        <!-- End title -->
		<?php
	}
	?>


    <!-- Start stylesheet -->
    <style type="text/css">
        a,
        a[href],
        a:hover,
        a:link,
        a:visited {
            /* This is the link colour */
            text-decoration: none !important;
            color: #b99c64;
        }

        .link {
            text-decoration: underline !important;
        }

        p,
        p:visited {
            /* Fallback paragraph style */
            font-size: 15px;
            line-height: 24px;
            font-family: 'myriad pro', Arial, sans-serif;
            font-weight: 300;
            text-decoration: none;
            color: #000000;
        }

        h1 {
            /* Fallback heading style */
            font-size: 22px;
            line-height: 24px;
            font-family: 'myriad pro', Arial, sans-serif;
            font-weight: normal;
            text-decoration: none;
            color: #000000;
        }

        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td {
            line-height: 100%;
        }

        .ExternalClass {
            width: 100%;
        }
    </style>
    <!-- End stylesheet -->

</head>
<body
        style="text-align: center;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            background-color: #ffffff;
            color: #000000"
        align="center">

<!-- Fallback force center content -->
<div style="text-align: center;">
    <!-- Email Header -->
    <table align="center" style="width: 100%; background-color: #000; padding: 30px 0 20px;">
        <tbody>
        <tr>
            <td>
                <table align="center"
                       style="text-align: center; vertical-align: middle; width: 600px; max-width: 600px;" width="600">
                    <tbody>
                    <tr>
                        <td align="left">
                            <div style="width: 245px;">
								<?php
								the_custom_logo();
								?>
                            </div>
                        </td>
                        <td align="right" style="vertical-align:bottom;">
                            <div>
								<?php
								$gs_site_contact_number = get_field( 'gs_site_contact_number', 'option' );
								if ( $gs_site_contact_number ) {
									?>
                                    <a href="Tel:<?php echo esc_attr( $gs_site_contact_number ); ?>"
                                       style="font-size: 21px; display: block; line-height: 28px; color: #b99c64; font-family: 'myriad pro', Arial, sans-serif; font-weight: 400; text-decoration: none;"><?php echo esc_html( $gs_site_contact_number ); ?></a>
									<?php
								}
								?>

                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

    <div>
		<?php echo $recipient_name; ?>,<br>
		<?php echo $message; ?><br>
		<?php echo $your_name; ?>
    </div>

    <!-- Email Body -->
    <table align="center" style="width: 100%; padding: 15px 0;">
        <tbody>
        <tr>
            <td>
                <!-- Body Container-->
                <table align="center"
                       style="text-align: center; vertical-align: middle; width: 600px; max-width: 600px;" width="600">
                    <tbody>
                    <!-- Body Top Content -->
                    <tr>
                        <td></td>
                    </tr>
                    <!-- Body property Listing -->
                    <tr>
                        <td>
							<?php
							get_template_part( 'email-templates/content-saved-listings', null, array( 'saved_listings' => $saved_listings ) );
							?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!-- Body Container Ends-->
            </td>
        </tr>
        </tbody>
    </table>


    <!-- Email Footer -->
    <table align="center" style="width: 100%; background-color: #cecece; padding: 40px 0;">
        <tbody>
        <tr>
            <td>
                <table align="center"
                       style="text-align: center; vertical-align: middle; width: 600px; max-width: 600px;" width="600">
                    <tbody>
                    <tr>
                        <td align="left">
							<?php
							$gs_site_copyright_text         = get_field( 'gs_site_copyright_text', 'option' );
							$gs_site_footer_contact_details = get_field( 'gs_site_footer_contact_details', 'option' );
							if ( $gs_site_copyright_text ) {
								?>
                                <p style="margin: 0 0 16px 0; padding: 0; font-size: 18px; font-family: 'myriad pro', Arial, sans-serif; font-weight: 400; color: #000; text-transform: capitalize;"><?php echo _e( '&copy; ' . date( "Y" ) . ' Horrell Company. All Rights Reserved.', 'horrell' ); ?></p>
								<?php
							}
							if ( $gs_site_footer_contact_details ) {
								?>
                                <p style="margin: 0; padding: 0; font-size: 18px; font-family: 'myriad pro', Arial, sans-serif; font-weight: 400; color: #000; text-transform: uppercase;"><?php echo $gs_site_footer_contact_details; ?></p>
								<?php
							}
							?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
	<?php
	$email_footer_description = get_field( 'email_footer_description', 'options' );
	if ( $email_footer_description ) {
		?>
        <!-- post footer text -->
        <table align="center" style="width: 100%; background-color: #fff; padding: 15px 0;">
            <tbody>
            <tr>
                <td>
                    <table align="center"
                           style="text-align: center; vertical-align: middle; width: 600px; max-width: 600px;"
                           width="600">
                        <tbody>
                        <tr>
                            <td align="left">
                                <p style="font-size: 13px; line-height: 1.4; font-family: 'myriad pro', Arial, sans-serif; font-weight: 400; text-decoration: none; color: #000000; margin: 0; padding: 0; text-align: justify;"><?php echo esc_html( $email_footer_description ) ?></p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
		<?php
	}
	?>
</div>
</body>

