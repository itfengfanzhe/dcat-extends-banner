<?php

namespace Dcat\Admin\Banner;

use Dcat\Admin\Extend\Setting as Form;

class Setting extends Form
{
    public function form()
    {
        $this->radio('action_style', '操作样式')->options(['下拉', '展开', '右键']);
    }
}
