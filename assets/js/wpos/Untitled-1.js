this.userAbortSale = function () {
        /*var answer = confirm("Are you sure you want to abort this order?");
        if (answer) {
            clearSalesForm();
        }*/
// Implemented new modal for aborting orders
        swal({
            title: 'Are you sure you want to abort this order??',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, abort it!'
          }).then(function (result) {
            if (result.value) {
                clearSalesForm();
              swal('Aborted!', 'Your order has been aborted.', 'success');
            }
          });
    };

    this.resetSalesForm = function(){
        clearSalesForm();
    };
