<?php
// Migrate component models
$migrations = array(
    array(
        'template_id' => 'subscribe.subscribe1',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [{
                        "tagName": "h1",
                        "html": ' . json_encode($model['title']['content']) . ',

                        "style": {
                            "color": ' . json_encode($model['title']['style']['color']) . ',
                            "font-family": ' . json_encode($model['title']['style']['font-family']) . '
                        },
                        "classes": [
                            "font-size-' . $model['title']['classes']['font-size'] . '",
                            "line-height-4"
                        ]
                    }],

                    "placeholder": "Write your message here..."
                },
                "hero": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['hero']['content']) . ',

                        "style": {
                            "color": ' . json_encode($model['hero']['style']['color']) . ',
                            "font-family": ' . json_encode($model['hero']['style']['font-family']) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['hero']['classes']['font-size'] . '",
                            "line-height-4"
                        ]
                    }],

                    "placeholder": "Write your message here..."
                },
                "button": {
                    "content": ' . json_encode($model['button']) . ',
                    "url": "#",
                    "content-style": {
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#FFF"
                    },
                    "button-style": {
                        "border-width": "0",
                        "border-style": "solid",
                        "border-color": "#FFF"
                    },
                    "classes": [
                        "font-size-8",
                        "line-height-2"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": true
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": true
                    }
                },
                "block_bg": {
                    "color": "#ffffff",
                    "opacity": "1",
                    "image": "",
                    "gradient": "",
                    "gradient_type": "default",
                    "angle": "90",
                    "type": "color"
                },
                "paddings": {
                    "top": 10,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'subscribe.subscribe2',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [{
                        "tagName": "h1",
                        "html": "",

                        "style": {
                            "color": "#424242",
                            "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif"
                        },
                        "classes": [
                            "font-size-4",
                            "line-height-4"
                        ]
                    }],
                    "placeholder": "Write your message here..."
                },
                "hero": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['hero']['content']) . ',

                        "style": {
                            "color": ' . json_encode($model['hero']['style']['color']) . ',
                            "font-family": ' . json_encode($model['hero']['style']['font-family']) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['hero']['classes']['font-size'] . '",
                            "line-height-4"
                        ]
                    }],

                    "placeholder": "Write your message here..."
                },
                "button": {
                    "content": ' . json_encode($model['button']) . ',
                    "url": "#",
                    "content-style": {
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#FFF"
                    },
                    "button-style": {
                        "border-width": "0",
                        "border-style": "solid",
                        "border-color": "#FFF"
                    },
                    "classes": [
                        "font-size-8",
                        "line-height-2"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": false
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": true
                    }
                },
                "block_bg": {
                    "color": "#ffffff",
                    "opacity": "1",
                    "image": "",
                    "gradient": "",
                    "gradient_type": "default",
                    "angle": "90",
                    "type": "color"
                },
                "paddings": {
                    "top": 10,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
);