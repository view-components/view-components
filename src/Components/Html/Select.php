<?php
namespace Presentation\Framework\Components\Html;

use Presentation\Framework\BaseComponents\Html\AbstractTag;
use Presentation\Framework\BaseComponents\Html\TagInterface;
use Presentation\Framework\Components\Text;
use Presentation\Framework\Structure\ChildNodeInterface;

class Select extends AbstractTag
{
    public function getTagName()
    {
        return 'select';
    }

    /**
     * @param array|null $attributes
     * @param array $options components or 'value' => 'label' array
     * @param string $selectedValue
     */
    public function __construct(
        array $attributes = [],
        array $options = [],
        $selectedValue = null
    )
    {
        parent::__construct(
            $attributes,
            self::makeOptionComponents($options, $selectedValue)
        );
        if ($selectedValue !== null) {
            $this->selectOption($selectedValue);
        }
    }

    private function selectOption($selectedValue)
    {
        /** @var TagInterface $option */
        foreach($this->components() as $option)
        {
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
        foreach($options as $value => $label)
        {
            if ($label instanceof ChildNodeInterface) {
                $components[] = $label;
            } else {
                $components[] = new Tag(
                    'option',
                    ['value' => $value],
                    [new Text($label)]
                );
            }
        }
        return $components;
    }
}
