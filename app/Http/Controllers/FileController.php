<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Resources\File\FileResource;
use App\Repositories\File\FileInterface;
use App\Http\Requests\File\StoreRequest;
use App\Http\Requests\File\UpdateRequest;

class FileController extends Controller
{
    use ApiResponseTrait;

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
            // return response()->json(['data' => FileResource::collection($data)], 200);
            return $this->apiResponse(FileResource::collection($data), 'Data Returned Successfully', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    // Show an existing data
    public function show($id)
    {
        try {
            $data = $this->file->show($id);
            // return response()->json(['data' => new FileResource($data)], 200);
            return $this->apiResponse(new FileResource($data), 'Data Returned Successfully', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    // Store a new data
    public function store(StoreRequest $request)
    {
        try {
            $data = $this->file->store($request);
            // return response()->json(['data' => new FileResource($data)], 200);
            return $this->apiResponse(new FileResource($data), 'Data Stored Successfully', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    // Update an existing data
    public function update(UpdateRequest $request, $id)
    {
        try {
            $data = $this->file->update($request, $id);
            // return response()->json(['data' => new FileResource($data)], 200);
            return $this->apiResponse(new FileResource($data), 'Data Updated Successfully', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    // Delete a data
    public function destroy($id)
    {
        try {
            $data = $this->file->destroy($id);
            // return response()->json(['message' => 'File deleted successfully.'], 200);
            return $this->apiResponse(null,'Data Deleted Sucessfully',200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
