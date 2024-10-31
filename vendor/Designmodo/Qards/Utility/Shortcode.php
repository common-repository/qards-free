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
use Designmodo\Qards\Http\Http;
/**
 * Shortcode implements WP schortcodes handler.
 */
class Shortcode
{

    /**
     * Init Shortcode
     *
     * @return void
     */
    public static function init()
    {
        add_action(
            'wp_enqueue_scripts',
            function () {
                wp_enqueue_script( 'iframeResizer', DM_PLUGIN_URL . '/js/iframeResizer.min.js');
                wp_enqueue_script( 'iframeResizer-contentWindow', DM_PLUGIN_URL . '/js/iframeResizer.contentWindow.min.js');
            }
        );
        // [qards_iframe id="123"]
        add_shortcode(
            'qards_iframe',
             array('Designmodo\Qards\Utility\Shortcode', 'iframe')
        );

        // [qards_inline id="123"]
        add_shortcode(
            'qards_inline',
            array('Designmodo\Qards\Utility\Shortcode', 'inline')
        );

        // Iframe view
        if (!empty($_REQUEST['iframe-view']) && $_REQUEST['iframe-view'] == 'true') {
            Context::getInstance()->set('qards_body_class', 'qards-iframe');
        }
    }

    public static function iframe ($atts)
    {
        $currentPage = new \TimberPost();
        $atts = shortcode_atts(array('id' => null), $atts );
        if (!(int)$atts['id']) {
            $result = _('Page not found.');
        } else {
            $post = new \TimberPost((int)$atts['id']);
            $result = '';
            if ($currentPage->ID == $post->ID) {
                $result = _('Recursion detected.');
            } elseif (get_post_meta($post->ID, '_qards_page_layout', true)) {
                    $result = '
                        <iframe
                            id="qards_page_' . $post->ID . '"
                            src="' . add_query_arg(array('iframe-view' => 'true'), get_permalink($post->ID)) . '"
                            width="100%"
                            frameborder="0"
                            marginheight="0"
                            onload="onQardsIframeLoad(this.id)"
                        ></iframe>
                        <script language="JavaScript">
                        <!--
                            function onQardsIframeLoad(elementSelector) {
                                elementSelector = "#" + elementSelector;
                                var iframe = document.querySelector(elementSelector);
                                iframe.contentWindow.postMessage(JSON.stringify({parentWindowWidth:window.innerWidth, parentWindowHeight:window.innerHeight}), "*" );
                                iFrameResize([], elementSelector);
                            }
                        //-->
                        </script>';
            } else {
                $result = _('Page not found.');
            }
        }
        return $result;
    }

    public static function inline ($atts) {
        $currentPage = new \TimberPost();
        $atts = shortcode_atts(array('id' => null), $atts);
        if (!(int)$atts['id']) {
            $result = _('Page not found.');
        } else {
            $post = new \TimberPost($atts['id']);
            $result = '';
            $pageLayout = get_post_meta($post->ID, '_qards_page_layout', true);

            if ($currentPage->ID == $post->ID && get_post_meta($post->ID, '_qards_page_mode', true) != 'embed') {
                $result = _('Recursion detected.');
            } elseif ($pageLayout) {
                $layout = new Layout($pageLayout);
                $fontList = $layout->getFonts();
                $fontLinks = array();
                foreach ($fontList as $type => $fonts) {
                    for ($i = 0; $i < \count($fonts); $i++) {
                        switch ($type) {
                            case 'googleFonts':
                                $fontLinks[] = 'https://fonts.googleapis.com/css?family=' . rawurlencode($fonts[$i]) . ':400,700';
                                if ($fonts[$i] == 'Muli') {
                                    $fontLinks[] = 'https://fonts.googleapis.com/css?family=' . rawurlencode($fonts[$i]) . ':400italic';
                                }
                                break;
                            case 'localFonts':
                                $fontLinks[] = DM_PLUGIN_URL . 'fonts/' . rawurlencode($fonts[$i]) . '/' . rawurlencode($fonts[$i]) . '.css';
                                break;
                        }
                    }
                }

                require_once DM_BASE_PATH . '/vendor/Oyejorge/Less/Less.php';
                $parser = new \Less_Parser();

                $css = $layout->render(Http::CONTENT_TYPE_CSS, true);
                $css = preg_replace('/@media.*screen and /im', '&', $css);
                $css = preg_replace('/\(((max|min)-width): (\d*px)\)( and )?/im', '[$1~="$3"]', $css);

                try {
                    $parser->parse(
                        file_get_contents(DM_BASE_PATH . '/js/reset.css') .
                        '#dm-parent #dm-wrapper #dm-inner' .
                        ' { ' .
                        file_get_contents(DM_BASE_PATH . '/dist/styles/initial.css') .
                        $css .
                        ' }'
                    );
                    $css = $parser->getCss();
                } catch (\Exception $e) {
                    throw new \Exception('CSS is not valid: ' . $e->getMessage(), 765936);
                }

                $result =
                '<script type="text/javascript">
                                (function (fn) {
                                    if (document.readyState != "loading"){
                                        fn();
                                    } else {
                                        document.addEventListener("DOMContentLoaded", fn);
                                    }
                                })(function() {
                                    var head = document.querySelector("head");
                                    var links = ' . \json_encode($fontLinks) . ';
                                    var css = ' . \json_encode($css) . ';
                                    var style = document.createElement("style");
                                    style.type = "text/css";
                                    if (style.styleSheet){
                                      style.styleSheet.cssText = css;
                                    } else {
                                      style.appendChild(document.createTextNode(css));
                                    }
                                    head.appendChild(style);
                                    for (i in links) {
                                        var l = document.createElement("link");
                                        l.rel = "stylesheet";
                                        l.type = "text/css";
                                        l.href = links[i];
                                        head.appendChild(l);
                                    }
                                    var script = document.createElement("script");
                                    script.type = "text/javascript";
                                    script.src = "' . DM_PLUGIN_URL . '/js/elementQuery.js";
                                    head.appendChild(script);
                                });
                            </script>
                            <div id="dm-parent">
                                <div id="dm-wrapper">
                                    <div id="dm-inner">' .
                                        $layout->render(Http::CONTENT_TYPE_HTML, false) . '
                                    </div>
                                </div>
                            </div>';
            } else {
                $result = _('Page not found.');
            }
        }
        return $result;
    }
}