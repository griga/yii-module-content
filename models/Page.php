<?php
/** Created by griga at 18.06.2014 | 21:32.
 * 
 */

class Page extends Content {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function defaultScope(){
        return array(
            'condition'=>"type=".self::TYPE_PAGE,
        );
    }


} 