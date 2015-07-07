<?php
namespace Presentation\Framework\Components\Debug;

use Presentation\Framework\BaseComponents\AbstractItemView;

class VarExport extends AbstractItemView
{
    public function render()
    {
        return var_export($this->data, true);
    }
}
