<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 border-black ">
                <h1><?= Html::encode($this->title) ?></h1>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    
                ]); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group">
                            <?= Html::submitButton('Войти', ['class' => 'btn btn-yellow f-s-16', 'name' => 'login-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>  
        </div>
    </div>
</div>