<?php

namespace App\Repositories\File;

interface FileInterface
{
    public function index($request);

    public function store($request);

    public function update($request, $id);

    public function destroy($id);
}