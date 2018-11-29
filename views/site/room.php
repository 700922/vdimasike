<?php
use app\models\User;

use yii\helpers\Html;
use app\models\Rooms;


/* @var $this yii\web\View */

$this->title = 'ЧАТ';
$this->registerJs('connectToChat('.$roomId.');', \yii\web\View::POS_READY);
?>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/chat.css">
<span style="display: none;" id="username"><?= (@Yii::$app->user->identity->username) ? : 'какой то левый чел незареганный' ?></span>
<div class="container">
    <div class="row">
        <div class="col-md-2"  style="border:1px solid #aaa; background-color:white; ">
            <?= $this->render('_left_menu') ?>
        </div>
        <div class="col-md-7">
            <div class="row">
				<div class="col-xs-12">
					<div class="chat-history" style="border:1px solid #aaa; background-color:white; ">
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
						<section class="dialog" id="connectFormDialog"></section>
						<section id="messageDialog"><ul id="messageList"></ul></section>
					</div>
					<form id="messageForm" action="#" class="form-input-message" onsubmit="return sendChatMessage();" style="border:1px solid #aaa; border-top:0;">
						 <input id="message" type="text" class="search input-message" onkeyup="//updateChatTyping()" style="border:0;" placeholder="Напишите сообщение..." autocomplete="off">
						 <input type="submit" class="submit-message" value="Отправить" />
						 <!-- <button id="btnSend" class="submit-message">Отправить</button> -->
					</form>
				</div>
			</div>

				
        </div>
        <div class="col-md-3" style="border:1px solid #aaa; background-color:white; ">
	        <div   style="margin-top:15px;">
	        	<?php if ($list = Rooms::getList(Yii::$app->user->identity->id)) : ?>
	            <?php foreach ($list as $key) : ?>
	                    <a href="room?id=<?= $key->id ?>" class="chat-rooms-words"><div class="panel panel-default chat-rooms">
	                        <div class="panel-body">
	                            <?= $key->name ?>
	                        </div>
	                    </div></a> 
	            <?php endforeach ?>
	        <?php endif ?>
	        </div>
        </div>
    </div>
</div>

