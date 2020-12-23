<div class="gdbbx-post">
    <?php

    if (bbp_is_topic(get_the_ID())) {

    ?>

<span class="gdbbx-post-type"><?php _e("Topic", "gd-bbpress-toolbox"); ?></span>
<a href="<?php bbp_topic_permalink(get_the_ID()); ?>"><?php bbp_topic_title(get_the_ID()); ?></a>

    <?php

    } else {
        
    ?>

<span class="gdbbx-post-type"><?php _e("Reply", "gd-bbpress-toolbox"); ?></span>
<a href="<?php bbp_reply_url(get_the_ID()); ?>"><?php bbp_reply_title(get_the_ID()); ?></a>

    <?php

    }

    ?>
</div>
<div class="gdbbx-information">
    <span class="gdbbx-post-time"><?php echo sprintf(__("%s ago", "gd-bbpress-toolbox"), human_time_diff(get_the_date('U'))); ?></span>
    <span class="gdbbx-post-author"><?php _e("by", "gd-bbpress-toolbox"); ?><?php bbp_author_link(array('post_id' => get_the_ID(), 'size' => 14)); ?></span>
</div>
