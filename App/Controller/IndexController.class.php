<?php

use OSS\OssClient;
use OSS\Core\OssException;
class IndexController extends ServiceController
{
    protected $db;
    protected function _init()
    {
        header("Content-Type:text/html; charset=utf-8");
        date_default_timezone_set('Asia/Shanghai');
        $this->openid = $_SESSION['openid'];
        $this->db = M();
    }

    /**
     * 首页授权 普通入口
     */
    public function IndexAction()
    {
            $code = $_GET["code"];
            if ( !isset($this->openid)) {
                if ( !isset($code)) {
                    $appid = C('APPID');
                    $appsecret = C('APPSECRET');
                    $redirect_uri = urlencode(C('redirect_uri') . "index.php?c=Index");
                    $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
                    $this->redirect($url);
                } else {
                    $this->user = getUserInfo($code);
                    if (isset($this->user)) {
                        $username             = addslashes($this->user['nickname']);
                        $_SESSION['openid']   = $this->user['openid'];
                        $_SESSION['nickname'] = $username;
                        $_SESSION['headimg']  = $this->user['headimgurl'];
                        $this->openid         = $_SESSION['openid'];
                        $this->nickname       = $_SESSION['nickname'];
                    } else {
                        Log::warn('【授权出错！】 openid:' . $this->openid);
                        exit('授权出错！');
                    }
                }
            }
            $this->addUserMessage();//初始化设置放在这里面
            require_once "./jssdk.php";
            $jssdk = new JSSDK(C('APPID'), C('APPSECRET'));
            $signPackage = $jssdk->GetSignPackage();
            $this->assign('signPackage',$signPackage);
            $this->display('index');

    }

    /*
     * 新增用户
     * */
    public function addUserMessage()
    {
        $this->isSetOpenid();
        $openId  = $this->openid;
        $user    = $this->db->query("SELECT * FROM xxw180901_user WHERE appid = '$openId'");// 查询时不要使用 *
        $flag    = $this->db->getRows();
        $appid   = $_SESSION['openid'];
        $wname   = $_SESSION['nickname'];
        $headimg = $_SESSION['headimg'];
        if ( $flag == 0 ) {

            $time    = date("Y-m-d H:i:s");
            if(empty($headimg) || empty($wname)) {
                Log::warn("【授权头像或昵称为空，重新授权】");
                unset($_SESSION['openid']);
                $url = "your url";
                $this->redirect($url);//重定向授权
            }else{
                $this->db->execute("INSERT INTO your_table_name (openid,headimage,username,creattime) VALUES ('$appid','$headimg','$wname','$time')");
            }

        }else{

            $this->db->execute("UPDATE your_table_name SET headimage = '$headimg',username = '$wname' WHERE openid = '$openId'");

        }
    }

    /*
    * 身份认证
    * */
    private function isSetOpenid()
    {
        if ( !isset($this->openid)) {
            $this->errorResponse('身份认证失败,请刷新重试');
        }
    }



}
