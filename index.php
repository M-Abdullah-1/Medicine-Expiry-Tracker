<?php
  include './include/header.php';
 ?>
<body>

 <div class="bgPic">
  <!-- navbar section start -->
  <?php
    include './include/navbar.php';
   ?>
  <!-- navbar section end -->

  <div class="container">


    <!-- Popup section start -->
    <?php
      include './include/popup.php';
     ?>
    <!-- Popup section end -->
    <!-- table section start -->
    <div class="row py-3 height">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center my-1">
          <h1 class="text-dark">Product List</h1>
          <?php
              if (isset($_SESSION['s_userId'])) {
                echo '
                <div>
                  <button type="button" value="Add New" onclick="addNew()" class="btn bgOpacity text-light"><i class="fas fa-plus text-success"></i> Add New</button>



                  <button onclick="refresh()" class="btn bgOpacity text-light"><i class="fas fa-sync-alt"></i></button>
                  </div>
                ';
              }
           ?>
        </div>
        <table class="table table-dark bgOpacity table-bordered table-hover table-sm">
          <thead>
            <tr>
              <th>S.NO</th>
              <th>Name</th>
              <th>Exp Date</th>
              <th>Pack Size</th>
              <th>Quantity</th>
              <th>Sale Price</th>
              <?php
                if (isset($_SESSION['s_userId'])) {
                  echo '<th>Purchase Price</th>';
                  echo '<th>Total Purchase</th>';
                  echo '<th class="text-center">Options</th>';
                }
               ?>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
        <!-- Showing the total purchase price of all items  -->
        <!-- <div class="bgOpacity text-light p-1 text-center ">
          <h3 class="font-weight-light">Total <strong class="font-weight-bold">Purchase Price</strong> of all items are :&nbsp;&nbsp;<strong class="font-weight-bold" id="purchasePriceOfAllItems"></strong></h3>
        </div> -->
      </div>

    </div>
    <!-- table section end -->
    <div class="row text-light">
    </div>
  </div>
