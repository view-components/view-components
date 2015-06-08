<?php
namespace Nayjest\ViewComponents\Components\Debug;

use Nayjest\ViewComponents\BaseComponents\AbstractItemView;

class VarExport extends AbstractItemView
{
    public function render()
    {
        return var_export($this->data, true);
    }
}
