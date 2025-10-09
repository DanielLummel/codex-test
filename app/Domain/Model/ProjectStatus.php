<?php

namespace App\Domain\Model;

enum ProjectStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Completed = 'completed';
    case OnHold = 'on_hold';
    case Archived = 'archived';

    public function isClosed(): bool
    {
        return $this === self::Completed || $this === self::Archived;
    }
}
