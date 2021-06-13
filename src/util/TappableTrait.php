<?php

namespace Amenadiel\JpGraph\Util;

use Closure;

trait TappableTrait
{
    /**
     * Call the given Closure with this instance then return the instance.
     *
     * @param  callable|null  $callback
     * @return mixed
     */
    public function tap(Closure $callback): self
    {
        $callback($this);

        return $this;
    }
}
