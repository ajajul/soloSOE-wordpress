<div class="oxy-timeline-block">
    <div class="oxy-timeline-marker">
    </div>
    <div class="oxy-timeline-content">
        <a class='oxy-post-title' href='<?php the_permalink(); ?>'><?php the_title(); ?></a>

        <a class='oxy-post-image' href='<?php the_permalink(); ?>'>
            <div class='oxy-post-image-fixed-ratio' style='background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);'>
            </div>
        </a>
    </div>
</div>
