<?php

namespace App\SwaggerModel ;

/**
 * @SWG\Definition(
 *   definition="muser",
 *   description="用户表"
 * )
 */
class User {

    public $name ;
    /**
     * 昵称
     * @var string
     * @SWG\Property(description="昵称")
     */
    public $nickname ;
    /**
     * 联系人
     * @var string
     * @SWG\Property(description="联系人")
     */
    public $contact ;
    /**
     * 手机号
     * @var string
     * @SWG\Property(description="手机号")
     */
    public $mobile ;
    /**
     * 省
     * @var string
     * @SWG\Property(description="省")
     */
    public $province_id ;
    /**
     * 市
     * @var string
     * @SWG\Property(description="市")
     */
    public $city_id ;
    /**
     * 区
     * @var string
     * @SWG\Property(description="区")
     */
    public $area_id ;
    /**
     * 商店描述
     * @var string
     * @SWG\Property(description="商店描述")
     */
    public $shop_desc ;
    /**
     * 头像
     * @var string
     * @SWG\Property(description="头像")
     */
    public $headimgurl ;
    /**
     * 出售类型
     * @var string
     * @SWG\Property(description="出售类型")
     */
    public $sell_type ;
    /**
     * wx名称
     * @var string
     * @SWG\Property(description="wx名称")
     */
    public $wx_name ;
    /**
     * qqopenid
     * @var string
     * @SWG\Property(description="qqopenid")
     */
    public $qq_openid ;
    /**
     * qq头像
     * @var string
     * @SWG\Property(description="qq头像")
     */
    public $qq_headimgurl ;
    /**
     * qq名称
     * @var string
     * @SWG\Property(description="qq名称")
     */
    public $qq_name ;
    /**
     * wxopenid
     * @var string
     * @SWG\Property(description="wxopenid")
     */
    public $wx_openid ;
    /**
     * wx头像
     * @var string
     * @SWG\Property(description="wx头像")
     */
    public $wx_headimgurl ;
    /**
     * 真实姓名
     * @var string
     * @SWG\Property(description="真实姓名")
     */
    public $real_name ;
    /**
     * 支付宝账号
     * @var string
     * @SWG\Property(description="支付宝账号")
     */
    public $alipay ;
    /**
     * 微信账号
     * @var string
     * @SWG\Property(description="微信账号")
     */
    public $wechat ;
    /**
     * 首次养宠时间
     * @var string
     * @SWG\Property(description="首次养宠时间")
     */
    public $first_keep_pets_time ;
    /**
     * 生日
     * @var string
     * @SWG\Property(description="生日")
     */
    public $birthday ;
    /**
     * 性别
     * @var string
     * @SWG\Property(description="性别")
     */
    public $sex ;
    /**
     * 邮箱
     * @var string
     * @SWG\Property(description="邮箱")
     */
    public $email;
    /**
     * 用户认证信息
     * @var string
     * @SWG\Property(description="出售类型",ref="#/definitions/muser_identify")
     */
    public $identify ;
}

/**
 * @SWG\Definition(
 *   definition="muser_identify",
 *   description="用户商店|个人商店表"
 * )
 */
class UserIdentify {
    /**
     * 出售类型
     * @var string
     * @SWG\Property(description="出售类型")
     */
    public $sell_type ;
    /**
     * 商店名称
     * @var string
     * @SWG\Property(description="商店名称")
     */
    public $shop_name ;
    /**
     * 用户名
     * @var string
     * @SWG\Property(description="用户名")
     */
    public $username ;
    /**
     * 身份证号
     * @var string
     * @SWG\Property(description="身份证号")
     */
    public $idcard ;
    /**
     * 身份证图片地址
     * @var string
     * @SWG\Property(description="身份证图片地址")
     */
    public $idcard_imgurl ;
    /**
     * 手机号
     * @var string
     * @SWG\Property(description="手机号")
     */
    public $mobile ;
    /**
     * 地址
     * @var string
     * @SWG\Property(description="地址")
     */
    public $address ;
    /**
     * 银行名字
     * @var string
     * @SWG\Property(description="银行名字")
     */
    public $bank_name ;
    /**
     * 银行账号
     * @var string
     * @SWG\Property(description="银行账号")
     */
    public $bank_no ;
    /**
     * 营业执照
     * @var string
     * @SWG\Property(description="营业执照")
     */
    public $license_imgurl ;
    /**
     * 用户编号
     * @var string
     * @SWG\Property(description="用户编号")
     */
    public $user_id ;
    /**
     * 经度
     * @var string
     * @SWG\Property(description="经度")
     */
    public $lon ;
    /**
     * 纬度
     * @var string
     * @SWG\Property(description="纬度")
     */
    public $lat ;
    /**
     * 是否认证
     * @var string
     * @SWG\Property(description="是否认证")
     */
    public $is_valid ;
    /**
     * 省
     * @var string
     * @SWG\Property(description="省")
     */
    public $province_id ;
    /**
     * 市
     * @var string
     * @SWG\Property(description="市")
     */
    public $city_id ;
    /**
     * 区
     * @var string
     * @SWG\Property(description="区")
     */
    public $area_id ;

