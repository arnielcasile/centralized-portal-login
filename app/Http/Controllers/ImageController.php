<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Requests\LogoRequest;
use Illuminate\Http\Request;
use App\Interfaces\ImageInterface;
use App\Traits\ResponseAPI;

class ImageController extends Controller
{
    use ResponseAPI;
    protected $imageInterface;

    public function __construct(ImageInterface $imageInterface)
    {
        $this->imageInterface = $imageInterface;
    }

    public function load()
    {
        try {
            $result = $this->imageInterface->load();
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
    public function get($id)
    {
        try {
            $result = $this->imageInterface->get($id);
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function store(ImageRequest $request)
    {
        try {
            $logo_path =  $request->file('main_image')->store('public/system_logo');
            $main_image_path =  $request->file('main_image')->store('public/system_main_image');

            if ($main_image_path && $logo_path) {
                $data = $request->validated();
                $data['logo'] = $logo_path;
                $data['main_image'] = $main_image_path;

                $result = $this->imageInterface->store($data);
                return $this->success('Successfully Executed', 200, $result);
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function update(ImageRequest $request, $id)
    {
        try {
            if ($request->validator->fails()) {
                return $this->warning('Invalid Inputs', 400, $request->validator->errors());
            }

            $result = $this->imageInterface->update($id, $request->validated());
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->imageInterface->delete($id);
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
