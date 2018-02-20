<?php
/**
 * StockitemsModel is part of Wallace Point of Sale system (WPOS) API
 *
 * StockItemsModel extends the DbConfig PDO class to interact with the config DB table
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
 * @since      File available since 24/05/14 4:13 PM
 */
class StockItemsModel extends DbConfig
{

    /**
     * @var array
     */
    protected $_columns = ['id', 'storeditemid', 'stocklevel', 'batchNo', 'expiryDate','cost', 'price', 'code', 'data', 'locationid', 'dt'];

    /**
     * Init the DB
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @param $stockinventoryid
     * @param $locationid
     * @param $stocklevel
     * @param $expiryDate
     * @param $cost
     * @param $price
     * @param $code
     * @param $inventoryNo
     * @param $data
     * @param $locationid
     * @param $dt
     * @return bool|string Returns false on an unexpected failure, returns -1 if a unique constraint in the database fails, or the new rows id if the insert is successful
     */
    public function create($stockinventoryid, $stocklevel, $expiryDate, $cost, $price, $code, $inventoryNo, $data, $locationid, $dt)
    {
        $sql          = "INSERT INTO stock_items (`stockinventoryid`, `stocklevel`, `expiryDate`,  `cost`, `price`, `code`, `inventoryNo`, `data`, `locationid`) VALUES (:stockinventoryid, :stocklevel, :expiryDate, :cost, :price, :code, :inventoryNo, :data, :locationid);";
        $placeholders = [":stockinventoryid"=>$stockinventoryid, ":stocklevel"=>$stocklevel,   ":expiryDate"=>$expiryDate, ":cost"=>$cost, ":price"=>$price, ":code"=>$code,  ":inventoryNo"=>$inventoryNo, ":data"=>$data,  ":locationid"=>$locationid];

        return $this->insert($sql, $placeholders);
    }


    /**
     * @param null $Id
     * @param null $code
     * @return array|bool Returns false on an unexpected failure or an array of selected rows
     */
    public function get($Id = null, $code = null) {
        $sql = 'SELECT * FROM stock_items';
        $placeholders = [];
        if ($Id !== null) {
            if (empty($placeholders)) {
                $sql .= ' WHERE';
            }
            $sql .= ' id = :id';
            $placeholders[':id'] = $Id;
        }
        if ($code !== null) {
            if (empty($placeholders)) {
                $sql .= ' WHERE';
            }
            $sql .= ' code = :code';
            $placeholders[':code'] = $code;
        }

        $items = $this->select($sql, $placeholders);
        if ($items===false)
            return false;

        foreach($items as $key=>$item){
            $data = json_decode($item['data'], true);
            $data['id'] = $item['id'];
            $items[$key] = $data;
        }

        return $items;
    }

    /**
     * Returns an array of stock records, optionally including special reporting values
     * @param null $stockinventoryid
     * @param null $locationid
     * @param bool $report
     * @return array|bool Returns false on failure, or an array of stock records
     */
    public function getItem($stockinventoryid= null, $locationid= null, $report=false){

        $sql = 'SELECT s.*, items.name AS name, COALESCE(p.name, "Misc") AS supplier'.($report?', l.name AS location, s.price*s.stocklevel as stockvalue':'').' FROM stock_items as s LEFT JOIN stock_inventory as i ON s.stockinventoryid=i.id LEFT JOIN stored_items as items ON i.storeditemid=items.id LEFT JOIN stored_suppliers as p ON i.supplierid=p.id LEFT JOIN stored_categories as c ON items.categoryid=c.id'.($report?' LEFT JOIN locations as l ON s.locationid=l.id':'');
        $placeholders = [];
        if ($stockinventoryid !== null) {
            if (empty($placeholders)) {
                $sql .= ' WHERE';
            }
            $sql .= ' s.stockinventoryid = :stockinventoryid';
            $placeholders[':stockinventoryid'] = $stockinventoryid;
        }
        if ($locationid !== null) {
            if (empty($placeholders)) {
                $sql .= ' WHERE';
            } else {
                $sql .= ' AND';
            }
            $sql .= ' s.locationid = :locationid';
            $placeholders[':locationid'] = $locationid;
        }

        return $this->select($sql, $placeholders);
    }

