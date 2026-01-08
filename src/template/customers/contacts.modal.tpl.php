<div class="modal-header">
    <div class="h5modal-title">Other Contacts</div>
    <button type="button" class="btn-close" aria-label="Close" ng-click="closeContact()"></button>
</div>
<div class="modal-body">
    <div class="table-in" style="height: calc(100vh - 200px);">
        <table class="table align-middle table-bordered">
            <thead>
                <tr>
                    <th colspan="5">
                        <div class="d-flex align-items-center" style="gap:10px">
                            <div class="input-grp-table">
                                <i class="ph-bold ph-magnifying-glass"></i>
                                <input type="text" placeholder="Search contacts..." ng-model="search_cn" ng-disabled="isLoading">
                            </div>
                            <a class="btn d-flex align-items-center justify-content-center"
                                style="width:130px !important; padding:10px 12px;" ng-click="addLine()" ng-disabled="isLoading">
                                <i class="fa-solid fa-plus me-2"></i>
                                Add Lines
                            </a>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th width="20%" class="resizable">Person</th>
                    <th width="15%" class="resizable">Contact No</th>
                    <th width="15%" class="resizable">Email</th>
                    <th class="resizable">Full Address</th>
                    <th width="1%" class="text-center">Remove</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="cl in contactList | filter:search_cn track by $index" ng-if="cl.deleted == 0">
                    <td class="has-input"><input type="text" ng-disabled="isLoading" class="input-tbl" placeholder="Contact Person" ng-model="cl.contact_person" ng-change="checkLastRow($index)"></td>
                    <td class="has-input"><input type="text" ng-disabled="isLoading" class="input-tbl" placeholder="Contact No" ng-model="cl.contact_no" ng-change="checkLastRow($index)" numbers-only></td>
                    <td class="has-input"><input type="email" ng-disabled="isLoading" class="input-tbl" placeholder="Email" ng-model="cl.email" ng-change="checkLastRow($index)"></td>
                    <td class="has-input"><input type="text" ng-disabled="isLoading" class="input-tbl" placeholder="Full Address" ng-model="cl.address" ng-change="checkLastRow($index)"></td>
                    <td class="text-center">
                        <button class="btn-table w-100" ng-click="deleteLine($index)" ng-disabled="isLoading">
                            <i class="ph-bold ph-trash text-danger"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
<div class="modal-footer">
    <button style="padding: 10px 12px;" class="d-flex align-items-center btn btn-light-blue"
        ng-click="saveContacts(contactList)">
        <div ng-if="isLoading">
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status">Saving</span>
        </div>
        <div class="text-white" ng-if="!isLoading">Save Contacts</div>
    </button>
</div>