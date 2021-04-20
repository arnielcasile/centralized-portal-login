<?php

namespace App\Interfaces;

/**
 * Interface serve as access method for controller and Repository
 * Important: Make Sure that the number method from controller is the same in interface
 */
interface ImageInterface
{
    /**
     * Display all the images
     */
    public function loadAllImages();

    /**
     * Get the specific image
     * The paramater used was coming from Controller
     * 
     * @param $id
     */
    public function getSpecificImages($id);

    /**
     * Store the new created image
     * The paramater used was coming from Controller
     * 
     * @param $data
     */
    public function storeImages($data);

    /**
     * Update the specific images
     * The paramater used was coming from Controller
     * 
     * @param $data
     * @param $id
     */
    public function updateImages($data, $id);

    /**
     * Remove the specific images
     * The paramater used was coming from Controller
     * 
     * @param $id
     */
    public function deleteImages($id);
}
