<?php

if (!defined('ABSPATH')) { exit; }

require_once(GDBBX_PATH.'modules/features/core.wizard.php');

include(GDBBX_PATH.'forms/wizard/header.php');

include(GDBBX_PATH.'forms/wizard/'.gdbbx_wizard()->current_panel().'.php');

include(GDBBX_PATH.'forms/wizard/footer.php');
