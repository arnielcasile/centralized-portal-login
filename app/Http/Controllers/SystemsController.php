<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemsStoreRequest;
use App\Traits\ResponseAPI;
use App\Interfaces\SystemsInterface;

class SystemsController extends Controller
{
    use ResponseAPI;
    protected $systemsInterface;

    public function __construct(SystemsInterface $systemsInterface)
    {
        $this->systemsInterface = $systemsInterface;
    }

    public function load()
    {
        try {
            $data = $this->systemsInterface->load();
            $result = $this->combineSections($data);
            return $this->success('Systems Loaded', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function get($id)
    {
        try {
            $result = $this->systemsInterface->get($id);
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function store(SystemsStoreRequest $request)
    {
        try {
            $result = $this->systemsInterface->store($request->validated());
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function update(SystemsStoreRequest $request, $id)
    {
        try {
            $result = $this->systemsInterface->update($id, $request->validated());
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->systemsInterface->delete($id);
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function combineSections($data)
    {
        $hris_data = $this->systemsInterface->getSection();

        foreach ($data as $key => $value) {
            foreach ($hris_data as $hrisdata) {
                if($value->section_owner == $hrisdata->id)
                {
                    $result[] = [
                        'id'                => $value->id,
                        'name'              => $value->name,
                        'abbreviation'      => $value->abbreviation,
                        'reference_code'    => $value->reference_code,
                        'reference_number'  => $value->reference_number,
                        'description'       => $value->description,
                        'url'               => $value->url,
                        'date_deployed'     => $value->date_deployed,
                        'status'            => $value->status,
                        'section_owner'     => $hrisdata->section,

                    ];
                }
            }
        }

        return $result;
    }
}
