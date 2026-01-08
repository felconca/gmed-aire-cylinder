<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-1">
    <div class="d-block mb-4 mb-md-0">
        <breadcrumbs></breadcrumbs>
    </div>
    <div class="d-flex align-items-center " style="gap: 6px;">
        <button class="btn btn-light-blue" style="padding: 10px 12px;" ng-click="cylinderModal()" ng-disabled="isfiltering">
            <i class="ph-bold ph-plus me-2"></i>
            Add New
        </button>
        <button class="btn btn-light border" style="padding: 10px 14px;" tooltip='Export' ng-click="downloadItems()" ng-disabled="isfiltering">
            <i class="ph-bold ph-cloud-arrow-down"></i>
        </button>
        <button class="btn btn-light border" style="padding: 10px 14px;" tooltip='Print' ng-click="printCylinder()" ng-disabled="isfiltering">
            <i class="ph-bold ph-printer"></i>
        </button>

    </div>
</div>
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h2 class="greetings mb-0">Cylinders</h2>
        <p class="sub-greetings mb-0">
            Manage inventory and tracking of cylinders.
        </p>
    </div>
    <!-- <div class="d-block mb-md-0">
        <div class="d-flex align-items-center justify-content-end mb-1" style="gap: 6px;">
            <div class="text-muted me-2">Status:</div>
            <div class="filter-tabs border border-light">
                <button
                    ng-repeat="tab in filterItemStatus"
                    class="filter-tab"
                    ng-class="{active: selectedFilter === tab.value}"
                    ng-click="setFilter(tab.value)">
                    {{tab.label}}
                </button>
            </div>
        </div>
    </div> -->


    <div class="d-flex align-items-end justify-content-end" style="gap: 6px;">
        <div class="table-search" ng-disabled="isfiltering">
            <i class="ph-bold ph-magnifying-glass"></i>
            <input type="text" placeholder="Search" ng-model="search" ng-disabled="isfiltering">
        </div>


        <div class="dropdown">
            <button class="btn btn-light border dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                style="padding: 10px 14px;" ng-disabled="isfiltering" tooltip='Filter'>
                <i class="ph-bold ph-funnel-simple"></i>
            </button>
            <ul class="filter-menu dropdown-menu">
                <li class="px-3 py-2">
                    <div class="fw-semibold text-dark fs-6">
                        <i class="ph-bold ph-sliders me-2"></i>Filter Cylinder
                    </div>

                </li>
                <hr class="dropdown-divider">
                <div>
                    <li class="px-3 mb-3">
                        <div class="text-muted">Customer</div>
                        <div>
                            <select class="form-select py-2" id="filterCustomer" ng-model="fcustomer" ng-disabled="isfiltering">
                                <option ng-value="0">Select Customer</option>
                                <option ng-repeat="c in customersList" ng-value="c.id">{{c.descriptions}}</option>
                            </select>
                        </div>
                    </li>
                    <li class="px-3 mb-3">

                        <div class="d-flex align-items-center" style="gap: 6px;">
                            <div class="w-50">
                                <div class="text-muted">Status</div>
                                <select class="form-select py-2" id="filterStatus" ng-model="selectedFilter" ng-disabled="isfiltering">
                                    <option ng-repeat="tab in filterItemStatus" ng-value="tab.value">{{tab.label}}</option>
                                </select>
                            </div>

                            <div class="w-50">
                                <div class="text-muted">Types</div>
                                <select class="form-select py-2" id="filterStatus" ng-model="ftypes" ng-disabled="isfiltering">
                                    <option ng-value="0">Select Type</option>
                                    <option ng-repeat="t in typesList" ng-value="t.id">{{t.descriptions}}</option>
                                </select>
                            </div>
                        </div>
                    </li>

                    <li class="px-3 mb-3">
                        <div class="d-flex align-items-center" style="gap:6px;">
                            <div class="w-50">
                                <div class="text-muted">Categories</div>
                                <select class="form-select py-2" id="filterCateory" ng-model="fcategory" ng-disabled="isfiltering">
                                    <option ng-value="0">Select Category</option>
                                    <option ng-repeat="c in categoryList" ng-value="c.id">{{c.descriptions}}</option>
                                </select>
                            </div>
                            <div class="w-50">
                                <div class="text-muted">Locations</div>
                                <select class="form-select py-2" id="filterLocation" ng-model="flocation" ng-disabled="isfiltering">
                                    <option ng-value="0">Select Location</option>
                                    <option ng-repeat="l in locationsList" ng-value="l.id">{{l.descriptions}}</option>
                                </select>
                            </div>
                        </div>

                    </li>
                    <!-- expiry -->
                    <li class="px-3 mb-3">
                        <div class="text-muted">Expiry Date</div>
                        <div class="d-flex align-items-center">
                            <div class="form-floating me-2">
                                <input type="date" class="form-control" id="expiryDateFrom" placeholder="From"
                                    ng-model="expiryDateFrom"
                                    ng-disabled="isfiltering">
                                <label for="expiryDateFrom">From</label>
                            </div>
                            <div class="form-floating">
                                <input type="date" class="form-control" id="expiryDateTo" placeholder="To"
                                    ng-model="expiryDateTo"
                                    ng-disabled="isfiltering">
                                <label for="expiryDateTo">To</label>
                            </div>
                        </div>
                    </li>
                    <!-- manufacturer -->
                    <li class="px-3 mb-3">
                        <div class="text-muted">Manufacture Date</div>
                        <div class="d-flex align-items-center">
                            <div class="form-floating me-2">
                                <input type="date" class="form-control" id="manufactureDateFrom" placeholder="From"
                                    ng-model="manufactureDateFrom"
                                    ng-disabled="isfiltering">
                                <label for="manufactureDateFrom">From</label>
                            </div>
                            <div class="form-floating">
                                <input type="date" class="form-control" id="manufactureDateTo" placeholder="To"
                                    ng-model="manufactureDateTo"
                                    ng-disabled="isfiltering">
                                <label for="manufactureDateTo">To</label>
                            </div>
                        </div>
                    </li>
                </div>
                <hr class="dropdown-divider">
                <li class="px-2">
                    <button class="btn btn-dark-blue py-2 w-100" ng-click="filterCylinders()">Filter</button>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- tables -->
