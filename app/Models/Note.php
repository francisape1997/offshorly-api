<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Scopes\NoteScopes;

class Note extends Model
{
    use HasFactory, NoteScopes;

    protected $fillable = ['title', 'body', 'created_by'];
}
