<?php
$this->widget('ext.yg.WellBlocksCollapsible');
/**
 * @var $this BackendController
 * @var $form \yg\tb\ActiveForm
 * @var Product $model
 */

$this->breadcrumbs = array(
    t('Content') => '/admin/content/',
    t('Slides') => '/admin/content/slide',
    t($model->isNewRecord ? 'New record' : 'Update record'),
);


$form = $this->beginWidget('\yg\tb\ActiveForm', array(
    'id' => 'slide-form',
    'labelColWidth'=>3,
));

?>

        <h3><?= t($model->isNewRecord ? 'New record' : 'Update record') ?></h3>
        <hr/>
<div class="row">
    <div class="col-sm-12">
        <div class="well">
            <h4><?= t('Slide properties') ?></h4>
            <?= $form->textAreaControl($model, 'name', array(
                'multilingual'=>true
            )); ?>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-sm-12">
        <div class="well">
            <h4><?= t('Content') ?></h4>
            <div data-ml-group="Slide_content_multilingual">
                <?php foreach (Lang::getLanguages() as $lang => $langTitle): ?>
                    <?= CHtml::openTag('div', array(
                        'data-ml-language'=>$langTitle,
                        'class'=> $lang == Lang::getDefault() ? '' : 'hidden',
                    )) ?>
                    <?php $this->widget('ext.redactor.ImperaviRedactorWidget', array(
                        'model' => $model,
                        'attribute' => $lang == Lang::getDefault() ? 'content' : 'content_' . $lang,
                        'options' => array(
                            'lang' => Lang::getDefault(),
                            'iframe' => true,
                            'css' => '/themes/ekma/front/css/style.css',
                            'minHeight' => 200,
                            'imageUpload' => '/admin/dashboard/imageUpload',
                            'imageGetJson' => '/admin/dashboard/imageList',
                        ),
                    ));?>
                    <?= CHtml::closeTag('div') ?>
                <?php endforeach; ?>
                <?= $form->error($model, 'content') ?>
            </div>
        </div>
        <?php app()->clientScript->registerScript('Slide_content_multilingual','$.fn.ygMultilang.register(\'[data-ml-group="Slide_content_multilingual"]\',{handlerCssClass: "top-minus-offset"})', CClientScript::POS_READY)?>

        <div class="well">
            <h4><?= t('Pictures') ?></h4>
            <div class="form-group">
                <div class="col-sm-12">
                    <?php $this->widget('upload.widgets.UploadImagesWidget', array(
                        'model' => $model
                    ));?>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $form->actionButtons($model) ?>

<?php $this->endWidget(); ?>

