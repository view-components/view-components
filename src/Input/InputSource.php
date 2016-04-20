<?php

namespace ViewComponents\ViewComponents\Input;

/**
 * InputSource is a factory class for InputOption instances.
 */
class InputSource
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
    final public function option($name, $default = null)
    {
        return new InputOption($name, $this->input, $default);
    }

    /**
     * Shortcut for InputSource::option().
     *
     * @param string $name
     * @param null $default optional default value
     * @return InputOption
     */
    public function __invoke($name, $default = null)
    {
        return $this->option($name, $default);
    }
}
