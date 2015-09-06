<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        <div class="img_notification" id="performed"></div>
        <?= Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        <div class="img_notification" id="error"></div>
        <?= Yii::$app->session->getFlash('error'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('warning')): ?>
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        <div class="img_notification" id="warning"></div>
        <?= Yii::$app->session->getFlash('warning'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('info')): ?>
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="info" aria-hidden="true">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        <div class="img_notification" id="info"></div>
        <?= Yii::$app->session->getFlash('info'); ?>
    </div>
<?php endif; ?>