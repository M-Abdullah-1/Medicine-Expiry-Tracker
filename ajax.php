<?php

  session_start();

  if (isset($_POST['key'])) {

    $conn = mysqli_connect("localhost","root","","mysqldatamanager");



  // calculate the purchase price of all items in db
  if ($_POST['key'] == 'calculateTotalPurchasePrice') {
    $sql = "SELECT * FROM productlist";
    if ($result = mysqli_query($conn,$sql)) {
      $totalPurchase = 0;
      $totalSelling = 0;
      while($data = mysqli_fetch_assoc($result)) {
        $totalPurchase += (float)$data['quantity'] * (float)$data['purchase_price'];
        $totalSelling += $data['quantity'] * $data['price'];
      }
      $arrayJson = array(
        'totalPurchase' => $totalPurchase,
        'totalSelling' => $totalSelling
      );
      exit(json_encode($arrayJson));
    } else {
      exit("connection not established.");
    }
  }



  // get selling record from db according to date
  if ($_POST['key'] == 'showByDate') {
    $searchingDate = $_POST['searchingDate'];
    // $array = explode("-",$searchingDate);
    // $test = $array[1];
    // $test = $test + 1;
    // $x = (int)$test + 1;
    // exit($x);
    // exit(gettype($searchingDate));
    $sql0 = "SELECT * FROM buyer WHERE buying_date = '$searchingDate'";
    $result0 = mysqli_query($conn,$sql0);
    if (mysqli_num_rows($result0) > 0) {
      // code...
      $response = '';
      while ($data0 = mysqli_fetch_assoc($result0)) {
        $buyer_name = $data0['buyer_name'];
        $buying_date = $data0['buying_date'];
        // now getting data from sellingrecord table
        $sql = "SELECT * FROM sellingrecord WHERE buyer_name = '$buyer_name' AND buying_date = '$searchingDate'";
        $result = mysqli_query($conn,$sql);
        $counter = 0;
        $response .= '
        <div class="m-2 bgOpacity singleTable">
        <div class="d-flex justify-content-between align-items-center ">
        <h6 class="text-light m-2">Name : <span id="buyerNameTable">'.$buyer_name.'</span></h3>
        <h6 class="text-light m-2">Date : <span id="buyingDate">'.$buying_date.'</span></h4>

        </div>
        <table class="table mb-0 table-dark bg_transparent  table-bordered table-hover table-sm">
        ';
        $response .= '
        <thead>
        <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>Qty</th>
        <th>Rate</th>
        <th>Amount</th>
        </tr>
        </thead>
        ';
        $response .= '
        <tbody>
        ';
        $totalAmount = 0;
        while ($data = mysqli_fetch_assoc($result)) {
          $response .='
          <tr>
          <td>'.++$counter.'</td>
          <td>'.$data['p_name'].'</td>
          <td>'.$data['quantity'].'</td>
          <td>'.$data['rate'].'</td>
          <td>'.$data['amount'].'</td>
          </tr>
          ';
          $totalAmount += $data['amount'];
        }
        $response .='
        </tbody>
        </table>
        <div class="d-flex flex-row-reverse align-items-center">
        ';
        // if (isset($_SESSION['s_userId'])) {
        //   $response .='
        //   <button type="button" class="m-2 btn btn-danger" onclick="refresh()">Remove</button>
        //   ';
        // }
        $response .='
          <h6 class="text-light mx-5 m-2">Total Amount : '.$totalAmount.'</h6>
        </div>
      </div>
        ';
      }
      exit($response);
    } else {
      exit("noMore");
    }

  }


  // get selling record from db
  if ($_POST['key'] == 'getListOfSellingRecord') {
    $start = $_POST['start'];
    $limit = $_POST['limit'];
    $sql0 = "SELECT * FROM buyer LIMIT $start , $limit";
    $result0 = mysqli_query($conn,$sql0);
    if (mysqli_num_rows($result0) > 0) {
      // code...
      while ($data0 = mysqli_fetch_assoc($result0)) {
        $buyer_name = $data0['buyer_name'];
        $buying_date = $data0['buying_date'];
        // now getting data from sellingrecord table
        $sql = "SELECT * FROM sellingrecord WHERE buyer_name = '$buyer_name' AND buying_date = '$buying_date'";
        $result = mysqli_query($conn,$sql);
        $counter = 0;
        $response = '';
        $response .= '
        <div class="m-2 bgOpacity singleTable">
        <div class="d-flex justify-content-between align-items-center ">
        <h6 class="text-light m-2">Name : <span id="buyerNameTable">'.$buyer_name.'</span></h3>
        <h6 class="text-light m-2">Date : <span id="buyingDate">'.$buying_date.'</span></h4>

        </div>
        <table class="table mb-0 table-dark bg_transparent  table-bordered table-hover table-sm">
        ';
        $response .= '
        <thead>
        <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>Qty</th>
        <th>Rate</th>
        <th>Amount</th>
        </tr>
        </thead>
        ';
        $response .= '
        <tbody>
        ';
        $totalAmount = 0;
        while ($data = mysqli_fetch_assoc($result)) {
          $response .='
          <tr>
          <td>'.++$counter.'</td>
          <td>'.$data['p_name'].'</td>
          <td>'.$data['quantity'].'</td>
          <td>'.$data['rate'].'</td>
          <td>'.$data['amount'].'</td>
          </tr>
          ';
          $totalAmount += $data['amount'];
        }
        $response .='
        </tbody>
        </table>
        <div class="d-flex flex-row-reverse align-items-center">
        ';
        // if (isset($_SESSION['s_userId'])) {
        //   $response .='
        //   <button type="button" class="m-2 btn btn-danger" onclick="refresh()">Remove</button>
        //   ';
        // }
        $response .='
          <h6 class="text-light mx-5 m-2">Total Amount : '.$totalAmount.'</h6>
        </div>
      </div>
        ';
      }
      exit($response);
    } else {
      exit("noMore");
    }
  }

  // sold data
  if ($_POST['key'] == 'soldData') {
    $buyerName = $_POST['buyerName'];
    $soldDate = $_POST['soldDate'];
    $sql = "SELECT * FROM buyer WHERE buyer_name = '$buyerName' AND buying_date = '$soldDate'";
    $result = mysqli_query($conn,$sql);
    if (!(mysqli_fetch_assoc($result) > 0)) {
      $sql = "INSERT INTO buyer(buyer_name,buying_date) VALUES('$buyerName','$soldDate')";
      mysqli_query($conn,$sql);
    }
    $sql = "SELECT * FROM  tmp ";
    $result = mysqli_query($conn,$sql);
    while($data = mysqli_fetch_assoc($result)) {
      $sold_product_id = $data['tmp_id'];
      $sold_product_name = $data['tmp_name'];
      $sold_quantity = $data['tmp_quantity'];
      $sold_rate = $data['tmp_rate'];
      $sold_amount = $data['tmp_amount'];

      $sql = "INSERT INTO sellingrecord(buyer_name,buying_date,p_name,quantity,amount,rate) VALUES('$buyerName','$soldDate','$sold_product_name','$sold_quantity','$sold_amount','$sold_rate') ";
      mysqli_query($conn,$sql);

      $sql = "SELECT * FROM productlist WHERE product_id = '$sold_product_id'";
      $result1 = mysqli_query($conn,$sql);
      $data1 = mysqli_fetch_assoc($result1);
      $actualQuantity = $data1['quantity'];
      $afterSoldQuantity = $actualQuantity - $sold_quantity;
      $sql = "UPDATE productlist SET quantity = '$afterSoldQuantity' WHERE product_id = '$sold_product_id'";
      mysqli_query($conn,$sql);

    }
    $sql = "DELETE FROM tmp";
    mysqli_query($conn,$sql);
    exit("Successfully added into selling record.");
  }

  // empty temporary table
  if ($_POST['key'] == 'empty_tmp') {
    $sql = "DELETE FROM tmp";
    if (mysqli_query($conn,$sql)) {
      exit("successfully empty the temporary table");
    } else {
      exit("somethingWrong in empty_tmp");
    }
  }

  // edit selling list row
  if ($_POST['key'] == 'editSellingListRow') {
    $rowID = $_POST['rowID'];
    $sql = "SELECT * FROM tmp WHERE tmp_id = '$rowID'";
    $result = mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($result);
    $array = array(
      'tmp_id' => $data['tmp_id'],
      'tmp_quantity' => $data['tmp_quantity'],
      'tmp_amount' => $data['tmp_amount']
    );
    exit(json_encode($array));
  }

  // save
  if ($_POST['key'] == 'saveEditSellingListData') {
    $tmp_quantity = $_POST['tmp_quantity'];
    $tmp_amount = $_POST['tmp_amount'];
    $tmp_id = $_POST['tmp_id'];
    $sql0 = "SELECT * FROM tmp WHERE tmp_id = '$tmp_id'";
    $result = mysqli_query($conn,$sql0);
    $data = mysqli_fetch_assoc($result);
    if (empty($tmp_amount)) {
      $tmp_rate = $data['tmp_rate'];
      $amount = $tmp_rate * $tmp_quantity;
    } else {
      $amount = $tmp_amount;
    }
    $sql1 = "UPDATE tmp SET tmp_quantity = '$tmp_quantity' , tmp_amount = '$amount' WHERE tmp_id = '$tmp_id'";
    if (mysqli_query($conn,$sql1)) {
      $response ="".$amount;
      exit($response);
    } else {
      exit('somethingWrong in saveEditSellingListData');
    }
  }

  // selling list total amount checker
  if ($_POST['key'] == 'sellingListTotalAmount') {
    $sql = "SELECT sum(tmp_amount) AS total FROM tmp";
    $result = mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($result);
    exit($data['total']);
  }

  // remove row from tempary table
  if ($_POST['key'] == 'removeSellRow') {
    $rowID = $_POST['rowID'];
    $sql = "DELETE FROM tmp WHERE tmp_id = '$rowID'";
    if (mysqli_query($conn,$sql)) {
      exit("successfully removed the row from selling list .");
    } else {
      exit("somethingWrong in removeSellRow");
    }
  }

  // add row into tempary table
  if ($_POST['key'] == 'addRowInTmp') {
    $rowID = $_POST['rowID'];
    $soldQuantity = $_POST['soldQuantity'];
    $sql = "SELECT * FROM productlist WHERE product_id = '$rowID'";
    $result = mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($result);
    // inserting into temporary table
    $tmp_price = (int)$data['price'];
    $reciptAmount = (int)$soldQuantity * (int)$data['price'];
    $tmp_name = $data['product_name'];
    $sql = "INSERT INTO tmp(tmp_id,tmp_name,tmp_quantity,tmp_rate,tmp_amount) VALUES('$rowID','$tmp_name','$soldQuantity','$tmp_price','$reciptAmount')";
    mysqli_query($conn,$sql);
    exit('successfully add the row in temporary table.');
  }

  // checking temporary data table in db
  if ($_POST['key'] == 'checking_temporary_data_table') {
    $sql = "SELECT * FROM tmp ";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result) > 0) {
      $response = "";
      $counter = 0;
      while ($data = mysqli_fetch_assoc($result)) {
        $response .='<tr id="'.$data['tmp_id'].'">';
        $response .='<td class="serialNo">'.++$counter.'</td>';
        $response .='<td id="product_name_'.$data['tmp_id'].'">'.$data['tmp_name'].'</td>';
        $response .='<td id="quantity_'.$data['tmp_id'].'">'.$data['tmp_quantity'].'</td>';
        $response .='<td id="selling_list_amount_'.$data['tmp_id'].'">'.$data['tmp_amount'].'</td>';
        $response .='<td class="d-flex justify-content-center">';
        $response .='<button type="button" class="mx-2 btn btn-success editBtnOfTable" onclick="editSellingListRow('.$data['tmp_id'].')">Edit</button>';
        $response .='<button type="button" class="mx-2 btn btn-danger editBtnOfTable delete" onclick="removeSellRow('.$data['tmp_id'].')"> Remove</button>';
        $response .='</td>';
        $response .='</tr>';
      }
      $jsonArray = array(
        'tableData' => $response,
        'sellingListCounter' => $counter
      );
      exit(json_encode($jsonArray));
    } else {
      $response = "<tr id='sellingListMsg' ><td  colspan='5' class='text-center'>List is empty.</td></tr>";
      $jsonArray = array(
        'tableData' => $response
      );
      exit(json_encode($jsonArray));
    }
  }

  // geting row from db to add in sell item list
  if ($_POST['key'] == 'addSellRow') {
    $rowID = $_POST['rowID'];
    $counter = $_POST['counter'];
    $soldQuantity = $_POST['soldQuantity'];

    $sql = "SELECT * FROM tmp WHERE tmp_id = '$rowID'";
    $temporary_result = mysqli_query($conn,$sql);
    // getting data from productlist which is in db
    $sql1 = "SELECT * FROM productlist WHERE product_id = '$rowID'";
    $result = mysqli_query($conn,$sql1);
    $data = mysqli_fetch_assoc($result);
    // check quantity is valid or not
    $quantityValid = (int)$data['quantity'] - (int)$soldQuantity;

    if (mysqli_num_rows($temporary_result) > 0) {
      exit("alreadyExist");
    } elseif ($quantityValid < 0) {
      $response = "Total Quantity is : ".$data['quantity'];
      $responseKey = "totalQuantity";
      $jsonArray = array(
        'responseKey' => $responseKey,
        'message' => $response
      );
      exit(json_encode($jsonArray));
    } else {

      // making table row
      $response = "";
      $response .='<tr id="'.$data['product_id'].'">';
      $response .='<td class="serialNo">'.++$counter.'</td>';
      $response .='<td id="product_name_'.$data['product_id'].'">'.$data['product_name'].'</td>';
      $response .='<td id="quantity_'.$data['product_id'].'">'.$soldQuantity.'</td>';
      $response .='<td id="selling_list_amount_'.$data['product_id'].'">'.$soldQuantity*(int)$data['price'].'</td>';
      $response .='<td class="d-flex justify-content-center">';
      $response .='<button type="button" class="mx-2 btn btn-success editBtnOfTable" onclick="editSellingListRow('.$data['product_id'].')">Edit</button>';
      $response .='<button type="button" class="mx-2 btn btn-danger editBtnOfTable delete" onclick="removeSellRow('.$data['product_id'].')">Remove</button>';
      $response .='</td>';
      $response .='</tr>';
      $responseKey = "returnTableRow";
      $jsonArray = array(
        'responseKey' => $responseKey,
        'tableRow' => $response,
        'rowCounter' => $counter,
      );
      exit(json_encode($jsonArray));
    }

  }


  // get selling data from db to display
  if ($_POST['key'] == 'getSellingData') {
    $start = $_POST['start'];
    $limit = $_POST['limit'];
    $counter = $start;
    $sql = "SELECT * FROM productlist LIMIT $start , $limit";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result) > 0) {
      $response = "";
      while($data = mysqli_fetch_assoc($result)) {
        // $response .='<tr>';
        // $response .='<td id="product_name_'.$data['product_id'].'">'.$data['product_name'].'</td>';
        // $response .='<td id="quantity_'.$data['product_id'].'">'.$data['quantity'].'</td>';
        // $response .='<td class="d-flex justify-content-center">';
        // $response .='<input class="" type="text" id="sellingQuantity_'.$data['product_id'].'" placeholder=" Quantity...">';
        // $response .='<button type="button" class="mx-2 btn btn-success editBtnOfTable" onclick="addSellRow('.$data['product_id'].')"><i class="fas fa-plus"></i> Add</button>';
        // $response .='</td>';
        // $response .='</tr>';
        $response .='<li class="justify-content-between list-group-item  list-group-item-action  list_color text-light " style="display:none;">';
        $response .='<span> '.$data['product_name'].'</span>';
        // $response .='<span>Quantity : '.$data['quantity'].'</span>';
        $response .='<span class="d-flex">';
        $response .='<input class="form-control search_quantity_style" type="text" id="sellingQuantity_'.$data['product_id'].'" placeholder=" Quantity...">';
        $response .='<button type="button" class="mx-2 btn btn-success editBtnOfTable" onclick="addSellRow('.$data['product_id'].')"> Add</button>';
        $response .='</span>';
        $response .='</li>';
      }
      exit($response);
    } else {
      exit("noMore");
    }
  }



  // notify expiry date
  if ($_POST['key'] == 'notifyExpiryDate') {
    $counter = $_POST['counter'];
    $currentDateString = $_POST['currentDate'];
    $sql = "SELECT * FROM productlist ";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result) > 0) {
      while($data = mysqli_fetch_assoc($result)) {

        $currentDate = $currentDateString;
        $expiryDate = $data['exp_date'];
        $diff = date_diff(date_create($currentDate), date_create($expiryDate));
        // echo 'Age is '.$diff->format('%d-%m-%y');
        $yearNumber = $diff->format('%y');
        $monthNumber = $diff->format('%m');
        $dayNumber = $diff->format('%d');


        if ( ( $yearNumber == 0 && $monthNumber == 6 && $dayNumber == 0) || ($yearNumber == 0 && $monthNumber < 6)) {
          ++$counter;
        }
      }

      $response = (string)$counter;
      exit($response);
    } else {
      $response = (string)$counter;
      exit($response);
    }


  }



  // expiry
  if ($_POST['key'] == 'expiryDate') {
    $start = $_POST['start'];
    $limit = $_POST['limit'];
    $counter = $_POST['counter'];
    $currentDateString = $_POST['currentDate'];
    $sql = "SELECT * FROM productlist LIMIT $start , $limit";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result) > 0) {
      $response = "";
      while($data = mysqli_fetch_assoc($result)) {

        $currentDate = $currentDateString;
        $expiryDate = $data['exp_date'];
        $diff = date_diff(date_create($currentDate), date_create($expiryDate));
        // echo 'Age is '.$diff->format('%d-%m-%y');
        $yearNumber = $diff->format('%y');
        $monthNumber = $diff->format('%m');
        $dayNumber = $diff->format('%d');


        if ( ( $yearNumber == 0 && $monthNumber == 6 && $dayNumber == 0) || ($yearNumber == 0 && $monthNumber < 6)) {
          $response .='<tr>';
          $response .='<td id="">'.++$counter.'</td>';
          $response .='<td id="product_name_'.$data['product_id'].'">'.$data['product_name'].'</td>';
          $response .='<td id="exp_date_'.$data['product_id'].'">'.$data['exp_date'].'</td>';
          $response .='<td>'.$diff->format('%m').' month and '.$diff->format('%d').' days</td>';
          $response .='<td id="pack_size_'.$data['product_id'].'">'.$data['pack_size'].'</td>';
          $response .='<td id="quantity_'.$data['product_id'].'">'.$data['quantity'].'</td>';
          $response .='<td id="price_'.$data['product_id'].'">'.$data['price'].'</td>';
          if (isset($_SESSION['s_userId'])) {
            $response .='<td id="purchase_price_'.$data['product_id'].'">'.$data['purchase_price'].'</td>';
            $response .='<td id="total_purchase_price_'.$data['product_id'].'">'.$data['purchase_price']*$data['quantity'].'</td>';
            $response .='<td class="d-flex justify-content-center">';
            $response .='<button type="button" class="mx-2 btn btn-success editBtnOfTable" onclick="editRow('.$data['product_id'].')"><i class="fas fa-edit"></i> Edit</button>';
          }
          // $response .='<button type="button" class="mx-2 btn btn-info" onclick="sellBox('.$data['product_id'].')"><i class="fas fa-coins"></i> Sell</button>';
          if (isset($_SESSION['s_userId'])) {
            $response .='<button type="button" class="mx-2 btn btn-danger deleteBtnOfTable" onclick="deleteData('.$data['product_id'].')"><i class="fas fa-trash"></i> Delete</button>';
            $response .='</td>';
          }
          $response .='</tr>';
        }
      }
      $array = array(
        'tableRows' => $response,
        'counter' => $counter
      );
      exit(json_encode($array));
    } else {
      exit("noMore");
    }


  }

  // sell
  if ($_POST['key'] == 'sell') {
    $rowID = $_POST['rowID'];
    $quantity = $_POST['quantity'];
    $sql = "SELECT * FROM country WHERE id = '$rowID'";
    $result = mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($result);
    $tmpQuantity = $data['quantity'] - $quantity;
    $sql = "UPDATE country SET quantity = '$tmpQuantity' WHERE id = '$rowID'";
    if (mysqli_query($conn,$sql)) {
      exit("success");
    } else {
      exit("somethingWrong in sell");
    }
  }

  // admin logout
  if ($_POST['key'] == 'logout') {
    session_unset();
    session_destroy();
    exit("success");
  }

  // account setting of password
  if ($_POST['key'] == 'saveAccountSetting') {
    $userName = $_POST['userName'];
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];
    $sql = "SELECT * FROM login WHERE BINARY userId = '$userName'";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result) > 0) {
      $data = mysqli_fetch_assoc($result);
      if ($currentPassword == $data['userPwd']) {
        if ($newPassword == $confirmNewPassword) {
          $sql = "UPDATE login SET userPwd = '$newPassword' WHERE userId = '$userName'";
          if (mysqli_query($conn,$sql)) {
            exit("success");
          } else {
            exit("somethingWrong");
          }
        } else {
          exit("passwordNotMatch");
        }
      } else {
        exit("incorrectCurrentPassword");
      }
    } else {
      exit("incorrectName");
    }
  }

  // admin login
  if ($_POST['key'] == 'loginForm') {
    $userId = $_POST['userId'];
    $userPwd = $_POST['userPwd'];
    $sql = "SELECT * FROM login WHERE binary userId='$userId'";
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
    if ( $resultCheck < 1) {
      exit("incorrectName");
    } else if($resultCheck == 1) {
      $data = mysqli_fetch_assoc($result);
      if ($userPwd == $data['userPwd']) {
        $_SESSION['s_userId'] = $data['userId'];
        $_SESSION['s_userPwd'] = $data['userPwd'];
        exit("successfullyLogined");
      } else {
        exit("incorrectPassword");
      }
    } else {
      exit("somethingWrong");
    }
  }

  // delete data
  if ($_POST['key'] == 'deleteData') {
    $rowID = $_POST['rowID'];
    $sql = "DELETE FROM productlist WHERE product_id = '$rowID'";
    if (mysqli_query($conn,$sql)) {
      exit("success");
    } else {
      exit("somethingWrong in deleteData");
    }
  }

  // View data
  if ($_POST['key'] == 'viewData') {
    $rowID = $_POST['rowID'];
    $sql = "SELECT * FROM country WHERE id = '$rowID'";
    if ($result = mysqli_query($conn,$sql)) {
      $data = mysqli_fetch_assoc($result);
      $array = array(
        'id' => $data['id'],
        'name' => $data['name'],
        'shortDesc' => $data['shortDesc'],
        'longDesc' => $data['longDesc']
      );
      exit(json_encode($array));
    } else {
      exit("somethingWrong in viewData");
    }
  }

  // save edited data
  if($_POST['key'] == 'saveEditData') {
    $rowID = $_POST['rowID'];
    $product_name = $_POST['product_name'];
    $exp_date = $_POST['exp_date'];
    $pack_size = $_POST['pack_size'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $purchase = $_POST['purchase'];
    $sql = "UPDATE productlist SET product_name = '$product_name', exp_date = '$exp_date', pack_size = '$pack_size' , quantity = '$quantity' , price = '$price' , purchase_price = '$purchase' WHERE product_id = '$rowID'";
    if (mysqli_query($conn,$sql)) {
      $response = $purchase*$quantity;
      exit((string)$response);
    } else {
      exit("somethingWrong in saveEditData");
    }
  }


    // edit data
    if ($_POST['key'] == 'editRow') {
      $rowID = $_POST['rowID'];
      $sql = "SELECT * FROM productlist WHERE product_id = '$rowID'";
      $result = mysqli_query($conn,$sql);
      $data = mysqli_fetch_assoc($result);
      $array = array(
        'product_id' => $data['product_id'],
        'product_name' => $data['product_name'],
        'exp_date' => $data['exp_date'],
        'pack_size' => $data['pack_size'],
        'quantity' => $data['quantity'],
        'price' => $data['price'],
        'purchase' => $data['purchase_price']
      );
      exit(json_encode($array));
    }


    // get data from db to display in table
    if ($_POST['key'] == 'getExistingData') {
      $start = $_POST['start'];
      $limit = $_POST['limit'];
      $counter = $start;
      $sql = "SELECT * FROM productlist LIMIT $start , $limit";
      $result = mysqli_query($conn,$sql);
      if (mysqli_num_rows($result) > 0) {
        $response = "";
        while($data = mysqli_fetch_assoc($result)) {
          $response .='<tr>';
          $response .='<td>'.++$counter.'</td>';
          $response .='<td id="product_name_'.$data['product_id'].'">'.$data['product_name'].'</td>';
          $response .='<td id="exp_date_'.$data['product_id'].'">'.$data['exp_date'].'</td>';
          $response .='<td id="pack_size_'.$data['product_id'].'">'.$data['pack_size'].'</td>';
          $response .='<td id="quantity_'.$data['product_id'].'">'.$data['quantity'].'</td>';
          $response .='<td id="price_'.$data['product_id'].'">'.$data['price'].'</td>';
          if (isset($_SESSION['s_userId'])) {
            $response .='<td id="purchase_price_'.$data['product_id'].'">'.$data['purchase_price'].'</td>';
            $response .='<td id="total_purchase_price_'.$data['product_id'].'">'.$data['quantity']*$data['purchase_price'].'</td>';
            $response .='<td class="d-flex justify-content-center">';
            $response .='<button type="button" class="mx-2 btn btn-success editBtnOfTable" onclick="editRow('.$data['product_id'].')"><i class="fas fa-edit"></i> Edit</button>';
          }
          // $response .='<button type="button" class="mx-2 btn btn-light" onclick="viewData('.$data['product_id'].')"><i class="far fa-file-alt"></i> View </button>';
          // $response .='<button type="button" class="mx-2 btn btn-info" onclick="sellBox('.$data['product_id'].')"><i class="fas fa-coins"></i> Sell</button>';
          if (isset($_SESSION['s_userId'])) {
            $response .='<button type="button" class="mx-2 btn btn-danger deleteBtnOfTable" onclick="deleteData('.$data['product_id'].')"><i class="fas fa-trash "></i> Delete</button>';
            $response .='</td>';
          }
          $response .='</tr>';
        }
        exit($response);
      } else {
        exit("noMore");
      }
    }

    // add data into db
    if ($_POST['key'] == 'addNew') {
      $product_name = $_POST['product_name'];
      $pack_size = $_POST['pack_size'];
      $quantityInput = $_POST['quantity'];
      $price = $_POST['price'];
      $exp_date = $_POST['exp_date'];
      $purchase = $_POST['purchase'];

      $sql = "SELECT * FROM productlist WHERE product_name = '$product_name'";
      $result = mysqli_query($conn,$sql);
      if (mysqli_num_rows($result) > 0) {
        exit("NameTaken");
      } else {
        $sql = "INSERT INTO productlist(product_name,exp_date,pack_size,quantity,price,purchase_price) VALUES('$product_name','$exp_date','$pack_size','$quantityInput','$price','$purchase')";
        if (mysqli_query($conn,$sql)) {
          exit("success");
        } else {
          exit("somethingWrong");
        }
      }
    }


  }

 ?>
