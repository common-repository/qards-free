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

use Designmodo\Qards\Page\Layout\Component\Component;
use Designmodo\Qards\Page\Layout\Layout;
use Designmodo\Qards\Http\Http;
use Designmodo\Qards\CodeTidy\CodeTidy;
use Designmodo\Qards\Page\Layout\Component\Template\Template;
use Sabberworm\CSS\Parser;
use Sabberworm\CSS\Rule\Rule;
use Sabberworm\CSS\Property\Selector;
use Sabberworm\CSS\RuleSet\DeclarationBlock;
use Sabberworm\CSS\OutputFormat;

/**
 * Api implements API handler.
 */
class Api
{

    /**
     * API handler
     *
     * @param bool $quietMode TRUE - return result; FALSE - print result and exit.
     * @return array
     */
    static public function handler($quietMode = false)
    {
        ob_start();
        try {
            // Get method
            $method = $_REQUEST['method'];
            // Check permission
            $publicMethods = array('layout.css.get', 'component.css.get', 'settings.globalcss.get', 'font.get', 'subscriber.add');
            if (!in_array($method, $publicMethods) && !current_user_can('edit_posts')) {
                throw new \Exception('You must be authorized and have permission "edit_posts" to call "' . $method . '"', 768423);
            }
            // Get params
            if (! empty($_REQUEST['params'])) {
                if (! is_array($_REQUEST['params'])) {
                    $params = json_decode(stripslashes($_REQUEST['params']), true);
                } else {
                    $params = $_REQUEST['params'];
                }
            } elseif ($input = file_get_contents('php://input')) {
                $payload = json_decode($input, true);
                $params = $payload['params'];
            }
            $params = (!empty($params) && is_array($params)) ? $params : array();
            if (!empty($params)) {
                $stripslashesDeepFunction = function($value) use ( &$stripslashesDeepFunction ) {
                    $value = is_array($value) ? array_map($stripslashesDeepFunction, $value) : stripslashes($value);
                    return $value;
                };
                $params = $stripslashesDeepFunction($params);
            }

            // Call action
            $actionName = self::underscoredToLowerCamelcase(str_replace('.', '_', $method)) . 'Action';
            try {
                $reflector = new \ReflectionMethod(__CLASS__, $actionName);
            } catch (\Exception $e) {
                throw new \Exception('API method "' . $method . '" does not exist.', 645912);
            }

            $args = array();
            foreach ($reflector->getParameters() as $param) {
                $name = $param->getName();
                $isArgumentGiven = array_key_exists(self::camelcasedToUnderscored($name), $params);
                if (! $isArgumentGiven && ! $param->isDefaultValueAvailable()) {
                    throw new \Exception('Parameter "' . self::camelcasedToUnderscored($name) . '" is mandatory for API method "' . $method . '", but was not provided.', 371248);
                }
                $args[$param->getPosition()] = $isArgumentGiven ? $params[self::camelcasedToUnderscored($name)] : $param->getDefaultValue();
            }
            $result = array(
                'result' => call_user_func_array(array(__CLASS__, $actionName), $args)
            );
        } catch (\Exception $e) {
            $result = array(
                'error' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                )
            );
            error_log("Exception caught: " . print_r($result,true));
        }

