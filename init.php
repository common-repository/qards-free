<?php
use Symfony\Component\ClassLoader\ClassLoader;
/*
 * This file is part of the Designmodo WordPress Plugin.
 *
 * (c) Designmodo Inc. <info@designmodo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Class loader
if (! class_exists('Symfony\\Component\\ClassLoader\\ClassLoader')) {
    require_once DM_BASE_PATH . '/vendor/Symfony/Component/ClassLoader/ClassLoader.php';
}

$_qardsClassLoader = new ClassLoader();
$_qardsClassLoader->addPrefix('Symfony', DM_BASE_PATH . '/vendor/');
$_qardsClassLoader->addPrefix('Designmodo', DM_BASE_PATH . '/vendor/');
$_qardsClassLoader->addPrefix('Sabberworm', DM_BASE_PATH . '/vendor/');
$_qardsClassLoader->register();
$_qardsClassLoader->setUseIncludePath(true);

use Designmodo\Qards\Utility\Context;
use Designmodo\Qards\Utility\Menu;
use Designmodo\Qards\Utility\Post;
use Designmodo\Qards\Utility\Timber;
use Designmodo\Qards\Utility\Migrations;
use Designmodo\Qards\Utility\Rewrite;
use Designmodo\Qards\Utility\Api;
use Designmodo\Qards\Utility\ContactForm;
use Designmodo\Qards\Utility\User;
use Designmodo\Qards\Utility\SettingsPage;
use Designmodo\Qards\License\License;
use Designmodo\Qards\Utility\Subscription;
use Designmodo\Qards\Utility\StyleScriptFilter;
use Designmodo\Qards\Utility\AdminMsg;
use Designmodo\Qards\Utility\Cleaner;
use Designmodo\Qards\Utility\Shortcode;
use Designmodo\Qards\Utility\Duplicate;
use Designmodo\Qards\Utility\Settings;

// Init exception handler
set_exception_handler(function ($exception) {
    echo '
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Oops!</title>
    <style>
    </style>
  </head>
  <body>
  	<div>
	    <h1>Beep beep boop!</h1>
        <h2>Error occurred :(</h2>
        <p>Something went wrong while displaying this page.</p>
        <p>Please, let us know about this incident.</p>
        <pre>' . $exception->getCode() . ': ' . $exception->getMessage() . '</pre>
        <pre style="display: none">' . $exception->getTraceAsString() . '</pre>
	</div>
  </body>
</html>';
});

// Initialize the plugin
add_action(
    'init',
    function () {
        // Allow cross domain sharing
        header('Access-Control-Allow-Origin: *');

        // Init the migration tool
        Migrations::init();

        // License init
        //License::init();

        // Register custom post type
        Post::registerCustomPostType();

        // Init template engine
        Timber::init();

        // Init menus
        Menu::init();

        if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'dm_api') {
            Timber::setupContext();
            Menu::initMenus();
        }

        // Setting page init
        SettingsPage::init();

        // Shortcodes
        Shortcode::init();

//         // Declarate theme supported features
//         add_theme_support('post-formats');
//         add_theme_support('post-thumbnails');
//         add_theme_support('menus');

        // Add Mediaelement on the page
        wp_enqueue_style( 'wp-mediaelement' );
        wp_enqueue_script( 'wp-mediaelement' );

        // Rewriter init
        Rewrite::init();

        // Add to post menu
        Duplicate::addToMenu();

        // Ajax handler
        add_action('wp_ajax_dm_api', array('Designmodo\Qards\Utility\Api', 'handler'));
        add_action('wp_ajax_nopriv_dm_api', array('Designmodo\Qards\Utility\Api', 'handler'));

        // Contact form handler
        ContactForm::handler();

        // Registrantion of new user handler
        User::registrationHandler();

        // Registrantion of new subscriber handler
        Subscription::subscriptionHandler();

        // Add links on the plugins page
        add_filter(
            'plugin_action_links_qards-free/qards.php', // 'plugin_row_meta',
            function ($links) {
                $links[] = '<a href="https://designmodo.com/qards/faq/">FAQ</a>';
                $links[] = '<a href="https://designmodo.com/qards/first-steps/" target="_blank">First Steps</a>';
                $links[] = '<a href=" https://designmodo.com/qards/support/" target="_blank">Support</a>';
                return $links;
            }
        );


        add_filter('qards_fonts_list_otherFonts_family',function($list=[]){
            $otherFonts = apply_filters('qards_fonts_list_otherFonts',[]);
            foreach ($otherFonts as $name=>$otherFont) {
                if(!empty($otherFont['family']))
                    $list[$name] = $otherFont['family'];
            }
            return $list;
        },10,1);

        if (is_admin()) {
            // Add button to TMCE
            add_action(
                'admin_enqueue_scripts',
                function () {
                    wp_enqueue_script('jquery-ui-dialog');
                    wp_enqueue_style('wp-jquery-ui-dialog');
                }
            );
            add_action('admin_head', function () {
                global $typenow;
                // check user permissions
                if (! current_user_can('edit_posts') && ! current_user_can('edit_pages')) {
                    return;
                }
                // verify the post type
                if (! in_array($typenow, array('post', 'page'))) {
                    return;
                }
                // check if WYSIWYG is enabled
                if (get_user_option('rich_editing') == 'true') {
                    add_filter(
                        'mce_external_plugins',
                        function ($plugin_array) {
                            $plugin_array['qards_tc_button'] = plugins_url('/js/qards_tc_button.js', __FILE__);
                            return $plugin_array;
                        }
                    );
                    add_filter(
                        'mce_buttons',
                        function ($buttons) {
                            array_push($buttons, 'qards_tc_button');
                            return $buttons;
                        }
                    );
                }
            });
        }

        // Show admin's msgs
        AdminMsg::show();

        // Ajax proxy
        if (!empty($_GET['action']) && $_GET['action'] == 'dm_api') {
            Api::handler();
            exit();
        }
    }
);

// Init scripts/styles filtering
add_action('wp', function () {
    if (is_admin() || is_home()) {
        return;
    }
    if ((is_page() || is_single()) && $post = get_post()) {
        $isEmbed = (get_post_meta($post->ID, '_qards_page_mode', true) == 'embed');
        if(!empty($_REQUEST['dm_edit_mode']) && null===Context::getInstance()->get('edit_mode')){
            Context::getInstance()->set('edit_mode', (bool) (! empty($_REQUEST['dm_edit_mode']) && current_user_can('edit_posts')));
        }
        if (post_password_required() || !get_post_meta($post->ID, '_qards_page_layout', true) || ($isEmbed && !Context::getInstance()->get('edit_mode'))) {
            return;
        }

        add_action( 'after_setup_theme', function(){
            add_theme_support( 'title-tag' );
        } );

        remove_action( 'wp_head', '_wp_render_title_tag', 1 );

        add_action('wp_print_styles', array('Designmodo\Qards\Utility\StyleScriptFilter', 'filterStyles'));
        add_action('wp_print_scripts', array('Designmodo\Qards\Utility\StyleScriptFilter', 'filterScripts'));

        if(Context::getInstance()->get('edit_mode')) {
            add_action( 'wp_print_styles', array( 'Designmodo\Qards\Utility\StyleScriptFilter', 'filterStylesEditMode' ),300 );
            add_action( 'wp_print_scripts', array( 'Designmodo\Qards\Utility\StyleScriptFilter', 'filterScriptsEditMode' ),300 );
	        add_action( 'wp_print_scripts',function(){
		        wp_deregister_script ('jquery-ui-mouse');
		        wp_deregister_script ('jquery-ui-core');
		        wp_deregister_script ('jquery-ui-widget');
	        }, 100 );

            remove_all_filters('wp_head');
            add_action( 'wp_head',             'wp_enqueue_scripts',              1     );
            add_action( 'wp_head',             'wp_print_styles',                  8    );
            add_action( 'wp_head',             'wp_print_head_scripts',            9    );

            remove_all_filters('wp_footer');
            add_action( 'wp_footer',           'wp_print_footer_scripts',         20    );
        }
    }
});