<?php
/**
 * Created by PhpStorm.
 * User: 李火生
 * Date: 2018/8/7
 * Time: 15:05
 */
namespace  app\index\controller;

use think\Controller;
use think\Request;
use  think\Db;
use think\Response;
use think\Session;

class  Member extends  Base {
    /**
     **************李火生*******************
     * @return \think\response\View]
     * 用户页面
     **************************************
     */
    public  function  index(){
        return view('member_index');
    }

    /**
     **************李火生*******************
     * @param Request $request
     * @return \think\response\View|void
     * 收货地址管理
     **************************************
     */

    public function address(Request $request){
        $province = Db::name('tree')->where (array('pid'=>1) )->select();
        $this->assign('province',$province);
        if($request->isPost()){
            $data =Session('member');
            $member_id =Db::name('user')->field('id')->where('phone_num',$data['phone_num'])->find();
            $data =Db::name('user')->where('id',$member_id)->find();
            return ajax_success('获取成功',$data);
        }
        return view('address');
    }

    public function getRegions(){
        $Region=Db::name("tree");
        $map['pid']=$_REQUEST["pid"];
        $map['type']=$_REQUEST["type"];
        $list=$Region->where($map)->select();
        echo json_encode($list);
    }

    /**
     **************李火生*******************
     * @param Request $request
     * 收货信息
     **************************************
     */
    public function  harvester_informations(Request $request){
        if($request->isPost()){
            $member =Session('member');
            $member_id =Db::name('user')->field('id')->where('phone_num',$member['phone_num'])->find();
            $data=$_POST;
            $datas =[
              'harvester'=>$data['harvester'],
                'harvester_phone_num'=>$data['harvester_phone_num'],
                'city'=>$data['city_information'],
                'province_id'=>$data['province_id'],
                'city_id'=>$data['city_id'],
                'town_id'=>$data['town_id'],
                'address'=>$data['address'],
            ];
            if(!$_POST['harvester']){
                $this->error('收获人不能为空');
            }
            if(!$_POST['harvester_phone_num']){
                $this->error('收获人手机号不能为空');
            }
            if(!$_POST['province']){
                $this->error('省级地址不能为空');
            }
            if(!$_POST['city']){
                $this->error('市级地址不能为空');
            }
            if(!$_POST['town']){
                $this->error('县级地址不能为空');
            }
            if(!$_POST['address']){
                $this->error('具体收货街道地址不能为空');
            }
            if(!empty($_POST['harvester'])&&
                !empty($_POST['harvester_phone_num'])&&
                !empty($_POST['province'])&&
                !empty($_POST['city'])&&
                !empty($_POST['town'])&&
                !empty($_POST['harvester'])
            ){
                $res = Db::name('user')->where('id',$member_id['id'])->update($datas);
                if($res){
                    return ajax_success('成功',$res);
                }
            }else{
                return ajax_error('失败');
            }
        }
    }


}