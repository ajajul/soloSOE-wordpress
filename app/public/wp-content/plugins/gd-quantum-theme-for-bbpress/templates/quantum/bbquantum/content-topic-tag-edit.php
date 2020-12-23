<?php

/**
 * Topic Tag Edit Content Part
 *
 * @package    bbPress
 * @subpackage Theme
 */

?>

<div id="bbpress-forums">
	<?php

	gdqnt_theme()->breadcrumbs();

	bbp_topic_tag_description();

	do_action( 'bbp_template_before_topic_tag_edit' );
	bbp_get_template_part( 'form', 'topic-tag' );
	do_action( 'bbp_template_after_topic_tag_edit' );

	?>
</div>
