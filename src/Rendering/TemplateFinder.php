<?php

namespace ViewComponents\ViewComponents\Rendering;

class TemplateFinder
{
    /**
     * Paths for locating templates.
     * First paths has higher priority.
     * @var string[]
     * */
    protected $paths;

    /**
     * TemplateFinder constructor.
     *
     * @param string[] $paths paths to folder containing templates.
     */
    public function __construct(array $paths)
    {
        $this->paths = $paths;
    }

    /**
     * Registers path to views.
     *
     * @param string $path
     * @param bool $highPriority
     * @return $this
     */
    public function registerPath($path, $highPriority = true)
    {
        if ($highPriority) {
            array_unshift($this->paths, $path);
        } else {
            array_push($this->paths, $path);
        }
        return $this;
    }

    /**
     * Returns full path to template file.
     *
     * @param string $templateName
     * @return bool|string full path or false
     */
    public function getTemplatePath($templateName)
    {
        $fileName = "$templateName.php";
        foreach ($this->paths as $path) {
            $fullPath = $path . DIRECTORY_SEPARATOR . $fileName;
            if (is_file($fullPath)) {
                return $fullPath;
            }
        }
        return false;
    }

    /**
     * Returns true if template file can be found, false otherwise.
     *
     * @param $templateName
     * @return bool
     */
    public function templateExists($templateName)
    {
        return $this->getTemplatePath($templateName) !== false;
    }
}
