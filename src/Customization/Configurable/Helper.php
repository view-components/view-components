<?php

namespace ViewComponents\ViewComponents\Customization\Configurable;

use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\Html\TagInterface;
use ViewComponents\ViewComponents\Component\DataView;
use ViewComponents\ViewComponents\Component\Part;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Resource\ResourceManager;
use ViewComponents\ViewComponents\Service\Services;

class Helper
{
    protected $resourceManager;

    /**
     * Constructor.
     *
     * @param ResourceManager|null $resourceManager
     */
    public function __construct(ResourceManager $resourceManager = null)
    {
        $this->resourceManager = $resourceManager;
    }

    /**
     * @param TagInterface|ComponentInterface $tag
     * @param string $className
     * @return $this
     */
    public function addClass($tag, $className)
    {
        $this->addAttributeContent($tag, 'class', $className, ' ');
        return $this;
    }

    public function addStyle($tag, $style)
    {
        $this->addAttributeContent($tag, 'class', $style, ';');
        return $this;
    }

    public function removeClass($tag, $className)
    {
        $this->removeAttributeContent($tag, 'class', $className);
        return $this;
    }

    public function setAttribute($tag, $attribute, $data)
    {
        if ($tag instanceof Part) {
            $tag = $tag->getView();
        }
        if (!$tag instanceof TagInterface) {
            return;
        }
        $tag->setAttribute($attribute, $data);
    }

    public function addAttributeContent($tag, $attribute, $data, $separator)
    {
        if ($tag instanceof Part) {
            $tag = $tag->getView();
        }
        if (!$tag instanceof TagInterface) {
            return;
        }
        $tag->setAttribute(
            $attribute,
            str_replace($data, '', $tag->getAttribute($attribute, '')) . $separator . $data
        );
    }

    public function removeAttributeContent($tag, $attribute, $data)
    {
        if ($tag instanceof Part) {
            $tag = $tag->getView();
        }
        if (!$tag instanceof TagInterface) {
            return;
        }
        $tag->setAttribute(
            $attribute,
            str_replace($data, '', $tag->getAttribute($attribute, ''))
        );
    }

    public function addText($component, $text, $prepend = false)
    {
        if ($component instanceof Part) {
            $component = $component->getView();
        }
        if (!$component instanceof ContainerComponentInterface) {
            return;
        }
        $component->children()->add(new DataView($text), $prepend);
    }

    public function prependText($component, $text)
    {
        $this->addText($component, $text, true);
    }

    public function js($component, $js, $prepend = false)
    {
        if (!$component instanceof ContainerComponentInterface) {
            return;
        }
        if (is_array($js)) {
            if ($prepend) {
                $js = array_reverse($js);
            }
            foreach ($js as $item) {
                $this->js($component, $item, $prepend);
            }
            return;
        }
        $component->children()->add($this->getResourceManager()->js($js), $prepend);
    }

    public function inlineJs($component, $jsCode, $uniqueId)
    {
        if (!$component instanceof ContainerComponentInterface) {
            return;
        }
        $component->children()->add($this->getResourceManager()->inlineJs($jsCode, $uniqueId));
    }

    /**
     * @param $component
     * @param string|array $css
     * @param bool $prepend false by default
     */
    public function css($component, $css, $prepend = false)
    {
        if (!$component instanceof ContainerComponentInterface) {
            return;
        }
        if (is_array($css)) {
            if ($prepend) {
                $css = array_reverse($css);
            }
            foreach ($css as $item) {
                $this->css($component, $item, $prepend);
            }
            return;
        }
        $component->children()->add($this->getResourceManager()->css($css), $prepend);
    }

    public function moveTo($component, $parentName)
    {
        if (!$component instanceof Part) {
            return;
        }
        $component->setDestinationParentId($parentName);
    }

    public function mergeData($component, $data)
    {
        if (!$component instanceof TemplateView) {
            return;
        }
        $component->mergeData($data);
    }

    public function overrideTemplate($component, $templatePrefix, array $additionalViewData = null)
    {
        if ($component instanceof Part) {
            $component = $component->getView();
        }
        if (!$component instanceof TemplateView) {
            return;
        }
        $templateName = $templatePrefix . '/' . $component->getTemplateName();
        if ($component->getRenderer()->getFinder()->templateExists($templateName)) {
            $component->setTemplateName($templateName);
            if ($additionalViewData !== null) {
                $component->mergeData($additionalViewData);
            }
        }
    }

    protected function getResourceManager()
    {
        if ($this->resourceManager === null) {
            $this->resourceManager = Services::resourceManager();
        }
        return $this->resourceManager;
    }
}
