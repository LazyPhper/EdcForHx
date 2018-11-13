<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:50:"themes/admin_simpleboot3/admin\project\edcadd.html";i:1540457664;s:72:"G:\PHPTutorial\WWW\hx\public\themes\admin_simpleboot3\public\header.html";i:1540550792;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->


    <link href="/hx/public/themes/admin_simpleboot3/public/assets/themes/<?php echo cmf_get_admin_style(); ?>/bootstrap.min.css" rel="stylesheet">
    <link href="/hx/public/themes/admin_simpleboot3/public/assets/simpleboot3/css/simplebootadmin.css" rel="stylesheet">
    <link href="/hx/public/static/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/hx/public/static/js/layer/skin/default/layer.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        form .input-order {
            margin-bottom: 0px;
            padding: 0 2px;
            width: 42px;
            font-size: 12px;
        }

        form .input-order:focus {
            outline: none;
        }

        .table-actions {
            margin-top: 5px;
            margin-bottom: 5px;
            padding: 0px;
        }

        .table-list {
            margin-bottom: 0px;
        }

        .form-required {
            color: red;
        }
    </style>
    <script type="text/javascript">
        //全局变量
        var GV = {
            ROOT: "/hx/public/",
            WEB_ROOT: "/hx/public/",
            JS_ROOT: "static/js/",
            APP: '<?php echo \think\Request::instance()->module(); ?>'/*当前应用名*/
        };
    </script>
    <script src="/hx/public/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
    <script src="/hx/public/static/js/wind.js"></script>
    <script src="/hx/public/themes/admin_simpleboot3/public/assets/js/bootstrap.min.js"></script>
    <script src="/hx/public/static/js/layer/layer.js"></script>
    <script>
        Wind.css('artDialog');
        Wind.css('layer');
        $(function () {
            $("[data-toggle='tooltip']").tooltip({
                container:'body',
                html:true,
            });
            $("li.dropdown").hover(function () {
                $(this).addClass("open");
            }, function () {
                $(this).removeClass("open");
            });
        });
    </script>
    <?php if(APP_DEBUG): ?>
        <style>
            #think_page_trace_open {
                z-index: 9999;
            }
        </style>
    <?php endif; ?>
