<?php
/*
 * This file is part of the Designmodo WordPress Plugin.
 *
 * (c) Designmodo Inc. <info@designmodo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Designmodo\Qards\Page\Layout\Component\Template;

use Designmodo\Qards\Utility\Db;
/**
 * Template implements the HTML\CSS etc resources providing for components of layout.
 */
class Template
{
    const RESOURCE_TPL = 'tpl';
    const RESOURCE_CSS = 'css';
    const RESOURCE_JSON = 'json';
    const RESOURCE_JS = 'js';

    /**
     * Template ID.
     * @var string
     */
    protected $id;

    /**
     * HTML template
     * @var string
     */
    protected $tpl;

    /**
     * CSS
     * @var string
     */
    protected $css;

    /**
     * Default model
     * @var array
     */
    protected $model;

    /**
     * JS
     * @var string
     */
    protected $js;

    /**
     * Is custom
     * @var bool
     */
    protected $isCustom;

    /**
     * Constructor
     *
     * @param string $id
     * @return void
     */
    public function __construct($id = null)
    {
        if (!empty($id)) {
            $segments = explode(DM_TEMPLATE_DELIMETER, $id);
            $this->isCustom = (count($segments) < 2 ? false : $segments[0] == 'custom');
            $this->setId($id);
            $tpl = $this->getResource(self::RESOURCE_TPL);
            $model = json_decode($this->getResource(self::RESOURCE_JSON), true);
            $model = $model ? $model : array();
            $css = $this->getResource(self::RESOURCE_CSS);
            $js = $this->getResource(self::RESOURCE_JS);
        } else {
            $this->isCustom = true;
            $this->setId('custom.' . rand(1111111111, 9999999999));
            $tpl = '';
            $model = array();
            $css = '';
            $js = '';
        }
        $this->setTpl($tpl);
        $this->setModel($model);
        $this->setCss($css);
        $this->js = $js;
    }

    /**
     * Get path of resources
     *
     * @param string $resourceType
     * @return string
     */
    public function getResourcePath($resourceType)
    {
        if (! preg_match(DM_TEMPLATE_ID_REGEX, $this->getId())) {
            throw new \Exception('Invalid format of the template ID "' . $this->getId() . '".', 23874);
        }
        $segments = explode(DM_TEMPLATE_DELIMETER, $this->getId());

        switch ($resourceType) {
            case self::RESOURCE_TPL:
                $filePath = 'ui-kit-' . $segments[0] . DM_DS . 'components' . DM_DS . $segments[1] . DM_DS . $segments[1] . DM_TPL_EXT;
                break;
            case self::RESOURCE_CSS:
                $fname = $segments[0] . '.css';
//                 $matches = null;
//                 if (preg_match('/^([a-z]+)(\d+)$/i', $segments[1], $matches)) {
//                     $fname = $matches[1] . '-' . $matches[2] . '-style.css';
//                 }
                $filePath = 'ui-kit-' . $segments[0] . DM_DS . 'css' . DM_DS . $fname;
                break;
            case self::RESOURCE_JSON:
                $filePath = 'ui-kit-' . $segments[0] . DM_DS . 'components' . DM_DS . $segments[1] . DM_DS . $segments[1] . '.json';
                break;
            case self::RESOURCE_JS:
                $filePath = 'ui-kit-' . $segments[0] . DM_DS . 'js' . DM_DS . $segments[0] . '.js';
                break;
        }
        return $filePath;
    }

