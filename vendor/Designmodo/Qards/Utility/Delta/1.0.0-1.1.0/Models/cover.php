<?php
// Migrate component models
$migrations = array(
    array(
        'template_id' => 'cover.cover1',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [{
                        "tagName": "h1",
                        "html": ' . json_encode($model['title']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['title']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['title']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "font-size-' . $model['title']['classes']['font-size'] . '",
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Start with a title"
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['text']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['text']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Type your caption text"
                },
                "media": {
                    "show": "image",
                    "bg_image": {
                        "src": {
                            "small": ' . json_encode($model['bg_image'] ) . ',
                            "base": ' . json_encode($model['bg_image'] ) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "quality": "default",
                        "firstFrame": "",
                        "startAt": "0",
                        "stopAt": "0"
                    }
                },
                "block_bg": {
                    "color": ' . json_encode($model['bg_color'] ) . ',
                    "opacity": ' . json_encode($model['opacity'] ) . ',
                    "type": "color"
                },
                "button": {
                    "content": ' . json_encode($model['button']['name'] ) . ',
                    "url": ' . json_encode($model['button']['url'] ) . ',
                    "content-style": {
                        "text-align": "left",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#FFF"
                    },
                    "button-style": {
                        "border-width": "2px",
                        "border-style": "solid",
                        "border-color": "#FFF"
                    },
                    "classes": [
                        "font-size-2",
                        "line-height-2"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "position": {
                    "index": "1",
                    "classes": "left top"
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
                    "button": {
                        "label": "Show Button",
                        "value": true
                    },
                    "colors": {
                        "label": "Inverse Colors",
                        "value": false
                    }
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'cover.cover2',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [{
                        "tagName": "h1",
                        "html": ' . json_encode($model['title']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['title']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['title']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "font-size-' . $model['title']['classes']['font-size'] . '",
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Start with a title"
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['text']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['text']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Type your caption text"
                },
                "media": {
                    "show": "image",
                    "bg_image": {
                        "src": {
                            "small": ' . json_encode($model['bg_image'] ) . ',
                            "base": ' . json_encode($model['bg_image'] ) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "quality": "default",
                        "firstFrame": "",
                        "startAt": "0",
                        "stopAt": "0"
                    }
                },
                "block_bg": {
                    "color": ' . json_encode($model['bg_color'] ) . ',
                    "opacity": ' . json_encode($model['opacity'] ) . ',
                    "type": "color"
                },
                "button": {
                    "content": ' . json_encode($model['button']['name'] ) . ',
                    "url": ' . json_encode($model['button']['url'] ) . ',
                    "content-style": {
                        "text-align": "left",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#FFF"
                    },
                    "button-style": {
                        "border-width": "2px",
                        "border-style": "solid",
                        "border-color": "#FFF"
                    },
                    "classes": [
                        "font-size-2",
                        "line-height-2"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "position": {
                    "index": "4",
                    "classes": "left middle"
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
                    "button": {
                        "label": "Show Button",
                        "value": true
                    },
                    "colors": {
                        "label": "Inverse Colors",
                        "value": false
                    }
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'cover.cover3',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [{
                        "tagName": "h1",
                        "html": ' . json_encode($model['title']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['title']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['title']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "font-size-' . $model['title']['classes']['font-size'] . '",
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Start with a title"
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['text']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['text']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Type your caption text"
                },
                "media": {
                    "show": "image",
                    "bg_image": {
                        "src": {
                            "small": ' . json_encode($model['bg_image'] ) . ',
                            "base": ' . json_encode($model['bg_image'] ) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "quality": "default",
                        "firstFrame": "",
                        "startAt": "0",
                        "stopAt": "0"
                    }
                },
                "block_bg": {
                    "color": ' . json_encode($model['bg_color'] ) . ',
                    "opacity": ' . json_encode($model['opacity'] ) . ',
                    "type": "color"
                },
                "button": {
                    "content": ' . json_encode($model['button']['name'] ) . ',
                    "url": ' . json_encode($model['button']['url'] ) . ',
                    "content-style": {
                        "text-align": "left",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#FFF"
                    },
                    "button-style": {
                        "border-width": "2px",
                        "border-style": "solid",
                        "border-color": "#FFF"
                    },
                    "classes": [
                        "font-size-2",
                        "line-height-2"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "position": {
                    "index": "7",
                    "classes": "left bottom"
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
                    "button": {
                        "label": "Show Button",
                        "value": true
                    },
                    "colors": {
                        "label": "Inverse Colors",
                        "value": false
                    }
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'cover.cover4',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [{
                        "tagName": "h1",
                        "html": ' . json_encode($model['title']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['title']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['title']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "font-size-' . $model['title']['classes']['font-size'] . '",
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Start with a title"
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['text']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['text']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Type your caption text"
                },
                "media": {
                    "show": "image",
                    "bg_image": {
                        "src": {
                            "small": ' . json_encode($model['bg_image'] ) . ',
                            "base": ' . json_encode($model['bg_image'] ) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "quality": "default",
                        "firstFrame": "",
                        "startAt": "0",
                        "stopAt": "0"
                    }
                },
                "block_bg": {
                    "color": ' . json_encode($model['bg_color'] ) . ',
                    "opacity": ' . json_encode($model['opacity'] ) . ',
                    "type": "color"
                },
                "button": {
                    "content": ' . json_encode($model['button']['name'] ) . ',
                    "url": ' . json_encode($model['button']['url'] ) . ',
                    "content-style": {
                        "text-align": "center",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#303336"
                    },
                    "button-style": {
                        "border-width": "2px",
                        "border-style": "solid",
                        "border-color": "#303336"
                    },
                    "classes": [
                        "font-size-2",
                        "line-height-2"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "position": {
                    "index": "2",
                    "classes": "center top"
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
                    "button": {
                        "label": "Show Button",
                        "value": true
                    },
                    "colors": {
                        "label": "Inverse Colors",
                        "value": true
                    }
                }
            }
            ';
            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'cover.cover5',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [{
                        "tagName": "h1",
                        "html": ' . json_encode($model['title']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['title']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['title']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "font-size-' . $model['title']['classes']['font-size'] . '",
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Start with a title"
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['text']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['text']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Type your caption text"
                },
                "media": {
                    "show": "image",
                    "bg_image": {
                        "src": {
                            "small": ' . json_encode($model['bg_image'] ) . ',
                            "base": ' . json_encode($model['bg_image'] ) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "quality": "default",
                        "firstFrame": "",
                        "startAt": "0",
                        "stopAt": "0"
                    }
                },
                "block_bg": {
                    "color": ' . json_encode($model['bg_color'] ) . ',
                    "opacity": ' . json_encode($model['opacity'] ) . ',
                    "type": "color"
                },
                "button": {
                    "content": ' . json_encode($model['button']['name'] ) . ',
                    "url": ' . json_encode($model['button']['url'] ) . ',
                    "content-style": {
                        "text-align": "center",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#FFF"
                    },
                    "button-style": {
                        "border-width": "2px",
                        "border-style": "solid",
                        "border-color": "#FFF"
                    },
                    "classes": [
                        "font-size-2",
                        "line-height-2"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "position": {
                    "index": "5",
                    "classes": "center middle"
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
                    "button": {
                        "label": "Show Button",
                        "value": true
                    },
                    "colors": {
                        "label": "Inverse Colors",
                        "value": false
                    }
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'cover.cover6',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [{
                        "tagName": "h1",
                        "html": ' . json_encode($model['title']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['title']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['title']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "font-size-' . $model['title']['classes']['font-size'] . '",
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Start with a title"
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['text']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['text']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Type your caption text"
                },
                "media": {
                    "show": "image",
                    "bg_image": {
                        "src": {
                            "small": ' . json_encode($model['bg_image'] ) . ',
                            "base": ' . json_encode($model['bg_image'] ) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "quality": "default",
                        "firstFrame": "",
                        "startAt": "0",
                        "stopAt": "0"
                    }
                },
                "block_bg": {
                    "color": ' . json_encode($model['bg_color'] ) . ',
                    "opacity": ' . json_encode($model['opacity'] ) . ',
                    "type": "color"
                },
                "button": {
                    "content": ' . json_encode($model['button']['name'] ) . ',
                    "url": ' . json_encode($model['button']['url'] ) . ',
                    "content-style": {
                        "text-align": "center",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#FFF"
                    },
                    "button-style": {
                        "border-width": "2px",
                        "border-style": "solid",
                        "border-color": "#FFF"
                    },
                    "classes": [
                        "font-size-2",
                        "line-height-2"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "position": {
                    "index": "8",
                    "classes": "center bottom"
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
                    "button": {
                        "label": "Show Button",
                        "value": true
                    },
                    "colors": {
                        "label": "Inverse Colors",
                        "value": false
                    }
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'cover.cover7',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [{
                        "tagName": "h1",
                        "html": ' . json_encode($model['title']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['title']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['title']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "font-size-' . $model['title']['classes']['font-size'] . '",
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Start with a title"
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['text']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['text']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Type your caption text"
                },
                "media": {
                    "show": "image",
                    "bg_image": {
                        "src": {
                            "small": ' . json_encode($model['bg_image'] ) . ',
                            "base": ' . json_encode($model['bg_image'] ) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "quality": "default",
                        "firstFrame": "",
                        "startAt": "0",
                        "stopAt": "0"
                    }
                },
                "block_bg": {
                    "color": ' . json_encode($model['bg_color'] ) . ',
                    "opacity": ' . json_encode($model['opacity'] ) . ',
                    "type": "color"
                },
                "button": {
                    "content": ' . json_encode($model['button']['name'] ) . ',
                    "url": ' . json_encode($model['button']['url'] ) . ',
                    "content-style": {
                        "text-align": "left",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#FFF"
                    },
                    "button-style": {
                        "border-width": "2px",
                        "border-style": "solid",
                        "border-color": "#FFF"
                    },
                    "classes": [
                        "font-size-2",
                        "line-height-2"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "position": {
                    "index": "3",
                    "classes": "right top"
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
                    "button": {
                        "label": "Show Button",
                        "value": true
                    },
                    "colors": {
                        "label": "Inverse Colors",
                        "value": false
                    }
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'cover.cover8',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [{
                        "tagName": "h1",
                        "html": ' . json_encode($model['title']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['title']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['title']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "font-size-' . $model['title']['classes']['font-size'] . '",
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Start with a title"
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['text']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['text']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Type your caption text"
                },
                "media": {
                    "show": "image",
                    "bg_image": {
                        "src": {
                            "small": ' . json_encode($model['bg_image'] ) . ',
                            "base": ' . json_encode($model['bg_image'] ) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "quality": "default",
                        "firstFrame": "",
                        "startAt": "0",
                        "stopAt": "0"
                    }
                },
                "block_bg": {
                    "color": ' . json_encode($model['bg_color'] ) . ',
                    "opacity": ' . json_encode($model['opacity'] ) . ',
                    "type": "color"
                },
                "button": {
                    "content": ' . json_encode($model['button']['name'] ) . ',
                    "url": ' . json_encode($model['button']['url'] ) . ',
                    "content-style": {
                        "text-align": "left",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#FFF"
                    },
                    "button-style": {
                        "border-width": "2px",
                        "border-style": "solid",
                        "border-color": "#FFF"
                    },
                    "classes": [
                        "font-size-2",
                        "line-height-2"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "position": {
                    "index": "6",
                    "classes": "right middle"
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
                    "button": {
                        "label": "Show Button",
                        "value": true
                    },
                    "colors": {
                        "label": "Inverse Colors",
                        "value": false
                    }
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'cover.cover9',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [{
                        "tagName": "h1",
                        "html": ' . json_encode($model['title']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['title']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['title']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "font-size-' . $model['title']['classes']['font-size'] . '",
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Start with a title"
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": ' . json_encode($model['text']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['text']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['text']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "hero",
                            "font-size-' . $model['text']['classes']['font-size'] . '",
                            "line-height-' . $model['text']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Type your caption text"
                },
                "media": {
                    "show": "image",
                    "bg_image": {
                        "src": {
                            "small": ' . json_encode($model['bg_image'] ) . ',
                            "base": ' . json_encode($model['bg_image'] ) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "quality": "default",
                        "firstFrame": "",
                        "startAt": "0",
                        "stopAt": "0"
                    }
                },
                "block_bg": {
                    "color": ' . json_encode($model['bg_color'] ) . ',
                    "opacity": ' . json_encode($model['opacity'] ) . ',
                    "type": "color"
                },
                "button": {
                    "content": ' . json_encode($model['button']['name'] ) . ',
                    "url": ' . json_encode($model['button']['url'] ) . ',
                    "content-style": {
                        "text-align": "left",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#FFF"
                    },
                    "button-style": {
                        "border-width": "2px",
                        "border-style": "solid",
                        "border-color": "#FFF"
                    },
                    "classes": [
                        "font-size-2",
                        "line-height-2"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "position": {
                    "index": "9",
                    "classes": "right bottom"
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
                    "button": {
                        "label": "Show Button",
                        "value": true
                    },
                    "colors": {
                        "label": "Inverse Colors",
                        "value": false
                    }
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'cover.cover10',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [{
                        "tagName": "h1",
                        "html": ' . json_encode($model['title']['content']) . ',
                        "style": {
                            "color": ' . json_encode($model['title']['style']['color'] ) . ',
                            "font-family": ' . json_encode($model['title']['style']['font-family'] ) . '
                        },
                        "classes": [
                            "font-size-' . $model['title']['classes']['font-size'] . '",
                            "line-height-' . $model['title']['classes']['line-height'] . '"
                        ]
                    }],
                    "placeholder": "Start with a title"
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": "<br/>",
                        "style": {
                            "color": "#ffffff",
                            "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif"
                        },
                        "classes": [
                            "hero",
                            "font-size-4",
                            "line-height-4"
                        ]
                    }],
                    "placeholder": "Type your caption text"
                },
                "media": {
                    "show": "image",
                    "bg_image": {
                        "src": {
                            "small": ' . json_encode($model['bg_image'] ) . ',
                            "base": ' . json_encode($model['bg_image'] ) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "quality": "default",
                        "firstFrame": "",
                        "startAt": "0",
                        "stopAt": "0"
                    }
                },
                "block_bg": {
                    "color": ' . json_encode($model['bg_color'] ) . ',
                    "opacity": ' . json_encode($model['opacity'] ) . ',
                    "type": "color"
                },
                "button": {
                    "content": "<br />",
                    "url": "#",
                    "content-style": {
                        "text-align": "center",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#FFF"
                    },
                    "button-style": {
                        "border-width": "2px",
                        "border-style": "solid",
                        "border-color": "#FFF"
                    },
                    "classes": [
                        "font-size-2",
                        "line-height-2"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "position": {
                    "index": "5",
                    "classes": "center middle"
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": true
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": false
                    },
                    "button": {
                        "label": "Show Button",
                        "value": false
                    },
                    "colors": {
                        "label": "Inverse Colors",
                        "value": false
                    }
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'cover.cover11',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [{
                        "tagName": "h1",
                        "html": "<br/>",
                        "style": {
                            "color": "#303336",
                            "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif"
                        },
                        "classes": [
                            "font-size-4",
                            "line-height-4"
                        ]
                    }],
                    "placeholder": "Start with a title"
                },
                "text": {
                    "content": [{
                        "tagName": "p",
                        "html": "<br/>",
                        "style": {
                            "color": "#303336",
                            "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif"
                        },
                        "classes": [
                            "hero",
                            "font-size-4",
                            "line-height-4"
                        ]
                    }],
                    "placeholder": "Type your caption text"
                },
                "media": {
                    "show": "image",
                    "bg_image": {
                        "src": {
                            "small": ' . json_encode($model['bg_image'] ) . ',
                            "base": ' . json_encode($model['bg_image'] ) . '
                        }
                    },
                    "video": {
                        "id": "",
                        "quality": "default",
                        "firstFrame": "",
                        "startAt": "0",
                        "stopAt": "0"
                    }
                },
                "block_bg": {
                    "color": ' . json_encode($model['bg_color'] ) . ',
                    "opacity": 0,
                    "type": "color"
                },
                "button": {
                    "content": "<br/>",
		            "url": "#",
                    "content-style": {
                        "text-align": "center",
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#FFF"
                    },
                    "button-style": {
                        "border-width": "2px",
                        "border-style": "solid",
                        "border-color": "#FFF"
                    },
                    "classes": [
                        "font-size-2",
                        "line-height-2"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here..."
                },
                "position": {
                    "index": "5",
                    "classes": "center middle"
                },
                "layout": {
                    "header": {
                        "label": "Show Header",
                        "value": false
                    },
                    "hero": {
                        "label": "Show Hero",
                        "value": false
                    },
                    "button": {
                        "label": "Show Button",
                        "value": false
                    },
                    "colors": {
                        "label": "Inverse Colors",
                        "value": false
                    }
                }
            }
            ';
            return json_decode($model, true);
        }
    )
);