</div>
  <!-- jQuery link -->
  <script src="./js/jquery-3.4.1.min.js"></script>
  <!-- external js -->
  <script src="./js/bootstrap.bundle.min.js"></script>
  <!-- data table links -->

  <!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script> -->

  <script src="./js/jquery.dataTables.min.js"></script>
  <script src="./js/dataTables.bootstrap4.min.js"></script>
  <!-- toastr.js link -->
  <script src="./js/toastr.min.js"></script>
  <!-- sweetalert2 link  -->
  <script src="./js/sweetalert2.all.min.js"></script>

  <!-- internal js -->

  <script>
  $(document).ready(function() {
    getExistingData(0,10);

    // toastr.info('Are you the 6 fingered man?');

    // Swal.fire(
    //   'Good job!',
    //   'You clicked the button!',
    //   'success'
    // )

      notifyExpiryData(0);
      calculateTotalPurchasePrice();
  });




    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-bottom-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }


  // calculate the purchase price of all items in db
  function calculateTotalPurchasePrice(){
    $.ajax({
      url: 'ajax.php',
      method: 'post',
      datatype: 'json',
      data:{
        key: 'calculateTotalPurchasePrice'
      },
      success: function(response) {
        let data = JSON.parse(response);
        $("#purchasePriceOfAllItems").html( data.totalPurchase);
        $("#sellingPriceOfAllItems").html( data.totalSelling);
        $("#totalProfitOfAllItems").html( data.totalSelling - data.totalPurchase);
      }
    });
  }

  // function of apply account setting
  function saveAccountSetting() {
    let userName = $("#userName");
    let currentPassword = $("#currentPassword");
    let newPassword = $("#newPassword");
    let confirmNewPassword = $("#confirmNewPassword");
    if (empty(userName) && empty(currentPassword) && empty(newPassword) && empty(confirmNewPassword)) {
      $.ajax({
        url: 'ajax.php',
        method: 'post',
        datatype: 'text',
        data: {
          key: 'saveAccountSetting',
          userName : userName.val(),
          currentPassword : currentPassword.val(),
          newPassword : newPassword.val(),
          confirmNewPassword : confirmNewPassword.val()
        },
        success: function(response) {
          if (response == 'success') {
            Swal.fire(
              'Success',
              'Admin Password has changed successfully.',
              'success'
            );
            userName.val('');
            currentPassword.val('');
            newPassword.val('');
            confirmNewPassword.val('');
            $("#passwordSetting").modal('hide');
          } else if (response == 'somethingWrong') {
            Swal.fire(
              'Error',
              'Password did not change.',
              'error'
            );
          } else if (response == 'passwordNotMatch') {
            Swal.fire(
              'Error',
              'New password and confirm password not match with each other.',
              'error'
            );
            newPassword.val('');
            confirmNewPassword.val('');
            newPassword.attr("autofocus","");
          } else if (response == 'incorrectCurrentPassword') {
            Swal.fire(
              'Error',
              'You enter the wrong current password.',
              'error'
            );
            currentPassword.val('');
          } else if (response == 'incorrectName') {
            Swal.fire(
              'Error',
              'You enter the incorrect user name.',
              'error'
            );
            userName.val('');
          } else {
            Swal.fire(
              'Error',
              'Something is going wrong in backend.',
              'error'
            );
          }
        }
      });
    }
  }

  // setting function for admin
  function setting() {
    // alert("success");
    let userName = $("#userName");
    let currentPassword = $("#currentPassword");
    let newPassword = $("#newPassword");
    let confirmNewPassword = $("#confirmNewPassword");
    userName.val('').css('border','');
    currentPassword.val('').css('border','');
    newPassword.val('').css('border','');
    confirmNewPassword.val('').css('border','');
    $("#passwordSetting").modal('show');
  }
  // finance function which is on navbar
  function finance() {
    calculateTotalPurchasePrice();
    $("#finance").modal('show');
  }

  // sell
  function sellBox(rowID) {
    $("#inputPart").css('display','none');
    $("#sellingListForm").css('display','none');
    $("#viewPart").css('display','none');
    $("#loginForm").css('display','none');
    $("#sellForm").css('display','block');
    var sellRowId = $("#sellRowId");
    sellRowId.val(rowID);
    $("#manageBtn1").attr('value','Sell').attr('onclick','sell()');
    $("#manageBtn1").fadeIn();
    $("#tableManager").modal('show');
  }
  function sell() {
    var rowID = $("#sellRowId");
    var quantity = $("#quantity");
    $.ajax({
      url: 'ajax.php',
      method: 'post',
      datatype: 'text',
      data: {
        key: 'sell',
        rowID: rowID.val(),
        quantity: quantity.val()
      },
      success: function(response) {
        var quantity = $("#quantity");
        quantity.val('');
        $("#tableManager").modal('hide');
        // toastr notification
        toastr["success"]('Requested completed.');
        // sweetalert2 notification
        // Swal.fire({
        //   position: 'center',
        //   type: 'success',
        //   title: 'Successfully save changes.',
        //   showConfirmButton: false,
        //   timer: 1300,
        //   animation: false,
        //   customClass: {
        //     popup: 'animated fadeIn'
        //   }
        // });
      }
    });
  }

  // admin logout
  function logout() {
    $.ajax({
      url: 'ajax.php',
      method: 'post',
      datatype: 'text',
      data: {
        key: 'logout'
      },
      success: function(response) {
        window.location.reload();
        // alert(response);
      }
    });
  }

  // adminLogin
  function login() {
    $("#inputPart").css('display','none');
    $("#sellingListForm").css('display','none');
    $("#viewPart").css('display','none');
    $("#sellForm").css('display','none');
    $("#loginForm").css('display','block');
    var userId = $("#userId");
    var userPwd = $("#userPwd");
    userId.val('');
    userPwd.val('');
    $("#manageBtn1").attr('value','Send').attr('onclick','loginForm()');
    $("#modalTitle").html('Login');
    $("#manageBtn1").fadeIn();
    $("#tableManager").modal('show');
  }

  function loginForm() {
    var userId = $("#userId");
    var userPwd = $("#userPwd");
    // alert(userId.val());
    $.ajax({
      url: 'ajax.php',
      method: 'post',
      datatype: 'text',
      data: {
        key: 'loginForm',
        userId: userId.val(),
        userPwd: userPwd.val()
      },
      success: function(response) {
        if (response == 'incorrectName') {
          Swal.fire(
            'Error',
            'Something you entered was wrong.',
            'error'
          );
        } else if (response == 'incorrectPassword') {
          Swal.fire(
            'Error',
            'Something you entered was wrong.',
            'error'
          );
        } else if (response == 'successfullyLogined') {
          window.location.reload();
        } else {
          Swal.fire(
            'Error',
            'Something is going wrong.',
            'error'
          );
        }
      }
    });
  }


  // Delete data
  function deleteData(rowID) {
    const swalWithBootstrapButtons = Swal.mixin({
      animation: false,
      customClass: {
        confirmButton: 'btn btn-success mx-2',
        cancelButton: 'btn btn-danger',
        popup: 'animated fadeIn'
    },
    buttonsStyling: false,
  })

  swalWithBootstrapButtons.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, cancel!',
    reverseButtons: true
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: 'ajax.php',
        method: 'post',
        datatype: 'text',
        data: {
          key: 'deleteData',
          rowID: rowID
        },
        success: function(response) {
          // toastr notification
          // toastr["success"]('Requested completed.');
          // sweetalert2 notification
          notifyExpiryData(0);
          swalWithBootstrapButtons.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          );
          // end
          $("#product_name_"+rowID).parent().remove();
          // $("#product_name_"+rowID).fadeOut();
          // setTimeout(removeTableRow(rowID),2000);
        }
      });

    } else if (
      // Read more about handling dismissals
      result.dismiss === Swal.DismissReason.cancel
    ) {
      swalWithBootstrapButtons.fire(
        'Cancelled',
        'Your imaginary file is safe :)',
        'error'
      )
    }
  })
  }
  // remove the table row function
  function removeTableRow(rowID) {
    $("#product_name_"+rowID).parent().remove();
  }

  // View Data
  function viewData(rowID) {
    $.ajax({
      url: 'ajax.php',
      method: 'post',
      datatype: 'json',
      data: {
        key: 'viewData',
        rowID: rowID
      },
      success: function(response) {
        $("#inputPart").css('display','none');
        $("#sellingListForm").css('display','none');
        $("#loginForm").css('display','none');
        $("#sellForm").css('display','none');
        $("#viewPart").css('display','block');
        var data = JSON.parse(response);
        $("#view_id").html('ID : '+data.id);
        $("#view_name").html('Name : '+data.name);
        $("#view_shortDesc").html('shortDesc : '+data.shortDesc);
        $("#view_longDesc").html('longDesc : '+data.longDesc);
        $("#manageBtn1").fadeOut();
        $("#tableManager").modal('show');
      }
    });
  }



  // Edit data
  function editRow(rowID) {
    $.ajax({
      url: 'ajax.php',
      method: 'post',
      datatype: 'json',
      data: {
        key: 'editRow',
        rowID: rowID
      },
      success: function (response) {
        var rowID = $("#rowID");
        var product_name = $("#product_name");
        var exp_date = $("#exp_date");
        var pack_size = $("#pack_size");
        var quantity = $("#quantityInput");
        var price = $("#price");
        let purchase = $("#purchase");
        var data = JSON.parse(response);
        rowID.val(data.product_id);
        product_name.val(data.product_name);
        exp_date.val(data.exp_date);
        pack_size.val(data.pack_size);
        quantity.val(data.quantity);
        price.val(data.price);
        purchase.val(data.purchase);
        $("#inputPart").css('display','block');
        $("#viewPart").css('display','none');
        $("#loginForm").css('display','none');
        $("#sellForm").css('display','none');
        $("#sellingListForm").css('display','none');
        $("#manageBtn1").fadeIn();
        $("#manageBtn1").attr('value','Save').attr('onclick','saveEditData()');
        $("#tableManager").modal('show');
      }
    });
  }

  // save editing data
  function saveEditData() {
    var rowID = $("#rowID");
    var product_name = $("#product_name");
    var exp_date = $("#exp_date");
    var pack_size = $("#pack_size");
    var quantity = $("#quantityInput");
    var price = $("#price");
    let purchase = $("#purchase");
    if (empty(product_name) && empty(exp_date) && empty(pack_size) && empty(quantity) && empty(price) && empty(purchase)) {
      $.ajax({
        url: 'ajax.php',
        method: 'post',
        datatype: 'text',
        data: {
          key: 'saveEditData',
          rowID: rowID.val(),
          product_name: product_name.val(),
          exp_date: exp_date.val(),
          pack_size: pack_size.val(),
          quantity: quantity.val(),
          price: price.val(),
          purchase: purchase.val()
        },
        success: function(response) {
          $("#product_name_"+rowID.val()).html(product_name.val());
          $("#exp_date_"+rowID.val()).html(exp_date.val());
          $("#pack_size_"+rowID.val()).html(pack_size.val());
          $("#quantity_"+rowID.val()).html(quantity.val());
          $("#price_"+rowID.val()).html(price.val());
          $("#purchase_price_"+rowID.val()).html(purchase.val());
          $("#total_purchase_price_"+rowID.val()).html(response);
          $("#tableManager").modal('hide');
          notifyExpiryData(0);
          // toastr notification

          toastr["success"]('Requested completed.');
          // sweetalert2 notification
          // Swal.fire({
          //   position: 'center',
          //   type: 'success',
          //   title: 'Your work has been saved ',
          //   showConfirmButton: true,
          //   // timer: 1300
          // });
        }
      });
    }
  }




  // getting data from db
    function getExistingData(start,limit) {
      $.ajax({
        url: 'ajax.php',
        method: 'post',
        datatype: 'text',
        data: {
          key: 'getExistingData',
          start: start,
          limit: limit
        },
        success: function(response) {
          if (response != 'noMore') {
            $("tbody").append(response);
            start += limit;
            getExistingData(start,limit);
          } else {
            $(".table").DataTable();
          }
        }
      });
    }


    // add data into db function
      function addNew() {
        clear();
        $("#inputPart").css('display','block');
        $("#viewPart").css('display','none');
        $("#loginForm").css('display','none');
        $("#sellForm").css('display','none');
        $("#sellingListForm").css('display','none');
        $("#manageBtn1").fadeIn();
        $("#manageBtn1").attr('value','Add').attr('onclick','saveNewData()');
        $("#tableManager").modal('show');
      }
      function saveNewData() {
        var product_name = $("#product_name");
        var pack_size = $("#pack_size");
        var quantity = $("#quantityInput");
        var price = $("#price");
        var exp_date = $("#exp_date");
        let purchase = $("#purchase");
        if (empty(product_name) && empty(pack_size) && empty(quantity) && empty(price) && empty(exp_date) && empty(purchase)) {
          $.ajax({
            url: 'ajax.php',
            method: 'post',
            datatype: 'text',
            data: {
              key: 'addNew',
              product_name: product_name.val(),
              pack_size: pack_size.val(),
              price: price.val(),
              quantity: quantity.val(),
              exp_date: exp_date.val(),
              purchase: purchase.val()
            },
            success: function (response) {
              // $("#tableManager").modal('hide');
              // toastr notification
              if (response == 'NameTaken') {
                Swal.fire(
                  'Error',
                  'Name is already exist.<br>Try another one.',
                  'error'
                );
              } else if (response == 'success') {
                Swal.fire(
                  'Success',
                  'Details are added into record.',
                  'success'
                );
                clear();
                refresh();
              } else {
                Swal.fire(
                  'Error',
                  'Something is going wrong.',
                  'error'
                );
              }
              // toastr["success"]('Requested completed.'+response);
              notifyExpiryData(0);
              // sweetalert2 notification
              // Swal.fire({
              //   position: 'center',
              //   type: 'success',
              //   title: 'New product is Added in the list.',
              //   showConfirmButton: false,
              //   timer: 1300
              // });
            }
          });
        }
      }
      function empty(x) {
        if (x.val() == '') {
          x.css('border','1px solid red');
          return false;
        } else {
          x.css('border','');
          return true;
        }
      }


      // clear the input fields
      function clear() {
        var product_name = $("#product_name");
        var exp_date = $("#exp_date");
        var pack_size = $("#pack_size");
        var quantity = $("#quantityInput");
        var price = $("#price");
        let purchase = $("#purchase");
        product_name.val('');
        exp_date.val('');
        pack_size.val('');
        quantity.val('');
        price.val('');
        purchase.val('');
      }


  //  table of expiry products
      function getExpiryData(start,limit,counter) {
        var d = new Date();
        var yearNumber = d.getFullYear();
        var monthNumber = d.getMonth()+1;
        var dateNumber = d.getDate();
        var yearString = yearNumber.toString();
        var monthString = monthNumber.toString();
        var dateString = dateNumber.toString();
        var currentDate = yearString+"-"+monthString+"-"+dateString;
        $.ajax({
          url: 'ajax.php',
          method: 'post',
          datatype: 'text',
          data: {
            key: 'expiryDate',
            start: start,
            limit: limit,
            counter: counter,
            currentDate: currentDate
          },
          success: function(response,counter) {
            if (response != 'noMore') {
              var data = JSON.parse(response);
              $("tbody").append(data.tableRows);
              start += limit;
              counter = data.counter;
              getExpiryData(start,limit,counter);
            } else {
              $(".table").DataTable();
            }
          }
        });
      }



      function notifyExpiryData(counter) {
        var d = new Date();
        var yearNumber = d.getFullYear();
        var monthNumber = d.getMonth()+1;
        var dateNumber = d.getDate();
        var yearString = yearNumber.toString();
        var monthString = monthNumber.toString();
        var dateString = dateNumber.toString();
        var currentDate = yearString+"-"+monthString+"-"+dateString;
        $.ajax({
          url: 'ajax.php',
          method: 'post',
          datatype: 'text',
          data: {
            key: 'notifyExpiryDate',
            counter: counter,
            currentDate: currentDate
          },
          success: function(response) {
            var number = Math.floor(response);
            if (number > 0) {
              $("#navbarExpiryBtn").removeClass('btn-outline-light').addClass('btn-danger');
              $("sup").html(number);

              // toastr notification
              // toastr["warning"]('Products which will expire soon are : '+response);
              // sweetalert2 notification
              // Swal.fire({
              //   position: 'center',
              //   type: 'warning',
              //   title: 'Total no of products which will expire soon are : '+response,
              //   showConfirmButton: true,
              //   // timer: 1300
              // });
            }
          }
        });
      }


      // refresh function
      function refresh() {
        window.location.reload();
      }



  </script>
  <!-- <script src="./js/internal.js"></script> -->
</body>
</html>
