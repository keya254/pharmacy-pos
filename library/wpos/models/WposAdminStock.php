<?php
/**
 * WposAdminStock is part of Wallace Point of Sale system (WPOS) API
 *
 * WposAdminStock is used to manage stock
 *
 * WallacePOS is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3.0 of the License, or (at your option) any later version.
 *
 * WallacePOS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details:
 * <https://www.gnu.org/licenses/lgpl.html>
 *
 * @package    wpos
 * @copyright  Copyright (c) 2014 WallaceIT. (https://wallaceit.com.au)
 * @link       https://wallacepos.com
 * @author     Michael B Wallace <micwallace@gmx.com>
 * @since      File available since 12/04/14 3:44 PM
 */
class WposAdminStock {
    /**
     * @var stdClass provided params
     */
    private $data;
    /**
     * @var StockHistoryModel
     */
    private $histMdl;
    /**
     * @var StockModel
     */
    private $stockMdl;
    /**
         * @var StockItemsModel
         */
        private $stockItemsMdl;

    /**
     * Decode provided input
     * @param $data
     */
    function __construct($data=null){
        // parse the data and put it into an object
        if ($data!==null){
            $this->data = $data;
        } else {
            $this->data = new stdClass();
        }
        // setup objects
        $this->histMdl = new StockHistoryModel();
        $this->stockMdl = new StockModel();
        $this->stockItemsMdl = new StockItemsModel();
    }

    /**
     * Import items
     * @param $result
     * @return mixed
     */
    public function importItemsSet($result)
    {
        $_SESSION['import_data'] = $this->data->import_data;
        $_SESSION['import_options'] = $this->data->options;
        return $result;
    }

