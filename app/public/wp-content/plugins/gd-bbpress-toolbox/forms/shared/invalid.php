<?php

include(GDBBX_PATH.'forms/shared/top.php');

?>

<div class="d4p-content-left">
    <div class="d4p-panel-title">
        <i aria-hidden="true" class="fa fa-bug"></i>
        <h3><?php _e("Invalid Request", "gd-bbpress-toolbox"); ?></h3>
    </div>
</div>
<div class="d4p-content-right">
    <h3><?php _e("Error", "gd-bbpress-toolbox"); ?></h3>
    <?php

        _e("Current request URL is invalid, and it can't be processed.", "gd-bbpress-toolbox");

    ?>
</div>

<?php 

include(GDBBX_PATH.'forms/shared/bottom.php');
