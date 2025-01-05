<?php

namespace App\Repositories\File;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileRepository implements FileInterface
{
    public function getModel()
    {
        return new File();
    }



    // Fetch data
    public function index($request)
    {
        $data = $this->getModel()
        ->when($request->mediable_type != null,function ($q) use($request){
            return $q->where('mediable_type',$request->mediable_type);
        })
        ->when($request->mediable_id != null,function ($q) use($request){
            return $q->where('mediable_id',$request->mediable_id);
        })
        ->get();
        return $data;
    }



    // Show  an existing data
    public function show($id)
    {
        $data = $this->getModel()->findOrFail($id);
        return $data;
    }



    // Store a new data
    public function store($request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('files', 'public');
            $data = $this->getModel()->create([
                'name'          => $request->file('file')->getClientOriginalName(),
                'mediable_id'   => $request->input('mediable_id'),
                'mediable_type' => $request->input('mediable_type'),
                'url'           => url(Storage::url($path)),
            ]);
            return $data;
        }
    }



    // Update an existing data
    public function update($request, $id)
    {
        $data = $this->getModel()->findOrFail($id);
        if ($request->hasFile('file')) {
            // Delete the old file
            if ($data->url) {
                Storage::delete(str_replace('/storage/', 'public/', $data->url));
            }
            // Upload the new file
            $path       = $request->file('file')->store('files', 'public');
            $data->name = $request->file('file')->getClientOriginalName();
            $data->url  = url(Storage::url($path));
        }
        // $file->mediable_id   = $request->input('mediable_id', $file->mediable_id);
        // $file->mediable_type = $request->input('mediable_type', $file->mediable_type);
        $data->save();
        return $data;
    }



    // Delete a data
    public function destroy($id)
    {
        $data = $this->getModel()->findOrFail($id);
        // Delete the file from storage
        if ($data->url) {
            Storage::delete(str_replace('/storage/', 'public/', $data->url));
        }
        $data->delete();
    }
}