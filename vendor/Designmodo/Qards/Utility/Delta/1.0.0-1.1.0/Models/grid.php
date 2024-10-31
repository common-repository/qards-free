<?php
// Migrate component models
$migrations = array(
    array(
        'template_id' => 'grid.grid1',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [
                        {
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
                        }
                    ],
                    "placeholder": "Write your message here..."
                },
                "hero": {
                    "content": [
                        {
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
                        }
                    ],
                    "placeholder": "Write your message here..."
                },
                "grid": [{
                        "link": {
                            "content": "Enter link text here...",
                            "url": "",
                            "content-style": {
                                "text-align": "left",
                                "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                                "color": "#11A1EC"
                            },
                            "classes": [
                                "font-size-4",
                                "line-height-4"
                            ],
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][0]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][0]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][0]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][0]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][0]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][0]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][0]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][0]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][0]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][0]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][0]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][0]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    },
                    {
                        "link": {
                            "content": "Enter link text here...",
                            "url": "",
                            "content-style": {
                                "text-align": "left",
                                "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                                "color": "#11A1EC"
                            },
                            "classes": [
                                "font-size-4",
                                "line-height-4"
                            ],
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][1]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][1]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][1]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][1]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][1]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][1]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][1]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][1]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][1]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][1]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][1]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][1]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    }
                ],
                "columns": {
                    "count": 2
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
                    "image": {
                        "label": "Show Media",
                        "value": true
                    },
                    "title": {
                        "label": "Show Title",
                        "value": true
                    },
                    "description": {
                        "label": "Show Description",
                        "value": true
                    }
                },
                "seamless": {
                    "label": "Seamless Grid",
                    "value": false
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
                "imgHeight": 1,
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
        'template_id' => 'grid.grid2',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [
                        {
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
                        }
                    ],
                    "placeholder": "Write your message here..."
                },
                "hero": {
                    "content": [
                        {
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
                        }
                    ],
                    "placeholder": "Write your message here..."
                },
                "grid": [{
                        "link": {
                            "content": "",
                            "url": "",
                            "content-style": {
                                "text-align": "left",
                                "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                                "color": "#11A1EC"
                            },
                            "classes": [
                                "font-size-4",
                                "line-height-4"
                            ],
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][0]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][0]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][0]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][0]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][0]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][0]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][0]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][0]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][0]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][0]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][0]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][0]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    },
                    {
                        "link": {
                            "content": "",
                            "url": "",
                            "content-style": {
                                "text-align": "left",
                                "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                                "color": "#11A1EC"
                            },
                            "classes": [
                                "font-size-4",
                                "line-height-4"
                            ],
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][1]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][1]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][1]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][1]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][1]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][1]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][1]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][1]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][1]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][1]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][1]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][1]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    },
                    {
                        "link": {
                            "content": "",
                            "url": "",
                            "content-style": {
                                "text-align": "left",
                                "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                                "color": "#11A1EC"
                            },
                            "classes": [
                                "font-size-4",
                                "line-height-4"
                            ],
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][2]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][2]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][2]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][2]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][2]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][2]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][2]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][2]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][2]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][2]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][2]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][2]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    }
                ],
                "columns": {
                    "count": 3
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
                    "image": {
                        "label": "Show Media",
                        "value": true
                    },
                    "title": {
                        "label": "Show Title",
                        "value": true
                    },
                    "description": {
                        "label": "Show Description",
                        "value": true
                    }
                },
                "seamless": {
                    "label": "Seamless Grid",
                    "value": false
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
                "imgHeight": 1,
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
        'template_id' => 'grid.grid3',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [
                        {
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
                        }
                    ],
                    "placeholder": "Write your message here..."
                },
                "hero": {
                    "content": [
                        {
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
                        }
                    ],
                    "placeholder": "Write your message here..."
                },
                "grid": [{
                        "link": {
                            "content": "",
                            "url": "",
                            "content-style": {
                                "text-align": "left",
                                "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                                "color": "#11A1EC"
                            },
                            "classes": [
                                "font-size-4",
                                "line-height-4"
                            ],
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][0]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][0]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][0]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][0]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][0]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][0]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][0]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][0]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][0]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][0]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][0]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][0]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    },
                    {
                        "link": {
                            "content": "",
                            "url": "",
                            "content-style": {
                                "text-align": "left",
                                "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                                "color": "#11A1EC"
                            },
                            "classes": [
                                "font-size-4",
                                "line-height-4"
                            ],
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][1]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][1]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][1]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][1]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][1]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][1]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][1]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][1]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][1]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][1]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][1]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][1]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    },
                    {
                        "link": {
                            "content": "",
                            "url": "",
                            "content-style": {
                                "text-align": "left",
                                "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                                "color": "#11A1EC"
                            },
                            "classes": [
                                "font-size-4",
                                "line-height-4"
                            ],
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][2]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][2]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][2]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][2]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][2]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][2]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][2]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][2]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][2]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][2]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][2]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][2]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    },
                    {
                        "link": {
                            "content": "",
                            "url": "",
                            "content-style": {
                                "text-align": "left",
                                "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                                "color": "#11A1EC"
                            },
                            "classes": [
                                "font-size-4",
                                "line-height-4"
                            ],
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][3]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][3]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][3]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][3]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][3]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][3]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][3]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][3]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][3]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][3]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][3]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][3]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    }
                ],
                "columns": {
                    "count": 4
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
                    "image": {
                        "label": "Show Media",
                        "value": true
                    },
                    "title": {
                        "label": "Show Title",
                        "value": true
                    },
                    "description": {
                        "label": "Show Description",
                        "value": true
                    }
                },
                "seamless": {
                    "label": "Seamless Grid",
                    "value": false
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
                "imgHeight": 1,
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
        'template_id' => 'grid.grid4',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [
                        {
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
                        }
                    ],
                    "placeholder": "Write your message here..."
                },
                "hero": {
                    "content": [
                        {
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
                        }
                    ],
                    "placeholder": "Write your message here..."
                },
                "grid": [{
                        "link": {
                            "content": "Explore City",
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
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][0]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][0]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][0]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][0]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][0]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][0]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][0]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][0]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][0]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][0]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][0]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][0]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    },
                    {
                       "link": {
                            "content": "Santa Monica",
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
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][1]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][1]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][1]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][1]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][1]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][1]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][1]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][0]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][0]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][0]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][0]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][0]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    }
                ],
                "columns": {
                    "count": 2
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
                    "image": {
                        "label": "Show Media",
                        "value": true
                    },
                    "title": {
                            "label": "Show Title",
                            "value": true
                    },
                    "description": {
                            "label": "Show Description",
                            "value": true
                    }
                },
                "seamless": {
                    "label": "Seamless Grid",
                    "value": false
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
                "imgHeight": 1,
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
        'template_id' => 'grid.grid5',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [
                        {
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
                        }
                    ],
                    "placeholder": "Write your message here..."
                },
                "hero": {
                    "content": [
                        {
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
                        }
                    ],
                    "placeholder": "Write your message here..."
                },
                "grid": [{
                        "link": {
                            "content": ' . json_encode($model['grid'][0]['link']['name']) . ',
                            "url": ' . json_encode($model['grid'][0]['link']['url']) . ',
                            "content-style": {
                                "text-align": "left",
                                "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                                "color": "#11A1EC"
                            },
                            "classes": [
                                "font-size-4",
                                "line-height-4"
                            ],
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": true
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][0]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][0]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][0]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][0]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][0]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][0]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][0]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][0]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][0]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][0]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][0]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][0]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    },
                    {
                        "link": {
                            "content": ' . json_encode($model['grid'][1]['link']['name']) . ',
                            "url": ' . json_encode($model['grid'][1]['link']['url']) . ',
                            "content-style": {
                                "text-align": "left",
                                "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                                "color": "#11A1EC"
                            },
                            "classes": [
                                "font-size-4",
                                "line-height-4"
                            ],
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": true
                        },
                        "media": {
                            "show": "image",
                             "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][1]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][1]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][1]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][1]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][1]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][1]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][1]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][1]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][1]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][1]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][1]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][1]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    },
                    {
                        "link": {
                            "content": ' . json_encode($model['grid'][2]['link']['name']) . ',
                            "url": ' . json_encode($model['grid'][2]['link']['url']) . ',
                            "content-style": {
                                "text-align": "left",
                                "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                                "color": "#11A1EC"
                            },
                            "classes": [
                                "font-size-4",
                                "line-height-4"
                            ],
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": true
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][2]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][2]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][2]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][2]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][2]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][2]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][2]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][2]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][2]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][2]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][2]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][2]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    }
                ],
                "columns": {
                    "count": 3
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
                    "image": {
                        "label": "Show Media",
                        "value": true
                    },
                    "title": {
                        "label": "Show Title",
                        "value": true
                    },
                    "description": {
                        "label": "Show Description",
                        "value": true
                    }
                },
                "seamless": {
                    "label": "Seamless Grid",
                    "value": false
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
                "imgHeight": 1,
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
        'template_id' => 'grid.grid6',
        'migrator' => function ($model) {
            $model = '
            {
                "title": {
                    "content": [
                        {
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
                        }
                    ],
                    "placeholder": "Write your message here..."
                },
                "hero": {
                    "content": [
                        {
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
                        }
                    ],
                    "placeholder": "Write your message here..."
                },
                "grid": [{
                        "link": {
                            "content": "Leather Wallets",
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
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][0]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][0]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][0]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][0]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][0]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][0]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][0]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][0]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][0]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][0]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][0]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][0]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    },
                    {
                        "link": {
                            "content": "Brown Leather",
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
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][1]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][1]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][1]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][1]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][1]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][1]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][1]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][1]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][1]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][1]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][1]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][1]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    },
                    {
                        "link": {
                            "content": "Design",
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
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][2]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][2]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h3",
                                    "html": ' . json_encode($model['grid'][2]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][2]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][2]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][2]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][2]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][2]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][2]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][2]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][2]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][2]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    },
                    {
                        "link": {
                            "content": "Neck Strap",
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
                            "placeholder": "Enter link text here...",
                            "target": "_blank",
                            "bottom": false
                        },
                        "media": {
                            "show": "image",
                            "bg_image": {
                                "src": {
                                    "small": ' . json_encode($model['grid'][3]['bg_image']) . ',
                                    "base": ' . json_encode($model['grid'][3]['bg_image']) . '
                                }
                            },
                            "video": {
                                "id": "",
                                "autoplay": false
                            }
                        },
                        "sub_title": {
                            "content": [
                                {
                                    "tagName": "h4",
                                    "html": ' . json_encode($model['grid'][3]['sub_title']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][3]['sub_title']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][3]['sub_title']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][3]['sub_title']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][3]['sub_title']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Enter title here"
                        },
                        "text": {
                            "content": [
                                {
                                    "tagName": "p",
                                    "html": ' . json_encode($model['grid'][3]['text']['content']) . ',
                                    "style": {
                                        "color": ' . json_encode($model['grid'][3]['text']['style']['color']) . ',
                                        "font-family": ' . json_encode($model['grid'][3]['text']['style']['font-family']) . '
                                    },
                                    "classes": [
                                        "font-size-' . $model['grid'][3]['text']['classes']['font-size'] . '",
                                        "line-height-' . $model['grid'][3]['text']['classes']['line-height'] . '"
                                    ]
                                }
                            ],
                            "placeholder": "Right here you can describe this block"
                        },
                        "isDuplicate": false
                    }
                ],
                "columns": {
                    "count": 4
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
                    "image": {
                        "label": "Show Media",
                        "value": true
                    },
                    "title": {
                        "label": "Show Title",
                        "value": true
                    },
                    "description": {
                        "label": "Show Description",
                        "value": true
                    }
                },
                "seamless": {
                    "label": "Seamless Grid",
                    "value": false
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
                "imgHeight": 1,
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