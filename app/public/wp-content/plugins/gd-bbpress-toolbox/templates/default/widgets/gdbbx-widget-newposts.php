<?php

$url = $post['type'] == 'topic' ? bbp_get_topic_permalink($post['id']) : bbp_get_reply_url($post['id']);
$title = $post['type'] == 'topic' ? bbp_get_topic_title($post['id']) : bbp_get_reply_title($post['id']);

?>

<li class="gdbbx-widget-newspost-default">
    <h4 class="gdbbx-title">
        <a href="<?php echo esc_attr($url); ?>" title="<?php echo esc_attr($title); ?>"><?php echo $title; ?></a>
    </h4>

    <?php if ($show_date) { ?>
        <em class="gdbbx-last-active"><?php echo $post['activity']; ?></em>
    <?php } ?>

    <?php if ($show_author) { ?>
        <?php $author = bbp_get_author_link(array('post_id' => $post['id'], 'size' => 20, 'type' => ($show_avatar ? 'both' : 'name'))); ?>

        <em class="gdbbx-author"><?php echo sprintf(_x("by %s", "New posts widget author", "gd-bbpress-toolbox"), $author); ?></em>
    <?php } ?>
</li>
