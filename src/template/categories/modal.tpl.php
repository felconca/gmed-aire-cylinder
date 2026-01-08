<div class="modal-header">
    <div class="h5 modal-title">Category Information</div>
    <button type="button" class="btn-close" ng-click="closeModal()" aria-label="Close" ng-disabled="isloading"></button>
</div>
<div class="modal-body px-3">
    <!-- Categories -->
    <div class="alert alert-warning d-flex align-items-center rounded-3 mb-3" role="alert">
        <i class="ph-bold ph-info me-2 fs-2 text-warning"></i>
        <div>
            <strong>Important:</strong> All fields marked with
            <span class="text-danger">*</span> are required.
            Please provide complete and accurate details before saving.
        </div>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingCategoryTags" placeholder="Category Tags"
            ng-class="{'is-invalid':isInvalid && category_info.tags == ''}"
            ng-model="category_info.tags" ng-disabled="isloading">
        <label for="floatingCategoryTags">Tags <span class="text-danger">*</span></label>
        <small class="invalid-feedback" ng-if="isInvalid && category_info.tags == ''">This field is required</small>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingCategoryDescriptions" placeholder="Category Descriptions"
            ng-class="{'is-invalid':isInvalid && category_info.descriptions == ''}"
            ng-model="category_info.descriptions" ng-disabled="isloading">
        <label for="floatingCategoryDescriptions">Descriptions <span class="text-danger">*</span></label>
        <small class="invalid-feedback" ng-if="isInvalid && category_info.descriptions == ''">This field is required</small>
    </div>
</div>

<div class="modal-footer">
    <button style="padding: 10px 12px;" class="d-flex align-items-center btn btn-light-blue"
        ng-click="saveCategory(category_info)" ng-disabled="isloading">
        <div ng-if="isloading">
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status">Saving</span>
        </div>
        <div class="text-white" ng-if="!isloading">Save Changes</div>
    </button>
</div>