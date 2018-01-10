/**
 * Created by k on 2016/3/23.
 * scope 商品上传
 * update 2016/3/23
 */
$(function(){
    addGoods.init();
});

var addGoods = {
    init : function(){
        this.$wrap = $('#j_formAddGoods');
        this.$tbAttrWrap = $('#j_tbAttrWrap');
        this.$tbAttr = this.$tbAttrWrap.find('table');
        this.attrData = {}; //保存属性表对应数据

        this.createAttrData(); //初始化属性表数据结构
        this.on(); //事件绑定
        //console.log(this.attrData)

        this.$wrap.formValid({
            trigger:$('#j_submit'),
            callback:function(){

            }
        });
    },
    on : function(){
        var _this = this;
        //商品类型选择
        $('#j_gType').on('change', function(){
            if($(this).val() != 1){
                $('#j_boxBsq').show();
            }else{
                $('#j_boxBsq').hide();
            }
        });

        //SKU属性change 创建属性表DOM
        this.$wrap.on("change", ".multi_select :checkbox", function(){
            _this.createAttrTb();
        });
        //属性表文本框blur保存数据
        this.$wrap.on("blur", "#j_tbAttrWrap .txt", function(){
            _this.saveTrAttrData( $(this).parents("tr") );
        });

        //商品图片位移
        var albumList = $('#j_albumList');
        albumList.on('click', '.left, .right', this.imgMove);
        //商品图片删除
        albumList.on('click', '.del', function(){
            $(this).parents('li').find('span').html('<b>+</b>上传图片');
        })
    },
    //生成SKU属性表DOM结构
    createAttrTb : function(){
        /*var json = [
         { attr:"颜色", name:["红色","白色"], val:["1","2"]},
         { attr:"尺寸", name:["L","M"], val:['a','b']},
         ];*/
        var _this = this;
        var json = [];	//保存选中的属性,名,值
        var flag = true;
        this.$wrap.find(".multi_select").each(function() {
            var checked = $(this).find(":checked");
            if(!checked.length){ //必须选择全部销售属性才生成属性表
                flag = false;
                return false;
            }
            var temp = {
                attr:$(this).find('.lab').text().replace(/:|：/g,''),
                name:[],
                val:[]
            };
            checked.each(function() {
                temp.name.push( $(this).parent().text() );
                temp.val.push( this.value );
            });
            json.push(temp);
        });
        if(!flag){ //没有选择全部销售属性
            this.$tbAttrWrap.hide();
            return false;
        }
        this.$tbAttrWrap.show();

        var arrName = [], //合并的属性名
            arrVal = [], //合并的属性值
            th = '';
        $.each(json, function(i){
            th += '<th width="12%" class="newMultiAttr">'+json[i].attr+'</th>';
            arrName.push(json[i].name);
            arrVal.push(json[i].val);
        });
        this.$tbAttr.find(".newMultiAttr").remove();
        this.$tbAttr.find("thead tr").prepend(th);

        var firstAttrNameArr =  arrName[0]; //第一个属性值数组

        var arrID = this.combArr(arrVal); //组合checkbox的value作为tr的id

        var arrNameComb = this.combArr(arrName); //得到属性名的所有组合
        var resArr = [];

        //拆分组合得到最终属性名数组
        $.each(arrNameComb, function(i){
            var temp = arrNameComb[i].split('_');
            resArr.push(temp);
        });
        //console.log(arrNameComb);
        var otherItemLen = resArr[0].length,
            rowspan = resArr.length/firstAttrNameArr.length, //合并行数量
            tbody = '', k = 0;
        $.each(resArr, function(i){
            var row = '', td = '';
            if( i%rowspan == 0 ){
                row = '<td rowspan="'+rowspan+'">'+firstAttrNameArr[k]+'</td>';
                k++;
            }else{
                row = '';
            }

            for(var j = 1; j<otherItemLen; j++){
                td += '<td>'+resArr[i][j]+'</td>';
            }
            tbody += _this.attrTr(arrID[i], row+td);
        });

        this.$tbAttr.find("tbody").html(tbody);
    },
    /**
     * @description: 将多个数组的所有组合合并为一个数组
     * @param: arr 待合并的数组集合
     * @return: 返回合并后的数组
     * @example: combArr([["XXL","XL"], ["红色","白色"]]) return: [["XXL,红色","XL,红色","XXL,白色","XL,白色"]];
     */
    combArr : function(arr){
        var len = arr.length;
        if(len>=2){
            var len1=arr[0].length,
                len2=arr[1].length,
                temp=[], index=0, i=0, j=0;
            for(i=0;i<len1;i++){
                for(j=0;j<len2;j++){
                    temp[index]=arr[0][i]+'_'+arr[1][j];
                    index++;
                }
            }
            arr.splice(0,2,temp);
            return arguments.callee(arr);
        }else{
            return arr[0];
        }
    },
    /**
     * @description: 返回一行属性表
     * @param: id 此行属性id
     * @param: row 合并的单元格
     */
    attrTr : function(id, row){
        if(!this.attrData[id].length){
            //属性表默认值
            this.attrData[id] = ['', '', '', '']
        }
        return '<tr id="'+id+'">'+row+
                '<td><input type="text" class="txt" value="'+this.attrData[id][0]+'" /></td>'+
                '<td><input type="text" class="txt" value="'+this.attrData[id][1]+'" /></td>'+
                '<td><input type="text" class="txt" value="'+this.attrData[id][2]+'" /></td>'+
                '<td><input type="text" class="txt" value="'+this.attrData[id][3]+'" /></td>'+
            '</tr>';
    },
    /**
     * @description: 属性表文本框blur事件处理函数 保存数据
     * @param: tr 属性表tr对象
     */
    saveTrAttrData : function(tr){
        var arr = [],
            id = tr.attr('id');
        tr.find('.txt').each(function() {
            arr.push(this.value);
        });
        this.attrData[id] = arr;
    },
    /**
     * @description: 生成SKU属性表数据
     */
    createAttrData : function(json){
        var sku = $(".multi_select");
        if(!sku.length) return;
        this.attrData = {};
        var zuhArr = [];
        sku.each(function(i) {
            var temp = [];
            $(this).find(":checkbox").each(function() {
                temp.push(this.value);
            });
            zuhArr.push(temp);
        });

        var resArr = this.combArr(zuhArr), i;

        for(i = 0; i<resArr.length; i++){
            if(json){
                this.attrData[resArr[i]] = json[resArr[i]] ? json[resArr[i]] : [];
            }else{
                this.attrData[resArr[i]] = [];
            }
        }
    },
    //商品图片位移
    imgMove : function(){
        var curLi = $(this).parents('li');
        var changeLi;
        if($(this).hasClass('left')){
            changeLi = curLi.prev();
        }else{
            changeLi = curLi.next();
        }
        var curImg = curLi.find('span');
        var prevImg = changeLi.find('span');
        changeLi.find('.u_upload').prepend(curImg);
        curLi.find('.u_upload').prepend(prevImg);
    }
};


