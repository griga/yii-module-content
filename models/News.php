<?php

/** Created by griga at 23.06.2014 | 19:38.
 *
 */
class News extends Content
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function defaultScope()
    {
        return [
            'condition' => "type=" . self::TYPE_NEWS,
        ];
    }

    /**
     * return behaviors of component merged with parent component behaviors
     * @return array CBehavior[]
     */

    public function behaviors()
    {
        return CMap::mergeArray(
            parent::behaviors(),
            [
                'upload' => [
                    'class' => 'upload.components.UploadBehavior',
                    'folder' => 'news',
                    'defaultUploadField' => 'image_id',
                ],
                'linkable' => [
                    'class' => 'LinkableBehavior',
                    'urlPath'=>'/news/',
                    'urlAttribute'=>'alias',
                ]
            ]);
    }

} 