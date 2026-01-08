<div class="d-flex justify-content-between flex-wrap align-items-end flex-md-nowrap py-1">
    <div class="d-block mb-2 mb-md-0">
        <breadcrumbs></breadcrumbs>
        <div>
            <h2 class="greetings mb-0">Customers</h2>
            <p class="sub-greetings mb-0">
                Maintain a list of customers for issuing cylinders.
            </p>
        </div>
    </div>
    <div>
        <div class="d-flex align-items-center justify-content-end mb-2" style="gap: 6px;">
            <div class="table-search" ng-disabled="isfiltering">
                <i class="ph-bold ph-magnifying-glass"></i>
                <input type="text" placeholder="Search" ng-model="search" ng-disabled="isfiltering">
            </div>
            <button class="btn btn-light-blue" style="padding: 10px 12px;" ng-click="customerModal()" ng-disabled="isfiltering">
                <i class="ph-bold ph-plus me-2"></i>
                Add New
            </button>
            <!-- <button class="btn btn-light border" style="padding: 10px 14px;" tooltip='Export' ng-click="exportToExcel('table-data')" ng-disabled="isfiltering">
                <i class="ph-bold ph-cloud-arrow-down"></i>
            </button>
            <button class="btn btn-light border" style="padding: 10px 14px;" tooltip='Print' ng-click="printCustomer()" ng-disabled="isfiltering">
                <i class="ph-bold ph-printer"></i>
            </button> -->
        </div>

    </div>
</div>
<!-- tables -->
<div class="table-in mt-2" style="height:calc(100vh - 180px)">
    <table class="table align-middle table-bordered" id="table-data">
        <thead>
            <tr>
                <th width="1%" nowrap>#</th>
                <th width="20%" nowrap>Customer Name</th>
                <th width="22%" nowrap>Address</th>
                <th width="10%">City</th>
                <th width="10%">Zipcode</th>
                <th width="12%">Contact Person</th>
                <th width="12%">Contact No.</th>
                <th width="10%" class="text-center dont-print">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-if="customerF.length == 0">
                <td colspan="8" class="text-center text-muted">No customer(s) found.</td>
            </tr>
            <tr ng-repeat="items in customerF = (customersList | filter:search) | limitTo:itemsPerPage:itemsPerPage*(currentPage-1) track by $index">
                <td>{{$index + 1 + itemsPerPage * (currentPage-1)}}</td>
                <td>{{items.descriptions || '-N/A-'}}
                    <div ng-if="items.email" class="d-flex align-items-centertext-muted small">
                        <i class="ph-bold ph-at me-1"></i>{{items.email}}
                    </div>
                </td>
                <td>
                    <div>{{items.address}}</div>
                    <div class="text-muted small">
                        {{items.state && items.state + ', '}}{{items.country || ''}}
                    </div>
                </td>
                <td>{{items.city}}</td>
                <td>{{items.zipcode}}</td>
                <td>{{items.contact_person}}</td>
                <td>{{items.contact_no}}</td>
                <td class="text-center dont-print">
                    <div class="d-flex align-items-center justify-content-center">
                        <button class="btn-table" type="button" ng-click="editCustomer(items)" tooltip="Edit">
                            <i class="ph-bold ph-pencil-simple-line"></i>
                        </button>
                        <button class="btn-table" ng-click="deleteCustomer(items.id)" tooltip="Delete">
                            <i class="ph-bold ph-trash text-danger"></i>
                        </button>
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
            customerF.length > 0 ? formatNumber((currentPage - 1) * itemsPerPage + 1) : 0
        }} to {{
            customerF.length > 0 ? formatNumber(Math.min(currentPage * itemsPerPage, customerF.length)) : 0
        }} of {{formatNumber(customerF.length)}} entries
    </span>

    <ul style="margin-bottom: 0 !important;" uib-pagination boundary-links="true" total-items="customerF.length" num-pages="numPages" items-per-page="itemsPerPage" ng-model="currentPage" max-size="5" boundary-link-numbers="true" ng-change="pageChanged()"></ul>
</div>