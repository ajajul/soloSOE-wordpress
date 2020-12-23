<?php

namespace Dev4Press\Plugin\GDQNT\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Core {
	public function __construct() {
		add_filter( 'bbp_template_include', array( $this, 'favorites_control' ) );

		add_filter( 'bbp_topic_pagination', array( $this, 'pagination_arrows' ) );
		add_filter( 'bbp_replies_pagination', array( $this, 'pagination_arrows' ) );
		add_filter( 'bbp_search_results_pagination', array( $this, 'pagination_arrows' ) );

		add_filter( 'bbp_body_class', array( $this, 'body_class' ) );
		add_filter( 'bbp_show_lead_topic', array( $this, 'show_lead_topic' ) );

		add_filter( 'bbp_after_get_user_subscribe_link_parse_args', array( $this, 'get_user_subscribe_link' ) );
		add_filter( 'bbp_after_get_user_favorites_link_parse_args', array( $this, 'get_user_favorites_link' ) );
		add_filter( 'bbp_after_get_author_link_parse_args', array( $this, 'get_author_link' ) );
	}

	/** @return Core */
	public static function instance() {
		static $_gdqnt_core = null;

		if ( ! isset( $_gdqnt_core ) ) {
			$_gdqnt_core = new Core();
		}

		return $_gdqnt_core;
	}

	public function body_class( $classes ) {
		$quantum = array(
			'gd-quantum-theme',
			'quantum-theme-' . $this->get_theme_variant(),
			'theme-stylesheet-' . get_stylesheet()
		);

		if ( get_template() != get_stylesheet() ) {
			$quantum[] = 'theme-template-' . get_template();
		}

		$quantum = apply_filters( 'gdqnt_body_classes', $quantum );

		return array_merge( $classes, $quantum );
	}

	public function is( $version = 26 ) {
		return d4p_get_bbpress_major_version_code() >= $version;
	}

	public function pagination_arrows( $args ) {
		$args['prev_text'] = is_rtl()
			?
			'<i aria-hidden="true" class="gdqnt-icon gdqnt-icon-caret-right" title="' . __( "Previous", "gd-quantum-theme-for-bbpress" ) . '"></i>'
			:
			'<i aria-hidden="true" class="gdqnt-icon gdqnt-icon-caret-left" title="' . __( "Previous", "gd-quantum-theme-for-bbpress" ) . '"></i>';
		$args['next_text'] = is_rtl()
			?
			'<i aria-hidden="true" class="gdqnt-icon gdqnt-icon-caret-left" title="' . __( "Next", "gd-quantum-theme-for-bbpress" ) . '"></i>'
			:
			'<i aria-hidden="true" class="gdqnt-icon gdqnt-icon-caret-right" title="' . __( "Next", "gd-quantum-theme-for-bbpress" ) . '"></i>';

		return $args;
	}

	public function show_lead_topic( $lead ) {
		return gdqnt_customizer()->get( 'topic-lead-topic' );
	}

	public function breadcrumbs() {
		if ( gdqnt_customizer()->get( 'breadcrumbs' ) ) {
			bbp_breadcrumb(
				array( 'sep' => is_rtl() ? '&laquo;' : '&raquo;' )
			);
		}
	}

	public function reply_admin_links( $args = array() ) {
		if ( gdqnt_customizer()->get( 'posts-controls' ) == 'dropdown' ) {
			$this->_reply_admin_links_dropdown( $args );
		} else {
			bbp_reply_admin_links( $args );
		}
	}

	public function topic_admin_links( $args = array() ) {
		if ( gdqnt_customizer()->get( 'posts-controls' ) == 'dropdown' ) {
			$this->_topic_admin_links_dropdown( $args );
		} else {
			bbp_topic_admin_links( $args );
		}
	}

	public function get_user_subscribe_link( $r ) {
		if ( ! isset( $r['profile'] ) ) {
			$r['before']      = '';
			$r['after']       = '';
			$r['subscribe']   = '<i aria-hidden="true" class="gdqnt-icon gdqnt-icon-subscribe" title="' . __( "Subscribe", "gd-quantum-theme-for-bbpress" ) . '"></i><span> ' . __( "Subscribe", "gd-quantum-theme-for-bbpress" ) . '</span>';
			$r['unsubscribe'] = '<i aria-hidden="true" class="gdqnt-icon gdqnt-icon-unsubscribe" title="' . __( "Unsubscribe", "gd-quantum-theme-for-bbpress" ) . '"></i><span> ' . __( "Unsubscribe", "gd-quantum-theme-for-bbpress" ) . '</span>';
		}

		return $r;
	}

