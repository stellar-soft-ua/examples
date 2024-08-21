<?php

namespace AL\ProductPassword\Api;

interface ValidatorInterface
{
    /**
     * @return bool
     */
    public function validate(): bool;
}
