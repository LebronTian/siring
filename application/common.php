<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * Created by PhpStorm.
 * User: CHEN
 * Date: 2018/5/26
 * Time: 10:53
 */

/**
 *阿里大鱼短信接口
 */
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;

/**
 **************李火生*******************
 * @param $object
 * @return mixed
 * 阿里大鱼短信接口
 **************************************
 */

//阿里短信函数，$mobile为手机号码，$code为自定义随机数(注册)
function sendMsg($mobile,$code){

    //这里的路径EXTEND_PATH就是指tp5根目录下的extend目录，系统自带常量。alisms为我们复制api_sdk过来后更改的目录名称

    include(EXTEND_PATH.'alisms/vendor/autoload.php');
    Config::load();             //加载区域结点配置

    $accessKeyId = 'LTAID1DEcOCLzwmv';  //阿里云短信获取的accessKeyId

    $accessKeySecret = 'KGMpwJhSxw76U0BoYcoNWzuGJh1pJ4';    //阿里云短信获取的accessKeySecret

    //这个个是审核过的模板内容中的变量赋值，记住数组中字符串code要和模板内容中的保持一致
    //比如我们模板中的内容为：你的验证码为：${code}，该验证码5分钟内有效，请勿泄漏！
    $templateParam = array("code"=>$code);           //模板变量替换
    $signName = '嘎嘎靓科技'; //这个是短信签名，要审核通过
    $templateCode = 'SMS_147480025';   //短信模板ID，记得要审核通过的
    //短信API产品名（短信产品名固定，无需修改）
    $product = "Dysmsapi";
    //短信API产品域名（接口地址固定，无需修改）
    $domain = "dysmsapi.aliyuncs.com";
    //暂时不支持多Region（目前仅支持cn-hangzhou请勿修改）
    $region = "cn-hangzhou";

    // 初始化用户Profile实例
    $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
    // 增加服务结点
    DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
    // 初始化AcsClient用于发起请求
    $acsClient= new DefaultAcsClient($profile);

    // 初始化SendSmsRequest实例用于设置发送短信的参数
    $request = new SendSmsRequest();
    // 必填，设置雉短信接收号码
    $request->setPhoneNumbers($mobile);

    // 必填，设置签名名称
    $request->setSignName($signName);

    // 必填，设置模板CODE
    $request->setTemplateCode($templateCode);

    // 可选，设置模板参数
    if($templateParam) {
        $request->setTemplateParam(json_encode($templateParam));
    }
    //发起访问请求
    $acsResponse = $acsClient->getAcsResponse($request);

    //返回请求结果
    $result = json_decode(json_encode($acsResponse),true);
    return $result;
}


//阿里鱼密码找回
function sendMsgPassword($mobile,$password){

    //这里的路径EXTEND_PATH就是指tp5根目录下的extend目录，系统自带常量。alisms为我们复制api_sdk过来后更改的目录名称
    include(EXTEND_PATH.'alisms/vendor/autoload.php');
    Config::load();             //加载区域结点配置
    $accessKeyId = 'LTAID1DEcOCLzwmv';  //阿里云短信获取的accessKeyId

    $accessKeySecret = 'KGMpwJhSxw76U0BoYcoNWzuGJh1pJ4';    //阿里云短信获取的accessKeySecret

    //这个个是审核过的模板内容中的变量赋值，记住数组中字符串code要和模板内容中的保持一致
    //比如我们模板中的内容为：你的验证码为：${code}，该验证码5分钟内有效，请勿泄漏！
    $templateParam = array("password"=>$password);           //模板变量替换
    $signName = '嘎嘎靓科技'; //这个是短信签名，要审核通过
    $templateCode = 'SMS_147415726';   //短信模板ID，记得要审核通过的
//      $templateCode = 'SMS_116781357';   //短信模板ID，记得要审核通过的
    //短信API产品名（短信产品名固定，无需修改）
    $product = "Dysmsapi";
    //短信API产品域名（接口地址固定，无需修改）
    $domain = "dysmsapi.aliyuncs.com";
    //暂时不支持多Region（目前仅支持cn-hangzhou请勿修改）
    $region = "cn-hangzhou";

    // 初始化用户Profile实例
    $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
    // 增加服务结点
    DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
    // 初始化AcsClient用于发起请求
    $acsClient= new DefaultAcsClient($profile);

    // 初始化SendSmsRequest实例用于设置发送短信的参数
    $request = new SendSmsRequest();
    // 必填，设置雉短信接收号码
    $request->setPhoneNumbers($mobile);

    // 必填，设置签名名称
    $request->setSignName($signName);

    // 必填，设置模板CODE
    $request->setTemplateCode($templateCode);

    // 可选，设置模板参数
    if($templateParam) {
        $request->setTemplateParam(json_encode($templateParam));
    }
    //发起访问请求
    $acsResponse = $acsClient->getAcsResponse($request);

    //返回请求结果
    $result = json_decode(json_encode($acsResponse),true);
    return $result;
}


