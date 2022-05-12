<?php

namespace App\Http\Controllers;

# Requests
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;

# Resources
use App\Http\Resources\NoteResource;

# Service
use App\Services\NoteService;
use App\Http\Resources\StoreNoteResource;
use App\Http\Resources\UpdateNoteResource;
use App\Http\Resources\ShowNoteResource;
use App\Http\Resources\EditNoteResource;

class NoteController extends Controller
{
    private $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    public function index()
    {
        return NoteResource::collection($this->noteService->getUserNotes());
    }

    public function store(StoreNoteRequest $request)
    {
        $response = $this->noteService->storeNote($request);

        return response(new StoreNoteResource($response));
    }

    public function show($id)
    {
        return response(new ShowNoteResource($this->noteService->showNote($id)));
    }

    public function edit($id)
    {
        return response(new EditNoteResource($this->noteService->showNote($id)));
    }

    public function update(UpdateNoteRequest $request, $id)
    {
        $response = $this->noteService->updateNote($request, $id);

        return response(new UpdateNoteResource($response));
    }

    public function destroy($id)
    {
        return response()->json([
            'deleted' => $this->noteService->deleteNote($id),
        ]);
    }
}
