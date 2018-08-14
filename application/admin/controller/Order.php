<?php
/**
 * Created by PhpStorm.
 * User: 李火生
 * Date: 2018/8/11
 * Time: 11:42
 */
namespace  app\admin\controller;

use think\Controller;
use  think\Db;
use think\Request;

class  Order extends  Controller{

    /**
     **************李火生*******************
     * @return \think\response\View
     * 订单首页
     **************************************
     */
    public function index(){
        $data =Db::name('order')->order('create_time',"desc")->select();
        if(!empty($data)){
            $this->assign('data',$data);
        }
        return view('order_index');
    }
    /**
     **************李火生*******************
     * @param Request $request
     * 模糊查询
     **************************************
     */
    public function search(Request $request){
        if($request->isPost()){
            $keywords =input('search_key');
            $timemin  =strtotime(input('datemin'));
            $timemax  =strtotime(input('datemax'));
            if(empty($timemin)||empty($timemax)){
                $condition = " `goods_name` like '%{$keywords}%' or `id` like '%{$keywords}%' or`user_id` like '%{$keywords}%'";
                $res = Db::name("order")->where($condition)->select();
                return ajax_success('成功',$res);
            }
            if(!empty($timemin)&&!empty($timemax)){
                if(empty($keywords)){
                    $condition = "create_time>{$timemin} and create_time< {$timemax}";
                    $res = Db::name("order")->where($condition)->select();
                    return ajax_success('成功',$res);
                }
                if(!empty($keywords)){
                    $condition = " `goods_name` like '%{$keywords}%' or `id` like '%{$keywords}%' or`user_id` like '%{$keywords}%'";
                    $conditions = "create_time>{$timemin} and create_time< {$timemax}";
                    $res = Db::name("order")->where($condition)->where($conditions)->select();
                    return ajax_success('成功',$res);
                }else{
                    return ajax_error('失败');
                }

            }
        }
    }


    /**
     **************李火生*******************
     * 批量发货
     **************************************
     */
    public function batch_delivery(Request $request){
        if($request->isPost()){
            $id =$_POST['id'];
            if(is_array($id)){
                $where ='id in('.implode(',',$id).')';
            }else{
                $where ='id='.$id;
            }
            $list =  Db::name('order')->where($where)->update(['status'=>3]);
            if($list!==false)
            {
                $this->success('更新成功!');
            }else{
                $this->error('更新失败');
            }
        }
    }





    /**
     **************李火生*******************
     * @return \think\response\View
     * 晒单
     **************************************
     */
    public function sunburn(){

        return view('order_sunburn');
    }




}