function objectToArray($object) {
    //先编码成json字符串，再解码成数组
    return json_decode(json_encode($object), true);
}

function arrayToObject($arr){
    if(is_array($arr)){
        return (object) array_map(__FUNCTION__, $arr);
    }else{
        return $arr;
    }
}

//生成树形图
function genTree($items,$id='id',$pid='pid',$son = 'children'){
    $tree = array(); //格式化的树
    $tmpMap = array();  //临时扁平数据

    foreach ($items as $item) {
        $tmpMap[$item[$id]] = $item;
    }

    foreach ($items as $item) {
        if (isset($tmpMap[$item[$pid]])) {
            $tmpMap[$item[$pid]][$son][] = &$tmpMap[$item[$id]];
        } else {
            $tree[] = &$tmpMap[$item[$id]];
        }
    }
    unset($tmpMap);
    return $tree;
}

/**
 * 分类排序（降序）
 */
function _tree_sort($arr,$cols){
    //子分类排序
    foreach ($arr as $k => &$v) {
        if(!empty($v['sub'])){
            $v['sub']=_tree_sort($v['sub'],$cols);
        }
        $sort[$k]=$v[$cols];
    }
    if(isset($sort))
        array_multisort($sort,SORT_ASC,$arr);
    return $arr;
}
/**
 * 横向分类树
 */
function _tree_hTree($arr,$pid=0){
    foreach($arr as $k => $v){
        if($v['pid']==$pid){
            $data[$v['id']]=$v;
            $data[$v['id']]['sub']=_tree_hTree($arr,$v['id']);
        }
    }
    return isset($data)?$data:array();
}
/**
 * 纵向分类树
 */
function _tree_vTree($arr,$pid=0){
    foreach($arr as $k => $v){
        if($v['pid']==$pid){
            $data[$v['id']]=$v;
            $data+=_tree_vTree($arr,$v['id']);
        }
    }
    return isset($data)?$data:array();
}

function ajax_error($msg = '服务器错误，可刷新页面重试',$data=array()){
    $return = array('status'=>'0');
    $return['info'] = $msg;
    $return['data'] = $data;

    exit(json_encode($return,JSON_UNESCAPED_UNICODE));
}

function ajax_success($msg = '提交成功',$data=array()){
    $return = array('status'=>'1');
    $return['info'] = $msg;
    $return['data'] = $data;
    exit(json_encode($return,JSON_UNESCAPED_UNICODE));
}


/**
 * 打印调试函数
 * @param mixed $var 打印的东西
 */
function p($var = null,$debugger = 0){
    $str = '<pre style="border:1px solid #ccc; padding:10px; font-size:16px; line-height:28px; border-radius:5px; background:#eaebe6;">%str%</pre>';
    $replace = print_r($var, true);
    if(is_null($var)){
        $replace = '__NULL__';
    }elseif(is_bool($var)){
        $var = $var === true ? 'true' : 'false';
        $replace = '(bool)'.$var;
    }elseif(is_string($var) && trim($var) === ''){
        $replace = '空';
    }
    $str = str_replace('%str%', $replace, $str);
    echo $str;
    if($debugger) exit;
}


/**
 * 将中文转换成首字母大写
 * 获取首字母
 */
