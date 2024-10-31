<?php
/**
 * Plugin Name: WordPress Page Builder - Qards
 * Plugin URI: https://designmodo.com/qards/
 * Description: The Powerful WordPress plugin to easily create beautiful landing-pages in no time. With no coding skills.
 * Version: 1.0.5
 * Author: Designmodo Inc.
 * Author URI: https://designmodo.com/
 */

defined('DONOTMINIFY') OR define('DONOTMINIFY', true);
// Config loader.
$_qards_config = array();
require_once __DIR__ . '/config/config.php';
if (!empty($_qards_config)) {
    foreach ($_qards_config as $k => $v) {
        define($k, $v);
    }

    // Check PHP version
    if (version_compare(phpversion(), DM_MIN_PHP_VERSION, '<')) {
        if (is_admin()) {
            add_action('admin_notices', 'qards_error_php');
            function qards_error_php()
            {
                ?>
                <div id="message" class="error">
                    <p>
                        <b><?php printf(__('Qards requires PHP %s or greater. You have %s'), DM_MIN_PHP_VERSION, phpversion()); ?></b>
                    </p>
                </div>
                <?php
                deactivate_plugins(str_replace('\\', '/', dirname(__FILE__)) . '/qards.php');
            }
        } else {
            throw new Exception(sprintf(__('Qards requires PHP %s or greater. You have %s'), DM_MIN_PHP_VERSION, phpversion()), 986545);
        }
        return;
    }

    // Activation hook
    function _qards_activation_hook()
    {
        global $wpdb;
        $postMetas = $wpdb->get_results(
            'SELECT *
        FROM   `' . $wpdb->postmeta . '`
        WHERE  `meta_key` LIKE  "_qards_content"',
            ARRAY_A
        );
        if ($postMetas) {
            foreach ($postMetas as $postMeta) {
                $post = get_post($postMeta['post_id']);
                add_post_meta($postMeta['post_id'], '_qards_page_content', $post->post_content, true)
                ||
                update_post_meta($postMeta['post_id'], '_qards_page_content', $post->post_content);
                wp_update_post(array('ID' => $postMeta['post_id'], 'post_content' => $postMeta['meta_value']));
                delete_post_meta($postMeta['post_id'], '_qards_content');
            }
        }
    }

    register_activation_hook(__FILE__, '_qards_activation_hook');

    // Deactivation hook
    function _qards_deactivation_hook()
    {
        global $wpdb;

        $postMetas = $wpdb->get_results(
            'SELECT *
        FROM   `' . $wpdb->postmeta . '`
        WHERE  `meta_key` LIKE  "_qards_page_content"',
            ARRAY_A
        );
        if ($postMetas) {
            foreach ($postMetas as $postMeta) {
                $post = get_post($postMeta['post_id']);
                add_post_meta($postMeta['post_id'], '_qards_content', $post->post_content, true)
                ||
                update_post_meta($postMeta['post_id'], '_qards_content', $post->post_content);
                wp_update_post(array('ID' => $postMeta['post_id'], 'post_content' => $postMeta['meta_value']));
            }
        }
    }

    register_deactivation_hook(__FILE__, '_qards_deactivation_hook');

    // Load initializer
    require_once __DIR__ . '/init.php';
}