    /**
     * @var string
     * @SWG\Property(description="狗" ,ref="#/definitions/mdog")
     */
    public $dogs ;
}


/**
 * @SWG\Definition(
 *   definition="mdog_category",
 *   description="狗分类表"
 * )
 */
class DogCategories {
    /**
     * 名字
     * @var string
     * @SWG\Property(description="名字")
     */
    public $name ;
    /**
     * 缩略图
     * @var string
     * @SWG\Property(description="缩略图")
     */
    public $thumb ;
    /**
     * 上级id
     * @var string
     * @SWG\Property(description="上级id")
     */
    public $pid ;

    /**
     * 是否热门
     * @var string
     * @SWG\Property(description="是否热门")
     */
    public $is_hot ;
    /**
     * 拼音首字母
     * @var string
     * @SWG\Property(description="拼音首字母")
     */
    public $pinyin ;
}

/**
 * @SWG\Definition(
 *   definition="mdog",
 *   description="狗表"
 * )
 */
class Dogs {
    /**
     * 分类
     * @var string
     * @SWG\Property(description="分类")
     */
    public $cate_id ;

    /**
     * 疫苗次数
     * @var string
     * @SWG\Property(description="疫苗次数")
     */
    public $vaccine ;
    /**
     * 性别
     * @var string
     * @SWG\Property(description="性别")
     */
    public $sex;
    /**
     * 是否绝育 0 否  1是
     * @var string
     * @SWG\Property(description="是否绝育 0 否  1是")
     */
    public $sterilization;
    /**
     * 宠物品级0宠物级、1血统级
     * @var string
     * @SWG\Property(description="宠物品级0宠物级、1血统级")
     */
    public $grade;
    /**
     * 宠物体型:012小中大
     * @var string
     * @SWG\Property(description="宠物体型:012小中大")
     */
    public $body_size;
    /**
     * 是否驱虫:次数
     * @var string
     * @SWG\Property(description="是否驱虫:次数")
     */
    public $insect;
    /**
     * 是否预售:0否1 是
     * @var string
     * @SWG\Property(description=" 是否预售:0否1 是")
     */
    public $is_presell;
    /**
     * 健康保证天数
     * @var string
     * @SWG\Property(description="健康保证天数")
     */
    public $health_ensure_days;
    /**
     * 宝贝标题
     * @var string
     * @SWG\Property(description="宝贝标题")
     */
    public $title;
    /**
     * 宠物品级0宠物级、1血统级
     * @var string
     * @SWG\Property(description="宠物品级0宠物级、1血统级")
     */
    public $keywords;
    /**
     * 一口价
     * @var string
     * @SWG\Property(description=" 一口价")
     */
    public $buyout_price;
    /**
     * 市场价
     * @var string
     * @SWG\Property(description="市场价")
     */
    public $market_price;
    /**
     * 预售价格
     * @var string
     * @SWG\Property(description="预售价格")
     */
    public $presell_price;
    /**
     * 简介
     * @var string
     * @SWG\Property(description="简介")
     */
    public $desc;
    /**
     * 商店id
     * @var string
     * @SWG\Property(description="商店id")
     */
    public $shop_id;
    /**
     * 详情
     * @var string
     * @SWG\Property(description="详情")
     */
    public $detail;
    /**
     * 用户编号
     * @var string
     * @SWG\Property(description="用户编号")
     */
    public $user_id;
    /**
     * 评论数
     * @var string
     * @SWG\Property(description="评论数")
     */
    public $comments ;
    /**
     * 购买数
     * @var string
     * @SWG\Property(description="购买数")
     */
    public $buy_counts;

}
/**
 * @SWG\Definition(
 *   definition="mdog_files",
 *   description="狗文件表"
 * )
 */
