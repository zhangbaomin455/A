<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goods;
use App\Models\Cate;
use App\Models\Cart;
class IndexController extends Controller
{
    /**私有的静态属性 */
    protected static $arrCate;
    /*
     * @content 主页
     */
    public function index()
    {
        //轮播图
        $goodsmodel=new Goods;
        $data=$goodsmodel->orderBy('update_time','desc')->select('goods_img')->paginate(14);
        //首页分类
         $catemodel=new Cate;
         $cateInfo=$catemodel->where('pid','=',0)->get();
        //最热商品
        $goodshost=$goodsmodel->where(['is_hot'=>1])->orderBy('update_time','desc')->paginate(2);
        //猜你喜欢商品列表
        $goodsinfo=$goodsmodel->where(['is_new'=>1])->orderBy('update_time','desc')->get();
        return view('index',['data'=>$data],['goodshost'=>$goodshost])
            ->with('goodsinfo',$goodsinfo)
            ->with('cateInfo', $cateInfo);

    }
    /*
     * @content 我的潮购
     */
    public function userpage()
    {
        return view('userpage');
    }

    /*
     * @contetn 购物车
     */
    public function shopcart()
    {
        $cartmodel=new Cart;
        $goodsmodel=new Goods;
        $goodsinfo=$goodsmodel->where('is_hot',1)->get();
        $data=$cartmodel
            ->join('goods','cart.goods_id','=','goods.goods_id')
            ->where(['user_id'=>session('user_id'),'cart_status'=>1])
            ->orderBy('cart.create_time','desc')
            ->get();
        return view('shopcart',['data'=>$data],['goodsinfo'=>$goodsinfo]);
    
    }

    /*
     * @content 所有商品
     */
    public function allshops(Request $request)
    {
        //轮播图
        $goodsmodel=new Goods;
        $data=$goodsmodel->where('is_up','=',1)->orderBy('update_time','desc')->get();
        //分类
        $catemodel=new Cate;
        $cate=$catemodel->where('pid','=',0)->get();
        return view('allshops',['data'=>$data],['cate'=>$cate]);
    }

    /**商品分类展示 */
    public function indexshop($id){
       // $id=$request->input('cate_id');
       // dump($id);die;
        $catemodel=new Cate;
        $data=$catemodel->select("cate_id")->where('pid',0)->get();
        $cate_id=$id;
       // dump($cate_id);die;
        $this->get($id);
        $arr=self::$arrCate;
        $goodsmodel=new Goods;
        $arr=$goodsmodel->whereIn("cate_id",$arr)->get();
       // dump($arr);die;
        //分类
        $catemodel=new Cate;
        $cate=$catemodel->where('pid','=',0)->get();
        return view('allshops',['data'=>$arr],['cate'=>$cate]);
     
    }
    /**私有的方法 */
    private function get($id){
        $catemodel=new Cate;
        $arrIds=$catemodel->select('cate_id')->where("pid",$id)->get();
        if(count( $arrIds)!=0){
            foreach($arrIds as $k=>$v){
                $cateId=$v->cate_id;
                $Ids=$this->get($cateId);
                self::$arrCate[]=$Ids;
            }
        }
    if(count($arrIds)==0){
        return $id;
        }
    }
    //分类下的商品
    public function cateshop(Request $request)
    {
        $cate_id=$request->input('cate_id');
        //分类
        $catemodel=new Cate;
        $cate=$catemodel->where('pid','=',0)->get();
    
        $catemodel=new Cate;
        $this->get($cate_id);
        $cateId=self::$arrCate;
        $goodsmodel=new Goods;
     
      
        $data=$goodsmodel->where('is_up','=',1)->whereIn('cate_id',$cateId)->orderBy('update_time','desc')->get();
       
        return view('div',['data'=>$data]);
    }
    /**点击排序 */
    public function sortshop(Request $request)
    {
        $goodsmodel=new Goods;
        $cate_id=$request->input('cate_id');
        $type=$request->input('_type');
        $top=$request->input('top');
        if($top=='↑'){
            $top="asc";
        }else{
            $top="desc";
        }
        if($cate_id==0){
            $data=$goodsmodel->where('is_up','=',1)->orderBy($type,$top)->get();
        }else{
            $this->get($cate_id);
            $cateId=self::$arrCate;
            $data=$goodsmodel->where('is_up','=',1)->whereIn('cate_id',$cateId)->orderBy($type,$top)->get();
        }

       return view('div',['data'=>$data]);
    }
    /*
     * @content 商品详情
     */
    public function shopcontent($id)
    {
        $goodsmodel=new Goods;
        $goods=$goodsmodel->where('goods_id','=',$id)->first()->toArray();
        $goods['goods_imgs']=rtrim($goods['goods_imgs'],'|');
        $goods['goods_imgs']=explode('|',$goods['goods_imgs']);
        //dump($goods);exit;
        return view('shopcontent',['goods'=>$goods]);
    }

