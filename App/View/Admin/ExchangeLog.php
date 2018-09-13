<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="edge" />
    <meta charset="utf-8" />
    <title>系统后台</title>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="Admin/css/admin.css">
<!--    <script src="Admin/layer/layer.js"></script>-->
    <script src="Admin/layui/layui.js"></script>
    <link rel="stylesheet" href="Admin/layui/css/layui.css">
</head>

<body>
<?php
$data = array('username' => $username, );
View::tplInclude('Admin/Header',$data);
?>
<div class="container-fluid" id="content">
    <div id="left">
        <div class="subnav">
            <div class="subnav-title">
                <a href="#" class='toggle-subnav'>
                    <i class="fa fa-angle-down"></i>
                    <span>快捷导航</span>
                </a>
            </div>
            <ul class="subnav-menu">
                <li>
                    <a href="index.php?c=Admin">首页</a>
                </li>
                <li>
                    <a href="index.php?c=Admin&a=OrderList&lang=shownews">新闻动态</a>
                </li>
                <li>
                    <a href="index.php?c=Admin&a=OrderList&lang=config">系统配置</a>
                </li>
                <li>
                 <a  href="index.php?c=Admin&a=OrderList&lang=member">会员管理</a>
                </li>
                <li>
                    <a style="color: red" href="index.php?c=Admin&a=OrderList&lang=exchangeLog">兑换记录</a>
                </li>
                <li>
                    <a href="index.php?c=Admin&a=OrderList&lang=playLog">游戏记录</a>
                </li>

            </ul>
        </div>
    </div>
    <div id="main">
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>兑换记录</h1>
                </div>
            </div>
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a href="#">首页</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a>兑换记录</a>
                        <i class="fa fa-angle-right"></i>
                    </li>

                </ul>
            </div>
            <br>

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-title"></div>
                        <div class="box-content nopadding" style="padding-top: 50px">
                            <br><br>
                            <div class="layui-form-item">
                                <label class="layui-form-label">  </label>
                                <div class="layui-input-inline">
                                    <input id="userContent" type="text" name="password"  required lay-verify="required" placeholder="用户名,积分" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux" style="padding: 0px 0!important;"><button id="search" class="layui-btn layui-btn">搜索</button></div>
                            </div>

                            <div style="width: 90%;margin: auto;height:600px">
                                <table id="convert" lay-filter="test"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php View::tplInclude('Admin/Footer'); ?>
</body>
</html>
<script>
    $(function () {
        layui.use(['table','laypage','layer'], function(){
            var table = layui.table;
               laypage = layui.laypage;
               layer = layui.layer;
            table.render({
                elem: '#convert'
                ,height: 800
                ,url: 'http://h5.rzthinkmore.com/xxw180601/index.php?c=Admin&a=getData&lang=convert' //数据接口
                ,page: true //开启分页
                ,loading:true
                ,skin:'line'
                ,cols: [[ //表头
                    {field: 'id', title: 'ID', width:84, sort: true, fixed: 'left',align:'center' ,style:"height:70px;"}
                    ,{field: 'useropenid', title: '用户OPENID',width:180,align:'center',style:"height:70px;"}
                    ,{field: 'username', title: '用户昵称', width:170,align:'center',style:"height:70px;"}
                    ,{field: 'logcontent', title: '说明', width: 300, sort: true,align:'center',style:"height:70px;"}
                    ,{field: 'creattime', title: '开始时间', width: 250, sort: true,align:'center',style:"height:70px;"}
                    ,{field: 'responce', title: '响应结果', width: 700,align:'center',style:"height:70px;"}

                ]]
            });

        $("#search").on('click',function () {
            var content = $("#userContent").val();//用户输入内容
            if(content==""){
                layer.msg("请输入有效内容",function () {})
            }else{
                table.render({
                    elem: '#convert'
                    ,height: 800
                    ,url: 'http://h5.rzthinkmore.com/xxw180601/index.php?c=Admin&a=getData&lang=convert_for_search&name='+content //数据接口
                    ,page: true //开启分页
                    ,loading:true
                    ,skin:'line'
                    ,cols: [[ //表头
                        {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left',align:'center' ,style:"height:70px;"}
                        ,{field: 'useropenid', title: '用户OPENID',width:180,align:'center',style:"height:70px;"}
                        ,{field: 'username', title: '用户昵称', width:170,align:'center',style:"height:70px;"}
                        ,{field: 'logcontent', title: '说明', width: 300, sort: true,align:'center',style:"height:70px;"}
                        ,{field: 'creattime', title: '开始时间', width: 250, sort: true,align:'center',style:"height:70px;"}
                        ,{field: 'responce', title: '响应结果', width: 540,align:'center',style:"height:70px;"}

                    ]]
                });
            }

        })
        });
    })
</script>