	public function get_user_favorites_link( $r ) {
		if ( ! isset( $r['profile'] ) ) {
			$r['before']    = '';
			$r['after']     = '';
			$r['favorite']  = '<i aria-hidden="true" class="gdqnt-icon gdqnt-icon-favorite" title="' . __( "Favorite", "gd-quantum-theme-for-bbpress" ) . '"></i><span> ' . __( "Favorite", "gd-quantum-theme-for-bbpress" ) . '</span>';
			$r['favorited'] = '<i aria-hidden="true" class="gdqnt-icon gdqnt-icon-unfavorite" title="' . __( "Unfavorite", "gd-quantum-theme-for-bbpress" ) . '"></i><span> ' . __( "Unfavorite", "gd-quantum-theme-for-bbpress" ) . '</span>';
		}

		return $r;
	}

	public function get_author_link( $args ) {
		$args['sep'] = '';

		return $args;
	}

	public function topic_user_links() {
		bbp_topic_subscription_link();
		bbp_topic_favorite_link();

		if ( gdqnt_customizer()->get( 'topic-action-new-reply' ) && bbp_current_user_can_access_create_reply_form() ) {
			bbp_topic_new_reply_link();
		}
	}

	public function favorites_control( $template ) {
		if ( bbp_is_favorites() ) {
			$_public = gdqnt_customizer()->get( 'profile-favorites-tab-is-public' );

			if ( ! $_public && ! $this->user_allowed_to_edit_current_profile() ) {
				$user_id = bbp_get_displayed_user_id();
				$profile = bbp_get_user_profile_url( $user_id );

				wp_redirect( $profile );
				exit;
			}
		}

		return $template;
	}

	public function user_profile_navigation() {
		$links = array(
			array(
				'current' => bbp_is_single_user_profile(),
				'icon'    => 'user',
				'class'   => 'bbp-user-profile-link',
				'url'     => bbp_get_user_profile_url(),
				'label'   => __( "Profile", "gd-quantum-theme-for-bbpress" )
			),
			array(
				'current' => bbp_is_single_user_topics(),
				'icon'    => 'topic',
				'class'   => 'bbp-user-topics-created-link',
				'url'     => bbp_get_user_topics_created_url(),
				'label'   => __( "Topics Started", "gd-quantum-theme-for-bbpress" )
			),
			array(
				'current' => bbp_is_single_user_replies(),
				'icon'    => 'reply',
				'class'   => 'bbp-user-replies-created-link',
				'url'     => bbp_get_user_replies_created_url(),
				'label'   => __( "Replies Created", "gd-quantum-theme-for-bbpress" )
			)
		);

		if ( bbp_is_engagements_active() ) {
			$links[] = array(
				'current' => bbp_is_single_user_engagements(),
				'icon'    => 'user',
				'class'   => 'bbp-user-engagements-created-link',
				'url'     => bbp_get_user_engagements_url(),
				'label'   => __( "Engagements", "gd-quantum-theme-for-bbpress" )
			);
		}

		if ( bbp_is_favorites_active() ) {
			$_public = gdqnt_customizer()->get( 'profile-favorites-tab-is-public' );

			if ( $_public || $this->user_allowed_to_edit_current_profile() ) {
				$links[] = array(
					'current' => bbp_is_favorites(),
					'icon'    => 'unfavorite',
					'class'   => 'bbp-user-favorites-link',
					'url'     => bbp_get_favorites_permalink(),
					'label'   => __( "Favorites", "gd-quantum-theme-for-bbpress" )
				);
			}
		}

		if ( $this->user_allowed_to_edit_current_profile() ) {
			if ( bbp_is_subscriptions_active() ) {
				$links[] = array(
					'current' => bbp_is_subscriptions(),
					'icon'    => 'unsubscribe',
					'class'   => 'bbp-user-subscriptions-link',
					'url'     => bbp_get_subscriptions_permalink(),
					'label'   => __( "Subscriptions", "gd-quantum-theme-for-bbpress" )
				);
			}

			$links[] = array(
				'current' => bbp_is_single_user_edit(),
				'icon'    => 'user',
				'class'   => 'bbp-user-edit-link',
				'url'     => bbp_get_user_profile_edit_url(),
				'label'   => __( "Edit", "gd-quantum-theme-for-bbpress" )
			);
		}

		return apply_filters( 'bbp_get_user_profile_links', $links );
	}

	public function user_allowed_to_edit_current_profile() {
		return bbp_is_user_home() || current_user_can( 'edit_user', bbp_get_displayed_user_id() );
	}

	private function _admin_links_dropdown( $links ) {
		if ( ! empty( $links ) ) {
			?>

            <div class="bbp-admin-links-dropdown">
                <a class="bbp-dropdown-open" href="#" aria-haspopup="true"><?php _e( "Options", "gd-quantum-theme-for-bbpress" ); ?></a>
                <ul class="bbp-dropdown" aria-label="submenu">
                    <li><?php echo join( '</li><li>', $links ); ?></li>
                </ul>
            </div>

			<?php

		}
	}