       /*
     * @content 加入购物车
     */
    public function  addCart(Request $request)
    {
        if(empty(session('user_id'))){
            echo json_encode(['font'=>"请登录后操作",'code'=>3]);exit;
        }
        $cartmode=new Cart;
        $goodsmodel=new Goods;
        $goodsInfo=$goodsmodel->where('goods_id',$request->goods_id)->first();
        $arr=$cartmode->where(['goods_id'=>$request->goods_id,'user_id'=>session('user_id'),'cart_status'=>1])->first();
        if(empty($arr)){
            if($goodsInfo->goods_num>=1){
                $data['goods_id']=$request->goods_id;
                $data['user_id']=session('user_id');
                $data['buy_number']=1;
                $data['create_time']=time();
                $res=$cartmode->insert($data);
                if($res){
                    echo json_encode(['font'=>"添加成功",'code'=>1]);exit;
                }else{
                    echo json_encode(['font'=>"添加失败",'code'=>2]);exit;
                }
            }else{
                echo json_encode(['font'=>"库存不足,加入失败",'code'=>2]);exit;
            }
        }else{
            if($goodsInfo->goods_num>$arr->buy_number){
                $arr->buy_number=$arr->buy_number+1;
                $res=$arr->save();
                if($res){
                    echo json_encode(['font'=>"添加成功",'code'=>1]);exit;
                }else{
                    echo json_encode(['font'=>"添加失败",'code'=>2]);exit;
                }
            }else{
                echo json_encode(['font'=>"库存不足,加入失败",'code'=>2]);exit;
            }

        }
    }



    /*
     * @content 修改库存
     */
    public function priceadd(Request $request)
    {
        $cartmodel=new Cart;
        $where=[
            'user_id'=>session('user_id'),
            'goods_id'=>$request->goods_id,
            'cart_status'=>1
        ];
        $arr=$cartmodel->where($where)->first();
        $goodsmodel=new Goods;
        $goodsInfo=$goodsmodel->where('goods_id',$request->goods_id)->first();
        if($request->type==1){
            $arr->buy_number=$arr->buy_number+1;
        }else{
            if($request->buy_number>1){
                $arr->buy_number=$arr->buy_number-1;
            }else{
                echo 3;exit;
            }
            
        }
        if($goodsInfo->goods_num>$request->buy_number){
            $res=$arr->save();
            if($res){
                echo 1;
            }else{
                echo 2;
            }
        }else{
            echo 3;
        }

    }

    //单删
    public function cartdel(Request $request)
    {
        $cartmodel=new Cart;
        $where=[
            'goods_id'=>$request->goods_id,
            'user_id'=>session('user_id')
        ];
        $arr=$cartmodel->where($where)->first();
        $arr->cart_status=2;
        $res=$arr->save();
        if($res){
            echo json_encode(['font'=>"删除成功",'code'=>1]);exit;
        }else{
            echo json_encode(['font'=>"删除失败",'code'=>2]);exit;
        }
    }
    //批删
    public function cartdels(Request $request)
    {
        $goods_id=explode(',',rtrim($request->goods_id,','));
        $cartmodel=new Cart;
        $res=Cart::where('user_id',session('user_id'))
            ->whereIn('goods_id',$goods_id)
            ->update(['cart_status' => 2]);
        if($res){
            echo json_encode(['font'=>"删除成功",'code'=>1]);exit;
        }else{
            echo json_encode(['font'=>"删除失败",'code'=>2]);exit;
        }
    }
}
