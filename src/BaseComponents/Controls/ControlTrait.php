<?php

namespace Nayjest\ViewComponents\BaseComponents\Controls;

use Nayjest\ViewComponents\Common\InitializedOnceTrait;
use Nayjest\ViewComponents\Common\InputValueReader;
use Nayjest\ViewComponents\Data\DataProviderInterface;

trait ControlTrait
{
    use InitializedOnceTrait;

    /** @var  InputValueReader */
    protected $inputValueReader;

    /**
     * Applies operations based on input to data provider.
     *
     * @param DataProviderInterface $provider
     * @return mixed
     */
    abstract protected function applyOperations(DataProviderInterface $provider);

    /**
     * Initializes control with runtime data.
     *
     * @param DataProviderInterface $provider
     * @param array $input
     */
    public function initialize(DataProviderInterface $provider, array $input)
    {
        $this->setInitialized();
        $this->inputValueReader->initialize($input);
        if ($this->inputValueReader->hasValue()) {
            $this->applyOperations($provider);
        }
    }

    /**
     * Creates InputValueReader.
     *
     * Must be called in constructor.
     *
     * @param string $key
     * @param mixed $defaultValue
     */
    protected function makeInputValueReader($key, $defaultValue)
    {
        $this->inputValueReader = new InputValueReader($key, $defaultValue);
    }
}