<div class="table-in" style="height:calc(100vh - 190px)">
    <table class="table align-middle table-bordered">
        <thead>
            <tr>
                <th class="resizable" nowrap>Barcode</th>
                <th class="resizable" nowrap>Serial</th>
                <th class="resizable">Type</th>
                <th class="resizable" nowrap>Manufactured</th>
                <th class="resizable" nowrap>Expiry</th>
                <th class="resizable" nowrap>Capacity</th>
                <th class="resizable" nowrap>Assigned Customers</th>
                <th nowrap class="text-center">Status</th>
                <th width="5%" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="items in cylinderF = (cylindersList | filter:search) | limitTo:itemsPerPage:itemsPerPage*(currentPage-1) track by $index">
                <td class="text-ellipsis">{{items.barcode || '-N/A-'}}</td>
                <td class="text-ellipsis">{{items.serial}}</td>
                <td>{{items.types}}</td>
                <td>{{items.manufacture_date | date: 'MM/dd/yyyy'}}</td>
                <td>{{items.expiry_date | date: 'MM/dd/yyyy'}}</td>
                <td>{{items.capacity}} ({{items.units}})</td>
                <td>{{items.customers}}</td>
                <td nowrap class="text-center">
                    <span class="status-badge {{ cylinderStatusClass(items.status) }}">
                        {{ cylinderStatus(items.status) }}
                    </span>
                </td>
                <td class="text-center">
                    <div class="dropdown dropdown-tbl w-100">
                        <button class="btn-table dropdown-toggle text-center w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ph-fill ph-dots-three-outline"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <button class="dropdown-item" type="button" ng-click="editCylinder(items)">
                                    <i class="ph-bold ph-pencil-simple-line"></i>
                                    <span>Edit Cylinder</span>
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item" type="button" ng-click="viewLogs(items)">
                                    <i class="ph-bold ph-clock-counter-clockwise"></i>
                                    <span>Maintenance History</span>
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item" type="button" ng-click="viewLogs(items)">
                                    <i class="ph-bold ph-signpost"></i>
                                    <span>Tracked Movement</span>
                                </button>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <button class="dropdown-item delete" ng-click="deleteCylinder(items.id)">
                                    <i class="ph-bold ph-trash text-danger"></i>
                                    <span class="text-danger">Delete</span>
                                </button>
                            </li>
                        </ul>

                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- pagination -->
<div class=" d-flex align-items-center justify-content-between pt-3">
    <span class="page-table-info">
        <!-- Page: {{currentPage}} of {{numPages}} -->
        Showing {{
            cylinderF.length > 0 ? formatNumber((currentPage - 1) * itemsPerPage + 1) : 0
        }} to {{
            cylinderF.length > 0 ? formatNumber(Math.min(currentPage * itemsPerPage, cylinderF.length)) : 0
        }} of {{formatNumber(cylinderF.length)}} entries
    </span>

    <ul style="margin-bottom: 0 !important;" uib-pagination boundary-links="true" total-items="cylinderF.length" num-pages="numPages" items-per-page="itemsPerPage" ng-model="currentPage" max-size="5" boundary-link-numbers="true" ng-change="pageChanged()"></ul>
</div>