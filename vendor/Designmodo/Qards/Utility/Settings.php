<?php
/*
 * This file is part of the Designmodo WordPress Plugin.
 *
 * (c) Designmodo Inc. <info@designmodo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Designmodo\Qards\Utility;

/**
 * Settings provides features of settings mngmt.
 */
class Settings
{
    const SETTING_SITE_TITLE = '_QARDS_SETTING_SITE_TITLE';
    const SETTING_DOMAIN = '_QARDS_SETTING_DOMAIN';
    const SETTING_GA_API_KEY = '_QARDS_SETTING_GA_API_KEY';
    const SETTING_GA_TRACK = '_QARDS_SETTING_GA_TRACK';
    const SETTING_LOGO = '_QARDS_SETTING_LOGO';
    const SETTING_BG_IMG = '_QARDS_SETTING_BG_IMG';
    const SETTING_GLOBAL_CSS = '_QARDS_SETTING_GLOBAL_CSS';
    const SETTING_BACKGROUND_CSS = '_QARDS_SETTING_BACKGROUND_CSS';
    const SETTING_WP_HEAD = '_QARDS_SETTING_WP_HEAD';
    const SETTING_WP_HEADER = '_QARDS_SETTING_WP_HEADER';
    const SETTING_WP_FOOTER = '_QARDS_SETTING_WP_FOOTER';
    const SETTING_TYPEKIT_ID = '_QARDS_SETTING_TYPEKIT_ID';
    const SETTING_SHOW_PROMO_BANNER = '_QARDS_SETTING_SHOW_PROMO_BANNER';
    const SETTING_QARDS_VERSION = 'qards_version';
    const SETTING_MAILCHIMP_API_KEY = '_QARDS_SETTING_MAILCHIMP_API_KEY';
    const SETTING_MAILCHIMP_LIST_URL = '_QARDS_SETTING_MAILCHIMP_LIST_URL';
    // const SETTING_ = '_QARDS_SETTING_';
    // const SETTING_ = '_QARDS_SETTING_';
    // const SETTING_ = '_QARDS_SETTING_';

    /**
     * Set setting
     *
     * @param string $setting
     * @param string $val
     * @return void
     */
    static public function set($setting, $val)
    {
        add_option($setting, $val) || update_option($setting, $val);
    }

    /**
     * Get setting
     *
     * @param string $setting
     * @param string $default
     * @return string
     */
    static public function get($setting, $default='')
    {
        return get_option($setting, $default);
    }

    /**
     * Reset settings
     *
     * @return void
     */
    static public function reset()
    {
        $settings = array(
            self::SETTING_SITE_TITLE => htmlspecialchars_decode(get_bloginfo()),
            self::SETTING_DOMAIN => '',
            self::SETTING_GA_API_KEY => '',
            self::SETTING_LOGO => '',
            self::SETTING_BG_IMG => '',
            self::SETTING_GLOBAL_CSS => 'body.qards {}',
            self::SETTING_WP_HEAD => '',
            self::SETTING_WP_HEADER => '',
            self::SETTING_WP_FOOTER => '',
            self::SETTING_TYPEKIT_ID => '',
            self::SETTING_SHOW_PROMO_BANNER => 0,
            self::SETTING_MAILCHIMP_API_KEY => '',
            self::SETTING_MAILCHIMP_LIST_URL => '',
            self::SETTING_BACKGROUND_CSS => '',
        );
        foreach ($settings as $setting => $val) {
            self::set($setting, $val);
        }
    }
}