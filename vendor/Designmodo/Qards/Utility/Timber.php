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

use Designmodo\Qards\Utility\Db;
use Designmodo\Qards\Page\Layout\Component\Template\Template;
use Designmodo\Qards\Twig\Extension\PhpEval;

/**
 * Timber inits and provides features of the Timber.
 */
class Timber
{

    /**
     * Init the Timber
     *
     * @return void
     */
    static public function init()
    {
        // Load Timber if needed
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if (! class_exists('\Timber')) {
            require_once DM_BASE_PATH . '/vendor/Timber/timber.php';
        } elseif (! is_admin() && \is_plugin_active('timber-library/timber.php')) {
            throw new \Exception('Please deactivate your Timber plugin before use of this plugin.', 705213);
        }

        // This is where you can add your own fuctions to twig
        add_filter(
            'get_twig',
            function($twig) {
                $twig->addExtension(new \Twig_Extension_StringLoader());
                $twig->addExtension(new PhpEval());
                return $twig;
            }
        );

        // Custom search form
        add_filter(
            'get_search_form',
            function($form) {
                $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
                    <div><label class="screen-reader-text" for="s">' . __( 'Search for:' ) . '</label>
                    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
                    <input type="submit" id="searchsubmit" value="'. esc_attr__( 'Search' ) .'" />
                    </div>
                    </form>';
                return $form;
            }
        );
    }

    static public function setupContext(){
        // Setup context
        Context::getInstance()->set('ajaxurl', admin_url('admin-ajax.php'));
        Context::getInstance()->set('mainMenu', new \TimberMenu(Menu::MENU_LOCATION_MAIN));
        Context::getInstance()->set('footerMenu', new \TimberMenu(Menu::MENU_LOCATION_FOOTER));
        Context::getInstance()->set('pluginUrl', DM_PLUGIN_URL);
        Context::getInstance()->set('baseUrl', get_site_url());
        Context::getInstance()->set('postType', DM_POST_TYPE);
        $siteUrlParts = parse_url(get_site_url());
        Context::getInstance()->set('baseUri', empty($siteUrlParts['path']) ? '/' : $siteUrlParts['path']);
        Context::getInstance()->set('menuEditPageUriPattern', admin_url('nav-menus.php?action=edit&menu=%s'));
        Context::getInstance()->set('edit_mode', (bool) (! empty($_REQUEST['dm_edit_mode']) && current_user_can('edit_posts')));
        Context::getInstance()->set('wp_mode', true);
        Context::getInstance()->set('debug_mode', DM_DEBUG_MODE);
        Context::getInstance()->set('_REQUEST', $_REQUEST);
        Context::getInstance()->set('DM_SHOW_PROMO_BANNER', intval(Settings::get(Settings::SETTING_SHOW_PROMO_BANNER)));
        Context::getInstance()->set('SETTING_SITE_TITLE', Settings::get(Settings::SETTING_SITE_TITLE));
        Context::getInstance()->set('SETTING_GA_API_KEY', Settings::get(Settings::SETTING_GA_API_KEY));
        Context::getInstance()->set('SETTING_GA_TRACK', Settings::get(Settings::SETTING_GA_TRACK));
        Context::getInstance()->set('SETTING_TYPEKIT_ID', Settings::get(Settings::SETTING_TYPEKIT_ID));
        Context::getInstance()->set('SETTING_WP_HEAD', Settings::get(Settings::SETTING_WP_HEAD));
        Context::getInstance()->set('SETTING_WP_HEADER', Settings::get(Settings::SETTING_WP_HEADER));
        Context::getInstance()->set('SETTING_WP_FOOTER', Settings::get(Settings::SETTING_WP_FOOTER));
        Context::getInstance()->set('SETTING_MAILCHIMP_API_KEY', Settings::get(Settings::SETTING_MAILCHIMP_API_KEY));
        Context::getInstance()->set('SETTING_MAILCHIMP_LIST_URL', Settings::get(Settings::SETTING_MAILCHIMP_LIST_URL));
        Context::getInstance()->set('SETTING_BACKGROUND_CSS', Settings::get(Settings::SETTING_BACKGROUND_CSS));
        Context::getInstance()->set('SETTING_BG_IMG', Settings::get(Settings::SETTING_BG_IMG));
        Context::getInstance()->set('is_WPSEO_VERSION_or_AIOSEOP_VERSION', defined('WPSEO_VERSION') || defined('AIOSEOP_VERSION'));
    }

    /**
     * Clear Timber cache
     *
     * @return void
     */
    static public function clearCache()
    {
        $origCacheState = self::cache();
        self::cache(true);
//         if (is_writable(DM_TPL_CACHE_PATH)) {
//             $loader = new \TimberLoader(\Timber::get_calling_script_dir());
//             $loader->clear_cache_twig();
//         }
        wp_cache_flush();
        Db::query('
            DELETE FROM `' . Db::getWpDb()->options . '`
            WHERE
                `option_name` LIKE "_transient_timberloader_%"
                OR
                `option_name` LIKE "_transient_timeout_timberloader_%"
        ');
        self::cache($origCacheState);
    }

    /**
     * Timber cache mngmt
     *
     * @param mixed $mode true - switch on the cache, false - switch off the cache, null - get cache mode.
     * @return bool
     */
    static public function cache($mode = null)
    {
        if (is_null($mode)) {
            return \Timber::$cache;
        } elseif ($mode) {
            return \Timber::$cache = true;
        } elseif (!$mode) {
            return \Timber::$cache = false;
        }
    }
}