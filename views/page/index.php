<?php
/** @var Product $model */
/** @var ProductController $this */

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
    <div class="col-sm-10 col-sm-offset-1">
        <h3><?php echo t('{n} page|{n} pages|{n} pages', $countAll); ?></h3>
        <a class="btn btn-success btn-xs" href="/admin/content/page/create"><span class="glyphicon glyphicon-plus"></span> <?= t('add') ?></a>
        <?php $this->widget('\yg\tb\GridView', array(
                'id' => 'page-grid',
                'dataProvider' => $model->search(),
                'ajaxUpdate' => false,
                'filter' => $model,
                'columns' => array(
                    array(
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => function ($product) {
                            return l($product->name, array("/content/page/update", "id" => $product->id));
                        },
                        'htmlOptions' => array('encodeLabel' => false),
                    ),
                    array(
                        'class' => '\yg\tb\ButtonColumn',
                    ),
                )
            )); ?>
    </div>
</div>