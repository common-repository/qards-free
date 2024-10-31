<?php
// Migrate component models
$migrations = array(
    array(
        'template_id' => 'feature.feature1',
        'migrator' => function ($model) {
            $model['media']['image']['url'] = '';
            unset($model['link']);
            unset($model['layout']['bottom']);
            return $model;
        }
    ),
    array(
        'template_id' => 'feature.feature2',
        'migrator' => function ($model) {
            $model['media']['image']['url'] = '';
            unset($model['link']);
            unset($model['layout']['bottom']);
            return $model;
        }
    ),
    array(
        'template_id' => 'feature.feature3',
        'migrator' => function ($model) {
            $model['media']['image']['url'] = '';
            unset($model['link']);
            unset($model['layout']['bottom']);
            return $model;
        }
    ),
    array(
        'template_id' => 'feature.feature4',
        'migrator' => function ($model) {
            $model['media']['image']['url'] = '';
            unset($model['link']);
            unset($model['layout']['bottom']);
            return $model;
        }
    ),
    array(
        'template_id' => 'feature.feature5',
        'migrator' => function ($model) {
            $model['media']['image']['url'] = '';
            $model['hero']['content'][] = array(
                "tagName" => "p",
                "html" => "<a href=''>Take a Look</a>",
                "style" => array(
                    "color"  => "#11A1EC",
                    "font-family"  => "'Helvetica Neue', Helvetica, Arial, sans-serif"
                ),
                "classes"  => array(
                    "hero",
                    "font-size-4",
                    "line-height-4"
                )
            );
            unset($model['link']);
            unset($model['layout']['bottom']);
            return $model;
        }
    ),
    array(
        'template_id' => 'feature.feature6',
        'migrator' => function ($model) {
            $model['media']['image']['url'] = '';
            $model['hero']['content'][] = array(
                "tagName" => "p",
                "html" => "<a href=''>Take a Look</a>",
                "style" => array(
                    "color"  => "#11A1EC",
                    "font-family"  => "'Helvetica Neue', Helvetica, Arial, sans-serif"
                ),
                "classes"  => array(
                    "hero",
                    "font-size-4",
                    "line-height-4"
                )
            );
            unset($model['link']);
            unset($model['layout']['bottom']);
            return $model;
        }
    ),
    array(
        'template_id' => 'feature.feature7',
        'migrator' => function ($model) {
            $model['media']['image']['url'] = '';
            $model['hero']['content'][] = array(
                "tagName" => "p",
                "html" => "<a href=''>Shopping Center</a>",
                "style" => array(
                    "color"  => "#11A1EC",
                    "font-family"  => "'Helvetica Neue', Helvetica, Arial, sans-serif"
                ),
                "classes"  => array(
                    "hero",
                    "font-size-4",
                    "line-height-4"
                )
            );
            unset($model['link']);
            unset($model['layout']['bottom']);
            return $model;
        }
    ),
    array(
        'template_id' => 'feature.feature8',
        'migrator' => function ($model) {
            $model['media']['image']['url'] = '';
            $model['hero']['content'][] = array(
                "tagName" => "p",
                "html" => "<a href=''>Neighborhoods</a>",
                "style" => array(
                    "color"  => "#11A1EC",
                    "font-family"  => "'Helvetica Neue', Helvetica, Arial, sans-serif"
                ),
                "classes"  => array(
                    "hero",
                    "font-size-4",
                    "line-height-4"
                )
            );
            unset($model['link']);
            unset($model['layout']['bottom']);
            return $model;
        }
    ),
    array(
        'template_id' => 'feature.feature9',
        'migrator' => function ($model) {
            $model['media']['image']['url'] = '';
            unset($model['link']);
            unset($model['layout']['bottom']);
            return $model;
        }
    ),
    array(
        'template_id' => 'feature.feature10',
        'migrator' => function ($model) {
            $model['media']['image']['url'] = '';
            unset($model['link']);
            unset($model['layout']['bottom']);
            return $model;
        }
    ),
    array(
        'template_id' => 'feature.feature11',
        'migrator' => function ($model) {
            $model['media']['image']['url'] = '';
            $model['hero']['content'][] = array(
                "tagName" => "p",
                "html" => "<a href=''>Download</a>",
                "style" => array(
                    "color"  => "#11A1EC",
                    "font-family"  => "'Helvetica Neue', Helvetica, Arial, sans-serif"
                ),
                "classes"  => array(
                    "hero",
                    "font-size-4",
                    "line-height-4"
                )
            );
            unset($model['link']);
            unset($model['layout']['bottom']);
            return $model;
        }
    ),
    array(
        'template_id' => 'feature.feature12',
        'migrator' => function ($model) {
            $model['media']['image']['url'] = '';
            $model['hero']['content'][] = array(
                "tagName" => "p",
                "html" => "<a href=''>Get More</a>",
                "style" => array(
                    "color"  => "#11A1EC",
                    "font-family"  => "'Helvetica Neue', Helvetica, Arial, sans-serif"
                ),
                "classes"  => array(
                    "hero",
                    "font-size-4",
                    "line-height-4"
                )
            );
            unset($model['link']);
            unset($model['layout']['bottom']);
            return $model;
        }
    ),
);