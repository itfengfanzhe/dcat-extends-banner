<?php
namespace Dcat\Admin\Banner\Renderable;

use Dcat\Admin\Banner\Extensions\DeleteBannerAction;
use Dcat\Admin\Banner\Forms\EditBannerForm;
use Dcat\Admin\Banner\Models\Banner;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;
use Dcat\Admin\Widgets\Modal;

class BannerTable extends LazyRenderable
{
    function grid(): Grid
    {
        $position_id = $this->payload['position'];
        return Grid::make(new Banner(), function (Grid $grid) use($position_id) {
            $grid->model()->where('position_id', $position_id);
            $grid->column('id', 'ID');
            $grid->column('title', '标题');
            $grid->column('image', '图片')->image('', 70, 70);
            $grid->disableViewButton();
            $grid->disableeditButton();
            $grid->disableDeleteButton();
            $grid->disableCreateButton();
            $grid->disablePagination();
            $grid->disableRefreshButton();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->append(
                    Modal::make()
                        ->lg()
                        ->title('修改')
                        ->body(EditBannerForm::make()->payload(['id' => $actions->row->id]))
                        ->button('修改')
                );
                $actions->append(new DeleteBannerAction());
            });
        });
    }
}
