<div class="modal-header">
    <div class="h5 modal-title">Cylinder Information</div>
    <button type="button" class="btn-close" ng-click="closeModal()" aria-label="Close" ng-disabled="isloading"></button>
</div>
<div class="modal-body px-3">
    <!-- cylinder fields -->
    <div class="alert alert-warning d-flex align-items-center rounded-3 mb-3" role="alert">
        <i class="ph-bold ph-info me-2 fs-2 text-warning"></i>
        <div>
            <strong>Important:</strong> All fields marked with
            <span class="text-danger">*</span> are required.
            Please provide complete and accurate details before saving.
        </div>
    </div>



    <!-- Serial -->
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingSerial" placeholder="Serial"
            ng-class="{'is-invalid': isInvalid && !cylinder_info.serial}"
            ng-model="cylinder_info.serial" ng-disabled="isloading">
        <label for="floatingSerial">Serial <span class="text-danger">*</span></label>
        <small class="invalid-feedback" ng-if="isInvalid && !cylinder_info.serial">This field is required</small>
    </div>

    <div class="row mb-3 align-items-center">
        <!-- Barcode Input -->
        <div class="col-lg-9 pe-2">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingBarcode" placeholder="Barcode"
                    ng-class="{'is-invalid': isInvalid && !cylinder_info.barcode}"
                    ng-model="cylinder_info.barcode" ng-disabled="isloading">
                <label for="floatingBarcode">Barcode <span class="text-danger">*</span> (Auto generate if not filled)</label>
                <small class="invalid-feedback" ng-if="isInvalid && !cylinder_info.barcode">This field is required</small>
            </div>
        </div>
        <!-- Generate Button -->
        <div class="col-lg-3 ps-2">
            <button type="button" class="d-flex align-items-center justify-content-center btn btn-light-blue w-100"
                style="padding:12px 14px"
                ng-click="setGeneratedBarcode()"
                ng-disabled="isloading">
                <i class="ph-bold ph-barcode me-2" style="font-size: 18px;"></i> Generate
            </button>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6 pe-2">
            <!-- Types -->
            <div class="form-floating">
                <select class="form-select" id="floatingTypes"
                    ng-class="{'is-invalid': isInvalid && (!cylinder_info.types_id || cylinder_info.types_id == 0)}"
                    ng-model="cylinder_info.types_id"
                    ng-disabled="isloading">
                    <option ng-value="0">Select Type</option>
                    <option ng-repeat="t in typesList" ng-value="t.id">{{t.descriptions}}</option>
                </select>
                <label for="floatingTypes">Types <span class="text-danger">*</span></label>
                <small class="invalid-feedback" ng-if="isInvalid && (!cylinder_info.types_id || cylinder_info.types_id == 0)">
                    This field is required
                </small>
            </div>
        </div>
        <div class="col-6 ps-2">
            <!-- Categories -->
            <div class="form-floating">
                <select class="form-select" id="floatingCategories"
                    ng-class="{'is-invalid': isInvalid && (!cylinder_info.category_id || cylinder_info.category_id == 0)}"
                    ng-model="cylinder_info.category_id"
                    ng-disabled="isloading">
                    <option ng-value="0">Select Category</option>
                    <option ng-repeat="c in categoryList" ng-value="c.id">{{c.descriptions}}</option>
                </select>
                <label for="floatingCategories">Category <span class="text-danger">*</span></label>
                <small class="invalid-feedback" ng-if="isInvalid && (!cylinder_info.category_id || cylinder_info.category_id == 0)">
                    This field is required
                </small>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <!-- Capacity (col-8) -->
        <div class="col-lg-6 pe-2">
            <div class="form-floating">
                <input type="number" min="0" step="0.01" class="form-control" id="floatingCapacity" placeholder="Capacity"
                    ng-class="{'is-invalid': isInvalid && (!cylinder_info.capacity || cylinder_info.capacity == 0)}"
                    ng-model="cylinder_info.capacity" ng-disabled="isloading">
                <label for="floatingCapacity">Capacity <span class="text-danger">*</span></label>
                <small class="invalid-feedback" ng-if="isInvalid && (!cylinder_info.capacity || cylinder_info.capacity == 0)">This field is required</small>
            </div>
        </div>
        <!-- Unit (col-4) -->
        <div class="col-lg-6 ps-2">
            <div class="form-floating">
                <select class="form-select" id="floatingUnit"
                    ng-class="{'is-invalid': isInvalid && (!cylinder_info.unit_id || cylinder_info.unit_id == 0)}"
                    ng-model="cylinder_info.unit_id"
                    ng-disabled="isloading">
                    <option ng-value="0">Select Unit</option>
                    <option ng-repeat="u in unitsList" ng-value="u.id">{{u.tags}}({{u.descriptions}})</option>
                </select>
                <label for="floatingUnit">Unit <span class="text-danger">*</span></label>
                <small class="invalid-feedback" ng-if="isInvalid && (!cylinder_info.unit_id || cylinder_info.unit_id == 0)">This field is required</small>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <!-- Manufacture Date -->
        <div class="col-lg-6 pe-2">
            <div class="form-floating">
                <input type="date" class="form-control" id="floatingManufactureDate" placeholder="Manufacture Date"
                    ng-class="{'is-invalid': isInvalid && !cylinder_info.manufacture_date}"
                    ng-model="cylinder_info.manufacture_date" ng-disabled="isloading" date-input>
                <label for="floatingManufactureDate">Manufacture Date <span class="text-danger">*</span></label>
                <small class="invalid-feedback" ng-if="isInvalid && !cylinder_info.manufacture_date">This field is required</small>
            </div>
        </div>
        <!-- Expiry Date -->
        <div class="col-lg-6 ps-2">
            <div class="form-floating">
                <input type="date" class="form-control" id="floatingExpiryDate" placeholder="Expiry Date"
                    ng-class="{'is-invalid': isInvalid && !cylinder_info.expiry_date}"
                    ng-model="cylinder_info.expiry_date" ng-disabled="isloading" date-input>
                <label for="floatingExpiryDate">Expiry Date <span class="text-danger">*</span></label>
                <small class="invalid-feedback" ng-if="isInvalid && !cylinder_info.expiry_date">This field is required</small>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button style="padding: 10px 12px;" class="d-flex align-items-center btn btn-light-blue"
        ng-click="saveCylinder(cylinder_info)" ng-disabled="isloading">
        <div ng-if="isloading">
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status">Saving</span>
        </div>
        <div class="text-white" ng-if="!isloading">Save Changes</div>
    </button>
</div>