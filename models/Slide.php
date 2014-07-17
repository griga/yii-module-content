<?php
/** Created by griga at 18.06.2014 | 21:32.
 * 
 */

class Slide extends Content {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function defaultScope(){
        return array(
            'condition'=>"type=".self::TYPE_SLIDE,
        );
    }

    /**
     * return behaviors of component merged with parent component behaviors
     * @return array CBehavior[]
     */

    public function behaviors(){
    	return CMap::mergeArray(
    		parent::behaviors(),
    		array(
//                'upload'=>array(
//                    'class'=>'upload.components.UploadBehavior',
//                    'folder'=>'slides',
//                    'defaultUploadField'=>'image_id',
//                ),
    	));
    }

    public function getFrontApiAttributes(){
        return array(
            'id'=>$this->id,
            'name'=>$this->name,
            'content'=>$this->content,
            'image'=>$this->defaultUpload->filename,
        );
    }



} 