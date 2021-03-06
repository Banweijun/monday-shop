<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrderController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('订单列表')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }




    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        $grid->model()->latest();

        $grid->column('id');
        $grid->column('no', '流水号');
        $grid->column('user.name', '用户');
        $grid->column('total', '总价');
        $grid->column('status', '状态')->display(function ($status) {
            return Order::PAY_STATUSES[$status];
        });
        $grid->column('address', '收货地址');
        $grid->column('pay_no', '支付流水号');
        $grid->column('pay_time', '支付时间');
        $grid->column('pay_type', '支付类型')->display(function ($type) {
            return Order::PAY_TYPES[$type] ?? '未知';
        });
        $grid->column('is_commented', '是否评论')->display(function ($is) {
            return $is ? '已评论' : '未评论';
        });
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '修改时间');

        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->actions(function (Actions $actions) {
            $actions->disableEdit();
        });

        $grid->filter(function (Filter $filter) {

            $filter->disableIdFilter();
            $filter->like('no', '流水号');
            $filter->where(function ($query) {

                $users = User::query()->where('name', 'like', "%{$this->input}%")->pluck('id');
                $query->whereIn('user_id', $users->all());
            }, '用户');
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->field('id');
        $show->field('no', '流水号');
        $show->field('user', '用户')->as(function ($user) {
            return $user->name;
        });
        $show->field('total', '总计');
        $show->field('status', '状态')->as(function ($status) {
            return Order::PAY_STATUSES[$status];
        });;
        $show->field('address', '收货地址');
        $show->field('pay_no', '支付单号');
        $show->field('pay_time', '支付时间');
        $show->field('pay_type', '支付类型')->as(function ($type) {
            return Order::PAY_TYPES[$type] ?? '未知';
        });
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '修改时间');

        // 详情
        $show->details('详情', function (Grid $details) {

            $details->column('id');
            $details->column('product.name', '商品名字');
            $details->column('price', '单价');
            $details->column('numbers', '数量');
            $details->column('is_commented', '是否评论')->display(function ($is) {
                return $is ? '<span class="bg-green">✔</span>' : '<span class="bg-blue">○</span>';
            });
            $details->column('total', '小计');

            $details->disableRowSelector();
            $details->disableCreateButton();
            $details->disableFilter();
            $details->disableActions();
        });

        return $show;
    }
}
