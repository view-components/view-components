<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.04.2015
 * Time: 17:19
 */

namespace Presentation\Framework\BaseComponents\Html;


interface TagInterface {
    public function getTagName();
    public function getAttributes();
    public function getAttribute($name, $default = null);
}