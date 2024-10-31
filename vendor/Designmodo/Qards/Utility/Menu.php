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
 * Menu implements menu handler for WordPress.
 */
class Menu
{


    const MENU_LOCATION_MAIN = 'qards-main-menu';
    const MENU_LOCATION_FOOTER = 'qards-footer-menu';

    /**
     * Init menus
     *
     * @return void
     */
    static public function init()
    {
        // Register locations for menus
        register_nav_menu(self::MENU_LOCATION_MAIN, __('Qards main'));
        register_nav_menu(self::MENU_LOCATION_FOOTER, __('Qards footer'));

        // Create menus if needed
        //self::initMenus();

        // Register custom fields for sp_page editor
        add_action(
            'add_meta_boxes',
            function ($postType, $post) {
                if ($postType == DM_POST_TYPE) {
                    add_meta_box(
                        'dm_meta_visual_editor',
                        'Qards visual editor',
                        function ($post) {
                            echo '<a href="' . add_query_arg( array('dm_edit_mode' => 'true'), get_permalink($post) ) . '" name="visual_editor" class="button button-primary button-large visual_editor save-first">Visual editor</a>';
                        },
                        array('post',DM_POST_TYPE),
                        'normal',
                        'high'
                    );
                }
            },
            10,
            2
        );
        $disableGutenber = function($isCanUse, $post){
            $layoutId = get_post_meta($post->ID, '_qards_page_layout', true);
            if($layoutId) {
                remove_post_type_support('page', 'editor');
                $isCanUse = false;
            }
            return $isCanUse;
        };

        add_filter('use_block_editor_for_post', $disableGutenber, 10,2);
        add_filter('gutenberg_can_edit_post', $disableGutenber, 10,2);

        // Add custom actions to the post grid
        $rowAction = function ($actions) {
            if (isset($actions['edit']) && get_post_meta(get_the_ID(), '_qards_page_layout', true)) {
                $actions['visual_editor'] = '<a href="' . add_query_arg( array('dm_edit_mode' => 'true'), get_permalink() ) . '" class="button button-primary button-large" style="vertical-align: middle;">Visual editor</a>';
            }
            return $actions;
        };
        add_filter(
            'post_row_actions',
            $rowAction
        );
        add_filter(
            'page_row_actions',
            $rowAction
        );

        add_action(
            'add_meta_boxes',
            function ($postType, $post) {
                if (in_array($post->post_type, array('post','page')) || get_post_meta($post->ID, '_qards_page_layout', true)) {
                    $postTypes = array('post', 'page');
                    if(!in_array($post->post_type, $postTypes)) $postTypes[] = $post->post_type;
                    add_meta_box(
                        'dm_meta_q_activate',
                        'Qards Activate',
                        function ($post) {
                            wp_register_style('qards-post-convert', DM_PLUGIN_URL . '/custom/css/qards-activate.css');
                            wp_enqueue_style('qards-post-convert');
                            wp_register_script('qards-post-convert', DM_PLUGIN_URL . '/custom/js/qards-activate.js');
                            wp_enqueue_script('qards-post-convert');
                            $layoutId = get_post_meta($post->ID, '_qards_page_layout', true);
                            $is_wp_below_5_0 = (version_compare(get_bloginfo('version'),'5.0')==-1 || $layoutId);
                            echo '<script type="text/javascript">
                                    jQuery(document).ready(function(){
                                        var $ = jQuery;
                                        var $q_screen = $("input[name=\'dm_meta_q_activate-hide\']");
                                        var is_wp_below_5_0 = '.($is_wp_below_5_0?"true":"false").';
                                        var is_old_editor = $("#postdivrich").length;
                                        if(is_wp_below_5_0 || is_old_editor){
//                                        $("#dm_meta_q_activate").parents("#postbox-container-2").css("display", "none");
                                            $("#dm_meta_q_activate").css({"display":"none",opacity:0,visibility:"hidden"});
    
                                            $q_screen.change(function(){
                                                if(!$(this).is(":checked")){
                                                    $("#qards-activate").css("display", "none");
                                                }else{
                                                    $("#qards-activate").css("display", "block");
                                                }
                                            });
    
                                            if(!$q_screen.is(":checked")){
                                                $("#qards-activate").css("display", "none");
                                            }
                                            $("#qards-activate").addClass("can-move");
                                        }

                                        if('.(int)$layoutId.') {
                                            $("#postdivrich").hide();
                                        }
                                        $("[name=\"convertPageQardsMode\"]").click(function(){
                                            var qards_mode = $(this).attr("data-qards-mode");
                                            $.ajax({
                                                url: ajaxurl,
                                                method: "POST",
                                                data: {action: "dm_api",method: "page.convert",params: {post_id: ' . $post->ID . ',qards_mode: qards_mode}},
                                                dataType: "json",
                                                success: function(response) {
                                                    location = "' . (get_edit_post_link($post->ID, '')) . '";
                                                },
                                                error: function(jqXHR, textStatus, errorThrown) {
                                                    alert("API failed: " + textStatus + ": " + errorThrown);
                                                }
                                            });
                                            return false;
                                        });
                                    });
                                </script>
                                  <div id="qards-activate" ' . ($layoutId ? 'class="activated"' : '') . '>
                                  <div class="block block-nonactivated">
                                    <div class="cell main"><h1 class="title"><span>Activate Qards</span></h1><p>You can Activate Qards by clicking the <strong>Activate</strong> button. Then you’ll be able to edit this page like a Qards Page. Standard wysiwyg editor will be ignored.</p></div>
                                        <div class="cell secondary">
                                            <div class="button-holder">
                                                <div class="q-button large"><a class="q-button-link left-button" href="#" name="convertPageQardsMode" data-qards-mode="1">Activate</a><a class="q-button-link right-button" href="#"></a></div>
                                                    <div class="drop-down">
                                                        <ul class="activate-list">
                                                            <li class="activate-list-item">
                                                                <a class="activate-list-link" href="#" name="convertPageQardsMode" data-qards-mode="1">
                                                                <h2 class="sub-title">Activate as a New Qards Page</h2>
                                                                <p>This method will replace your current page to a Qards Page. In this case, your current WordPress theme will be ignored. All your content will be saved.</p>
                                                                <div class="q-button"><span class="q-button-link">Activate</span></div>
                                                                </a>
                                                            </li>
                                                            <li class="activate-list-item">
                                                            <a class="activate-list-link" href="#" name="convertPageQardsMode" data-qards-mode="3">
                                                        <h2 class="sub-title">Embed Qards Inside This Page</h2>
                                                        <p>Embed the new Qards Page inside this page. You will see the content of the Qards Page inside your WordPress theme and template.</p>
                                                        <div class="q-button"><span class="q-button-link">Activate</span></div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block block-activated">
                                <div class="cell main"><h1 class="title"><span>Qards Active</span></h1><p>You have activated Qards functionality. Now click the <strong>Edit Page</strong> button to start building your new Qards Page. You’ll be able to deactivate Qards at any time.</p></div>
                                <div class="cell secondary">
                                    <div class="button-holder">
                                        <div class="q-button large"><a class="q-button-link save-first" href="' . add_query_arg( array('dm_edit_mode' => 'true'), get_permalink($post) ) . '" name="visual_editor">Edit Page</a></div>
                                        '. ($post->post_type!=DM_POST_TYPE ? '
                                        <div class="deactivate"><a href="#" name="convertPageQardsMode" data-qards-mode="0">Deactivate Qards</a></div>
                                        ':'').'
                                    </div>
                                </div>
                            </div>
                        </div>';
                        },
                        $postTypes,
                        'normal',
                        'high',
                        array(
                            '__block_editor_compatible_meta_box' => true,
//                            '__back_compat_meta_box'             => true,
                        )
                    );
                }
            },
            10,
            2
        );
    }

