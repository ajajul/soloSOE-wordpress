<?php

namespace Dev4Press\Plugin\GDBBX\Basic;

use Dev4Press\Plugin\GDBBX\Features\AdminAccess;
use Dev4Press\Plugin\GDBBX\Features\AdminColumns;
use Dev4Press\Plugin\GDBBX\Features\AdminWidgets;
use Dev4Press\Plugin\GDBBX\Features\AutoCloseTopics;
use Dev4Press\Plugin\GDBBX\Features\CannedReplies;
use Dev4Press\Plugin\GDBBX\Features\Clickable;
use Dev4Press\Plugin\GDBBX\Features\CloseTopicControl;
use Dev4Press\Plugin\GDBBX\Features\CustomViews;
use Dev4Press\Plugin\GDBBX\Features\DisableRSS;
use Dev4Press\Plugin\GDBBX\Features\Editor;
use Dev4Press\Plugin\GDBBX\Features\FooterActions;
use Dev4Press\Plugin\GDBBX\Features\ForumIndex;
use Dev4Press\Plugin\GDBBX\Features\Icons;
use Dev4Press\Plugin\GDBBX\Features\LockForums;
use Dev4Press\Plugin\GDBBX\Features\LockTopics;
use Dev4Press\Plugin\GDBBX\Features\MIMETypes;
use Dev4Press\Plugin\GDBBX\Features\Objects;
use Dev4Press\Plugin\GDBBX\Features\Privacy;
use Dev4Press\Plugin\GDBBX\Features\PrivateReplies;
use Dev4Press\Plugin\GDBBX\Features\PrivateTopics;
use Dev4Press\Plugin\GDBBX\Features\Profiles;
use Dev4Press\Plugin\GDBBX\Features\ProtectRevisions;
use Dev4Press\Plugin\GDBBX\Features\Publish;
use Dev4Press\Plugin\GDBBX\Features\Quote;
use Dev4Press\Plugin\GDBBX\Features\Replies;
use Dev4Press\Plugin\GDBBX\Features\ReplyActions;
use Dev4Press\Plugin\GDBBX\Features\Report;
use Dev4Press\Plugin\GDBBX\Features\Rewriter;
use Dev4Press\Plugin\GDBBX\Features\ScheduleTopic;
use Dev4Press\Plugin\GDBBX\Features\SEOTweaks;
use Dev4Press\Plugin\GDBBX\Features\Signatures;
use Dev4Press\Plugin\GDBBX\Features\Snippets;
use Dev4Press\Plugin\GDBBX\Features\Thanks;
use Dev4Press\Plugin\GDBBX\Features\Toolbar;
use Dev4Press\Plugin\GDBBX\Features\TopicActions;
use Dev4Press\Plugin\GDBBX\Features\Topics;
use Dev4Press\Plugin\GDBBX\Features\Tweaks;
use Dev4Press\Plugin\GDBBX\Features\UserSettings;
use Dev4Press\Plugin\GDBBX\Features\UsersStats;
use Dev4Press\Plugin\GDBBX\Features\VisitorsRedirect;

if (!defined('ABSPATH')) {
    exit;
}

class Features {
    public $load = array();

    public function __construct() {
        $this->load = gdbbx()->group_get('load');
    }

    /** @return \Dev4Press\Plugin\GDBBX\Basic\Features */
    public static function instance() {
        static $instance = false;

        if ($instance === false) {
            $instance = new Features();
        }

        return $instance;
    }

    public function is_enabled($name) {
        return $this->load[$name];
    }

    public function run_early() {
        UserSettings::instance();

        if ($this->load['objects']) {
            Objects::instance();
        }

        if ($this->load['publish']) {
            Publish::instance();
        }

        if ($this->load['disable-rss']) {
            DisableRSS::instance();
        }

        if ($this->load['visitors-redirect']) {
            VisitorsRedirect::instance();
        }

        if ($this->load['mime-types']) {
            MIMETypes::instance();
        }
    }

    public function run_global() {
        Icons::instance();
        Tweaks::instance();

        TopicActions::instance();
        ReplyActions::instance();

        CustomViews::instance();

        if ($this->load['rewriter']) {
            Rewriter::instance();
        }

        if ($this->load['privacy']) {
            Privacy::instance();
        }

        if ($this->load['toolbar']) {
            Toolbar::instance();
        }

        if ($this->load['lock-forums']) {
            LockForums::instance();
        }

        if ($this->load['lock-topics']) {
            LockTopics::instance();
        }

        if ($this->load['editor']) {
            Editor::instance();
        }

        if ($this->load['clickable']) {
            Clickable::instance();
        }

        if ($this->load['signatures']) {
            Signatures::instance();
        }

        if ($this->load['topics']) {
            Topics::instance();
        }

        if ($this->load['private-topics']) {
            PrivateTopics::instance();
        }

        if ($this->load['replies']) {
            Replies::instance();
        }

        if ($this->load['close-topic-control']) {
            CloseTopicControl::instance();
        }

        if ($this->load['auto-close-topics']) {
            AutoCloseTopics::instance();
        }

        if ($this->load['private-topics']) {
            PrivateTopics::instance();
        }

        if ($this->load['private-replies']) {
            PrivateReplies::instance();
        }

        if ($this->load['thanks']) {
            Thanks::instance();
        }

        if ($this->load['report']) {
            Report::instance();
        }

        if ($this->load['canned-replies']) {
            CannedReplies::instance();
        }
    }

    public function run_admin() {
        if (!is_super_admin() && $this->load['admin-access']) {
            AdminAccess::instance();
        }

        if (gdbbx_can_user_moderate()) {
            if ($this->load['admin-widgets']) {
                AdminWidgets::instance();
            }

            if ($this->load['admin-columns']) {
                AdminColumns::instance();
            }
        }
    }

    public function run_frontend() {
        if ($this->load['footer-actions']) {
            FooterActions::instance();
        }

        if ($this->load['forum-index']) {
            ForumIndex::instance();
        }

        if ($this->load['users-stats']) {
            UsersStats::instance();
        }

        if ($this->load['profiles']) {
            Profiles::instance();
        }

        if ($this->load['quote']) {
            Quote::instance();
        }

        if ($this->load['protect-revisions']) {
            ProtectRevisions::instance();
        }

        if ($this->load['seo-tweaks']) {
            SEOTweaks::instance();
        }

        if ($this->load['snippets']) {
            Snippets::instance();
        }

        if ($this->load['schedule-topic']) {
            ScheduleTopic::instance();
        }
    }
}