    /**
     * @param $id
     * @param $stockinventoryid
     * @param $locationid
     * @param $stocklevel
     * @param $expiryDate
     * @param $cost
     * @param $price
     * @param $code
     * @param $inventoryNo
     * @param $data
     * @param $locationid
     * @return bool|int|string Returns false on failure, number of rows affected or a newly inserted id.
     */
    public function setStockLevel($id, $stockinventoryid, $stocklevel, $expiryDate, $cost, $price, $code, $inventoryNo, $data, $locationid){

        $sql = "UPDATE stock_items SET `stockinventoryid`=:stockinventoryid, `stocklevel`=:stocklevel, `expiryDate`=:expiryDate,  `cost`=:cost, `price`=:price, `code`=:code, `inventoryNo`=:inventoryNo, `data`=:data, `locationid`=:locationid WHERE `stockinventoryid`=:stockinventoryid AND `id`=:id";
        $placeholders = [":id"=>$id, ":stockinventoryid"=>$stockinventoryid, ":stocklevel"=>$stocklevel, ":expiryDate"=>$expiryDate,  ":cost"=>$cost, ":price"=>$price, ":code"=>$code, ":inventoryNo"=>$inventoryNo, ":data"=>$data,  ":locationid"=>$locationid];
        $result=$this->update($sql, $placeholders);
        if ($result>0) // if row has been updated, return
            return $result;

        if ($result===false) // if error occured return
            return false;

        // Otherwise add a new stock record, none exists
        return $this->create($stockinventoryid, $stocklevel, $expiryDate,  $cost, $price, $code, $inventoryNo, $data, $locationid, time());
    }

    /**
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
     * @return bool|int|string Returns false on failure, number of rows affected or a newly inserted id.
     */
    public function incrementStockLevel($stockinventoryid, $stocklevel, $locationid, $decrement = false, $expiryDate=null, $cost=null, $price=null, $code=null, $inventoryNo=null, $data=null){
        $sql = "UPDATE stock_items SET  `stockinventoryid`=:stockinventoryid, `stocklevel`= (`stocklevel` ".($decrement==true?'-':'+')." :stocklevel), `expiryDate`=:expiryDate,  `cost`=:cost, `price`=:price, `code`=:code, `inventoryNo`=:inventoryNo, `data`=:data, `locationid`=:locationid WHERE `stockinventoryid`=:stockinventoryid AND `locationid`=:locationid";
        $placeholders = [":stockinventoryid"=>$stockinventoryid, ":stocklevel"=>$stocklevel,   ":expiryDate"=>$expiryDate,  ":cost"=>$cost, ":price"=>$price, ":code"=>$code, ":inventoryNo"=>$inventoryNo, ":data"=>$data,  ":locationid"=>$locationid];
        $result=$this->update($sql, $placeholders);

        if ($result>0) return $result;

        if ($result===false) return false;

        if ($decrement===false){ // if adding stock and no record exists, create it
            return $this->create($stockinventoryid, $stocklevel, $expiryDate,  $cost, $price, $code, $inventoryNo, $data, $locationid, time());
        }

        return true;
    }

    public function decrementStockLevel($id, $stocklevel, $decrement){
        $sql = "UPDATE stock_items SET  `stocklevel`= (`stocklevel` ".($decrement==true?'-':'+')." :stocklevel) WHERE `id`=:id";
        $placeholders = [":id"=>$id, ":stocklevel"=>$stocklevel];
        $result=$this->update($sql, $placeholders);

        if ($result>0) return $result;

        if ($result===false) return false;

        return true;
    }

    /**
     * Remove stock record by item id.
     * @param $itemid
     * @return bool|int Returns false on failure, or number of records deleted
     */
    public function removeByItemId($itemid){
        if ($itemid === null) {
            return false;
        }
        $sql          = "DELETE FROM stock_items WHERE id=:itemid;";
        $placeholders = [":id"=>$itemid];

        return $this->delete($sql, $placeholders);
    }

    /**
     * Remove stock record by location id.
     * @param $locationid
     * @return bool|int Returns false on failure, or number of records deleted
     */
    public function removeByLocationId($locationid){
        if ($locationid === null) {
            return false;
        }
        $sql          = "DELETE FROM stock_items WHERE locationid=:locationid;";
        $placeholders = [":locationid"=>$locationid];

        return $this->delete($sql, $placeholders);
    }

    /**
     * @param integer|array $id
     * @return bool|int Returns false on an unexpected failure or the number of rows affected by the delete operation
     */
    public function remove($id){

        $placeholders = [];
        $sql = "DELETE FROM stock_items WHERE ";
        if (is_numeric($id)){
            $sql .= " `id`=:id;";
            $placeholders[":id"] = $id;
        } else if (is_array($id)) {
            $id = array_map([$this->_db, 'quote'], $id);
            $sql .= " `id` IN (" . implode(', ', $id) . ");";
        } else {
            return false;
        }

        return $this->delete($sql, $placeholders);
    }

}