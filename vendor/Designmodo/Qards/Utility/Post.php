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
 * Post provides post features of WordPress.
 */
class Post
{
    const OPT_PAGE_LAYOUT = '_qards_page_layout';
    const OPT_ORIG_PAGE_CONTENT = '_qards_page_content';
    const OPT_OLD_PAGE_LAYOUT = '_old_qards_page_layout';
    const OPT_QARDS_MODE = '_qards_page_mode';


    /**
     * Register custom post type
     *
     * @return void
     */
    static public function registerCustomPostType()
    {
        $labels = array(
            'name'               => __( 'Qards'),
            'singular_name'      => __( 'Qards Page' ),
            'menu_name'          => __( 'Qards' ),
            'name_admin_bar'     => __( 'Qards Page' ),
            'add_new'            => __( 'Add New' ),
            'add_new_item'       => __( 'Add New Page' ),
            'new_item'           => __( 'New Page' ),
            'edit_item'          => __( 'Edit Page' ),
            'view_item'          => __( 'View Page' ),
            'all_items'          => __( 'All Pages' ),
            'search_items'       => __( 'Search Pages' ),
            'parent_item_colon'  => __( 'Parent Pages:' ),
            'not_found'          => __( 'No pages found.' ),
            'not_found_in_trash' => __( 'No pages found in Trash.' )
        );

        // Define icon styles for the custom post type
        add_action(
            'admin_head',
            function () {
                ?>
                <style type="text/css" media="screen">
                    @font-face {
                        font-family: 'qards-icon';
                        src:url('<?php echo DM_PLUGIN_URL; ?>/fonts/qards/qards-icon.eot?-azkf4y');
                        src:url('<?php echo DM_PLUGIN_URL; ?>/fonts/qards/qards-icon.eot?#iefix-azkf4y') format('embedded-opentype'),
                            url('<?php echo DM_PLUGIN_URL; ?>/fonts/qards/qards-icon.woff?-azkf4y') format('woff'),
                            url('<?php echo DM_PLUGIN_URL; ?>/fonts/qards/qards-icon.ttf?-azkf4y') format('truetype'),
                            url('<?php echo DM_PLUGIN_URL; ?>/fonts/qards/qards-icon.svg?-azkf4y#icomoon') format('svg');
                        font-weight: normal;
                        font-style: normal;
                    }
                    #menu-posts-qards_page .wp-menu-image:before {
                        font-family: 'qards-icon';
                        speak: none;
                        font-style: normal;
                        font-weight: normal;
                        font-variant: normal;
                        text-transform: none;
                        line-height: 1;
                        /* Better Font Rendering =========== */
                        -webkit-font-smoothing: antialiased;
                        -moz-osx-font-smoothing: grayscale;
                        content: "\e600";
                        font-size: 18px !important;
                    }
                    .mce-i-qards_tc_button:before {
                        font-family: 'qards-icon';
                        speak: none;
                        font-style: normal;
                        font-weight: normal;
                        font-variant: normal;
                        text-transform: none;
                        line-height: 1;
                        -webkit-font-smoothing: antialiased;
                        -moz-osx-font-smoothing: grayscale;
                        content: "\e600";
                    }
                </style>
                <?php
            }
        );

        $args = array(
            'labels'             => $labels,
            'menu_icon'          => '',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('with_front' => false, 'slug' => 'qards' ),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'supports'           => array( 'title', 'author' )
        );

        register_post_type( DM_POST_TYPE, $args );

        // Add custom post type to the get_pages
        add_filter(
            'get_pages',
            function ($pages) {
                $qardsPosts = get_posts(array('post_type' => DM_POST_TYPE, 'posts_per_page' => 5000));
                return array_merge($pages, $qardsPosts);
            }
        );

        // Add custom post type to front page selector
        /*add_action(
            'pre_get_posts',
            function ($query) {
				$postType = '';
				if (array_key_exists('post_type', $query->query_vars)) {
                	$postType = $query->query_vars['post_type'];
				}
                if ('' == $postType && 0 != $query->query_vars['page_id']) {
                    $query->query_vars['post_type'] = array(
                        'page',
                        DM_POST_TYPE
                    );
                }
            }
        );*/

        // Set layout to new page
        add_action(
            'wp_insert_post',
            function ($postId) {
                // Set layout id
                $post = new \TimberPost($postId);
                if ($post->get_post_type()->name == DM_POST_TYPE && !get_post_meta($postId, '_qards_page_layout', true)) {
                    // Set status draft
                    Db::update(
                        Db::getWpDb()->posts,
                        array('post_status' => 'draft'),
                        array('ID' => $postId, 'post_status' => 'auto-draft')
                    );
                    $layout = new Layout();
                    $layout->save();
                    Post::setOpt($postId, Post::OPT_PAGE_LAYOUT, $layout->getId());
                }
            }
        );