class DogFiles {
    /**
     * @var string
     * @SWG\Property(description="类型 1图片 2视频")
     */
    public $type;
    /**
     * 狗编号
     * @var string
     * @SWG\Property(description="狗编号")
     */
    public $dog_id;
    /**
     * @var string
     * @SWG\Property(description="地址")
     */
    public $url;
}
/**
 * @SWG\Definition(
 *   definition="msms",
 *   description="短信表"
 * )
 */
class Sms{
    /**
     * @var string
     * @SWG\Property(description="短信类型: login|登录 register|注册 change_mobile|更改手机号")
     */
    public $type;

    /**
     * @var string
     * @SWG\Property(description="验证码")
     */
    public $code;
    /**
     * @var string
     * @SWG\Property(description="手机号")
     */
    public $mobile;
}
/**
 * @SWG\Definition(
 *   definition="marticle_category",
 *   description="文章分类表"
 * )
 */
class ArticleCategory{
    /**
     * @var string
     * @SWG\Property(description="分类名称")
     */
    public $name;

    /**
     * @var string
     * @SWG\Property(description="缩略图")
     */
    public $thumb;
    /**
     * @var string
     * @SWG\Property(description="上级id")
     */
    public $pid;
}


/**
 * @SWG\Definition(
 *   definition="marticle",
 *   description="文章表"
 * )
 */
class Article{
    /**
     * @var string
     * @SWG\Property(description="分类id")
     */
    public $cate_id;

    /**
     * @var string
     * @SWG\Property(description="标题")
     */
    public $title;
    /**
     * @var string
     * @SWG\Property(description="缩略图")
     */
    public $thumb;
    /**
     * @var string
     * @SWG\Property(description="来源")
     */
    public $from ;
    /**
     * @var string
     * @SWG\Property(description="内容")
     */
    public $content ;
}

/**
 * @SWG\Definition(
 *   definition="mBaikeDetail",
 *   description="百科详情"
 * )
 */
class BaikeDetail{
    /**
     * @var string
     * @SWG\Property(description="banner图")
     */
    public $banner_imgurl;
    /**
     * @var string
     * @SWG\Property(description="介绍")
     */
    public $desc ;
    /**
     * @var string
     * @SWG\Property(description="市场价")
     */
    public $market_price ;
    /**
     * @var string
     * @SWG\Property(description="发展历史")
     */
    public $history;
    /**
     * @var string
     * @SWG\Property(description="形态特征")
     */
    public $feature ;
}


/**
 * @SWG\Definition(
 *   definition="mBaikeDogDetail",
 *   description="百科犬种详情"
 * )
 */
class BaikeDogDetail{
    /**
     * @var string
     * @SWG\Property(description="中文名")
     */
    public $cn_name;
    /**
     * @var string
     * @SWG\Property(description="英文名")
     */
    public $en_name;
    /**
     * @var string
     * @SWG\Property(description="别名")
     */
    public $alias;
    /**
     * @var string
     * @SWG\Property(description="界")
     */
    public $world;
    /**
     * @var string
     * @SWG\Property(description="地域")
     */
    public $area;
    /**
     * @var string
     * @SWG\Property(description="禁忌食物")
     */
    public $dislike_food;
    /**
     * @var string
     * @SWG\Property(description="易患病")
     */
    public $easy_illness;
    /**
     * @var string
     * @SWG\Property(description="身高")
     */
    public $height;
    /**
     * @var string
     * @SWG\Property(description="用途")
     */
    public $usage;
    /**
     * @var string
     * @SWG\Property(description="体重")
     */
    public $weight;
    /**
     * @var string
     * @SWG\Property(description="寿命")
     */
    public $age;
    /**
     * @var string
     * @SWG\Property(description="百科id")
     */
    public $baike_id;
}
/**
 * @SWG\Definition(
 *   definition="mBaikePrice",
 *   description="百科价格趋势"
 * )
 */
class BaikePrice{
    /**
     * @var string
     * @SWG\Property(description="低端")
     */
   public $low;
    /**
     * @var string
     * @SWG\Property(description="中端")
     */
   public $medium;
    /**
     * @var string
     * @SWG\Property(description="高端")
     */
   public $high;
    /**
     * @var string
     * @SWG\Property(description="时间")
     */
   public $created_at;
}
/**
 * @SWG\Definition(
 *   definition="mVideos",
 *   description="视频"
 * )
 */
class Videos{
    /**
     * @var string
     * @SWG\Property(description="标题")
     */
    public $title ;
    /**
     * @var string
     * @SWG\Property(description="地址")
     */
    public $url;
    /**
     * @var string
     * @SWG\Property(description="点击数")
     */
    public $click_count;
}
/**
 * @SWG\Definition(
 *   definition="mAddress",
 *   description="地址"
 * )
 */
