<?php

namespace Dev4Press\Plugin\GDQNT\Theme\Themes;

use Dev4Press\Plugin\GDQNT\Theme\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DefaultGray extends Theme {
	protected $name = 'default-gray';

	protected $overrides = array(
		'color-form-background',
		'color-form-border',
		'color-form-text',
		'color-form-link',
		'color-form-search-border',
		'color-form-button-link',
		'color-list-header-background',
		'color-list-header-text',
		'color-list-row-background',
		'color-list-row-text',
		'color-list-row-link',
		'color-post-author-background',
		'color-post-author-text',
		'color-post-author-link',
		'color-action-banner-background',
		'color-action-banner-text',
		'color-action-banner-link',
		'color-breadcrumbs-background',
		'color-breadcrumbs-text',
		'color-breadcrumbs-link',
		'color-topic-tag-background',
		'color-topic-tag-border',
		'color-topic-tag-link',
		'color-pager-numbers-background',
		'color-pager-numbers-link'
	);

	protected $settings = array(
		'color-text',
		'color-link',
		'color-background',
		'color-common-background',
		'color-sticky-background',
		'color-super-sticky-background',
		'color-spam-background',
		'color-trash-background',
		'color-pending-background',
		'font-size',
		'line-height'
	);

	protected function import() {
		$lines = parent::import();

		$lines[] = '@import "' . $this->name . $this->rtl . '.scss";';

		return $lines;
	}

	protected function import_path() {
		return GDQNT_PATH . 'templates/quantum/scss';
	}

	protected function init() {
		parent::init();

		$this->values['font-size']   .= 'px';
		$this->values['line-height'] .= 'px';

		foreach ( $this->overrides as $key ) {
			$_key = 'theme-' . $this->name . '-' . $key;

			if ( gdqnt_customizer()->get( $_key . '-override' ) ) {
				$this->values[ $key ] = gdqnt_customizer()->get( $_key );
			}
		}
	}
}
