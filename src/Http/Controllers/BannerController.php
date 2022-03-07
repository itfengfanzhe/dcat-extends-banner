<?php

namespace Dcat\Admin\Banner\Http\Controllers;

use Dcat\Admin\Banner\BannerServiceProvider;
use Dcat\Admin\Banner\Forms\AddBannerForm;
use Dcat\Admin\Banner\Models\Banner;
use Dcat\Admin\Banner\Models\BannerPosition;
use Dcat\Admin\Banner\Renderable\BannerTable;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Routing\Controller;

class BannerController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('轮播图')
            ->description('轮播图管理')
            ->body($this->position_grid());
    }

    /**
     * 轮播图位置列表
     * @return Grid
     * @author 张建伟 <itfengfanzhe@163.com>
     */
    public function position_grid()
    {
        $action_style = BannerServiceProvider::setting('action_style');
        return Grid::make(new BannerPosition(), function (Grid $grid) use($action_style) {
            if ($action_style == 1) {
                $grid->setActionClass(Grid\Displayers\Actions::class);
            } else if ($action_style == 2) {
                $grid->setActionClass(Grid\Displayers\ContextMenuActions::class);
            }
//            $grid->setActionClass(Grid\Displayers\DropdownActions::class);
//            $grid->setActionClass(Grid\Displayers\Actions::class);
//            $grid->setActionClass(Grid\Displayers\ContextMenuActions::class);
            $add_button = function ($title, $href) {
                return $this->createPositionDialog($title, $href);
            };
            $grid->model()->orderBy('id', 'desc');
            $grid->tools($add_button('新增', 'cms_banner/addPosition')); // 新增按钮
            $grid->setResource("cms_banner/editPosition");

            $grid->disableCreateButton();
            $grid->disableViewButton();
            $grid->column('id', 'ID')->sortable();
            $grid->column('title', '标题');
            $grid->column('description', '描述')->limit(20);
            $grid->column('banner', '轮播图')->display(function () {
                $count = Banner::query()->where('position_id', $this->id)->count();
                return "管理图片({$count})";
            })->expand(function () {
                return BannerTable::make()->payload(['position' => $this->id]);
            });
            $grid->actions(function (Grid\Displayers\Actions $action) {
                $action->append(
                    Modal::make()
                        ->lg()
                        ->title('新增')
                        ->body(AddBannerForm::make()->payload(['position_id' => $action->row->id]))
                        ->button('新增轮播图')
                );
            });
        });
    }

    /**
     * 新增位置弹框
     * @param $title
     * @param $href
     * @param string $click
     * @return string
     * @author 张建伟 <itfengfanzhe@163.com>
     */
    private function createPositionDialog($title, $href, $click = 'position')
    {

        Form::dialog("新增轮播图位置")
            ->click('.create-'.$click)
            ->url($href)
            ->width('60%')
            ->height('50%')
            ->success('Dcat.reload()');
        return <<<HTML
<div class="pull-right" data-responsive-table-toolbar="grid-table">

                        <a href="javascript:void(0)" class="btn btn-primary btn-outline create-{$click}">
    <i class="feather icon-plus"></i><span class="d-none d-sm-inline">&nbsp;&nbsp;{$title}</span>
</a>
                    </div>
HTML;
    }

    /**
     * 轮播图位置修改页面
     * @param $id
     * @param Content $content
     * @return Content
     * @author 张建伟 <itfengfanzhe@163.com>
     */
    public function editPosition($id, Content $content)
    {
        return $content
            ->header('轮播图位置')
            ->description('修改')
            ->body($this->positionForm()->edit($id));
    }

    /**
     * 轮播图位置新增页面
     * @param Content $content
     * @return Content
     * @author 张建伟 <itfengfanzhe@163.com>
     */
    public function createPosition(Content $content)
    {
        return $content
            ->header('轮播图位置')
            ->description('新增')
            ->body($this->positionForm());
    }

    /**
     * 轮播图位置表单
     * @return Form
     * @author 张建伟 <itfengfanzhe@163.com>
     */
    protected function positionForm()
    {
        return Form::make(new BannerPosition(), function (Form $form) {
            if ($form->isCreating()) {
                $form->action('cms_banner/positionStore');
            } else {
                $form->action('cms_banner/positionUpdate/'.$form->model()->id);
            }

            $form->text('title', '标题');
            $form->textarea('description', '描述');

            $form->saved(function(Form $form) {
               return $form->response()->success('保存成功')->redirect('/cms_banner');
            });
        });
    }

    /**
     * 新增轮播图位置方法
     * @author 张建伟 <itfengfanzhe@163.com>
     */
    public function positionStore()
    {
        return $this->positionForm()->store();
    }

    /**
     * 修改轮播图位置方法
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @author 张建伟 <itfengfanzhe@163.com>
     */
    public function positionUpdate($id)
    {
        return $this->positionForm()->update($id);
    }

    /**
     * 删除轮播图位置
     * @param $id
     * @return mixed
     * @author 张建伟 <itfengfanzhe@163.\com>
     */
    public function deletePosition($id)
    {
        return $this->positionForm()->destroy($id);
    }
}
