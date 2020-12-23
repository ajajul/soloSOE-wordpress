<?php

use Dev4Press\Plugin\GDBBX\Basic\Cache;
use Dev4Press\Plugin\GDBBX\Basic\Features;
use Dev4Press\Plugin\GDBBX\Basic\Feed;
use Dev4Press\Plugin\GDBBX\Basic\Forum;
use Dev4Press\Plugin\GDBBX\Basic\Roles;
use Dev4Press\Plugin\GDBBX\Basic\Signs;
use Dev4Press\Plugin\GDBBX\Basic\User;
use Dev4Press\Plugin\GDBBX\Features\CannedReplies;
use Dev4Press\Plugin\GDBBX\Features\ForumIndex;
use Dev4Press\Plugin\GDBBX\Features\LockForums;
use Dev4Press\Plugin\GDBBX\Features\PrivateReplies;
use Dev4Press\Plugin\GDBBX\Features\PrivateTopics;
use Dev4Press\Plugin\GDBBX\Features\Profiles;
use Dev4Press\Plugin\GDBBX\Features\Quote;
use Dev4Press\Plugin\GDBBX\Features\Report;
use Dev4Press\Plugin\GDBBX\Features\Signatures;
use Dev4Press\Plugin\GDBBX\Features\Thanks;

if (!defined('ABSPATH')) {
    exit;
}

/** @return \Dev4Press\Plugin\GDBBX\Basic\Cache */
function gdbbx_cache() {
    return Cache::instance();
}

/** @return \Dev4Press\Plugin\GDBBX\Basic\Roles */
function gdbbx_roles() {
    return Roles::instance();
}

/** @return \Dev4Press\Plugin\GDBBX\Basic\Signs */
function gdbbx_signs() {
    return Signs::instance();
}

/** @return \Dev4Press\Plugin\GDBBX\Basic\Feed */
function gdbbx_feed() {
    return Feed::instance();
}

/** @return \Dev4Press\Plugin\GDBBX\Basic\Forum */
function gdbbx_forum($id = 0) {
    return Forum::instance($id);
}

/** @return \Dev4Press\Plugin\GDBBX\Basic\User */
function gdbbx_user($id = 0) {
    return User::instance($id);
}

/** @return bool|\Dev4Press\Plugin\GDBBX\Features\Signatures */
function gdbbx_signature() {
    return Features::instance()->is_enabled('signatures') ? Signatures::instance() : false;
}

/** @return bool|\Dev4Press\Plugin\GDBBX\Features\Quote */
function gdbbx_quote() {
    return Features::instance()->is_enabled('quote') ? Quote::instance() : false;
}

/** @return bool|\Dev4Press\Plugin\GDBBX\Features\Report */
function gdbbx_report() {
    return Features::instance()->is_enabled('report') ? Report::instance() : false;
}

/** @return bool|\Dev4Press\Plugin\GDBBX\Features\Profiles */
function gdbbx_user_profiles() {
    return Features::instance()->is_enabled('profiles') ? Profiles::instance() : false;
}

/** @return bool|\Dev4Press\Plugin\GDBBX\Features\ForumIndex */
function gdbbx_forum_index() {
    return Features::instance()->is_enabled('forum-index') ? ForumIndex::instance() : false;
}

/** @return bool|\Dev4Press\Plugin\GDBBX\Features\LockForums */
function gdbbx_lock_forums() {
    return Features::instance()->is_enabled('lock-forums') ? LockForums::instance() : false;
}

/** @return bool|\Dev4Press\Plugin\GDBBX\Features\PrivateTopics */
function gdbbx_private_topics() {
    return Features::instance()->is_enabled('private-topics') ? PrivateTopics::instance() : false;
}

/** @return bool|\Dev4Press\Plugin\GDBBX\Features\PrivateReplies */
function gdbbx_private_replies() {
    return Features::instance()->is_enabled('private-replies') ? PrivateReplies::instance() : false;
}

/** @return bool|\Dev4Press\Plugin\GDBBX\Features\Thanks */
function gdbbx_say_thanks() {
    return Features::instance()->is_enabled('thanks') ? Thanks::instance() : false;
}

/** @return bool|\Dev4Press\Plugin\GDBBX\Features\CannedReplies */
function gdbbx_canned_replies() {
    return Features::instance()->is_enabled('canned-replies') ? CannedReplies::instance() : false;
}