<style type="text/css">
	.addbutton{height: 40px;width: 150px;position: absolute;top:15%;left: 65%;background-color:#5FB878;text-align:center;line-height:40px;color:#FFF;}
	.appendbutton{height: 40px;width: 50px;margin-left:10px;margin-top:10px;margin-bottom:10px;background-color:#5FB878;text-align:center;line-height:40px;color:#FFF;}
	.appendbut{height: 40px;margin-left:10px;margin-top:10px;margin-bottom:10px;text-align:center;line-height:40px;color:#FFF;}
	.input-div{width: 100%;float: left;}
	.input-a{margin-left: 20px;}
	.input-div-margin{margin:20px;}
	.input-div-margin-left{margin-left:100px;}
	.input-div-margin-top{margin-top:8px;}
	.floatdiv{float: left;}
	.clear{float: none;
		height: auto;}
	.tabDiv{margin: 20px;}
	.divPosition{position: absolute;right: 50px;}
	.select-input{ height: 34px;
		padding: 6px 12px;
		font-size: 14px;
		line-height: 1.42857143;
		color: #2C3E50;
		margin-left: 13px;
		margin-top: 3px;
		background-color: #fff;
		background-image: none;
		border: 1px solid #dce4ec;
		border-radius: 0;}
	.span-input{
		float: left;
		margin-left: 8%;
	}
	.crf-num{
		margin-bottom: 20px;

	}
</style>
</head>

<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li ><a href="<?php echo url('project/edit'); ?>">项目基本信息</a></li>
			<li class="active"><a href="<?php echo url('project/edcadd'); ?>">项目CRF</a></li>
		</ul>
		<form action="<?php echo url('project/edcaddPost'); ?>" method="post" class="form-horizontal js-ajax-form margin-top-20">
			<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
        <div class="row" style='position: relative;' id="crf">
        	<div class='addbutton' onclick="crfAdd()">+增加事件</div>
	            <div class="col-md-7 col-sm-10 crf-num"  id='project-crf-1' >
	            		<div id='crf-con-1'>
							<div class="form-group">
								<label for="input-name" class="col-sm-2 control-label"><span class="form-required">*</span>事件名称</label>
								<div class="col-md-6 col-sm-10">
									<input class="form-control" id="input-name" type="text" required name="project_event[]" value=""  placeholder="事件名称">
								</div>
							</div>
							<!--增加表格-->
						</div>
	            		
						<div class='input-div input-div-margin'>
							<a class='btn btn-primary input-a' href="javascript:;" onclick="crfTableAdd('project-crf-1')">追加表格</a>
							<a class='btn btn-primary input-a' href="javascript:;" onclick="crfInputAdd('project-crf-1')">追加填空</a>
							<a class='btn btn-primary input-a' href="javascript:;" onclick="crfSelectAdd('project-crf-1')">追加选择</a>
							<a class='btn btn-danger input-a'  href="javascript:;" onclick="crfDel('project-crf-1')">删除事件</a>
						</div>


	                <!-- end div -->
	            </div>


        </div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary js-ajax-submit">保存</button>
					<a class="btn btn-default" href="<?php echo url('project/index'); ?>"><?php echo lang('BACK'); ?></a>
					<!--<a class="btn btn-default" href="<?php echo url('project/edcadd'); ?>">生成CRF</a>-->
				</div>
			</div>
    </form>
	</div>

<!--
 table[table-1-1]  第一个 -1 是第一个事件中 第二个 -1 第一个表格 
 input[input-1-1] 	第一个 -1 是第一个事件中 第二个 -1 第一个填空
 input[select-1-1] 	第一个 -1 是第一个事件中 第二个 -1 第一个选择
-->

	<script src="/hx/public/static/js/admin.js"></script>
</body>
</html>
<script type="text/javascript">

	/*增加事件*/
	function crfAdd()
	{
	    var hhtml=crfcon();
	    $("#crf").append(hhtml);

	}

	/*事件内容*/
	function crfcon(){
        var crf_num=$("#crf").find(".crf-num").length;
        crf_num=crf_num+1;
        // alert(crf_num);
        var crf_id='project-crf-'+crf_num;
        var crf_con='crf-con-'+crf_num;
		var con='<div class="col-md-7 col-sm-10 crf-num"  id="'+crf_id+'" >'+
            '<div id="'+crf_con+'">' +
            '<div class="form-group">' +
            '<label for="input-name" class="col-sm-2 control-label"><span class="form-required">*</span>事件名称</label>' +
            '<div class="col-md-6 col-sm-10">' +
            '<input class="form-control" type="text" name="project_event[]" value=""  placeholder="事件名称">' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class=\'input-div input-div-margin\'>' +
            '<a class=\'btn btn-primary input-a\' href="javascript:;" onclick="crfTableAdd(\''+crf_id+'\')">追加表格</a>' +
            '<a class=\'btn btn-primary input-a\' href="javascript:;" onclick="crfInputAdd(\''+crf_id+'\')">追加填空</a>' +
            '<a class=\'btn btn-primary input-a\' href="javascript:;" onclick="crfSelectAdd(\''+crf_id+'\')">追加选择</a>' +
            '<a class=\'btn btn-danger input-a\' href="javascript:;" onclick="crfDel(\''+crf_id+'\')">删除事件</a>' +
            '</div>' +
            '</div>';
		return con;
    }
    
    /*删除事件*/
	function crfDel(crfId) {
	    //不能删除最后一个事件
        var crf_num=$("#crf").find(".crf-num").length;
        if(crf_num >1 )
		{
            $('#'+crfId).remove();
		}else{
			//
		}


    }

	/*追加表格*/
	function crfTableAdd(crfId)
	{
		var crfId=crfId;
		var conArray= new Array();
        conArray=crfId.split('-');
        //查看是生成的第几个事件 conArray[2] 数字从1 开始 追加表格就是加1
		var table_num=0;
        //table_num 表示有几个 table
        var table_num=$("#"+crfId).find(".table-num").length;
        	table_num=table_num+1;
        //以相同的规则生成 input name
		// crf[1] 第一个1 是第一个事件 第二个1 是 是顺序
		// crf[1]['table_title'][] 表格标题
        // crf[1]['table'][desc][0]
		// crf[1]['table]['type'][0]
		var crf_num=conArray[2];
        // console.log(table_num);
        // console.log(crf_num);
        hhtml=crfTableCon(crf_num,table_num);
		$('#crf-con-'+conArray[2]).append(hhtml);

	}

	/*表格内容*/
	function crfTableCon(crf_num,table_num)
	{
	    var crf_num=crf_num;
	    if(!crf_num)
		{
		    crf_num=1;
		}
	    var table_num=table_num;
        if(!table_num)
        {
            table_num=1;
        }
		var input_name="crf["+crf_num+"][table][desc]["+table_num+"][]";
        var table_name="crf["+crf_num+"][table][name]["+table_num+"]";
		var input_type="crf["+crf_num+"][table][type]["+table_num+"][]";
		var table_sort="crf["+crf_num+"][table][sort]["+table_num+"]";
		//排序问题
		var sort_class="crf-"+crf_num+"-sort";
		var event_sort=$("."+sort_class).length;
		if(!event_sort)
		{
		    event_sort=0;
		}
		event_sort=event_sort+1;
		var input_append=crf_num+","+table_num;
		//tr id 为动态数字
        var tr_id="tr-"+crf_num+"-"+table_num;
        var div_table='table-'+crf_num+"-"+table_num;
	    var contxt='';
	    contxt='<div id="'+div_table+'"><div class="form-group input-div-margin">' +
				'<label  class="col-sm-2 control-label"><span class="form-required">*</span>表格名称</label>' +
				'<div class="col-md-6 col-sm-10">' +
            	'<input type="hidden" class="'+sort_class+'"  name="'+table_sort+'" value="'+event_sort+'">' +
				'<input type="text" class="form-control"  name="'+table_name+'" placeholder="表格名称">' +
				'</div>' +
				'</div>' +
				'<div class="input-div input-div-margin-left table-num" >' +
				'<table>' +
				'<tr id="'+tr_id+'">'+
				'<td><input class="form-control" type="text" name="'+input_name+'">'+
				'<select style="display: inline" name="'+input_type+'">' +
				'<option value="text">文本输入</option>' +
				'<option value="radio_or">两项单选</option>' +
				'<option value="date">时间选择器</option>' +
				'</select>' +
				'</td>' +
				'</tr>' +
				'</table>' +
				'<div class="appendbutton floatdiv" onclick="crfTableAppend('+crf_num+','+table_num+')">追加</div>' +
				'<div class="appendbutton floatdiv" onclick="crfTableDel('+crf_num+','+table_num+')">删除</div>' +
				'<div class="appendbut floatdiv"><a class="btn btn-danger input-a" href="javascript:;" onclick="crfTableDelAll('+crf_num+','+table_num+')">删除表格</a></div>'+
				'</div></div>';
	    return  contxt;

	}
	/*删除表格*/
	function crfTableDelAll(crf_num,table_num) {
        var  div_table="table-"+crf_num+"-"+table_num;
        $('#'+div_table).remove();

    }

	/*表格追加td*/

	 function crfTableAppend(crf_num,table_num) {
        // alert(1);
		 var input_name="crf["+crf_num+"][table][desc]["+table_num+"][]";
         var input_type="crf["+crf_num+"][table][type]["+table_num+"][]";
		 var  tr_id="tr-"+crf_num+"-"+table_num;
       	html='<td><input class="form-control" type="text" name="'+input_name+'">' +
            '<select style="display: inline" name="'+input_type+'">'+
            '<option value="text">文本输入</option>' +
            '<option value="radio_or">两项单选</option>' +
            '<option value="date">时间选择器</option>' +
            '</select>'+
            '</td>';
        $('#'+tr_id).append(html);

    }
    /*表格删除最后一个*/
	function crfTableDel(crf_num,table_num)
	{
        var  tr_id="tr-"+crf_num+"-"+table_num;
		$('#'+tr_id+' td:last-child').remove();
	}

	/*增加填空*/
	function crfInputAdd(crfId)
	{
	    //增加填空
        var crfId=crfId;
        var conArray= new Array();
        conArray=crfId.split('-');
        var crf_num=conArray[2];
		var hhtml=crfInputCon(crfId,crf_num);
        $('#crf-con-'+conArray[2]).append(hhtml);

	}

	/*填空内容*/
	function crfInputCon(crfId,crf_num)
	{
	    var crf_num=crf_num;
	    var input_name="crf["+crf_num+"][input][desc][]";
	    var select_name="crf["+crf_num+"][input][type][]";
        var input_num=$("#"+crfId).find(".input-num").length;
        input_num=input_num+1;
        var div_input='input-'+crf_num+"-"+input_num;
        //排序问题
		var input_sort="crf["+crf_num+"][input][sort][]";
        var sort_class="crf-"+crf_num+"-sort";
        var event_sort=$("."+sort_class).length;
        if(!event_sort)
        {
            event_sort=0;
        }
        event_sort=event_sort+1;
	    var con='';
	    con='<div id="'+div_input+'"><div class="form-group">' +
            '<input type="hidden" class="'+sort_class+'"  name="'+input_sort+'" value="'+event_sort+'">' +
            '<label for="input-name" class="col-sm-2 control-label"><span class="form-required">*</span>填空描述</label>' +
            '<div class="col-md-6 col-sm-10">' +
            '<input class="form-control input-num" type="text" name="'+input_name+'" value="" placeholder="填空描述">' +
			'<div style="display:inline;float: left;"><select name="'+select_name+'"><option value="fill">填空&nbsp;&nbsp;&nbsp;</option><option value="desc">描述&nbsp;&nbsp;</option><option value="date">时间选择器</option></select></div>'+
            '<a class="btn btn-danger"  href="javascript:;" onclick="crfInputDelAll('+crf_num+','+input_num+')">删除填空</a>'+
            '</div>' +
            '</div></div>';
	    return con;
	}

	/*填空删除*/
	function crfInputDelAll(crf_num,input_num) {
        var  div_input="input-"+crf_num+"-"+input_num;
        $('#'+div_input).remove();

    }

    /*增加选择*/
	function crfSelectAdd(crfId) {
        //增加填空
        var crfId=crfId;
        var conArray= new Array();
        conArray=crfId.split('-');
        var crf_num=conArray[2];
        var hhtml=crfSelectCon(crfId,crf_num);
        $('#crf-con-'+conArray[2]).append(hhtml);

    }

	/*选择的内容*/
    function crfSelectCon(crfId,crf_num){
        var crf_num=crf_num;
        var select_name="crf["+crf_num+"][select][]";
        var select_num=$("#"+crfId).find(".select-num").length;
        select_num=select_num+1;
        var div_select='select-'+crf_num+"-"+select_num;
        var input_select_name="crf["+crf_num+"][select][name]["+select_num+"]";
        var input_select_type="crf["+crf_num+"][select][type]["+select_num+"]";
        var input_select_option="crf["+crf_num+"][select][option]["+select_num+"][]";
        var table_select='select-table-'+crf_num+"-"+select_num;
        var con='';
        //排序问题
		var select_sort="crf["+crf_num+"][select][sort]["+select_num+"]"
        var sort_class="crf-"+crf_num+"-sort";
        var event_sort=$("."+sort_class).length;
        if(!event_sort)
        {
            event_sort=0;
        }
        event_sort=event_sort+1;
        	con='<div class="" id="'+div_select+'">' +
                '<div class="form-group">' +
                '<input type="hidden" class="'+sort_class+'"  name="'+select_sort+'" value="'+event_sort+'">' +
                '<label for="input-name" class="col-sm-2 control-label"><span class="form-required">*</span>选择题目描述</label>' +
                '<div class="col-md-6 col-sm-10">' +
                '<input class="form-control" type="text" name="'+input_select_name+'" value=""  placeholder="选择题目描述">' +
                '' +
                '</div>' +
                '\</div>' +
                '\<label for="input-name" class="col-sm-2 control-label"><span class="form-required">*</span>选择类型</label>' +
                '\<div class="col-md-6 col-sm-10">' +
                '<select class="form-control valid" name="'+input_select_type+'"><option value=\'radio\'>单选</option><option value=\'checkbox\'>多选</option></select>' +
                '' +
                '</div>' +
                '<div class="input-div input-div-margin-left input-div-margin-top">' +
                '<table class="input-div-margin-left select-num" id="'+table_select+'">' +
                '<tr>' +
                '<td>' +
                '<span class="span-select">A</span><input class="select-input" style="width: 80%" type="text" name="'+input_select_option+'" value=""  placeholder="选项描述">' +
                '</td>' +
                '<td>' +
                '<a class="btn btn-primary input-a" href="javascript:;" onclick="crfSelectAddoption('+crf_num+','+select_num+')">追加选项</a>' +
                '</td>' +
                '<td>' +
                '<a class="btn btn-danger input-a" href="javascript:;" onclick="crfSelectDeloption('+crf_num+','+select_num+')">删除选项</a>' +
                '</td>' +
                '</tr>' +
                '</table>' +
                '</div>' +
                '<a class=\'btn btn-primary input-a\' href="javascript:;" onclick="crfSelectDel('+crf_num+','+select_num+')">删除选择</a>' +
                '</div>';
        	return con;
	}

	/*删除选择*/
	function crfSelectDel(crf_num,select_num)
	{
        var div_select='select-'+crf_num+"-"+select_num;
        $('#'+div_select).remove();

	}
	/*增加选择选项*/
	function crfSelectAddoption(crf_num,select_num) {
        var select_id='select-table-'+crf_num+"-"+select_num;
        var tr_num=$("#"+select_id).find(".select-input").length;
        var sort=selectSort(tr_num);
        var input_select_option="crf["+crf_num+"][select][option]["+select_num+"][]";
		var hhtml=  '<tr>' +
					'<td>' +
					'<span>'+sort+'</span><input class="select-input" style="width: 80%" type="text" name="'+input_select_option+'" value=""  placeholder="选项描述">' +
					'</td>' +
					'</tr>';
		$('#'+select_id).append(hhtml);

    }
    /*删除选择选项*/
    function crfSelectDeloption(crf_num,select_num) {
        var select_id='select-table-'+crf_num+"-"+select_num;
        var tr_num=$("#"+select_id).find(".select-input").length;
        if(tr_num > 1)
		{
            $('#'+select_id+' tr:last-child').remove();
		}
    }

    /*字母增加*/
	function selectSort(num)
	{
	    var new_array=new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	    return new_array[num];

	}

</script>