<div id="tableManager" class="modal fade">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header">
        <h3 id="modalTitle" class="modal-title">
          <i class="fas fa-clinic-medical"></i>
          Medical Store
        </h3>
      </div>
      <div class="modal-body">
        <div id="inputPart">
          <div class="form-group">
            <label class="font-weight-bold" for="product_name">Product Name :</label>
            <input class="form-control" type="text" id="product_name" placeholder="Product Name ">
          </div>
          <div class="form-group">
            <label class="font-weight-bold" for="exp_date">Exp Date :</label>
            <input id="exp_date" class="form-control" type="date">
          </div>
          <div class="form-group">
            <label class="font-weight-bold" for="pack_size">Pack Size :</label>
            <input type="text" id="pack_size" class="form-control" placeholder="Pack Size">
          </div>
          <div class="form-group">
            <label class="font-weight-bold" for="quantityInput">Quantity : </label>
            <input id="quantityInput" placeholder="Quantity" type="text" class="form-control">
          </div>
          <div class="d-flex">
            <div class="form-group flex-fill">
              <label class="font-weight-bold" for="price">Sale Price :</label>
              <input type="text" id="price" class="form-control" placeholder="Sale Price">
            </div>
            <div class="form-group flex-fill mx-2">
              <label class="font-weight-bold" for="purchase">Purchase Price :</label>
              <input type="text" id="purchase" class="form-control" placeholder="Purchase Price">
            </div>
          </div>

          <input type="hidden"  id="rowID" value="0">
        </div>
        <div id="viewPart">
          <div id="view_id"></div>
          <div id="view_name"></div>
          <div id="view_shortDesc"></div>
          <div id="view_longDesc"></div>
        </div>
        <div id="loginForm" class="form-group" >
          <input class="form-control" type="text" id="userId" placeholder="UserId.."><br>
          <input class="form-control" type="password" id="userPwd" placeholder="Password..">
        </div>
        <div id="sellForm" class="form-group" >
          <input class="form-control" type="text" id="quantity" placeholder="Quantity..">
          <input id="sellRowId" type="hidden" value="0">
        </div>
        <div id="sellingListForm">
          <div class="form-group">
            <label class="font-weight-bold" for="editSellingListQuantiy">Quantity:</label>
            <input type="text" class="form-control" id="editSellingListQuantiy" placeholder="Quantity..."><br>
          </div>
          <div class="form-group">
            <label class="font-weight-bold" for="editSellingListAmount">Amount:</label>
            <input type="text" class="form-control" id="editSellingListAmount" placeholder="Amount...">
          </div>
          <input type="hidden" value="0" id="editSellingListID">
        </div>
      </div>
      <div class="modal-footer">
        <input type="button"  value="Add" id="manageBtn1" class="btn btn-success">
        <input type="button"  value="Cancel" id="manageBtn2" class="btn btn-danger" data-dismiss="modal">
      </div>
    </div>
  </div>
</div>










<div id="passwordSetting" class="modal fade">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header">
        <h3 id="modalTitle" class="modal-title">
          <i class="fas fa-clinic-medical"></i>
          Account setting
        </h3>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="userName" class="font-weight-bold d-flex mb-0 pb-2">User Name :</label>
          <input type="text" id="userName" class="form-control" placeholder="User Name....">
        </div>
        <div class="form-group">
          <label class="font-weight-bold d-flex mb-0 pb-2" for="currentPassword">Current Password :</label>
          <input type="password" id="currentPassword" class="form-control" placeholder="Current Password">
        </div>
        <div class="form-group">
          <label class="font-weight-bold d-flex mb-0 pb-2" for="newPassword">New Password :</label>
          <input type="password" id="newPassword" class="form-control" placeholder="New Password">
        </div>
        <div class="form-group">
          <label class="font-weight-bold d-flex mb-0 pb-2" for="confirmNewPassword">Confirm New Password :</label>
          <input type="password" id="confirmNewPassword" class="form-control" placeholder="Confirm New Password">
        </div>
      </div>
      <div class="modal-footer">
        <input type="button"  onclick="saveAccountSetting()" value="Apply"  class="btn btn-success">
        <input type="button"  value="Cancel"  class="btn btn-danger" data-dismiss="modal">
      </div>
    </div>
  </div>
</div>

<div id="finance" class="modal fade">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">
          <i class="fas fa-clinic-medical"></i>
          Finance
        </h3>
      </div>
      <div class="modal-body">
        <h4 >Total Purchase Price : <br>&nbsp;&nbsp;<span id="purchasePriceOfAllItems"></span> </h4><br>
        <h4 >Total Selling Price : <br>&nbsp;&nbsp;<span id="sellingPriceOfAllItems"></span> </h4><br>
        <h4 >Total Profit : <br>&nbsp;&nbsp;<span id="totalProfitOfAllItems"></span> </h4>
      </div>
      <div class="modal-footer">
        <input type="button" value="Cancel" class="btn btn-danger" data-dismiss="modal">
      </div>
    </div>
  </div>
</div>
