<?php

namespace Presentation\Framework\Component\ManagedList\Control\View;

use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Component\Text;

/**
 * Class FilterControlView
 *
 * @internal
 */
class FilterControlView extends Tag
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
            'span',
            [
                'data-role' => 'control-container'
            ]
        );
        $this->onRender(function() {
            $id = $this->name;
            $this->addChildren([
                new Tag('label', [
                    'for' => $id
                ], [
                    new Text($this->label)
                ]),
                new Text('&nbsp;'),
                new Tag('input', [
                    'value' => $this->value,
                    'type' => 'text',
                    'name' => $this->name,
                    'id' => $id
                ]),
                new Text('&nbsp;')
            ]);
        });
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
