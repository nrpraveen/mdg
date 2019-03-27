<?
global $website_settings;
?>
<section class="copyright">
	<div class="content">
		
		<? if(!empty($website_settings->social_media)): ?>
		<div id="copyright-social">
			<ul>
				<? foreach($website_settings->social_media as $platform => $url): ?>
				<li><a href="<?= $url ?>" target="_blank" class="icon-<?= $platform ?>"></a></li>
				<? endforeach ?>
			</ul>
		</div>
		<? endif ?>
		
		<div id="copyright-nav">
			<p>Copyright &copy;  ©2007-<?= date('Y') ?> <?= $website_settings->corporate->legal_name ?>. All Right Reserved.</p>
			<ul><? wp_nav_menu(['items_wrap' => '%3$s', 'theme_location' => 'footer-nav', 'container' => false]); ?></ul>
		</div>
	</div>
</section>