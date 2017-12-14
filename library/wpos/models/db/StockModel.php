<?php
/**
 * StockModel is part of Wallace Point of Sale system (WPOS) API
 *
 * StockModel extends the DbConfig PDO class to interact with the config DB table
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
class StockModel extends DbConfig
{

    /**
     * @var array
     */
    protected $_columns = ['id', 'storeditemid', 'supplierid'];

    /**
     * Init the DB
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @param $storeditemid
     * @param $supplierid
     * @return bool|string Returns false on an unexpected failure, returns -1 if a unique constraint in the database fails, or the new rows id if the insert is successful
     */
    public function create($storeditemid, $supplierid)
    {
        $sql          = "INSERT INTO stock_inventory (`storeditemid`, `supplierid`) VALUES (:storeditemid, :supplierid);";
        $placeholders = [":storeditemid"=>$storeditemid, ":supplierid"=>$supplierid];

        return $this->insert($sql, $placeholders);
    }

    /**
     * @param $storeditemid
     * @param $supplierid
     * @return bool|int|string Returns false on failure, number of rows affected or a newly inserted id.
     */
    public function setStockLevel($storeditemid, $supplierid){

        $sql = "UPDATE stock_inventory SET `storeditemid`=:storeditemid, `supplierid`=:supplierid WHERE `storeditemid`=:storeditemid AND `id`=:id";
        $placeholders = [":storeditemid"=>$storeditemid, ":supplierid"=>$supplierid];
        $result=$this->update($sql, $placeholders);
        if ($result>0) // if row has been updated, return
            return $result;

        if ($result===false) // if error occured return
            return false;

        // Otherwise add a new stock record, none exists
        return $this->create($storeditemid, $supplierid);
    }

    /**
     * Returns an array of stock records, optionally including special reporting values
     * @param null $storeditemid
     * @param null $locationid
     * @param bool $report
     * @return array|bool Returns false on failure, or an array of stock records
     */
    public function get($storeditemid= null, $locationid= null, $report=false){

        $sql = 'SELECT s.*, items.name AS name, items.categoryid AS categoryid, items.description AS description, COALESCE(p.name, "Misc") AS supplier'.($report?', l.name AS location, s.price*s.stocklevel as stockvalue':'').' FROM stock_items as s LEFT JOIN stock_inventory as i ON s.stockinventoryid=i.id LEFT JOIN stored_items as items ON i.storeditemid=items.id LEFT JOIN stored_suppliers as p ON i.supplierid=p.id LEFT JOIN stored_categories as c ON items.categoryid=c.id'.($report?' LEFT JOIN locations as l ON s.locationid=l.id':'');
        $placeholders = [];
        if ($storeditemid !== null) {
            if (empty($placeholders)) {
                $sql .= ' WHERE';
            }
            $sql .= ' s.storeditemid = :storeditemid';
            $placeholders[':storeditemid'] = $storeditemid;
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
     * Get stock record by item id.
     * @param $storeditemid
     * @param $supplierid
     * @return bool|int Returns false on failure, or number of records
     */
    public function getByItemId($storeditemid, $supplierid){
        if ($storeditemid === null || $supplierid === null) {
            return false;
        }
        $sql          = "SELECT * FROM stock_inventory WHERE storeditemid=:storeditemid AND supplierid=:supplierid;";
        $placeholders = [":storeditemid"=>$storeditemid, ":supplierid"=>$supplierid];

        return $this->select($sql, $placeholders);
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
        $sql          = "DELETE FROM stock_inventory WHERE id=:itemid;";
        $placeholders = [":id"=>$itemid];

        return $this->delete($sql, $placeholders);
    }

    /**
     * Remove stock record by supplierd id.
     * @param $supplierid
     * @return bool|int Returns false on failure, or number of records deleted
     */
    public function removeBySupplierId($supplierid){
        if ($supplierid === null) {
            return false;
        }
        $sql          = "DELETE FROM stock_inventory WHERE supplierid=:supplierid;";
        $placeholders = [":supplierid"=>$supplierid];

        return $this->delete($sql, $placeholders);
    }

}