    /**
     * Create dummy menus
     *
     * @return void
     */
    static public function initMenus()
    {
        $menuItemsMain = array(
            array('menu-item-title' =>  __('Home')),
            array('menu-item-title' =>  __('Company')),
            array('menu-item-title' =>  __('Portfolio')),
            array('menu-item-title' =>  __('Blog')),
            array('menu-item-title' =>  __('Contact'))
        );
        $menus = array(
            array(
                'name' => __('Qards main'),
                'location' => self::MENU_LOCATION_MAIN,
                'items' => $menuItemsMain
            ),
            array(
                'name' => __('Qards footer'),
                'location' => self::MENU_LOCATION_FOOTER,
                'items' => $menuItemsMain
            ),
        );
        $setupMenuItems = function($menuId, $items, $parentItemId = null) use ( &$setupMenuItems ) {
            foreach ($items as $item) {
                $item['menu-item-url'] = isset($item['menu-item-url']) ? $item['menu-item-url'] : '#';
                $item['menu-item-status'] = isset($item['menu-item-status']) ? $item['menu-item-status'] : 'publish';
                if ($parentItemId) {
                    $item['menu-item-parent-id'] = $parentItemId;
                }
                $menuItemId = wp_update_nav_menu_item($menuId, 0, $item);
                if (!empty($item['children'])) {
                    $setupMenuItems($menuId, $item['children'], $menuItemId);
                }
            }
        };

        foreach ($menus as $menu) {
            $locations = get_theme_mod('nav_menu_locations');
            if (!get_term_by('name', $menu['name'], 'nav_menu') && empty($locations[$menu['location']])) {
                $menuId = wp_create_nav_menu($menu['name']);
                $setupMenuItems($menuId, $menu['items']);
                $locations = get_theme_mod('nav_menu_locations');
                $locations[$menu['location']] = $menuId;
                set_theme_mod( 'nav_menu_locations', $locations );
            } else if (empty($locations[$menu['location']])) {
                $menuObj = get_term_by('name', $menu['name'], 'nav_menu');
                $locations = get_theme_mod('nav_menu_locations');
                $locations[$menu['location']] = $menuObj->term_id;
                set_theme_mod( 'nav_menu_locations', $locations );
            }
        }
    }
}
