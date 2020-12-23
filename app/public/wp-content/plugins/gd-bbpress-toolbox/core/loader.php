<?php

use Dev4Press\Plugin\GDBBX\Basic\bbPress;
use Dev4Press\Plugin\GDBBX\Basic\Features;
use Dev4Press\Plugin\GDBBX\Basic\Enqueue;
use Dev4Press\Plugin\GDBBX\Basic\Feed;
use Dev4Press\Plugin\GDBBX\Basic\Navigation;
use Dev4Press\Plugin\GDBBX\Basic\Requests;
use Dev4Press\Plugin\GDBBX\Basic\Search;
use Dev4Press\Plugin\GDBBX\Basic\Template;

if (!defined('ABSPATH')) { exit; }

class gdbbx_core_loader {
    public $svg_icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyMC4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAyOTguOSAyOTguOSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjk4LjkgMjk4Ljk7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJLnN0MHtmaWxsOiM5QkExQTY7fQ0KPC9zdHlsZT4NCjxnPg0KCTxnPg0KCQk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMjcxLjgsMTguM0gyNy4yYy00LjgsMC04LjgsMy45LTguOCw4Ljh2MC4xdjEwMi4xVjE5N3Y3My42djAuMWMwLDQuOSw1LDEwLDkuOSwxMEg3Mw0KCQkJYy0wLjEsMC0wLjEtMC4xLTAuMi0wLjFoMTc3LjhjLTAuMSwwLTAuMSwwLjEtMC4yLDAuMWgxOS43YzQuOSwwLDEwLjQtNS4yLDEwLjQtMTAuMXYtMC4xdi0yMC4zVjc1LjlWMjcuMnYtMC4xDQoJCQlDMjgwLjYsMjIuMiwyNzYuNywxOC4zLDI3MS44LDE4LjN6IE0yNzIuOCwyNTkuOWMtMy44LDQuNC03LjksOC41LTEyLjIsMTIuNEg2Mi45Yy0xNC40LTEzLjEtMjYuNi0yOS4yLTM1LjItNDhjMCwwLDAtMC4xLDAtMC4xDQoJCQl2LTEyMkM0MS45LDcwLjksNjYuOSw0NC40LDEwMC42LDI5YzEuNC0wLjcsMi45LTEuMiw0LjQtMS44aDExMy43YzIwLjUsOC42LDM5LjEsMjEuOCw1NC4xLDM5VjI1OS45eiIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik04OS41LDE3MC44bDEyNS40LTU3LjNjMi45LTEuMyw1LjgtMS40LDguOC0wLjNjMywxLjEsNS4xLDMuMSw2LjQsNmMxLjMsMi45LDEuNCw1LjgsMC4zLDguOA0KCQljLTEuMSwzLTMuMSw1LjEtNiw2LjVMOTkuMSwxOTEuOGMtMi45LDEuMy01LjgsMS40LTguOCwwLjNjLTMtMS4xLTUuMS0zLjEtNi40LTZjLTEuMy0yLjktMS40LTUuOC0wLjMtOC44DQoJCUM4NC43LDE3NC4zLDg2LjcsMTcyLjEsODkuNSwxNzAuOHogTTExNC4zLDE5Ny40bDEwNC41LTQ3LjhjMi45LTEuMyw1LjgtMS40LDguOC0wLjNjMywxLjEsNS4xLDMuMSw2LjQsNmMxLjMsMi45LDEuNCw1LjgsMC4zLDguOA0KCQljLTEuMSwzLTMuMSw1LjEtNiw2LjVsLTEwNC41LDQ3LjhjLTIuOSwxLjMtNS44LDEuNC04LjgsMC4zYy0zLTEuMS01LjEtMy4xLTYuNC02Yy0xLjMtMi45LTEuNC01LjgtMC4zLTguOA0KCQlDMTA5LjQsMjAwLjksMTExLjQsMTk4LjcsMTE0LjMsMTk3LjR6IE0xODQsMTE1bC03My4yLDMzLjRjLTQuMywyLTguNywyLjEtMTMuMiwwLjVjLTQuNS0xLjctNy43LTQuNy05LjctOQ0KCQljLTItNC4zLTIuMS04LjctMC41LTEzLjJjMS43LTQuNSw0LjctNy43LDktOS43bDE2LjYtNy42Yy0xLjUtMS43LTIuNy0zLjMtMy4zLTQuOGMtMi00LjMtMi4xLTguNy0wLjUtMTMuMmMxLjctNC41LDQuNy03LjcsOS05LjcNCgkJbDEwLjUtNC44YzQuMy0yLDguNy0yLjEsMTMuMi0wLjVjNC41LDEuNyw3LjcsNC43LDkuNyw5YzAuNywxLjUsMS4xLDMuNCwxLjQsNS43bDE2LjYtNy42YzQuMy0yLDguNy0yLjEsMTMuMi0wLjUNCgkJYzQuNSwxLjcsNy43LDQuNyw5LjcsOWMyLDQuMywyLjEsOC43LDAuNSwxMy4yQzE5MS4zLDEwOS44LDE4OC4zLDExMywxODQsMTE1eiBNMTQ5LjUsMjE5LjJsNjIuNy0yOC43YzIuOS0xLjMsNS44LTEuNCw4LjgtMC4zDQoJCWMzLDEuMSw1LjEsMy4xLDYuNCw2YzEuMywyLjksMS40LDUuOCwwLjMsOC44Yy0xLjEsMy0zLjEsNS4xLTYsNi41bC0xMS40LDUuMmMxLjUsMS43LDIuNywzLjMsMy4zLDQuOGMyLDQuMywyLjEsOC43LDAuNSwxMy4yDQoJCWMtMS43LDQuNS00LjcsNy43LTksOS43bC0xMC41LDQuOGMtNC4zLDItOC43LDIuMS0xMy4yLDAuNWMtNC41LTEuNy03LjctNC43LTkuNy05Yy0wLjctMS41LTEuMS0zLjMtMS40LTUuN2wtMTEuNCw1LjINCgkJYy0yLjksMS4zLTUuOCwxLjQtOC44LDAuM2MtMy0xLjEtNS4xLTMuMS02LjQtNmMtMS4zLTIuOS0xLjQtNS44LTAuMy04LjhDMTQ0LjcsMjIyLjcsMTQ2LjcsMjIwLjYsMTQ5LjUsMjE5LjJ6Ii8+DQo8L2c+DQo8L3N2Zz4NCg==';

