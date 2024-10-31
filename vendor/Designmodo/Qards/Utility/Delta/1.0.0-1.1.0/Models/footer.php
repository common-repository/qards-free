<?php
// Migrate component models
$migrations = array(
    array(
        'template_id' => 'footer.footer1',
        'migrator' => function ($model) {
            $model = '
            {
                "align": "center",
                "brand": {
                    "src": {
                        "base": "templates/ui-kit-footer/img/designmodo.png"
                    },
                    "url": "",
                    "show": false
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',

                        "style": {
                            "color": ' . json_encode($model['text']['style']['color']) . ',
                            "font-family": ' . json_encode($model['text']['style']['font-family']) . ',
                            "text-align": "center"
                        },
                        "classes": [
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],

                    "placeholder": "Write your message here...",
                    "show": true
                },
                "links": {
                    "style": {
                        "bold": "normal",
                        "italic": "normal",
                        "color": "#424242",
                        "opacity": "0.7",
                        "fontFamily": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "fontSize": "4",
                        "lineHeight": "4"
                    },
                    "show": false
                },
                "block_bg": {
                    "color": "#ffffff",
                    "opacity": "1",
                    "gradient": "",
                    "gradient_type": "default",
                    "angle": "90",
                    "type": "color"
                },
                "paddings": {
                    "top": 12,
                    "bottom": 0
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'footer.footer2',
        'migrator' => function ($model) {
            $model = '
            {
                "align": "center",
                "brand": {
                    "src": {
                        "base": "templates/ui-kit-footer/img/designmodo.png"
                    },
                    "url": "",
                    "show": false
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": "Made by Designmodo. Follow us on <a href=\'#\'>Twitter</a> or <a href=\'#\'>Facebook</a>",

                        "style": {
                            "color": "#979797",
                            "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                            "text-align": "center"
                        },
                        "classes": [
                            "font-size-4",
                            "line-height-4"
                        ]
                    }],

                    "placeholder": "Write your message here...",
                    "show": false
                },
                "links": {
                    "style": {
                        "bold": "normal",
                        "italic": "normal",
                        "color": "#424242",
                        "opacity": "0.7",
                        "fontFamily": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "fontSize": "4",
                        "lineHeight": "4"
                    },
                    "show": true
                },
                "block_bg": {
                    "color": "#ffffff",
                    "opacity": "1",
                    "gradient": "",
                    "gradient_type": "default",
                    "angle": "90",
                    "type": "color"
                },
                "paddings": {
                    "top": 12,
                    "bottom": 0
                }
            }
            ';
            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'footer.footer3',
        'migrator' => function ($model) {
            $model = '
            {
                "align": "center",
                "brand": {
                    "src": {
                        "base": ' . json_encode($model['image']) . '
                    },
                    "url": ' . json_encode($model['url']) . ',
                    "show": true
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": "Made by Designmodo. Follow us on <a href=\'#\'>Twitter</a> or <a href=\'#\'>Facebook</a>",

                        "style": {
                            "color": "#979797",
                            "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                            "text-align": "center"
                        },
                        "classes": [
                            "font-size-4",
                            "line-height-4"
                        ]
                    }],

                    "placeholder": "Write your message here...",
                    "show": false
                },
                "links": {
                    "style": {
                        "bold": "normal",
                        "italic": "normal",
                        "color": "#424242",
                        "opacity": "0.7",
                        "fontFamily": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "fontSize": "4",
                        "lineHeight": "4"
                    },
                    "show": false
                },
                "block_bg": {
                    "color": "#ffffff",
                    "opacity": "1",
                    "gradient": "",
                    "gradient_type": "default",
                    "angle": "90",
                    "type": "color"
                },
                "paddings": {
                    "top": 12,
                    "bottom": 0
                }
            }
            ';
            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'footer.footer4',
        'migrator' => function ($model) {
            $model = '
            {
                "align": "center",
                "brand": {
                    "src": {
                        "base": "templates/ui-kit-footer/img/designmodo.png"
                    },
                    "url": "",
                    "show": false
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',

                        "style": {
                            "color": ' . json_encode($model['text']['style']['color']) . ',
                            "font-family": ' . json_encode($model['text']['style']['font-family']) . ',
                            "text-align": "center"
                        },
                        "classes": [
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Write your message here...",
                    "show": true
                },
                "links": {
                    "style": {
                        "bold": "normal",
                        "italic": "normal",
                        "color": "#424242",
                        "opacity": "0.7",
                        "fontFamily": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "fontSize": "4",
                        "lineHeight": "4"
                    },
                    "show": false
                },
                "block_bg": {
                    "color": ' . json_encode($model['bg_color']) . ',
                    "opacity": ".2",
                    "gradient": "",
                    "gradient_type": "default",
                    "angle": "90",
                    "type": "color"
                },
                "paddings": {
                    "top": 12,
                    "bottom": 0
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'footer.footer5',
        'migrator' => function ($model) {
            $model = '
            {
                "align": "center",
                "brand": {
                    "src": {
                        "base": "templates/ui-kit-footer/img/designmodo.png"
                    },
                    "url": "",
                    "show": false
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": "Made by Designmodo. Follow us on <a href=\'#\'>Twitter</a> or <a href=\'#\'>Facebook</a>",

                        "style": {
                            "color": "#979797",
                            "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                            "text-align": "center"
                        },
                        "classes": [
                            "font-size-4",
                            "line-height-4"
                        ]
                    }],

                    "placeholder": "Write your message here...",
                    "show": false
                },
                "links": {
                    "style": {
                        "bold": "normal",
                        "italic": "normal",
                        "color": "#424242",
                        "opacity": "0.7",
                        "fontFamily": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "fontSize": "4",
                        "lineHeight": "4"
                    },
                    "show": true
                },
                "block_bg": {
                    "color": ' . json_encode($model['bg_color']) . ',
                    "opacity": ".2",
                    "gradient": "",
                    "gradient_type": "default",
                    "angle": "90",
                    "type": "color"
                },
                "paddings": {
                    "top": 12,
                    "bottom": 0
                }
            }
            ';
            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'footer.footer6',
        'migrator' => function ($model) {
            $model = '
            {
                "align": "center",
                "brand": {
                    "src": {
                        "base": ' . json_encode($model['image']) . '
                    },
                    "url": ' . json_encode($model['url']) . ',
                    "show": true
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": "Made by Designmodo. Follow us on <a href=\'#\'>Twitter</a> or <a href=\'#\'>Facebook</a>",

                        "style": {
                            "color": "#979797",
                            "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                            "text-align": "center"
                        },
                        "classes": [
                            "font-size-4",
                            "line-height-4"
                        ]
                    }],

                    "placeholder": "Write your message here...",
                    "show": false
                },
                "links": {
                    "style": {
                        "bold": "normal",
                        "italic": "normal",
                        "color": "#424242",
                        "opacity": "0.7",
                        "fontFamily": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "fontSize": "4",
                        "lineHeight": "4"
                    },
                    "show": false
                },
                "block_bg": {
                    "color": ' . json_encode($model['bg_color']) . ',
                    "opacity": ".2",
                    "gradient": "",
                    "gradient_type": "default",
                    "angle": "90",
                    "type": "color"
                },
                "paddings": {
                    "top": 12,
                    "bottom": 0
                }
            }
            ';
            return json_decode($model, true);
        }
    ),
);