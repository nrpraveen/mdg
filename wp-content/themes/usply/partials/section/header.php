<?
global $website_settings;
?>
<section>
	<div class="content">
		<div class="inner-content">
			<div id="header-logo">
				<a href="<?= site_url() ?>/">
					<img src="<?= wp_get_attachment_url($website_settings->logos->desktop_reverse) ?>" width="180" height="48" alt="<?= esc_attr($website_settings->corporate->name) ?>" />
				</a>
			</div>
			<div id="header-navigation" class="desktop">
				<div class="super-nav">
					Supernav
				</div>
				<div class="primary-nav">
					<ul>
						<? wp_nav_menu(['items_wrap' => '%3$s', 'theme_location' => 'header-primary', 'container' => false]); ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>