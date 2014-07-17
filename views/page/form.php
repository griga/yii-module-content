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
            <div data-ml-group="Page_content_multilingual">
                <?php foreach (Lang::getLanguages() as $lang => $langTitle): ?>
                    <?= CHtml::openTag('div', [
                        'data-ml-language'=>$langTitle,
                        'class'=> $lang == Lang::get() ? '' : 'hidden',
                    ]) ?>
                    <?php $this->widget('ext.redactor.ImperaviRedactorWidget', [
                        'model' => $model,
                        'attribute' => $lang == Lang::get() ? 'content' : 'content_' . $lang,
                        'options' => [
                            'lang' => Lang::get() == 'uk' ? 'ua' : Lang::get(),
                            'iframe' => true,
                            'css' => '/themes/ekma/front/css/style.css',
                            'minHeight' => 400,
                            'imageUpload' => '/admin/dashboard/imageUpload',
                            'imageGetJson' => '/admin/dashboard/imageList',
                        ],
                    ]);?>
                    <?= CHtml::closeTag('div') ?>
                <?php endforeach; ?>
                <?= $form->error($model, 'content') ?>
            </div>
        </div>
        <?php app()->clientScript->registerScript('Page_content_multilingual','$.fn.ygMultilang.register(\'[data-ml-group="Page_content_multilingual"]\',{handlerCssClass: "top-minus-offset"})', CClientScript::POS_READY)?>

    </div>
</div>

<?= $form->actionButtons($model) ?>

<?php $this->endWidget(); ?>

