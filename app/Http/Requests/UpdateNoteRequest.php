<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Note;

class UpdateNoteRequest extends FormRequest
{
    public function authorize()
    {
        $note = Note::findOrFail($this->note);

        if ($note->created_by !== auth()->user()->id) {
            return false;
        }

        return true;
    }

    public function rules()
    {
        return
        [
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ];
    }
}
