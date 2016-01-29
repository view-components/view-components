<?php
namespace Presentation\Framework\Base;

trait HasSortPositionTrait
{
    protected $sortPosition = 1;

    /**
     * @return int
     */
    public function getSortPosition()
    {
        return $this->sortPosition;
    }

    /**
     * @param int $sortPosition
     * @return $this
     */
    public function setSortPosition($sortPosition)
    {
        $this->sortPosition = $sortPosition;
        return $this;
    }
}
