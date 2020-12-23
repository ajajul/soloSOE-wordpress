<?php

use Dev4Press\Plugin\GDBBX\Basic\Features;

if (!defined('ABSPATH')) { exit; }

class gdbbx_mod_buddypress {
    /** @var gdbbx_buddypress_notifications */
    public $notify;

    public function __construct() {
        add_action('bp_init', array($this, 'init'));

        add_action('xprofile_get_field_data', array($this, 'xprofile_get_field_data'), 10, 3);
        add_action('xprofile_data_before_delete', array($this, 'xprofile_data_before_delete'));
        add_action('xprofile_data_after_save', array($this, 'xprofile_data_after_save'));
        add_filter('bp_xprofile_get_field_types', array($this, 'get_field_types'));

        if ($this->notifications_enabled()) {
            require_once(GDBBX_PATH.'modules/buddypress/notifications.php');

            $this->notify = new gdbbx_buddypress_notifications();
        }
    }

    public function notifications_enabled() {
        return gdbbx()->get('notifications_support', 'buddypress');
    }

    public function xprofile_enabled() {
        return bp_is_active('xprofile') && gdbbx()->get('xprofile_support', 'buddypress');
    }

    public function init() {
        if ($this->xprofile_enabled() && gdbbx()->get('xprofile_signature_field_add', 'buddypress')) {
            add_action('current_screen', array($this, 'create_signature_field'));
        }

        if ($this->xprofile_enabled() && gdbbx()->get('xprofile_signature_field_del', 'buddypress')) {
            add_action('current_screen', array($this, 'remove_signature_field'));
        }

        $this->_override_urls();
    }

    public function xprofile_data_before_delete($field) {
        if ($this->xprofile_enabled() && $field->field_id == gdbbx()->get('xprofile_signature_field_id', 'buddypress')) {
            $user_id = $field->user_id;

            gdbbx_update_raw_user_signature($user_id, '');
        }
    }

    public function xprofile_get_field_data($value, $field_id, $user_id) {
        if ($this->xprofile_enabled() && $field_id == gdbbx()->get('xprofile_signature_field_id', 'buddypress')) {
            $value = gdbbx_get_raw_user_signature($user_id);
        }

        return $value;
    }

    public function xprofile_data_after_save($field) {
        if ($this->xprofile_enabled() && $field->field_id == gdbbx()->get('xprofile_signature_field_id', 'buddypress')) {
            if (Features::instance()->is_enabled('signatures')) {
                $user_id = $field->user_id;
                $signature = $field->value;

                gdbbx_update_raw_user_signature($user_id, $signature);
            }
        }
    }

    public function get_field_types($types) {
        require_once(GDBBX_PATH.'modules/buddypress/signature.php');

        $types['signature_textarea'] = 'GDBBX_XProfile_Field_Type_Signature_Text_Area';

        return $types;
    }

    public function has_signature_field() {
        if (!bp_is_active('xprofile')) {
            return false;
        }

        $field_id = gdbbx()->get('xprofile_signature_field_id', 'buddypress');
        $field = xprofile_get_field($field_id);

        $missing = is_null($field) || $field->id !== $field_id || $field->type !== 'signature_textarea';

        return !$missing;
    }

    public function remove_signature_field() {
        if (!bp_is_active('xprofile')) {
            return false;
        }

        $field_id = gdbbx()->get('xprofile_signature_field_id', 'buddypress');

        if ($field_id > 0) {
            xprofile_delete_field($field_id);
        }

        gdbbx()->set('xprofile_signature_field_del', false, 'buddypress', true);

        wp_redirect_self();
        exit;
    }

    public function create_signature_field() {
        if (!bp_is_active('xprofile')) {
            return false;
        }

        if (!$this->has_signature_field()) {
            $field_id = xprofile_insert_field(array(
                'field_group_id' => $this->first_group_id(),
                'name' => __("Forum Signature", "gd-bbpress-toolbox"),
                'is_required' => false,
                'type' => 'signature_textarea',
                'can_delete' => true
            ));

            gdbbx()->set('xprofile_signature_field_id', $field_id, 'buddypress');
        }

        gdbbx()->set('xprofile_signature_field_add', false, 'buddypress', true);

        wp_redirect_self();
        exit;
    }

    public function profile_groups() {
        $list = array();

        $raw = BP_XProfile_Group::get(array('fetch_fields' => false));

        foreach ($raw as $group) {
            $list[$group->id] = $group->name;
        }

        return $list;
    }

    public function first_group_id() {
        $list = $this->profile_groups();
        $groups = array_keys($list);

        return $groups[0];
    }

    private function _override_urls() {
        if (gdbbx()->get('disable_profile_override', 'buddypress')) {
            if (gdbbx_bbpress_version() < 26) {
                remove_filter('bbp_pre_get_user_profile_url', array(bbpress()->extend->buddypress, 'user_profile_url'));
                remove_filter('bbp_get_favorites_permalink', array(bbpress()->extend->buddypress, 'get_favorites_permalink'), 10);
                remove_filter('bbp_get_subscriptions_permalink', array(bbpress()->extend->buddypress, 'get_subscriptions_permalink'), 10);
            } else {
                remove_filter('bbp_pre_get_user_profile_url', array(bbpress()->extend->buddypress->members, 'get_user_profile_url'));
                remove_filter('bbp_pre_get_favorites_permalink', array(bbpress()->extend->buddypress->members, 'get_favorites_permalink'));
                remove_filter('bbp_pre_get_subscriptions_permalink', array(bbpress()->extend->buddypress->members, 'get_subscriptions_permalink'));
                remove_filter('bbp_pre_get_user_topics_created_url', array(bbpress()->extend->buddypress->members, 'get_topics_created_url'));
                remove_filter('bbp_pre_get_user_replies_created_url', array(bbpress()->extend->buddypress->members, 'get_replies_created_url'));
                remove_filter('bbp_pre_get_user_engagements_url', array(bbpress()->extend->buddypress->members, 'get_engagements_permalink'));
            }
        }
    }
}

/** @return gdbbx_mod_buddypress */
function gdbbx_module_buddypress() {
    return gdbbx_loader()->modules['buddypress'];
}
