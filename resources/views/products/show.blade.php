@extends('layouts.shop')


@section('main')
    <div class="listMain">
        <!--放大镜-->

        <div class="item-inform">
            <div class="clearfixLeft" id="clearcontent">

                <div class="box">
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $(".jqzoom").imagezoom();
                            $("#thumblist li a").click(function() {
                                $(this).parents("li").addClass("tb-selected").siblings().removeClass("tb-selected");
                                $("#jqzoom").attr('src', $(this).find("img").attr("src"));
                            });
                        });
                    </script>

                    <div class="tb-booth tb-pic tb-s310">
                        <img src="{{ $product->thumb }}" alt="{{ $product->name }}" id="jqzoom" />
                    </div>
                    <ul class="tb-thumb" id="thumblist">
                        @foreach ($product->pictures as $key => $image)
                            <li class="{{ $key == 0 ? 'tb-selected' : '' }}">
                                <div class="tb-pic tb-s40">
                                    <a href="javascript:;">
                                        <img src="{{ imageUrl($image) }}">
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="clear"></div>
            </div>

            <div class="clearfixRight">

                <!--规格属性-->
                <!--名称-->
                <div class="tb-detail-hd">
                    <h1>
                        {{ $product->name }}
                    </h1>
                </div>
                <div class="tb-detail-list">
                    <!--价格-->
                    <div class="tb-detail-price">
                        <li class="price iteminfo_price">
                            <dt>促销价</dt>
                            <dd><em>¥</em><b class="sys_item_price">{{ $product->price }}</b>  </dd>
                        </li>
                        <li class="price iteminfo_mktprice">
                            <dt>原价</dt>
                            <dd><em>¥</em><b class="sys_item_mktprice">{{ $product->price_original }}</b></dd>
                        </li>
                        <div class="clear"></div>
                    </div>

                    <!--地址-->
                    <dl class="iteminfo_parameter freight">
                        <dt>收货地址</dt>
                        <div class="iteminfo_freprice">
                            <div class="am-form-content address">

                                @if ($addresses->isNotEmpty())
                                    <select class="form-control" style="width: 100%" name="address_id">
                                        @foreach($addresses as $address)
                                            <option value="{{ $address->id }}" {{ $address->is_default ? 'selected' : '' }}>{{ $address->name }}/{{ $address->phone }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <a style="line-height:27px;color:red;" href="/user/addresses">添加收货地址</a>
                                @endif

                            </div>
                        </div>
                    </dl>
                    <div class="clear"></div>

                    <!--销量-->
                    <ul class="tm-ind-panel">
                        <li class="tm-ind-item tm-ind-sumCount canClick">
                            <div class="tm-indcon"><span class="tm-label">累计销量</span><span class="tm-count">{{ $product->safe_count }}</span></div>
                        </li>
                        <li class="tm-ind-item tm-ind-reviewCount canClick tm-line3">
                            <div title="滑动到下方收藏的用户查看"  class="tm-indcon"><span class="tm-label">累计收藏</span><span class="tm-count">{{ $product->users->count() }}</span></div>
                        </li>
                    </ul>
                    <div class="clear"></div>

                    <!--各种规格-->
                    <dl class="iteminfo_parameter sys_item_specpara">
                        <dt class="theme-login"><div class="cart-title">可选规格<span class="am-icon-angle-right"></span></div></dt>
                        <dd>
                            <!--操作页面-->

                            <div class="theme-popover-mask"></div>

                            <div class="theme-popover">
                                <div class="theme-span"></div>
                                <div class="theme-poptit">
                                    <a href="javascript:;" title="关闭" class="close">×</a>
                                </div>
                                <div class="theme-popbod dform">
                                    <form class="theme-signin" name="" action="" method="post">

                                        <div class="theme-signin-left">
                                            <div class="theme-options">
                                                <div class="cart-title number">数量</div>
                        <dd>
                            <input id="min" class="am-btn am-btn-default" type="button" value="-" />
                            <input id="text_box" name="numbers" type="text" value="1" style="width:30px;" />
                            <input id="add" class="am-btn am-btn-default"  type="button" value="+" />
                            <span id="Stock" class="tb-hidden">库存<span class="stock">{{ $product->count }}</span>件</span>
                        </dd>
                    </dl>


                </div>
                <div class="clear"></div>

                <!--按钮	-->
                <div class="pay">
                    <div class="pay-opt">
                        <a href="/"><span class="am-icon-home am-icon-fw">首页</span></a>
                        @auth
                            @if ($product->userIsLike)
                                <a href="javascript:;" style="display: none" id="likes_btn"><span class="am-icon-heart am-icon-fw" >收藏</span></a>
                                <a href="javascript:;"  id="de_likes_btn"><span class="am-icon-heart am-icon-fw">取消收藏</span></a>
                            @else
                                <a href="javascript:;"  id="likes_btn"><span class="am-icon-heart am-icon-fw">收藏</span></a>
                                <a href="javascript:;" style="display: none" id="de_likes_btn"><span class="am-icon-heart am-icon-fw" >取消收藏</span></a>
                            @endif
                        @endauth

                        @guest
                            <a href="javascript:;"  id="likes_btn"><span class="am-icon-heart am-icon-fw">收藏</span></a>
                        @endguest
                    </div>
                    <ul>
                        <li>
                            <div class="clearfix tb-btn" id="nowBug">
                                @auth
                                    <a  href="javascript:;" >立即购买</a>
                                @endauth
                                @guest
                                    <a href="/login?redirect_url={{ url()->current() }}">立即购买</a>
                                @endguest

                            </div>
                        </li>
                        <li>
                            <div class="clearfix tb-btn tb-btn-basket">
                                <a  title="加入购物车" href="javascript:;"  id="addCar"><i></i>加入购物车</a>
                            </div>
                        </li>
                    </ul>

                    <div class="clear"></div>
                </div>
                <input type="hidden" name="product_id" value="{{ $product->uuid }}">

            </div>


            </form>
        </div>
    </div>

    <div class="clear"></div>




    <!-- introduce-->

    <div class="introduce">
        <div class="browse">
            <div class="mc">
                <ul>
                    <div class="mt">
                        <h2>推荐</h2>
                    </div>

                    @foreach ($recommendProducts as $recommendProduct)
                        <li class="first">
                            <div class="p-img">
                                <a href="/products/{{ $recommendProduct->uuid }}">
                                    <img class="media-object" src="{{ $recommendProduct->thumb }}" alt="{{ $recommendProduct->name }}" width="80">
                                </a>
                            </div>
                            <div class="p-name"><a href="/products/{{ $recommendProduct->uuid }}">
                                    {{ $recommendProduct->name }}
                                </a>
                            </div>
                            <div class="p-price"><strong>
                                    ￥ {{ $recommendProduct->price }}
                                </strong></div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div class="introduceMain">
            <div class="am-tabs" data-am-tabs>
                <ul class="am-avg-sm-3 am-tabs-nav am-nav am-nav-tabs">

                    <li class="am-active">
                        <a href="#"><span class="index-needs-dt-txt">商品评论</span></a>
                    </li>

                    <li>
                        <a href="#"><span class="index-needs-dt-txt">宝贝详情</span></a>
                    </li>

                    <li>
                        <a href="#"><span class="index-needs-dt-txt">收藏的用户</span></a>
                    </li>
                </ul>

                <div class="am-tabs-bd">


                    <div class="am-tab-panel am-fade am-in am-active">
                        <div class="post-review panel p-20">
                            <h3 class="h-title">评论</h3>
                            <form class="horizontal-form pt-30" action="#">
                                <div class="row row-v-10">
                                    <div class="col-xs-12">
                                        <select id="comment_detail" class="form-control">
                                            @foreach ($orderDetails as $detail)
                                                <option value="{{ $detail->id }}">订单流水：{{ $detail->order->no }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xs-12">
                                        <select id="comment_score" class="form-control">
                                            <option value="1">1分</option>
                                            <option value="2">2分</option>
                                            <option value="3">3分</option>
                                            <option value="4">good</option>
                                            <option value="5">very good</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12">
                                        <textarea id="comment_content" class="form-control" placeholder="写下你对商品的评论" rows="6"></textarea>
                                    </div>
                                    <div class="col-xs-12 text-right">
                                        @if ($orderDetails->isEmpty())
                                            <button type="button" id="comment_btn" disabled="disabled" class="btn mt-20">请先去购买商品再评论</button>
                                        @else
                                            <button type="button" id="comment_btn" class="btn mt-20">评论</button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="posted-review panel p-30">
                            <h3 class="h-title">{{ $product->comments->count() }} 评论</h3>
                            @foreach ($product->comments as $comment)
                                <div class="review-single pt-30">
                                    <div class="media">
                                        <div class="media-left">
                                            <img class="media-object mr-10 radius-4" src="{{ $comment->user->avatar }}" width="90" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="review-wrapper clearfix">
                                                <ul class="list-inline">
                                                    <li>
                                                        <span class="review-holder-name h5">{{ $comment->user->name }}</span>
                                                    </li>
                                                    <li>
                                                        <div class="rating">
                                                            <span class="rating-stars" data-rating="5">
                                                                {!! str_repeat('<i class="fa fa-star-o"></i>', 5 - $comment->score) !!}
                                                                {!! str_repeat('<i class="fa fa-star-o star-active"></i>', $comment->score) !!}
										                    </span>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <p class="review-date mb-5">{{ $comment->created_at }}</p>
                                                <p class="copy">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="clear"></div>
                    </div>

                    <div class="am-tab-panel am-fade">
                        <div class="details">
                            <div class="attr-list-hd after-market-hd">
                                <h4>商品细节</h4>
                            </div>
                            <div class="twlistNews">
                                {!! $product->detail->content !!}
                            </div>
                        </div>
                        <div class="clear"></div>

                    </div>


                    <div class="am-tab-panel am-fade">

                        <ul class="am-comments-list am-comments-list-flip">
                            @foreach ($product->users as $user)
                                <li class="am-comment">
                                    <a href="">
                                        <img class="am-comment-avatar" src="{{ $user->avatar }}" alt="{{ $user->name }}" />
                                    </a>

                                    <div class="am-comment-main">
                                        <header class="am-comment-hd">
                                            <div class="am-comment-meta">
                                                <a href="#" class="am-comment-author">{{ $user->name }}</a>
                                            </div>
                                        </header>

                                        <!-- 评论内容 -->
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="clear"></div>


                        <div class="tb-reviewsft">
                            <div class="tb-rate-alert type-attention">购买前请查看该商品的 <a href="#" target="_blank">购物保障</a>，明确您的售后保障权益。</div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="clear"></div>

            <div class="footer">
                <div class="footer-hd">
                    <p>
                        <a href="#">星期一商城</a>
                        <b>|</b>
                        <a href="#">商城首页</a>
                        <b>|</b>
                        <a href="#">支付宝</a>
                        <b>|</b>
                        <a href="#">物流</a>
                    </p>
                </div>
                @include('common.home.footer')
            </div>
        </div>

    </div>

    <form id="pay_form" action="/user/pay/show" method="post">
        {{ csrf_field() }}
    </form>
@endsection

@section('script')
    <script src="/assets/user/layer/2.4/layer.js"></script>
    <script src="/js/jquery-addShopping.js"></script>
    <script>
        var product_id = $('input[name=product_id]').val();
        var _url = "/user/likes/" + product_id;
        var token = "{{ csrf_token() }}";
        var likes_nums = $('#likes_count');

        // 收藏
        $('#likes_btn').click(function(){
            var that = $(this);

            $.post(_url, {_token:token}, function(res){
                layer.msg(res.msg);

                if (res.code == 301) {
                    return;
                }

                that.hide().next().show();
                likes_nums.text(parseInt(likes_nums.text()) + 1);
            });
        });
        // 取消收藏
        $('#de_likes_btn').click(function(){
            var that = $(this);

            $.post(_url, {_token:token,_method:'DELETE'}, function(res){
                layer.msg(res.msg);

                if (res.code == 301) {
                    return;
                }

                that.hide().prev().show();
                likes_nums.text(parseInt(likes_nums.text()) - 1);
            });
        });

        var Car = {
            addProduct:function(product_id) {

                var numbers = $("input[name=numbers]").val();
                if (! localStorage.getItem(product_id)) {
                    var product = {name:"{{ $product->name }}", numbers:numbers, price:"{{ $product->price }}"};
                } else {
                    var product = $.parseJSON(localStorage.getItem(product_id));
                    product.numbers = parseInt(product.numbers) + parseInt(numbers);
                }
                localStorage.setItem(product_id, JSON.stringify(product))
            }
        };

        // 加入购物车
        var car_nums = $('#cart-number');
        $('#addCar').shoping({
            endElement:"#car_icon",
            iconCSS: "",
            iconImg: $('#jqzoom').attr('src'),
            endFunction:function(element){

                var numbers = $("input[name=numbers]").val();
                var data = {product_id:"{{ $product->uuid }}",_token:token, numbers:numbers};
                var url = "/cars";
                $.post(url, data, function(res){
                    console.log(res);

                    if (res.code == 304) {

                        layer.msg(res.msg, {icon: 2});
                        return;
                    }

                    if (res.code == 302) {
                        Car.addProduct(product_id);
                    }
                    layer.msg(res.msg);
                    car_nums.text(parseInt(car_nums.text())+parseInt(numbers));
                });
            }
        });

        // 现在购买
        $('#nowBug').click(function(){
            var _address_id = $('select[name=address_id]').val();
            var _numbers = $('input[name=numbers]').val();
            var _product_id = $('input[name=product_id]').val();


            var data = {address_id:_address_id,numbers:_numbers,product_id:_product_id, _token:"{{ csrf_token() }}"};

            $.post('/user/orders/single', data, function(res){
                layer.msg(res.msg);

                if (res.code != 200) {
                    return false;
                }
                /** v请求支付 **/
                var form = $('#pay_form');
                var input = '<input type="hidden" name="_address_id" value="'+ _address_id +'">\
                        <input type="hidden" name="_product_id" value="'+ _product_id +'">\
                        <input type="hidden" name="_numbers" value="'+ _numbers +'">';
                form.append(input);
                form.submit();
            });
        });

        // 评论按钮
        $('#comment_btn').click(function () {

            var _id = $('#comment_detail').val();
            var _score = $('#comment_score').val();
            var _content = $('#comment_content').val();
            var that = $(this);

            var data = {id:_id, score:_score, content:_content};
            that.attr('disabled', true);
            $.post('/user/comments', data, function (res) {
                that.attr('disabled', false);

                layer.alert(res.msg);

                if (res.code == 200) {
                    window.location.reload();
                }

            });
        });
    </script>
@endsection
