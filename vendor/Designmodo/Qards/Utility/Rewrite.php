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
 * Rewrite implements removing slugs of CPT from URLs.
 */
class Rewrite
{

    /**
     * Init rewriter
     *
     * @return void
     */
    static public function init()
    {
        //self::regenerateRewriteRules();

        // Save post
        add_action(
            'save_post',
            function ($postId) {
                Rewrite::regenerateRewriteRules();
            }
        );
        
        //fix on update page_on_front option
        add_action(
            'update_option_page_on_front',
            function ($old_value, $value, $option) {
                Rewrite::regenerateRewriteRules();
            }
        );


        // Press Visual Editor button
        add_filter(
            'redirect_post_location',
            function ($location) {
                if (!empty($_POST['visualEditorHref'])) {
                    $location = $_POST['visualEditorHref'];
                }
                wp_redirect($location);
            }
        );

        // Insert/update post handler
        add_action(
            'wp_insert_post',
            function ($postId) {
                if (get_post_type($postId) == DM_POST_TYPE) {
                    Rewrite::regenerateRewriteRules();
                }
            }
        );

        // Remove slug from link
        add_filter(
            'post_type_link',
            function ($permalink, $post) {
                $frontpage_id = get_option( 'page_on_front' );
                $customPostTypes = get_post_types(array('_builtin' => false), 'objects');
                foreach ($customPostTypes as $type => $postType) {
                    if ($type == DM_POST_TYPE) {
                        if($post->ID==$frontpage_id)  return get_home_url();
                        $slug = trim($postType->rewrite['slug'], '/');
                        $permalink = str_replace(get_bloginfo('url') . '/' . $slug . '/', get_bloginfo('url') . '/', $permalink);
                    }
                }
                return $permalink;
            }, 100, 2
        );

        // Filter the slug
        add_filter(
            'wp_unique_post_slug',
            function ($slug, $postId, $postStatus, $postType, $postParent, $originalSlug) {
                $hierarchicalPostTypes = array_merge(get_post_types(array('hierarchical' => true)), array('page' => 'page', 'post' => 'post', DM_POST_TYPE => DM_POST_TYPE, 'sf_page' => 'sf_page'));
                if ($originalSlug == $slug && in_array($postType, $hierarchicalPostTypes)) {
                    $sql = '
                        SELECT
                            post_name
                        FROM ' . Db::getWpDb()->posts . '
                        WHERE
                            post_name = %s
                            AND
                            ID != %d
                            AND
                            post_type IN ( "' . implode( '", "', esc_sql( $hierarchicalPostTypes ) ) . '" )
                        LIMIT 1';

                    $postNameCheck = Db::getColumn($sql, array(
                        $slug,
                        $postId
                    ));

                    if ($postNameCheck) {
                        $suffix = 2;
                        do {
                            $altPostName = _truncate_post_slug($slug, 200 - (strlen($suffix) + 1)) . "-$suffix";
                            $postNameCheck = Db::getColumn($sql, array(
                                $altPostName,
                                $postId
                            ));
                            $suffix ++;
                        } while ($postNameCheck);
                        $slug = $altPostName;
                    }
                }
                return $slug;
            },
            10,
            6
        );

    }

    /**
     * Regenerate rewrite rules for each custom page
     *
     * @return void
     */
    static public function regenerateRewriteRules()
    {
        self::generateRewriteRules();
        flush_rewrite_rules(false);
    }

    /**
     * Generate rewrite rules for each custom page
     *
     * @return void
     */
    static public function generateRewriteRules()
    {
        $customPostTypes = get_post_types(array('_builtin' => false), 'objects');
        
        //check PolyLang
        $poly_options = get_option('polylang');
        //check:The language is set from the directory name in pretty permalinks
        $lang_from_directory = (!empty($poly_options) && $poly_options['force_lang'] == 1);
        $frontpage_id = get_option( 'page_on_front' );

        foreach ($customPostTypes as $type => $postType) {
            if ($type == DM_POST_TYPE) {
                $posts = Db::getAll(
                    'SELECT ID, post_name
                    FROM `' . Db::getWpDb()->posts . '`
                    WHERE post_name !=  ""
                    AND post_type = %s',
                    array($type)
                );
                $is_translated_type = (!empty($lang_from_directory) && function_exists('pll_is_translated_post_type') && pll_is_translated_post_type($type));
                foreach ($posts as $post) {
                    $slug = ($post['ID']==$frontpage_id) ? '' : $post['post_name'] ;
                    add_rewrite_rule($slug . '$', 'index.php?' . $postType->query_var . '=' . $post['post_name'], 'top');
                    if($is_translated_type && function_exists('pll_languages_list') && false!=($lang=pll_get_post_language($post['ID'])))
                        add_rewrite_rule("(".$lang.")/".$post['post_name'] . '$', 'index.php?' . $postType->query_var . '=' . $post['post_name'], 'top');
                }
            }
        }
    }
}