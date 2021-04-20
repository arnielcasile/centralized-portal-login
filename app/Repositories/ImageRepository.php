<?php

namespace App\Repositories;

use App\Interfaces\ImageInterface;
use App\Models\Images;


class ImageRepository implements ImageInterface
{

    /**
     * Get all images from storage
     * The parameter used is coming from interface
     * 
     * @return object data
     */
    public function loadAllImages()
    {
        return Images::all();
    }

    /**
     * Get the specific Images from database
     * The parameter used is coming from interface
     * 
     * @param $id
     * @return object data
     */
    public function getSpecificImages($id)
    {
        return Images::find($id);
    }

    /**
     * Store the new created Images
     * The parameter used is coming from interface
     * 
     * @param $data
     * @return true/false
     */
    public function storeImages($data)
    {
        $Images = new Images;
        $Images->system_id      = $data['system_id'];
        $Images->logo           = $data['logo'];
        $Images->main_image     = $data['main_image'];
        return $Images->save();
    }

    /**
     * Update the specific Images
     * The parameter used is coming from interface
     * 
     * @param $data
     * @param $id
     * @return true/false
     */
    public function updateImages($data, $id)
    {
        $Images = Images::find($id);
        $Images->system_id      = $data['system_id'];
        $Images->logo           = $data['logo'];
        $Images->main_image     = $data['main_image'];
        return $Images->save();
    }

    /**
     * Remove the specific Images
     * The parameter used is coming from interface
     * 
     * @param $id
     * @return true/false
     */
    public function deleteImages($id)
    {
        $result = false;
        
        $systems = Images::destroy($id);

        if ($systems) {
            $result = true;
        }
        return $result;
    }
}
