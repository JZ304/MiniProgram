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
    <link rel="stylesheet" href="Admin/layui/css/layui.css">
    <script src="Admin/layer/layer.js"></script>
    <script src="Admin/layui/layui.js"></script>
    <style>
        .layui-table-cell{
            height: 40px;
        }
    </style>
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
                    <a  href="index.php?c=Admin&a=OrderList&lang=exchangeLog">兑换记录</a>
                </li>
                <li>
                    <a style="color: red" href="index.php?c=Admin&a=OrderList&lang=playLog">游戏记录</a>
                </li>

            </ul>
        </div>
    </div>
    <div id="main">
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>游戏记录</h1>
                </div>
            </div>
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a href="#">首页</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a>游戏记录</a>
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
                            <br>
                            <div style="width: 90%;margin: auto;height: 600px">

                                <table id="demo" lay-filter="test"></table>

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
                elem: '#demo'
                ,height: 800
                ,url: 'http://h5.rzthinkmore.com/xxw180601/index.php?c=Admin&a=getData&lang=gameLog' //数据接口
                ,page: true //开启分页
                ,loading:true
                ,skin:'line'
                ,cols: [[ //表头
                    {field: 'id', title: 'ID', width:84, sort: true, fixed: 'left',align:'center' ,style:"height:70px;"}
                    ,{field: 'username', title: '用户昵称',width:180,align:'center',style:"height:70px;"}
                    ,{field: 'headimage', title: '头像' ,width:160,align:'center',style:"height:70px;",templet:'<div  style="border: 1px solid red;"><img style="width: 30px;height:30px" src="{{ d.headimage}}"></div>'}
                    ,{field: 'gametype', title: '游戏名', width:170,align:'center',style:"height:70px;"}
                    ,{field: 'getintegral', title: '获得积分', width: 170, sort: true,align:'center',style:"height:70px;"}
                    ,{field: 'creattime', title: '开始时间', width: 350, sort: true,align:'center',style:"height:70px;"}
                    ,{field: 'appid', title: 'OpenID', width: 570,align:'center',style:"height:70px;"}

                ]]
            });

        });
    })
</script>
