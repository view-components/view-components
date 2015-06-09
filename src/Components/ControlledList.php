<?php

namespace Nayjest\ViewComponents\Components;


use Nayjest\ViewComponents\BaseComponents\AbstractControlledList;
use Nayjest\ViewComponents\Components\Html\Tag;

class ControlledList extends AbstractControlledList
{
    protected function createComponentsTree()
    {
        $mainContainer = new Tag('div');
        $mainContainer->setAttribute('data-role', 'list-container');
        $mainContainer->components()->set([
            $this->createForm(),
            $this->createItemsContainer()
        ]);
        $this->components()->add($mainContainer);
    }

    protected function createForm()
    {
        $form = new Tag('form');
        $form->setAttribute('data-role', 'controls-from');
        $form->components()->set($this->controls);
        $form->components()->add($this->createSubmitButton());
        return $form;
    }

    protected function createSubmitButton()
    {
        $button = new Tag('input');
        $button->setAttributes([
           'type' => 'submit'
        ]);
        return $button;
    }

    protected function createItemsContainer()
    {
        $itemsContainer = new Tag('div');
        $itemsContainer->setAttribute('data-role', 'items-container');
        $itemsContainer->components()->add($this->repeater);
        return $itemsContainer;
    }

    public function render()
    {
        return $this->renderComponents();
    }
}
