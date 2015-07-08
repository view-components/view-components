<?php

namespace Presentation\Framework\Common;

class InputOptionFactory
{
    /**
     * @var array
     */
    private $input;

    /**
     * Constructor.
     *
     * @param array $input $_GET, $_POST, etc. can be used as input
     */
    public function __construct(array $input)
    {
        $this->input = $input;
    }

    /**
     * Creates input option.
     *
     * @param string $name
     * @param null $default optional default value
     * @return InputOption
     */
    public final function make($name, $default = null)
    {
        return new InputOption($name, $this->input, $default);
    }

    /**
     * Shortcut for InputOptionFactory::make.
     *
     * @param string $name
     * @param null $default optional default value
     * @return InputOption
     */
    public function __invoke($name, $default = null)
    {
        return $this->make($name, $default);
    }
}
