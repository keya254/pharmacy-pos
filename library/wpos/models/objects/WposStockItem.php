<?php
/**
 * Created by PhpStorm.
 * User: joe
 * Date: 12/1/17
 * Time: 9:11 AM
 */

class WposStockItem extends stdClass
{
    public $stockinventoryid = 0;
    public $storeditemid = 0;
    public $supplierid = 0;
    public $amount = 0;
    public $expiryDate = 0;
    public $cost = 0;
    public $price = 0;
    public $code = 0;
    public $data = "";
    public $locationid = 0;
    public $inventoryNo = 0;

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