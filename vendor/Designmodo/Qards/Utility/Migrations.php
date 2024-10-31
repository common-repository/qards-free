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
use Designmodo\Qards\Utility\AdminMsg;
use Designmodo\Qards\Page\Layout\Component\Component;
use Designmodo\Qards\Page\Layout\Component\Template\Template;
/**
 * Migrations implements migration feature for WP plugin.
 */
class Migrations
{
    static $msgs = array();

    /**
     * Init Migrations
     *
     * @return void
     */
    static public function init()
    {
        if (Settings::get(Settings::SETTING_QARDS_VERSION) != DM_PLUGIN_VERSION) {
            self::migrate();
            add_option(Settings::SETTING_QARDS_VERSION, DM_PLUGIN_VERSION) || update_option(Settings::SETTING_QARDS_VERSION, DM_PLUGIN_VERSION);
        }
    }

    /**
     * Run SQL scripts
     *
     * @return void
     */
    static public function migrate()
    {
        $sql = array();

        // New install
        if (!Settings::get(Settings::SETTING_QARDS_VERSION)) {

            // Setup settings
            Settings::reset();

            // Setup DB
            if (Db::getColumn('SHOW TABLES LIKE "' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '"') != Db::getPluginTableName(Db::TABLE_COMPONENT)) {
                Db::query('
                    CREATE TABLE IF NOT EXISTS `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '` (
                      `id` int(10) NOT NULL AUTO_INCREMENT,
                      `template_id` varchar(200) NOT NULL,
                      `thumb` LONGTEXT NULL,
                      `model` text NOT NULL,
                      `custom_css` longtext NULL,
                      `is_system` tinyint(1) NOT NULL DEFAULT "0",
                      `is_hidden` tinyint(1) NOT NULL DEFAULT "0",
                      `created_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      `version` varchar(10) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) DEFAULT CHARSET=utf8;
                ');

                //$template = new Template('common.header');
                //$default_template_model = $template->getModel();
                $default_template_model = ["pageTitle" => "SF2 proto"];
                Db::query('
                    INSERT INTO `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '` VALUES
                    (1,"common.header","",' . \json_encode(\json_encode($default_template_model)) . ', "", 1, 1, "2000-01-01 00:00:00", ""),
                    (2,"common.footer","","[]", "", 1, 1, "2000-01-01 00:00:00", "");
                ');
            }

            if (Db::getColumn('SHOW TABLES LIKE "' . Db::getPluginTableName(Db::TABLE_LAYOUT) . '"') != Db::getPluginTableName(Db::TABLE_LAYOUT)) {
                Db::query('
                    CREATE TABLE IF NOT EXISTS `' . Db::getPluginTableName(Db::TABLE_LAYOUT) . '` (
                      `id` int(10) NOT NULL AUTO_INCREMENT,
                      `is_system` tinyint(1) NOT NULL DEFAULT 0,
                      PRIMARY KEY (`id`)
                    ) DEFAULT CHARSET=utf8;
                ');
            }

            if (Db::getColumn('SHOW TABLES LIKE "' . Db::getPluginTableName(Db::TABLE_LAYOUT_COMPONENT) . '"') != Db::getPluginTableName(Db::TABLE_LAYOUT_COMPONENT)) {
                Db::query('
                    CREATE TABLE IF NOT EXISTS `' . Db::getPluginTableName(Db::TABLE_LAYOUT_COMPONENT) . '` (
                      `layout_id` int(10) NOT NULL,
                      `component_id` int(10) NOT NULL,
                      `order` int(10) NOT NULL
                    ) DEFAULT CHARSET=utf8;
                ');
            }

            if (Db::getColumn('SHOW TABLES LIKE "' . Db::getPluginTableName(Db::TABLE_RESOURCE) . '"') != Db::getPluginTableName(Db::TABLE_RESOURCE)) {
                Db::query('
                    CREATE TABLE IF NOT EXISTS `' . Db::getPluginTableName(Db::TABLE_RESOURCE) . '` (
                      `id` int(10) NOT NULL AUTO_INCREMENT,
                      `template_id` varchar(255) NOT NULL,
                      `type` varchar(255) NOT NULL,
                      `data` longtext NOT NULL,
                      `is_custom` tinyint(1) NOT NULL DEFAULT "1",
                      `created_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      PRIMARY KEY (`id`)
                    ) DEFAULT CHARSET=utf8;
                ');
            }

            if (Db::getColumn('SHOW TABLES LIKE "' . Db::getPluginTableName(Db::TABLE_SUBSCRIBER) . '"') != Db::getPluginTableName(Db::TABLE_SUBSCRIBER)) {
                Db::query('
                    CREATE TABLE IF NOT EXISTS `' . Db::getPluginTableName(Db::TABLE_SUBSCRIBER) . '` (
                      `id` int(10) NOT NULL AUTO_INCREMENT,
                      `email` varchar(255) NOT NULL,
                      `created_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                       PRIMARY KEY (`id`)
                    ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
                ');
            }

            if (Db::getColumn('SHOW TABLES LIKE "' . Db::getPluginTableName(Db::TABLE_SS) . '"') != Db::getPluginTableName(Db::TABLE_SS)) {
                Db::query( '
                    CREATE TABLE IF NOT EXISTS `' . Db::getPluginTableName(Db::TABLE_SS) . '` (
                      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                      `handle` varchar(255) NOT NULL,
                      `src` text NOT NULL,
                      `is_active` tinyint(1) unsigned NOT NULL,
                      PRIMARY KEY (`id`)
                    ) DEFAULT CHARSET=utf8;
                ');
            }

        // Migration
        } else if (version_compare(Settings::get(Settings::SETTING_QARDS_VERSION), DM_PLUGIN_VERSION, '<')) {

            // If old version is older than 1.1.0
            if (version_compare(Settings::get(Settings::SETTING_QARDS_VERSION), '1.1.0', '<')) {

                $component = new Component(1);
                $component->setModel($component->getTemplate()->getModel());
                $component->save();

                Db::query('ALTER TABLE  `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '` ADD  `version` VARCHAR( 10 ) NOT NULL');

                // Clear old unrelated components
                Cleaner::cleanDb();

                /*
                 * Backup tables
                 */
                $tables = array(
                    Db::getPluginTableName(Db::TABLE_COMPONENT),
                );
                self::backupTables($tables, Settings::get(Settings::SETTING_QARDS_VERSION) . '_to_' . '1.1.0');

                /*
                 * Migrate
                 */
                $deltas = array(
                    'Delta/1.0.0-1.1.0/Models/cover.php',
                    'Delta/1.0.0-1.1.0/Models/feature.php',
                    'Delta/1.0.0-1.1.0/Models/footer.php',
                    'Delta/1.0.0-1.1.0/Models/grid.php',
                    'Delta/1.0.0-1.1.0/Models/image.php',
                    'Delta/1.0.0-1.1.0/Models/menu.php',
                    'Delta/1.0.0-1.1.0/Models/subscribe.php',
                    'Delta/1.0.0-1.1.0/Models/text.php'
                );
                $report = self::migrateModels($deltas);

                // Migrate img
                $imgIds = array();
                $imgs = Db::getAll('SELECT `id` AS `component_id` FROM `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '` AS `c` WHERE `c`.`template_id` LIKE \'image.image%\' AND `c`.`model` LIKE \'%"layout":"full"%\'');
                if ($imgs) {
                    foreach ($imgs as $img) {
                        $imgIds[] = $img['component_id'];
                    }
                    $coverIds = array();
                    $covers = Db::getAll('SELECT `id` AS `component_id` FROM `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '` AS `c` WHERE `c`.`template_id` LIKE \'cover.cover%\'');
                    if ($covers) {
                        foreach ($covers as $cover) {
                            $coverIds[] = $cover['component_id'];
                        }
                    }
                    $imgs = Db::getAll('
                        SELECT
                            img.component_id AS component_id
                        FROM
                            `wp_qards_layout_component` img
                        INNER JOIN
                            ' . Db::getPluginTableName(Db::TABLE_LAYOUT_COMPONENT) . ' p
                            ON
                                img.layout_id = p.layout_id
                        WHERE
                            img.component_id IN (' . join(', ', $imgIds) . ')
                            &&
                            (
                                p.`order` = ( img.`order` - 1 )
                                &&
                                p.component_id IN (' . join(', ', array_merge($imgIds, $coverIds)) . ')
                            )
                            ||
                            img.`order` = 0'
                    );
                    if ($imgs) {
                        foreach ($imgs as $img) {
                            $component = new Component($img['component_id']);
                            $model = $component->getModel();
                            $model['paddings']['top'] = 0;
                            $component->setModel($model);
                            $component->save();
                        }
                    }
                }

                // Migrate img
                $imgIds = array();
                $imgs = Db::getAll('SELECT `id` AS `component_id` FROM `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '` AS `c` WHERE `c`.`template_id` LIKE \'image.image%\' AND `c`.`model` LIKE \'%"layout":"full"%\' AND (`c`.`model` LIKE \'%"html":""%\' OR `c`.`model` LIKE \'%"html":"<br\\\\\\\/>"%\')');
                if ($imgs) {
                    foreach ($imgs as $img) {
                        $imgIds[] = $img['component_id'];
                    }
                    $imgs = Db::getAll('
                        SELECT
                            img.component_id AS component_id
                        FROM
                            `wp_qards_layout_component` img
                        INNER JOIN
                            ' . Db::getPluginTableName(Db::TABLE_LAYOUT_COMPONENT) . ' n
                            ON
                                img.layout_id = n.layout_id
                        WHERE
                            img.component_id IN (' . join(', ', $imgIds) . ')
                            &&
                            n.`order` = ( img.`order` + 1 )
                            &&
                            n.component_id IN (' . join(', ', $imgIds) . ')'
                    );
                    if ($imgs) {
                        foreach ($imgs as $img) {
                            $component = new Component($img['component_id']);
                            $model = $component->getModel();
                            $model['paddings']['bottom'] = 4;
                            $component->setModel($model);
                            $component->save();
                        }
                    }
                }


                // Migrate img
                $imgIds = array();
                $imgs = Db::getAll('SELECT `id` AS `component_id` FROM `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '` AS `c` WHERE `c`.`template_id` LIKE \'image.image%\' AND `c`.`model` LIKE \'%"layout":"full"%\' AND (`c`.`model` LIKE \'%"html":""%\' OR `c`.`model` LIKE \'%"html":"<br\\\\\\\/>"%\' OR `c`.`template_id` LIKE \'image.image1\')');
                if ($imgs) {
                    foreach ($imgs as $img) {
                        $imgIds[] = $img['component_id'];
                    }

                    $nimgs = Db::getAll('SELECT `id` AS `component_id` FROM `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '` AS `c` WHERE `c`.`template_id` LIKE \'image.image%\' AND `c`.`model` LIKE \'%"layout":"full"%\' AND (`c`.`model` LIKE \'%"html":""%\' OR `c`.`model` LIKE \'%"html":"<br\\\\\\\/>"%\')');
                    if ($nimgs) {
                        foreach ($nimgs as $nimg) {
                            $nimgIds[] = $nimg['component_id'];
                        }
                    }

                    $imgs = Db::getAll('
                        SELECT
                            img.component_id AS component_id
                        FROM
                            `wp_qards_layout_component` img
                        INNER JOIN
                            ' . Db::getPluginTableName(Db::TABLE_LAYOUT_COMPONENT) . ' n
                            ON
                                img.layout_id = n.layout_id
                        WHERE
                            img.component_id IN (' . join(', ', $imgIds) . ')
                            &&
                            n.`order` = ( img.`order` + 1 )
                            &&
                            n.component_id IN (' . join(', ', $nimgIds) . ')'
                    );
                    if ($imgs) {
                        foreach ($imgs as $img) {
                            $component = new Component($img['component_id']);
                            $model = $component->getModel();
                            $model['paddings']['bottom'] = 4;
                            $component->setModel($model);
                            $component->save();
                        }
                    }
                }

                // Migrate footer
                $footerIds = array();
                $footers = Db::getAll('SELECT `id` AS `component_id` FROM `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '` AS `c` WHERE `c`.`template_id` LIKE \'footer.footer%\'');
                if ($footers) {
                    foreach ($footers as $footer) {
                        $footerIds[] = $footer['component_id'];
                    }
                    $footers = Db::getAll('
                        SELECT
                            footer.component_id AS component_id
                        FROM
                            `wp_qards_layout_component` footer
                        INNER JOIN
                            ' . Db::getPluginTableName(Db::TABLE_LAYOUT_COMPONENT) . ' p
                            ON
                                footer.layout_id = p.layout_id
                        WHERE
                            footer.component_id IN (' . join(', ', $footerIds) . ')
                            &&
                            p.`order` = ( footer.`order` - 1 )
                            &&
                            p.component_id IN (' . join(', ', $footerIds) . ')'
                    );
                    if ($footers) {
                        foreach ($footers as $footer) {
                            $component = new Component($footer['component_id']);
                            $model = $component->getModel();
                            $model['paddings']['top'] = 0;
                            $component->setModel($model);
                            $component->save();
                        }
                    }
                }

                // Add report message
                $status = empty($report['fail']);
                AdminMsg::add(
                    sprintf(
                        __(
                            '<b>' . ($status ? 'Success' : 'Warning') . '!</b> Migration from %s to %s. %s'
                        ),
                        Settings::get(Settings::SETTING_QARDS_VERSION),
                        '1.1.0',
                        $report['msg']
                    ),
                    $status
                );

            }
            if (version_compare(Settings::get(Settings::SETTING_QARDS_VERSION), '1.2.0', '<')) {
                /*
                 * Backup tables
                 */
                $tables = array(
                    Db::getPluginTableName(Db::TABLE_COMPONENT),
                );
                self::backupTables($tables, Settings::get(Settings::SETTING_QARDS_VERSION) . '_to_' . '1.2.0');

                /*
                 * Migrate
                 */
                $deltas = array(
                    'Delta/1.1.0-1.2.0/Models/feature.php',
                );
                $report = self::migrateModels($deltas);

                // Add report message
                $status = empty($report['fail']);
                AdminMsg::add(
                    sprintf(
                        __(
                            '<b>' . ($status ? 'Success' : 'Warning') . '!</b> Migration from %s to %s. %s'
                        ),
                        Settings::get(Settings::SETTING_QARDS_VERSION),
                        '1.2.0',
                        $report['msg']
                    ),
                    $status
                );



                // Setup settings
                Settings::reset();
                $options = Settings::get('qards_settings');
                Settings::set(Settings::SETTING_GLOBAL_CSS, $options['DM_GLOBAL_CSS']);
                Settings::set(Settings::SETTING_SHOW_PROMO_BANNER, (int)$options['DM_SHOW_PROMO_BANNER']);
                // Fix the subscribers table
                if (Db::getColumn('SHOW TABLES LIKE "' . Db::getPluginTableName(Db::TABLE_SUBSCRIBER) . '"') != Db::getPluginTableName(Db::TABLE_SUBSCRIBER)) {
                    Db::query('
                        CREATE TABLE IF NOT EXISTS `' . Db::getPluginTableName(Db::TABLE_SUBSCRIBER) . '` (
                          `id` int(10) NOT NULL AUTO_INCREMENT,
                          `email` varchar(255) NOT NULL,
                          `created_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                           PRIMARY KEY (`id`)
                        ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
                    ');
                } else {
                    $columns = Db::getAll('SHOW COLUMNS FROM  `' . Db::getPluginTableName(Db::TABLE_SUBSCRIBER) . '` ');
                    if ($columns) {
                        $idExists = false;
                        $priKeyExists = false;
                        foreach ($columns as $column) {
                            if ($column['Field'] == 'id') {
                                $idExists = true;
                            }
                            if ($column['Key'] == 'PRI') {
                                $priKeyExists = true;
                            }
                        }
                        if (!$idExists) {
                            if ($priKeyExists) {
                                Db::query('ALTER TABLE `' . Db::getPluginTableName(Db::TABLE_SUBSCRIBER) . '` DROP PRIMARY KEY');
                            }
                            Db::query('ALTER TABLE `' . Db::getPluginTableName(Db::TABLE_SUBSCRIBER) . '` ADD `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');
                        }
                    }
                    //             if (Db::query('ALTER TABLE `' . Db::getPluginTableName(Db::TABLE_SUBSCRIBER) . '` ADD `id` INT UNSIGNED NOT NULL FIRST')) {
                    //                 Db::query('ALTER TABLE `' . Db::getPluginTableName(Db::TABLE_SUBSCRIBER) . '` DROP `id`');
                    //                 Db::query('ALTER TABLE `' . Db::getPluginTableName(Db::TABLE_SUBSCRIBER) . '` DROP PRIMARY KEY');
                    //                 Db::query('ALTER TABLE `' . Db::getPluginTableName(Db::TABLE_SUBSCRIBER) . '` ADD `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');
                    //             }
                }
            }
            //TODO!
            // if (version_compare(Settings::get(Settings::SETTING_QARDS_VERSION), '1.3.1', '<')) {
            //     /*
            //      * Backup tables
            //      */
            //     $tables = array(
            //         Db::getPluginTableName(Db::TABLE_COMPONENT),
            //     );
            //     self::backupTables($tables, Settings::get(Settings::SETTING_QARDS_VERSION) . '_to_' . '1.3.1');
            //
            //     /*
            //      * Migrate
            //      */
            //     $deltas = array(
            //         'Delta/1.2.0-1.3.1/Models/cover.php',
            //     );
            //     $report = self::migrateModels($deltas);
            //
            //     // Add report message
            //     $status = empty($report['fail']);
            //     AdminMsg::add(
            //         sprintf(
            //             __(
            //                 '<b>' . ($status ? 'Success' : 'Warning') . '!</b> Migration from %s to %s. %s'
            //             ),
            //             Settings::get(Settings::SETTING_QARDS_VERSION),
            //             '1.2.0',
            //             $report['msg']
            //         ),
            //         $status
            //     );
            // }
            //TODO!
        }
        $setting_qards_version = Settings::get(Settings::SETTING_QARDS_VERSION);
        if (!empty($setting_qards_version) && version_compare($setting_qards_version, '1.4.2', '<')) {
            /*
			 * Backup tables
			 */
            $tables = array(
                Db::getPluginTableName(Db::TABLE_COMPONENT),
            );
            self::backupTables($tables, Settings::get(Settings::SETTING_QARDS_VERSION) . '_to_' . '1.4.2');

            Db::query('ALTER TABLE  `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '` CHANGE  `thumb` `thumb` LONGTEXT NULL ');
            Db::query('ALTER TABLE  `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '` CHANGE  `custom_css` `custom_css` LONGTEXT NULL ');
        }

        if ($sql) {
            require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta(join(PHP_EOL, $sql));
        }
    }

    /**
     * Back up tables
     *
     * @param array $tables
     * @param string $suffix wp_qards_table_bk_SUFFIX_781231273
     * @return void
     */
    static public function backupTables($tables, $suffix = '')
    {
        $time = time();
        $suffix = preg_replace('/[^a-z0-9]/i', '_', $suffix);

        foreach ($tables as $tableName) {
            $tableBk = $tableName . '_bk_' . $suffix . '_';
            if (!Db::getColumn('SHOW TABLES LIKE "' . $tableBk . '%"')) {
                $tableBk .= $time;
                Db::query('CREATE TABLE `' . $tableBk .  '` LIKE `' . $tableName . '`');
                Db::query('INSERT INTO `' . $tableBk .  '` SELECT * FROM `' . $tableName . '`');
            }
        }
    }

    /**
     * Migrate models
     * Will migrate all models and skip broken.
     *
     * @param array $deltas
     * @param bool $dryRun
     * @return array statistic
     */
    static public function migrateModels($deltas, $dryRun = false)
    {
//         if (is_array($deltas)) {
//             foreach ($deltas as $delta) {
//                 if (!file_exists(__DIR__ . '/' . $delta)) {
//                     throw new \Exception('Delta file not found "' . $delta . '".', 987245);
//                 }
//             }
//         }
        $stat = array(
            'msg' => '',
            'success' => array(),
            'fail' => array()
        );
        foreach ($deltas as $delta) {
            $migrations = array();
            require $delta;
            if (!empty($migrations)) {
                foreach ($migrations as $migration) {
                    $componentIds = Db::getAll(
                        'SELECT `id` FROM `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '` WHERE template_id = %s',
                        array($migration['template_id'])
                    );
                    foreach ($componentIds as $componentId) {
                        $componentId = $componentId['id'];
                        $component = new Component($componentId);
                        if (!version_compare($component->getVersion(), DM_PLUGIN_VERSION, '<')) {
                            continue;
                        }
                        $model = $component->getModel();
                        $model = $migration['migrator']($model);
                        if (!is_array($model)) {
                            $stat['fail'][] = $componentId;
                        } else {
                            $stat['success'][] = $componentId;
                        }
                        if (!$dryRun && is_array($model)) {
                            $component->setModel($model);
                            $component->setVersion(DM_PLUGIN_VERSION);
                            $component->save();
                        }
                    }
                }
            }
        }
        // Report
        if (count($stat['fail']) > 0) {
            $stat['msg'] = sprintf(
                __(
                    'Update affected %d components.
                    %d of them were updated successfully and %d could not be updated (Failed component IDs: %s).
                    Please check the display units on pages and recreate broken.'
                ),
                (count($stat['success']) + count($stat['fail'])),
                count($stat['success']),
                count($stat['fail']),
                join(', ', $stat['fail'])
            );
        } else {
            $stat['msg'] = __('The updates were successfully installed.');
        }

        return $stat;
    }
/*
    static public function cmpMigModels()
    {
        $components = Db::getAll('SELECT id, template_id, model FROM `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '`');
        @mkdir('/tmp/json/', 0777, true);
        @mkdir('/tmp/db/', 0777, true);
        foreach ($components as $component) {
            $fileName = $component['template_id'] . '_' . $component['id'];
            $tpl = new Template($component['template_id']);
            $dModel = $tpl->getModel();
            file_put_contents('/tmp/json/' . $fileName, var_export($dModel, true));
            file_put_contents('/tmp/db/' . $fileName, var_export(json_decode($component['model'], true), true));
        }
    }*/
}
