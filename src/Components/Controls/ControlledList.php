<?php

namespace Nayjest\ViewComponents\Components\Controls;

use Nayjest\ViewComponents\BaseComponents\ContainerInterface;
use Nayjest\ViewComponents\BaseComponents\Controls\ControlledList\AbstractControlledList;
use Nayjest\ViewComponents\Components\Html\Div;
use Nayjest\ViewComponents\Components\Html\Form;
use Nayjest\ViewComponents\Components\Html\Input;

class ControlledList extends AbstractControlledList
{
    protected $form;
    protected $itemsContainer;
    protected $submitButton;

    /**
     * @return mixed
     */
    public function getItemsContainer()
    {
        return $this->itemsContainer;
    }

    public function getSubmitButton()
    {
        return $this->submitButton;
    }

    /**
     * @return mixed
     */
    public function getForm()
    {
        if ($this->form === null) {
            $this->setForm(new Form);
        }
        return $this->form;
    }

    /**
     * @param mixed $form
     */
    public function setForm(ContainerInterface $form)
    {
        $this->form = $form;
        $form->setAttribute('data-role', 'controls-from');
        $form->components()->set($this->controls);
        $this->submitButton = $this->createSubmitButton();
        $form->components()->add($this->submitButton);
    }

    protected function createComponentsTree()
    {
        $mainContainer = new Div();
        $mainContainer->setAttribute('data-role', 'list-container');
        $mainContainer->components()->set([
            $this->getForm(),
            $this->createItemsContainer()
        ]);
        $this->components()->add($mainContainer);
    }

    protected function createSubmitButton()
    {
        $button = new Input();
        $button->setAttributes([
           'type' => 'submit'
        ]);
        return $button;
    }

    protected function createItemsContainer()
    {
        $itemsContainer = new Div();
        $itemsContainer->setAttribute('data-role', 'items-container');
        $itemsContainer->components()->add($this->repeater);
        $this->itemsContainer = $itemsContainer;
        return $itemsContainer;

    }

    public function render()
    {
        return $this->renderComponents();
    }
}
