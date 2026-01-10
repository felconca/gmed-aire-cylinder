<div class="modal-header">
    <div class="h5 modal-title">Available Cylinders List</div>
    <button type="button" class="btn-close" ng-click="closeCylinder()" aria-label="Close" ng-disabled="isloading"></button>
</div>
<div class="modal-body">
    <div class="d-flex align-items-end justify-content-end mb-3" style="gap: 12px;">
        <div class="w-50">
            <div class="table-search">
                <i class="ph-bold ph-magnifying-glass"></i>
                <input type="text" placeholder="Search" ng-model="search_cylinder">
            </div>
        </div>
        <div class="row w-50 justify-content-end">
            <div class="col-4 px-2">
                <!-- Types -->
                <div class="form-floating">
                    <select class="form-select" id="floatingTypes"
                        ng-model="ftypes"
                        ng-disabled="isloading">
                        <option ng-value="0">Select Type</option>
                        <option ng-repeat="t in typesList" ng-value="t.id">{{t.descriptions}}</option>
                    </select>
                    <label for="floatingTypes">Types</label>
                </div>
            </div>
            <div class="col-4 ps-2">
                <!-- Categories -->
                <div class="form-floating">
                    <select class="form-select" id="floatingCategories"
                        ng-model="fcategory"
                        ng-disabled="isloading">
                        <option ng-value="0">Select Category</option>
                        <option ng-repeat="c in categoryList" ng-value="c.id">{{c.descriptions}}</option>
                    </select>
                    <label for="floatingCategories">Category</label>
                </div>
            </div>
        </div>
        <button class="btn btn-light-blue py-3" style="padding-inline: 16px;" ng-click="getCylinders(fcategory, ftypes)">
            <i class="ph-bold ph-funnel"></i>
        </button>
    </div>
    <div class="table-in" style="height: calc(100vh - 200px);">
        <table class="table align-middle table-bordered">
            <thead>
                <tr>
                    <th class="text-center" nowrap width="1%">
                        <input class="form-check-input fs-6" type="checkbox" ng-model="selectCylinderAll"
                            ng-click="selectAllCylinders(cylinderF)" ng-disabled="cylindersList.length == 0">
                    </th>
                    <th>Barcode</th>
                    <th>Serial</th>
                    <th width="10%">Capacity</th>
                    <th width="10%">Types</th>
                    <th width="10%">Categories</th>
                    <th width="8%" class="text-center">Add</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="items in cylinderF = (cylindersList | filter:search_cylinder) | limitTo:itemsPerCylinderPage:itemsPerCylinderPage*(currentCylinderPage-1) track by $index">
                    <td class="text-center">
                        <input class="form-check-input" type="checkbox" ng-model="items.selected" ng-click="selectCylinder(items)">
                    </td>
                    <td class="text-ellipsis">{{items.barcode || '-N/A-'}}</td>
                    <td class="text-ellipsis">{{items.serial}}</td>
                    <td>{{items.capacity}} ({{items.units}})</td>
                    <td>{{items.types}}</td>
                    <td>{{items.categories}}</td>
                    <td class="text-center">
                        <a class="link-anchor" ng-click="addItems([items])">
                            <i class="ph-bold ph-plus-circle" style="color:inherit"></i> Add
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


    <!-- pagination -->
    <div class=" d-flex align-items-center justify-content-between pt-3">
        <span class="page-table-info">
            <!-- Page: {{currentCylinderPage}} of {{numPages}} -->
            Showing {{
            cylinderF.length > 0 ? formatNumber((currentCylinderPage - 1) * itemsPerCylinderPage + 1) : 0
        }} to {{
            cylinderF.length > 0 ? formatNumber(Math.min(currentCylinderPage * itemsPerCylinderPage, cylinderF.length)) : 0
        }} of {{formatNumber(cylinderF.length)}} entries
        </span>

        <ul style="margin-bottom: 0 !important;" uib-pagination boundary-links="true"
            total-items="cylinderF.length" num-pages="numPages" items-per-page="itemsPerCylinderPage"
            ng-model="currentCylinderPage" max-size="5" boundary-link-numbers="true"
            ng-change="changeCylinderPage(cylindersList)"></ul>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <span class="page-table-info">
        {{ selectedCylinders.length}} of {{cylindersList.length}} items selected
    </span>
    <button style="padding: 10px 12px;" class="d-flex align-items-center btn btn-light-blue"
        ng-click="addItems(selectedCylinders)" ng-disabled="isloading || selectedCylinders.length == 0">
        <div ng-if="isloading">
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status">Adding...</span>
        </div>
        <div class="text-white" ng-if="!isloading">Add Selected items</div>
    </button>
</div>