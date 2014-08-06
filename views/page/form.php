<?php
$this->widget('ext.yg.WellBlocksCollapsible');
/**
 * @var $this BackendController
 * @var $form \yg\tb\ActiveForm
 * @var Product $model
 */

$this->breadcrumbs = [
    t('Content') => '/admin/content/',
    t('Pages') => '/admin/content/page',
    t($model->isNewRecord ? 'New record' : 'Update record'),
];


$form = $this->beginWidget('\yg\tb\ActiveForm', [
    'id' => 'page-form',
    'labelColWidth'=>3,
]);

?>

        <h3><?= t($model->isNewRecord ? 'New record' : 'Update record') ?></h3>
        <hr/>
<div class="row">
    <div class="col-sm-12">
        <div class="well">
            <h4><?= t('Page properties') ?></h4>
            <?= $form->textAreaControl($model, 'name',[
                'multilingual'=>true
            ]); ?>
            <?= $form->textAreaControl($model, 'alias'); ?>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-sm-12">
        <div class="well">
            <h4><?= t('Content') ?></h4>
            <?php $this->widget('\yg\tb\RedactorWidget', [
                'model' => $model,
                'attribute' => 'content',
                'options'=>[
                    'minHeight'=>400,
                    'css' => Config::get('mainCssFile'),
                ],
            ]);?>
        </div>
        <?php app()->clientScript->registerScript('Page_content_multilingual','$.fn.ygMultilang.register(\'[data-ml-group="Page_content_multilingual"]\',{handlerCssClass: "top-minus-offset"})', CClientScript::POS_READY)?>

    </div>
</div>

<?= $form->actionButtons($model) ?>

<?php $this->endWidget(); ?>

