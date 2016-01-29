<?php

namespace Presentation\Framework\Rendering;


use InvalidArgumentException;

/**
 * Renderer for native PHP templates.
 */
class SimpleRenderer implements RendererInterface
{
    /**
     * Paths for locating templates.
     * First paths has higher priority.
     * @var string[]
     * */
    protected $paths;

    /**
     * SimpleRenderer constructor.
     * @param array $paths
     */
    public function __construct(array $paths = [])
    {
        $this->paths = $paths;
    }

    public function registerViewsPath($path, $highPriority = true)
    {
        if ($highPriority) {
            array_unshift($this->paths, $path);
        } else {
            array_push($this->paths, $path);
        }
        return $this;
    }

    /**
     * @param string $name
     * @return bool|string full path or false
     */
    protected function resolveTemplateFile($name)
    {
        $fileName = "$name.php";
        foreach ($this->paths as $path) {
            $fullPath = $path . DIRECTORY_SEPARATOR . $fileName;
            if (is_file($fullPath)) {
                return $fullPath;
            }
        }
        return false;
    }

    /**
     * Renders template and returns output.
     *
     * @param string $template template name
     * @param array $viewData
     * @return string
     */
    public function render($template, array $viewData = [])
    {
        $filePath = $this->resolveTemplateFile($template);
        if (!$filePath) {
            throw new InvalidArgumentException("Can't load template '$template'");
        }
        ob_start();
        extract($viewData);
        include($filePath);
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
}