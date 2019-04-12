<? global $website_settings; ?>
<div id="mobileNavigation" class="mobile mobile-nav">
    <ul class="primary menu">
        <? wp_nav_menu(['items_wrap' => '%3$s', 'theme_location' => 'header-primary', 'container' => false]); ?>
    </ul>
</div>
<div id="mobileHeader">
    <div class="mobile mobile-menu">
        <ul>
            <li>
                <a class="btn menu">
                    <i class="icon-menu"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
