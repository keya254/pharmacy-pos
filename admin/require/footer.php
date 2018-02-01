            <div id="loginmodal" class="login-layout">
              <div class="login-page">
                <div class="form text-center">
                  <img style="height: 35px; margin-top: -5px; margin-bottom: 10px;" src="/assets/images/Untitled-2.png">
                  <div id="login-banner" class="alert alert-block alert-success" style="display:none;">
                    <i class="icon icon-lock green" style="margin-right: 3px;"></i>
                    <span id="login-banner-txt"></span>
                  </div>
                  <form class="login-form">
                    <input class="form-control"id="loguser" type="text" placeholder="Admin"/>
                    <input class="form-control"id="logpass" onkeypress="if(event.keyCode == 13){WPOS.login();}" type="password"  placeholder="Password"/>
                    <button id="loginbutton" onClick="WPOS.userLogin();">login</button>
                  </form>
                  <div id="loadingdiv" style="height: 225px;">
                    <h3 id="loadingbartxt">Initializing</h3>
                    <div id="loadingprogdiv" class="progress progress-striped active">
                      <div class="progress-bar" id="loadingprog" style="width: 100%;"></div>
                    </div>
                    <span id="loadingstat"></span>
                  </div>
                </div>
              </div>
            </div>
            <a style="display: none;" id="dlelem" href=""></a>

            <div id="editcustdialog" class="hide">
              <div class="tabbable" style="min-width: 360px; min-height: 310px;">
                <ul class="nav nav-tabs">
                  <li class="active">
                    <a href="#details" data-toggle="tab">
                      Details
                    </a>
                  </li>
                  <li class="">
                    <a href="#notes" data-toggle="tab">
                      Notes
                    </a>
                  </li>
                  <li class="">
                    <a href="#contacts" data-toggle="tab">
                      Contacts
                    </a>
                  </li>
                  <li class="">
                    <a href="#options" data-toggle="tab">
                      Options
                    </a>
                  </li>
                </ul>

                <div class="tab-content" style="min-height: 320px;">
                  <div class="tab-pane active in" id="details">
                    <table>
                      <tr>
                        <td style="text-align: right;"><label>Name:&nbsp;</label></td>
                        <td><input class="form-control"id="custname" type="text"/><input class="form-control"id="custid" type="hidden"/></td>
                      </tr>
                      <tr>
                        <td style="text-align: right;"><label>Email:&nbsp;</label></td>
                        <td><input class="form-control"id="custemail" type="text"/></td>
                      </tr>
                      <tr>
                        <td style="text-align: right;"><label>Phone:&nbsp;</label></td>
                        <td><input class="form-control"id="custphone" type="text"/></td>
                      </tr>
                      <tr>
                        <td style="text-align: right;"><label>Mobile:&nbsp;</label></td>
                        <td><input class="form-control"id="custmobile" type="text"/></td>
                      </tr>
                      <tr>
                        <td style="text-align: right;"><label>Address:&nbsp;</label></td>
                        <td><input class="form-control"id="custaddress" type="text"/></td>
                      </tr>
                      <tr>
                        <td style="text-align: right;"><label>Suburb:&nbsp;</label></td>
                        <td><input class="form-control"id="custsuburb" type="text"/></td>
                      </tr>
                      <tr>
                        <td style="text-align: right;"><label>Postcode:&nbsp;</label></td>
                        <td><input class="form-control"id="custpostcode" type="text"/></td>
                      </tr>
                      <tr>
                        <td style="text-align: right;"><label>State:&nbsp;</label></td>
                        <td><input class="form-control"id="custstate" type="text"/></td>
                      </tr>
                      <tr>
                        <td style="text-align: right;"><label>Country:&nbsp;</label></td>
                        <td><input class="form-control"id="custcountry" type="text"/></td>
                      </tr>
                    </table>
                  </div>
                  <div class="tab-pane" id="notes" style="height: 280px;">
                    <textarea style="width: 100%; height: 100%;" id="custnotes"></textarea>
                  </div>
                  <div class="tab-pane" id="contacts">
                    <button onclick="WPOS.customers.openEditContactDialog(null);" class="btn btn-sm btn-primary pull-right">Add</button>
                    <table class="table table-stripped">
                      <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody id="contactstable">
                      <tr>
                        <td colspan="3" style="text-align: center;">No customer contacts</td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane" id="options" style="text-align: center;">
                    <button id="custdisbtn" class="btn btn-primary" onclick="WPOS.customers.setOnlineAccess();">Disable Customer Access</button>
                    <div class="space-10"></div>
                    <input class="form-control"id="newcustpass" type="password" autocomplete="off"/>
                    <button class="btn btn-primary" onclick="WPOS.customers.setOnlinePassword();">Set Customer Password</button>
                    <div class="space-10"></div>
                    <button class="btn btn-primary" onclick="WPOS.customers.sendResetEmail();">Send Password Reset Email</button>
                    <div class="space-10"></div>
                  </div>
                </div>
              </div>
            </div>
            <div id="addcustdialog" class="hide">
              <table>
                <tr>
                  <td style="text-align: right;"><label>Name:&nbsp;</label></td>
                  <td><input class="form-control"id="newcustname" type="text"/></td>
                </tr>
                <tr>
                  <td style="text-align: right;"><label>Email:&nbsp;</label></td>
                  <td><input class="form-control"id="newcustemail" type="text"/><br/></td>
                </tr>
                <tr>
                  <td style="text-align: right;"><label>Phone:&nbsp;</label></td>
                  <td><input class="form-control"id="newcustphone" type="text"/></td>
                </tr>
                <tr>
                  <td style="text-align: right;"><label>Mobile:&nbsp;</label></td>
                  <td><input class="form-control"id="newcustmobile" type="text"/></td>
                </tr>
                <tr>
                  <td style="text-align: right;"><label>Address:&nbsp;</label></td>
                  <td><input class="form-control"id="newcustaddress" type="text"/></td>
                </tr>
                <tr>
                  <td style="text-align: right;"><label>Suburb:&nbsp;</label></td>
                  <td><input class="form-control"id="newcustsuburb" type="text"/></td>
                </tr>
                <tr>
                  <td style="text-align: right;"><label>Postcode:&nbsp;</label></td>
                  <td><input class="form-control"id="newcustpostcode" type="text"/></td>
                </tr>
                <tr>
                  <td style="text-align: right;"><label>State:&nbsp;</label></td>
                  <td><input class="form-control"id="newcuststate" type="text"/></td>
                </tr>
                <tr>
                  <td style="text-align: right;"><label>Country:&nbsp;</label></td>
                  <td><input class="form-control"id="newcustcountry" type="text"/></td>
                </tr>
              </table>
            </div>
            <div id="custcontactdialog" class="hide">
              <form id="custcontactform">
                <input class="form-control"id="contid" type="hidden" value="0"/>
                <input class="form-control"id="contcustid" type="hidden" value="0"/>
                <table>
                  <tr>
                    <td style="text-align: right;"><label>Name:&nbsp;</label></td>
                    <td><input class="form-control"id="contname" type="text"/></td>
                  </tr>
                  <tr>
                    <td style="text-align: right;"><label>Position:&nbsp;</label></td>
                    <td><input class="form-control"id="contposition" type="text"/></td>
                  </tr>
                  <tr>
                    <td style="text-align: right;"><label>Email:&nbsp;</label></td>
                    <td><input class="form-control"id="contemail" type="text"/><br/></td>
                  </tr>
                  <tr>
                    <td style="text-align: right;"><label>Phone:&nbsp;</label></td>
                    <td><input class="form-control"id="contphone" type="text"/></td>
                  </tr>
                  <tr>
                    <td style="text-align: right;"><label>Mobile:&nbsp;</label></td>
                    <td><input class="form-control"id="contmobile" type="text"/></td>
                  </tr>
                  <tr>
                    <td style="text-align: right;"><label>Receives Invoices:&nbsp;</label></td>
                    <td><input class="form-control"id="contrecinv" type="checkbox"/></td>
                  </tr>
                </table>
              </form>
            </div>

            <div id="edittransdialog" class="hide" style="padding-left: 20px; padding-right: 20px;">
              <div style="width: 100%; margin: 0; margin-bottom: 5px;">
                <div style="display: inline-block; margin: 0; width: 49%; min-width: 250px; max-width: 300px; padding: 0 10px 5px 10px;">
                  <label class="fixedlabel">Status:</label> <span id="transstat"></span><br/>
                  <label class="fixedlabel">ID:</label> <span id="transid"></span><br/>
                  <label class="fixedlabel">Ref:</label> <span id="transref"></span><br/>
                  <label class="fixedlabel">Trans DT:</label> <span id="transtime"></span><br/>
                </div>
                <div style="display: inline-block; margin: 0; width: 49%; min-width: 250px; max-width: 300px; padding: 0 10px 5px 10px;">
                  <label class="fixedlabel">Process DT:</label> <span id="transptime"></span><br/>
                  <label class="fixedlabel">User:</label> <span id="transuser"></span><br/>
                  <label class="fixedlabel">Device:</label> <span id="transdev"></span><br/>
                  <label class="fixedlabel">Location:</label> <span id="transloc"></span><br/>
                </div>
                <div style="display: inline-block; margin: 0; width: 49%; min-width: 250px; max-width: 300px; padding: 0 10px 5px 10px; vertical-align: top;">
                  <label class="fixedlabel">Notes:</label><textarea style="width: 100%;" id="transnotes"></textarea>
                  <div class="space-8"></div>
                </div>
                <div style="display: inline-block; margin: 0; width: 49%; min-width: 250px; max-width: 300px; padding: 0 10px 5px 10px;">
                  <input class="form-control"type="hidden" autofocus="true" />
                  <div class="transinvoptions">
                    <label class="fixedlabel">Invoice Date:</label> <input class="form-control"type="text" id="invprocessdt" onclick="$(this).blur();" style="width: 110px"/>
                    <div class="space-4"></div>
                    <label class="fixedlabel">Due Date:</label> <input class="form-control"type="text" id="invduedt" onclick="$(this).blur();" style="width: 110px"/>
                    <div class="space-4"></div>
                    <label class="fixedlabel">Close Date:</label> <input class="form-control"type="text" id="invclosedt" onclick="$(this).blur();" style="width: 110px"/>
                    <div class="space-4"></div>
                    <label class="fixedlabel">Discount:</label> <input class="form-control"style="width: 60px;" type="text" id="invdiscountval" />%
                    <div class="space-4"></div>
                  </div>
                </div>
                <div style="text-align: center;">
                  <div class="transinvoptions" style="text-align: center;">
                    <button class="btn btn-sm btn-success" onclick="WPOS.transactions.updateInvoice();"><i class='icon-edit bigger-110'></i>&nbsp; Save</button>
                  </div>
                  <div class="transsaleoptions" style="text-align: center;">
                    <button class="btn btn-sm btn-success" onclick="WPOS.transactions.updateNotes();"><i class='icon-edit bigger-110'></i>&nbsp; Save</button>
                  </div>
                </div>
              </div>
              <div class="tabbable" style="margin-top: 10px;">
                <ul class="nav nav-tabs">
                  <li class="active">
                    <a href="#transdetails" data-toggle="tab">
                      <i class="green icon-gift bigger-120"></i>
                      Details
                    </a>
                  </li>
                  <li>
                    <a href="#transitems" data-toggle="tab">
                      <i class="green icon-gift bigger-120"></i>
                      Items
                    </a>
                  </li>
                  <li class="">
                    <a href="#transpayments" data-toggle="tab">
                      <i class="red icon-dollar bigger-120"></i>
                      Payments
                    </a>
                  </li>
                  <li class="">
                    <a href="#transoptions" data-toggle="tab">
                      <i class="blue icon-cogs bigger-120"></i>
                      Options
                    </a>
                  </li>
                </ul>

                <div class="tab-content">
                  <div class="tab-pane active in" id="transdetails">
                    <div class="inline" style="vertical-align: top; min-width: 250px;">
                      <h4>Sale Totals:</h4>
                      <label class="fixedlabel">Subtotal:</label><span id="transsubtotal"></span><br/>
                      <div id="transtax">
                      </div>
                      <div id="transdisdiv"><label class="fixedlabel">Discount:</label><span id="transdiscount"></span></div>
                      <label class="fixedlabel">Total:</label><span id="transtotal"></span><br/>
                      <div id="voidinfo" style="display: none;">
                        <h4>Void/Refunds:</h4>
                        <table style="width: 100%" class="table">
                          <thead class="table-header">
                          <tr>
                            <th>Type</th>
                            <th>Time</th>
                            <th>View</th>
                            <th>Delete</th>
                          </tr>
                          </thead>
                          <tbody id="transvoidtable" class="ui-widget-content">

                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="inline" style="min-width: 250px; vertical-align: top;">
                      <div id="tcustdetails">
                        <h4>Customer Details:</h4>
                        <span id="tcustname"></span><br/>
                        <span id="tcustaddress"></span><br/>
                        <span id="tcustsuburb"></span>, &nbsp;<span id="icustpostcode"></span><br/>
                        <span id="tcustcountry"></span>
                        <div class="space-4"></div>
                        P: <span id="tcustphone"></span><br/>
                        M: <span id="tcustmobile"></span><br/>
                        E: <span id="tcustemail"></span><br/>
                        <input class="form-control"type="hidden" id="tcustid"/>
                        <button id="transcustdtlbtn" class="btn btn-xs btn-primary" onclick="WPOS.customers.openCustomerDialog($('#tcustid').val());">Details</button>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="transitems">
                    <h4 class="inline">Items:</h4>
                    <button onclick="WPOS.transactions.openInvoiceItemDialog(false);" class="btn btn-sm btn-primary transinvoptions" style="float: right;">Add</button>
                    <table width="100%" class="table">
                      <thead class="table-header">
                      <tr align="left">
                        <th>Qty</th>
                        <th>Name</th>
                        <th>Unit</th>
                        <th>Tax</th>
                        <th>Price</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody id="transitemtable" style="overflow:auto;" class="ui-widget-content">

                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane" id="transpayments">
                    <h4 class="inline">Payments:</h4>
                    <button onclick="WPOS.transactions.openInvoicePaymentDialog(false);" class="btn btn-sm btn-primary transinvoptions" style="float: right;">Add</button>
                    <table width="100%" class="table">
                      <thead class="table-header">
                      <tr>
                        <th>Method</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody id="transpaymenttable" class="ui-widget-content">

                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane" id="transoptions">
                    <h4>Options:</h4>
                    <div style="text-align: center;">
                      <button onclick="WPOS.transactions.showGenerateDialog();" class="btn btn-sm btn-primary" style="padding: 5px;"><i class="icon-file"></i> Generate Invoice</button>
                      <button onclick="WPOS.transactions.showEmailDialog();" class="btn btn-sm btn-success" style="padding: 5px;"><i class="icon-envelope"></i> Email Invoice</button>
                      <button onclick="WPOS.transactions.showHistoryDialog();" class="btn btn-sm btn-warning" style="padding: 5px;"><i class="icon-list"></i> History</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="transitemdialog" class="hide" style="padding-left: 20px; padding-right: 20px;">
              <form id="transitemform">
                <input class="form-control"type="hidden" id="transitemid" value="0"/>
                <input class="form-control"type="hidden" id="transitemsitemid" value="0"/>
                <input class="form-control"type="hidden" id="transitemtaxval" value="0"/>
                <input class="form-control"type="hidden" id="transitempriceval" value="0"/>
                <label class="fixedlabel">Search: </label><input class="form-control"class="form-control" type="text" id="stitemsearch"/><br/>
                <div class="space-8"></div>
                <label class="fixedlabel">Qty: </label><input class="form-control"type="text" id="transitemqty" onchange="WPOS.transactions.calculateItemTotals();"/>
                <div class="space-4"></div>
                <label class="fixedlabel">Name: </label><input class="form-control"type="text" id="transitemname"/>
                <div class="space-4"></div>
                <label class="fixedlabel">Alt Name: </label><input class="form-control"type="text" id="transitemaltname"/><br/><small>Alternate language name</small>
                <div class="space-4"></div>
                <label class="fixedlabel">Description: </label><textarea style="width: 178px;" id="transitemdesc"></textarea>
                <div class="space-4"></div>
                <label class="fixedlabel">Cost: </label><input class="form-control"type="text" id="transitemcost"/>
                <div class="space-4"></div>
                <label class="fixedlabel">Unit: </label><input class="form-control"type="text" id="transitemunit" onchange="WPOS.transactions.calculateItemTotals();"/>
                <div class="space-4"></div>
                <label class="fixedlabel">Tax: </label><select type="text" id="transitemtaxid" class="taxselect" onchange="WPOS.transactions.calculateItemTotals();"></select>
                <div class="space-4"></div>
                <div id="transitemtax">
                </div>
                <label class="fixedlabel">Price: </label><span id="transitemprice">0</span><br/>
              </form>
            </div>
            <div id="transpaydialog" class="hide" style="padding-left: 20px; padding-right: 20px;">
              <form id="transpayform">
                <input class="form-control"type="hidden" autofocus="true" />
                <input class="form-control"type="hidden" id="transpayid" value="0"/>
                <label class="fixedlabel">Invoice Date: </label><input class="form-control"type="text" id="transpaydt" onclick="$(this).blur();"/>
                <div class="space-4"></div>
                <label class="fixedlabel">Method: </label><select id="transpaymethod">
                  <option value="deposit">Deposit</option>
                  <option value="cash">Cash</option>
                  <option value="mpesa">Mpesa</option>
                  <option value="eftpos">Eftpos</option>
                  <option value="credit">Credit</option>
                </select>
                <div class="space-4"></div>
                <label class="fixedlabel">Amount: </label><input class="form-control"type="text" id="transpayamount"/><br/>
              </form>
            </div>
            <div id="miscdialog" class="hide">
              <div id="geninvoiceform" style="text-align: center; min-width: 150px;">
                <h3>Invoice Template</h3>
                <select id="invoicetemplate">
                </select>
                <h3>View</h3>
                <button onclick="WPOS.transactions.generateInvoice('html', 0, $('#invoicetemplate').val());" class="btn btn-sm btn-primary" style="padding: 5px;">HTML</button>
                <button onclick="WPOS.transactions.generateInvoice('pdf', 0, $('#invoicetemplate').val());" class="btn btn-sm btn-primary" style="padding: 5px;">PDF</button>
                <h3>Download</h3>
                <button onclick="WPOS.transactions.generateInvoice('html', 1, $('#invoicetemplate').val());" class="btn btn-sm btn-primary" style="padding: 5px;">HTML</button>
                <button onclick="WPOS.transactions.generateInvoice('pdf', 1, $('#invoicetemplate').val());" class="btn btn-sm btn-primary" style="padding: 5px;">PDF</button>
              </div>
              <div id="sendinvoiceform" style="min-width: 420px;">
                <label class="smfixedlabel inline">Invoice Template: </label><div class="inline"><select id="emlinvoicetemplate"></select></div>
                <div class="space-4"></div>
                <label class="smfixedlabel inline">TO: </label><div class="inline"><input class="form-control"type="text" placeholder="Enter recipients..." id="emailto" class="email-input" name="tags"/></div>
                <div class="space-4"></div>
                <label class="smfixedlabel inline">CC: </label><div class="inline"><input class="form-control"type="text" placeholder="Enter recipients..." id="emailcc" class="email-input" name="tags"/></div>
                <div class="space-4"></div>
                <label class="smfixedlabel inline">BCC: </label><div class="inline"><input class="form-control"type="text" placeholder="Enter recipients..." id="emailbcc" class="email-input" name="tags"/></div>
                <div class="space-4"></div>
                <label class="smfixedlabel inline">Subject: </label><input class="form-control"style="width: 410px;" type="text" placeholder="Enter Subject" id="emailsubject" />
                <div class="space-4"></div>
                <div class="wysiwyg-editor" id="emailmessage"></div>
                <div class="space-8"></div>
                <div style="text-align: center;">
                  <button type="button" onclick="WPOS.transactions.emailInvoice();" class="btn btn-primary">Send</button>
                </div>
              </div>
              <div id="transhist">
                <table class="table table-stripped table-responsive">
                  <thead>
                  <tr>
                    <th>Time</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Description</th>
                  </tr>
                  </thead>
                  <tbody id="transhisttable">
                  </tbody>
                </table>
              </div>
              <div id="voiddetails">
                <label class="fixedlabel">Time: </label><span id="reftime"></span><br/>
                <label class="fixedlabel">User: </label><span id="refuser"></span><br/>
                <label class="fixedlabel">Device: </label><span id="refdev"></span><br/>
                <label class="fixedlabel">Location: </label><span id="refloc"></span><br/>
                <label class="fixedlabel">Reason: </label><span id="refreason"></span><br/>

                <div id="refunddetails">
                  <label class="fixedlabel">Amount: </label><span id="refamount"></span>
                  <div class="space-6"></div>
                  <label class="fixedlabel">Method: </label><span id="refmethod"></span>
                  <button style="float: right; display: inline-block;" onclick="WPOS.transactions.showPaymentInfo(this);" id="refpaydtlbtn" class="btn btn-xs btn-primary">Details</button>
                  <div class="space-6"></div>
                  <table style="width: 100%;" class="table">
                    <thead class="table-header">
                    <tr>
                      <th>Item ID</th>
                      <th># Returned</th>
                    </tr>
                    </thead>
                    <tbody id="refitemtable">

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div id="eftdetailsdialog" class="hide" title="Payment Details">
              <div>
                <div>
                  <label>Reference: <span id="efttransref" style="margin-right: 20px;"></span></label>
                  <label>Card Type: <span id="efttranscard"></span></label>
                </div>
              </div>
              <div>
                <div style="width: 250px; display: inline-block; text-align: center;">
                  <pre id="eftcustrec"></pre>
                </div>
                <div style="width: 250px; display: inline-block; text-align: center;">
                  <pre id="eftmerchrec"></pre>
                </div>
              </div>
            </div>
            <div id="voidform" style="display:none; padding:5px; z-index: 1100;" title="Void Invoice">
              <input class="form-control"id="voidref" type="hidden" value=""/>
              <label class="fixedlabel">Reason:</label><br/>
              <textarea rows="6" id="voidreason" style="width: 100%;"></textarea>
            </div>
            <div id="translistdialog" class="hide">
              <table class="table table-responsive">
                <thead>
                <tr id="translistheader">
                  <th>Ref</th>
                  <th>Details</th>
                </tr>
                </thead>
                <tbody id="translist">

                </tbody>
              </table>
            </div>
            </div>
            </div>
            </div>
            <?php require_once './require/_footer.html'?>
            </div>
        </div>
    </div>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../node_modules/chart.js/dist/Chart.min.js"></script>
    <script src="../node_modules/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5NXz9eVnyJOA81wimI8WYE08kW_JMe8g&callback=initMap" async defer></script>
    <script src="./start/assets/js/off-canvas.js"></script>
    <script src="./start/assets/js/hoverable-collapse.js"></script>
    <script src="./start/assets/js/misc.js"></script>
    <script src="./start/assets/js/chart.js"></script>
    <script src="./start/assets/js/maps.js"></script>


            <!-- basic scripts -->

            <!--[if !IE]> -->
            <script type="text/javascript">
              window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
            </script>
            <!-- <![endif]-->

            <!--[if IE]>
            <script type="text/javascript">
              window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
            </script>
            <![endif]-->

            <script type="text/javascript">
              if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
            </script>
            <script src="/assets/js/bootstrap.min.js"></script>
            <!--<script src="assets/js/typeahead"></script>!-->

            <!-- page specific plugin scripts -->

            <!--[if lte IE 8]>
            <script src="assets/js/excanvas.min.js"></script>
            <![endif]-->
            <script src="assets/js/typeahead-bs2.min.js"></script>
            <script src="assets/js/jquery-ui-1.10.3.full.min.js"></script>
            <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
            <script src="assets/js/jquery.slimscroll.min.js"></script>
            <script src="assets/js/jquery.easy-pie-chart.min.js"></script>
            <script src="assets/js/jquery.sparkline.min.js"></script>
            <script src="assets/js/flot/jquery.flot.min.js"></script>
            <script src="assets/js/flot/jquery.flot.pie.min.js"></script>
            <script src="assets/js/flot/jquery.flot.resize.min.js"></script>
            <script src="assets/js/flot/jquery.flot.time.min.js"></script>
            <script src="assets/js/bootstrap-tag.js"></script>

            <!-- ace scripts -->
            <script src="assets/js/ace-elements.min.js"></script>
            <script src="assets/js/ace.min.js"></script>

            <!-- Scripts included on many of the pages -->
            <script src="../assets/js/wpos/utilities.js"></script>

            <script src="/assets/libs/datatables/datatables.min.js"></script>
            <script src="/assets/libs/datatables/datatableSorting.js"></script>

            <script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
            <script src="assets/js/select2/select2.min.js"></script>
            <script src="assets/js/jquery.hotkeys.min.js"></script>
            <script src="assets/js/bootstrap-wysiwyg.min.js"></script>
            <script src="assets/js/bootbox.min.js"></script>

            <script src="assets/wpos/wpos.js"></script>
            <script src="assets/wpos/customers.js"></script>
            <script src="assets/wpos/transactions.js"></script>

            <!-- Websocket library -->
            <script type="text/javascript" src="/assets/libs/socketio/socket.io-1.4.5.js"></script>
    </body>
</html>