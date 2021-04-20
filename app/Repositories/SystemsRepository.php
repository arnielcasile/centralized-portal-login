<?php

namespace App\Repositories;

use App\Interfaces\SystemsInterface;
use App\Models\Systems;
use App\Models\HrisSections;
use Illuminate\Support\Facades\Redis;
class SystemsRepository implements SystemsInterface
{
    public function load()
    {
        return Systems::all()->sortBy("name");
    }

    public function get($id)
    {
        return Systems::find($id);
    }

    public function store($request)
    {
        $systems = new Systems;
        $systems->name              = $request['name'];
        $systems->abbreviation      = $request['abbreviation'];
        $systems->reference_code    = $request['reference_code'];
        $systems->reference_number  = $request['reference_number'];
        $systems->description       = $request['description'];
        $systems->url               = $request['url'];
        $systems->date_deployed     = $request['date_deployed'];
        $systems->status            = $request['status'];
        $systems->section_owner     = $request['section_owner'];
        return $systems->save();
    }

    public function update($id, $request)
    {
        $systems = Systems::find($id);
        $systems->name              = $request['name'];
        $systems->abbreviation      = $request['abbreviation'];
        $systems->reference_code    = $request['reference_code'];
        $systems->reference_number  = $request['reference_number'];
        $systems->description       = $request['description'];
        $systems->url               = $request['url'];
        $systems->date_deployed     = $request['date_deployed'];
        $systems->status            = $request['status'];
        $systems->section_owner     = $request['section_owner'];
        return $systems->save();
    }

    public function delete($id)
    {
        $result = false;
        
        $systems = Systems::destroy($id);

        if ($systems) {
            $result = true;
        }
        return $result;
    }

    public function getSection()
    {
        $key = "hris_section";
        if ($HrisSection = Redis::get($key)) {
            return json_decode($HrisSection);
        }
        $HrisSection = HrisSections::all('id', 'section', 'section_code');
        Redis::set($key, $HrisSection);

        return $HrisSection;
    }
}
