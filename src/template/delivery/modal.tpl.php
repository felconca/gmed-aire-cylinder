<div class="modal-header">
    <div class="h5 modal-title">Delivery Information</div>
    <button type="button" class="btn-close" ng-click="closeModal()" aria-label="Close" ng-disabled="isloading"></button>
</div>
<div class="modal-body px-3">
    <!-- Delivery info -->
    <div class="alert alert-warning d-flex align-items-center rounded-3 mb-3" role="alert">
        <i class="ph-bold ph-info me-2 fs-2 text-warning"></i>
        <div>
            <strong>Note:</strong> All fields marked with
            <span class="text-danger">*</span> are required for delivery.
            If no address is selected, the default address and contact will be set using the customer's main information.
        </div>
    </div>

    <!-- Customer -->
    <div class="form-floating mb-3">
        <select class="form-select" id="deliveryCustomer"
            ng-class="{'is-invalid': isInvalid && !delivery_info.customer_id}"
            ng-model="delivery_info.customer_id"
            ng-disabled="isloading"
            ng-change="onChangeCustomer(delivery_info.customer_id)">
            <option ng-value="0">Select Customer</option>
            <option ng-value="c.id" ng-repeat="c in customersList">{{c.descriptions}}</option>
        </select>
        <label for="deliveryCustomer">Customer <span class="text-danger">*</span></label>
        <small class="invalid-feedback" ng-if="isInvalid && !delivery_info.customer_id">Please select a customer</small>
    </div>

    <!-- Address -->
    <div class="form-floating mb-3" ng-if="delivery_info.customer_id">
        <select class="form-select"
            id="deliveryCustomerAddress"
            ng-model="delivery_info.customer_address"
            ng-disabled="isloading || !delivery_info.customer_id">
            <option ng-value="0">Select Address</option>
            <option ng-value="loc.id" ng-repeat="loc in customerAddresses">
                {{loc.address}}-
                {{loc.contact_person}} | {{loc.contact}}
            </option>
        </select>
        <label for="deliveryCustomerAddress">Customer Address</label>
    </div>

    <!-- Delivery Date & Request Date -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="form-floating">
                <input type="date" class="form-control" id="deliveryDate"
                    ng-class="{'is-invalid': isInvalid && !delivery_info.delivery_date}"
                    ng-model="delivery_info.delivery_date" ng-disabled="isloading">
                <label for="deliveryDate">Delivery Date <span class="text-danger">*</span></label>
                <small class="invalid-feedback" ng-if="isInvalid && !delivery_info.delivery_date">Delivery Date Required</small>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-floating">
                <input type="date" class="form-control" id="requestDate"
                    ng-class="{'is-invalid': isInvalid && !delivery_info.request_date}"
                    ng-model="delivery_info.request_date" ng-disabled="isloading">
                <label for="requestDate">Request Date <span class="text-danger">*</span></label>
                <small class="invalid-feedback" ng-if="isInvalid && !delivery_info.request_date">>Request Date Required</small>
            </div>
        </div>
    </div>

    <!-- Optional Notes -->
    <div class="form-floating mb-3">
        <textarea class="form-control" placeholder="Notes" id="deliveryNotes"
            ng-model="delivery_info.notes" style="height: 80px" ng-disabled="isloading"></textarea>
        <label for="deliveryNotes">Notes</label>
    </div>
</div>

<div class="modal-footer">
    <button style="padding: 10px 12px;" class="d-flex align-items-center btn btn-light-blue"
        ng-click="saveDelivery(delivery_info)" ng-disabled="isloading">
        <div ng-if="isloading">
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status">Saving</span>
        </div>
        <div class="text-white" ng-if="!isloading">Save Delivery</div>
    </button>
</div>