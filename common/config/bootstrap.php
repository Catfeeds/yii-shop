<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@app', dirname(dirname(__DIR__)) . '/app');
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@feehi', dirname(dirname(__DIR__)) . '/feehi');
Yii::setAlias('@image', dirname(dirname(__DIR__)) . '/image');//图片路径
Yii::setAlias('@ueditor', '@image/ueditor');//编辑器资源上传目录