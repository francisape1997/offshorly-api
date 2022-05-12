<?php

namespace App\Services;

# Model
use App\Models\Note;

class NoteService
{
    private $note;

    public function __construct(Note $note)
    {
        $this->note = $note;
    }

    public function getUserNotes()
    {
        return $this->note->owner()->descending()->paginate();
    }

    public function storeNote($request)
    {
        // PHP 8 version. Since PHP 8.1 is not currently supported on AWS
        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'created_by' => auth()->user()->id,
        ];

        return $this->note->create($data);

        // PHP 8.1 Version
        // return $this->note->create([
        //     ...$request->validated(),
        //     'created_by' => auth()->user()->id,
        // ]);
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
