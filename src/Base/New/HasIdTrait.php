<?php
namespace Presentation\Framework\Base;


trait HasIdTrait
{
    private $id;

    /**
     * @return string|null
     */
    public function getId()
    {
        if ($this->id === null) {
            $this->setId($this->makeDefaultId());
        }
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    protected function makeDefaultId()
    {
        $parts = explode('\\', static::class);
        $baseName = array_pop($parts);
        return $baseName . '_' . rand();
    }
}
