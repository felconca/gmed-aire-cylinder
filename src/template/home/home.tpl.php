<div class="mb-4">
    <h3 class="greetings">
        Hello, {{user.firstname}}
    </h3>
    <div class="sub-greetings">
        Track Cylinders Movement and Data
    </div>
</div>
<hr>
<!-- statuses -->
<div class="dashboard-overview mb-3">

    <div class="metrics-info">
        <div class="icons">
            <i class="ph-bold ph-jar-label"></i>
        </div>
        <div class="ms-2">
            <div class="title">Total Cylinders</div>
            <div class="number d-flex align-items-center" style="gap: 6px;">
                {{120 | number:0}}
            </div>
        </div>
    </div>

    <!-- <hr class="vr"> -->
    <div class="metrics-info">
        <div class="icons green"><i class="ph-bold ph-seal-check"></i></div>
        <div class="ms-2">
            <div class="title">Available</div>
            <div class="number d-flex align-items-center" style="gap: 6px;">
                {{15 | number:0}}
            </div>
        </div>
    </div>

    <!-- <hr class="vr"> -->
    <div class="metrics-info">
        <div class="icons red"><i class="ph-bold ph-box-arrow-down"></i></div>
        <div class="ms-2">
            <div class="title">In Used</div>
            <div class="number d-flex align-items-center" style="gap: 6px;">
                {{2 | number:0}}

            </div>
        </div>
    </div>

    <!-- <hr class="vr"> -->
    <div class="metrics-info">
        <div class="icons yellow"><i class="ph-bold ph-wrench"></i></div>
        <div class="ms-2">
            <div class="title">Under Maintenance</div>
            <div class="number d-flex align-items-center" style="gap: 6px;">
                {{2210 | number:0}}
            </div>
        </div>
    </div>
</div>
<hr>
<!-- alerts and activities -->
<div class="row mt-4">
    <!-- recent activities -->
    <div class=" col-lg-8">

        <div class="d-flex justify-content-between align-items-center">
            <h5 class="greetings mb-0 mb-2">
                <i class="ph-bold ph-clock-counter-clockwise me-1"></i>
                Recent Activities
            </h5>
        </div>

        <div class="table-in" style="height:calc(100vh - 250px)">
            <table class="table align-middle table-bordered">
                <thead>
                    <tr>
                        <th width="10%" nowrap>Date</th>
                        <th>Cylinder Info</th>
                        <th class="text-center" width="15%" nowrap>Action</th>
                        <th width="15%" nowrap>Location</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- alerts and notifications -->
    <div class="col-lg-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="greetings mb-0 mb-2">
                <i class="ph-bold ph-warning-circle me-1 text-danger"></i>Alerts
            </h5>
            <small class="text-muted px-1" style="cursor: pointer;">See all</small>
        </div>
        <div class="table-in" style="height:calc(100vh - 250px)">
            <table class="table align-middle table-bordered">
                <thead>
                    <tr>
                        <th nowrap>Alerts</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>