    /**
     * Import items
     * @param $result
     * @return mixed
     */
    public function importItemsStart($result)
    {
        if (!isset($_SESSION['import_data']) || !is_array($_SESSION['import_data'])){
            $result['error'] = "Import data was not received.";
            EventStream::sendStreamData($result);
            return $result;
        }
        $options = $_SESSION['import_options'];
        $items = $_SESSION['import_data'];

        EventStream::iniStream();
        $storedItemsMdl = new StoredItemsModel();
        $stockItemsMdl = new StockItemsModel();
        $stockMdl = new StockModel();
        $catMdl = new CategoriesModel();
        $supMdl = new SuppliersModel();
        $taxMdl = new TaxRulesModel();

        $storedItems = $storedItemsMdl->get();
        $categories = $catMdl->get();
        $suppliers = $supMdl->get();
        $taxRules = $taxMdl->get();
        foreach ($taxRules as $key=>$rule){
            $data = json_decode($rule['data'], true);
            $data['id'] = $rule['id'];
            $taxRules[$rule['id']] = $data;
        }

        if ($categories===false || $suppliers===false || $taxRules===false){
            $result['error'] = "Could not load categories, suppliers or tax rules: ".$catMdl->errorInfo." ".$supMdl->errorInfo." ".$taxMdl->errorInfo;
            EventStream::sendStreamData($result);
            return $result;
        }

        EventStream::sendStreamData(['status'=>"Validating Stock..."]);
        $validator = new JsonValidate(null, '{"code":"", "qty":1, "name":"", "price":-1, "tax_name":"", "category_name":"", "supplier_name":""}');
        $count = 1;
        foreach ($items as $key=>$item){
            EventStream::sendStreamData(['status'=>"Validating Stock...", 'progress'=>$count]);

            $validator->validate($item);

            // TODO :: Allow items with same code
//            $item->code = strtoupper($item->code); // make sure stockcode is upper case
//            $dupitems = $stockItemsMdl->get(null, $item->code);
//            if (sizeof($dupitems) > 0) {
//                $dupitem = $dupitems[0];
//                if ($dupitem['id'] != $item->id) {
//                    $result['error'] = "An item with the stockcode ".$item->code." already exists on line ".$count;
//                    EventStream::sendStreamData($result);
//                    return $result;at
//                }
//            }

            // remove currency symbol from price & cost
            $item->price = preg_replace("/([^0-9\\.])/i", "", $item->price);
            $item->cost = preg_replace("/([^0-9\\.])/i", "", $item->cost);

            // Match tax id with name
            if (!$item->tax_name){
                $id = 1;
            } else {
                $id = $this->getIdForName($taxRules, $item->tax_name);
            }
            if ($id===false){
                $result['error'] = "Could not find tax rule id for name ".$item->tax_name." on line ".$count." of the CSV";
                EventStream::sendStreamData($result);
                return $result;
            }
            $item->taxid = $id;
            unset($item->tax_name);

            // Match category
            if (!$item->category_name || $item->category_name=="None" || $item->category_name=="Misc"){
                $id = 0;
            } else {
                $id = $this->getIdForName($categories, $item->category_name);
            }
            if ($id===false){
                if ((isset($options->add_categories) && $options->add_categories===true)){
                    EventStream::sendStreamData(['status'=>"Adding category..."]);
                    $id = $catMdl->create($item->category_name);
                    $categories[] = ['id'=>$id, 'name'=>$item->category_name];
                    if (!is_numeric($id)){
                        $result['error'] = "Could not add new category " . $item->category_name . " on line ".$count." of the CSV: ".$catMdl->errorInfo.json_encode($categories);
                        EventStream::sendStreamData($result);
                        return $result;
                    }
                }
            }
            $item->categoryid = $id;
            unset($item->category_name);

            // Match Item Name
            $id = $this->getIdForName($storedItems, $item->name);
            if ($id === false || $id === null){
                // Add item as an Inventory Item
                if ((isset($options->add_items) && $options->add_items===true)){
                    EventStream::sendStreamData(['status'=>"Adding Item..."]);
                    $id = $storedItemsMdl->create($item);
                    if (!is_numeric($id)){
                        $result['error'] = "Could not add new item " . $item->name . " on line ".$count." of the CSV: ".$storedItemsMdl->errorInfo;
                        EventStream::sendStreamData($result);
                        return $result;
                    }
                }
            }
            $item->storeditemid = $id;
            $storedItems[] = ['id'=>$id, 'name'=>$item->name];
            unset($item->name);


            // Match supplier
            if (!$item->supplier_name || $item->supplier_name=="None" || $item->supplier_name=="Misc"){
                $id = 0;
            } else {
                $id = $this->getIdForName($suppliers, $item->supplier_name);
            }
            if ($id===false){
                if ((isset($options->add_suppliers) && $options->add_suppliers===true)){
                    EventStream::sendStreamData(['status'=>"Adding supplier..."]);
                    $id = $supMdl->create($item->supplier_name);
                    if (!is_numeric($id)){
                        $result['error'] = "Could not add new supplier " . $item->supplier_name . " on line ".$count." of the CSV: ".$catMdl->errorInfo;
                        EventStream::sendStreamData($result);
                        return $result;
                    }
                    $suppliers[] = ['id'=>$id, 'name'=>$item->supplier_name];
                }
            }
            $item->supplierid = $id;
            unset($item->supplier_name);

            $items[$key] = $item;

            $count++;
        }

        EventStream::sendStreamData(['status'=>"Importing Stock..."]);
        $result['data'] = [];
        $count = 1;
        foreach ($items as $item){
            EventStream::sendStreamData(['progress'=>$count]);

            $stockObj = new WposStockItem($item);

            // Check if item exists in inventory
            $dupitems = $stockMdl->getByItemId($stockObj->storeditemid, $stockObj->supplierid);
            if (sizeof($dupitems) == 0 || $dupitems == false) {
                // Add as new entry
                $stockMdl->create($stockObj->storeditemid, $stockObj->supplierid);
                $dupitems = $stockMdl->getByItemId($stockObj->storeditemid, $stockObj->supplierid);
                $stockinventoryid = $dupitems[0]['id'];
            } else {
                $stockinventoryid = $dupitems[0]['id']; // Return id of the stockinventory
            }
            if ($stockinventoryid===false){
                $result['error'] = "Failed to add  a new supplier for  item in line " .$count." of the CSV: ".$stockMdl->errorInfo;
                EventStream::sendStreamData($result);
                return $result;
            } else {
                // create add the item in stock Items model
                unset($stockObj->storeditemid);
                $stockObj->stockinventoryid = $stockinventoryid;
                $id=$stockItemsMdl->create($stockObj->stockinventoryid, $stockObj->amount, $stockObj->expiryDate,  $stockObj->cost,  $stockObj->price,  $stockObj->code, $stockObj->inventoryNo,  json_encode($stockObj),  $stockObj->locationid, time());
                if ($id===false){
                    $result['error'] = "Could not add item to stock, ".json_encode($stockObj);
                    EventStream::sendStreamData($result);
                    return $result;
                }
                // create history record for imported stock
                if ($this->histMdl->create($id, $stockObj->locationid, 'Stock Imported', $stockObj->amount)===false){
                    $result['error'] = "Could not create stock history record".$this->histMdl->errorInfo;
                    return $result;
                }
            }
            // Success; log data
            Logger::write("Stock Added", "STOCK", json_encode($stockObj));

            $stockObj->id = $id;
            $result['data'][$id] = $stockObj;

            $count++;
        }

        unset($_SESSION['import_data']);
        unset($_SESSION['import_options']);

        EventStream::sendStreamData($result);
        return $result;
    }

