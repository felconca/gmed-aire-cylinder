<div class="modal-header">
    <div class="h5 modal-title">Location Information</div>
    <button type="button" class="btn-close" ng-click="closeModal()" aria-label="Close" ng-disabled="isloading"></button>
</div>
<div class="modal-body px-3">
    <!-- Location -->
    <div class="alert alert-warning d-flex align-items-center rounded-3 mb-3" role="alert">
        <i class="ph-bold ph-info me-2 fs-2 text-warning"></i>
        <div>
            <strong>Important:</strong> All fields marked with
            <span class="text-danger">*</span> are required.
            Please provide complete and accurate details before saving.
        </div>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingLocation" placeholder="Location Tags"
            ng-class="{'is-invalid':isInvalid && location_info.tags == ''}"
            ng-model="location_info.tags" ng-disabled="isloading">
        <label for="floatingLocation">Tags <span class="text-danger">*</span></label>
        <small class="invalid-feedback" ng-if="isInvalid && location_info.tags == ''">This field is required</small>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingLocation" placeholder="Location Name"
            ng-class="{'is-invalid':isInvalid && location_info.descriptions == ''}"
            ng-model="location_info.descriptions" ng-disabled="isloading">
        <label for="floatingLocation">Descriptions <span class="text-danger">*</span></label>
        <small class="invalid-feedback" ng-if="isInvalid && location_info.descriptions == ''">This field is required</small>
    </div>

    <div class="ps-2">
        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="defaultSwitch"
                ng-model="location_info.default_1"
                ng-true-value="1" ng-false-value="0"
                ng-disabled="isloading"
                ng-change="checkDefault()">
            <label class="form-check-label" for="defaultSwitch">Set as Default</label>
        </div>
    </div>

</div>

<div class="modal-footer">
    <button style="padding: 10px 12px;" class="d-flex align-items-center btn btn-light-blue"
        ng-click="saveLocation(location_info)" ng-disabled="isloading">
        <div ng-if="isloading">
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status">Saving</span>
        </div>
        <div class="text-white" ng-if="!isloading">Save Changes</div>
    </button>
</div>