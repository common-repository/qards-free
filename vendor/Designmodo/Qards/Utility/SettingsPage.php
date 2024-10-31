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
 * SettingsPage implements WP admin's settings page handler.
 */
class SettingsPage
{
    /**
     * Get used font or all fonts
     *
     * @param bool $all return all fonts
     * @return array
     */
    public static function getFonts($all = false)
    {
        $allFontsList = array(
            'webFonts' => array(),
            'googleFonts' => array(),
            'localFonts' => array()
        );
        $fontList = $allFontsList;
        $fontsFile = @file_get_contents(DM_TPL_JS_CONFIG_PATH.DM_DS.'fonts.json');
        if ($fontsFile = json_decode($fontsFile, true)) {
            $allFontsList['webFonts'] = array_keys($fontsFile['family']['webFonts']);
            $allFontsList['googleFonts'] = array_keys($fontsFile['family']['googleFonts']);
            $allFontsList['localFonts'] = array_keys($fontsFile['family']['localFonts']);
        }

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
     * Init SettingsPage
     *
     * @return void
     */
    public static function init()
    {
        add_action(
            'admin_menu',
            function () {
                add_theme_page(
                    __('Qards settings'),
                    __('Qards Settings'),
                    'edit_theme_options',
                    'qards_settings',
                    array(
                        'Designmodo\Qards\Utility\SettingsPage',
                        'show'
                    )
                );

                add_submenu_page(
                    'edit.php?post_type=' . DM_POST_TYPE,
                    __('Qards settings'),
                    __('Qards Settings'),
                    'edit_theme_options',
                    'qards_settings',
                    array(
                        'Designmodo\Qards\Utility\SettingsPage',
                        'show'
                    )
                );

            }
        );

        add_action(
            'admin_init',
            function() {

            }
        );
    }

    public static function show()
    {
        ?>

            <link rel="stylesheet" href="<?php echo DM_PLUGIN_URL; ?>custom/css/qards-settings.css" />
            <link rel="stylesheet" href="<?php echo DM_PLUGIN_URL; ?>custom/css/sweetalert.css" />

                <?php $fontList = SettingsPage::getFonts(true) ?>

                <?php
                //-----------------------Templates start------------------------------------------------
                $std_buttons = '<div class="tab-row-cell">'.
                                    '<div class="button-holder edit">'.
                                        '<a class="edit-button main-button" href="#">Edit</a>'.
                                    '</div>'.
                                    '<div class="button-holder save">'.
                                        '<a class="save-button main-button" href="#">Save</a>'.
                                        '<a class="cancel-button main-button" href="#">Cancel</a>'.
                                    '</div>'.
                                '</div>';
                $clpick =   '<div class="clpick_wrapper">' .
                                '<div class="clpick_main">' .
                                    '<div class="clpick_pin">' .
                                    '</div>' .
                                '</div>' .
                                '<div class="clpick_hue">' .
                                    '<div class="clpick_button_wrapper">' .
                                        '<div class="clpick_button">' .
                                        '</div>' .
                                    '</div>' .
                                '</div>' .
                            '</div>' .
                            '<div class="clpick_dataholder">' .
                                '<input type="text" class="clpick_data" />' .
                            '</div>';
                //-----------------------Templates start------------------------------------------------
                                        ?>

                <?php foreach($fontList as $type => $arr) { ?>
                    <?php if ($type == 'googleFonts' && sizeof($arr)>0) { ?>
                        <!-- <?php //var_dump($arr); ?> -->
                        <link href='https://fonts.googleapis.com/css?family=<?php
                        foreach($arr as $font) {
                            echo urlencode($font)
                                . ':400,700|'
                                . (($font == 'Muli') ? (urlencode($font) . ':400italic|') : '') ;
                            }
                        ?>' rel='stylesheet' type='text/css' />
                    <?php } else if ($type == 'localFonts') { ?>
                        <?php foreach ($arr as $font) { ?>
                            <link href='<?php echo DM_PLUGIN_URL; ?>fonts/<?php echo rawurlencode($font) ?>/<?php echo rawurlencode($font) ?>.css' rel='stylesheet' type='text/css' />
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                <?php if (Settings::get(Settings::SETTING_TYPEKIT_ID)) { ?>
                <script src="//use.typekit.net/<?php echo Settings::get(Settings::SETTING_TYPEKIT_ID); ?>.js"></script>
                <script>try{Typekit.load();}catch(e){}</script>
                <?php } ?>


            <style type="text/css">
                .clpick_main:before {
                    background: rgba(0, 0, 0, 0) url(<?php echo DM_PLUGIN_URL; ?>/img/minicolor.png) no-repeat scroll 0% 0% / 100% 100% padding-box border-box;
                }
                .clpick_hue:after {
                    background: rgba(0, 0, 0, 0) url(<?php echo DM_PLUGIN_URL; ?>/img/minicolor-bar.png) no-repeat scroll 0% 0% / 100% 100% padding-box border-box;
                }
            </style>
            <div id="qards-settings" class="invisible">
                <div class="free-notify">
                    You're using the free version of Qards. If you want to unlock all features, buy the full version of <a href="https://designmodo.com/qards/" target="_blank">Qards here</a>.
                </div>
                <div class="main-content">
                    <div id="iOS_nav">
                        <div id="nav_items">
                            <a id="link_gen" class="active" href="#general">General</a><!--
                         --><a id="link_app" href="#appearance">Appearance</a><!--
                         --><!--<a id="link_acc" href="#">Account</a>-->
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="general" class="tab">
                            <h1 class="options_h1">General settings</h1>
                            <div class="rows">
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Site Title</p>
                                            <textarea class="editable-text text-field" id="siteTitle" name="<?php echo Settings::SETTING_SITE_TITLE; ?>" placeholder="Type your title here"><?php echo esc_textarea(Settings::get(Settings::SETTING_SITE_TITLE)); ?></textarea>
                                        </div>
                                        <?php echo $std_buttons; ?>
                                    </div>
                                </div>
                                <!-- <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Domain</p>
                                            <textarea class="editable-text text-field" id="domain" name="<?php echo Settings::SETTING_DOMAIN; ?>" placeholder="Type your domain here"><?php echo esc_textarea(Settings::get(Settings::SETTING_DOMAIN)); ?></textarea>
                                        </div>
                                        <?php echo $std_buttons; ?>
                                    </div>
                                </div> -->
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading"><strong>Google API key</strong>. <a href="https://developers.google.com/fonts/docs/developer_api#acquiring_and_using_an_api_key" target="_blank">Learn how</a> to get your Google API key.</p>
                                            <textarea class="editable-text text-field" id="googleKey" name="<?php echo Settings::SETTING_GA_API_KEY; ?>" placeholder="Type your key here"><?php echo esc_textarea(Settings::get(Settings::SETTING_GA_API_KEY)); ?></textarea>
                                        </div>
                                        <div class="tab-row-cell">
                                            <div class="button-holder edit">
                                                <a class="edit-button main-button" href="#">Edit</a>
                                            </div>
                                            <div class="button-holder save">
                                                <a id="gAPIsave" class="save-button main-button" href="#">Save</a>
                                                <a class="cancel-button main-button" href="#">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading"><strong>Google Analytics tracking ID</strong>. <a href="https://support.google.com/analytics/answer/1032385?hl=en" target="_blank">Learn how</a> to find your tracking code.</p>
                                            <textarea class="editable-text text-field" id="googleGATrack" name="<?php echo Settings::SETTING_GA_TRACK; ?>" placeholder="Type your tracking ID here"><?php echo esc_textarea(Settings::get(Settings::SETTING_GA_TRACK)); ?></textarea>
                                        </div>
                                        <div class="tab-row-cell">
                                            <div class="button-holder edit">
                                                <a class="edit-button main-button" href="#">Edit</a>
                                            </div>
                                            <div class="button-holder save">
                                                <a id="googleGATracksave" class="save-button main-button" href="#">Save</a>
                                                <a class="cancel-button main-button" href="#">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row disabled" title="This functionality is locked, please buy the full version to unlock it.">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading"><strong>MailChimp API key</strong>. <a href="http://kb.mailchimp.com/integrations/api-integrations/about-api-keys" target="_blank">Learn how</a> to find your API key.</p>
                                            <textarea class="editable-text text-field" disabled="disabled" id="mailchimpKey" name="<?php echo Settings::SETTING_MAILCHIMP_API_KEY; ?>" placeholder="Type your key here"><?php echo esc_textarea(Settings::get(Settings::SETTING_MAILCHIMP_API_KEY)); ?></textarea>
                                        </div>
                                        <?php /*echo $std_buttons;*/ ?>
                                    </div>
                                </div>
                                <div class="tab-row mc-hide" style="border-top: 0;padding: 0 0 30px 0;">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading"><strong>Mailing list</strong>. Select or <a href="http://kb.mailchimp.com/lists/growth/create-a-new-list" target="_blank">create</a> a mailing list.</p>
                                            <div style="text-align: left; z-index: 5;margin-top:13px" class="button-holder">
                                                <select id="mcsel" disabled style="width: 250px;border: 1px solid #cfcfcf;font-size:23px;height: 35px;" class="text-field">
                                                    <option>Please load lists</option>
                                                </select>
                                                <!-- <a id="maillistsbtn" style="margin-left: 20px" class="main-button">Load lists</a> -->
                                            </div>
                                            <textarea style="display:none" class="editable-text text-field" id="mailchimpListUrl" name="<?php echo Settings::SETTING_MAILCHIMP_LIST_URL; ?>" placeholder="Type your key here"><?php echo esc_textarea(Settings::get(Settings::SETTING_MAILCHIMP_LIST_URL)); ?></textarea>
                                        </div>
                                        <?php echo $std_buttons; ?>
                                    </div>
                                </div>
                                <div class="tab-row no-image">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading"><strong>Upload logo</strong>. Use <i>.png</i>, <i>.jpg</i> or <i>.gif</i>.
                                                <br>Maximum file size of 30KB</p>
                                            <span class="upload-image main-button">Browse<input id="logo" data-file-size="30000" class="fileupload" type="file" accept="image/gif, image/jpeg, image/pjpeg, image/png" name="<?php echo Settings::SETTING_LOGO; ?>" /></span>
                                            <a class="remove-image main-button" href="#">Remove</a>
                                        </div>
                                        <div class="tab-row-cell">
                                            <div class="logo-preview">
                                                <img class="preview-img" data-preview-src="<?php echo Settings::get(Settings::SETTING_LOGO);?>" src="<?php
                                                    if(strlen(Settings::get(Settings::SETTING_LOGO))>0)
                                                        echo DM_PLUGIN_URL . Settings::get(Settings::SETTING_LOGO);
                                                ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Check this box if you want to help us <strong>promote Qards</strong> on your pages.</p>
                                        </div>
                                        <div class="tab-row-cell">
                                            <label class="custom-checkbox">
                                                <input id="promoteQards" class="checkbox" type="checkbox" name="<?php echo Settings::SETTING_SHOW_PROMO_BANNER; ?>" <?php if (Settings::get(Settings::SETTING_SHOW_PROMO_BANNER)) { echo ' checked="checked" '; } ?> />
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading"><strong>Set global CSS</strong> if you care about it. This code will be used on each page, so be careful with it.</p>
                                        </div>
                                        <?php echo $std_buttons; ?>
                                    </div>
                                    <div class="code-editor">
                                        <textarea class="code-editor-textarea text-field" data-code-mode="css" id="editingCSS" name="<?php echo Settings::SETTING_GLOBAL_CSS;?>"><?php echo esc_textarea(Settings::get(Settings::SETTING_GLOBAL_CSS)); ?></textarea>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading"><strong>Add Code to Head</strong>. This code will be added to the <i>&lt;head&gt;</i> section of every page.</p>
                                        </div>
                                        <div class="tab-row-cell">
                                            <div class="tab-row-cell">
                                                <div class="button-holder edit">
                                                    <a class="edit-button main-button" href="#">Edit</a>
                                                </div>
                                                <div class="button-holder save">
                                                    <a class="save-button main-button" href="#">Save</a>
                                                    <a class="cancel-button main-button" href="#">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="code-editor">
                                        <textarea class="code-editor-textarea text-field" data-code-mode="text/html" id="editingHead" name="<?php echo Settings::SETTING_WP_HEAD;?>"><?php echo esc_textarea(Settings::get(Settings::SETTING_WP_HEAD));?></textarea>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading"><strong>Set Header</strong>. This code will be added on every page after the <i>&lt;body&gt;</i> tag.</p>
                                        </div>
                                        <?php echo $std_buttons; ?>
                                    </div>
                                    <div class="code-editor">
                                        <textarea class="code-editor-textarea text-field" data-code-mode="text/html" id="editingHeader" name="<?php echo Settings::SETTING_WP_HEADER;?>"><?php echo esc_textarea(Settings::get(Settings::SETTING_WP_HEADER));?></textarea>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading"><strong>Set Footer</strong>. This code will be added before the end of the page.</p>
                                        </div>
                                        <?php echo $std_buttons; ?>
                                    </div>
                                    <div class="code-editor">
                                        <textarea class="code-editor-textarea text-field" data-code-mode="text/html" id="editingFooter" name="<?php echo Settings::SETTING_WP_FOOTER;?>"><?php echo esc_textarea(Settings::get(Settings::SETTING_WP_FOOTER));?></textarea>
                                    </div>
                                </div>
                                <div class="tab-row disabled" title="This functionality is locked, please buy the full version to unlock it.">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">If you use the Subscribe component you can <strong>export your subscribers</strong> in a .csv format.</p>
                                        </div>
                                        <div class="tab-row-cell">
                                            <div class="button-holder">
                                                <a class="main-button" id="exportSubscribers" href="#">Export</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">If you think you have made a mistake with the settings, be sure to reset it.</p>
                                        </div>
                                        <div class="tab-row-cell">
                                            <div class="button-holder">
                                                <a class="main-button reset-button" id="resetSettings" href="#">Reset Settings</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="appearance" class="tab">
                            <h1 class="options_h1">Appearance settings</h1>
                            <div class="rows">
                                <div class="tab-row disabled" title="This functionality is locked, please buy the full version to unlock it.">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading headlineArrowTxt">Headline default font</p>
                                            <h1 style="opacity:1;transition: all 0.25s ease-in-out;" class="headlinePreview noLH headlineArrowTxt">Headline One</h1>
                                        </div>
                                        <div class="tab-row-cell">
                                            <span class="headlineArrow arrow1 arrow_right"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row disabled" title="This functionality is locked, please buy the full version to unlock it.">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading heroArrowTxt">Hero text default font</p>
                                            <p style="opacity:1;transition: all 0.25s ease-in-out;" class="heroPreview noLH heroArrowTxt">Hero Text</p></span>
                                        </div>
                                        <div class="tab-row-cell">
                                            <span class="heroArrow arrow1 arrow_right"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row disabled" title="This functionality is locked, please buy the full version to unlock it.">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading paragraphArrowTxt">Paragraph default font</p>
                                            <p style="opacity:1;transition: all 0.25s ease-in-out;" class="paragraphPreview noLH paragraphArrowTxt">Paragraph</p></span>
                                        </div>
                                        <div class="tab-row-cell">
                                            <span class="paragraphArrow arrow1 arrow_right"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading"><strong>TypeKit ID</strong>. Adding fonts to your site is fast and easy. <a href="http://help.typekit.com/customer/portal/articles/6850-using-typekit-with-other-blogging-platforms" target="_blank">Learn how</a> to get your TypeKit ID.</p>
                                            <div class="typekitId-row">
                                                <textarea class="editable-text text-field" id="typeKitID" placeholder="TypeKit ID" name="<?php echo Settings::SETTING_TYPEKIT_ID; ?>"><?php echo esc_textarea(Settings::get(Settings::SETTING_TYPEKIT_ID)); ?></textarea>
                                                <p class="remove-typekitId">
                                                    <a href="#">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12px" height="12px" fill="rgba(103,103,103,.7)" viewBox="0 0 17 16" enable-background="new 0 0 17 16"><path d="M14.3 4.5h-11.6c-.4 0-.7.3-.7.8l.7 10c0 .4.4.8.9.8h10c.4 0 .8-.3.9-.8l.7-10c-.2-.5-.5-.8-.9-.8zm-7.3 8.4c0 .5-.4.9-.9.9s-.9-.4-.9-.9v-5.5c0-.5.4-.9.9-.9s.9.4.9.9v5.5zm4.7 0c0 .5-.4.8-.8.8-.5 0-.8-.4-.8-.8v-5.6c0-.5.4-.8.8-.8.5 0 .8.4.8.8v5.6zm4.3-11.9h-4c0-.6-.4-1-1-1h-5c-.6 0-1 .4-1 1h-4c-.6 0-1 .4-1 1s.4 1 1 1h15c.6 0 1-.4 1-1s-.4-1-1-1z"></path></svg>
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                        <?php echo $std_buttons; ?>
                                    </div>
                                </div>
                                <div class="tab-row disabled" title="This functionality is locked, please buy the full version to unlock it.">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading backgroundArrowTxt">Background</p>
                                        </div>
                                        <div class="tab-row-cell">
                                            <span class="backgroundArrow arrow1 arrow_right"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row disabled" title="This functionality is locked, please buy the full version to unlock it.">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading clpick_label">Active link color</p>
                                            <div class="clpicker" id="linkCL"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <p class="row-heading"><strong>Google Fonts.</strong> Manage your fonts: </p>
                                    </div>
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <div class="gFonts-row">
                                                <textarea class="editable-text text-field" id="gFonts" placeholder="Start typing to add a font"></textarea>
                                            </div>
                                        </div>
                                        <!-- <div class="tab-row-cell wide" style="padding-right:50%">
                                            <a id="gFontsAdd" class="main-button" href="#">Add</a>
                                        </div> -->
                                    </div>
                                    <div class="tab-line">
                                        <?php
                                            $svg = '<!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path id="x-mark-4-icon" d="M462,256c0,113.771-92.229,206-206,206S50,369.771,50,256S142.229,50,256,50S462,142.229,462,256zM422,256c0-91.755-74.258-166-166-166c-91.755,0-166,74.259-166,166c0,91.755,74.258,166,166,166C347.755,422,422,347.741,422,256zM325.329,362.49l-67.327-67.324l-67.329,67.332l-36.164-36.186l67.314-67.322l-67.321-67.317l36.185-36.164l67.31,67.301l67.3-67.309l36.193,36.17l-67.312,67.315l67.32,67.31L325.329,362.49z"></path></svg>';
                                        add_filter( 'https_ssl_verify', '__return_false' );
                                        $jsstr=wp_remote_get(DM_PLUGIN_URL . "js/config/fonts.json");
                                            if($jsstr){
                                                $parsed = (object) json_decode($jsstr['body']);
                                                if($parsed){
                                                    // var_dump($jsstr);
                                                    // error_log("JSSTR: ".print_r($jsstr,true));
                                                    // $parsed=(object)$jsstr;
                                                    // error_log("PARSED:".print_r($parsed,true));
                                                    // error_log("ARR:".print_r(($parsed->family->googleFonts),true));
                                                    echo "<ul style=\"margin-top:10px\" id=\"gFontsList\">";
                                                    foreach ((array)($parsed->family->googleFonts) as $key => $value) {
                                                        echo '
                                                        <li style="font-family:\''. $key .'\'">' . '<div class="rmvIcon">'. $svg .'</div>' . $key . '</li>
                                                        ';
                                                    }
                                                    echo "</ul>";
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">If you think you have made a mistake with the styles, be sure to reset it.</p>
                                        </div>
                                        <div class="tab-row-cell">
                                            <div class="button-holder">
                                                <a class="main-button" id="resetStyles" href="#">Reset Styles</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="account" class="tab">
                            <h1 class="options_h1">Account settings</h1>
                        </div>
                        <div id="headline_sub" class="tab">
                            <span class="returnArrow arrow1 arrow_left"></span><h1 class="options_h1 returnArrowTxt">Default Headline Font</h1>
                            <div class="rows">
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Preview text</p>
                                            <h1 style="opacity:1;transition: all 0.25s ease-in-out;" class="headlinePreview">Alice's Adventures in Wonderland</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Font family</p>
                                            <textarea class="editable-text text-field" id="headlineFF" placeholder="Start typing to search"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Font size</p>
                                            <div class="uislider" min="1" max="9" ui-slider id="headlineSlider1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Line height</p>
                                            <div class="uislider" min="1" max="7" ui-slider id="headlineSlider2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading clpick_label">Font color</p>
                                            <div class="clpicker" id="headlineCL"></div>
                                            <div class="clpick_panel" handle="headline">
                                                <?php echo $clpick; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Bold</p>
                                        </div>
                                        <div class="tab-row-cell">
                                            <label class="custom-checkbox">
                                                <input id="headlineBL" class="checkbox" type="checkbox" />
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Italic</p>
                                        </div>
                                        <div class="tab-row-cell">
                                            <label class="custom-checkbox">
                                                <input id="headlineIT" class="checkbox" type="checkbox" />
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="hero_sub" class="tab">
                            <span class="returnArrow arrow1 arrow_left"></span><h1 class="options_h1 returnArrowTxt">Default Hero Text Font</h1>
                            <div class="rows">
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Preview text</p>
                                            <p style="opacity:1;transition: all 0.25s ease-in-out;" class="heroPreview">Alice's Adventures in Wonderland</p></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Font family</p>
                                            <textarea class="editable-text text-field" id="heroFF" placeholder="Start typing to search"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Font size</p>
                                            <div class="uislider" min="1" max="9" ui-slider id="heroSlider1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Line height</p>
                                            <div class="uislider" min="1" max="7" ui-slider id="heroSlider2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading clpick_label">Font color</p>
                                            <div class="clpicker" id="heroCL"></div>
                                            <div class="clpick_panel" handle="hero">
                                                <?php echo $clpick; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Bold</p>
                                        </div>
                                        <div class="tab-row-cell">
                                            <label class="custom-checkbox">
                                                <input id="heroBL" class="checkbox" type="checkbox" />
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Italic</p>
                                        </div>
                                        <div class="tab-row-cell">
                                            <label class="custom-checkbox">
                                                <input id="heroIT" class="checkbox" type="checkbox" />
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="paragraph_sub" class="tab">
                            <span class="returnArrow arrow1 arrow_left"></span><h1 class="options_h1 returnArrowTxt">Default Paragraph Font</h1>
                            <div class="rows">
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Preview text</p>
                                            <p style="opacity:1;transition: all 0.25s ease-in-out;" class="paragraphPreview">Alice's Adventures in Wonderland</p></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Font family</p>
                                            <textarea class="editable-text text-field" id="paragraphFF" placeholder="Start typing to search"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Font size</p>
                                            <div class="uislider" min="1" max="9" ui-slider id="paragraphSlider1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Line height</p>
                                            <div class="uislider" min="1" max="7" ui-slider id="paragraphSlider2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading clpick_label">Font color</p>
                                            <div class="clpicker" id="paragraphCL"></div>
                                            <div class="clpick_panel" handle="paragraph">
                                                <?php echo $clpick; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Bold</p>
                                        </div>
                                        <div class="tab-row-cell">
                                            <label class="custom-checkbox">
                                                <input id="paragraphBL" class="checkbox" type="checkbox" />
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Italic</p>
                                        </div>
                                        <div class="tab-row-cell">
                                            <label class="custom-checkbox">
                                                <input id="paragraphIT" class="checkbox" type="checkbox" />
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="background_sub" class="tab">
                            <span class="returnArrow arrow1 arrow_left"></span><h1 class="options_h1 returnArrowTxt">Background</h1>
                            <div class="rows">
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading clpick_label">Background color</p>
                                            <div class="clpicker" id="backgroundCL"></div>
                                            <div class="clpick_panel" handle="background">
                                                <div class="clpick_wrapper">
                                                    <div class="clpick_main">
                                                        <div class="clpick_pin">
                                                        </div>
                                                    </div>
                                                    <div class="clpick_hue">
                                                        <div class="clpick_button_wrapper">
                                                            <div class="clpick_button">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clpick_dataholder">
                                                    <input type="text" class="clpick_data" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row no-image">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading"><strong>Background image</strong>. Use <i>.png</i>, <i>.jpg</i> or <i>.gif</i>.
                                                <br>Max image size 3 mb</p>
                                            <span class="upload-image main-button">Browse<input id="bg" data-file-size="3000000" class="fileupload" type="file" accept="image/gif, image/jpeg, image/pjpeg, image/png" name="<?php echo Settings::SETTING_BG_IMG; ?>" /></span>
                                            <a class="remove-image main-button" href="#">Remove</a>
                                        </div>
                                        <div class="tab-row-cell">
                                            <div class="bg-preview">
                                                <img class="preview-img" data-preview-src="<?php echo Settings::get(Settings::SETTING_BG_IMG);?>" src="<?php
                                                        if(strlen(Settings::get(Settings::SETTING_BG_IMG))>0)
                                                            echo DM_PLUGIN_URL . Settings::get(Settings::SETTING_BG_IMG);
                                                    ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <p class="row-heading" style="width:20em">Background position</p>
                                        <div class="tab-row-cell wide">
                                            <div class="pospick">
                                              <div>
                                                <input id="pp_1" type="radio" name="radio" value="top left" checked><label for="pp_1"><span></span></label>
                                              </div>
                                              <div>
                                                <input id="pp_2" type="radio" name="radio" value="top"><label for="pp_2"><span></span></label>
                                              </div>
                                              <div>
                                                <input id="pp_3" type="radio" name="radio" value="top right"><label for="pp_3"><span></span></label>
                                              </div>
                                              <br/>
                                              <div>
                                                <input id="pp_4" type="radio" name="radio" value="left"><label for="pp_4"><span></span></label>
                                              </div>
                                              <div>
                                                <input id="pp_5" type="radio" name="radio" value="center"><label for="pp_5"><span></span></label>
                                              </div>
                                              <div>
                                                <input id="pp_6" type="radio" name="radio" value="right"><label for="pp_6"><span></span></label>
                                              </div>
                                              <br/>
                                              <div>
                                                <input id="pp_7" type="radio" name="radio" value="bottom left"><label for="pp_7"><span></span></label>
                                              </div>
                                              <div>
                                                <input id="pp_8" type="radio" name="radio" value="bottom"><label for="pp_8"><span></span></label>
                                              </div>
                                              <div>
                                                <input id="pp_9" type="radio" name="radio" value="bottom right"><label for="pp_9"><span></span></label>
                                              </div>
                                            </div>
                                            <p style="display:none" id="backgroundValue">top left</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Stretch background</p>
                                        </div>
                                        <div class="tab-row-cell">
                                            <label class="custom-checkbox">
                                                <input id="backgroundST" class="checkbox" type="checkbox" />
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-row">
                                    <div class="tab-line">
                                        <div class="tab-row-cell wide">
                                            <p class="row-heading">Tile background</p>
                                        </div>
                                        <div class="tab-row-cell">
                                            <label class="custom-checkbox">
                                                <input id="backgroundTL" class="checkbox" type="checkbox" />
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var pluginUrlAdmin = "<?php echo DM_PLUGIN_URL; ?>";
                var $ = jQuery;
            </script>
            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/jquery-ui.js"></script>
            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/sweetalert.min.js"></script>
            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/vendor/file-upload/jquery.ui.widget.js"></script>
            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/vendor/file-upload/jquery.iframe-transport.js"></script>
            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/vendor/file-upload/jquery.fileupload.js"></script>

            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/vendor/flex-text/jquery.flexText.min.js"></script>

            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/vendor/codemirror/codemirror.js"></script>
            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/vendor/codemirror/css.js"></script>
            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/vendor/codemirror/xml.js"></script>
            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/vendor/codemirror/search.js"></script>
            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/vendor/codemirror/searchcursor.js"></script>
            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/vendor/codemirror/dialog.js"></script>
            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/vendor/codemirror/beautifier.js"></script>
            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/vendor/codemirror/simplescrollbars.js"></script>

            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/jquery.ajaxQueue.min.js"></script>
            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/tippy.all.min.js"></script>
            <script src="<?php echo DM_PLUGIN_URL; ?>custom/js/qards-settings.js"></script>
        <?php
    }
}
