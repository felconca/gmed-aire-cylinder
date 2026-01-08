<div class="modal-header">
    <div class="h5 modal-title">Customer Information</div>
    <button type="button" class="btn-close" ng-click="closeCustomer()" aria-label="Close" ng-disabled="isloading"></button>
</div>
<div class="modal-body px-3">
    <!-- Customer -->
    <div class="alert alert-warning d-flex align-items-center rounded-3 mb-3" role="alert">
        <i class="ph-bold ph-info me-2 fs-2 text-warning"></i>
        <div>
            <strong>Important:</strong> All fields marked with
            <span class="text-danger">*</span> are required.
            Please provide complete and accurate details before saving.
        </div>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingCustomer" placeholder="Customer"
            ng-class="{'is-invalid':isInvalid && customer_info.descriptions == ''}"
            ng-model="customer_info.descriptions" ng-disabled="isloading">
        <label for="floatingCustomer">Customer <span class="text-danger">*</span></label>
        <small class="invalid-feedback" ng-if="isInvalid && customer_info.descriptions == ''">This field is required</small>
    </div>

    <!-- Address -->
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingAddress" placeholder="Address"
            ng-class="{'is-invalid':isInvalid && customer_info.address == ''}"
            ng-model="customer_info.address" ng-disabled="isloading">
        <label for="floatingAddress">Address <span class="text-danger">*</span></label>
        <small class="invalid-feedback" ng-if="isInvalid && customer_info.address == ''">This field is required</small>
    </div>

    <div class="row">
        <!-- City -->
        <div class="col-lg-4 mb-3 pe-2">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingCity" placeholder="City"
                    ng-class="{'is-invalid':isInvalid && customer_info.city == ''}"
                    ng-model="customer_info.city" ng-disabled="isloading">
                <label for="floatingCity">City <span class="text-danger">*</span></label>
                <small class="invalid-feedback" ng-if="isInvalid && customer_info.city == ''">This field is required</small>
            </div>
        </div>
        <!-- State -->
        <div class="col-lg-4 mb-3 px-2">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingState" placeholder="State/Province"
                    ng-class="{'is-invalid':isInvalid && customer_info.state == ''}"
                    ng-model="customer_info.state" ng-disabled="isloading">
                <label for="floatingState">State/Province <span class="text-danger">*</span></label>
                <small class="invalid-feedback" ng-if="isInvalid && customer_info.state == ''">This field is required</small>
            </div>
        </div>
        <!-- zipcode -->
        <div class="col-lg-4 mb-3 px-2">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingZip" placeholder="ZipCode"
                    ng-class="{'is-invalid':isInvalid && customer_info.zipcode == ''}"
                    ng-model="customer_info.zipcode" ng-disabled="isloading">
                <label for="floatingZip">ZipCode <span class="text-danger">*</span></label>
                <small class="invalid-feedback" ng-if="isInvalid && customer_info.zipcode == ''">This field is required</small>
            </div>
        </div>



        <!-- Country -->
        <!-- <div class="col-lg-3 mb-3 ps-2">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingCountry" placeholder="Country"
                    ng-class="{'is-invalid':isInvalid && customer_info.country == ''}"
                    ng-model="customer_info.country" ng-disabled="isloading">
                <label for="floatingCountry">Country <span class="text-danger">*</span></label>
                <small class="invalid-feedback" ng-if="isInvalid && customer_info.country == ''">This field is required</small>
            </div>
        </div> -->
    </div>

    <div class="row">
        <!-- Contact Person -->
        <div class="col-lg-4 mb-3 pe-2">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingContactPerson" placeholder="Contact Person"
                    ng-class="{'is-invalid':isInvalid && customer_info.contact_person == ''}"
                    ng-model="customer_info.contact_person" ng-disabled="isloading">
                <label for="floatingContactPerson">Contact Person <span class="text-danger">*</span></label>
                <small class="invalid-feedback" ng-if="isInvalid && customer_info.contact_person == ''">This field is required</small>
            </div>
        </div>

        <!-- Contact Number -->
        <div class="col-lg-4 mb-3 px-2">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingContactNo" placeholder="Contact/Mobile No."
                    ng-class="{'is-invalid':isInvalid && customer_info.contact_no == ''}"
                    ng-model="customer_info.contact_no" ng-disabled="isloading">
                <label for="floatingContactNo">Contact/Mobile No. <span class="text-danger">*</span></label>
                <small class="invalid-feedback" ng-if="isInvalid && customer_info.contact_no == ''">This field is required</small>
            </div>
        </div>

        <!-- Email -->
        <div class="col-lg-4 mb-3 ps-2">
            <div class="form-floating">
                <input type="email" class="form-control" id="floatingEmail" placeholder="Email"
                    ng-model="customer_info.email" ng-disabled="isloading">
                <label for="floatingEmail">Email</label>
            </div>
        </div>
    </div>

    <!-- Shown only when customer_info.id > 0 -->
    <div class=" d-flex justify-content-end align-items-center mb-3" ng-if="customer_info.id > 0">
        <a style="text-decoration: underline; cursor:pointer" ng-click="showContactModal(customer_info.id)">
            Other Contact Information
        </a>
    </div>
</div>

<div class="modal-footer">
    <button style="padding: 10px 12px;" class="d-flex align-items-center btn btn-light-blue"
        ng-click="saveCustomer(customer_info)" ng-disabled="isloading">
        <div ng-if="isloading">
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status">Saving</span>
        </div>
        <div class="text-white" ng-if="!isloading">Save Changes</div>
    </button>
</div>