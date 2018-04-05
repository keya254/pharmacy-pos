<!-- WallacePOS: Copyright (c) 2014 WallaceIT <micwallace@gmx.com> <https://www.gnu.org/licenses/lgpl.html> -->
<div class="page-header">
    <h1 class="inline">
        Item Inventory
    </h1>
    <button onclick="openAddStockDialog();" id="addbtn" class="btn btn-primary btn-sm pull-right"><i class="icon-pencil align-top bigger-125"></i>Add</button>
    <button class="btn btn-success btn-sm pull-right" style="margin-right: 10px;" onclick="exportStock();"><i class="icon-cloud-download align-top bigger-125"></i>Download Template</button>
    <button class="btn btn-success btn-sm pull-right" style="margin-right: 10px;" onclick="openImportDialog();"><i class="icon-cloud-upload align-top bigger-125"></i>Update Inventory</button>
<!--    <input type="file" id="files" name="inventory" data-buttonText="" class="btn btn-success btn-sm pull-right" style="margin-right: 10px;"/>-->
</div><!-- /.page-header -->

<div class="row">
<div class="col-xs-12">
<!-- PAGE CONTENT BEGINS -->

<div class="row">
<div class="col-xs-12">

<div class="table-header">
    Manage your product inventory
</div>

<table id="stocktable" class="table table-striped table-bordered table-hover dt-responsive" style="width:100%;">
    <thead>
        <tr>
            <th data-priority="0" class="center">
                <label>
                    <input type="checkbox" class="ace" />
                    <span class="lbl"></span>
                </label>
            </th>
            <th data-priority="7">Code</th>
            <th data-priority="2">Name</th>
            <th data-priority="10">Description</th>
            <th data-priority="3">Location</th>
            <th data-priority="5">Cost</th>
            <th data-priority="6">Price</th>
            <th data-priority="4">Qty</th>
            <th data-priority="5">Supplier</th>
            <th data-priority="8">Invoice No</th>
            <th data-priority="9">Expiry Date</th>
            <th data-priority="11">Tax</th>
            <th data-priority="12">Category</th>
            <th data-priority="1" class="noexport">Actions</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</div>
</div>

</div><!-- PAGE CONTENT ENDS -->
</div><!-- /.row -->
<div id="editstockdialog" class="hide">
    <table>
        <tr>
            <input type="hidden" id="setstockid" />
            <input type="hidden" id="setstockinventoryid" />
            <input type="hidden" id="setstocklocid" />
        </tr>
      <tr>
        <td style="text-align: right;"><label>Name:</label></td>
        <td><input type="text" id="setstockname" class="form-control" disabled/></td>
      </tr>
      <tr>
        <td style="text-align: right;"><label>Qty:&nbsp;</label></td>
        <td><input id="setstockqty" type="text" class="form-control"/></td>
      </tr>
      <tr>
        <td style="text-align: right;"><label>Cost:&nbsp;</label></td>
        <td><input id="setstockcost" class="form-control" type="text"/></td>
      </tr>
      <tr>
        <td style="text-align: right;"><label>Price:&nbsp;</label></td>
        <td><input id="setstockprice" class="form-control" type="text"/></td>
      </tr>
      <tr>
        <td style="text-align: right;"><label>Expiry Date:&nbsp;</label></td>
        <td><input id="setstockexpiryDate" class="form-control" type="text" value=""/></td>
      </tr>
      <tr>
        <td style="text-align: right;"><label>Invoice No:&nbsp;</label></td>
        <td><input id="setstockinventoryNo" class="form-control" type="text"/></td>
      </tr>
      <tr>
        <td style="text-align: right;"><label>BatchNo/Code:&nbsp;</label></td>
        <td><input id="setstockcode" class="form-control" type="text"/></td>
      </tr>
    </table>
</div>
<div id="transferstockdialog" class="hide">
    <table>
        <tr>
            <input type="hidden" id="tstockitem" />
            <input type="hidden" id="tstockitemid" />
            <input type="hidden" id="tstocklocid" />
            <td style="text-align: right;"><label>Transfer to:&nbsp;</label></td>
            <td><select id="tstocknewlocid" class="locselect form-control">
                </select></td>
        </tr>
        <tr>
            <td style="text-align: right;"><label>Qty:&nbsp;</label></td>
            <td><input id="tstockqty" type="text" class="form-control" value="1"/></td>
        </tr>
    </table>
