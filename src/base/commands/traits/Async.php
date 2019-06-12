<?php

namespace chemezov\yii2\yandex\cloud\base\commands\traits;

/**
 * Trait Async
 *
 * @package chemezov\yii2\yandex\cloud\base\commands\traits
 */
trait Async
{
    /** @var bool */
    private $isAsync = false;

    /**
     * @return $this
     */
    final public function async()
    {
        $this->isAsync = true;

        return $this;
    }

    /**
     * @return bool
     */
    final public function isAsync(): bool
    {
        return $this->isAsync;
    }
}