function getfirstchar($s0){
    $fchar = ord($s0{0});
    if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($s0{0});
    $s1 = @iconv("UTF-8","gbk", $s0);
    $s2 = iconv("gbk","UTF-8", $s1);
    if($s2 == $s0){$s = $s1;}else{$s = $s0;}
    $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
    if($asc >= -20319 and $asc <= -20284) return "A";
    if($asc >= -20283 and $asc <= -19776) return "B";
    if($asc >= -19775 and $asc <= -19219) return "C";
    if($asc >= -19218 and $asc <= -18711) return "D";
    if($asc >= -18710 and $asc <= -18527) return "E";
    if($asc >= -18526 and $asc <= -18240) return "F";
    if($asc >= -18239 and $asc <= -17923) return "G";
    if($asc >= -17922 and $asc <= -17418) return "H";
    if($asc >= -17417 and $asc <= -16475) return "J";
    if($asc >= -16474 and $asc <= -16213) return "K";
    if($asc >= -16212 and $asc <= -15641) return "L";
    if($asc >= -15640 and $asc <= -15166) return "M";
    if($asc >= -15165 and $asc <= -14923) return "N";
    if($asc >= -14922 and $asc <= -14915) return "O";
    if($asc >= -14914 and $asc <= -14631) return "P";
    if($asc >= -14630 and $asc <= -14150) return "Q";
    if($asc >= -14149 and $asc <= -14091) return "R";
    if($asc >= -14090 and $asc <= -13319) return "S";
    if($asc >= -13318 and $asc <= -12839) return "T";
    if($asc >= -12838 and $asc <= -12557) return "W";
    if($asc >= -12556 and $asc <= -11848) return "X";
    if($asc >= -11847 and $asc <= -11056) return "Y";
    if($asc >= -11055 and $asc <= -10247) return "Z";
    return null;
}

/**
 * 将中文转换成首字母大写
 * 中文字符转英文字符
 */
function make_semiangle($str){
    $arr = array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G', 'H' => 'H', 'I' => 'I', 'J' => 'J', 'K' => 'K', 'L' => 'L', 'M' => 'M', 'N' => 'N', 'O' => 'O', 'P' => 'P', 'Q' => 'Q', 'R' => 'R', 'S' => 'S', 'T' => 'T', 'U' => 'U', 'V' => 'V', 'W' => 'W', 'X' => 'X', 'Y' => 'Y', 'Z' => 'Z', 'a' => 'a', 'b' => 'b', 'c' => 'c', 'd' => 'd', 'e' => 'e', 'f' => 'f', 'g' => 'g', 'h' => 'h', 'i' => 'i', 'j' => 'j', 'k' => 'k', 'l' => 'l', 'm' => 'm', 'n' => 'n', 'o' => 'o', 'p' => 'p', 'q' => 'q', 'r' => 'r', 's' => 's', 't' => 't', 'u' => 'u', 'v' => 'v', 'w' => 'w', 'x' => 'x', 'y' => 'y', 'z' => 'z', '（' => '(', '）' => ')', '〔' => '[', '〕' => ']', '【' => '[', '】' => ']', '〖' => '[', '〗' => ']', '“' => '"', '”' => '"', '‘' => '\'', '’' => '\'', '｛' => '{', '｝' => '}', '《' => '<', '》' => '>', '％' => '%', '＋' => '+', '—' => '-', '－' => '-', '～' => '-', '：' => ':', '。' => '.', '、' => ',', '，' => ',', '；' => ';', '？' => '?', '！' => '!', '…' => '...', '‖' => '|', '｜' => '|', '〃' => '"', '　' => ' ');
    return strtr($str, $arr);
}

/**
 * 将中文转换成首字母大写
 * 输入中文转换首字母英文
 */
function zh2pinyin($zh){
    $zh = make_semiangle($zh);
    $ret = "";
    $s1 = iconv("utf-8","gbk", $zh);
    $s2 = iconv("gbk","utf-8", $s1);
    if($s2 == $zh){$zh = $s1;}
    for($i = 0; $i < strlen($zh); $i++){
        $s1 = substr($zh,$i,1);
        $p = ord($s1);
        if($p > 160){
            $s2 = substr($zh,$i++,2);
            $ret .= getfirstchar($s2);
        }else{
            $ret .= $s1;
        }
    }
    return $ret;
}