</div>
<div id="addstockdialog" class="hide">
    <table>
        <tr>
            <td style="text-align: right;"><label>Item(<span class="text-danger">Required</span>):</label></td>
            <td><select id="addstockitemid" class="itemselect form-control">
                </select></td>
        </tr>
        <tr>
            <td style="text-align: right;"><label>Location:</label></td>
            <td><select id="addstocklocid" class="locselect form-control">
            </select></td>
        </tr>
      <tr>
        <td style="text-align: right;"><label>Supplier:</label></td>
        <td><select id="addstocksupid" class="supselect form-control">
          </select></td>
      </tr>
        <tr>
            <td style="text-align: right;"><label>Qty(<span class="text-danger">Required</span>):&nbsp;</label></td>
            <td><input id="addstockqty" type="text" class="form-control" value="1"/></td>
        </tr>
        <tr>
            <td style="text-align: right;"><label>Cost(<span class="text-danger">Required</span>):&nbsp;</label></td>
            <td><input id="addstockcost" class="form-control" value="0.00" type="text"/></td>
        </tr>
        <tr>
            <td style="text-align: right;"><label>Price(<span class="text-danger">Required</span>):&nbsp;</label></td>
            <td><input id="addstockprice" class="form-control" value="0.00" type="text"/></td>
        </tr>
        <tr>
            <td style="text-align: right;"><label>Expiry Date:&nbsp;</label></td>
            <td><input id="addstockexpiryDate" class="form-control" value="31/12/2050" type="text" value=""/></td>
        </tr>
        <tr>
            <td style="text-align: right;"><label>Invoice No:&nbsp;</label></td>
            <td><input id="addstockinventoryNo" class="form-control" value="INV000" type="text"/></td>
        </tr>
        <tr>
              <td style="text-align: right;"><label>BatchNo/Code:&nbsp;</label></td>
              <td><input id="addstockcode" class="form-control" value="M0001" type="text"/></td>
        </tr>
    </table>
</div>
<div id="stockhistdialog" class="hide">

    <div style="width: 100%; overflow-x: auto;">
    <table class="table table-responsive table-stripped">
        <thead>
            <tr>
                <th>Item</th>
                <th>Location</th>
                <th>Type</th>
                <th>Amount</th>
                <th>DT</th>
            </tr>
        </thead>
        <tbody id="stockhisttable">

        </tbody>
    </table>
    </div>
</div>

