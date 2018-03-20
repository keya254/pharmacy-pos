<div style="text-align: center;">
    <ul class="breadcrumb">
        <li>Check Requirements</li>
        <li>Configure Database</li>
        <li><strong>Initial Setup</strong></li>
        <li>Install System</li>
    </ul>
</div>
<div>
    <h4>Choose a password for the admin user</h4>
    <form role="form" class="form-horizontal" method="post" onsubmit="return validatePassword();">
        <input name="doinstall" type="hidden" value="1">
        <div class="space-8"></div>
        <div class="form-group">
            <label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Password </label>
            <div class="col-sm-9">
                <input name="password" id="password" type="password" class="col-xs-10 col-sm-5" placeholder="Password">
            </div>
        </div>
        <div class="space-4"></div>
        <div class="form-group">
            <label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Confirm Password </label>
            <div class="col-sm-9">
                <input name="cpassword" id="cpassword" type="password" class="col-xs-10 col-sm-5" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
          <label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Subscription Type </label>
          <div class="col-sm-9">
            <select name="subscription" id="subscription">
              <option value="null">--- select a package ---</option>
              <option value="month">Monthly</option>
              <option value="year">Yearly</option>
              <option value="lifetime">Life Time</option>
            </select>
          </div>
        </div>
      <div class="space-4"></div>
      <div class="form-group hide" id="months">
        <label for="form-field-2" class="col-sm-3 control-label no-padding-right">Total Months </label>
        <div class="col-sm-9">
          <input name="months" id="tmonths" type="text" class="col-xs-10 col-sm-5" placeholder="Number of months...">
        </div>
      </div>
      <div class="form-group hide" id="years">
        <label for="form-field-2" class="col-sm-3 control-label no-padding-right">Total Years </label>
        <div class="col-sm-9">
          <input name="years" id="tyears" type="text" class="col-xs-10 col-sm-5" placeholder="Number of years...">
        </div>
      </div>
      <input type="hidden" name="subscriptionTime" id="subscriptionTime" value="">
      <input type="hidden" name="activationTime" id="activationTime" value="">
        <hr/>
        <div style="height: 40px;">
            <button type="button" class="pull-left btn btn-primary" onclick="document.location.href='/installer?screen=2';">Back</button>
            <button type="submit" class="pull-right btn btn-primary">Install</button>
        </div>
    </form>
</div>
<script>
    function validatePassword(){
        var time = new Date();
        var selected = $("#subscription").find(":selected").val();
        if (selected === "null") {
          alert("Select a subscription package.");
          return false;
        }
        if (selected === "month"){
          var tmonths = $("#tmonths").val();
          if (!tmonths || tmonths <= 0){
            alert("Set at least one month.");
            return false;
          }
          time.setMonth(time.getMonth() + parseInt(tmonths));
        }
        if (selected === "year"){
          var tyears = $("#tyears").val();
          if (!tyears || tyears <= 0) {
            alert("Set at least one year.");
            return false;
          }
          time.setFullYear(time.getFullYear() + parseInt(tyears));
        }
        if (selected === "lifetime") time = new Date("12/31/2030");

        $("#subscriptionTime").val(time);
        $("#activationTime").val(new Date());
        var password = $("#password").val();
        if (password.length<4){
            alert("The password must be at least 4 characters");
            return false;
        }
        if ($("#cpassword").val()!==password){
            alert("The provided passwords do not match");
            return false;
        }
        return true;
    }
    $("#subscription").on("change", function (e) {
      var option = e.target.value;
      if (option === "month"){
        $("#months").removeClass("hide");
        $("#years").addClass("hide");
      }else if (option === 'year'){
        $("#years").removeClass("hide");
        $("#months").addClass("hide");
      } else {
        $("#years").addClass("hide");
        $("#months").addClass("hide");
      }

    });
</script>
