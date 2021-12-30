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

  <div class="container-fluid ">


    <!-- Popup section start -->
    <?php
      include './include/popup.php';
     ?>
    <!-- Popup section end -->
    <!-- table section start -->
    <div class="row py-3">
      <div class="col-sm-12 text-center">
          <h1 class="text-dark">Selling Items</h1>
            <!-- <button onclick="refresh()" class="btn btn-success"><i class="fas fa-sync-alt"></i></button> -->
      </div>
    </div>
    <div class="row py-3 height">
      <div class="col-sm-6">
        <div class="d-flex justify-content-between align-items-center my-1">
          <h5 class="text-dark">Search Items</h5>
          <form id="search-item">
            <input class="form-control " type="text" placeholder="Search Items...">
          </form>
          <!-- <div>
            <button onclick="refresh()" class="btn btn-success"><i class="fas fa-sync-alt"></i></button>
          </div> -->
        </div>
        <!-- <table id="data-table" class="table table-dark bgOpacity table-bordered table-hover table-sm "> -->
          <!-- <thead>
            <tr>
              <th>Name</th>
              <th>Quantity</th>
              <th>Options</th>
            </tr>
          </thead> -->
          <!-- <tbody id="sellingBody">

          </tbody>
        </table> -->
        <ul id="sellingBody" class="list-group">

        </ul>
      </div>
      <div class="col-sm-6">
        <!-- <div class="row">
          <div class="col-12">
            <div class="d-flex justify-content-between align-items-center bgOpacity">
              <h5 class="text-light mx-2">Selling List</h5>
              <div class="d-flex">
                <button onclick="soldData()" class="btn btn-success m-2">Ok</button>
                <button onclick="empty_tmp()" class="btn btn-danger m-2">Cancel</button>
              </div>
            </div>
          </div>
        </div> -->
        <div class="row">
          <div class="col-12">
            <div class="d-flex justify-content-between align-items-center bgOpacity">
              <!-- <h5 id="sellingListTotalAmount" class="text-light mx-2"></h5> -->
              <h5 class="text-light mx-2">Selling List</h5>
              <div class="d-flex">
                <input type="text" id="buyerName" class="form-control m-2" placeholder="Name...">
                <!-- <input type="date" id="soldDate" class="form-control m-2"> -->
              </div>
            </div>
          </div>
        </div>
        <table class="table mb-0 table-dark bgOpacity table-bordered table-hover table-sm">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Particulars</th>
              <th>Qty</th>
              <th>Amount</th>
              <th class="text-center">Options</th>
            </tr>
          </thead>
          <tbody id="soldBody">

          </tbody>
        </table>
        <div class="d-flex  justify-content-between align-items-center bgOpacity">
          <h5 id="sellingListTotalAmount" class="text-light mx-2"></h5>
          <div class="d-flex mr-5">
            <button onclick="soldData()" class="btn btn-success m-2 mr-3">Ok</button>
            <button onclick="empty_tmp()" class="btn btn-danger m-2">Cancel</button>
          </div>
        </div>
      </div>
    </div>
    <!-- table section end -->
  </div>