<!-- page specific plugin scripts; migrated to index.php due to heavy use -->
<script type="text/javascript" src="/admin/assets/js/jquery.csv.js"></script>
<link rel="stylesheet" href="/admin/assets/js/csv-import/lib/jquery.ezdz.min.css"/>
<script type="text/javascript" src="/admin/assets/js/csv-import/lib/jquery.ezdz.min.js"></script>
<script type="text/javascript" src="/admin/assets/js/csv-import/lib/jquery-sortable-min.js"></script>
<script type="text/javascript" src="/admin/assets/js/csv-import/lib/jquery.csv-0.71.min.js"></script>
<script type="text/javascript" src="/admin/assets/js/csv-import/csv.import.tool.js"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">
    var stock = null;
    var items = null;
    var suppliers = null;
    var categories = null;
    var locations = null;
    var datatable;
    $(function() {
        stock = WPOS.getJsonData("stock/get");
        items = WPOS.getJsonData("items/get");
        suppliers = WPOS.getJsonData("suppliers/get");
        categories = WPOS.getJsonData("categories/get");
        locations = WPOS.locations;
        var stockarray = [];
        var tempstock;
        var taxrules = WPOS.getTaxTable().rules;
        for (var key in stock){
            tempstock = stock[key];
            if (taxrules.hasOwnProperty(tempstock.taxid)){
              tempstock.taxname = taxrules[tempstock.taxid].name;
            } else {
              tempstock.taxname = "Not Defined";
            }
            if (tempstock.stockType === '1')
              stockarray.push(tempstock);
        }
        datatable = $('#stocktable').dataTable({"bProcessing": true,
            "aaData": stockarray,
            "aaSorting": [[ 2, "asc" ]],
            "aLengthMenu": [ 10, 25, 50, 100, 200],
            "aoColumns": [
                { mData:null, sDefaultContent:'<div style="text-align: center"><label><input class="ace dt-select-cb" type="checkbox"><span class="lbl"></span></label><div>', bSortable: false },
                { mData:"code" },
                { mData:function(data,type,val){return (data.name==null?"Unknown":data.name) } },
                { mData:"description" },
                { mData:function(data,type,val){return (data.locationid!=='0'?(WPOS.locations.hasOwnProperty(data.locationid)?WPOS.locations[data.locationid].name:'Unknown'):'Warehouse');} },
                { mData:"cost" },
                { mData:"price" },
                { mData:"stocklevel" },
                { mData:"supplier" },
                { mData:"inventoryNo" },
                { mData:"expiryDate" },
                { mData:"taxname" },
                { mData:function(data,type,val){return (data.categoryid!=='0'?(categories.hasOwnProperty(data.categoryid)?categories[data.categoryid].name:'Unknown'):'General');} },
                { mData:function(data,type,val){return '<div class="action-buttons"><a class="green" onclick="openEditStockDialog('+data.id+');"><i class="icon-pencil bigger-130"></i></a><a class="blue" onclick="openTransferStockDialog('+data.id+')"><i class="icon-arrow-right bigger-130"></i></a><a class="red" onclick="getStockHistory('+data.id+', '+data.locationid+');"><i class="icon-time bigger-130"></i></a><a class="red" onclick="deleteStockItem('+data.id+');"><i class="icon-trash bigger-130"></i></a></div>'; }, "bSortable": false }
            ],
            "columns": [
                {},
                {type: "string"},
                {type: "string"},
                {type: "string"},
                {type: "numeric"},
                {type: "numeric"},
                {type: "numeric"},
                {type: "numeric"},
                {type: "string"},
                {type: "string"},
                {type: "string"},
                {}
            ],
            "fnInfoCallback": function( oSettings, iStart, iEnd, iMax, iTotal, sPre ) {
                // Add selected row count to footer
                var selected = this.api().rows('.selected').count();
                return sPre+(selected>0 ? '<br/>'+selected+' row(s) selected':'');
            }
        });

        // row selection checkboxes
        datatable.find("tbody").on('click', '.dt-select-cb', function(e){
            var row = $(this).parents().eq(3);
            if (row.hasClass('selected')) {
                row.removeClass('selected');
            } else {
                row.addClass('selected');
            }
            datatable.api().draw(false);
            e.stopPropagation();
        });

        $('table.dataTable th input:checkbox').on('change' , function(){
            var that = this;
            $(this).closest('table.dataTable').find('tr > td:first-child input:checkbox')
                .each(function(){
                    var row = $(this).parents().eq(3);
                    if ($(that).is(":checked")) {
                        row.addClass('selected');
                        $(this).prop('checked', true);
                    } else {
                        row.removeClass('selected');
                        $(this).prop('checked', false);
                    }
                });
            datatable.api().draw(false);
        });

        // dialogs
        $( "#addstockdialog" ).removeClass('hide').dialog({
                resizable: false,
                width: 'auto',
                modal: true,
                autoOpen: false,
                title: "Add Stock",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='icon-save bigger-110'></i>&nbsp; Save",
                        "class" : "btn btn-success btn-xs",
                        click: function() {
                            saveItem(1);
                        }
                    }
                    ,
                    {
                        html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancel",
                        "class" : "btn btn-xs",
                        click: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                ],
            create: function( event, ui ) {
                // Set maxWidth
                $(this).css("maxWidth", "400px");
            }
        });
        $( "#editstockdialog" ).removeClass('hide').dialog({
            resizable: false,
            width: 'auto',
            modal: true,
            autoOpen: false,
            title: "Edit Stock",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-save bigger-110'></i>&nbsp; Update",
                    "class" : "btn btn-success btn-xs",
                    click: function() {
                        saveItem(2);
                    }
                }
                ,
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancel",
                    "class" : "btn btn-xs",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                }
            ],
            create: function( event, ui ) {
                // Set maxWidth
                $(this).css("maxWidth", "375px");
            }
        });
        $( "#transferstockdialog" ).removeClass('hide').dialog({
            resizable: false,
            width: 'auto',
            modal: true,
            autoOpen: false,
            title: "Transfer Stock",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-save bigger-110'></i>&nbsp; Update",
                    "class" : "btn btn-success btn-xs",
                    click: function() {
                        saveItem(3);
                    }
                }
                ,
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancel",
                    "class" : "btn btn-xs",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                }
            ],
            create: function( event, ui ) {
                // Set maxWidth
                $(this).css("maxWidth", "375px");
            }
        });
        $( "#stockhistdialog" ).removeClass('hide').dialog({
            resizable: false,
            width: 'auto',
            maxWidth: '700px',
            modal: true,
            autoOpen: false,
            title: "Stock History",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Close",
                    "class" : "btn btn-xs",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                }
            ],
            create: function( event, ui ) {
                // Set maxWidth
                $(this).css("maxWidth", "700px");
            }
        });
        // fill location selects
        var locselect = $(".locselect");
        locselect.html('');
        var config = JSON.parse(localStorage.getItem('wpos_config'));
        var location = config.locationname;
        for (key in WPOS.locations){
            if (key == 0){
                locselect.append('<option class="form-control locid-0" value="0">Warehouse</option>');
            } else {
              if (location === WPOS.locations[key].name) {
                locselect.append('<option selected class="form-control locid-' + WPOS.locations[key].id + '" value="' + WPOS.locations[key].id + '">' + WPOS.locations[key].name + '</option>');
              }else {
                locselect.append('<option class="form-control locid-' + WPOS.locations[key].id + '" value="' + WPOS.locations[key].id + '">' + WPOS.locations[key].name + '</option>');
              }
            }
        }

        // fill supplier selects
        var supselect = $(".supselect");
        supselect.html('');
        for (key in suppliers){
          supselect.append('<option class="form-control supid-'+suppliers[key].id+'" value="'+suppliers[key].id+'">'+suppliers[key].name+'</option>');
        }

        // hide loader
        WPOS.util.hideLoader();

    });

    function getLocation(location) {
      var l = -1;
      for(var i in locations) {
        if(location === locations[0].name) {
          l = 0;
          break;
        } else if (location !== locations[i].name) {
          continue;
        } else {
          l = locations[i].id;
        }
      }
      if (l === -1) {
        swal({
                type: 'error',
                title: 'Oops...',
                text: location + ' is not a registered location. Item will be added to Warehouse'
            });

      }
      return l;
    }

    // updating records
    function getStockHistory(id, locationid){
        WPOS.util.showLoader();
        var stockhist = WPOS.sendJsonData("stock/history", JSON.stringify({stockitemid: id, locationid: locationid}));
        // populate stock dialog with list
        $("#stockhisttable").html("");
        var hist;
        for (var i in stockhist){
            hist = stockhist[i];
            $("#stockhisttable").append('<tr><td>'+hist.name+'</td><td>'+hist.location+'</td><td>'+hist.type+(hist.auxid!=-1?(hist.auxdir==1?" from ":" to ")+(hist.auxid==0?"Warehouse":WPOS.locations[hist.auxid].name):"")+'</td><td>'+hist.amount+'</td><td>'+hist.dt+'</td></tr>');
        }
        WPOS.util.hideLoader();
        $("#stockhistdialog").dialog('open');
    }
    function deleteStockItem(id){
      var results = WPOS.sendJsonData("stock/delete", JSON.stringify(id));
      if (results) {
        reloadTable();
      }
    }
    function openEditStockDialog(id){
        var item = stock[id];
        $("#setstockid").val(item.id);
        $("#setstockname").val(item.name);
        $("#setstockinventoryid").val(item.stockinventoryid);
        $("#setstocklocid").val(item.locationid);
        $("#setstockqty").val(item.stocklevel);
        $("#setstockcost").val(item.cost);
        $("#setstockprice").val(item.price);
        $("#setstockexpiryDate").val(item.expiryDate);
        $("#setstockinventoryNo").val(item.inventoryNo);
        $("#setstockcode").val(item.code);
        $("#editstockdialog").dialog("open");
    }
    function openAddStockDialog(){
        populateItems();
        $("#addstockdialog").dialog("open");
    }
    function openTransferStockDialog(id){
        var item = stock[id];
        $("#tstockitem").val(id);
        $("#tstockitemid").val(item.stockinventoryid);
        $("#tstocklocid").val(item.locationid);
        $("#transferstockdialog").dialog("open");
    }
    function populateItems(){
        WPOS.util.showLoader();
        items = WPOS.sendJsonData("items/get");
        var itemselect = $(".itemselect");
        itemselect.html('');
        for (var i in items){
          if (items[i].stockType === '1')
            itemselect.append('<option class="itemid-'+items[i].id+'" value="'+items[i].id+'">'+items[i].name+'</option>');
        }
        WPOS.util.hideLoader();
    }
    function saveItem(type){
        // show loader
        WPOS.util.showLoader();
        var item = {};
        switch (type){
        case 1:
            // adding new stock
            item.storeditemid = $("#addstockitemid option:selected").val();
            item.locationid = $("#addstocklocid option:selected").val();
            item.supplierid = $("#addstocksupid option:selected").val();
            item.amount = $("#addstockqty").val();
            item.cost = $("#addstockcost").val();
            item.price = $("#addstockprice").val();
            item.expiryDate = $("#addstockexpiryDate").val();
            item.inventoryNo = $("#addstockinventoryNo").val();
            item.code = $("#addstockcode").val();
            if (WPOS.sendJsonData("stock/add", JSON.stringify(item))!==false){
                reloadTable();
                $("#addstockdialog").dialog("close");
            }
            break;
        case 2:
            // set stock level
            item.id = $("#setstockid").val();
            item.name = $("#setstockname").val();
            item.stockinventoryid = $("#setstockinventoryid").val();
            item.locationid = $("#setstocklocid").val();
            item.stocklevel = $("#setstockqty").val();
            item.cost = $("#setstockcost").val();
            item.price = $("#setstockprice").val();
            item.expiryDate = $("#setstockexpiryDate").val();
            item.code = $("#setstockcode").val();
            item.inventoryNo = $("#setstockinventoryNo").val();
            if (WPOS.sendJsonData("stock/set", JSON.stringify(item))!==false){
                reloadTable();
                $("#editstockdialog").dialog("close");
            }
            break;
        case 3:
            // transfer stock
            item = stock[$("#tstockitem").val()];
            item.data = {};
            item.storeditemid = $("#tstockitemid").val();
            item.locationid = $("#tstocklocid").val();
            item.newlocationid = $("#tstocknewlocid").val();
            item.amount = $("#tstockqty").val();
            if (WPOS.sendJsonData("stock/transfer", JSON.stringify(item))!==false){
               reloadTable();
               $("#transferstockdialog").dialog("close");
            }
            break;
        }
        // hide loader
        WPOS.util.hideLoader();
    }
    function reloadTable(){
        stock = WPOS.getJsonData("stock/get");
        var stockarray = [];
        var tempstock;
        for (var key in stock){
            tempstock = stock[key];
            tempstock.taxname = WPOS.getTaxTable().rules[tempstock.taxid].name;
            if (tempstock.stockType === '1')
              stockarray.push(tempstock);
        }
        datatable.fnClearTable(false);
        datatable.fnAddData(stockarray, false);
        datatable.api().draw(false);
    }
    function exportStock(){
        var filename = "stock-"+WPOS.util.getDateFromTimestamp(new Date());
        filename = filename.replace(" ", "");

        var data = {};
        var config = JSON.parse(localStorage.getItem('wpos_config'));
        var sortable=[];
        var items = WPOS.getJsonData("items/get");
        var list = {};
        for(var item in items) {
            if (items[item].stockType === '1')
                list[items[item].name] = items[item];
        }
        for(var key in list)
            if(list.hasOwnProperty(key))
                sortable.push([key, list[key]]);
        var sorted = sortable.sort(function(a, b) {
          return a[1].name.localeCompare(b[1].name);
        });
        var i = 1;
        for(var item in sorted){
            i++;
            data[item] = {
                code: "",
                name: sorted[item][1].name,
                description: sorted[item][1].description,
                locationid: config.deviceconfig.locationid,
                cost: 0.00,
                price: '=(PRODUCT(E'+(i)+',1.3))',
                stocklevel: "",
                reorderpoint: sorted[item][1].reorderPoint,
                supplier: '',
                inventoryNo: "0000",
                expiryDate: "31/12/2050",
                taxname: WPOS.getTaxTable().rules[sorted[item][1].taxid].name,
                categoryid: sorted[item][1].categoryid
            };
        }

        if (Object.keys(data).length === 0) {
          data[0] = {
            code: "M00001",
            name: "Flu-gone 200ml",
            description: "Syrup",
            locationid: config.deviceconfig.locationid,
            cost: 100,
            price: '=(PRODUCT(E2,1.3))',
            stocklevel: 25,
            reorderpoint: 10,
            supplier: 'Freb',
            inventoryNo: "INV0001",
            expiryDate: "31/12/2050",
            taxname: "VAT",
            category: "Medicine"
          }
        }

        var csv = WPOS.data2CSV(
            ['Stock Code', '*Name', 'Description', '*Location', '*Unit Cost', '*Unit Price', '*Stock Level', 'Reorder Point', '*Supplier Name', 'Invoice No', 'Expiry Date', 'Tax Name', 'Category Name'],
            ['code', 'name', 'description',
              {key:'locationid', func: function(value){ return WPOS.locations.hasOwnProperty(value) ? WPOS.locations[value].name : 'Unknown'; }},
              'cost', 'price', 'stocklevel', 'reorderpoint', 'supplier', 'inventoryNo', 'expiryDate', 'taxname',
              {key:'categoryid', func: function(value){ return categories.hasOwnProperty(value) ? categories[value].name : 'GENERAL'; }}
            ],
            data
        );
        WPOS.initSave(filename, csv);
    }

    var importdialog = null;
    function openImportDialog(){
      if (importdialog!=null) {
        importdialog.csvImport("destroy");
      }
      importdialog = $("body").csvImport({
        jsonFields: {
          'code': {title:'Stock Code', required: false, value: "0000"},
          'name': {title:'*Name', required: true},
          'description': {title:'Description', required: false, value: "No Description"},
          'location': {title:'*Location', required: true},
          'cost': {title:'*Unit Cost', required: true},
          'price': {title:'*Unit Price', required: true},
          'amount': {title:'*Stock Level', required: true},
          'reorderpoint': {title:'Reorder Point', required: false, value: "0"},
          'supplier_name': {title:'*Supplier Name', required: true},
          'inventoryNo': {title:'Invoice No', required: false, value: "0000"},
          'expiryDate': {title:'Expiry Date', required: false, value: "31/12/2050"},
          'tax_name': {title:'Tax Name', required: false, value: "No Tax"},
          'category_name': {title:'Category Name', required: false, value: "General"}
        },
        csvHasHeader: true,
        importOptions: [
          {label: "Set unknown tax names to no tax", id:"skip_tax", checked:false},
          {label: "Create Items if doesn't exists", id:"add_items", checked:true},
          {label: "Create unknown suppliers", id:"add_suppliers", checked:true},
          {label: "Create unknown categories", id:"add_categories", checked:true}
        ],
        // callbacks
        onImport: function(jsondata, options){
          var data = [];
          for(var i=0; i<jsondata.length;i++){
            if (jsondata[i].amount === "0" || jsondata[i].amount === '' || jsondata[i].amount === null ) {
              continue;
            }
            data.push({
              name: jsondata[i].name,
              description: jsondata[i].description !== '' ? jsondata[i].description.toUpperCase(): "No Description",
              supplier_name: jsondata[i].supplier_name.toUpperCase(),
              locationid: getLocation(jsondata[i].location),
              cost: jsondata[i].cost,
              price: jsondata[i].price,
              stockType: '1',
              amount: jsondata[i].amount,
              reorderPoint: jsondata[i].reorderpoint !== '' ? jsondata[i].reorderpoint: "0",
              code: jsondata[i].code !== '' ? jsondata[i].code.toUpperCase(): "0000",
              expiryDate: jsondata[i].expiryDate !== '' ? jsondata[i].expiryDate: "30/12/2050",
              inventoryNo: jsondata[i].inventoryNo !== '' ? jsondata[i].inventoryNo.toUpperCase(): "INV0000",
              category_name: jsondata[i].category_name !== '' ? jsondata[i].category_name.toUpperCase(): "GENERAL",
              tax_name: jsondata[i].tax_name !== '' ? jsondata[i].tax_name: "No Tax"
            });
          }
          importItems(data, options);
        }
      });
    }

    function importItems(jsondata, options){
      showModalLoader("Importing Stock");
      var total = jsondata.length;
      setModalLoaderStatus("Uploading data...");
      var data = {"options":options, "import_data": jsondata};
      var result = WPOS.sendJsonDataAsync('stock/import/set', JSON.stringify(data), function(data){
        if (data!==false){
          WPOS.startEventSourceProcess(
            '/api/stock/import/start',
            function(data){
              if (data.hasOwnProperty('progress')) {
                setModalLoaderSubStatus(data.progress +" of "+ total);
                var progress = Math.round((100*data.progress)/total);
                setModalLoaderProgress(progress);
              }

              if (data.hasOwnProperty('status'))
                setModalLoaderStatus(data.status);

              if (data.hasOwnProperty('error')) {
                if (data.error == "OK") {
                  showModalCloseButton('Stock Import Complete!');
                } else {
                  showModalCloseButton("Error Importing Stock", data.error);
                }
                if (data.hasOwnProperty('data')){
                  // update table with imported items
                  for (var i in data.data) {
                    if (data.data.hasOwnProperty(i))
                      stock[i] = data.data[i];
                  }
                  reloadTable();
                }
              }
            },
            function(e){
              showModalCloseButton("Event feed failed "+ e.message);
            }
          );
        } else {
          showModalCloseButton("Stock Import Failed!");
        }
      }, function(error){
        showModalCloseButton("Stock Import Failed!", error);
      });
      if (!result)
        showModalCloseButton("Stock Import Failed!");
    }

    var eventuiinit = false;
    function initModalLoader(title){
      $("#modalloader").removeClass('hide').dialog({
        resizable: true,
        width: 400,
        modal: true,
        autoOpen: false,
        title: title,
        title_html: true,
        closeOnEscape: false,
        open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); }
      });
    }
    function showModalLoader(title){
      if (!eventuiinit){
        initModalLoader(title);
        eventuiinit = true;
      }
      $("#modalloader_status").text('Initializing...');
      $("#modalloader_substatus").text('');
      $("#modalloader_cbtn").hide();
      $("#modalloader_img").show();
      $("#modalloader_prog").show();
      var modalloader = $("#modalloader");
      modalloader.dialog('open');
    }
    function setModalLoaderProgress(progress){
      $("#modalloader_progbar").css('width', progress+"%")
      $("#modalloader_progbar").text(progress+"%");
    }
    function showModalCloseButton(result, substatus){
      $("#modalloader_status").text(result);
      setModalLoaderSubStatus(substatus? substatus : '');
      $("#modalloader_img").attr('src', '/assets/images/Check_mark.png');
      $("#modalloader_prog").hide();
      $("#modalloader_cbtn").show();
    }
    function setModalLoaderStatus(status){
      $("#modalloader_status").text(status);
    }
    function setModalLoaderSubStatus(status){
      $("#modalloader_substatus").text(status);
    }
</script>
<div id="modalloader" class="hide" style="width: 360px; height: 320px; text-align: center;">
  <img id="modalloader_img" style="width: 128px; height: auto;" src="/admin/assets/images/cloud_loader.gif"/>
  <div id="modalloader_prog" class="progress progress-striped active">
    <div class="progress-bar" id="modalloader_progbar" style="width: 100%;"></div>
  </div>
  <h4 id="modalloader_status">Initializing...</h4>
  <h5 id="modalloader_substatus"></h5>
  <button id="modalloader_cbtn" class="btn btn-primary" style="display: none; margin-top:40px;" onclick="$('#modalloader').dialog('close');">Close</button>
</div>

<style type="text/css">
    #itemstable_processing {
        display: none;
    }
</style>