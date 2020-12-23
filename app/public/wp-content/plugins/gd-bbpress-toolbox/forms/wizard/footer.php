                <div class="d4p-wizard-panel-footer">
                    <?php

                    if (gdbbx_wizard()->is_last_panel()) {
                        
                    ?><a class="button-primary" href="admin.php?page=gd-bbpress-toolbox-front"><?php _e("Finish", "gd-bbpress-toolbox"); ?></a><?php

                    } else {
                        
                    ?><input type="submit" class="button-primary" value="<?php _e("Save and Continue", "gd-bbpress-toolbox"); ?>" /><?php

                    }

                    ?>
                </div>
            </form>
        </div>
    </div>
</div>
