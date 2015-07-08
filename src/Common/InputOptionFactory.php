<?php

namespace Presentation\Framework\Common;

class InputOptionFactory
{
    /**
     * @var array
     */
    private $input;

    public function __construct(array $input)
    {
        $this->input = $input;
    }

    public final function make($name, $default = null)
    {
        return new InputOption($name, $this->input, $default);
    }

    public function __invoke($name, $default = null)
    {
        return $this->make($name, $default);
    }

}
