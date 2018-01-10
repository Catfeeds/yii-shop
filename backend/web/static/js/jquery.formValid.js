/*
 * @description: 表单验证插件
 * @author: kuangqj
 * @scope: 全局
 * @create: 2015/5/13 11:20
 * @update: 2016/4/15 11:20
 */

(function($){
    //默认参数设置
    var defaults = {
        //正则验证规则 可自定义添加
        regexp : {
            username : { Exp:/^[\w@.]{3,18}$/, alias:"用户名", error:"用户名为3-18位数字,字母,下划线组成,可以是手机或邮箱" },
            password : { Exp:/^[a-z0-9]{6,18}$/, alias:"密码", error:"密码须为6-18位的数字和字母"},
            //手机
            mobile : { Exp:/^1[3|4|5|7|8][0-9]\d{8}$/, alias:"手机号码", error:"手机号码格式错误" },
            //电话号码 （区号-号码）
            phone : { Exp:/^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/, alias:"电话号码", error:"电话号码格式错误" },
            phoneArea : { Exp:/^\d{3,4}$/, alias:"电话区号", error:"电话区号为3-4个数字" },
            phoneNum : { Exp:/^\d{7,8}$/, alias:"电话号码", error:"电话尾号为7-8个数字" },
            //邮政编码
            postcode : { Exp:/^\d{6}$/, alias:"邮政编码", error:"请填写6位数字的邮政编码" },
            bankCardNum : { Exp:/^\d{12,19}$/, alias:"银行卡号", error:"银行卡号为12-19个数字" },
            url : {Exp:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/, alias:"网址", error:"请输入网址"},
            //邮箱
            email : { Exp:/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/i, alias:"邮箱", error:"邮箱格式不正确" },
            floatNum:{Exp:/^\d+\.?\d*$/, error:"请输入大于0的数字"},
            num : { Exp:/^[1-9]\d*$/, alias:"大于0的整数", error:"请输入大于0的整数" }
        },
        trigger:null,         //可选 触发验证的jq对象 默认为<input>提交按钮
        isAppendTips:true,  //可选 是否往页面输出提示 默认true
        blurValid:false,	//可选 是否开启blur事件验证 默认false, true开启
        preCallback:null,     //触发验证之前执行
        callback:null		//可选 验证通过回调函数
    };

    $.fn.formValid = function(options){
        var opts = $.extend( true, {}, defaults, options );
        var form = $(this);
        var regexp = opts.regexp;

        //需要验证的表单元素
        var selector = "input[type='text'], input[type='password'], input[type='radio'], input[type='file'], input[type='checkbox'], select, textarea";
        var ele = form.find(selector).not(':hidden, :disabled');

        //函数返回的对象
        var resultObj = {
            valid : fnValid, //返回验证函数
            regexp : regexp, //正则表达式
            errorMsg : '' //验证错误提示信息
        };

        //console.log(opts)
        //console.log(regexp)

        //提示信息html
        function tipsHtml(s){
            return '<span class="u_tipsInfo">'+s+'</span>';
        }

        //验证函数
        function valid(obj){
            if( obj.attr('reg') == 'no' || obj[0].disabled || obj.is(":hidden") ||  obj.is("input[type='hidden']") ) return true;
            var optional = parseInt(obj.attr("optional")); //否为选填项
            var relation = parseInt(obj.attr('selOne')); //是否为多选一

            removeTips(obj);

            if(obj.is("input[type='text']") || obj.is("textarea") || obj.is("input[type='password']")){
                //text & textarea & password
                if(isEmpty(obj)){ //为空
                    if(!optional){
                        if(relation){ //验证多选一是否都为空
                            var flag = false;
                            form.find('input[selOne="1"]').each(function(){
                                if(!isEmpty($(this))){
                                    flag = true;
                                    return false;
                                }
                            });
                            if(!flag){
                                tipsEmpty(obj);
                                return false;
                            }
                        }else{
                            //非选填, 非二选一 提示不能为空
                            tipsEmpty(obj);
                            return false;
                        }
                    }
                }else{ //非空
                    if(obj.attr("psw") == "2"){ //确认密码验证
                        if(obj.val() != form.find('input[psw="1"]').val()){
                            tipsError(obj, "两次密码输入不一致");
                            return false;
                        }
                    }
                    var reg = obj.attr("reg");
                    if(reg && regexp[reg]){ //正则验证
                        if(!regexp[reg]["Exp"].test(obj.val())){
                            tipsError(obj, obj.attr('error') || regexp[reg]["error"]);
                            return false;
                        }

                    }
                }
            }else if(obj.is("select") && obj.find(':selected').attr('data-default')){ //select
                var n = obj.attr("alias") || obj.find(':selected').text();
                tipsError(obj, "请选择"+n);
                return false;
            }else if(obj.is("input[type='checkbox']") || obj.is("input[type='radio']")){ //checkbox & radio
                var p = obj.parents(".parentsNode");
                if(p.attr('reg') == 'no') return true;
                if(!p.find(":checked").length){
                    var n = p.attr("alias") || "";
                    tipsError(obj, "请选择"+n);
                    return false;
                }
            }else if(obj.is("input[type='file']")){
                if(!obj.val()){
                    var n = obj.attr("alias") || "";
                    tipsError(obj, "请上传"+n);
                    return false;
                }
            }

            return true;
        }

        //错误提示
        function tipsError(obj, info){
            if(obj.parent().find(".u_tipsInfo").length == 0){
                resultObj.errorMsg = info;
                if(opts.isAppendTips) obj.parent().append(tipsHtml(info));
            }
        }

        //非空验证
        function isEmpty(obj){
            var v = obj.val();
            if(v.replace(/\s+/g,'') == '' || v == obj.attr("def")) return true;
            return false;
        }

        //删除提示信息
        function removeTips(obj){
            obj.parent().find(".u_tipsInfo").remove();
        }

        //提示为空
        function tipsEmpty(obj){
            var reg = obj.attr("reg");
            var n = obj.attr("alias") || '';
            if( regexp[reg] && !n ) n = regexp[reg]["alias"];

            if(obj.parent().find(".u_tipsInfo").length == 0){
                resultObj.errorMsg = n+"不能为空";
                if(opts.isAppendTips) obj.parent().append(tipsHtml(n+"不能为空"));
            }
        }

        //blur验证
        form.on('blur', selector, function(){
            opts.blurValid ? valid($(this)) : removeTips($(this));
        });

        //提交按钮验证
        opts.trigger && opts.trigger.on('click', function(){
            if(opts.preCallback) opts.preCallback();
            return fnValid();
        });
        form.find('input:submit').on('click', function(){
            if(opts.preCallback) opts.preCallback();
            return fnValid();
        });

        function fnValid(){
            var flag = true;
            ele = form.find(selector).not(':hidden, :disabled');
            ele.each(function() {
                flag = valid($(this));

                if(!flag){
                    $(this).focus();
                    return false;
                }
            });
            if(flag){ //验证通过
                if(opts.callback) return opts.callback() && true;
                return true;
            }
            return false;
        }

        return resultObj;
    };

})(jQuery);