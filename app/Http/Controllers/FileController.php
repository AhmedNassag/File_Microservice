<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\File\FileInterface;
use App\Http\Requests\File\StoreRequest;
use App\Http\Requests\File\UpdateRequest;

class FileController extends Controller
{
    protected $file;

    public function __construct(FileInterface $file)
    {
        $this->file = $file;
    }



    // Fetch data
    public function index(Request $request)
    {
        try {
            $data = $this->file->index($request);
            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    // Store a new data
    public function store(StoreRequest $request)
    {
        try {
            $data = $this->file->store($request);
            return response()->json(['data' => $data], 201);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    // Update an existing data
    public function update(Request $request, $id)
    {
        try {
            $data = $this->file->update($request, $id);
            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    // Delete a data
    public function destroy($id)
    {
        try {
            $data = $this->file->destroy($id);
            return response()->json(['message' => 'File deleted successfully.'], 200);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