class Address{
    /**
     * @var string
     * @SWG\Property(description="省id")
     */
    public $province_id ;
    /**
     * @var string
     * @SWG\Property(description="市id")
     */
    public $city_id ;
    /**
     * @var string
     * @SWG\Property(description="区id")
     */
    public $area_id ;
    /**
     * @var string
     * @SWG\Property(description="省名称")
     */
    public $province_name ;
    /**
     * @var string
     * @SWG\Property(description="市名称")
     */
    public $city_name ;
    /**
     * @var string
     * @SWG\Property(description="区名称")
     */
    public $area_name ;
    /**
     * @var string
     * @SWG\Property(description="用户编号")
     */
    public $user_id ;
    /**
     * @var string
     * @SWG\Property(description="手机号")
     */
    public $mobile ;
    /**
     * @var string
     * @SWG\Property(description="用户姓名")
     */
    public $username ;
    /**
     * @var string
     * @SWG\Property(description="是否默认：0否，1是")
     */
    public $is_default;
}

/**
 * @SWG\Definition(
 *   definition="mOrders",
 *   description="订单"
 * )
 */
class Orders {
    /**
     * @var string
     * @SWG\Property(description="订单号")
     */
    public $orderno ;
    /**
     * @var string
     * @SWG\Property(description="省")
     */
    public $province_id ;
    /**
     * @var string
     * @SWG\Property(description="市")
     */
    public $city_id ;
    /**
     * @var string
     * @SWG\Property(description="区")
     */
    public $area_id ;
    /**
     * @var string
     * @SWG\Property(description="发货方式")
     */
    public $shipping_type ;
    /**
     * @var string
     * @SWG\Property(description="收货人")
     */
    public $shipping_name ;
    /**
     * @var string
     * @SWG\Property(description="手机号")
     */
    public $shipping_mobile ;
    /**
     * @var string
     * @SWG\Property(description="收货详细地址")
     */
    public $shipping_address ;
    /**
     * @var string
     * @SWG\Property(description="原价")
     */
    public $origin_price ;
    /**
     * @var string
     * @SWG\Property(description="是否预售")
     */
    public $is_pre ;
    /**
     * @var string
     * @SWG\Property(description="预售价格")
     */
    public $pre_price ;
    /**
     * @var string
     * @SWG\Property(description="邮费")
     */
    public $shipping_price ;
    /**
     * @var string
     * @SWG\Property(description="数量")
     */
    public $number ;
    /**
     * @var string
     * @SWG\Property(description="支付方式", enum="{'alipay','weixin'}")
     */
    public $payment ;
    /**
     * @var string
     * @SWG\Property(description="订单状态:0已提交，1已支付,2已发货，3已收货，4已评价，5订单取消，6发起退货，7已退货")
     */
    public $order_status ;
    /**
     * @var string
     * @SWG\Property(description="支付状态:0未支付,1正在支付，2支付成功，3支付失败")
     */
    public $pay_status ;
    /**
     * @var string
     * @SWG\Property(description="用户编号")
     */
    public $user_id ;
    /**
     * @var string
     * @SWG\Property(description="创建日期")
     */
    public $created_at ;
    /**
     * @var string
     * @SWG\Property(description="狗" ,ref="#/definitions/mdog")
     */
    public $dog ;
}
/**
 * @SWG\Definition(
 *   definition="mregion",
 *   description="省市区"
 * )
 */
class Region{
    /**
     * @var int
     * @SWG\Property(description="id")
     */
    public $id ;
    /**
     * @var int
     * @SWG\Property(description="邮编")
     */
    public $region_id ;
    /**
     * @var int
     * @SWG\Property(description="父级")
     */
    public $parent_region_id ;
    /**
     * @var int
     * @SWG\Property(description="名称")
     */
    public $name ;
}

/**
 * @SWG\Definition(
 *   definition="mdogCollect",
 *   description="收藏"
 * )
 */
class DogCollect{
    /**
     * @var int
     * @SWG\Property(description="id")
     */
    public $id ;
    /**
     * @var int
     * @SWG\Property(description="用户id")
     */
    public $user_id ;
    /**
     * @var int
     * @SWG\Property(description="狗id")
     */
    public $dog_id ;
    /**
     * @var int
     *  @SWG\Property(description="狗" ,ref="#/definitions/mdog")
     */
    public $dog ;
}
