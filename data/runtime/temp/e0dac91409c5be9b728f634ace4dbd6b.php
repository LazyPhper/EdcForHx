<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:48:"themes/admin_simpleboot3/admin\project\edit.html";i:1540979019;s:72:"G:\PHPTutorial\WWW\hx\public\themes\admin_simpleboot3\public\header.html";i:1540550792;}*/ ?>
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
</head>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li ><a href="<?php echo url('project/index'); ?>">项目列表</a></li>
			<li class="active"><a href="">编辑项目</a></li>
			<li ><a  href="<?php echo url('project/project_crf',['project_id'=>$project_info['id']]); ?>">项目CRF</a></li>
			<li  ><a href="<?php echo url('project/ruleedit',['project_id'=>$project_info['id']]); ?>">编辑规则</a></li>
		</ul>
		<form action="<?php echo url('project/editPost'); ?>" method="post" class="form-horizontal js-ajax-form margin-top-20">
        <div class="row">
			<input  type="hidden" name="project_id" value="<?php echo $project_info['id']; ?>" />
            <div class="col-md-7">
            	<h1 style='font-size: 14px;color:#66CCCC;margin-left: 20px;'>研究项目的描述和状态</h1>
                <table class="table table-bordered">
                    <tr>
                        <th>项目编号<span class="form-required">*</span></th>
                        <td>
                            <input class="form-control" type="text" name="post[project_sn]"
                                   id="project_sn" required value="<?php echo $project_info['project_sn']; ?>" placeholder="请输入项目编号"/>
                        </td>
                    </tr>
                    <tr>
                        <th>项目名称<span class="form-required">*</span></th>
                        <td>
                            <input class="form-control" type="text" name="post[project_name]"
                                   id="project_name" required value="<?php echo $project_info['project_name']; ?>" placeholder="请输入项目名称"/>
                        </td>
                    </tr>
                 
                    <tr>
                        <th>项目摘要</th>
                        <td>
                            <textarea class="form-control" name="post[project_abstract]" style="height: 50px;"
                                      placeholder="请填写摘要"><?php echo $project_info['project_abstract']; ?></textarea>
                        </td>
                    </tr>

                     <tr>
                        <th>合作者</th>
                        <td>
                            <input class="form-control" type="text" name="post[partner]"  value="<?php echo $project_info['partner']; ?>"
                                   placeholder="请输入合作者">
                            <p class="help-block">多合作者之间用英文逗号隔开</p>
                        </td>
                    </tr>

                     <tr>
                        <th>主要研究者</th>
                        <td>
                             <select class="form-control" name="post[project_student]" >
								 <?php if(is_array($admin_y) || $admin_y instanceof \think\Collection || $admin_y instanceof \think\Paginator): if( count($admin_y)==0 ) : echo "" ;else: foreach($admin_y as $key=>$vv): ?>
									 <option value="<?php echo $vv['id']; ?>" <?php if($project_info['project_student']==$vv['id']){ echo 'selected';} ?> ><?php echo $vv['user_login']; ?></option>
								 <?php endforeach; endif; else: echo "" ;endif; ?>
                               
                            </select>
                        </td>
                    </tr>

                      <tr>
                        <th>负责人</th>
                        <td>
                              <select class="form-control" name="post[project_charge]" >
								  <?php if(is_array($admin_f) || $admin_f instanceof \think\Collection || $admin_f instanceof \think\Paginator): if( count($admin_f)==0 ) : echo "" ;else: foreach($admin_f as $key=>$vv): ?>
									  <option value="<?php echo $vv['id']; ?>" <?php if($project_info['project_charge']==$vv['id']){ echo 'selected';} ?> ><?php echo $vv['user_login']; ?></option>
								  <?php endforeach; endif; else: echo "" ;endif; ?>
                               
                            </select>
                        </td>
                    </tr>

                     <tr>
                        <th>研究项目分期</th>
                        <td>
                             <select class="form-control" name="post[stage]" >
                                <option value="1">无</option>
                                <option value="2">第一阶段</option>
                                <option value="3">第二阶段</option>
                                <option value="4">第四阶段</option>
                                <option value="5">第四阶段</option>
                            </select>
                        </td>
                    </tr>
                  
                    <tr>
                        <th>研究项目开始日期</th>
                        <td>
                            <input class="form-control js-date" type="text" name="post[start_time]"
                                   value="<?php echo $project_info['start_time']; ?>">
                        </td>
                    </tr>
                     <tr>
                        <th>研究项目完成日期</th>
                        <td>
                            <input class="form-control js-date" type="text" name="post[end_time]"
                                   value="<?php echo $project_info['start_time']; ?>">
                        </td>
                    </tr>


					<tr>
                        <th>目的</th>
                        <td>
                            <select class="form-control" name="post[project_objective]" >
                                <option value="1">自然史</option>
                                <option value="2">筛选</option>
                                <option value="3">心理学</option>
                            </select>
                        </td>
                    </tr>

                     <tr>
                        <th>时限</th>
                        <td>
                              <select class="form-control" name="post[project_timelimit]" >
                                <option value="1">回顾的</option>
                                <option value="2">预期的</option>
                            </select>
                        </td>
                    </tr>
                </table>

                <div>您必须展开每个部分并填写所需的字段。如果你不填写每个部分所需的字段，你的数据将不被保存，你将不得不重新编辑研究。</div>

            <!-- 条件和资格 -->
      	<div style='font-size: 14px;color:#66CCCC;margin:20px 0 20px 20px;width: 100%' onclick="tableOnclick('project-condition')"><p id='project-condition-show' style='display:inline'>+</p>&nbsp;&nbsp;&nbsp;条件和资格</div>
      		<div id='project-condition' style='display: none'>
	                <table class="table table-bordered">
	                   <tr>
	                        <th>条件</th>
	                        <td>
	                            <input class="form-control" type="text" name="condition[project_condition]"
	                                     value="<?php echo $project_condition['project_condition']; ?>" placeholder="请输入条件"/>
	                        </td>
	                    </tr>
	     

	                     <tr>
	                        <th>关键字</th>
	                        <td>
	                            <input class="form-control" type="text" name="condition[project_keywords]"  value="<?php echo $project_condition['project_keywords']; ?>"
	                                   placeholder="请输入关键字">
	                            <p class="help-block">多关键字之间用英文逗号隔开</p>
	                        </td>
	                    </tr>

	                     <tr>
	                        <th>合格的标准</th>
	                        <td>
	                            <textarea class="form-control" type="text" name="condition[project_standard]"><?php echo $project_condition['project_standard']; ?></textarea>
	                           
	                        </td>
	                    </tr>

	                     <tr>
	                        <th>性别</th>
	                        <td>
	                             <select class="form-control" name="condition[sex]" >
	                                <option value="1">全部</option>
	                                <option value="2">男</option>
	                                <option value="3">女</option>
	                               
	                            </select>
	                        </td>
	                    </tr>

	                     <tr>
	                        <th>最小年龄</th>
	                        <td>
	                            <input class="form-control" type="text" name="condition[min_age]"  value="<?php echo $project_condition['min_age']; ?>"
	                                   placeholder="最小年龄">
	                           
	                        </td>
	                    </tr>

	                     <tr>
	                        <th>最大年龄</th>
	                        <td>
	                            <input class="form-control" type="text" name="condition[max_age]"  value="<?php echo $project_condition['max_age']; ?>"
	                                   placeholder="最大年龄">
	                           
	                        </td>
	                    </tr>
	                    
	                    <tr>
	                        <th>接受健康志愿者</th>
	                        <td>
								<label for="radio-l">是</label>
								<input type="radio" value='1' name="condition[project_receive]"  id="radio-l" <?php if($project_condition['project_receive']==1) { echo 'checked';} ?> />&nbsp;&nbsp;&nbsp;
								<label for="radio-a">否</label>
								<input type="radio" value='2' name="condition[project_receive]" id="radio-a" <?php if($project_condition['project_receive']==2) { echo 'checked';} ?> />&nbsp;&nbsp;&nbsp;

	                           
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>预期入组人数<span class="form-required">*</span></th>
	                        <td>
	                            <input class="form-control" type="text" name="condition[project_people_num]" required  value="<?php echo $project_condition['project_people_num']; ?>"
	                                   placeholder="预期入组人数">
	                           
	                        </td>
	                    </tr>
	             
	                </table>
          		</div>


        <!-- 设备信息 -->
      	<div style='font-size: 14px;color:#66CCCC;margin:20px 0 20px 20px;width: 100%' onclick="tableOnclick('project-device')"><p id='project-device-show' style='display:inline'>+</p>&nbsp;&nbsp;&nbsp;设备信息</div>
      		<div id='project-device' style='display: none'>
	                <table class="table table-bordered">
	                    <tr>
	                        <th>设备名称</th>
	                        <td>
	                            <input class="form-control" type="text" name="device[device_name]"  value="<?php echo $project_device['device_name']; ?>"
	                                   placeholder="设备名称">
	                           
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>设备城市</th>
	                        <td>
	                            <input class="form-control" type="text" name="device[device_city]"  value="<?php echo $project_device['device_city']; ?>"
	                                   placeholder="设备城市">
	                           
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>设备 州/省</th>
	                        <td>
	                            <input class="form-control" type="text" name="device[device_province]"  value="<?php echo $project_device['device_province']; ?>"
	                                   placeholder="设备 州/省">
	                           
	                        </td>
	                    </tr>
	                     <tr>
	                        <th>邮政编码</th>
	                        <td>
	                            <input class="form-control" type="text" name="device[device_postcode]"  value="<?php echo $project_device['device_postcode']; ?>"
	                                   placeholder="邮政编码">
	                           
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>设备国家</th>
	                        <td>
	                            <input class="form-control" type="text" name="device[device_country]"  value="<?php echo $project_device['device_country']; ?>"
	                                   placeholder="设备国家">
	                           
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>设备联系姓名</th>
	                        <td>
	                            <input class="form-control" type="text" name="device[device_connet_name]"  value="<?php echo $project_device['device_connet_name']; ?>"
	                                   placeholder="设备联系姓名">
	                           
	                        </td>
	                    </tr>
	                     <tr>
	                        <th>设备联系电话</th>
	                        <td>
	                            <input class="form-control" type="text" name="device[device_connet_phone]"  value="<?php echo $project_device['device_connet_phone']; ?>"
	                                   placeholder="设备联系电话">
	                           
	                        </td>
	                    </tr>
	                     <tr>
	                        <th>设备联系电子邮件</th>
	                        <td>
	                            <input class="form-control" type="text" name="device[device_connet_email]"  value="<?php echo $project_device['device_connet_email']; ?>"
	                                   placeholder="设备联系电子邮件">
	                           
	                        </td>
	                    </tr>

	                </table>
          		</div>
          		
        <!-- 研究项目参数配置 -->
      	<div style='font-size: 14px;color:#66CCCC;margin:20px 0 20px 20px;width: 100%' onclick="tableOnclick('project-config')"><p id='project-config-show' style='display:inline'>+</p>&nbsp;&nbsp;&nbsp;研究项目参数配置</div>
      		<div id='project-config' style='display: none'>
	                <table class="table table-bordered">
	                    <tr>
	                        <th>收集受试者的出生日期</th>
	                        <td>
	                              <label for="radio-1">是</label>
								  <input type="radio" value='1' name="config[config_birthday]" id="radio-1" <?php if($project_config['config_birthday']==1) { echo 'checked';} ?>  />&nbsp;&nbsp;&nbsp;
								  <label for="radio-2">否</label>
								  <input type="radio" value='2' name="config[config_birthday]" id="radio-2" <?php if($project_config['config_birthday']==2) { echo 'checked';} ?>  />&nbsp;&nbsp;&nbsp;
								  <label for="radio-3">出生年份</label>
								  <input type="radio" value='3' name="config[config_birthday]" id="radio-3" <?php if($project_config['config_birthday']==3) { echo 'checked';} ?>  />
	                        </td>
	                    </tr>
						<tr>
							<th>性别必须？</th>
							<td>
								<label for="radio-4">是</label>
								<input type="radio" value='1' name="config[config_sex]" id="radio-4"  <?php if($project_config['config_sex']==1) { echo 'checked';} ?> />&nbsp;&nbsp;&nbsp;
								<label for="radio-5">否</label>
								<input type="radio" value='2' name="config[config_sex]" checked id="radio-5"  <?php if($project_config['config_sex']==2) { echo 'checked';} ?> />
							</td>
						</tr>

	                    <tr>
	                        <th>允许不一致管理？</th>
	                        <td>
	                              <label for="radio-4">是</label>
								  <input type="radio" value='1' name="config[config_manage]" checked id="radio-41"  <?php if($project_config['config_birthday']==1) { echo 'checked';} ?> />&nbsp;&nbsp;&nbsp;
								  <label for="radio-5">否</label>
								  <input type="radio" value='2' name="config[config_manage]" id="radio-51"  <?php if($project_config['config_manage']==2) { echo 'checked';} ?> />
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>是否需要受试者ID？</th>
	                        <td>
	                              <label for="radio-6">必需的</label>
								  <input type="radio" value='1' name="config[config_user_id]" checked id="radio-6" <?php if($project_config['config_user_id']==1) { echo 'checked';} ?> />&nbsp;&nbsp;&nbsp;
								  <label for="radio-7">可选</label>
								  <input type="radio" value='2' name="config[config_user_id]" id="radio-7" <?php if($project_config['config_user_id']==2) { echo 'checked';} ?> />
								<label for="radio-71">未使用</label>
								<input type="radio" value='3' name="config[config_user_id]" id="radio-71" <?php if($project_config['config_user_id']==3) { echo 'checked';} ?> />
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>显示ID于CRF页眉？</th>
	                        <td>
	                              <label for="radio-8">是</label>
								  <input type="radio" value='1' name="config[config_id_crf]" id="radio-8" <?php if($project_config['config_id_crf']==1) { echo 'checked';} ?> />&nbsp;&nbsp;&nbsp;
								  <label for="radio-9">否</label>
								  <input type="radio" value='2' name="config[config_id_crf]" checked id="radio-9" <?php if($project_config['config_id_crf']==2) { echo 'checked';} ?> />
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>如何生成研究项目受试者 ID?</th>
	                        <td>
	                              <label for="radio-10">手工录入</label>
								  <input type="radio" value='1' name="config[config_user]" id="radio-10" <?php if($project_config['config_user']==1) { echo 'checked';} ?> />
								<label for="radio-101">自动产生并可编辑</label>
								<input type="radio" value='2' name="config[config_user]" id="radio-101" <?php if($project_config['config_user']==2) { echo 'checked';} ?> />
								  <label for="radio-11">自动产生并不可编辑</label>
								  <input type="radio" value='3' name="config[config_user]" checked id="radio-11" <?php if($project_config['config_user']==3) { echo 'checked';} ?> />
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>录入数据时，是否需要访视者姓名？</th>
	                        <td>
	                              <label for="radio-12">是</label>
								  <input type="radio" value='1' name="config[config_see_user]" checked id="radio-12" <?php if($project_config['config_see_user']==1) { echo 'checked';} ?> />&nbsp;&nbsp;&nbsp;
								  <label for="radio-13">否</label>
								  <input type="radio" value='2' name="config[config_see_user]" id="radio-13" <?php if($project_config['config_see_user']==2) { echo 'checked';} ?> />
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>访视者姓名默认为空？</th>
	                        <td>
	                              <label for="radio-14">空白</label>
								  <input type="radio" value='1' name="config[config_see_user_null]" checked id="radio-14" <?php if($project_config['config_see_user_null']==1) { echo 'checked';} ?> />&nbsp;&nbsp;&nbsp;
								  <label for="radio-15">从实际用户中准备人群化</label>
								  <input type="radio" value='2' name="config[config_see_user_null]" id="radio-15" <?php if($project_config['config_see_user_null']==2) { echo 'checked';} ?> />
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>访视者姓名是否可以编辑？</th>
	                        <td>
	                              <label for="radio-16">是</label>
								  <input type="radio" value='1' name="config[config_see_user_edit]" checked id="radio-16" <?php if($project_config['config_see_user_edit']==1) { echo 'checked';} ?> />&nbsp;&nbsp;&nbsp;
								  <label for="radio-17">不</label>
								  <input type="radio" value='2' name="config[config_see_user_edit]" id="radio-17" <?php if($project_config['config_see_user_edit']==2) { echo 'checked';} ?> />
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>访视日期是否必需？</th>
	                        <td>
	                              <label for="radio-24">是</label>
								  <input type="radio" value='1' name="config[config_see_time]" checked id="radio-24" <?php if($project_config['config_see_time']==1) { echo 'checked';} ?> />&nbsp;&nbsp;&nbsp;
								  <label for="radio-25">不</label>
								  <input type="radio" value='2' name="config[config_see_time]" id="radio-25" <?php if($project_config['config_see_time']==2) { echo 'checked';} ?> />
	                        </td>
	                    </tr>
	                     <tr>
	                        <th>访视日期默认为空？</th>
	                        <td>
	                              <label for="radio-18">是</label>
								  <input type="radio" value='1' name="config[config_see_time_null]" checked id="radio-18" <?php if($project_config['config_see_time_null']==1) { echo 'checked';} ?> />&nbsp;&nbsp;&nbsp;
								  <label for="radio-19">不</label>
								  <input type="radio" value='2' name="config[config_see_time_null]" id="radio-19" <?php if($project_config['config_see_time_null']==2) { echo 'checked';} ?> />
	                        </td>
	                    </tr>
	                     <tr>
	                        <th>访视日期是否可以编辑？</th>
	                        <td>
	                              <label for="radio-20">是</label>
								  <input type="radio" value='1' name="config[config_see_time_edit]" checked id="radio-20" <?php if($project_config['config_see_time_edit']==1) { echo 'checked';} ?> />&nbsp;&nbsp;&nbsp;
								  <label for="radio-21">不</label>
								  <input type="radio" value='2' name="config[config_see_time_edit]" id="radio-21" <?php if($project_config['config_see_time_edit']==2) { echo 'checked';} ?> />
	                        </td>
	                    </tr>
	                     <tr>
	                        <th>管理员编辑强制修改原因？</th>
	                        <td>
	                              <label for="radio-22">是</label>
								  <input type="radio" value='1' name="config[config_admin_edit]" checked id="radio-22" <?php if($project_config['config_admin_edit']==1) { echo 'checked';} ?> />&nbsp;&nbsp;&nbsp;
								  <label for="radio-23">不</label>
								  <input type="radio" value='2' name="config[config_admin_edit]" id="radio-23" <?php if($project_config['config_admin_edit']==2) { echo 'checked';} ?> />
	                        </td>
	                    </tr>
	                </table>
          		</div>

               
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary js-ajax-submit">保存</button>
                        <a class="btn btn-default" href="<?php echo url('project/index'); ?>"><?php echo lang('BACK'); ?></a>
                        <a class="btn btn-default" href="<?php echo url('project/edcadd',['id'=>$project_info['id']]); ?>">生成CRF</a>
                    </div>
                </div>



                <!-- end div -->
            </div>
      
        </div>
    </form>
	</div>
	<script src="/hx/public/static/js/admin.js"></script>
</body>
</html>
<script type="text/javascript">
	 function tableOnclick(id)
	 {
	 	var tableId=id;
	 	tabStatus=document.getElementById(tableId).style.display;
	 	if(tabStatus=='none')
	 	{
	 		document.getElementById(tableId).style.display='block';
	 		document.getElementById(tableId+'-show').innerHTML='-';
	 	
	 	}
	 	if(tabStatus=='block')
	 	{
	 		document.getElementById(tableId).style.display='none';	
	 		document.getElementById(tableId+'-show').innerHTML='+';
	 	}
	 	// alert(tab);
	 }
</script>