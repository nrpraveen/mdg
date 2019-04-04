<?php
class StructuredDataClass {

	private $corporate;

	private function buildCorporate() {
		global $website_settings;

		$this->corporate = (object)[
			'@context' => 'https://schema.org/',
			'@type' => 'Organization',
            'name' => $website_settings->corporate->name,
			'legalName' => $website_settings->corporate->legal_name,
			'logo' => wp_get_attachment_url($website_settings->logos->desktop_normal),
			'numberOfEmployees' => '1001-5000',
			'description' => '',
			'sameAs' => array_values((array)$website_settings->social_media),
			'url' => site_url(),
            'telephone' => $website_settings->corporate->phone,
            "contactPoint" => (object) [
                "@type" => "ContactPoint",
                "telephone" => $website_settings->corporate->toll_free_phone,
                "contactType" => "customer service",
                "contactOption" => "TollFree",
                "areaServed" => "US"
            ],
            'faxNumber' => $website_settings->corporate->fax,
		];
	}

	private function getBlogPostStructuredData() {
		global $website_settings;

		$sd = (object)[
			'@context' => 'https://schema.org/',
			'@type' => 'BlogPosting',
			'name' => esc_js(get_the_title()),
			'author' => (object)[
				'@context' => 'https://schema.org',
				'@type' => 'Person',
				'additionalName' => esc_js(get_the_author()),
			],
			'wordCount' => str_word_count(strip_tags(get_the_content())),
			'datePublished' => get_the_date('Y-m-d'),
		];

		return $sd;
	}

	private function build() {
        global $website_settings, $testimonials;

		$sd = $this->corporate;

		if(is_singular('post')) {
			$sd = $this->getBlogPostStructuredData();
			$sd->publisher = $this->corporate;
		}

		return $sd;
	}

	private function registerHooks() {
		add_action('wp_footer', function() {
			$json_ld = $this->build();
			echo '<script type="application/ld+json">'.PHP_EOL.json_encode($json_ld, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES).PHP_EOL.'</script>';
		});
	}

	function __construct() {
		$this->buildCorporate();
		$this->registerHooks();
	}
}