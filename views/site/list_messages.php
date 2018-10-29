<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'ЧАТ';
// var_dump($list);die;
?>
<div class="container  wrap">
    <div class="row">
        <div class="col-md-2">
            <?= $this->render('_left_menu') ?>
        </div>
        <div class="col-md-8"><span style="display: none;" id="username"><?= (@Yii::$app->user->identity->username) ? : 'какой то левый чел незареганный' ?></span>
        <?php if ($list) : ?>
            <?php foreach ($list as $key) : ?>
                    <a href="room?id=<?= $key->id ?>"><div class="panel panel-default" style="margin-bottom: 0px;">
                        <div class="panel-body">
                            <?= $key->name ?>
                        </div>
                    </div></a> 
            <?php endforeach ?>
        <?php endif ?>
        </div>
        <?php $form = ActiveForm::begin(['class'=>'m-t-10'])?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Название комнаты'])->label(false) ?>
            <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>
            <div class="form-group text-center">
                <?= Html::submitButton('Создать комнату',['class' => 'btn btn-danger btn-lg']) ?>
            </div>
            <?php ActiveForm::end();?>
    </div>
</div>

