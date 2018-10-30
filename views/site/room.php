<?php
use app\models\User;

use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = 'ЧАТ';
$this->registerJs('connectToChat('.$roomId.');', \yii\web\View::POS_READY);
?>

<style type="text/css">
</style>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <?= $this->render('_left_menu') ?>
        </div>
        <div class="col-md-10">
            <div class="row" style="overflow-y: scroll; position:fixed; bottom:150px;width: 50%;">
				<section>
					<div id="chat">
						<?php if($messages) : ?>
							<?php foreach($messages as $message) : ?>
								<?php if($message->user_id == Yii::$app->user->identity->id) : ?>
									<div class="from-me" style="left:0;margin-bottom:5px;"><small><?= Yii::$app->user->identity->username ?></small><br /><?= Html::encode($message->message) ?><br /><small><?= $message->create_at ?></small></div><div class="clear"></div>
								<?php else : ?>
									<div class="from-them" style="right:0;margin-bottom:5px;"><small><?= User::findOne($message->user_id)->username ?></small><br /><?= Html::encode($message->message) ?><br /><small><?= $message->create_at ?></small></div><div class="clear"></div>
								<?php endif ?>
							<?php endforeach?>
						<?php endif ?>
					</div>
				</section>
			</div>

    		<span style="display: none;" id="username"><?= (@Yii::$app->user->identity->username) ? : 'какой то левый чел незареганный' ?></span>
			<div class="container">
				<form id="messageForm" action="#" class="form-input-message" style="position:fixed; bottom:100px;width: 50%;" onsubmit="return sendChatMessage();">
					 <input id="message" type="text" class="search input-message" onkeyup="//updateChatTyping()">
					 <input type="submit" class="submit-message" value="Отправить" />
					 <!-- <button id="btnSend" class="submit-message">Отправить</button> -->
				</form>
			</div>
        </div>
    </div>
</div>
    <section class="dialog" id="connectFormDialog">
    </section>
    <section id="messageDialog">
        <ul id="messageList"></ul>

        
    </section>