<?php

namespace ViewComponents\ViewComponents\Component\Html;

use Nayjest\Tree\ChildNodeInterface;
use ViewComponents\ViewComponents\Base\Html\AutoSubmittingInputInterface;
use ViewComponents\ViewComponents\Base\Html\AutoSubmittingInputTagTrait;
use ViewComponents\ViewComponents\Base\Html\TagInterface;
use ViewComponents\ViewComponents\Component\DataView;

class Select extends Tag implements AutoSubmittingInputInterface
{
    use AutoSubmittingInputTagTrait;
    /**
     * @param array|null $attributes
     * @param array $options components or 'value' => 'label' array
     * @param string $selectedValue
     */
    public function __construct(
        array $attributes = [],
        array $options = [],
        $selectedValue = null
    ) {
        parent::__construct(
            'select',
            $attributes,
            self::makeOptionComponents($options)
        );
        if ($selectedValue !== null) {
            $this->setOptionSelected($selectedValue);
        }
    }

    private function setOptionSelected($selectedValue)
    {
        /** @var TagInterface $option */
        foreach ($this->children() as $option) {
            if (!$option instanceof TagInterface) {
                continue;
            }
            if ((string)$option->getAttribute('value') === (string)$selectedValue) {
                // @todo setAttribute not in tag interface
                $option->setAttribute('selected', 'selected');
            }
        }
    }

    private static function makeOptionComponents($options)
    {
        $components = [];
        foreach ($options as $value => $label) {
            if ($label instanceof ChildNodeInterface) {
                $components[] = $label;
            } else {
                $components[] = new Tag(
                    'option',
                    ['value' => $value],
                    [new DataView($label)]
                );
            }
        }
        return $components;
    }
}
