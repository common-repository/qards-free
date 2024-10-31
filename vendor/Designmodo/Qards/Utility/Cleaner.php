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
 * Cleaner implements cleaning functions.
 */
class Cleaner
{
    /**
     * Delete unrelated layouts, components, resources
     *
     * @return void
     */
    static public function cleanDb()
    {
        // Delete unrelated(from posts) layouts
        $result = Db::getAll('SELECT `meta_value` FROM `' . Db::getWpDb()->postmeta . '` WHERE  `meta_key` IN ( \'_qards_page_layout\', \'_old_qards_page_layout\')');
        if ($result) {
            $count = count($result);
            $usedLayouts = array();
            for ($i = 0; $count > $i; $i++) {
                $usedLayouts[] = $result[$i]['meta_value'];
            }

            Db::query(
                'DELETE FROM `' . Db::getPluginTableName(Db::TABLE_LAYOUT) . '`
                WHERE id NOT IN (' . join(',', $usedLayouts) . ')'
            );

            // Delete relation-records
            Db::query(
                'DELETE FROM `' . Db::getPluginTableName(Db::TABLE_LAYOUT_COMPONENT) . '`
                WHERE `layout_id` NOT IN (
                    ' . join(',', $usedLayouts) . '
                )'
            );

        }
        $result = Db::getAll('SELECT component_id FROM `' . Db::getPluginTableName(Db::TABLE_LAYOUT_COMPONENT) . '`');
        if ($result) {
            $count = count($result);
            $usedComponents = array();
            for ($i = 0; $count > $i; $i++) {
                $usedComponents[] = $result[$i]['component_id'];
            }

            // Delete unrelated(tmp) components
            Db::query(
                'DELETE FROM `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '`
                WHERE id NOT IN (
                    ' . join(',', $usedComponents) . '
                ) AND is_system = 0 AND UNIX_TIMESTAMP(created_ts) < ' . (string)(time() - DM_UNRELATED_COMPONENT_MAX_AGE )
            );
        }

        $result = Db::getAll('SELECT  `template_id` FROM  `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '` GROUP BY  `template_id`');
        if ($result) {
            $count = count($result);
            $usedTemplates = array();
            for ($i = 0; $count > $i; $i++) {
                $usedTemplates[] = $result[$i]['template_id'];
            }
            // Delete resources
            Db::query(
                'DELETE FROM `' . Db::getPluginTableName(Db::TABLE_RESOURCE) . '`
                WHERE template_id NOT IN (
                    "' . join('","', $usedTemplates) . '"
                )'
            );
        }
    }
}