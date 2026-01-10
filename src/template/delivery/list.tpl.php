<div class="d-flex align-items-center justify-content-between">
    <div class="mb-2">
        <breadcrumbs></breadcrumbs>
        <h2 class="greetings mb-0">Delivery List</h2>
        <p class="sub-greetings mb-0">
            Create and track deliveries and returns for cylinders
        </p>
    </div>
    <div class="mb-2">
        <!-- <a ui-sref="app.movement.edit({id: 2})" ui-sref-opts="{reload: true}">Edit</a> -->
        <div class="d-flex align-items-center justify-content-end mb-2" style="gap: 6px;">
            <button class="btn btn-light-blue" style="padding: 10px 12px;" ng-click="deliveryModal()" ng-disabled="isfiltering">
                <i class="ph-bold ph-plus me-2"></i>
                Add New
            </button>
            <button class="btn btn-light border" style="padding: 10px 14px;" tooltip='Export' ng-click="exportToExcel('table-data')" ng-disabled="isfiltering">
                <i class="ph-bold ph-cloud-arrow-down"></i>
            </button>
            <button class="btn btn-light border" style="padding: 10px 14px;" tooltip='Print' ng-click="print()" ng-disabled="isfiltering">
                <i class="ph-bold ph-printer"></i>
            </button>
        </div>
    </div>
</div>
<div class="d-flex align-items-end justify-content-between">
    <div class="table-search" ng-disabled="isfiltering">
        <i class="ph-bold ph-magnifying-glass"></i>
        <input type="text" placeholder="Search" ng-model="search" ng-disabled="isfiltering">
    </div>
    <div class="d-flex align-items-center justify-content-end" style="gap: 6px;">
        <div class="form-floating">
            <select class="form-select" id="filterStatus" ng-model="fstatus" ng-disabled="isfiltering">
                <option ng-repeat="tab in filterItemStatus" ng-value="tab.value">{{tab.label}}</option>
            </select>
            <label for="filterStatus">Status</label>
        </div>
        <div class="form-floating">
            <select class="form-select" id="filterCustomer" ng-model="fcustomer" ng-disabled="isfiltering">
                <option ng-value="0">Select Customer</option>
                <option ng-repeat="c in customersList" ng-value="c.id">{{c.descriptions}}</option>
            </select>
            <label for="filterCustomer">Customer</label>
        </div>
        <div class="form-floating">
            <input type="date" class="form-control" id="deliveryFrom" placeholder="From" ng-model="fdeliverFrom" ng-disabled="isfiltering">
            <label for="deliveryDateFrom">Delivery Date From</label>
        </div>
        <div class="form-floating">
            <input type="date" class="form-control" id="deliveryTo" placeholder="To" ng-model="fdeliverTo" ng-disabled="isfiltering">
            <label for="deliveryDateTo">Delivery Date To</label>
        </div>
        <button class="btn btn-light border" style="padding: 12px 16px;"
            ng-click="getDeliveryList(fdeliverFrom, fdeliverTo, fstatus, fcustomer)" ng-disabled="isfiltering">
            <i class="ph-bold ph-funnel-simple"></i>
        </button>
    </div>
</div>

<!-- table -->
<div class="table-in mt-3" style="height:calc(100vh - 230px)">
    <table class="table align-middle table-bordered">
        <thead>
            <tr>
                <th class="text-center" width="1%" nowrap>#</th>
                <th width="10%" nowrap>Delivery No.</th>
                <th width="10%" nowrap>Delivery</th>
                <th width="10%" nowrap>Requested</th>
                <th width="10%" nowrap>Delivered</th>
                <th>Customer</th>
                <th width="10%" class="text-center">Status</th>
                <th width="5%" class="text-end">Cylinders</th>
                <th class="text-center" width="5%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="delivery in deliveryF = (deliveryList | filter:search) | limitTo:itemsPerPage:itemsPerPage*(currentPage-1) track by $index">
                <td class="text-center">{{ $index + 1 + itemsPerPage * (currentPage-1) }}</td>
                <td class="text-ellipsis">{{delivery.delivery_no}}</td>
                <td>{{delivery.delivery_date | date: 'MM/dd/yyyy'}}</td>
                <td>{{delivery.request_date | date: 'MM/dd/yyyy'}}</td>
                <td>{{delivery.delivered_date ? (delivery.delivered_date | date: 'MM/dd/yyyy') : '-'}}</td>
                <td>
                    {{delivery.descriptions}}
                    <div class="text-muted small" ng-if="delivery.customer_address == 0">
                        {{delivery.location_full_address}}
                    </div>
                    <div class="text-muted small" ng-if="delivery.customer_address > 0">
                        {{delivery.location_address}}
                    </div>
                </td>
                <td nowrap class="text-center">
                    <span class="status-badge {{ deliveryStatusClass(delivery.status) }}">
                        {{ deliveryStatus(delivery.status) }}
                    </span>
                </td>
                <td class="text-end">
                    {{delivery.items_total || 0}}
                </td>
                <td class="text-center">
                    <div class="dropdown dropdown-tbl w-100">
                        <button class="btn-table dropdown-toggle text-center w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ph-fill ph-dots-three-outline"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <button class="dropdown-item" type="button" ng-click="editDelivery(delivery.id)">
                                    <i class="ph-bold ph-pencil-simple-line"></i>
                                    <span>Edit Delivery</span>
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item" type="button" ng-click="cancelDeliveryItems(delivery.id)">
                                    <i class="ph-bold ph-package"></i>
                                    <span>Cancel Delivery</span>
                                </button>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <button class="dropdown-item delete" ng-click="deleteDelivery(delivery.id)">
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
            deliveryF.length > 0 ? formatNumber((currentPage - 1) * itemsPerPage + 1) : 0
        }} to {{
            deliveryF.length > 0 ? formatNumber(Math.min(currentPage * itemsPerPage, deliveryF.length)) : 0
        }} of {{formatNumber(deliveryF.length)}} entries
    </span>

    <ul style="margin-bottom: 0 !important;" uib-pagination boundary-links="true" total-items="deliveryF.length" num-pages="numPages" items-per-page="itemsPerPage" ng-model="currentPage" max-size="5" boundary-link-numbers="true" ng-change="pageChanged()"></ul>
</div>