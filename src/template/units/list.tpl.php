<div class="d-flex justify-content-between flex-wrap align-items-end flex-md-nowrap py-1">
    <div class="d-block mb-2 mb-md-0">
        <breadcrumbs></breadcrumbs>
        <div>
            <h2 class="greetings mb-0">Units</h2>
            <p class="sub-greetings mb-0">
                Manage unit types for cylinder containers.
            </p>
        </div>
    </div>
    <div>
        <div class="d-flex align-items-center justify-content-end mb-2" style="gap: 6px;">
            <div class="table-search" ng-disabled="isfiltering">
                <i class="ph-bold ph-magnifying-glass"></i>
                <input type="text" placeholder="Search" ng-model="search" ng-disabled="isfiltering">
            </div>
            <button class="btn btn-light-blue" style="padding: 10px 12px;" ng-click="unitModal()" ng-disabled="isfiltering">
                <i class="ph-bold ph-plus me-2"></i>
                Add New
            </button>
        </div>
    </div>
</div>
<div class="table-in mt-2" style="height:calc(100vh - 180px)">
    <table class="table align-middle table-bordered" id="table-data">
        <thead>
            <tr>
                <th width="1%" nowrap>#</th>
                <th width="10%" nowrap>Tags</th>
                <th nowrap>Description</th>
                <th width="8%" class="text-center dont-print">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-if="unitF.length == 0">
                <td colspan="5" class="text-center text-muted">No unit(s) found.</td>
            </tr>
            <tr ng-repeat="unit in unitF = (unitsList | filter:search) | limitTo:itemsPerPage:itemsPerPage*(currentPage-1) track by $index">
                <td>{{$index + 1 + itemsPerPage * (currentPage-1)}}</td>
                <td>{{unit.tags || '-N/A-'}}</td>
                <td>{{unit.descriptions || '-N/A-'}}</td>
                <td class="text-center dont-print">
                    <div class="d-flex align-items-center justify-content-center">
                        <button class="btn-table" type="button" ng-click="editUnit(unit)" tooltip="Edit">
                            <i class="ph-bold ph-pencil-simple-line"></i>
                        </button>
                        <button class="btn-table" ng-click="deleteUnit(unit)" tooltip="Delete">
                            <i class="ph-bold ph-trash text-danger"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- pagination -->
<table-pagenation
    items="unitF"
    current-page="currentPage"
    items-per-page="itemsPerPage"
    on-page-change="pageChanged()">

</table-pagenation>
<!-- <div class=" d-flex align-items-center justify-content-between pt-3">
    <span class="page-table-info">
        Showing {{
            unitF.length > 0 ? formatNumber((currentPage - 1) * itemsPerPage + 1) : 0
        }} to {{
            unitF.length > 0 ? formatNumber(Math.min(currentPage * itemsPerPage, unitF.length)) : 0
        }} of {{formatNumber(unitF.length)}} entries
    </span>

    <ul style="margin-bottom: 0 !important;" uib-pagination boundary-links="true" total-items="unitF.length" num-pages="numPages" items-per-page="itemsPerPage" ng-model="currentPage" max-size="5" boundary-link-numbers="true" ng-change="pageChanged()"></ul>
</div> -->