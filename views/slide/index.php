<?php
/** @var Slide $model */
/** @var SlideController $this */

$this->breadcrumbs = array(
    t('Content')=>'/catalog',
    t('List of pages')
);
$countAll = $model->search()->totalItemCount;

$this->widget('ext.yg.GridFilterClearButtons', array(
    'gridId'=>'page-grid',
))

?>

<div class="row">
    <div class="col-sm-12">
        <h3><?php echo t('{n} slide|{n} slides|{n} slides', $countAll); ?></h3>
        <a class="btn btn-success btn-xs" href="/admin/content/slide/create"><span class="glyphicon glyphicon-plus"></span> <?= t('add') ?></a>
        <?php $this->widget('\yg\tb\GridView', array(
                'id' => 'slide-grid',
                'dataProvider' => $model->search(),
                'ajaxUpdate' => false,
                'filter' => $model,
                'columns' => array(
                    array(
                        'name' => 'content',
                        'type' => 'raw',
                        'htmlOptions' => array('encodeLabel' => false),
                    ),
                    array(
                        'name' => 'image_id',
                        'header'=>t('Picture'),
                        'filter'=>false,
                        'type' => 'raw',
                        'value' => function ($slide) {
                            return $slide->defaultUpload ? l(CHtml::image($slide->defaultUpload->thumbUrl(150, 75)), array("/content/slide/update", "id" => $slide->id)) : '';
                        },
                        'htmlOptions' => array('encodeLabel' => false),
                    ),
                    array(
                        'name'=>'enabled',
                        'action'=>'/admin/content/slide/toggle',
                        'class'=>'\yg\tb\CheckboxColumn',
                    ),
                    array(
                        'class' => '\yg\tb\ButtonColumn',
                    ),
                )
            )); ?>
    </div>
</div>