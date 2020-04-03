<?php

namespace R794021;

class Bid
{
    public function __construct(Contractor $contractor, $data)
    {
        $this->contractor = $contractor;
        $this->taskId = $data['taskId'];
        $this->budget = $data['budget'];
        $this->text = $data['text'];
    }

    public function getContractor()
    {
        return $this->contractor;
    }

    public function getId()
    {
        return $this->id;
    }
}
