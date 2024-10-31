<?php
/*
 * This file is part of the Designmodo WordPress Plugin.
 *
 * (c) Designmodo Inc. <info@designmodo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Designmodo\Qards\Page\Layout;

use Designmodo\Qards\Utility\Db;
use Designmodo\Qards\Page\Layout\Component\Component;
use Designmodo\Qards\Http\Http;
use Designmodo\Qards\Page\Layout\Component\Template\Template;
use Designmodo\Qards\Utility\Context;
use Designmodo\Qards\Utility\Settings;

/**
 * Layout implements sequence of components on a page.
 */
class Layout
{

//     const SYSTEM_LAYOUT_DEFAULT = 1;

//     const SYSTEM_LAYOUT_HOME = 2;

//     const SYSTEM_LAYOUT_PAGE = 3;

//     const SYSTEM_LAYOUT_POST = 4;

//     const SYSTEM_LAYOUT_ARCHIVE = 5;

//     const SYSTEM_LAYOUT_404 = 6;

//     const SYSTEM_LAYOUT_SEARCH = 7;

    const SYSTEM_COMPONENT_HEADER = 1;

    const SYSTEM_COMPONENT_FOOTER = 2;

//     const SYSTEM_COMPONENT_ADMIN_LAYOUT = 3;

    /**
     * Layout ID
     *
     * @var string
     */
    protected $id;

    /**
     * Layout type
     *
     * @var bool
     */
    protected $isSystem;

    /**
     * Components
     *
     * @var array
     */
    protected $components;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct($id = null)
    {
        $this->id = $id;
        if ($this->getId()) {
            $layout = Db::getRow(
                'SELECT * FROM `' . Db::getPluginTableName(Db::TABLE_LAYOUT) . '` WHERE id = %d',
                array($id)
            );
            if (empty($layout)) {
                throw new \Exception('Layout "' . $this->getId() . '" not found.', 485546);
            }
            $this->isSystem = (bool) $layout['is_system'];
            $this->components = array();
            $components = Db::getAll(
                'SELECT * FROM `' .  Db::getPluginTableName(Db::TABLE_LAYOUT_COMPONENT) . '`
                    WHERE `layout_id` = %d ORDER BY `order` ASC',
                array($this->getId())
            );
            foreach ($components as $component) {
                try {
                    $this->components[] = new Component($component['component_id']);
                } catch (\Exception $e) {
                    if ($e->getCode() != 435736) {
                        throw $e;
                    }
                }
            }
        } else {
            $this->isSystem = false;
            $this->components = array();
        }
    }

