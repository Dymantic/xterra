<?php


namespace App\Blog;


trait CanBeFlagged
{
    public function flag($reason)
    {
        return $this->flagged()->create(['reason' => $reason]);
    }
}
