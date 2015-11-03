<?php

namespace Presentation\Framework\Component\ManagedList;

use Nayjest\Collection\Extended\ObjectCollectionReadInterface;
use Nayjest\Collection\Extended\Registry as BaseRegistry;

use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Component\Repeater;
use Presentation\Framework\Component\ManagedList\Control\ControlInterface;

class Registry extends BaseRegistry
{
    const SUBMIT_BUTTON_POSITION = 100;

    protected function useDefaults()
    {
        $this->setForm(new Tag('form'));
        $this->setRepeater(new Repeater());
        $this->setContainer(new Tag('div'));
        $this->setSubmitButton(new Tag('input', ['type' => 'submit']));
    }

    /**
     * @param string $itemName
     * @return null|object
     */
    public function get($itemName)
    {
        if ($this->isEmpty()) {
            $this->useDefaults();
        }
        return parent::get($itemName);
    }
    /**
     * @return ComponentInterface|null
     */
    public function getForm()
    {
        return $this->get('form');
    }

    /**
     * @param ComponentInterface|null $component
     * @return $this
     */
    public function setForm(ComponentInterface $component = null)
    {
        if ($this->has('form')) {
            $controls = $this->getControls();
            $component->addChildren($controls);
        }
        return $this->set('form', $component);
    }


    /**
     * @return Repeater|null
     */
    public function getRepeater()
    {
        return $this->get('repeater');
    }

    /**
     * @param ComponentInterface|null $component
     * @return $this
     */
    public function setRepeater(ComponentInterface $component = null)
    {
        return $this->set('repeater', $component);
    }

    /**
     * @return ComponentInterface|null
     */
    public function getContainer()
    {
        return $this->get('container');
    }

    /**
     * @param ComponentInterface|null $component
     * @return $this
     */
    public function setContainer(ComponentInterface $component = null)
    {
        return $this->set('container', $component);
    }


    /**
     * @return ComponentInterface|null
     */
    public function getListItem()
    {
        return $this->get('list_item');
    }

    /**
     * @param ComponentInterface|null $component
     * @return $this
     */
    public function setListItem(ComponentInterface $component = null)
    {
        return $this->set('list_item', $component);
    }


    /**
     * @return ObjectCollectionReadInterface|ControlInterface[]
     */
    public function getControls()
    {
        /** @var ObjectCollectionReadInterface $formChildren */
        $formChildren =  $this->getForm()->children();
        return $formChildren->filterByType(ControlInterface::class);
    }


    /**
     * @return ComponentInterface|null
     */
    public function getSubmitButton()
    {
        return $this->get('submit_button');
    }

    /**
     * @param ComponentInterface|null $component
     * @return $this
     */
    public function setSubmitButton(ComponentInterface $component = null)
    {
        $component->setSortPosition(static::SUBMIT_BUTTON_POSITION);
        return $this->set('submit_button', $component);
    }
}