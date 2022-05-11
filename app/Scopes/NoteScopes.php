<?php

namespace App\Scopes;

trait NoteScopes
{
    public function scopeOwner($query)
    {
        return $query->where('created_by', auth()->user()->id);
    }

    public function scopeDescending($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }
}