	private function _reply_admin_links_dropdown( $args = array() ) {
		$links = $this->_get_reply_admin_links( $args );

		$outside = apply_filters( 'gdqnt_reply_admin_links_dropdown_outside', array(), $links );

		$linear = array();
		if ( ! empty( $outside ) ) {
			$dropdown = array();

			foreach ( $links as $code => $link ) {
				if ( in_array( $code, $outside ) ) {
					$linear[ $code ] = $link;
				} else {
					$dropdown[ $code ] = $link;
				}
			}
		} else {
			$dropdown = $links;
		}

		$this->_admin_links_dropdown( $links );

		if ( ! empty( $linear ) ) {
			?>

            <span class="bbp-admin-links">
                <?php echo join( ' | ', $linear ); ?>
            </span>

			<?php
		}
	}

	private function _topic_admin_links_dropdown( $args = array() ) {
		$links = $this->_get_topic_admin_links( $args );

		$outside = apply_filters( 'gdqnt_topic_admin_links_dropdown_outside', array( 'quick-edit' ), $links );

		$linear = array();
		if ( ! empty( $outside ) ) {
			$dropdown = array();

			foreach ( $links as $code => $link ) {
				if ( in_array( $code, $outside ) ) {
					$linear[ $code ] = $link;
				} else {
					$dropdown[ $code ] = $link;
				}
			}
		} else {
			$dropdown = $links;
		}

		$this->_admin_links_dropdown( $dropdown );

		if ( ! empty( $linear ) ) {
			?>

            <span class="bbp-admin-links">
                <?php echo join( ' | ', $linear ); ?>
            </span>

			<?php
		}
	}

	private function _get_reply_admin_links( $args = array() ) {
		$r = array( 'id' => bbp_get_reply_id() );

		$r['id'] = bbp_get_reply_id( (int) $r['id'] );

		if ( bbp_is_topic( $r['id'] ) ) {
			return $this->_get_topic_admin_links( $args );
		}

		if ( ! bbp_is_reply( $r['id'] ) ) {
			return array();
		}

		if ( bbp_is_topic_trash( bbp_get_reply_topic_id( $r['id'] ) ) ) {
			return array();
		}

		$links = apply_filters( 'bbp_reply_admin_links', array(
			'edit'  => bbp_get_reply_edit_link( $r ),
			'move'  => bbp_get_reply_move_link( $r ),
			'split' => bbp_get_topic_split_link( $r ),
			'trash' => bbp_get_reply_trash_link( $r ),
			'spam'  => bbp_get_reply_spam_link( $r ),
			'reply' => bbp_get_reply_to_link( $r )
		), $r['id'] );

		$reply_status = bbp_get_reply_status( $r['id'] );
		if ( in_array( $reply_status, array( bbp_get_spam_status_id(), bbp_get_trash_status_id() ) ) ) {
			if ( bbp_get_trash_status_id() === $reply_status ) {
				unset( $links['spam'] );
			} else if ( bbp_get_spam_status_id() === $reply_status ) {
				unset( $links['trash'] );
			}
		}

		$links = array_filter( $links );

		return $links;
	}

	private function _get_topic_admin_links( $args = array() ) {
		$r = array( 'id' => bbp_get_topic_id() );

		$links = apply_filters( 'bbp_topic_admin_links', array(
			'edit'  => bbp_get_topic_edit_link( $r ),
			'close' => bbp_get_topic_close_link( $r ),
			'stick' => bbp_get_topic_stick_link( $r ),
			'merge' => bbp_get_topic_merge_link( $r ),
			'trash' => bbp_get_topic_trash_link( $r ),
			'spam'  => bbp_get_topic_spam_link( $r ),
			'reply' => bbp_get_topic_reply_link( $r )
		), $r['id'] );

		$topic_status = bbp_get_topic_status( $r['id'] );
		if ( in_array( $topic_status, array( bbp_get_spam_status_id(), bbp_get_trash_status_id() ) ) ) {
			unset( $links['close'] );

			if ( bbp_get_trash_status_id() === $topic_status ) {
				unset( $links['spam'] );
			} else if ( bbp_get_spam_status_id() === $topic_status ) {
				unset( $links['trash'] );
			}
		}

		$links = array_filter( $links );

		return $links;
	}

	public function get_theme_variant() {
		$theme = 'default-gray';
		$style = gdqnt_customizer()->get( 'style' );

		if ( $style == 'color-scheme' ) {
			$scheme = gdqnt_customizer()->get( 'color-scheme' );

			foreach ( gdqnt()->get_color_themes_codes() as $code ) {
				if ( substr( $scheme, 0, strlen( $code ) ) == $code ) {
					$theme = $code;
					break;
				}
			}
		} else if ( $style == 'custom-style' ) {
			$theme = gdqnt_customizer()->get( 'color-theme' );
		}

		return $theme;
	}
}
