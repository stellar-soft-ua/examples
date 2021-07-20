<?php

namespace ApiBundle\Component\Report;

interface Report
{
    public function setData(array $items);
    public function getFinalData(Callable $func);
}