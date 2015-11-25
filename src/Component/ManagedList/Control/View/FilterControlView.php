<?php

namespace Presentation\Framework\Component\ManagedList\Control\View;

use Presentation\Framework\Component\CompoundComponent;
use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Component\Text;

/**
 * Class FilterControlView
 *
 * @internal
 */
class FilterControlView extends CompoundComponent
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var null|string
     */
    private $value;
    /**
     * @var null|string
     */
    private $label;

    /**
     * Constructor.
     *
     * @param string $name
     * @param string|null $value
     * @param string|null $label
     */
    public function __construct($name, $value = null, $label = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->label = $label;
        parent::__construct(
            [
                'container' => [
                    'label' => [
                        'label_text' => []
                    ],
                    'space1' => [],
                    'input' => [],
                    'space2' => [],
                ]
            ],
            [
                'container' => new Tag('span'),
                'label' => new Tag('label'),
                'label_text' => new Text(),
                'space1' => new Text('&nbsp;'),
                'input' => new Tag('input', ['type' => 'text',]),
                'space2' => new Text('&nbsp;'),
            ]
        );
        $this->updateAttributes();
    }

    protected function updateAttributes()
    {
        /** @var Tag $input */
        $input = $this->getComponent('input');
        $input->addAttributes([
            'value' => $this->value,
            'name' => $this->name
        ]);
        /** @var Tag $label */
        $label = $this->getComponent('label');
        $label->addAttributes([
            'for' => $this->name
        ]);
        $this->getComponent('label_text')->setValue($this->label);
    }

    public function render()
    {
        $this->updateAttributes();
        return parent::render();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }
}
