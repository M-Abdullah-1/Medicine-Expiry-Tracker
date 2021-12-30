



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
      window.location.reload();
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
      var name = $("#name");
      var shortDesc = $("#shortDesc");
      var longDesc = $("#longDesc");
      var data = JSON.parse(response);
      rowID.val(data.id);
      name.val(data.name);
      shortDesc.val(data.shortDesc);
      longDesc.val(data.longDesc);
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
  var name = $("#name");
  var shortDesc = $("#shortDesc");
  var longDesc = $("#longDesc");
  if (empty(name) && empty(shortDesc) && empty(longDesc)) {
    $.ajax({
      url: 'ajax.php',
      method: 'post',
      datatype: 'text',
      data: {
        key: 'saveEditData',
        rowID: rowID.val(),
        name: name.val(),
        shortDesc: shortDesc.val(),
        longDesc: longDesc.val()
      },
      success: function(response) {
        $("#country_"+rowID.val()).html(name.val());
        $("#tableManager").modal('hide');
        notifyExpiryData(0);
        // toastr notification
        toastr["success"]('Requested completed.');
        // sweetalert2 notification
        Swal.fire({
          position: 'center',
          type: 'success',
          title: 'Your work has been saved ',
          showConfirmButton: true,
          // timer: 1300
        });
      }
    });
  }
}



// clear the input fields
function clear() {
  var name = $("#name");
  var shortDesc = $("#shortDesc");
  var longDesc = $("#longDesc");
  name.val('');
  shortDesc.val('');
  longDesc.val('');
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
      var name = $("#name");
      var shortDesc = $("#shortDesc");
      var longDesc = $("#longDesc");
      var quantityInput = $("#quantityInput");
      var expiryDate = $("#expiryDate");
      if (empty(name) && empty(shortDesc) && empty(longDesc)) {
        $.ajax({
          url: 'ajax.php',
          method: 'post',
          datatype: 'text',
          data: {
            key: 'addNew',
            name: name.val(),
            shortDesc: shortDesc.val(),
            longDesc: longDesc.val(),
            quantityInput: quantityInput.val(),
            expiryDate: expiryDate.val()
          },
          success: function (response) {
            $("#tableManager").modal('hide');
            // toastr notification
            toastr["success"]('Requested completed.');
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

//  table of expiry products
    function getExpiryData(start,limit,counter) {
      var d = new Date();
      var yearNumber = d.getFullYear();
      var monthNumber = d.getMonth();
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
      var monthNumber = d.getMonth();
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
          // alert(response);
        }
      });
    }


    // refresh function
    function refresh() {
      window.location.reload();
    }
