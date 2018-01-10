<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-24 12:51
 */

/**
 * @var $model frontend\models\User
 */

?>
<?= $this->render('_form', [
    'model' => $model,'attr'=>$attr,'products'=>$products,'checkedSku'=>$checkedSku,'head'=>$head,'jsAttr'=>$jsAttr,'store'=>$store
]);
