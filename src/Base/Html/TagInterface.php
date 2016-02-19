<?php

namespace ViewComponents\ViewComponents\Base\Html;

interface TagInterface
{
    public function getTagName();

    public function getAttributes();

    public function getAttribute($name, $default = null);

    public function setAttribute($name, $value);

    public function setAttributes(array $attributes = []);

    public function addAttributes(array $attributes);
}
