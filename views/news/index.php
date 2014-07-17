<?php
/** @var News|MultilingualBehavior $model */
/** @var NewsController $this */

$this->breadcrumbs = array(
    t('News')=>'/admin/news',
    t('All news')
);
$countAll = $model->search()->totalItemCount;

$this->widget('ext.yg.GridFilterClearButtons', array(
    'gridId'=>'page-grid',
))

?>

<div class="row">
    <div class="col-sm-12">
        <h3><?php echo t('{n} news|{n} news|{n} news', $countAll); ?></h3>
        <a class="btn btn-success btn-xs" href="/admin/content/news/create"><span class="glyphicon glyphicon-plus"></span> <?= t('add') ?></a>
        <?php $this->widget('\yg\tb\GridView', array(
                'id' => 'slide-grid',
                'dataProvider' => $model->multilang()->search(),
                'ajaxUpdate' => false,
                'filter' => $model,
                'columns' => array(
                    array(
                        'name' => 'name',
                    ),
                    array(
                        'name' => 'image_id',
                        'header'=>t('Picture'),
                        'filter'=>false,
                        'type' => 'raw',
                        'value' => function ($data) {
                            return $data->defaultUpload ? l(CHtml::image($data->defaultUpload->thumbUrl(75, 75)), array("/content/news/update", "id" => $data->id)) : '';
                        },
                        'htmlOptions' => array('encodeLabel' => false),
                    ),
                    array(
                        'name'=>'enabled',
                        'action'=>'/admin/content/news/toggle',
                        'class'=>'\yg\tb\CheckboxColumn',
                    ),
                    array(
                        'class' => '\yg\tb\ButtonColumn',
                    ),
                )
            )); ?>
    </div>
</div>