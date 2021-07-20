<?php

namespace ApiBundle\Component\Report;

class ReportItem
{
    private $value;
    private $date;

    public function __construct($data)
    {
        $this->date = isset($data['date']) ? $data['date'] : null;
        $this->value = isset($data['value']) ? $data['value'] : null;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getDate()
    {
        return $this->date;
    }
}