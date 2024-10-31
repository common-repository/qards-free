<?php
// Migrate component models
$migrations = array(
    array(
        'template_id' => 'text.text1',
        'migrator' => function ($model) {
            $model = '
            {
                "text": {
                    "content": [{
                        "tagName": "h1",
                        "html": ' . json_encode($model['title']['content']) . ',

                        "style": {
                            "color": ' . json_encode($model['title']['style']['color']) . ',
                            "font-family": ' . json_encode($model['title']['style']['font-family']) . '
                        },
                        "classes": [

                            "font-size-' . $model['title']['classes']['font-size'] . '",
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }, {
                        "tagName": "p",
                        "html": ' . json_encode($model['hero']['content']) . ',

                        "style": {
                            "color": ' . json_encode($model['hero']['style']['color']) . ',
                            "font-family": ' . json_encode($model['hero']['style']['font-family']) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['hero']['classes']['font-size'] . '",
                            "line-height-' . $model['hero']['classes']['line-height'] . '"
                        ]
                    }, {
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',

                        "style": {
                            "color": ' . json_encode($model['text']['style']['color']) . ',
                            "font-family": ' . json_encode($model['text']['style']['font-family']) . '
                        },
                        "classes": [
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }, {
                        "tagName": "p",
                        "html": "",

                        "style": {
                            "color": "#6C6C6C",
                            "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif"
                        },
                        "classes": [
                            "font-size-4",
                            "line-height-4"
                        ]
                    }],

                    "placeholder": "Write your message here..."
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
                    "top": 12,
                    "bottom": 2
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'text.text2',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [{
                        "tagName": "h2",
                        "html": ' . json_encode($model['title']['content']) . ',

                        "style": {
                            "color": ' . json_encode($model['title']['style']['color']) . ',
                            "font-family": ' . json_encode($model['title']['style']['font-family']) . '
                        },
                        "classes": [
                            "font-size-' . $model['title']['classes']['font-size'] . '",
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }, {
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',

                        "style": {
                            "color": ' . json_encode($model['text']['style']['color']) . ',
                            "font-family": ' . json_encode($model['text']['style']['font-family']) . '
                        },
                        "classes": [
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],

                    "placeholder": "Write your message here..."
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
                    "top": 12,
                    "bottom": 2
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'text.text3',
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
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }, {
                        "tagName": "p",
                        "html": ' . json_encode($model['hero']['content']) . ',

                        "style": {
                            "color": ' . json_encode($model['hero']['style']['color']) . ',
                            "font-family": ' . json_encode($model['hero']['style']['font-family']) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['hero']['classes']['font-size'] . '",
                            "line-height-' . $model['hero']['classes']['line-height'] . '"
                        ]
                    }],

                    "placeholder": "Write your message here..."
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
                    "top": 12,
                    "bottom": 2
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'text.text4',
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
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }, {
                        "tagName": "p",
                        "html": ' . json_encode($model['hero']['content']) . ',

                        "style": {
                            "color": ' . json_encode($model['hero']['style']['color']) . ',
                            "font-family": ' . json_encode($model['hero']['style']['font-family']) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['hero']['classes']['font-size'] . '",
                            "line-height-' . $model['hero']['classes']['line-height'] . '"
                        ]
                    }],

                    "placeholder": "Write your message here..."
                },
                "link": {
                    "content": ' . json_encode($model['link']['name']) . ',
                    "url": ' . json_encode($model['link']['url']) . ',
                    "content-style": {
                        "text-align": "center",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#11A1EC"
                    },
                    "classes": [
                        "hero",
                        "font-size-2",
                        "line-height-2"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
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
                    "top": 12,
                    "bottom": 2
                }
            }

            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'text.text5',
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
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }, {
                        "tagName": "p",
                        "html": ' . json_encode($model['hero']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['hero']['style']['color']) . ',
                            "font-family": ' . json_encode($model['hero']['style']['font-family']) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['hero']['classes']['font-size'] . '",
                            "line-height-' . $model['hero']['classes']['line-height'] . '"
                        ]
                    }],

                    "placeholder": "Write your message here..."
                },
                "button": {
                    "content": ' . json_encode($model['button']['name']) . ',
                    "url": ' . json_encode($model['button']['url']) . ',
                    "content-style": {
                        "text-align": "center",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#FFF"
                    },
                    "button-style": {
                        "border-width": "0",
                        "border-style": "solid",
                        "border-color": "#11A1EC"
                    },
                    "classes": [
                        "font-size-1",
                        "line-height-4"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
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
                    "top": 12,
                    "bottom": 2
                }
            }

            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'text.text6',
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
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }, {
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['text']['style']['color']) . ',
                            "font-family": ' . json_encode($model['text']['style']['font-family']) . '
                        },
                        "classes": [
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Write your message here..."
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
                    "top": 12,
                    "bottom": 2
                }
            }

            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'text.text7',
        'migrator' => function ($model) {
            $model = '
                {
                    "text": {
                        "content": [{
                            "tagName": "p",
                            "html": ' . json_encode($model['text']['content']) . ',

                            "style": {
                                "color": ' . json_encode($model['text']['style']['color']) . ',
                                "font-family": ' . json_encode($model['text']['style']['font-family']) . '
                            },
                            "classes": [
                                "font-size-' . $model['text']['classes']['font-size'] . '",
                                "line-height-4"
                            ]
                        }],

                        "placeholder": "Write your message here..."
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
                        "top": 12,
                        "bottom": 2
                    }
                }
            ';

            return json_decode($model, true);
        }
    ),

);