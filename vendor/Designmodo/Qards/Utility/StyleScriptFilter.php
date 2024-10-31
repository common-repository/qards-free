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
 * StyleScriptFilter filtering scripts and stiles.
 */
class StyleScriptFilter
{
    const OWNER_THEME = 1;
    const OWNER_PLUGIN = 2;
    const OWNER_UNKNOWN = 3;

    /**
     * Filter syles
     *
     * @return void
     */
    static public function filterStyles()
    {
        global $wp_styles;

        self::filter(
            $wp_styles->registered,
            function($handle) {
                wp_dequeue_style($handle);
                wp_deregister_style($handle);
            }
        );
    }

    /**
     * Filter syles
     *
     * @return void
     */
    static public function filterStylesEditMode()
    {
        global $wp_styles;

        foreach( $wp_styles->registered as $style ) {
            if(is_string($style->src)){
                $keep = false;
                foreach($wp_styles->default_dirs as $default_dir){
                    if(strpos($style->src, $default_dir)===0) $keep = true;
                }
                if(!$keep) {
                    wp_dequeue_style( $style->handle );
                    wp_dequeue_style( $style->handle );
                }
            }
        }

    }
    /**
     * Filter scripts
     *
     * @return void
     */
    static public function filterScripts()
    {
        global $wp_scripts;

        self::filter(
            $wp_scripts->registered,
            function($handle) {
                wp_dequeue_script($handle);
                wp_deregister_script($handle);
            }
        );
    }
    
    /**
     * Filter scripts
     *
     * @return void
     */
    static public function filterScriptsEditMode()
    {
        global $wp_scripts;

        foreach( $wp_scripts->registered as $script ) {
            if(is_string($script->src)){
                $keep = false;
                foreach($wp_scripts->default_dirs as $default_dir){
                    if(strpos($script->src, $default_dir)===0) $keep = true;
                }
                if(!$keep) {
                    wp_dequeue_script( $script->handle );
                    wp_deregister_script( $script->handle );
                }
            }
        }
    }

    /**
     * Filter resources and delete if needed
     *
     * @param array $registered
     * @param callable $remover
     * @return void
     */
    static private function filter($registered, $remover)
    {
        foreach ($registered as $dependency) {
            // Check owner type
            $src = (is_string($dependency->src) ? $dependency->src : '');
            $owner = self::getOwnerType($src);
            $handle = $dependency->handle;

            // Get SS rule
            $ssRule = Db::getRow(
                'SELECT * FROM `' . Db::getPluginTableName(Db::TABLE_SS) . '` WHERE `handle` = %s AND `src` = %s',
                array($handle, $src)
            );
            // If it's new
            if (!$ssRule) {
                $ssRule = array(
                    'handle' => $handle,
                    'src' => $src,
                    'is_active' => ($owner == self::OWNER_THEME ? 0 : 1 ) // By default plugins and unknown are active, but theme disabled
                );
                Db::insert(
                    Db::getPluginTableName(Db::TABLE_SS),
                    $ssRule
                );
            }
            // Derigister style
            if (!$ssRule['is_active']) {
                call_user_func_array($remover, array($handle));
            }
        }
    }

    /**
     * Get owner of resource
     *
     * @param string $src
     * @return int
     */
    static public function getOwnerType($src) {
        if (strpos($src, '/themes/')) {
            return self::OWNER_THEME;
        } elseif (strpos($src, '/plugins/')) {
            return self::OWNER_PLUGIN;
        } else {
            return self::OWNER_UNKNOWN;
        }
    }
}