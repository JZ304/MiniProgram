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
                    <a href="index.php?c=Admin" >首页</a>
                </li>
                <li>
                    <a href="index.php?c=Admin&a=OrderList&lang=userlist" style="color: red">用户列表</a>
                </li>
                <li>
                    <a href="index.php?c=Admin&a=OrderList&lang=prizelog">中奖记录</a>
                </li>
                <li>
                    <a href="index.php?c=Admin&a=OrderList&lang=formlist">实物奖励名单</a>
                </li>

            </ul>
        </div>
    </div>
    <div id="main">
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>用户列表</h1>
                </div>
            </div>
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a href="#">首页</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a>用户列表</a>
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
                            <div style="width: 90%;margin-left: 100px;height:700px">
                                <br>
<!--                                <div class="demoTable">-->
<!--                                    微信名：-->
<!--                                    <div class="layui-inline">-->
<!--                                        <input class="layui-input" name="id" id="demoReload" autocomplete="off">-->
<!--                                    </div>-->
<!--                                    <button class="layui-btn" data-type="reload">搜索</button>-->
<!--                                </div>-->
                                <table id="member" lay-filter="test"></table>
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
        layui.use('table', function(){
            var table = layui.table;
            table.render({
                elem: '#member'
                ,height: 700
                ,url: 'http://h5.rzthinkmore.com/xxw180901/index.php?c=Admin&a=getData&lang=member' //数据接口
                ,page: true //开启分页
                ,loading:true
                ,skin:'line'
                ,cols: [[ //表头
                    {field: 'id', title: 'ID', width:'10%', sort: true, fixed: 'left',align:'center' ,style:"height:70px;"}
                    ,{field: 'username', title: '微信名',width:'25%',align:'center',style:"height:70px;"}
                    ,{field: 'headimage', title: '头像' ,width:'15%',align:'center',style:"height:70px;",templet:'<div  style="border: 1px solid red;"><img style="width: 30px;height:30px" src="{{ d.headimage}}"></div>'}
                    ,{field: 'oppotunity', title: '中奖基数', width:'20%',align:'center',style:"height:70px;"}
                    ,{field: 'creattime', title: '注册时间', width: '30%', sort: true,align:'center',style:"height:70px;"}
                ]]
            });


             //搜索
            // $('.demoTable .layui-btn').on('click', function(){
            //     var content = $("#demoReload").val();
            //     table.render({
            //         elem: '#member'
            //         ,height: 800
            //         ,url: 'http://h5.rzthinkmore.com/xxw180601/index.php?c=Admin&a=getData&lang=member_search&name='+content //数据接口
            //         ,page: true //开启分页
            //         ,loading:true
            //         ,skin:'line'
            //         ,cols: [[ //表头
            //             {field: 'id', title: 'ID', width:104, sort: true, fixed: 'left',align:'center' ,style:"height:70px;"}
            //             ,{field: 'username', title: '微信名',width:200,align:'center',style:"height:70px;"}
            //             ,{field: 'nickname', title: '昵称',width:180,align:'center',style:"height:70px;"}
            //             ,{field: 'headimage', title: '头像' ,width:140,align:'center',style:"height:70px;",templet:'<div  style="border: 1px solid red;"><img style="width: 30px;height:30px" src="{{ d.headimage}}"></div>'}
            //             ,{field: 'guid', title: 'GUID', width:220,align:'center',style:"height:70px;"}
            //             ,{field: 'tel', title: '联系电话', width:170,align:'center',style:"height:70px;"}
            //             ,{field: 'integral', title: '账户积分', width: 170, sort: true,align:'center',style:"height:70px;"}
            //             ,{field: 'creattime', title: '注册时间', width: 500, sort: true,align:'center',style:"height:70px;"}
            //         ]]
            //     });
            // });
        });
    })
</script>