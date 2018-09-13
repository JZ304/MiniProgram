<?php
use OSS\OssClient;
use OSS\Core\OssException;

class AdminController extends BaseController {

	private $db = null;
	private $admin = null;

	protected function _init() {
		if (empty($_SESSION['admin'])){
			$_SESSION['admin']    = null;
		}
		if (empty($_SESSION['username'])){
			$_SESSION['username'] = null;
		}

		$this->admin = $_SESSION['admin'];
		$this->db = M();

		$this->assign("waitSecond", 2000);
		$this->assign('username', $_SESSION['username']);
	}
	//判断是否管理员
	private function IsAdmin() {
		if (!isset($this->admin)) {
			$this->redirect('index.php?c=Admin&a=Login');
		}
	}
	//验证码
	public function CheckcodeAction() {
		$checkcode = new Checkcode();
		if (isset($_GET['code_len']) && intval($_GET['code_len'])) {
			$checkcode->code_len = intval($_GET['code_len']);
		}

		if ($checkcode->code_len > 8 || $checkcode->code_len < 2) {
			$checkcode->code_len = 4;
		}
		//强制验证码不得小于4位
		if ($checkcode->code_len < 4) {
			$checkcode->code_len = 4;
		}
		if (isset($_GET['font_size']) && intval($_GET['font_size'])) {
			$checkcode->font_size = intval($_GET['font_size']);
		}

		if (isset($_GET['width']) && intval($_GET['width'])) {
			$checkcode->width = intval($_GET['width']);
		}

		if ($checkcode->width <= 0) {
			$checkcode->width = 130;
		}
		if (isset($_GET['height']) && intval($_GET['height'])) {
			$checkcode->height = intval($_GET['height']);
		}

		if ($checkcode->height <= 0) {
			$checkcode->height = 50;
		}
		if (isset($_GET['font_color']) && trim(urldecode($_GET['font_color'])) && preg_match('/(^#[a-z0-9]{6}$)/im', trim(urldecode($_GET['font_color'])))) {
			$checkcode->font_color = trim(urldecode($_GET['font_color']));
		}

		if (isset($_GET['background']) && trim(urldecode($_GET['background'])) && preg_match('/(^#[a-z0-9]{6}$)/im', trim(urldecode($_GET['background'])))) {
			$checkcode->background = trim(urldecode($_GET['background']));
		}

		$checkcode->doimage();

		//验证码类型
		$type = $_GET['type'];
		$type = $type ? strtolower($type) : "verify";
		$verify = $_SESSION["_verify_"];
		if (empty($verify)) {
			$verify = array();
		}
		$verify[$type] = $checkcode->get_code();
		$_SESSION["_verify_"] = $verify;
	}


	//验证
	public function verify($verify, $type = "verify") {
		$verifyArr = $_SESSION["_verify_"];
		if (!is_array($verifyArr)) {
			$verifyArr = array();
		}
		if ($verifyArr[$type] == strtolower($verify)) {
			unset($verifyArr[$type]);
			if (!$verifyArr) {
				$verifyArr = array();
			}
			$_SESSION["_verify_"] = $verifyArr;
			return true;
		} else {
			return false;
		}
	}
	//错误
	public function error($msg, $url) {

		$this->assign('msgTitle', '错误');
		$this->assign('error', $msg);
		$this->assign('jumpUrl', "index.php?c=Admin&a=" . $url);
		$this->display('Error');
		exit();

	}
	//正确
	public function success($msg, $url) {

		$this->assign('msgTitle', '提示');
		$this->assign('message', $msg);
		$this->assign('jumpUrl', "index.php?c=Admin&a=" . $url);
		$this->display('Success');

	}

	//首页 超级管理员入口
	public function IndexAction() {

		$this->IsAdmin();
		$system    = php_uname('s') ;
		$version   = php_uname('r');
		$p_version = PHP_VERSION;
		$z_version = Zend_Version();
		$serverIp  = GetHostByName($_SERVER['SERVER_NAME']);
		$userIp    =  $_SERVER['REMOTE_ADDR'];
		$serverinfo=  $_SERVER["HTTP_HOST"];
		$chorminfo =  $_SERVER['HTTP_USER_AGENT'];;
		$this->assign('system', $system);
		$this->assign('version', $version);
		$this->assign('p_version', $p_version);
		$this->assign('z_version', $z_version);
		$this->assign('serverIp', $serverIp);
		$this->assign('userIp', $userIp);
		$this->assign('serverinfo', $serverinfo);
		$this->assign('chorminfo', $chorminfo);
		$this->display();

	}

	//登录
	public function LoginAction() {

		$this->display();

	}

	//后台登陆验证
	public function tologinAction() {

		$username = I("post.username", "", "trim");
		$password = I("post.password", "", "trim");
		$code = I("post.code", "", "trim");
		if (empty($username) || empty($password))
		{
			$this->error("用户名或者密码不能为空，请重新输入！", "Login");
		}
		if (empty($code))
		{
			$this->error("请输入验证码！", "Login");
		}
		// 验证码开始验证
		if (!$this->verify($code))
		{
			$this->error("验证码错误，请重新输入！", "Login");
		}
		if (strtolower($username)=='admin' && $password=='123zxc')
		{
				$_SESSION['username'] = $username;
				$_SESSION['admin']    = true;
				$this->redirect("index.php?c=Admin");
		}
		$this->error("用户名或者密码错误，登陆失败！", "Login");

	}