    /**
     * Get resource content.
     *
     * @param string $resourceType
     * @return string
     */
    public function getResource($resourceType)
    {
        // A little workaround
        $data = null;
        if ($resourceType == self::RESOURCE_CSS && $this->isCustom()) {
            $matches = array();
            if (preg_match('/custom\.(\w+)_(\w+)_.*/i', $this->getId(), $matches)) {
                $filePath = 'ui-kit-' . $matches[1] . DM_DS . 'css' . DM_DS . $matches[1] . '.css';
                if (file_exists(DM_TPL_PATH. DM_DS . $filePath)){
                    $data = file_get_contents(DM_TPL_PATH. DM_DS . $filePath);
                }
            }
        }

        if (is_null($data)) {
            if (file_exists(DM_TPL_PATH. DM_DS . $this->getResourcePath($resourceType))){
                $data = file_get_contents(DM_TPL_PATH. DM_DS . $this->getResourcePath($resourceType));
            } else {
                $data = Db::getColumn(
                    'SELECT `data` FROM `' . Db::getPluginTableName(Db::TABLE_RESOURCE) . '` WHERE template_id = %s AND type = %s LIMIT 1',
                    array(
                        $this->getId(),
                        $resourceType
                    )
                );
            }
        }
        return $data;
    }

    /**
     * Get template ID.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set template ID.
     *
     * @param int $id
     * @return void
     */
    protected function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get default data model
     *
     * @return array
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set default data model
     *
     * @param array $model
     * @return void
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Get HTML template
     *
     * @return string
     */
    public function getTpl()
    {
        return $this->tpl;
    }

    /**
     * Set HTML template
     *
     * @param string $tpl
     * @return void
     */
    public function setTpl($tpl)
    {
        $this->tpl = $tpl;
    }

    /**
     * Get CSS
     *
     * @return string
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * Set CSS
     *
     * @param string $css
     * @return void
     */
    public function setCss($css)
    {
        $this->css = $css;
    }

    /**
     * Get JS
     *
     * @return string
     */
    public function getJs()
    {
        return $this->js;
    }

    /**
     * Set JS
     *
     * @param string $js
     * @return void
     */
//     public function setJs($js)
//     {
//         $this->js = $js;
//     }

    /**
     * Is template custom
     *
     * @return bool
     */
    public function isCustom()
    {
        return $this->isCustom;
    }

    /**
     * Template to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getId();
    }

    /**
     * Save custom Template
     *
     * @throws \Exception
     * @return boolean
     */
    public function save()
    {
        if (!$this->isCustom()) {
            throw new \Exception('Template must be "custom".', 324256);
        }
        $types = array(
            self::RESOURCE_TPL => $this->getTpl(),
            self::RESOURCE_JSON => \json_encode($this->getModel()),
//             self::RESOURCE_CSS => $this->getCss()
        );
        foreach ($types as $type => $value) {
            $existId = Db::getColumn(
                'SELECT `id` FROM `' . Db::getPluginTableName(Db::TABLE_RESOURCE) . '` WHERE template_id = %s AND type = %s LIMIT 1',
                array(
                    $this->getId(),
                    $type
                )
            );
            $data = array(
                'template_id' => $this->getId(),
                'type' => $type,
                'data' => $value,
                'is_custom' => 1
            );
            if ($existId) {
                Db::update(
                    Db::getPluginTableName(Db::TABLE_RESOURCE),
                    $data,
                    array('id' => $existId)
                );
            } else {
                Db::insert(Db::getPluginTableName(Db::TABLE_RESOURCE), $data);
            }
        }
        return true;
    }

    /**
     * Clone template
     *
     * @return \Designmodo\Qards\Page\Layout\Component\Template\Template
     */
    public function duplicate()
    {
        if ($this->isCustom) {
            $matches = array();
            if (preg_match('/custom\.(\w+_\w+)_.*/i', $this->getId(), $matches)) {
                $id = 'custom.' . $matches[1] . '_' . rand(1111111111, 9999999999);
            }
        } else {
            $id = 'custom.' . str_replace('.', '_', $this->getId()) . '_' . rand(1111111111, 9999999999);
        }
        $template = new self();
        if ($id) {
            $template->setId($id);
        }
        $template->setTpl($this->getTpl());
        $template->setCss($this->getCss());
        $template->setModel($this->getModel());
//         $template->save();
        return $template;
    }
}