    /**
     * Get type
     *
     * @return bool
     */
    public function isSystem()
    {
        return $this->isSystem;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get layout components
     *
     * @return array
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * Set layout components
     *
     * @param array $componentIds
     * @return void
     */
    public function setComponents($components)
    {
        $this->components = $components;
//         $this->components = array();
//         foreach ($componentIds as $componentId) {
//             $this->components[] = new Component($componentId);
//         }
    }

    /**
     * Remove all components
     *
     * @return void
     */
    public function removeComponents()
    {
        $this->components = array();
    }

    /**
     * Append component
     *
     * @param Component $component
     * @return void
     */
    public function appendComponent($component)
    {
        $this->components[] = $component;
    }

    /**
     * Save layout
     *
     * @param bool $preview
     * @return int
     */
    public function save($preview = false)
    {
        if (!$this->getId()) {
            $result = Db::insert(Db::getPluginTableName(Db::TABLE_LAYOUT), array('is_system' => $this->isSystem()));
            if ($result === false) {
                throw new \Exception('Can not save layout.', 432214);
            }
            $this->id = $result;
        }

        Db::delete(
            Db::getPluginTableName(Db::TABLE_LAYOUT_COMPONENT),
            array(
                'layout_id' => $this->getId()
            )
        );

        foreach ($this->getComponents() as $index => $component) {
            if (!$preview) {
                Db::update(
                    Db::getPluginTableName(Db::TABLE_COMPONENT),
                    array('is_hidden' => false),
                    array('id' => $component->getId())
                );
            }
            Db::insert(
                Db::getPluginTableName(Db::TABLE_LAYOUT_COMPONENT),
                array(
                    'layout_id' => $this->getId(),
                    'component_id' => $component->getId(),
                    'order' => $index
                )
            );
        }
        return $this->getId();
    }

    /**
     * Delete layout
     *
     * @return bool
     */
    public function delete()
    {
        if (! $this->isSystem() && $this->getId()) {
            // Delete record
            Db::delete(
                Db::getPluginTableName(Db::TABLE_LAYOUT),
                array(
                    'id' => $this->getId()
                )
            );
            Db::delete(
                Db::getPluginTableName(Db::TABLE_LAYOUT_COMPONENT),
                array(
                    'layout_id' => $this->getId()
                )
            );
            return true;
        }
        return false;
    }

    /**
     * Render layout
     *
     * @param int $contentType HTML or CSS
     * @param bool $withHeaderFooter Add header and footer parts
     * @return string
     */
    public function render($contentType, $withHeaderFooter = true)
    {
        $extraVars = array();
        $result = array();
        switch ($contentType) {
            case Http::CONTENT_TYPE_HTML:
                if ($withHeaderFooter) {
                    $extraVars['compScripts'] = \Timber::compile_string(file_get_contents(DM_TPL_PATH. DM_DS . 'compScripts.html.twig'), Context::getInstance()->toArray());
                    $extraVars['compStyles'] = \Timber::compile_string(file_get_contents(DM_TPL_PATH. DM_DS . 'compStyles.html.twig'), Context::getInstance()->toArray());
                    $components = array_merge(
                        array(new Component(self::SYSTEM_COMPONENT_HEADER)),
                        $this->getComponents(),
                        array(new Component(self::SYSTEM_COMPONENT_FOOTER))
                    );
                } else {
                    $components = $this->getComponents();
                }

                foreach ($components as $component) {
                    $tpl = $component->getTemplate()->getTpl();
                    $model = $component->getModel();
                    $templateId = $component->getTemplate()->getId();
                    $segmants = explode(DM_TEMPLATE_DELIMETER, $templateId);
                    if (in_array($segmants[0], array('footer', 'menu')) && Settings::get(Settings::SETTING_LOGO)) {
                        if (!empty($model['brand']['src']['base'])) {
                            $model['brand']['src']['base'] = Settings::get(Settings::SETTING_LOGO);
                        }
                    }
                    try {
                        $result[] = \Timber::compile_string(
                            $tpl,
                            array_merge(
                                $model,
                                Context::getInstance()->toArray(),
                                array('component_id' => $component->getId()),
                                $extraVars
                            )
                        );
                    }catch(\Exception $e){}
                }
                $result = join(PHP_EOL, $result);
                $result = str_replace(array('&#34;'), array('"'), $result);
                $result = do_shortcode($result);
                break;

            case Http::CONTENT_TYPE_CSS:
                if ($withHeaderFooter) {
                    $components = array_merge(
                        array(new Component(self::SYSTEM_COMPONENT_HEADER)),
                        $this->getComponents()
                    );
                } else {
                    $components = $this->getComponents();
                }
                $resourceType = Template::RESOURCE_CSS;

                foreach ($components as $component) {
                    $css = $component->getTemplate()->getCss();
                    // Add custom CSS
                    try {
                        require_once DM_BASE_PATH . '/vendor/Oyejorge/Less/Less.php';
                        $parser = new \Less_Parser();
                        //                     $segments = explode(DM_TEMPLATE_DELIMETER, $component->getTemplate()->getId());
                        $parser->parse(
                            '[component-id="' . $component->getId() . '"] ' .
                            ' { ' .
                            $component->getCustomCss() .
                            ' }'
                        );
                        $result[] = $parser->getCss();
                    } catch (\Exception $e) {
                        // Supress errors
                    }

                    // Add only unique css
                    $css = trim($css);
                    if (!in_array($css, $result)) {
                        $result[] = $css;
                    }
                }
                $result = join(PHP_EOL, $result);
                break;

            default:
                throw new \Exception('Unknown content type tryed to render.', 873132);
                break;
        }

        return $result;
    }


    /**
     * Get used font or all fonts
     *
     * @param bool $all return all fonts
     * @return array
     */
    public function getFonts($all = false)
    {
        $allFontsList = array(
            'webFonts' => array(),
            'googleFonts' => array(),
            'localFonts' => array(),
            'otherFonts' => array()
        );
        $fontList = $allFontsList;
        $fontsFile = @file_get_contents(DM_TPL_JS_CONFIG_PATH.DM_DS.'fonts.json');
        if ($fontsFile = json_decode($fontsFile, true)) {
            $allFontsList['webFonts'] = array_keys($fontsFile['family']['webFonts']);
            $allFontsList['googleFonts'] = array_keys($fontsFile['family']['googleFonts']);
            $allFontsList['localFonts'] = array_keys($fontsFile['family']['localFonts']);
            $allFontsList['otherFonts'] = empty($fontsFile['family']['otherFonts']) ? [] : array_keys($fontsFile['family']['otherFonts']);
        }

        $allFontsList['otherFonts'] = apply_filters('qards_fonts_list_otherFonts',$allFontsList['otherFonts']);
        $allFontsList = apply_filters('qards_fonts_list',$allFontsList);

        if ($all) {
            $fontList = $allFontsList;
        } else {
            if ($this->getId()) {
                // HTML
                $matches = array();
                $html = $this->render(Http::CONTENT_TYPE_HTML, false);
                if (preg_match_all('/font\-family\s*:\s*("|\'){0,2}(?P<font>.[^"\',]*)("|\'|,)/ims', $html, $matches)) {
                    foreach ($matches['font'] as $font) {
                        switch (true) {
                            case in_array($font, $allFontsList['webFonts']):
                                break;
                            case in_array($font, $allFontsList['googleFonts']):
                                $fontList['googleFonts'][] = $font;
                                break;
                            case in_array($font, $allFontsList['localFonts']):
                                $fontList['localFonts'][] = $font;
                                break;
                            case array_key_exists($font, $allFontsList['otherFonts']):
                                $fontList['otherFonts'][] = $allFontsList['otherFonts'][$font];
                                break;
                        }
                    }
                }

                // Model
                /* foreach ($this->getComponents() as $component) {
                    $matches = array();
                        \var_dump(json_encode($component->get));
                    if (preg_match_all('/font\-family("|\'|.)\s*:\s*("|\'){0,2}(?P<font>.[^"\',]*)("|\'|,)/ims', json_encode($component->getModel()), $matches)) {
                        foreach ($matches['font'] as $font) {
                            switch (true) {
                                case in_array($font, $allFontsList['webFonts']):
                                    break;
                                case in_array($font, $allFontsList['googleFonts']):
                                    $fontList['googleFonts'][] = $font;
                                    break;
                                case in_array($font, $allFontsList['localFonts']):
                                    $fontList['localFonts'][] = $font;
                                    break;
                            }
                        }
                    }
                } */
                //CSS font\-family\s*:\s*("|'){0,2}(?P<font>.[^"',]*)("|'|,)
                //JSON font\-family("|'|.)\s*:\s*("|'){0,2}(?P<font>.[^"',]*)("|'|,)
            }
        }
        foreach($fontList as $i => $v) {
            $fontList[$i] = array_unique($v);
        }
        return $fontList;
    }

    /**
     * Duplicate layout with all components
     *
     * @return \Designmodo\Qards\Page\Layout\Layout
     */
    public function duplicate()
    {
        $layout = new self;
        $layout->removeComponents();
        $components = $this->getComponents();
        foreach ($components as $component) {
            $clone = $component->duplicate();
            $clone->save();
            $layout->appendComponent($clone);
        }
        return $layout;
    }
}
