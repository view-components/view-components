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

    public function templateExists($templateName)
    {
        return $this->getTemplatePath($templateName) !== false;
    }
}
