<?php

/**
 * This is the model class for table "{{content_article}}".
 *
 * The followings are the available columns in table '{{content_article}}':
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property string $alias
 * @property integer $enabled
 * @property string $content
 * @property string $short_content
 * @property integer $parent_id
 * @property string $create_time
 * @property string $update_time
 * @property string $publish_date
 */
class Content extends CrudActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{content}}';
    }

    const TYPE_PAGE = 1;
    const TYPE_NEWS = 2;
    const TYPE_ARTICLE = 3;
    const TYPE_SLIDE = 4;

    public function getContentTypes()
    {
        return [
            self::TYPE_PAGE => 'Page',
            self::TYPE_NEWS => 'News',
            self::TYPE_ARTICLE => 'Article',
            self::TYPE_SLIDE => 'Slide',
        ];
    }

    public function getClassByType($type)
    {
        $types = $this->getContentTypes();
        return $types[$type];
    }

    public function getTypeByClass($class)
    {
        $types = $this->getContentTypes();
        $classes = array_values($types);
        $types = array_keys($types);
        return $types[array_search($class, $classes)];
    }

    /**
     * We're overriding this method to fill findAll() and similar method result
     * with proper models.
     *
     * @param array $attributes
     * @return Content
     */
    protected function instantiate($attributes)
    {
        $class = $this->getClassByType($attributes['type']);
        $model = new $class(null);
        return $model;
    }


    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['name','required'],
            ['enabled, parent_id', 'numerical', 'integerOnly' => true],
            ['name, alias', 'length', 'max' => 255],
            ['content, short_content, create_time, update_time', 'safe'],
            ['publish_date','date','format'=>'MM/dd/yyyy'],
            ['id, name, alias, enabled, content, short_content, parent_id, create_time, update_time, publish_date', 'safe', 'on' => 'search'],
        ];
    }

    protected function afterValidate()
    {
        if($this->publish_date){
            $dateParts = explode('/', $this->publish_date);
            $this->publish_date = $dateParts[2] . '-' . $dateParts[0] . '-' . $dateParts[1];
        }
        parent::afterValidate();
    }

    protected function afterFind()
    {

        parent::afterFind();
    }


    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => t('Name'),
            'alias' => t('Alias'),
            'enabled' => t('Enabled'),
            'content' => t('Content'),
            'short_content' => t('Short Content'),
            'parent_id' => t('Parent'),
            'create_time' => t('Create Time'),
            'update_time' => t('Update Time'),
            'publish_date' => t('Publish Date'),
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->with = array('defaultUpload');

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('enabled', $this->enabled);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('short_content', $this->short_content, true);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Content|MultilingualBehavior the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeValidate()
    {
        $childClass = get_called_class();
        $this->type = $this->getTypeByClass($childClass);
        return parent::beforeValidate();
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
                'aliasBehavior'=>array(
                    'class'=>'AliasBehavior',
                    'sourceAttribute'=>'name',
                    'aliasAttribute'=>'alias',
                ),
                'ml' => [
                    'class' => 'MultilingualBehavior',
                    'langTableName' => 'content_lang',
                    'langForeignKey' => 'entity_id',
                    'localizedAttributes' => [
                        'name',
                        'content',
                        'short_content',
                    ],
                    'languages' => Lang::getLanguages(), // array of your translated languages. Example : ['fr' => 'Français', 'en' => 'English')
                    'dynamicLangClass' => true,
                ],
                'upload'=>[
                    'class'=>'upload.components.UploadBehavior',
                    'folder'=>'content',
                    'defaultUploadField'=>'image_id',
                ],
            ]);
    }
}