        // Switch off autosave
        add_action(
            'admin_enqueue_scripts',
            function () {
                $post = get_post();
                wp_register_script('custom-admin', DM_PLUGIN_URL . '/js/custom-admin.js', array('jquery'));
                wp_enqueue_script('custom-admin');
                if ($post && get_post_meta($post->ID, '_qards_page_layout', true)) {
                    wp_dequeue_script('autosave');
                }
            }
        );

        // Img unautop
        add_filter(
            'the_content',
            function ($pee) {
                global $post;
                $pee = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<div class="figure">$1</div>', $pee);
                if (get_post_meta($post->ID, '_qards_page_mode', true) == 'embed') {
                    $pee = Shortcode::inline(array('id' => $post->ID));
                }
                return $pee;
            },
            30
        );


        // Filters wp_title to print a neat <title> tag based on what is being viewed.
        add_filter(
            'wp_title',
            function ( $title, $sep, $seplocation ) {
                if ( is_feed() ) {
                    return $title;
                }
                global $page, $paged;
                $post = new \TimberPost();
                $dmPostTypes = array(DM_POST_TYPE);
//                 if (defined('SF_PLUGIN_VERSION')) {
//                     $dmPostTypes[] = SF_POST_TYPE;
//                 }
                $currentPostType = $post->get_post_type();
                if(!$currentPostType || !$currentPostType->slug){
                    return $title;
                }
                if ( !\in_array($post->get_post_type()->name, $dmPostTypes)) {
                    return $title;
                }
                $title = $post->title();
                // Add the blog name
                if ( 'right' == $seplocation ) { // sep on right, so reverse the order
                    $title = $title . ' ' . $sep . ' ' . get_bloginfo( 'name', 'display' );
                } else {
                    $title = get_bloginfo( 'name', 'display' ) . ' ' . $sep . ' ' . $title;
                }

                // Add the blog description for the home/front page.
                $site_description = get_bloginfo( 'description', 'display' );
                if ( $site_description && ( is_home() || is_front_page() ) ) {
                    $title .= " $sep $site_description";
                }

                // Add a page number if necessary:
                if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
                    $title .= " $sep " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
                }

                return $title;
            },
            10,
            3
        );

        // Remove admin bar from qards
        add_action(
            'wp',
            function() {
                if ($post = get_post()) {
                    $isEmbed = (get_post_meta($post->ID, '_qards_page_mode', true) == 'embed');
                    if ($post && get_post_meta($post->ID, '_qards_page_layout', true) && (!$isEmbed || $isEmbed && Context::getInstance()->get('edit_mode'))) {
                        add_filter('show_admin_bar', '__return_false');
                        add_action(
                            'get_header',
                            function () {
                                remove_action('wp_head', '_admin_bar_bump_cb');
                            }
                        );
                        show_admin_bar(false);
                    }
                }
            }
        );

        // Show excerpt box
        add_filter(
            'hidden_meta_boxes',
            function ($hidden, $screen) {
                global $post;
                if ($post && get_post_meta($post->ID, '_qards_page_layout', true)) {
                    //             if ( in_array($screen->base,array('post', 'page'))) {
                    if(($key = array_search('postexcerpt', $hidden)) !== false) {
                        unset($hidden[$key]);
                    }
                }
                return $hidden;
            },
            10,
            2
        );

        // Show excerpt instead of content
        add_filter(
            'the_content',
            function($content) {
                global $post;
                //             $isEmbed = (get_post_meta($post->ID, '_qards_page_mode', true) == 'embed');
                if ((!is_page() && !is_single()) && get_post_meta($post->ID, '_qards_page_layout', true)) {
                    return $post->post_excerpt;
                }
                return $content;
            },
            9999
        );

        self::assignTpl();
    }

    /**
     * Assign template to CPT
     *
     * @return void
     */
    static public function assignTpl()
    {
        add_filter(
            'template_include',
            function ($template)
            {
                global $post;
                if (is_page() || is_single()) {
                    if ($post) {
                        $isEmbed = (get_post_meta($post->ID, '_qards_page_mode', true) == 'embed');
                        if (!post_password_required() && get_post_meta($post->ID, '_qards_page_layout', true) && (!$isEmbed || $isEmbed && Context::getInstance()->get('edit_mode'))) {
                            return DM_BASE_PATH . '/page.php';
                        }
                    }
                }
                return $template;
            }
        );
    }

    /**
     * Get post option
     *
     * @param int $postId
     * @param string $opt
     * @param bool $single
     * @return mixed
     */
    static public function getOpt($postId, $opt, $single = true)
    {
        return get_post_meta($postId, $opt, $single);
    }

    /**
     * Set page option
     *
     * @param int $postId
     * @param string $opt
     * @param mixed $val
     * @param bool $unique
     * @return mixed
     */
    static public function setOpt($postId, $opt, $val, $unique = true)
    {
        return add_post_meta($postId, $opt, $val, $unique)
        ||
        update_post_meta($postId, $opt, $val);

    }

    /**
     * Delete post option
     *
     * @param int $postId
     * @param string $opt
     */
    static public function deleteOpt($postId, $opt)
    {
        return delete_post_meta($postId, $opt);
    }
}