	//退出登陆
	public function logoutAction() {

		unset($_SESSION['admin']);
		$this->success('登出成功！', "Login");

	}





      /*
       * 点击导航栏跳转-超级管理员
       * */
	public function OrderListAction() {

		$this->IsAdmin();
		$lang = $_GET['lang'];
        if($lang == "userlist")//用户列表
        {
            $this->display('Member');
        }
        elseif($lang=='prizelog')//抽奖记录
        {
            $this->display('Prizelog');
        }
        elseif($lang == 'formlist')
        {
            $this->display('Formlist');
        }

	}

	/*
	 * 获取数据
	 * */
	public function getDataAction(){
        $this->IsAdmin();
	    $data         = [];
	    $data['code'] = 0;
	    $data['msg']  = '';
	    $type         = $_GET['lang'];
	    $page         = $_GET['page'];
	    $pagenum      = $_GET['limit'];
	    $begin        = ($page-1)*$pagenum;
	   if ($type == 'member'){

            $this->db->query("SELECT * FROM xxw180901_user");
            $data['count']= $this->db->getRows();
            $result = $this->db->query("SELECT * FROM xxw180901_user LIMIT $begin,$pagenum");
            $data['data'] = $result;
            echo json_encode($data);
        }elseif ($type == 'prizelog'){
            $this->db->query("SELECT * FROM xxw180901_prize");
            $data['count']= $this->db->getRows();
            $result = $this->db->query("SELECT * FROM xxw180901_prize LIMIT $begin,$pagenum");
            $data['data'] = $result;
            echo json_encode($data);
        }elseif ($type=='Formlist'){//实物奖励名单
            $this->db->query("SELECT * FROM xxw180901_luckermsg");
            $data['count']= $this->db->getRows();
            $result = $this->db->query("SELECT m.id,m.openid,m.username,m.tel,m.address,m.addtime,l.getprize FROM xxw180901_luckermsg m LEFT JOIN xxw180901_user l ON m.openid = l.openid LIMIT $begin,$pagenum");
            $data['data'] = $result;
            echo json_encode($data);
        }

    }


    /*
     * 导出数据（中奖）
     *
     * */
    public function getExcelAction()
    {


            $this->IsAdmin();

            $sql = "SELECT m.id,m.openid,m.username,m.tel,m.address,m.addtime,l.getprize FROM xxw180901_luckermsg m LEFT JOIN xxw180901_user l ON m.openid = l.openid ORDER BY m.id DESC";

            $template = $_SERVER['DOCUMENT_ROOT'] . "/xxw/Admin/Excel/text.csv";//模板路径

            $name = "中奖数据";

            $arr = $this->db->query($sql);

            $time = date("Y-m-d") ;

            $header=array('编号','姓名','电话','奖品','收货地址','时间');

            $index=array('id','username','tel','getprize','address','addtime');

            $this->getExcelCss($arr, $name, $index, $template);

            exit();

      
       
    }



    /*
     * OSS图片上传
     * */
    public function ossUploade($file){

        require '././OSS/autoload.php';
        $accessKeyId     = "";
        $accessKeySecret = "";
        $endpoint        = "";
        $bucketName      = '';
        try {
            $ossClient   = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            // 先把本地的example.jpg上传到指定$bucket, 命名为$object
            $ext         = substr($file['name'], strrpos($file['name'], '.')+1);
            $filename    = 'xxw180601/uploads/'.md5($file['name'].time()).'.'.$ext;
            $ossClient->uploadFile($bucketName, $filename, $file['tmp_name']);
        } catch (OssException $e) {
            Log::fatal("OSS:".$e->getMessage());
        }
        $url='http://oss.rzthinkmore.com/'.$filename;
        return $url;

    }



 /**
     * 创建(导出)Excel数据表格
     * @param  array   $list        要导出的数组格式的数据
     * @param  string  $filename    导出的Excel表格数据表的文件名
     * @param  array   $indexKey    $list数组中与Excel表格表头$header中每个项目对应的字段的名字(key值)
     * @param  array   $startRow    第一条数据在Excel表格中起始行
     * @param  [bool]  $excel2007   是否生成Excel2007(.xlsx)以上兼容的数据表
     * 比如: $indexKey与$list数组对应关系如下:
     *     $indexKey = array('id','username','sex','age');
     *     $list = array(array('id'=>1,'username'=>'YQJ','sex'=>'男','age'=>24));
     */

    public function getExcelCss($list,$filename,$indexKey=array(),$template){
        require_once $_SERVER['DOCUMENT_ROOT'] . "/xxw/Admin/Excel/PHPExcel/IOFactory.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/xxw/Admin/Excel/PHPExcel.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/xxw/Admin/Excel/PHPExcel/Writer/Excel2007.php";

        $header_arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

//        $template = $_SERVER['DOCUMENT_ROOT'] . "/xxw180522/Admin/Excel/model.xls";          //使用模板
        $objPHPExcel = PHPExcel_IOFactory::load($template);     //加载excel文件,设置模板

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);  //设置保存版本格式

        //接下来就是写数据到表格里面去
        $objActSheet = $objPHPExcel->getActiveSheet();
        $i = 3;//起始行
        foreach ($list as $row) {
            foreach ($indexKey as $key => $value){
                //这里是设置单元格的内容
                $objActSheet->setCellValue($header_arr[$key].$i,$row[$value]);
            }
            $i++;
        }
        header("Content-Type:text/html;charset=gbk");
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="'.$filename.'.xls"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }




}
