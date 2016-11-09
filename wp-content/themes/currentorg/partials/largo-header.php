<header id="site-header" class="clearfix" itemscope itemtype="http://schema.org/Organization">
	<?php largo_header(); ?>

	<?php if (is_home()) { ?>
		<div class="newsletter-signup">
			<form action="//current.us10.list-manage.com/subscribe/post?u=be91053a159d253f584056e47&id=1d564f03d8" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				<label>Sign up for our newsletter</label>
				<fieldset>
					<input required type="email" value="" name="EMAIL" class="required email_address" id="mce-EMAIL" placeholder="Email address">
					<input required type="text" value="" name="FNAME" class="required first_name" id="mce-FNAME" placeholder="First name">
					<input required type="text" value="" name="LNAME" class="required last_name" id="mce-LNAME" placeholder="Last name">
					<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button submit">
					<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
					<div style="position: absolute; left: -5000px;"><input type="text" name="b_be91053a159d253f584056e47_1d564f03d8" tabindex="-1" value=""></div>
				</fieldset>
			</form>
		</div>
	<?php } ?>

</header>
<header class="print-header">
	<p><strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong> (<?php echo esc_url( largo_get_current_url() ); ?>)</p>
</header>
