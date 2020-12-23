<?php

namespace Dev4Press\Plugin\GDQNT\Basic;

use Dev4Press\Core\Plugins\DBLite;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DB extends DBLite {
	public function count_custom_style_transients() {
		$sql = "SELECT COUNT(*) FROM " . $this->wpdb()->options . " WHERE option_name LIKE '_transient_gdnqt-custom-css-%'";

		return $this->get_var( $sql );
	}

	public function delete_custom_style_transients() {
		$sql = "DELETE FROM " . $this->wpdb()->options . " WHERE option_name LIKE '_transient_gdnqt-custom-css-%'";

		return $this->query( $sql );
	}
}
