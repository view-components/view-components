<?php
namespace Presentation\Framework\Component\Debug;



use Presentation\Framework\Base\AbstractDataView;

class VarExport extends AbstractDataView
{
    public function renderData()
    {
        return var_export($this->data, true);
    }
}
