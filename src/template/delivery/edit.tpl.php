<div class="d-flex align-items-center justify-content-between">
    <div class="mb-2">
        <breadcrumbs></breadcrumbs>
        <h3 class="greetings mb-0 d-flex align-items-center text-uppercase">{{delivery_info.delivery_no}}
            <span class="ms-2 status-badge {{ deliveryStatusClass(delivery_info.status) }}">
                {{ deliveryStatus(delivery_info.status) }}
            </span>
        </h3>
        <p class="sub-greetings mb-0">
            Create By: <small>{{delivery_info.users}}</small>
            | Date: <small>{{toISO(delivery_info.created_at) | date:'MM/dd/yyyy'}}</small>
        </p>
    </div>
    <div class="mb-2">
        <!-- <a ui-sref="app.movement.edit({id: 2})" ui-sref-opts="{reload: true}">Edit</a> -->
        <div class="d-flex align-items-center justify-content-end mb-2" style="gap: 6px;">
            <button class="btn btn-light-blue" style="padding: 10px 12px;"
                ng-click="updateDelivery(delivery_info)"
                ng-disabled="isloading">
                Save Changes
            </button>
            <button class="btn btn-light border" style="padding: 10px 14px;" tooltip='Cancel'
                ng-click="cancelDelivery(delivery_info.id)" ng-disabled="isloading">
                <i class="ph-bold ph-prohibit"></i>
            </button>
            <button class="btn btn-light border" style="padding: 10px 14px;" tooltip='Print' ng-click="print()"
                ng-disabled="isloading">
                <i class="ph-bold ph-printer"></i>
            </button>
            <button class="btn btn-light border" style="padding: 10px 14px;" tooltip='Delete'
                ng-click="deleteDelivery(delivery_info.id)" ng-disabled="isloading">
                <i class="ph-bold ph-trash text-danger"></i>
            </button>

        </div>
    </div>
</div>
<!-- Delivery info -->
<div class="alert alert-warning d-flex align-items-center rounded-3 mb-3" role="alert">
    <i class="ph-bold ph-info me-2 fs-2 text-warning"></i>
    <div>
        <strong>Note:</strong> All fields marked with
        <span class="text-danger">*</span> are required for delivery.
        If no address is selected, the default address and contact will be set using the customer's main information.
    </div>
</div>
<div class="row">
    <!-- Customers -->
    <div class="col-lg-3 pe-2">
        <div class="form-floating mb-3">
            <select class="form-select" id="deliveryCustomer"
                ng-class="{'is-invalid': isInvalid && !delivery_info.customer_id}"
                ng-model="delivery_info.customer_id"
                ng-disabled="isloading || delivery_info.status == 'delivered' 
                || delivery_info.status == 'cancelled'"
                ng-change="onChangeCustomer(delivery_info.customer_id)">
                <option ng-value="0">Select Customer</option>
                <option ng-value="c.id" ng-repeat="c in customersList">{{c.descriptions}}</option>
            </select>
            <label for="deliveryCustomer">Customer <span class="text-danger">*</span></label>
            <small class="invalid-feedback" ng-if="isInvalid && !delivery_info.customer_id">Please select a customer</small>
        </div>
    </div>
    <!-- Address -->
    <div class="col-lg-3 px-2">

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
    </div>
    <div class="col-lg-3 ps-2">
        <div class="form-floating">
            <input type="date" class="form-control" id="requestDate"
                ng-class="{'is-invalid': isInvalid && !delivery_info.request_date}"
                ng-model="delivery_info.request_date" ng-disabled="isloading" date-input>
            <label for="requestDate">Request Date <span class="text-danger">*</span></label>
            <small class="invalid-feedback" ng-if="isInvalid && !delivery_info.request_date">>Request Date Required</small>
        </div>
    </div>
    <div class="col-lg-3 px-2">
        <div class="form-floating">
            <input type="date" class="form-control" id="deliveryDate"
                ng-class="{'is-invalid': isInvalid && !delivery_info.delivery_date}"
                ng-model="delivery_info.delivery_date" ng-disabled="isloading" date-input>
            <label for="deliveryDate">Delivery Date <span class="text-danger">*</span></label>
            <small class="invalid-feedback" ng-if="isInvalid && !delivery_info.delivery_date">Delivery Date Required</small>
        </div>
    </div>
</div>
<!-- items -->
<div class="d-flex align-items-center justify-content-between">
    <div class="table-search" ng-disabled="isloading">
        <i class="ph-bold ph-magnifying-glass"></i>
        <input type="text" placeholder="Search" ng-model="search_items" ng-disabled="isloading">
    </div>
    <div class="d-flex align-items-center justify-content-center" style="gap:6px">
        <button class="btn btn-dark-blue" style="padding: 10px 12px;" ng-click="cylinderModal()"
            ng-disabled="isloading || delivery_info.status !== 'pending'">
            Add Cylinder
        </button>
        <button class="btn btn-light border" style="padding: 10px 14px;" tooltip='Remove Selected'
            ng-click="deleteItems(selectedItems)" ng-disabled="isloading || selectedItems.length == 0">
            <i class="ph-bold ph-x-circle text-danger"></i>
        </button>
    </div>
</div>
<div class="table-in mt-2" style="height:calc(100vh - 390px)">
    <table class="table align-middle table-bordered">
        <thead>
            <tr>
                <th class="text-center" width="1%" nowrap>
                    <input class="form-check-input fs-6" type="checkbox" ng-model="selectAll"
                        ng-click="selectAllItems(fdlvItems)" ng-disabled="deliveryItemsList.length == 0">
                </th>
                <th width="15%" nowrap>Barcode</th>
                <th width="5%" nowrap>Serial</th>
                <th width="5%" nowrap>Categories</th>
                <th width="10%" nowrap>Types</th>
                <th width="10%" nowrap>Capacity</th>
                <th class="text-center" width="5%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="items in fdlvItems = (deliveryItemsList | filter:search) | limitTo:itemsPerPage:itemsPerPage*(currentPage-1) track by $index">
                <td class="text-center">
                    <input class="form-check-input" type="checkbox" ng-model="items.selected" ng-click="selectItem(items)">
                </td>
                <td>{{items.barcode}}</td>
                <td>{{items.serial_no}}</td>
                <td>{{items.categories}}</td>
                <td>{{items.types}}</td>
                <td>{{items.capacity}}({{items.units}})</td>
                <td class="text-center">
                    <button class="btn-table text-danger text-center w-100" ng-click="deleteItems([items])">Remove</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="form-floating mt-3">
            <textarea class="form-control" placeholder="Notes" id="deliveryNotes"
                ng-model="delivery_info.notes" style="height: 80px; resize: none;" ng-disabled="isloading"></textarea>
            <label for="deliveryNotes">Notes</label>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-end mt-3">
            <!-- <pre>You are currently on page {{currentPage}}</pre> -->
            <ul uib-pager total-items="fdlvItems.length"
                num-pages="numPages" items-per-page="itemsPerPage"
                ng-change="changePage(deliveryItemsList)"
                ng-model="currentPage"></ul>
        </div>
    </div>
</div>