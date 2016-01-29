<?php

namespace Presentation\Framework\Base;

trait VisibilityTrait
{
    private $visible = true;


    public function hide()
    {
        $this->visible = false;
        return $this;
    }

    public function show()
    {
        $this->visible = true;
        return $this;
    }

    public function setVisible($value)
    {
        $this->visible = $value;
        return $this;
    }

    public function isVisible()
    {
        return $this->visible;
    }
}
