<?php

namespace common\helpers;

use Yii;

/**
 * Html provides a set of static methods for generating commonly used HTML tags.
 *
 * Nearly all of the methods in this class allow setting additional html attributes for the html
 * tags they generate. You can specify for example. 'class', 'style'  or 'id' for an html element
 * using the `$options` parameter. See the documentation of the [[tag()]] method for more details.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Html extends \yii\helpers\BaseHtml
{
    /**
     * ---------------------------------------
     * 生成 图片路径
     * @param string $url 图片相对路径，一般为“201605/1235654.jpg”
     * @param string $params 生成链接时的附加测试，例如长宽等
     * @param bool $isUrl 是否生成php文档形式的url
     * @return string
     * ---------------------------------------
     */
    public static function src($url,$params = '',$isUrl = false){
        if ($isUrl === false) {
            return Yii::$app->params['upload']['url'].$url;
        }
        $query = 'path='.$url;
        if ($params) {
            $query .= '&'.$params;
        }
        if (Yii::$app->params['storage_encrypt']) {
            $query = 'path='.base64_encode($query);

        }
        return Yii::getAlias('@storageUrl').'/index.php?'.$query;
    }

   
}
