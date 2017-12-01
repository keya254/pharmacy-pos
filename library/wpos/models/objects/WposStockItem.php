<?php
/**
 * Created by PhpStorm.
 * User: joe
 * Date: 12/1/17
 * Time: 9:11 AM
 */

class WposStockItem extends stdClass
{
    public $storeditemid = 0;
    public $locationid = 0;
    public $amount = 0;
    public $reorderpoint = 0;

    /**
     * Set any provided data
     * @param $data
     */
    function __construct($data){
        foreach ($data as $key=>$value){
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}