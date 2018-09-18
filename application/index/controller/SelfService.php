<?php
/**
 * Created by PhpStorm.
 * User: 李火生
 * Date: 2018/8/11
 * Time: 17:05
 */
namespace  app\index\controller;
use think\Controller;
use think\Request;
use think\Session;
use think\Db;

class  SelfService extends  Controller{

    /**
     * 售后服务列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function index(){
        return view('index');
    }



    /**
     * 售后维修
     * 陈绪
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function repair(){
        $data = Session::get("member");
        $user_id =db("user")->field('id')->where('phone_num',$data['phone_num'])->find();
        $order = db("order")->where("status",">=",5)->where("status","<=",7)->whereOr("status",10)->select();
        $serve = [];
        foreach ($order as $key=>$value){
            if($user_id["id"] == $value["user_id"]) {
                $goods = db("goods")->where("id", $value["goods_id"])->field("goods_show_images")->find();
                $serve[$key]["images"] = $goods["goods_show_images"];
                $serve[$key]["goods_name"] = $value["goods_name"];
                $serve[$key]["user_id"] = $value["user_id"];
                $serve[$key]["id"] = $value['id'];
                $serve[$key]["order_money"] = $value["pay_money"];
                $serve[$key]["order_num"] = $value["order_num"];
                $serve[$key]["create_time"] = $value["create_time"];
            }
        }

        $serve_id = db("serve")->select();
        foreach ($serve_id as $val){
           foreach ($serve as $k=>$v){
               if($val["order_id"] == $v['id']){
                   unset($serve[$k]);
               }
           }
        }
        return view('repair',["serve"=>$serve]);
    }



    /**
     * 问题描述
     * 陈绪
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function repair_desc(Request $request){
        if($request->isPost()){
            $id = Session::get("order_id");
            $order = db("order")->where("id",$id)->field("id,order_num,goods_id,goods_img,user_id,goods_name,harvest_address,harvester,harvest_phone_num,pay_money")->find();
            return ajax_success("获取成功",$order);
        }
        $province = Db::name('tree')->where (array('pid'=>1) )->select();
        $this->assign('province',$province);        
        return view('repair_desc');
    }



    /**
     * 问题描述
     * 陈绪
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function repair_ajax(Request $request){
        if($request->isPost()){
            $id = $request->only(["id"])["id"];
            Session("order_id",$id);
            return ajax_success("获取成功");
        }
    }



    /**
     * 提交成功
     * 陈绪
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
     public function successful_sub(Request $request){
         if($request->isPost()){
            $serve_data = $request->param();
            $serve_data["status"] = 1;
            $serve_data["serve_num"] = "SN".date("YmdHis").uniqid();
            $serve_data["create_time"] = time();
            $bool = db("serve")->insert($serve_data);
            if($bool){
                $serve_image = [];
                $serve_img = $request->file("serve_img");
                $serve_id = db("serve")->getLastInsID();
                foreach ($serve_img as $value){
                    $info = $value->move(ROOT_PATH . 'public' . DS . 'upload');
                    $serve_url = str_replace("\\", "/", $info->getSaveName());
                    $serve_image[] = ["serve_img" => $serve_url, "serve_id" => $serve_id];
                }
                $booldata = model("serve_images")->saveAll($serve_image);
                if($booldata){
                    return ajax_success("入库成功");
                }else{
                    return ajax_error("入库成功");
                }
            }
         }
         return view('successful_sub');
    }


    /**
     * 处理中
     * 陈绪
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function processing(){

        $serve = db("serve")->select();
        return view('processing',["serve"=>$serve]);

    }


    /**
     * 评价
     * 陈绪
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function evaluation(){
        return view('evaluation');
    }



    /**
     * 服务单详情
     * 陈绪
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function detail_info($id){
        $serve = db("serve")->where("id",$id)->find();
        return view('detail_info',["serve"=>$serve]);

    }


    public function  address_edit(Request $request){
        if($request->isPost()){
            $order_numbers =$request->only(['id'])['id'];
            dump($order_numbers);exit();
            if(!empty($order_numbers)){
                $datas = Db::name('user')->field('harvester,harvester_phone_num,city,address')->where('phone_num',$member['phone_num'])->find();
                if(!empty($data['city'])){
                    $my_position =explode(",",$datas['city']);
                    $position = $my_position[0].$my_position[1].$my_position[2].$datas['address'];
                    $data=[
                        'city'=>$my_position,
                        'position'=>$position,
                        'harvester'=>$datas['harvester'],
                        'harvester_phone_num'=>$data['harvester_phone_num'],
                    ];
                        if(!empty($data)){
                            return ajax_success('成功返回数据',$data);
                        }
        
                }
               
            }

        }
    }


}