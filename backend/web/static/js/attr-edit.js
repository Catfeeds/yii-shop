/**
 * Created by k on 2016/3/22.
 * scope 属性编辑
 * update 2016/3/22
 */
$(function(){
    attrEdit.init();
});

var attrEdit = {
    init : function(){
        this.on(); //事件绑定
    },
    on : function(){
        var _this = this;
        var body = $('body');
        $('#add-sku').on('click', this.addAttr); //添加SKU属性
        //添加扩展属性
        $('#add-ext').on('click', function(){
            _this.addAttr.call(this, true);
        });
        body.on('click', '.attr-del', this.delAttr); //删除属性
        body.on('click', '.attr-val-edit', function(){
            _this.editAttrVal($(this));
        }); //编辑属性
        
        body.on('click', '#add-attr-val', this.addAttrVal); //添加属性值

        //表单提交
        $('#j_btnSubmit').on('click', function(){
            var validRes = $('#j_formAttrEdit').formValid({
                callback : function(){ //验证通过回调
                    //判断sku属性是否重复
                    var skuAttr = $('#j_skuAttrTab .cate_attr');
                    if(skuAttr.length > 1){
                        var attr1 = skuAttr.eq(0).find('input').val();
                        var attr2 = skuAttr.eq(1).find('input').val();
                        if($.trim(attr1) == $.trim(attr2)){
                            layer.msg('sku属性"'+attr2+'"重复,请修改或删除重复属性',{icon:6});
                            skuAttr.last().find('input').focus();
                            return false;
                        }
                    }

                    //判断扩展属性是否重复
                    var extAttr = $('#j_extAttrTab .cate_attr');
                    if(extAttr.length > 1){
                        var arr = [];
                        extAttr.each(function(){
                            arr.push($.trim($(this).find('input').val()));
                        });
                        var index = _this.findDupIndex(arr);
                        if(index != -1){
                            var txt = extAttr.eq(index).find('input');
                            layer.msg('扩展属性"'+txt.val()+'"重复,请修改或删除重复属性',{icon:6});
                            txt.focus();
                            return false;
                        }
                    }

                    //判断属性值是否为空
                    var flag = true;
                    $('#j_formAttrEdit .u_tab .cate_attr').each(function(){
                        if(!$(this).find('.val i').length){
                            var sel = $(this).find('.value_model_select');
                            if(sel.val() != 3){
                                layer.msg('请编辑属性值',{icon:6});
                                return flag = false;
                            }
                        }
                    });

                    return flag;
                }
            });
            //表单验证
            if(validRes.valid()){
                _this.submit(); //提交
            }
        });
    },
    addAttr : function(isExtend){
        if( isExtend !== true ){
            if( $(this).parents('.attr-box').find( '.table tr' ).length>3 ){
            	layer.msg('销售属性最多设置三种',{icon: 6});
                return false;
            }
        }
        if(isExtend !==true){
        	var html = template('add-attr-sku');
        	$(this).parents('.attr-box').find('.table').append(html);
        }else{
        	var index = $(this).parents('.attr-box').find('.table tr').length;
        	var key =0;
        	if(index!=1)
        	{
        		var last = $(this).parents('.attr-box').find('.table tr:last');
        	        key = parseInt(parseInt(last.attr('attr-index'))+1);
        	}
        	var html = '<tr class="cate_attr" attr-index="'+key+'"><td><input type="text" name="Goods[ext]['+key+'][key]"></td>'
        		+'<td><input type="text" name="Goods[ext]['+key+'][value]"></td>'
        		+'<td><a href="javascript:;" class="attr-del">删除</a></td></tr>';
        	$(this).parents('.attr-box').find('.table').append(html);

        }
    },
    editAttrVal : function(obj){
        var _this = this;
        //自定义类型不可编辑属性值
        if($(obj).parents('tr').find('.value_model_select').val() == 3){
            layer.msg('自定义模式不可编辑',{icon: 6});
            return false;
        }

        var data = {val:[]};
        var val = $(obj).siblings('.val');
        if(val.find('i').length){
            val.find('i').each(function(){
                data.val.push({id:$(this).attr('data-id'), name:$(this).html()});
            })
        }
        layer.open({
            title:'属性值编辑',
            content:template('add-attr-val-html', data),
            btn:['确定','取消'],
            yes:function(){
                var str = '';
                var isEmpty = false;
                var arr = [];
                var inputList = $('#j_curEdit input');
                inputList.each(function(){
                    var v = $.trim(this.value);
                    if(!v){
                        isEmpty = true;
                        $(this).focus();
                        layer.msg('内容不能为空',{icon:6});
                        return false;
                    }
                    arr.push($.trim(v));
                    str += '<i data-id="'+($(this).attr('data-id') || '')+'">'+this.value+'</i>';
                });
                if(isEmpty) return false;
                if(inputList.length > 1){
                    var index = _this.findDupIndex(arr);
                    if(index != -1){
                        var txt = inputList.eq(index);
                        layer.msg('属性值"'+txt.val()+'"重复,请修改或删除重复属性值',{icon:6});
                        txt.focus();
                        return false;
                    }
                }
                val.html(str);
                layer.close(layer.index);
            }
        })
    },
    delAttr : function(){
        $(this).parents('tr').remove();
    },
    addAttrVal : function(){
        $('#j_curEdit').append('<tr><td><input type="text" name="name"></td><td><a href="javascript:;" class="attr-del">删除</a></td></tr>');
    },
    submit : function(){
        sale_attr_allow_img = 0;//允许上传图片的属性个数
        bool = true;
        attr_value = new Array;

        $('#j_formAttrEdit .cate_attr').each(function(){
            signle_value = {};
            signle_value.name = $.trim( $(this).find( 'input[name="name"]' ).val() );
            signle_value.value_model = $.trim( $(this).find( '[name="value_model"]' ).val() );
            signle_value.is_sale = $.trim( $(this).find( '[name="is_sale"]' ).val() );
            
            if( signle_value.is_sale  == '1' ){
                signle_value.is_allow_img = $.trim( $(this).find( '[name="is_allow_img"]' ).val() );

                if( signle_value.is_allow_img == '1' ){
                    if( sale_attr_allow_img>=1 ){
                        alert( '只能设置销售属性中的一个允许上传图片' );
                        bool = false;
                        return false;
                    }else{
                        sale_attr_allow_img +=1;
                    }
                }                
            }else{
                signle_value.is_allow_img = 0;
            }
            signle_value.id = $(this).attr( 'data-id' );
            
            signle_value.value = new Array();
            

            if( signle_value.value_model != '3' ){
                
                if( $(this).find( '.attr_value i' ).length<1 ){
                    
                    alert( '属性值不能少于一个' );
                    bool = false;
                    return false;
                }
                $(this).find( '.attr_value i' ).each(function(){
                    attr_value_name = $(this).text();
                    signle_value.value.push( attr_value_name );
                });              
            }
            
            attr_value.push( signle_value );
            
            
        });
        if( bool == false ){
            $.removeTipsBox();
            return false;
        }
        
        $.ajax({
                url :'/index.php?r=goods/attr/update',
                data:{'attr_value_data' : attr_value ,'cate_id' : cate_id},
                type:'post',
                dataType:'json',
                success:function( msg ){
                    alert( msg.msg );
                    if( msg.status !='1' ){
                         window.location.reload();
                    }
                }
            });
        
    },
    //从数组末尾开始查找,获取数组重复项索引,没找到返回-1;
    findDupIndex : function(arr){
        var index = -1,
            len = arr.length;
        lab : for(var i= 0; i<len-1; i++){
            for(var j=len-1; j>i; j--){
                if(arr[i] == arr[j]){
                    index = j;
                    break lab;
                }
            }
        }
        return index;
    }
};