    /**
     * Import items
     * @param $result
     * @return mixed
     */
    public function importItemsStop($result)
    {
        unset($_SESSION['import_data']);
        unset($_SESSION['import_options']);
        return $result;
    }
    /**
     * This function is used by WposPosSale and WposInvoices to decrement/increment sold/voided transaction stock; it does not create a history record
     * @param $stockinventoryid
     * @param $locationid
     * @param $stocklevel
     * @param $inventoryNo
     * @param $expiryDate
     * @param $cost
     * @param $price
     * @param $code
     * @param $data
     * @param $locationid
     * @param bool $decrement
     * @return bool
     */
    public function incrementStockLevel($stockinventoryid, $stocklevel, $locationid, $decrement = false, $expiryDate=null, $cost=null, $price=null, $code=null, $inventoryNo=null, $data=null){
        if ($this->stockItemsMdl->incrementStockLevel($stockinventoryid, $stocklevel, $locationid, $decrement, $expiryDate, $cost, $price, $code, $inventoryNo, $data)!==false){
            return true;
        }
        return $this->stockItemsMdl->errorInfo;
    }

    /**
     * Transfer stock to another location
     * @param $result
     * @return mixed
     */
    public function transferStock($result){
        // validate input
        // remove the data object
        unset($this->data->data);
        $jsonval = new JsonValidate($this->data, '{"storeditemid":1, "locationid":1, "newlocationid":1, "amount":">=1"}');
        if (($errors = $jsonval->validate())!==true){
            $result['error'] = $errors;
            return $result;
        }
        if ($this->data->locationid == $this->data->newlocationid){
            $result['error'] = "Cannot transfer stock to the same location, pick a different one.";
            return $result;
        }
        // check if theres enough stock at source location
        if (($stock=$this->stockItemsMdl->getItem($this->data->stockinventoryid, $this->data->locationid))===false){
            $result['error'] = "Could not fetch current stock level: ".$this->stockItemsMdl->errorInfo;
            return $result;
        }
        if ($stock[0]['stocklevel']<$this->data->amount){
            $result['error'] = "Not enough stock at the source location, add some first";
            return $result;
        }

        // remove stock amount from current location
        if ($id=$this->stockItemsMdl->incrementStockLevel($this->data->stockinventoryid, $this->data->amount, $this->data->locationid, true, $this->data->expiryDate, $this->data->cost, $this->data->price, $this->data->code, $this->data->inventoryNo, json_encode($this->data))===false){
            $result['error'] = "Could not decrement stock from current location".$this->stockItemsMdl->errorInfo;
            return $result;
        }
        // create history record for removed stock
        if (!is_numeric($id)) {
            $id = $this->data->id;
        }
        if ($this->createStockHistory($id, $this->data->locationid, 'Stock Transfer', -$this->data->amount, $this->data->newlocationid, 0)===false){ // stock history created with minus
            $result['error'] = "Could not create stock history record";
            return $result;
        }

        // add stock amount to new location
        $id = $this->stockItemsMdl->incrementStockLevel($this->data->stockinventoryid, $this->data->amount, $this->data->newlocationid, false, $this->data->expiryDate, $this->data->cost, $this->data->price, $this->data->code, $this->data->inventoryNo, json_encode($this->data));
        if ($id===false){
            $result['error'] = "Could not add stock to the new location";
            return $result;
        }
        $item = $this->stockItemsMdl->getItem($this->data->stockinventoryid, $this->data->newlocationid);
        if ($this->createStockHistory($item[0]['id'], $this->data->newlocationid, 'Stock Transfer', $this->data->amount, $this->data->locationid, 1)===false){
            $result['error'] = "Could not create stock history record.";
            return $result;
        }

        // Success; log data
        Logger::write("Stock Transfer", "STOCK", json_encode($this->data));

        return $result;
    }

