<?php

class BaseController extends Controller
{
    protected function _init()
    {
        header("Content-Type:text/html; charset=utf-8");
    }

    /**
     * 错误返回
     *
     * @param $msg
     */
    public function errorResponse($msg, $logmsg = null)
    {
        $ret = ['result' => false, 'error' => $msg];
        if ($logmsg) Log::fatal($logmsg);
        $this->AjaxReturn($ret);
    }

    /**
     * 成功返回
     *
     * @param $msg
     */
    public function successResponse($msg)
    {
        $ret = ['result' => true, 'msg' => $msg];
        $this->AjaxReturn($ret);
    }

    /**
     * 数据返回
     *
     * @param array $data
     */
    public function dataResponse(array $data)
    {
        $ret = ['result' => true, 'data' => $data];
        $this->AjaxResturn($ret);
    }

    /**
     * 具体时间
     *
     * @return false|string
     */
    public function currentTime()
    {
        $now = time();
        $dt = date('Y-m-d H:i:s', $now);

        return $dt;
    }

    /**
     * 日期
     *
     * @return false|string
     */
    public function currentDate()
    {
        $now = time();
        $dt = date('Y-m-d', $now);

        return $dt;
    }

    /*
     *验证手机号码
     *
     * @return false|true
     * */
    function is_mobile( $text ) {
        $search = '/^0?1[3|4|5|6|7|8][0-9]\d{8}$/';
        if ( preg_match( $search, $text ) ) {
            return ( true );
        } else {
            return ( false );
        }
    }



}
