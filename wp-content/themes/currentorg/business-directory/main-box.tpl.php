<?php
/**
 * BD Main Box
 *
 * @package BDP/Templates/Main Box
 */

// phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
?>
<div id="wpbdp-main-box" class="wpbdp-main-box" data-breakpoints='{"tiny": [0,360], "small": [360,560], "medium": [560,710], "large": [710,999999]}' data-breakpoints-class-prefix="wpbdp-main-box">

	<?php if ( wpbdp_get_option( 'show-search-listings' ) ) : ?>
		<div class="main-fields clearfix">
			<form action="<?php echo esc_url( $search_url ); ?>" method="get" class="row-fluid">
				<div class="span9 row-fluid bg-grey padding-1">

					<div class="span9 the-search-box">
						<label for="wpbdp-main-box-keyword-field"><?php esc_html_e( 'Search for listings' ); ?></label>
						<input type="text" id="wpbdp-main-box-keyword-field" class="keywords-field" name="kw" placeholder="<?php echo esc_attr( _x( 'Find listings for <keywords>', 'main box', 'WPBDM' ) ); ?>" />
						<?php echo $extra_fields; ?>
					</div>
					<div class="span3">
						<input id="main-search" type="submit" class="button" value="<?php echo esc_attr_x( 'Search', 'main box', 'WPBDM' ); ?>" /><br />
						<a class="advanced" href="<?php echo $search_url; ?>"><?php echo esc_attr_x( 'Advanced Search', 'main box', 'WPBDM' ); ?></a>
					</div>
				</div>

				<div class="create-btn span3 padding-1">
					<?php
						// Formerly a call to wpbdp_main_links( array( 'create' ) ),
						// but we didn't like the button text
						// so we copied all this over
						echo '<div class="wpbdp-main-links-container" data-breakpoints=\'{"tiny": [0,360], "small": [360,560], "medium": [560,710], "large": [710,999999]}\' data-breakpoints-class-prefix="wpbdp-main-links">';
							echo '<div class="wpbdp-main-links">';
								printf(
									'<input id="wpbdp-bar-submit-listing-button" type="button" value="%s" onclick="window.location.href = \'%s\'" class="button wpbdp-button" />',
									__( 'Create a Listing', 'WPBDM' ),
									wpbdp_url( 'submit_listing' )
								);
							echo '</div>';
						echo '</div>';
					?>
				</div>

				<input type="hidden" name="wpbdp_view" value="search" />
				<?php echo $hidden_fields; ?>

				<?php if ( ! wpbdp_rewrite_on() ) : ?>
					<input type="hidden" name="page_id" value="<?php echo wpbdp_get_page_id(); ?>" />
				<?php endif; ?>
			</form>
		</div>

	<?php endif; ?>

	<?php
		// This is changed from the plugin-controlled options to some hardcoded options
		// the plugin-provided markup here is absolutely bonkers
		// if we had time to redo that I'd write my own <a href=" wpbdp_url('') "> code.

		$main_links = wpbdp_main_links( array( 'directory', 'listings' ) );
		if ( $main_links ) {
			?>
				<div class="box-row main-links"><?php echo $main_links; ?></div>
			<?php
		}
	?>
</div>
