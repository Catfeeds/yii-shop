<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="header">
    <div class="head-top">
        <div class="nb">
            {$diy_indexheader}
            <div class="rside" style='float:right'>
                <ul class="head-ul">
                    {if $ym_uname!=''}
                    <li><a href="../user.html">{$ym_uname}</a></li>
                    <li><a href="../user.html?act=logout">退出</a></li>
                    {else}
                    <li><a href="../login.html">登录</a></li>
                    <li><a href="../reg.html">注册</a></li>
                    {/if}
                    <li><a href="../myorder.html">我的订单</a></li>
                    <li><a href="../user.html">会员中心</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="head-bot">
        <div class="nb">
            <div class="web-title-container">
                <a href="../index.html" class="logo"><img src="../{$ym_logo}" alt=""/></a>
                <div class="searchbox">
                    <form name="search" action="../list.html" method="get">
                        <input type="search" name="word" id="word" value="{$word}" placeholder="请输入关键词" class="txt-search"/>
                        <input type="submit" value="搜&nbsp;&nbsp;索" id="btn-search" class="btn-submit"/>
                        <input type="hidden" name="action" value="list" />
                    </form>
                </div>
                <div class="cartbox">
                    <div class="cartbtn">
                        <a href="../cart.html" class="radv-nav"><span>购物车</span>(<span class="cartinfo">{$ym_cnum}</span>)</a>
                    </div>
                    <div class="cart-slidedownbox">
                        <h3>最近加入</h3>
                        <ul class="cart-slidedown" id="cart-list">
                            <li id="[goods_id]" data-spec = "[spec_ids]">
                                <div class="cart-pro">
                                    <a href="[url]" class="pic-box"><img src="[thumb]" alt="60*60"></a>
                                    <div class="cart-pro-num elli">
                                        <a href="[url]">[name]</a>
                                    </div>
                                    <div class="close-price">
                                        <button class="close delgoods"></button>
                                        <p class="red">￥[price]x[num]</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="sum-box">
                            <a class="slidecart-js" href="../cart.html">立即结算(<span class="cartinfo">0</span>)</a>
                            <div class="sum">合计：￥<span class="red" id="cart-total">0.00</span></div>
                            <div class="check">
                                <p>共<span class="red cartinfo">0</span>件商品</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="nav">
                <div class="nav-classify">
                    <h3 class="nav-all-btn">全部分类</h3>
                    <ul class="menu-mainnav" style="height: 450px;">
                        <?php if($this->params['category']) : ?>
                            <?php foreach ($this->params['category'] as $k1 => $v1) : ?>
                        <li>
                            <div class="sortmaintitle">
                                <a href="<?= url(['category/index','id'=>$v1['id']]) ?>" target="_blank"><?= $v1['name'] ?></a>
                            </div>
                            <div class="navsonbox">
                                <div class="nr">
                                    <div class="navson-classify">
                                        <?php if($v1['child'] && !empty($v1['child'])) : ?>
                                            <?php foreach ($v1['child'] as $k2 => $v2) : ?>
                                        <div class="navson-classify-box">
                                            <h3 class="maintitle"><a href="<?= url(['category/index','id'=>$v2['id']]) ?>" target="_blank"><?= $v2['name'] ?><span>&gt;</span></a></h3>
                                            <div class="navson-classify-subtitle">
                                                <?php if(isset($v2['child']) && is_array($v2['child'])) : ?>
                                                    <?php foreach ($v2['child'] as $k3 => $v3) : ?>
                                                <a href="<?= url(['category/index','id'=>$v3['id']]) ?>" target="_blank"><?= $v3['name'] ?></a>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <ul class="nav-othder">
                    <li><a href="../index.html">首页</a></li>
                    <!--{loop $nav $p}-->
                    <li><a href="{$p[url]}" {if $p['target']==1}target="_blank"{/if}>{$p[name]}</a></li>
                    <!--{/loop}-->
                </ul>
            </div>
        </div>
    </div>
</div>
        <?= $content ?>
<div class="footer">
    <div class="nb">
        {$diy_indexfoot}
        <div class="foot-navson">
            <div class="navsonbox">
                <!--{loop $help $p}-->
                <dl>
                    <dt><a href="{$p['url']}" target="_blank">{$p['name']}</a></dt>
                    <!--{loop $p['son'] $v}-->
                    <dd><a href="{$v[url]}" target="_blank">{$v[name]}</a></dd>
                    <!--{/loop}-->
                </dl>
                <!--{/loop}-->
            </div>
            <div class="foot-service">
                <p>客服电话</p>
                <div class="tel">0755-888888888</div>
                <a href="http://wpa.qq.com/msgrd?v=3&uin=123456789&site=qq&menu=yes" target="_blank" class="btn-service">在线客服</a>
            </div>
        </div>
        <div class="foot-sortnav">
            <div class="box"><a href="/" target="_blank">首页</a></div>
            <!--{loop $nav_footer $p}-->
            <div class="box"><a href="{$p[url]}" {if $p['target']==1}target="_blank"{/if}>{$p[name]}</a></div>
            <!--{/loop}-->
        </div>
        {if $link2}
        <div class="foot-sortnav">
            <!--{loop $link $p}-->
            <a href="{$p[url]}" {if $p['target']==1}target="_blank"{/if}>
            <img src="{$p['img']}" width="120" height="60"/>
            <br />
            {$p['title']}</a>
            <!--{/loop}-->
        </div>
        <!--{/if}-->
        <div class="copyright">
            <p>{$diy_copyright}</p>
        </div>
    </div>
</div>
<p style="display: none;">{if $ym_site_statice}{$ym_site_statice}{/if}</p>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
