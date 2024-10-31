<?php
/*
 * This file is part of the Designmodo WordPress Plugin.
 *
 * (c) Designmodo Inc. <info@designmodo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Designmodo\Qards\Utility\Context;
use Designmodo\Qards\Page\Layout\Layout;
use Designmodo\Qards\Http\Http;
use Designmodo\Qards\Utility\Timber;
use Designmodo\Qards\Utility\Menu;

$q_post = new TimberPost();

Timber::setupContext();
Menu::initMenus();

Context::getInstance()->set('post', $q_post);

$pageLayout = get_post_meta($q_post->ID, '_qards_page_layout', true);
Context::getInstance()->set('current_layout_id', $pageLayout);
Context::getInstance()->set('current_post_id', $q_post->ID);

$layout = new Layout(Context::getInstance()->get('current_layout_id'));
$fontList = $layout->getFonts();
Context::getInstance()->set('current_component_ids', $layout->getComponents());
Context::getInstance()->set('wp_title', $q_post->title());
if (Context::getInstance()->get('edit_mode')) {
    $fontList = $layout->getFonts(true);
}else {
    $qards_body_class = get_body_class(Context::getInstance()->get('qards_body_class'));
    $qards_body_class[] = 'qards_version_'.str_replace('.','_',DM_PLUGIN_VERSION);
    $qards_body_class[] = 'page_builder_qards';
    Context::getInstance()->set('qards_body_class', join( ' ', $qards_body_class));
}
Context::getInstance()->set('fontList', $fontList);
Context::getInstance()->set('wp_blog_name', get_bloginfo('name'));

$html = $layout->render(Http::CONTENT_TYPE_HTML);

if(Context::getInstance()->get('edit_mode')){
	echo $html;
} else {
	require_once DM_BASE_PATH . 'vendor/Minify/HTML.php';
	echo Minify_HTML::minify($html);
};