    /**
     * Set the level of stock at a location (stocktake)
     * @param $result
     * @return mixed
     */
    public function setStockLevel($result){
        // validate input
        $jsonval = new JsonValidate($this->data, '{"storeditemid":1, "locationid":1, "amount":">=1}');
        if (($errors = $jsonval->validate())!==true){
            $result['error'] = $errors;
            return $result;
        }
        // create history record for added stock
        if ($this->createStockHistory($this->data->id, $this->data->locationid, 'Stock Edited', $this->data->stocklevel)===false){
            $result['error'] = "Could not create stock history record";
            return $result;
        }
        if ($this->stockItemsMdl->setStockLevel($this->data->id, $this->data->stockinventoryid, $this->data->stocklevel, $this->data->expiryDate,   $this->data->cost,  $this->data->price,  $this->data->code, $this->data->inventoryNo,  json_encode($this->data),  $this->data->locationid)===false){
            $result['error'] = "Could not add stock to the location".$this->stockItemsMdl->errorInfo;
        }

        // Success; log data
        Logger::write("Stock Level Set", "STOCK", json_encode($this->data));

        return $result;
    }

    /**
     * Add stock to a location
     * @param $result
     * @return mixed
     */
    public function addStock($result){
        // validate input
        $jsonval = new JsonValidate($this->data, '{"storeditemid":1, "locationid":1, "supplierid":1, "amount":1, "cost":1, "price":1, "expiryDate":, "inventoryNo":, "batchNo":""}');
        if (($errors = $jsonval->validate())!==true){
            $result['error'] = $errors;
            return $result;
        }

        $dupitems = $this->stockMdl->getByItemId($this->data->storeditemid, $this->data->supplierid);
        if (sizeof($dupitems) == 0) {
            // Add as new entry
            $stockinventoryid = $this->stockMdl->create($this->data->storeditemid, $this->data->supplierid);
        } else {
            $stockinventoryid = $dupitems[0]['id']; // Return id of the stockinventory
        }
        unset($this->data->storeditemid);
        $this->data->stockinventoryid = $stockinventoryid;
        if ($stockinventoryid > 0) {
            $id = $this->stockItemsMdl->create($this->data->stockinventoryid, $this->data->amount, $this->data->expiryDate, $this->data->cost,  $this->data->price,  $this->data->code, $this->data->inventoryNo,  json_encode($this->data),  $this->data->locationid, time());
            if ($id===false){
                $result['error'] = "Couldn't add item to stock, error ".$this->stockItemsMdl->errorInfo;
                return $result;
            }
        }

        if ($this->createStockHistory($id, $this->data->locationid, 'Stock Added', $this->data->amount)===false){
            $result['error'] = "Could not create stock history record";
            return $result;
        }
        // Success; log data
        Logger::write("Stock Added", "STOCK", json_encode($this->data));
        return $result;
    }

    /**
     * Get stock history records for a specified item & location
     * @param $result
     * @return mixed
     */
    public function getStockHistory($result){
        if (($stockHist = $this->histMdl->get($this->data->stockitemid, $this->data->locationid))===false){
            $result['error']="Could not retrieve stock history";
        } else {
            $result['data']= $stockHist;
        }
        return $result;
    }

    /**
     * Create a stock history record for a item & location
     * @param $stockitemid
     * @param $locationid
     * @param $type
     * @param $amount
     * @param $sourceid
     * @param int $direction
     * @return bool
     */
    private function createStockHistory($stockitemid, $locationid, $type, $amount, $sourceid=-1, $direction=0){
        if ($this->histMdl->create($stockitemid, $locationid, $type, $amount, $sourceid, $direction)!==false){
            return true;
        }
        return false;
    }

    private function getIdForName($arr, $value){
        foreach($arr as $key => $item) {
            if ($item['name'] == $value)
                return $item['id'];
        }
        return false;
    }

    /**
     * Delete a stored item
     * @param $result
     * @return mixed
     */
    public function deleteStoredItem($result)
    {
        // validate input
        if (!is_numeric($this->data)) {
            if (isset($this->data)) {
                $ids = explode(",", $this->data);
                foreach ($ids as $id){
                    if (!is_numeric($id)){
                        $result['error'] = "A valid comma separated list of ids must be supplied";
                        return $result;
                    }
                }
            } else {
                $result['error'] = "A valid id, or comma separated list of ids must be supplied";
                return $result;
            }
        }
        // remove the item
        $stockItemsMdl = new StockItemsModel();
        $qresult = $stockItemsMdl->remove(isset($ids)?$ids:$this->data);
        if ($qresult === false) {
            $result['error'] = "Could not delete the item: ".$stockItemsMdl->errorInfo;
        } else {
            $result['data'] = true;
            // broadcast the item; supplying the id only indicates deletion
            $socket = new WposSocketIO();
            $socket->sendItemUpdate($this->data);

            // log data
            Logger::write("Item(s) deleted with id:" . $this->data, "ITEM");
        }
        return $result;
    }

} 