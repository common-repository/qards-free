<?php
// Migrate component models
$migrations = array(
    array(
        'template_id' => 'feature.feature1',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "autoplay": false
                    }
                },
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
                            "line-height-' . $model['hero']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Write your message here..."
                },
                "link": {
                    "content": "<br/>",
                    "url": "#",
                    "content-style": {
                        "text-align": "center",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#11A1EC"
                    },
                    "classes": [
                        "font-size-4",
                        "line-height-4"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "size": {
                    "index": "2",
                    "class": "large"
                },
                "position": {
                    "index": "1",
                    "class": "top"
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": true
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": true
                    },
                    "bottom": {
                        "label": "Bottom Link",
                        "value": false
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
                    "top": 12,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'feature.feature2',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "autoplay": false
                    }
                },
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
                            "line-height-' . $model['hero']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Write your message here..."
                },
                "link": {
                    "content": "",
                    "url": "#",
                    "content-style": {
                        "text-align": "center",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#11A1EC"
                    },
                    "classes": [
                        "font-size-4",
                        "line-height-4"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "size": {
                    "index": "2",
                    "class": "large"
                },
                "position": {
                    "index": "2",
                    "class": "bottom"
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": true
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": true
                    },
                    "bottom": {
                        "label": "Bottom Link",
                        "value": false
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
                    "top": 12,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'feature.feature3',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "autoplay": false
                    }
                },
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
                            "line-height-' . $model['hero']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Write your message here..."
                },
                "link": {
                    "content": "",
                    "url": "#",
                    "content-style": {
                        "text-align": "center",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#11A1EC"
                    },
                    "classes": [
                        "font-size-4",
                        "line-height-4"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "size": {
                    "index": "1",
                    "class": "small"
                },
                "position": {
                    "index": "1",
                    "class": "top"
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": true
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": true
                    },
                    "bottom": {
                        "label": "Bottom Link",
                        "value": false
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
                    "top": 12,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'feature.feature4',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "autoplay": false
                    }
                },
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
                            "line-height-' . $model['hero']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Write your message here..."
                },
                "link": {
                    "content": "",
                    "url": "#",
                    "content-style": {
                        "text-align": "center",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#11A1EC"
                    },
                    "classes": [
                        "font-size-4",
                        "line-height-4"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "size": {
                    "index": "1",
                    "class": "small"
                },
                "position": {
                    "index": "2",
                    "class": "bottom"
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": true
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": true
                    },
                    "bottom": {
                        "label": "Bottom Link",
                        "value": false
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
                    "top": 12,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'feature.feature5',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "autoplay": false
                    }
                },
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
                        "font-size-4",
                        "line-height-4"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "size": {
                    "index": "2",
                    "class": "large"
                },
                "position": {
                    "index": "1",
                    "class": "top"
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": true
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": true
                    },
                    "bottom": {
                        "label": "Bottom Link",
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
                    "top": 12,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'feature.feature6',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "autoplay": false
                    }
                },
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
                        "font-size-4",
                        "line-height-4"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "size": {
                    "index": "2",
                    "class": "large"
                },
                "position": {
                    "index": "2",
                    "class": "bottom"
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": true
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": true
                    },
                    "bottom": {
                        "label": "Bottom Link",
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
                    "top": 12,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'feature.feature7',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "autoplay": false
                    }
                },
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
                        "font-size-4",
                        "line-height-4"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "size": {
                    "index": "1",
                    "class": "small"
                },
                "position": {
                    "index": "1",
                    "class": "top"
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": true
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": true
                    },
                    "bottom": {
                        "label": "Bottom Link",
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
                    "top": 12,
                    "bottom": 4
                }
            }
            ';
            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'feature.feature8',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "autoplay": false
                    }
                },
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
                        "font-size-4",
                        "line-height-4"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "size": {
                    "index": "1",
                    "class": "small"
                },
                "position": {
                    "index": "2",
                    "class": "bottom"
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": true
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": true
                    },
                    "bottom": {
                        "label": "Bottom Link",
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
                    "top": 12,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'feature.feature9',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "autoplay": false
                    }
                },
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
                            "line-height-' . $model['hero']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Write your message here..."
                },
                "link": {
                    "content": "",
                    "url": "#",
                    "content-style": {
                        "text-align": "left",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#11A1EC"
                    },
                    "classes": [
                        "font-size-4",
                        "line-height-4"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "size": {
                    "index": "2",
                    "class": "large"
                },
                "position": {
                    "index": "3",
                    "class": "left"
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": true
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": true
                    },
                    "bottom": {
                        "label": "Bottom Link",
                        "value": false
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
                    "top": 12,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'feature.feature10',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "autoplay": false
                    }
                },
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
                            "line-height-' . $model['hero']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Write your message here..."
                },
                "link": {
                    "content": "",
                    "url": "#",
                    "content-style": {
                        "text-align": "left",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#11A1EC"
                    },
                    "classes": [
                        "font-size-4",
                        "line-height-4"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "size": {
                    "index": "2",
                    "class": "large"
                },
                "position": {
                    "index": "4",
                    "class": "right"
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": true
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": true
                    },
                    "bottom": {
                        "label": "Bottom Link",
                        "value": false
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
                    "top": 12,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'feature.feature11',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "autoplay": false
                    }
                },
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
                            "line-height-' . $model['hero']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Write your message here..."
                },
                "link": {
                    "content": ' . json_encode($model['link']['name']) . ',
                    "url": ' . json_encode($model['link']['url']) . ',
                    "content-style": {
                        "text-align": "left",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#11A1EC"
                    },
                    "classes": [
                        "font-size-4",
                        "line-height-4"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "size": {
                    "index": "2",
                    "class": "large"
                },
                "position": {
                    "index": "3",
                    "class": "left"
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": true
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": true
                    },
                    "bottom": {
                        "label": "Bottom Link",
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
                    "top": 12,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'feature.feature12',
        'migrator' => function ($model) {
            $model = '
            {
                "media": {
                    "show": "image",
                    "image": {
                        "src": {
                            "small": ' . json_encode($model['image']) . ',
                            "base": ' . json_encode($model['image']) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "autoplay": false
                    }
                },
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
                            "line-height-' . $model['hero']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Write your message here..."
                },
                "link": {
                    "content":  ' . json_encode($model['link']['name']) . ',
                    "url": ' . json_encode($model['link']['url']) . ',
                    "content-style": {
                        "text-align": "left",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#11A1EC"
                    },
                    "classes": [
                        "font-size-4",
                        "line-height-4"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "size": {
                    "index": "2",
                    "class": "large"
                },
                "position": {
                    "index": "4",
                    "class": "right"
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": true
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": true
                    },
                    "bottom": {
                        "label": "Bottom Link",
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
                    "top": 12,
                    "bottom": 4
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
);