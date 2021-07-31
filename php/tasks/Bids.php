<?php

namespace R794021;

class Bids
{
    public function __construct()
    {
        $this->bids = [];
    }

    public function addBid(Bid $bid)
    {
        $this->bids[] = $bid;
    }

    public function findBid(Contractor $contractor)
    {
        return current(array_filter($this->bids, function ($bid) use ($contractor) {
            return $bid->getContractor() === $contractor;
        }));
    }
}
