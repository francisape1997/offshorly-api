<?php

namespace App\Services;

# Model
use App\Models\Note;

class NoteService
{
    public function __construct(private readonly Note $note) {}

    public function getUserNotes()
    {
        return $this->note->owner()->descending()->paginate();
    }

    public function storeNote($request)
    {
        return $this->note->create([
            ...$request->validated(),
            'created_by' => auth()->user()->id,
        ]);
    }

    public function updateNote($request, $id)
    {
        $note = Note::where('id', $id)->firstOrFail();

        $note->update($request->validated());

        return $note;
    }

    public function showNote($id)
    {
        return $this->note->findOrFail($id);
    }

    public function deleteNote($id)
    {
        return $this->note->findOrFail($id)->delete();
    }
}
