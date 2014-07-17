<?php
$this->widget('ext.yg.WellBlocksCollapsible');
/**
 * @var $this BackendController
 * @var $form \yg\tb\ActiveForm
 * @var Product $model
 */

$this->breadcrumbs = array(
    t('Content') => '/admin/content/',
    t('News') => '/admin/content/news',
    t($model->isNewRecord ? 'New record' : 'Update record'),
);


$form = $this->beginWidget('\yg\tb\ActiveForm', array(
    'id' => 'news-form',
    'labelColWidth' => 3,
));

?>

<h3><?= t($model->isNewRecord ? 'New record' : 'Update record') ?></h3>
<hr/>
<div class="row">
    <div class="col-sm-12">
        <div class="well">
            <h4><?= t('News properties') ?></h4>
            <?=
            $form->textAreaControl($model, 'name', array(
                'multilingual' => true
            )); ?>
            <?=
            $form->dateControl($model, 'publish_date') ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="well">
            <h4><?= t('Short Content') ?></h4>
            <?php $this->widget('\yg\tb\RedactorWidget', [
                'model' => $model,
                'attribute' => 'short_content',
                'height' => 100
            ]);?>
            <?= $form->error($model, 'short_content') ?>
        </div>


        <div class="well">
            <h4><?= t('Content') ?></h4>
            <?php $this->widget('\yg\tb\RedactorWidget', [
                'model' => $model,
                'attribute' => 'content',
                'height' => 400
            ]);?>
            <?= $form->error($model, 'content') ?>

        </div>
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