// base64 上传图片
function base64_upload($type,$field,$callback = ''){
    $sBase64 = request($field);
    $file_name_pre = '/storage/'.$type.'/'.date('Y-m-d').'/';
    $return = array();
    if(empty($sBase64)){
        @$callback([]);
        return false;
    }
    if(!is_array($sBase64)){
        $sBase64 = array($sBase64);
    }
    foreach($sBase64 as $base64){
        if(strpos($base64 , "base64,")){
            $base64 = explode('base64,' , $base64)[1];
        }
        $base64 = base64_decode($base64);
        if(empty($base64)) continue;

        $file_name = $file_name_pre.uniqid(date('Ymd').rand('1000','9999')).'.png';
        $save_path = '.'.$file_name;
        if(!is_dir('.'.$file_name_pre)){
            mkdir('.'.$file_name_pre,0777,true);
        }
        file_put_contents($save_path,$base64);
        $return[] = $file_name;
    }
    $callback($return);
    return true;
}

/**
 * @param $files
 * @return mixed
 * 上传到文件服务器
 */
function curl_upfile($files){
    $cwd = rtrim(getcwd(), '/') . '/';

    $ch = curl_init();

    $post = array();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER,array('User-Agent: Opera/9.80 (Windows NT 6.2; Win64; x64) Presto/2.12.388 Version/12.15','Content-Type: multipart/form-data'));
    curl_setopt($ch, CURLOPT_URL,env('FILE_SERVER_URL'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
// same as <input type="file" name="file_box">
    $post = array(
        'AppId'		=> env('FILE_SERVER_APPID'),
        'SafeCode'	=> env('FILE_SERVER_SAFECODE'),
        'Thumnail'	=> '0',
//		'file_box'	=> "@".getcwd().$files,
        'image[]'	=> curl_file_create($cwd . $files),
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    if(curl_errno($ch)){	//出错则显示错误信息
        throw new Exception('上传图片文件过大');
    }
    curl_close($ch); //关闭curl链接
    unlink($cwd . $files);
    preg_match('/<fullpath.*fullpath>/i',$response,$match);
    return strip_tags($match[0]);
}

/**
 * @param $add_status array
 * @return bool
 * 检查事务是否都是插入成功的。
 */
function checkTrans($add_status)
{
    foreach ($add_status as $v) {
        if (!$v && $v !== 0) {
            return false;
        }
        return true;
    }
}



/**
 * 查询快递信息
 * @param $com 物流公司信息，拼音
 * @param $no 快递单号
 *  常见快递公司编码：
公司名称 	公司公司编码
邮政包裹/平邮 	youzhengguonei
国际包裹 	youzhengguoji
EMS 	ems
EMS-国际件 	emsguoji
EMS-国际件 	emsinten
北京EMS 	bjemstckj
顺丰 	shunfeng
申通 	shentong
圆通 	yuantong
中通 	zhongtong
汇通 	huitongkuaidi
韵达 	yunda
宅急送 	zhaijisong
天天 	tiantian
德邦 	debangwuliu
国通 	guotongkuaidi
增益 	zengyisudi
速尔 	suer
中铁物流 	ztky
中铁快运 	zhongtiewuliu
能达 	ganzhongnengda
优速 	youshuwuliu
全峰 	quanfengkuaidi
京东 	jd
 */
function kuaidi($com , $no){
    $host = "http://express.woyueche.com";
    $path = "/query.action";
    $appcode = "ece8cce0e2e84443b684286e65965c89"; // porter的阿里云
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    //根据API的要求，定义相对应的Content-Type
    array_push($headers, "Content-Type".":"."application/x-www-form-urlencoded;charset=UTF-8");

    $url = $host . $path;
    $result = curl_post($url , ['express'=>$com , 'trackingNo'=>$no] , $headers);
    $result =explode("\n" , $result);
    return json_decode(array_pop($result), true);
}


// curl 模拟 post 请求
function curl_post($url,$post_data = array() , $header = false){
    $ch = curl_init(); //初始化curl
    curl_setopt($ch, CURLOPT_URL, $url);//设置链接
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置是否返回信息
    curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
    if($header){
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));//POST数据
    $response = curl_exec($ch);//接收返回信息
    if(curl_errno($ch)){	//出错则显示错误信息
        print curl_error($ch);
    }
    curl_close($ch); //关闭curl链接
    return $response;
}

/**
 * 将数据导出EXCEL
 * @param  [array 一维数组] $title   [标题]
 * @param  [array 二维数组] $content [导出内容]
 * @param  [string] $filename [文件名,默认为data.xls]
 */
function exportData($title , $content , $filename = 'data'){
//	$title = array('标题a' , '标题b' , '标题c');
//	$content = array(
//		array('aa' , 'bb' , 'cc'),
//		array('dd' , 'ee' , 'ff'),
//		array('gg' , 'hh' , 'ii'),
//	);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename=' . $filename . '.xls');
    header('Pragma: no-cache');
    header('Expires: 0');

    echo iconv('utf-8', 'gbk', implode("\t", $title)), "\n";
    foreach ($content as $value) {
        echo iconv('utf-8', 'gbk', implode("\t", $value)), "\n";
    }
    exit();
}

function q($tip){
    if(is_object($tip) || is_string($tip)){
        echo "<pre>";
        var_dump($tip);
    }else{
        echo"<pre>";
        print_r($tip);
    }
}

function ajaxSuccess($msg = '操作成功',$url = '',$data = []){
    $return = ['status'=>1,'url'=>$url,'data'=>$data,'info'=>$msg];
    return response()->json($return);
}

function getSelectList($table , $pid = 0 ,&$result = [] , $spac = -2){
    $spac += 2;
    $list = db($table)->where(["pid"=>$pid,"status"=>1])->field("pid,id,name")->select();     //传递条件数组
    $list = objectToArray($list);
    foreach($list as $value){
        $value["name"] = str_repeat("&nbsp;",$spac).$value["name"];
        $result[] = $value;
        getSelectList($table , $value["id"] , $result , $spac);
    }
    return $result;
}

function recursionArr($arr,$pid = 0) {
    $array = [];
    foreach ($arr as $value) {
        if ($value['pid'] == $pid) {
            $value['child'] = recursionArr($arr,$value['id']);
            $array[] = $value;
        }
    }
    return $array;
}

function recursionGoods($arr) {
    $array = [];
    foreach ($arr as $value) {
        if (isset($value['sub'])) {
            $value['sub'] = recursionGoods($arr);
            $array[] = $value;
        }
    }
    return $array;
}

function _tree_sorts($arr){
    //子分类排序
    foreach ($arr as $key=>$value){
        $arr[$key] = _tree_sorts($value);
    }
    return $arr;
}


function new_images($arr,$dir_name){

    $dir = (ROOT_PATH . 'public' . DS . 'uploads/'.$arr);

    $jpg = strrchr($dir,".");

    $image_name = uniqid().date("Ymd").$jpg;

    $goods_url = str_replace("\\", "/", $dir);

    $new_name = str_replace("\\", "/", $dir_name);

    $name = strrchr($new_name,"/");

    $numbers = substr($name,1)."/".$image_name;

    $dir_bool = copy($goods_url,$new_name."/".$image_name);
    if($dir_bool){
        return $numbers;
    }

}


function new_image($arr,$dir_name){

    $dir = (ROOT_PATH . 'public' . DS . 'upload/'.$arr);

    $jpg = strrchr($dir,".");

    $image_name = uniqid().date("Ymd").$jpg;

    $goods_url = str_replace("\\", "/", $dir);

    $new_name = str_replace("\\", "/", $dir_name);

    $name = strrchr($new_name,"/");

    $numbers = substr($name,1)."/".$image_name;

    $dir_bool = copy($goods_url,$new_name."/".$image_name);
    if($dir_bool){
        return $numbers;
    }

}


function show_category($arr){
    if(!empty($arr)){
        foreach ($arr as $value){
            echo '<ul>' ;
                 echo '<li class="childLi">' ;
                     echo  '<span class="parent_span">' ;
                          echo  $value['name'] ;
                          echo '<button id='.$value['id'].'>' . '+' . '</button>' ;
                     echo  '</span>';
                             if($value["sub"]) {
                                 show_category($value["sub"]);
                             }
                 echo '</li>' ;
            echo  '</ul>';
        }
    }
}


function showCategory($arr,$pid=0,$form=""){   //利用递归函数实现无限分类的效果
    $form.="&nbsp&nbsp&nbsp";   //让下拉框出现无限分类的层次效果
    foreach ($arr as $value){
        if($value['pid']==$pid){   //出现顶级分类的效果
            echo "<option value='{$value['id']}'>".$form.$value['cname']."</option>";  //通过id调用cname名称
            showCategory($arr,$value['id'],$form);   //递归函数，自己调用自己

        }
    }
}

