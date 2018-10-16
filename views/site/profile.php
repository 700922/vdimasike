<?php

/* @var $this yii\web\View */

$this->title = 'Профиль NAMA';
?>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <?= $this->render('_left_menu') ?>
        </div>
        <div class="col-md-10">
            <h1><?= @$model->username ?></h1>
            <p><?= @$model->password_hash ?></p>
            <p><?= @$model->auth_key ?></p>
            <p><?= @$model->status ?></p>
        </div>
    </div>
</div>
