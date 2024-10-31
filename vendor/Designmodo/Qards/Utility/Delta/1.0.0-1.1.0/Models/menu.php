<?php
// Migrate component models
$migrations = array(
    array(
        'template_id' => 'menu.menu1',
        'migrator' => function ($model) {
            $model = '
            {
                "sticky": true,
                "bg_color": "#fff",
                "opacity": "0.98",
                "bg_color_type": "color",
                "brand": {
                    "src": {
                        "base": ' . json_encode($model['brand']['image']) . '
                    },
                    "url": ' . json_encode($model['brand']['url']) . '
                },
                "links": {
                    "align": "center",
                    "style": {
                        "bold": "normal",
                        "italic": "normal",
                        "color": "#424242",
                        "opacity": "0.9",
                        "fontFamily": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "fontSize": "1"
                    },
                    "show": false
                },
                "button": {
                    "content": "Get the App",
                    "url": "#",
                    "content-style": {
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#424242"
                    },
                    "button-style": {
                        "border-width": "1px",
                        "border-style": "solid",
                        "border-color": "#424242"
                    },
                    "classes": [
                        "font-size-1",
                        "line-height-1"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here...",
                    "show": false
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'menu.menu2',
        'migrator' => function ($model) {
            $model = '
            {
                "sticky": true,
                "bg_color": "#fff",
                "opacity": "0.98",
                "bg_color_type": "color",
                "brand": {
                    "src": {
                        "base": ' . json_encode($model['brand']['image']) . '
                    },
                    "url": ' . json_encode($model['brand']['url']) . '
                },
                "links": {
                    "align": "center",
                    "style": {
                        "bold": "normal",
                        "italic": "normal",
                        "color": "#424242",
                        "opacity": "0.9",
                        "fontFamily": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "fontSize": "1"
                    },
                    "show": false
                },
                "button": {
                    "content": "Get the App",
                    "url": "#",
                    "content-style": {
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#424242"
                    },
                    "button-style": {
                        "border-width": "1px",
                        "border-style": "solid",
                        "border-color": "#424242"
                    },
                    "classes": [
                        "font-size-1",
                        "line-height-1"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here...",
                    "show": true
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'menu.menu3',
        'migrator' => function ($model) {
            $model = '
            {
                "sticky": true,
                "bg_color": "#fff",
                "opacity": "0.98",
                "bg_color_type": "color",
                "brand": {
                    "src": {
                        "base": ' . json_encode($model['brand']['image']) . '
                    },
                    "url": ' . json_encode($model['brand']['url']) . '
                },
                "links": {
                    "align": "left",
                    "style": {
                        "bold": "normal",
                        "italic": "normal",
                        "color": "#424242",
                        "opacity": "0.9",
                        "fontFamily": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "fontSize": "1"
                    },
                    "show": true
                },
                "button": {
                    "content": "Get the App",
                    "url": "#",
                    "content-style": {
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#424242"
                    },
                    "button-style": {
                        "border-width": "1px",
                        "border-style": "solid",
                        "border-color": "#424242"
                    },
                    "classes": [
                        "font-size-1",
                        "line-height-1"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here...",
                    "show": false
                }
            }
            ';
            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'menu.menu4',
        'migrator' => function ($model) {
            $model = '
            {
                "sticky": true,
                "bg_color": "#fff",
                "opacity": "0.98",
                "bg_color_type": "color",
                "brand": {
                    "src": {
                        "base": ' . json_encode($model['brand']['image']) . '
                    },
                    "url": ' . json_encode($model['brand']['url']) . '
                },
                "links": {
                    "align": "right",
                    "style": {
                        "bold": "normal",
                        "italic": "normal",
                        "color": "#424242",
                        "opacity": "0.9",
                        "fontFamily": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "fontSize": "1"
                    },
                    "show": true
                },
                "button": {
                    "content": "Get the App",
                    "url": "#",
                    "content-style": {
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#424242"
                    },
                    "button-style": {
                        "border-width": "1px",
                        "border-style": "solid",
                        "border-color": "#424242"
                    },
                    "classes": [
                        "font-size-1",
                        "line-height-1"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here...",
                    "show": false
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'menu.menu5',
        'migrator' => function ($model) {
            $model = '
            {
                "sticky": true,
                "bg_color": "#fff",
                "opacity": "0.98",
                "bg_color_type": "color",
                "brand": {
                    "src": {
                        "base": ' . json_encode($model['brand']['image']) . '
                    },
                    "url": ' . json_encode($model['brand']['url']) . '
                },
                "links": {
                    "align": "center",
                    "style": {
                        "bold": "normal",
                        "italic": "normal",
                        "color": "#424242",
                        "opacity": "0.9",
                        "fontFamily": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "fontSize": "1"
                    },
                    "show": true
                },
                "button": {
                    "content": ' . json_encode($model['button']['name']) . ',
                    "url": ' . json_encode($model['button']['url']) . ',
                    "content-style": {
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#424242"
                    },
                    "button-style": {
                        "border-width": "1px",
                        "border-style": "solid",
                        "border-color": "#424242"
                    },
                    "classes": [
                        "font-size-1",
                        "line-height-1"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here...",
                    "show": true
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'menu.menu6',
        'migrator' => function ($model) {
            $model = '
            {
                "sticky": true,
                "bg_color": "#fff",
                "opacity": "0.98",
                "bg_color_type": "color",
                "brand": {
                    "src": {
                        "base": ' . json_encode($model['brand']['image']) . '
                    },
                    "url": ' . json_encode($model['brand']['url']) . '
                },
                "links": {
                    "align": "right",
                    "style": {
                        "bold": "normal",
                        "italic": "normal",
                        "color": "#424242",
                        "opacity": "0.9",
                        "fontFamily": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "fontSize": "1"
                    },
                    "show": true
                },
                "button": {
                    "content": ' . json_encode($model['button']['name']) . ',
                    "url": ' . json_encode($model['button']['url']) . ',
                    "content-style": {
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#424242"
                    },
                    "button-style": {
                        "border-width": "1px",
                        "border-style": "solid",
                        "border-color": "#424242"
                    },
                    "classes": [
                        "font-size-1",
                        "line-height-1"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here...",
                    "show": true
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
    array(
        'template_id' => 'menu.menu7',
        'migrator' => function ($model) {
            $model = '
            {
                "sticky": true,
                "bg_color": "#fff",
                "opacity": "0.98",
                "bg_color_type": "color",
                "brand": {
                    "src": {
                        "base": ' . json_encode($model['brand']['image']) . '
                    },
                    "url": ' . json_encode($model['brand']['url']) . '
                },
                "links": {
                    "align": "left",
                    "style": {
                        "bold": "normal",
                        "italic": "normal",
                        "color": "#424242",
                        "opacity": "0.9",
                        "fontFamily": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "fontSize": "1"
                    },
                    "show": true
                },
                "button": {
                    "content": ' . json_encode($model['button']['name']) . ',
                    "url": ' . json_encode($model['button']['url']) . ',
                    "content-style": {
                        "font-family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif",
                        "color": "#424242"
                    },
                    "button-style": {
                        "border-width": "1px",
                        "border-style": "solid",
                        "border-color": "#424242"
                    },
                    "classes": [
                        "font-size-1",
                        "line-height-1"
                    ],
                    "target": "_blank",
                    "placeholder": "Enter link text here...",
                    "show": true
                }
            }
            ';

            return json_decode($model, true);
        }
    ),
);