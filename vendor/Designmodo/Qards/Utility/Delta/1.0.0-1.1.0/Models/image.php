<?php
// Migrate component models
$migrations = array(
    array(
        'template_id' => 'image.image1',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        },
                        "layout": "full",
                        "align": "center",
                        "url": "",
                        "imageIsSmall": false
                     }
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',

                        "style": {
                            "font-family": ' . json_encode($model['text']['style']['font-family']) . '
                        },
                        "classes": [
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Type here caption of the photo (optional)."
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
                    "top": 6,
                    "bottom": 6
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'image.image2',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        },
                        "layout": "full",
                        "align": "center",
                        "url": "",
                        "imageIsSmall": false
                    }
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',

                        "style": {
                            "font-family": ' . json_encode($model['text']['style']['font-family']) . '
                        },
                        "classes": [
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],

                    "placeholder": "Type here caption of the photo (optional)."
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
                    "top": 6,
                    "bottom": 6
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'image.image3',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        },
                        "layout": "full",
                        "align": "center",
                        "url": "",
                        "imageIsSmall": false
                    }
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": "<br/>"' . /* json_encode($model['text']['content']) .  */',

                        "style": {
                            "font-family": ' . json_encode($model['text']['style']['font-family']) . '
                        },
                        "classes": [
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],

                    "placeholder": "Type here caption of the photo (optional)."
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
                    "top": 6,
                    "bottom": 6
                }
            }

            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'image.image4',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        },
                        "layout": "medium",
                        "align": "center",
                        "url": "",
                        "imageIsSmall": false
                    }
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": "<br/>" ' . /* json_encode($model['text']['content']) . */ ',

                        "style": {
                            "font-family": ' . json_encode($model['text']['style']['font-family']) . '
                        },
                        "classes": [
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],

                    "placeholder": "Type here caption of the photo (optional)."
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
                    "top": 4,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'image.image5',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        },
                        "layout": "medium",
                        "align": "center",
                        "url": "",
                        "imageIsSmall": false
                    }
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',

                        "style": {
                            "font-family": ' . json_encode($model['text']['style']['font-family']) . '
                        },
                        "classes": [
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],

                    "placeholder": "Type here caption of the photo (optional)."
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
                    "top": 4,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'image.image6',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        },
                        "layout": "small",
                        "align": "center",
                        "url": "",
                        "imageIsSmall": false
                    }
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": "<br />",

                        "style": {
                            "font-family": ' . json_encode($model['text']['style']['font-family']) . '
                        },
                        "classes": [
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],

                    "placeholder": "Type here caption of the photo (optional)."
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
                    "top": 2,
                    "bottom": 2
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'image.image7',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        },
                        "layout": "small",
                        "align": "center",
                        "url": "",
                        "imageIsSmall": false
                    }
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',
                        "style": {
                            "font-family": ' . json_encode($model['text']['style']['font-family']) . '
                        },
                        "classes": [
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],

                    "placeholder": "Type here caption of the photo (optional)."
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
                    "top": 2,
                    "bottom": 2
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
);