    public $buddypress = false;
    public $debug = false;

    public $modules = array();
    public $objects = array();

    public $is_search = false;

    function __construct() {
        add_action('plugins_loaded', array($this, 'core'));
        add_action('template_redirect', array($this, 'template_redirect'), 7);
        add_action('gdbbx_plugin_settings_loaded', array($this, 'early'));
    }

    public function core() {
        $this->debug = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG;
        $this->buddypress = gdbbx_has_buddypress();

        if (GDBBX_WPV < 49) {
            add_action('admin_notices', array($this, 'system_requirements_problem'));
        }

        if (gdbbx_has_bbpress()) {
            add_action('bbp_init', array($this, 'load'), 1);
            add_action('bbp_init', array($this, 'init'), 2);

            add_action('bbp_ready', array($this, 'ready'));
        } else {
            add_action('admin_notices', array($this, 'bbpress_requirements_problem'));
        }
    }

    public function deactivate() {
        deactivate_plugins('gd-bbpress-toolbox/gd-bbpress-toolbox.php', false);
    }

    public function early() {
        if (!gdbbx_has_bbpress()) {
            return;
        }

        Features::instance()->run_early();
    }

    public function load() {
        if (function_exists('bbp_is_search')) {
            $this->is_search = bbp_is_search();
        }

        bbPress::instance();
        Requests::instance();
        Feed::instance();
        Search::instance();

        Features::instance()->run_global();

        if (is_admin()) {
            Features::instance()->run_admin();
        } else {
            Features::instance()->run_frontend();
        }

        $this->modules();

        Enqueue::instance();
        Template::instance();
        Navigation::instance();
    }

    public function init() {
        do_action('gdbbx_init');
    }

    public function ready() {
        do_action('gdbbx_core');
    }

    public function template_redirect() {
        do_action('gdbbx_template');
    }

    public function modules() {
        require_once(GDBBX_PATH.'modules/features/core.widgets.php');
        $this->objects['widgets'] = new gdbbx_core_widgets();

        require_once(GDBBX_PATH.'modules/mailer/core.php');
        require_once(GDBBX_PATH.'modules/mailer/notifications.php');
        require_once(GDBBX_PATH.'modules/mailer/override.php');
        $this->modules['mailer'] = new gdbbx_mailer_core();

        require_once(GDBBX_PATH.'modules/attachments/load.php');
        $this->modules['attachments'] = 'loaded';

        if (!is_admin()) {
            require_once(GDBBX_PATH.'modules/features/mod.seo.php');
            $this->modules['front.seo'] = new gdbbx_mod_seo();
        }

        if (!D4P_CRON) {
            require_once(GDBBX_PATH.'modules/features/mod.tracking.php');
            $this->modules['tracking'] = new gdbbx_mod_tracking();

            require_once(GDBBX_PATH.'modules/features/mod.online.php');
            $this->modules['online'] = new gdbbx_mod_online();
        }

        if (gdbbx()->get('bbcodes_active', 'tools')) {
            require_once(GDBBX_PATH.'modules/bbcodes/load.php');
            $this->modules['bbcodes'] = new gdbbx_mod_bbcodes();

            if (!is_admin() && gdbbx()->get('bbcodes_toolbar_active', 'tools') && !bbp_use_wp_editor()) {
                require_once(GDBBX_PATH.'modules/bbcodes/toolbar.php');
                $this->modules['bbcodes_toolbar'] = new gdbbx_mod_bbcodes_toolbar();
            }
        }

        if ($this->buddypress) {
            require_once(GDBBX_PATH.'modules/buddypress/load.php');
            $this->modules['buddypress'] = new gdbbx_mod_buddypress();
        }
    }

    public function system_requirements_problem() {
        ?>

        <div class="notice notice-error">
            <p><?php _e("GD bbPress Toolbox Pro requires WordPress 4.4 or newer. Plugin will now be disabled. To use this plugin, upgrade WordPress to 4.4 or newer version.", "gd-bbpress-toolbox"); ?></p>
        </div>

        <?php

        $this->deactivate();
    }

    public function bbpress_requirements_problem() {
        ?>

        <div class="notice notice-error">
            <p><?php _e("GD bbPress Toolbox Pro requires bbPress plugin for WordPress version 2.5 or newer. Plugin will now be disabled. To use this plugin, make sure you are using bbPress 2.5 or newer version.", "gd-bbpress-toolbox"); ?></p>
        </div>

        <?php

        $this->deactivate();
    }
}