</div>
  <!-- jQuery link -->
  <script src="./js/jquery-3.4.1.min.js"></script>
  <!-- external js -->
  <script src="./js/bootstrap.bundle.min.js"></script>
  <!-- data table links -->
  <!-- <script src="./js/jquery.dataTables.min.js"></script>
  <script src="./js/dataTables.bootstrap4.min.js"></script> -->
  <!-- toastr.js link -->
  <script src="./js/toastr.min.js"></script>
  <!-- sweetalert2 link  -->
  <script src="./js/sweetalert2.all.min.js"></script>

  <!-- internal js -->

  <script>
  $(document).ready(function() {
    // getExistingData(0,10);
    getSellingData(0,10);
    filterItems();
    checking_temporary_data_table();
    // toastr.info('Are you the 6 fingered man?');

    // Swal.fire(
    //   'Good job!',
    //   'You clicked the button!',
    //   'success'
    // )
    sellingListTotalAmount();
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

  // selling list counter
  var addSellRowCounter = 0;


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
  function finance() {
    calculateTotalPurchasePrice();
    $("#finance").modal('show');
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


  // sold data
  function soldData() {
    let buyerName = $('#buyerName');
    // let soldDate = $('#soldDate');
    let d = new Date();
    let yearNumber = d.getFullYear();
    let monthNumber = d.getMonth()+1;
    let dateNumber = d.getDate();
    let yearString = yearNumber.toString();
    let monthString = monthNumber.toString();
    let dateString = dateNumber.toString();
    if (monthNumber < 10 ) {
      monthString = "0"+""+monthString;
    }
    if (dateNumber < 10) {
      dateString = "0"+""+dateString;
    }
    let currentDate = yearString+"-"+monthString+"-"+dateString;
    if (empty(buyerName)) {
      $.ajax({
        url: 'ajax.php',
        method: 'post',
        datatype: 'text',
        data:{
          key: 'soldData',
          buyerName: buyerName.val(),
          soldDate: currentDate
        },
        success: function(response) {
          // alert(response);
          // Swal.fire(
          //   'Message',
          //   response,
          //   'info'
          // );
          Swal.fire({
            position: 'center',
            type: 'success',
            title: response,
            showConfirmButton: true,
            // timer: 1300
          });
          $('#soldBody').empty();
          $('#soldBody').append("<tr id='sellingListMsg' ><td  colspan='5' class='text-center'>List is empty.</td></tr>");
          buyerName.val('');
        }
      });
    } else {
      Swal.fire(
        'Something Missing',
        'Enter name of buyer.',
        'info'
      );
    }
  }

  // empty temporary table
  function empty_tmp() {
    $.ajax({
      url: 'ajax.php',
      method: 'post',
      datatype: 'text',
      data: {
        key: 'empty_tmp'
      },
      success: function(response) {
        // alert(response);
        refresh();
      }
    });
  }


  // selling list total amount checker
  function sellingListTotalAmount() {
    $.ajax({
      url: 'ajax.php',
      method: 'post',
      datatype: 'text',
      data: {
        key: 'sellingListTotalAmount'
      },
      success: function(response) {
        let totalAmount = $('#sellingListTotalAmount');
        totalAmount.text('Total Amount : '+response);
        // sellingListTotalAmount();
      }
    });
  }

  // edit selling list row
  function editSellingListRow(rowID) {
    $.ajax({
      url: 'ajax.php',
      method: 'post',
      datatype: 'json',
      data: {
        key: 'editSellingListRow',
        rowID: rowID
      },
      success: function(response) {
        let editSellingListID = $('#editSellingListID');
        let quantity = $('#editSellingListQuantiy');
        let amount = $('#editSellingListAmount');
        let data = JSON.parse(response);
        quantity.val(data.tmp_quantity);
        // amount.val(data.tmp_amount);
        editSellingListID.val(data.tmp_id);
        $("#inputPart").css('display','none');
        $("#viewPart").css('display','none');
        $("#loginForm").css('display','none');
        $("#sellForm").css('display','none');
        $("#manageBtn1").attr('value','Save').attr('onclick','saveEditSellingListData()');

        $("#tableManager").modal('show');
      }
    });
  }

  // save edit selling list data
  function saveEditSellingListData() {
    let tmp_id = $('#editSellingListID');
    let tmp_quantity = $('#editSellingListQuantiy');
    let tmp_amount = $('#editSellingListAmount');
    if (empty(tmp_quantity)) {
      $.ajax({
        url: 'ajax.php',
        method: 'post',
        datatype: 'text',
        data: {
          key: 'saveEditSellingListData',
          tmp_quantity: tmp_quantity.val(),
          tmp_amount: tmp_amount.val(),
          tmp_id: tmp_id.val()
        },
        success: function(response) {
          let changedAmount = response;
          $('#quantity_'+tmp_id.val()).html(tmp_quantity.val());
          $('#selling_list_amount_'+tmp_id.val()).html(changedAmount);
          console.log(tmp_amount.val());
          let quantity = $('#editSellingListQuantiy');
          let amount = $('#editSellingListAmount');
          quantity.val('');
          amount.val('');
          //alert(response);
          sellingListTotalAmount();
          $('#tableManager').modal('hide');
        }
      });
    }
  }

  // remove Sell row from reception table
  function removeSellRow(rowID){
    const bodyOfRemoveRow = document.querySelector('#soldBody');
    const itemsOfRemoveRow = bodyOfRemoveRow.getElementsByTagName('tr');
    var tmp = $('#'+rowID);


    tmp.remove();
    var tr_last = $('#soldBody tr:last-child');
    var td_first = $('#soldBody tr:last-child .serialNo');
    var no = td_first.text();
    no = Math.floor(no); //convert a string into an integer
    // var listOfSerialNo = document.getElementsByClassName('serialNo');
    var listOfSerialNo = $('.serialNo');
    // var listOfSerialNo = $('.serialNo');


    var serialNoCounter = 0;
    // Array.from(listOfSerialNo).forEach(function(singleSerialNo) {
      // singleSerialNo.innerHTML();
      // ++serialNoCounter;
      // singleSerialNo = '<td class="serialNo">'+serialNoCounter+'</td>';
    //   console.log(singleSerialNo);
    // });
    for (let i = 0; i < listOfSerialNo.length; i++) {
      console.log(listOfSerialNo[i].innerText = ++serialNoCounter);
    }
    addSellRowCounter = serialNoCounter;
    $.ajax({
      url: 'ajax.php',
      method: 'post',
      datatype: 'text',
      data: {
        key: 'removeSellRow',
        rowID: rowID
      },
      success: function(response) {
        console.log(response);
        sellingListTotalAmount();
      }
    });
  }

// checking temporary data table
  function checking_temporary_data_table() {
    $.ajax({
      url: 'ajax.php',
      method: 'post',
      datatype: 'json',
      data: {
        key: 'checking_temporary_data_table'
      },
      success: function(response) {
        let sellingListData = JSON.parse(response);
        $("#soldBody").append(sellingListData.tableData);
        if (sellingListData.sellingListCounter) {
          addSellRowCounter = sellingListData.sellingListCounter;
        }
      }
    });
  }


  // filter items
  function filterItems() {
    const list = document.querySelector('#sellingBody');
    const searchBar = document.forms['search-item'].querySelector('input');
    searchBar.addEventListener('keyup',function(e){
      var term = e.target.value.toLowerCase();
      const items = list.getElementsByTagName('li');
      console.log(term.length);
      // console.log(empty(term));
      if (term.length != 0 && term != ' ') {
        list.style.display = 'block';
        Array.from(items).forEach(function(item){
          const title = item.firstElementChild.textContent;
          if (title.toLowerCase().indexOf(term) != -1) {
            item.style.display = 'block';
            item.classList.add('d-flex');
          } else {
            item.classList.remove('d-flex');
            item.style.display  = 'none';
          }
        });
      } else {
        list.style.display = 'none';
      }
    });
  }




  // add Sell row
function addSellRow(rowID) {
  let soldQuantity = $('#sellingQuantity_'+rowID);
  if (empty(soldQuantity)) {
    $.ajax({
      url: 'ajax.php',
      method: 'post',
      datatype: 'json',
      data:{
        key: 'addSellRow',
        rowID: rowID,
        counter: addSellRowCounter,
        soldQuantity:soldQuantity.val()
      },
      success: function(response){
        // alert(response);
        if (response == 'alreadyExist') {
          alert(response);
        }
        else if (response == 'incorrectQuantityEntered') {
          alert(response);
        }
        else {
          var data = JSON.parse(response);
          if (data.responseKey == 'totalQuantity') {
            Swal.fire(
              data.message,
              'Enter the correct quantity.',
              'info'
            );
            // Swal.fire({
            //   position: 'center',
            //   type: 'success',
            //   title: 'Your work has been saved ',
            //   showConfirmButton: true,
            //   // timer: 1300
            // });
            // alert(data.message);
          } else {
            $("#soldBody").append(data.tableRow);
            addSellRowCounter = data.rowCounter;
            addRowInTmp(rowID);
            soldQuantity.val('');
            $('#sellingListMsg').remove();
            sellingListTotalAmount();
          }
        }
        let listOfSearchQuantity = $('.search_quantity_style');
        console.log(listOfSearchQuantity);
        for (let i = 0; i < listOfSearchQuantity.length; i++) {
          listOfSearchQuantity[i].style.border = '';
        }
      }
    });
  }
}

// add row into temparary table in db
function addRowInTmp(rowID) {
  let soldQuantity = $('#sellingQuantity_'+rowID).val();
  $.ajax({
    url: 'ajax.php',
    method: 'post',
    datatype: 'text',
    data: {
      key: 'addRowInTmp',
      rowID: rowID,
      soldQuantity: soldQuantity
    },
    success: function(response) {
      console.log(response);
    }
  });
}

// get selling data
function getSellingData(start,limit) {
  $.ajax({
    url: 'ajax.php',
    method: 'post',
    datatype: 'text',
    data: {
      key: 'getSellingData',
      start: start,
      limit: limit
    },
    success: function(response) {
      if (response != 'noMore') {
        $("#sellingBody").append(response);
        start += limit;
        getSellingData(start,limit);
      } else {
        // $("#data-table").DataTable();
      }
    }
  });
}




  // add Sell row
  // function addSellRow(rowID) {
  //   $.ajax({
  //     url: 'ajax.php',
  //     method: 'post',
  //     datatype: 'text',
  //     data:{
  //       key: 'addSellRow',
  //       rowID: rowID
  //     },
  //     success: function(response){
  //       // alert(response);
  //       $("#soldBody").append(response);
  //       // $(".table").DataTable();
  //     }
  //   });
  // }
  //
  // // get selling data
  // function getSellingData(start,limit) {
  //   $.ajax({
  //     url: 'ajax.php',
  //     method: 'post',
  //     datatype: 'text',
  //     data: {
  //       key: 'getSellingData',
  //       start: start,
  //       limit: limit
  //     },
  //     success: function(response) {
  //       if (response != 'noMore') {
  //         $("#sellingBody").append(response);
  //         start += limit;
  //         getExistingData(start,limit);
  //       } else {
  //         $(".table").DataTable();
  //       }
  //     }
  //   });
  // }
  //

// sell
function sellBox(rowID) {
  $("#inputPart").css('display','none');
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
  $("#viewPart").css('display','none');
  $("#sellForm").css('display','none');
  $("#loginForm").css('display','block');
  $("#sellingListForm").css('display','none');
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
        )
        // end
        $("#country_"+rowID).parent().remove();
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
      var data = JSON.parse(response);
      rowID.val(data.product_id);
      product_name.val(data.product_name);
      exp_date.val(data.exp_date);
      pack_size.val(data.pack_size);
      quantity.val(data.quantity);
      price.val(data.price);
      $("#inputPart").css('display','block');
      $("#viewPart").css('display','none');
      $("#loginForm").css('display','none');
      $("#sellForm").css('display','none');
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
  if (empty(product_name) && empty(exp_date) && empty(pack_size) && empty(quantity) && empty(price)) {
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
        price: price.val()
      },
      success: function(response) {
        $("#product_name_"+rowID.val()).html(product_name.val());
        $("#exp_date_"+rowID.val()).html(exp_date.val());
        $("#pack_size_"+rowID.val()).html(pack_size.val());
        $("#quantity_"+rowID.val()).html(quantity.val());
        $("#price_"+rowID.val()).html(price.val());
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
      if (empty(product_name) && empty(pack_size) && empty(quantity) && empty(price) && empty(exp_date)) {
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
            exp_date: exp_date.val()
          },
          success: function (response) {
            // $("#tableManager").modal('hide');
            // toastr notification
            clear();
            toastr["success"]('Requested completed.'+response);
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
      product_name.val('');
      exp_date.val('');
      pack_size.val('');
      quantity.val('');
      price.val('');
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
      if (monthString < 10) {
        monthString = "0"+monthString;
      }
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
