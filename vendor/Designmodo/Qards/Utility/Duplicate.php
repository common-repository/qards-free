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

use Designmodo\Qards\Page\Layout\Layout;
/**
 * Duplicate implements duplication functions.
 */
class Duplicate
{
    /**
     * Duplicate qards post
     *
     * @param int $postId
     * @param string $status
     * @param int $newAuthorId get_current_user_id()
     * @return int|void New post ID
     */
    static public function duplicatePost($postId, $status = null, $newAuthorId = null, $titleSuffix = ' 2',$type=false)
    {
        $post = get_post($postId);
        if (!get_post_meta($post->ID, '_qards_page_layout', true)) {
            return;
        }
        $newPost = array(
            'menu_order' => $post->menu_order,
            'comment_status' => $post->comment_status,
            'ping_status' => $post->ping_status,
            'post_author' => $newAuthorId ? $newAuthorId : $post->post_author,
            'post_content' => $post->post_content,
            'post_excerpt' => $post->post_excerpt,
            'post_mime_type' => $post->post_mime_type,
            'post_parent' => $post->post_parent,
            'post_password' => $post->post_password,
            'post_status' => $newPostStatus = (empty($status)) ? $post->post_status : $status,
            'post_title' => $post->post_title . $titleSuffix,
            'post_type' => !empty($type) ? $type : $post->post_type
        );
        $newPostId = wp_insert_post($newPost);
        if(!$newPostId) throw new Exception('Can\'t create post');
        if ($status == 'publish' || $status == 'future') {
            $newPost = array();
            $newPost['ID'] = $newPostId;
            $newPost['post_name'] = wp_unique_post_slug($post->post_name, $newPostId, $newPostStatus, $post->post_type, 0);
            wp_update_post($newPost);
        }
        $postMetaKeys = get_post_custom_keys($post->ID);
        foreach ($postMetaKeys as $metaKey) {
            $metaValues = get_post_custom_values($metaKey, $post->ID);
            foreach ($metaValues as $metaValue) {
                $metaValue = maybe_unserialize($metaValue);
                // Copy without rewrite
                add_post_meta($newPostId, $metaKey, $metaValue);
            }
        }

        $layoutId = get_post_meta($post->ID, '_qards_page_layout', true);
        $layout = new Layout($layoutId);
        $layout = $layout->duplicate();
        if ($layoutId = $layout->save()) {
            update_post_meta($newPostId, '_qards_page_layout', $layoutId);
        }
        return $newPostId;
    }

    /**
     * Handle duplication action in admin section
     *
     * @return void
     */
    public static function handleDuplicationRequest()
    {
        if ('duplicate_qards' == $_REQUEST['action']) {
            if (!current_user_can('edit_posts')) {
                wp_die(__('This user have no permisson to "edit_posts".'));
                exit;
            }
            if ($_REQUEST['post']) {
                $postId = Duplicate::duplicatePost((int)$_REQUEST['post'], 'draft', get_current_user_id());
                if (!$postId) {
                    wp_die(__('This post could not be duplicated.'));
                    exit;
                }
                $post = get_post($postId);
                wp_redirect(admin_url('edit.php?post_type=' . $post->post_type));
                exit;
            }
        }
    }

    /**
     * Add to qards menu duplication item
     *
     * @return void
     */
    public static function addToMenu()
    {
        add_filter('page_row_actions', array('Designmodo\Qards\Utility\Duplicate', 'rowAction'), 9, 2);
        add_filter('post_row_actions', array('Designmodo\Qards\Utility\Duplicate', 'rowAction'), 9, 2);
        add_action('admin_action_duplicate_qards', array('Designmodo\Qards\Utility\Duplicate', 'handleDuplicationRequest'));
    }
    public static function rowAction($actions, $post) {
        if (current_user_can('edit_posts') && get_post_meta($post->ID, '_qards_page_layout', true) ) {
            $actions['duplicate_qards'] = '<a href="' . admin_url('admin.php?action=duplicate_qards&post=' . $post->ID) . '" title="' . esc_attr(__("Duplicate this qard")) . '">' . __('Duplicate') . '</a>';
        }
        return $actions;
    }
}