        if ($quietMode) {
            return $result;
        } else {
        	ob_clean();
            // error_log(json_encode($result));
            echo json_encode($result);
            //exit();
	        wp_die();
        }
    }

    /**
     * Convert underscored string to lower-camelcase format
     *
     * @param string $underscored
     * @return string
     */
    static protected function underscoredToLowerCamelcase($underscored)
    {
        return preg_replace_callback('/_(.?)/', function($m) {return strtoupper($m[1]);}, $underscored);
    }

    /**
     * Convert camelcase string to underscored format
     *
     * @param string $camelcased
     * @return string
     */
    static protected function camelcasedToUnderscored($camelcased)
    {
        return strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1_$2", $camelcased));
    }

    /**
     * Reset component model to default
     * component.model.reset
     *
     * @param int $componentId
     * @return bool
     */
    static protected function componentModelResetAction($componentId)
    {
        $component = new Component($componentId);
        Timber::clearCache();
        return (bool)$component->restore();
    }

    /**
     * Get component thumb
     * component.thumb.get
     *
     * @param array $componentIds
     * @return array
     */
    static protected function componentThumbGetAction($componentIds)
    {
        $thumbs = array();
        foreach ($componentIds as $componentId) {
            $component = new Component($componentId);
            $thumbs[$componentId] = $component->getThumb();
        }
        return $thumbs;
    }

    /**
     * Get layout CSS
     * layout.css.get
     *
     * @param int $layoutId
     * @return void
     */
    static protected function layoutCssGetAction($layoutId)
    {
        $layout = new Layout($layoutId);
	    header('Content-Type:' . Http::CONTENT_TYPE_CSS);
	    require_once DM_BASE_PATH . '/vendor/CssMin/CssMin.php';
	    $css = $layout->render(Http::CONTENT_TYPE_CSS);
	    echo \Designmodo\CssMin::minify($css);
	    exit;
    }

    /**
     * Get component CSS
     * component.css.get
     *
     * @param array $componentIds
     * @param string $format
     * @return string
     */
    static protected function componentCssGetAction($componentIds, $format = 'css')
    {
        $result = '';
        $layout = new Layout(null);
        if (!is_array($componentIds) && !$componentIds = json_decode($componentIds, true)) {
            $result = '/* Request error */';
        } else {
            $layout->removeComponents();
            foreach ($componentIds as $componentId) {
                $layout->appendComponent(new Component($componentId));
            }
            $result = $layout->render(Http::CONTENT_TYPE_CSS);
        }
        if (strtolower($format) == 'json') {
            return $result;
        } else {
	        header('Content-Type:' . Http::CONTENT_TYPE_CSS);
	        require_once DM_BASE_PATH . '/vendor/CssMin/CssMin.php';
	        echo \Designmodo\CssMin::minify($result);
            exit;
        }
    }

    /**
     * Set custom component CSS
     * component.customcss.set
     *
     * @param int $componentId
     * @param string $customCss
     * @return bool|int
     */
    static protected function componentCustomcssSetAction($componentId, $customCss)
    {
        require_once DM_BASE_PATH . '/vendor/Oyejorge/Less/Less.php';
        $parser = new \Less_Parser();
        try {
            $parser->parse(
                '#test' .
                ' { ' .
                $customCss .
                ' }'
            );
        } catch (\Exception $e) {
            throw new \Exception('CSS is not valid: ' . $e->getMessage(), 713434);
        }
        $component = new Component($componentId);
        $component->setCustomCss($customCss);
        return $component->save();
    }

    /**
     * Get custom component CSS
     * component.customcss.get
     *
     * @param int $componentId
     * @return string
     */
    static protected function componentCustomcssGetAction($componentId)
    {
        $component = new Component($componentId);
        return $component->getCustomCss();
    }

    /**
     * Save component data model
     * component.model.save
     *
     * @param array $models
     * @return boolean
     */
    static protected function componentModelSaveAction($models)
    {
        $result = true;
        foreach ($models as $componentId => $model) {
            $component = new Component($componentId);
            $component->setModel($model);
            $result = (bool)$component->save() && $result;
        }
        Timber::clearCache();
        return $result;
    }

    /**
     * Get component model
     * component.model.get
     *
     * @param int $componentId
     * @return array
     */
    static protected function componentModelGetAction($componentIds)
    {
        if (!is_array($componentIds)) {
            throw new \Exception('Component.model.get component_ids must be an array.', 827455);
        }
        $result = array();
        foreach ($componentIds as $componentId) {
            $component = new Component($componentId);
            $result[$componentId] = $component->getModel();
        }
        return $result;
    }

    /**
     * Create new component
     * component.create
     *
     * @param string $templateId
     * @param array $model
     * @param array $componentIds CSS of that components will be added
     * @return array
     */
    static protected function componentCreateAction($templateId, $model = array(), $componentIds = array()){
        $component = new Component();
        $component->setTemplate(new Template($templateId));
        $segmants = explode(DM_TEMPLATE_DELIMETER, $templateId);
        if (in_array($segmants[0], array('footer', 'menu')) && Settings::get(Settings::SETTING_LOGO)) {
            $cmodel = $component->getModel();
            if (!empty($cmodel['brand']['src']['base'])) {
                $cmodel['brand']['src']['base'] = Settings::get(Settings::SETTING_LOGO);
                $component->setModel($cmodel);
            }
        }
        if (! empty($model)) {
            $component->setModel($model);
        }

        $componentId = $component->save();
        if ($componentId) {
            $tpl = self::componentTemplateGetAction($componentId);
            $models = self::componentModelGetAction(array($componentId));
            $componentIds[] = $componentId;
            $layoutCss = self::componentCssGetAction($componentIds, 'json');
            return array(
                'component_id' => $componentId,
                'layout_css' => $layoutCss,
                'custom_css' => $tpl['custom_css'],
                'html' => $tpl['html'],
                'template_id' => $tpl['id'],
                'js' => $tpl['js'],
                'model' => $models[$componentId],
                'is_custom' => $tpl['is_custom']
            );
        } else {
            throw new \Exception('Component was not created.', 324973);
        }
    }

    /**``
     * Create a duplicate of component
     * component.duplicate
     *
     * @param int $componentId
     * @param array $model
     * @return array
     */
    static protected function componentDuplicateAction($componentId, $model)
    {
        $component = new Component($componentId);
        $component = $component->duplicate();
        $component->setModel($model);
        $component->save();

        $tpl = self::componentTemplateGetAction($component->getId());
        $layoutCss = self::componentCssGetAction(array($component->getId()), 'json');
        return array(
            'component_id' => $component->getId(),
            'css' => $tpl['css'],
            'layout_css' => $layoutCss,
            'custom_css' => $tpl['custom_css'],
            'html' => $tpl['html'],
            'template_id' => $tpl['id'],
            'js' => $tpl['js'],
            'model' => $component->getModel(),
            'is_custom' => $tpl['is_custom']
        );
    }

    /**
     * Get list of components
     * components.get
     *
     * @param string $templateId Filter by template
     * @return array
     */
    static protected function componentsGetAction($templateId = null)
    {
        $params = array();
        if ($templateId) {
            $filter = ' && `template_id` = %s ';
            $params[] = $templateId;
        }
        $components = Db::getAll(
            'SELECT * FROM `' . Db::getPluginTableName(Db::TABLE_COMPONENT) . '`
            WHERE is_system = 0 && is_hidden = 0 ' . $filter . '
            ORDER BY `id` DESC',
            $params
        );
        return $components;
    }

    /**
     * Save layout
     * layout.save
     *
     * @param int $layoutId
     * @param array $components
     * @param bool $isPreview
     * @return int Layout ID
     */
    static protected function layoutSaveAction($layoutId, $components, $isPreview = false)
    {
        $layout = new Layout($layoutId);
        $layout->removeComponents();
        foreach ($components as $component) {
            $componentId = ! empty($component['id']) ? $component['id'] : null;
            if ($componentId) {
                $thumb = ! empty($component['thumb']) ? $component['thumb'] : null;
                $component = new Component($componentId);
                if ($thumb) {
                    $component->setThumb($thumb);
                    $component->save();
                }
                $layout->appendComponent($component);
            }
        }
        $layoutId = $layout->save($isPreview);

        $postId = Db::getColumn('SELECT post_id FROM  `' . Db::getWpDb()->postmeta . '` WHERE  `meta_key` LIKE  "_qards_page_layout" AND  `meta_value` =  %d', array($layoutId));

        if ($postId) {
            $content = $layout->render(Http::CONTENT_TYPE_HTML, false);
            wp_update_post(array('ID' => $postId, 'post_content' => $content));
        }

        // Clear old unrelated components
        Cleaner::cleanDb();
        Timber::clearCache();
        if ($layoutId) {
            return $layoutId;
        } else {
            throw new \Exception('Layout was not saved.', 764373);
        }
    }

    /**
     * Get list of layout components
     * layout.components.get
     *
     * @param unknown $layoutId
     * @return multitype:NULL
     */
    static protected function layoutComponentsGetAction($layoutId)
    {
        $layout = new Layout($layoutId);
        $result = array();
        foreach ($layout->getComponents() as $component) {
            $result[] = $component->toArray();
        }
        return $result;
    }

    /**
     * Get template of the component
     * component.template.get
     *
     * @param int $componentId
     * @param bool $pureHtml
     * @param array $model
     * @return array
     */
    static protected function componentTemplateGetAction($componentId, $pureHtml = false, $model = null)
    {
        $result = array();
        if ($pureHtml) {
            Context::getInstance()->set('edit_mode', false);
        } else {
            Context::getInstance()->set('edit_mode', true);
        }
        $layout = new Layout(null);
        $component = new Component($componentId);
        $layout->setComponents(array($component));

        if (\is_array($model)) {
            Context::getInstance()->set('edit_mode', false);
            $componentNew = $component->duplicate();
            $componentNew->setModel($model);
            $componentNew->save();
            $layout->setComponents(array($componentNew));
            //$componentNew = new Component();
            //$componentNew->setTemplate($component->getTemplate());
            //$componentNew->setModel($model);
            //$componentNew->setCustomCss($component->getCustomCss());
            //$componentNew->save();
            //$layout->setComponents(array($componentNew));
        }

        $result = array(
            'id' => $component->getTemplate()->getId(),
            'html' => $layout->render(Http::CONTENT_TYPE_HTML, false),
            'css' => $layout->render(Http::CONTENT_TYPE_CSS, false),
            'custom_css' => $component->getCustomCss(),
            'js' =>  $component->getTemplate()->getJs(),
            'is_custom' => $component->getTemplate()->isCustom()
        );
        if ($pureHtml) {
            $codeTydyObj = new CodeTidy();
            $result['html'] = $codeTydyObj->parseHtml($result['html']);
            $result['custom_css'] = $codeTydyObj->parseCss($result['custom_css']);
        }
        return $result;
    }

    /**
     * Get permalink
     * permalink.get
     *
     * @param int $postId
     * @param array $query
     * @return string
     */
    static protected function permalinkGetAction($postId, $query = array())
    {
        return add_query_arg($query, get_permalink($postId));
    }

    /**
     * Get HTML for preview
     * layout.preview.get
     *
     * @param array $components array(array('component_id' => '1', 'template_id' => 'header.header1', 'model' => array()), array('template_id' => 'header.header2'))
     * @param bool $withHeaderFooter Add header and footer parts
     * @return string
     */
    static protected function layoutPreviewGetAction($components)
    {
        Timber::clearCache();
        $layout = new Layout();
        $components = is_array($components) ? $components : array();
        foreach ($components as $componentData) {
            $component = new Component();
            $templateId = empty($componentData['template_id']) ? null : $componentData['template_id'];
            $component->setTemplate(new Template($templateId));
            if (isset($componentData['model']) && is_array($componentData['model'])) {
                $component->setModel($componentData['model']);
            }
            if (isset($componentData['component_id'])) {
                $origComponent = new Component($componentData['component_id']);
                $component->setCustomCss($origComponent->getCustomCss());
            }
            if ($component->save()) {
                $layout->appendComponent($component);
            } else {
                throw new \Exception('Can not create component by template "' . $componentData['template_id'] . '".', 823764);
            }
        }
        $layout->save(true);
        $result = array(
            'layout_id' => $layout->getId(),
            'html' => $layout->render(Http::CONTENT_TYPE_HTML, false),
            'css' => $layout->render(Http::CONTENT_TYPE_CSS, false)
        );
        $result['html'] .= ob_get_contents();
        return $result;
    }

    /**
     * Save component for preview
     * component.preview.set
     *
     * @param array $components array(array('component_id' => int, 'html' => '...', 'custom_css' => '...'))
     * @return int layout id
     */
    static protected function componentPreviewSetAction($components)
    {
        $components = is_array($components) ? $components : array();
        $layout = new Layout();
        foreach ($components as $data) {
            $origComponentId = $data['component_id'];
            $tpl = $data['html'];
            $customCss = $data['custom_css'];
            $origComponent = new Component($origComponentId);

            $component = $origComponent->duplicate();
            $component->setCustomCss($customCss);
            if ($tpl) {
                $template = $component->getTemplate()->duplicate();
                $template->setTpl($tpl);
                $template->save();
                $component->setTemplate($template);
            }

            if ($component->save()) {
                $layout->appendComponent($component);
            } else {
                throw new \Exception('Can not create component.', 734341);
            }
        }
        $layout->save(true);
        return array(
            'layout_id' => $layout->getId()
        );
    }

    /**
     * Get component for preview
     * component.preview.get
     *
     * @param int $layoutId layout id
     * @return void
     */
    static protected function componentPreviewGetAction($layoutId)
    {
        add_action('wp_print_styles',  array('Designmodo\Qards\Utility\StyleScriptFilter', 'filterStyles'));
        add_action('wp_print_scripts', array('Designmodo\Qards\Utility\StyleScriptFilter', 'filterScripts'));
        $layout = new Layout($layoutId);
        Context::getInstance()->set('current_layout_id', $layoutId);
        $fontList = $layout->getFonts();
        Context::getInstance()->set('current_component_ids', $layout->getComponents());
        Context::getInstance()->set('fontList', $fontList);
        echo $layout->render(Http::CONTENT_TYPE_HTML);
        exit;
    }

    /**
     * Set post title
     * post.title.set
     *
     * @param int $postId
     * @param string $title
     * @return bool
     */
    static protected function postTitleSetAction($postId, $title)
    {
        Timber::clearCache();
        //$postId = Db::getColumn('SELECT post_id FROM  `' . Db::getWpDb()->postmeta . '` WHERE  `meta_key` LIKE  "_qards_page_layout" AND  `meta_value` =  %d', array($layoutId));
        return (bool)wp_update_post(array('ID' => $postId, 'post_title' => $title));
        //return (bool)Db::update(
        //    Db::getWpDb()->posts,
        //    array('post_title' => $title),
        //    array('ID' => $postId)
        //);
    }

    /**
     * Get global CSS
     * settings.globalcss.get
     *
     * @return void
     */
    static protected function settingsGlobalcssGetAction()
    {
        header('Content-Type:' . Http::CONTENT_TYPE_CSS);
	    require_once DM_BASE_PATH . '/vendor/CssMin/CssMin.php';
        $css = Settings::get(Settings::SETTING_GLOBAL_CSS);
	    echo \Designmodo\CssMin::minify($css);
        exit;
    }

    /**
     * Add\Update template
     * template.save
     *
     * @param string $templateId optional
     * @param string $html
     * @param string $css
     * @return bool
     */
    static protected function templateSaveAction($templateId, $html, $css)
    {
        $template = new Template($templateId);
        //$template->setCss($css);
        $template->setTpl($html);
        return $template->save();
    }

    /**
     * Get Fonts list
     * font.get
     *
     * @return string
     */
    static protected function fontGetAction()
    {
        $file = @file_get_contents(DM_TPL_JS_CONFIG_PATH.DM_DS.'fonts.json');
        if (!$file) {
            throw new \Exception('No proper json file in' . DM_TPL_JS_CONFIG_PATH.DM_DS.'fonts.json', 723747);
        }
        header('Content-Type:' . Http::CONTENT_TYPE_JSON);
        $response = [];
        if ($fonts = json_decode($file, true)) {
            $response = apply_filters('qards_fonts_list_nested_names',$fonts);
        }

        if(!empty($response['family']))
            $response['family']['otherFonts'] =  apply_filters('qards_fonts_list_otherFonts_family',$response['family']['otherFonts']);

        echo json_encode($response);
        exit;
    }

    /**
     * Duplicate post
     * page.duplicate
     *
     * @param int $postId
     * @param string $status
     * @throws \Exception
     * @return int
     */
    static protected function pageDuplicateAction($postId, $status = 'draft')
    {
        if (!current_user_can('edit_posts')) {
            wp_die(__('This user have no permisson to "edit_posts".'));
            exit;
        }
        $postId = Duplicate::duplicatePost((int)$postId, $status, get_current_user_id());
        if (!$postId) {
            throw new \Exception(__('This post could not be duplicated.'), 327412);
        }
        return $postId;
    }

    /**
     * Convert post to/from qards
     * page.convert
     *
     * @param int $postId
     * @param int $qardsMode 0 - not qards, 1 - qards, 3 - embed
     * @return bool
     */
    static protected function pageConvertAction($postId, $qardsMode)
    {
        $post = get_post($postId);
        if (!$post) {
            throw new \Exception('Page not found.', 923134);
        }
        // Get currnt layout
        $layoutId = Post::getOpt($post->ID, Post::OPT_PAGE_LAYOUT);
        if ($post->post_status == 'auto-draft') {
            wp_update_post(array('ID' => $post->ID, 'post_status' => 'draft'));
        }

        $convertToQards = function ($post) {
            // Get currnt layout
            $layoutId = Post::getOpt($post->ID, Post::OPT_PAGE_LAYOUT);
            // Attache layout
            $layoutId = Post::getOpt($post->ID, Post::OPT_OLD_PAGE_LAYOUT);
            if (!$layoutId) {
                $layout = new Layout();
                $layoutId = $layout->save();
            }

            Post::setOpt($post->ID, Post::OPT_PAGE_LAYOUT, $layoutId);

            // Save original content
            Post::setOpt($post->ID, Post::OPT_ORIG_PAGE_CONTENT, $post->post_content);
            Post::deleteOpt($post->ID, Post::OPT_OLD_PAGE_LAYOUT);
            $layout = new Layout($layoutId);
            $content = $layout->render(Http::CONTENT_TYPE_HTML, false);
            wp_update_post(array('ID' => $post->ID, 'post_content' => $content));
        };
        $convertToPost = function ($post) {
            // Get currnt layout
            $layoutId = Post::getOpt($post->ID, Post::OPT_PAGE_LAYOUT);
            // Back original content
            wp_update_post(
                array(
                    'ID' => $post->ID,
                    'post_content' => Post::getOpt($post->ID, Post::OPT_ORIG_PAGE_CONTENT)
                )
            );
            // Deattache layout
            Post::setOpt($post->ID, Post::OPT_OLD_PAGE_LAYOUT, $layoutId);
            Post::deleteOpt($post->ID, Post::OPT_PAGE_LAYOUT);
            Post::deleteOpt($post->ID, Post::OPT_QARDS_MODE);
            Post::deleteOpt($post->ID, Post::OPT_ORIG_PAGE_CONTENT);
        };
        $convertToEmbed = function ($post) {
            // Get currnt layout
            $layoutId = Post::getOpt($post->ID, Post::OPT_PAGE_LAYOUT);
            // Attache layout
            $layoutId = Post::getOpt($post->ID, Post::OPT_OLD_PAGE_LAYOUT);
            if (!$layoutId) {
                $layout = new Layout();
                $layoutId = $layout->save();
            }
            Post::setOpt($post->ID, Post::OPT_PAGE_LAYOUT, $layoutId);
            // Save original content
            Post::setOpt($post->ID, Post::OPT_ORIG_PAGE_CONTENT, $post->post_content);

            // Flag as embed
            Post::setOpt($post->ID, Post::OPT_QARDS_MODE, 'embed');
            // Set content
            //             wp_update_post(
            //                 array(
            //                     'ID' => $post->ID,
            //                     'post_content' => '[qards_inline id="' . $post->ID . '"]'
            //                 )
            //             );

            Post::deleteOpt($post->ID, Post::OPT_OLD_PAGE_LAYOUT);
            $layout = new Layout($layoutId);
            $content = $layout->render(Http::CONTENT_TYPE_HTML, false);
            wp_update_post(array('ID' => $post->ID, 'post_content' => $content));
        };

        switch ((int)$qardsMode) {
            case 0: // Convert to post
                if ($layoutId) {
                    $convertToPost($post);
                }
                break;
            case 1: // Convert to qards
                if ($layoutId) {
                    $convertToPost($post);
                }
                $convertToQards($post);
                break;
            case 3: // Convert to embed
                if ($layoutId) {
                    $convertToPost($post);
                }
                $convertToEmbed($post);
                break;
            default:
                throw new \Exception('Unknown mode given.', 834132);
                break;
        }
        return true;
    }

    /**
     * Remove attached image
     * attachement.delete
     *
     * @param string $attachementUrl
     * @return bool
     */
    static protected function attachementDeleteAction($attachementUrl)
    {
        // Normalize URL
        $address = explode('/', $attachementUrl);
        $keys = array_keys($address, '..');
        foreach($keys AS $keypos => $key) {
            array_splice($address, $key - ($keypos * 2 + 1), 2);
        }
        $address = implode('/', $address);
        $attachementUrl = str_replace('./', '', $address);

        // Get attach id by url
        $image = Db::getRow('SELECT * FROM `' . Db::getWpDb()->posts  . '` WHERE post_type="attachment" AND guid = %s', array($attachementUrl));
        if (empty($image['ID'])) {
            throw new \Exception('This attachment can not be deleted.', 247614);
        }
        $attachmentid = $image['ID'];

        // Delete by WP
        if (wp_delete_attachment( $attachmentid, true) === false) {
            throw new \Exception('Can\'t delete record from filesystem, please, check file permissions of your upload folder: '.wp_upload_dir() . '.', 234824);
        }
        return true;
    }

    /**
     * Registrantion of new subscriber
     * subscriber.add
     *
     * @param string $email
     * @param string $fname
     * @param string $lname
     * @param string $junk
     * @return bool
     */
    static protected function subscriberAddAction($email,$fname=null,$lname=null,$junk=null){
        try{
            self::addMailchimpMember($email,$fname,$lname,$junk);
        }catch (\Exception $e){}
        return Subscription::addSubscriber($email);

    }
    static protected function addMailchimpMember($email,$fname=null,$lname=null,$junk=null)
    {
        //error_log("--------------------------------------------------------------------------------");
        //error_log($email . " " . $fname . " " . $lname . " >" . $junk . "< ");
//        if(!$fname && !$lname && !$junk) return Subscription::addSubscriber($email);
        $apikey =get_option('_QARDS_SETTING_MAILCHIMP_API_KEY', 'default');
//        if ($apikey==='default') return Subscription::addSubscriber($email);
        if ($apikey==='default' || !$apikey) return false;
        $sub_url=get_option('_QARDS_SETTING_MAILCHIMP_LIST_URL', 'default');
        //error_log($sub_url);
        if($sub_url==='default') throw new \Exception(__('Mailchimp list must be specified.'), 394447);
        $sub_url=str_replace("subscribe", "subscribe/post-json", $sub_url);
        //error_log($sub_url);
        $sub_url .= "&EMAIL=" . $email;
        $sub_url .= "&FNAME=" . $fname;
        $sub_url .= "&LNAME=" . $lname;
        $sub_url .= "&b_1917b7e769315ab2386044c6e_dd40e15b65=" . $junk;
        $sub_url .= "&subscribe=Subscribe";
        $response = wp_remote_get($sub_url);
        //error_log($sub_url);
        //error_log($response[body]);
        if (is_wp_error($response)) {
            error_log(print_r($response,true));
            throw new \Exception("Invalid Mailchimp server response", 1);
            return false;
        }
        try {
            $data = (object) json_decode($response['body']);
        } catch (\Exception $e) {
            error_log(print_r($response,true));
            throw new \Exception("Invalid Mailchimp server response", 1);
            return false;
        }
        //error_log($data->result);
        if($data->result==="success") return true;
        else return false;
    }

    /**
     * Registration of new subscriber
     * subscribers.export
     *
     * @return void
     */
    static protected function subscribersExportAction()
    {
        Subscription::export();
        exit;
    }

    /**
     * Get settings values
     * settings.get
     *
     * @param array $settings
     * @return array
     */
    static protected function settingsGetAction($settings)
    {
        // $DEBUG = true;
        // if($DEBUG) {
        //     function e($number, $msg, $file, $line, $vars) {
        //        print_r(debug_backtrace());
        //        die();
        //     }
        //     set_error_handler('e');
        // }
        // $log = function($obj){error_log(print_r($obj,true));};
        // if($DEBUG) $log($settings);
        if (!is_array($settings)) {
            throw new \Exception('Error in settings.get method: settings must be an array.', 912847);
        }
        $result = array();
        foreach ($settings as $setting) {
            $result[$setting] = Settings::get($setting);
        }
        return $result;
    }

    /**
     * Set settings values
     * settings.set
     *
     * @param string $settings
     * @param string $val
     * @return bool
     */
    static protected function settingsSetAction($settings)
    {
        if (!is_array($settings)) {
            throw new \Exception('Error in settings.set method: settings must be an array.', 112847);
        }
        foreach ($settings as $setting => $val) {
            Settings::set($setting, $val);
        }
        return true;
    }

    /**
     * Reset settings values
     * settings.reset
     *
     * @return bool
     */
    static protected function settingsResetAction()
    {
        Settings::reset();
        $jsonString = file_get_contents(DM_TPL_JS_CONFIG_PATH.DM_DS.'fonts.json.default');
        $data = json_decode($jsonString);
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(DM_TPL_JS_CONFIG_PATH.DM_DS.'fonts.json', $newJsonString);
        return true;
    }

    /**
     * Reset fonts
     * font.reset
     *
     * @return bool
     */
    static protected function fontResetAction()
    {
        $jsonString = file_get_contents(DM_TPL_JS_CONFIG_PATH.DM_DS.'fonts.json.default');
        $data = json_decode($jsonString);
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(DM_TPL_JS_CONFIG_PATH.DM_DS.'fonts.json', $newJsonString);
        return true;
    }

    /**
     * Get Mailchimp mailing lists
     * mailchimp.lists.get
     *
     * @return array
     */
    static protected function mailchimpListsGetAction()
    {
        $apikey = get_option('_QARDS_SETTING_MAILCHIMP_API_KEY', 'default');
        error_log($apikey);
        if ($apikey=='default') {
            // No API key :(
            //throw new \Exception('You are have no the upload_files permission.', 1);
            return array('error' => 'Please enter the Mailchimp API key' );
        }
        $serverPrefix = substr($apikey, strpos($apikey, '-')+1);
        $apiVersion = "3.0";
        $serverURL = "http://" . $serverPrefix . ".api.mailchimp.com/" . $apiVersion . "/lists";
        $args = array(
            'headers' => array(
                'Authorization' => 'apikey ' . $apikey
            )
        );
        $response = wp_remote_get($serverURL, $args);
        //error_log($serverURL . "?apikey=" . $apikey);
        //$myText = print_r($response,true);
        //error_log($myText);
        if(is_wp_error($response))
        {
            if($response->get_error_code()==="http_request_failed")
            {
                error_log("Mailchimp HTTP request failed");
                error_log(print_r($response,true));
                return array('error' => 'Network error. Please check server logs');
            }
            else
                return array('error' => $response->get_error_message() );
        }
        return $response;
    }

    /**
     * Get Google fonts
     * google.fonts.get
     *
     * @return array
     */
    static protected function googleFontsGetAction()
    {
        $apikey = trim(get_option('_QARDS_SETTING_GA_API_KEY', 'default'));
        if ($apikey=='default' || empty($apikey)) {
            // No API key :(
            //throw new \Exception('You are have no the upload_files permission.', 1);
//            return array('error' => 'Please enter the Google API key' );
            return ['body'=>file_get_contents(DM_TPL_JS_CONFIG_PATH.DM_DS.'avaliable.google.fonts.json')];
        }
        $serverURL = "https://www.googleapis.com/webfonts/v1/webfonts";

        $response = wp_remote_get($serverURL . "?key=" . $apikey);
        //error_log($serverURL . "?apikey=" . $apikey);
        return $response;
    }

    /**
     * Add Google font
     * google.fonts.add
     *
     * @param array $font
     * @return bool
     */
    static protected function googleFontsAddAction($font)
    {
        if (!is_array($font)) {
            throw new \Exception('Error in google.fonts.add method: font must be an array.', 112847);
        }
        //error_log($font['name'] . ':' . $font['type']);
        //error_log(DM_TPL_JS_CONFIG_PATH.DM_DS.'fonts.json');
        $jsonString = file_get_contents(DM_TPL_JS_CONFIG_PATH.DM_DS.'fonts.json');
        //error_log("JSON: " . $jsonString);
        $data = json_decode($jsonString);
        // echo "<pre>";var_dump($jsonString);
        // echo "<script>console.log(".var_dump($data).")<script>";
        // $str = print_r($data->family->googleFonts,true);
        $font_name = strpos($font['name'],' ')!==false ? '"'.$font['name'].'"' : $font['name'];
        $data->family->googleFonts->{$font['name']} = $font_name. ', ' . $font['type'];
        // error_log($str);
        //"Courier New": "'Courier New', Courier, monospace"
        // $data["family"]['activity_name'] = "TENNIS";
        // // or if you want to change all entries with activity_code "1"
        // foreach ($data as $key => $entry) {
        //     if ($entry['activity_code'] == '1') {
        //         $data[$key]['activity_name'] = "TENNIS";
        //     }
        // }
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(DM_TPL_JS_CONFIG_PATH.DM_DS.'fonts.json', $newJsonString);
        return true;
    }

    /**
     * Delete Google font
     * google.fonts.delete
     *
     * @param string $font
     * @return bool
     */
    static protected function googleFontsDeleteAction($font)
    {
        if (!is_array($font)) {
            throw new \Exception('Error in google.fonts.delete method: font must be an array.', 112847);
        }
        //error_log($font['name'] . ':' . $font['type']);
        //error_log(DM_TPL_JS_CONFIG_PATH.DM_DS.'fonts.json');
        $jsonString = file_get_contents(DM_TPL_JS_CONFIG_PATH.DM_DS.'fonts.json');
        //error_log("JSON: " . $jsonString);
        $data = json_decode($jsonString);
        // echo "<pre>";var_dump($jsonString);
        // echo "<script>console.log(".var_dump($data).")<script>";
        // $str = print_r($data->family->googleFonts,true);
        unset($data->family->googleFonts->$font['name']);// = '\'' . $font['name'] . '\', ' . $font['type'];
        // error_log($str);
        //"Courier New": "'Courier New', Courier, monospace"
        // $data["family"]['activity_name'] = "TENNIS";
        // // or if you want to change all entries with activity_code "1"
        // foreach ($data as $key => $entry) {
        //     if ($entry['activity_code'] == '1') {
        //         $data[$key]['activity_name'] = "TENNIS";
        //     }
        // }
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(DM_TPL_JS_CONFIG_PATH.DM_DS.'fonts.json', $newJsonString);
        return true;
    }

    /**
     * Edit twig template default fonts
     * twig.defaults.edit
     *
     * @param array $changes
     * @return bool
     */
    static protected function twigDefaultsEditAction($changes)
    {
        $DEBUG = false;
        if($DEBUG) {
            function e($number, $msg, $file, $line, $vars) {
               error_log(print_r(debug_backtrace(),true));
               throw new \Exception('Some backend error happened, please check server logs', 112847);
            }
            set_error_handler('e');
        }
        $log = function($obj){error_log(print_r($obj,true));};
        if($DEBUG) $log($changes);
        if (!is_array($changes)) {
            throw new \Exception('Error in twig.defaults.edit method: changes must be an array.', 112847);
        }
        //DM_BASE_PATH
        //data_manipulation = function(&$data){...}
        $editJSON = function($path, $data_manipulator)
        {
            $jsonString = file_get_contents($path);
            $data = json_decode($jsonString);
            $data_manipulator($data);
            $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
            //error_log($newJsonString);
            file_put_contents($path, $newJsonString)===FALSE;
            /*if(file_put_contents($path, $newJsonString)===FALSE)
                throw new \Exception('Error while editing templates', 112847);*/
        };
        $styling = function(&$el, $type) use ($log, $changes, $DEBUG, $styling)
        {
            if($DEBUG) $log($el->classes);
            if($changes[$type]!=='')
                $el->style->{'font-family'} = $changes[$type];
            if($changes[$type . 'CL']!=='' && $type !=="cover")
                $el->style->{'color'} = $changes[$type . 'CL'];
            if($changes[$type . 'BL']!=='') {
                if($changes[$type . 'BL']==="normal")
                    unset($el->style->{'font-weight'});
                else
                    $el->style->{'font-weight'} = $changes[$type . 'BL'];
            }
            if($changes[$type . 'IT']!=='') {
                $el->style->{'font-style'} = $changes[$type . 'IT'];
            }
            $index=0;
            if($type==="hero")$index++;
            if($changes[$type . 'FS']!=='')
                $el->classes[$index] = $changes[$type . 'FS'];
            if($changes[$type . 'LH']!=='')
                $el->classes[$index+1] = $changes[$type . 'LH'];
        };
        //ATTENTION: Manipulators below need to be changed if templates change
        $cover_mp = function(&$data) use ($log, $changes, $DEBUG, $styling)
        {
            if($DEBUG) $log("Cover is good");
            $styling($data->title->content[0],"headline");
            $styling($data->text->content[0],"hero");
        };
        $text_mp = function(&$data) use ($log, $changes, $DEBUG, $styling)
        {
            if($DEBUG) $log("Text is good");
            if($data->text)
            {
                foreach ($data->text->content as $el) {
                    if($el->tagName==="h1" || $el->tagName==="h2")
                    {
                        $styling($el,"headline");
                    } elseif (in_array("hero", $el->classes)) {
                        $styling($el,"hero");
                    } else {
                        $styling($el,"paragraph");
                    }
                }
            } else {
                foreach ($data->title->content as $el) {
                    if($el->tagName==="h1" || $el->tagName==="h2")
                    {
                        $styling($el,"headline");
                    } elseif (in_array("hero", $el->classes)) {
                        $styling($el,"hero");
                    } else {
                        $styling($el,"paragraph");
                    }
                }
            }
            if($data->link)
            {
                if($changes['linkCL']!=='')
                    $data->link->{'content-style'}->color = $changes['linkCL'];
            }
        };
        $feature_mp = function(&$data) use ($log, $changes, $DEBUG, $styling)
        {
            if($DEBUG) $log("Feature is good");
            $styling($data->title->content[0],"headline");
            $styling($data->hero->content[0],"hero");
        };
        $footer_mp = function(&$data) use ($log, $changes, $DEBUG, $styling)
        {
            if($DEBUG) $log("Footer is good");
            $styling($data->text->content[0],"paragraph");
        };
        $grid_mp = function(&$data) use ($log, $changes, $DEBUG, $styling)
        {
            if($DEBUG) $log("Grid is good");
            $styling($data->title->content[0],"headline");
            $styling($data->hero->content[0],"hero");
            foreach ($data->grid as $el) {
                // $styling($el->sub_title->content[0],"headline");
                $styling($el->text->content[0],"paragraph");
                if($changes['linkCL']!=='')
                    $el->link->{'content-style'}->color = $changes['linkCL'];
            }
        };
        $image_mp = function(&$data) use ($log, $changes, $DEBUG, $styling)
        {
            if($DEBUG) $log("Image is good");
            $styling($data->text->content[0],"paragraph");
        };
        $subscribe_mp = function(&$data) use ($log, $changes, $DEBUG, $styling)
        {
            if($DEBUG) $log("Subscribe is good");
            $styling($data->title->content[0],"headline");
            $styling($data->hero->content[0],"hero");
        };
        $jsonFileName = function($name, $i)
        {
            $prefix = '/templates/ui-kit-';
            $postfix = '/components/';
            return(DM_BASE_PATH . $prefix . $name . $postfix . $name . $i . '/' . $name . $i . '.json');
        };
        $fileData = array(
            //quantity, name, manipulator
            array(11, 'cover', $cover_mp),
            array( 7, 'text', $text_mp),
            array(12, 'feature', $feature_mp),
            array( 6, 'footer', $footer_mp),
            array( 6, 'grid', $grid_mp),
            array( 7, 'image', $image_mp),
            array( 4, 'subscribe', $subscribe_mp)
        );
        foreach ($fileData as $e) {
            for ($i=1; $i < $e[0]+1; $i++)
            $editJSON($jsonFileName($e[1], $i), $e[2]);
        }
        return true;
    }

    /**
     * Get twig template default fonts
     * twig.defaults.get
     *
     * @param string $style
     * @return object
     */
    static protected function twigDefaultsGetAction($style)
    {
        $DEBUG = false;
        $log = function($obj){error_log(print_r($obj,true));};
        if($DEBUG) $log($style);
        if($style==="link") {
            $jsonString = file_get_contents(DM_BASE_PATH . "/templates/ui-kit-grid/components/grid1/grid1.json");
            if($jsonString===FALSE)throw new \Exception('Error while opening templates', 112847);
            $data = json_decode($jsonString);
            return $data->grid[0]->link->{'content-style'}->color;
        }

        $jsonString = file_get_contents(DM_BASE_PATH . "/templates/ui-kit-text/components/text1/text1.json");
        if($jsonString===FALSE)throw new \Exception('Error while opening templates', 112847);
        $data = json_decode($jsonString);

        if ($style === "headline") {
            // $log($data->text->content[0]->style);
            $ret = array('style' => $data->text->content[0]->style,
                         'classes' => $data->text->content[0]->classes );
            return $ret;
        }
        elseif ($style==="hero") {
            $ret = array('style' => $data->text->content[1]->style,
                         'classes' => $data->text->content[1]->classes );
            return $ret;
        } else {
            $ret = array('style' => $data->text->content[2]->style,
                         'classes' => $data->text->content[2]->classes );
            return $ret;
        }
    }

    /**
     * Edit template link color
     * css.link.edit
     *
     * @param string $color
     * @return bool
     */
    static protected function cssLinkEditAction($color)
    {
        $arr = array(
            'cover',
            'text',
            'feature',
            'footer',
            'grid',
            'image',
            'subscribe'
        );
        foreach ($arr as $type) {
            $oCssParser = new Parser(file_get_contents(DM_BASE_PATH . '/templates/ui-kit-' . $type . '/css/' . $type . '.css'));
            if(!$oCssParser) throw new \Exception("Parser not created", 1);
            $oCssDocument = $oCssParser->parse();
            if(!$oCssDocument) throw new \Exception("Document not parsed", 2);
            $log = function($obj){error_log(print_r($obj,true));};
            $db = new DeclarationBlock();
            if(!$db) throw new \Exception("DeclarationBlock not created", 3);
            $cel = new Selector("." . $type . " a");
            if(!$cel) throw new \Exception("Selector not created", 4);
            $db->setSelector($cel);
            $rule = new Rule("color");
            if(!$rule) throw new \Exception("Rule not created", 5);
            $rule->setValue($color);
            $db->addRule($rule);
            $sel = new Selector("." . $type . " a");
            if(!$sel) throw new \Exception("Selector not created", 6);
            $oCssDocument->removeDeclarationBlockBySelector($sel, true);
            $oCssDocument->append($db);
            $ret = $oCssDocument->render();
            if(!$ret) throw new \Exception("Render failed", 7);
            // $log($oCssDocument);
            // $log($ret);
            $noerr = file_put_contents(DM_BASE_PATH . '/templates/ui-kit-' . $type . '/css/' . $type . '.css', $oCssDocument->render(OutputFormat::createPretty()));
            if(!$noerr) throw new \Exception("File put failed", 8);
        }
        return true;
    }

    /**
     * Set background css
     * background.css.set
     *
     * @param array $css
     * @return bool
     */
    static protected function backgroundCssSetAction($css)
    {
        $DEBUG = false;
        if($DEBUG) {
            function e($number, $msg, $file, $line, $vars) {
               print_r(debug_backtrace());
               die();
            }
            set_error_handler('e');
        }
        $log = function($obj){error_log(print_r($obj,true));};
        if($DEBUG) $log($css);
        Settings::set("_QARDS_SETTING_BACKGROUND_CSS",$css);
        return true;
    }

    /**
     * Upload file
     * attachement.upload
     *
     * @param array $sizes
     * @throws \Exception
     * @return array
     */
    static protected function attachementUploadAction($sizes = array())
    {
        if (! empty($_FILES)) {
            $allowedMimeTypes = array(
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/x-png',
                'image/gif',
                'image/svg+xml',
                'video/mp4',
                'video/ogg',
                'video/webm'
            );
            if (!in_array($_FILES['file']['type'], $allowedMimeTypes)) {
                throw new \Exception($_FILES['file']['type'] . ' is not allowed file type.', 813223);
            }
            if(!current_user_can('upload_files')) {
                throw new \Exception('You are have no the upload_files permission.', 876554);
            }
            require_once (ABSPATH . 'wp-admin/includes/admin.php');

            $id = \media_handle_upload('file', 0);
            unset($_FILES);
            if (\is_wp_error($id)) {
                throw new \Exception('There was an error uploading your file. Make sure that file is png/jpeg/gif and not greater than ' . ini_get('upload_max_filesize'), 323335);
            }
            $result = array(
            );
            if (! empty($sizes)) {
                foreach ($sizes as $key => $size) {
                    $maxWidth = ! empty($size['max_width']) ? $size['max_width'] : null;
                    $maxHeight = ! empty($size['max_height']) ? $size['max_height'] : null;
                    $crop = ! empty($size['crop']) ? true : false;
                    if ($maxWidth || $maxHeight) {
                        $image = wp_get_image_editor((get_attached_file($id))); // Return an implementation that extends <tt>WP_Image_Editor</tt>
                        if (! is_wp_error($image)) {
                            //wp_delete_attachment($id, true);
                            $image->resize($maxWidth, $maxHeight, $crop);
                            $imageData = $image->save($image->generate_filename($image->get_suffix() . '-' . rand(10000, 99999)));
                            $wp_upload_dir = wp_upload_dir();
                            $attachment = array(
                                'guid' => $wp_upload_dir['url'] . '/' . basename($imageData['path']),
                                'post_mime_type' => $imageData['mime-type'],
                                'post_title' => preg_replace('/\.[^.]+$/', '', basename($imageData['path'])),
                                'post_content' => '',
                                'post_status' => 'inherit'
                            );
                            $resizedId = wp_insert_attachment($attachment, $imageData['path']);
                            $attachData = wp_generate_attachment_metadata($resizedId, $imageData['path']);
                            wp_update_attachment_metadata($resizedId, $attachData);
                            $result[$key] = str_replace(content_url(), '../..', wp_get_attachment_url($resizedId));
                        }
                    }
                }
            }
            $result['original'] = str_replace(content_url(), '../..', wp_get_attachment_url($id));
        } else {
            throw new \Exception('Upload error.', 97245);
        }
        return $result;
    }

    /**
     * Get items from WP Media Library
     * medialibrary.items
     *
     * @param array $sizes
     * @throws \Exception
     * @return array
     */
    static protected function medialibraryItemsAction()
    {
        $result = array();
        $query_images_args = array(
            'post_type' => 'attachment',
            'post_mime_type' =>'image',
            'post_status' => 'inherit',
            'posts_per_page' => -1,
        );

        $query_images = new \WP_Query( $query_images_args );
        foreach ( $query_images->posts as $image ) {
            //add only original images
            if( !preg_match( "/-[0-9]+x[0-9]+-[0-9]+/", $image->guid) ){
                array_push( $result, $image->guid );
            }
        }
        return json_encode( $result );
    }
}
