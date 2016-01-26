<?php
namespace Presentation\Framework\Component\Html;

use Nayjest\Tree\ChildNodeInterface;
use Presentation\Framework\Base\Html\AbstractTag;
use Presentation\Framework\Base\Html\TagInterface;
use Presentation\Framework\Component\Text;

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
            self::makeOptionComponents($options)
        );
        if ($selectedValue !== null) {
            $this->setOptionSelected($selectedValue);
        }
    }

    private function setOptionSelected($selectedValue)
    {
        /** @var TagInterface $option */
        foreach($this->children() as $option)
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
