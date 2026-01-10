<div id="sidebar">
    <div class="header">
        <div class="user-profile">
            <div class="avatar">
                <img src="src/assets/images/boy.png" alt="">
            </div>
            <div class="users">
                <div class="name">{{user.firstname}} {{user. lastname}}</div>
                <small class="type">{{user.user_type}}</small>
            </div>
        </div>
    </div>
    <ul class="menu">
        <li ui-sref-active="active">
            <a ui-sref="app.dashboard" ui-sref-opts="{reload: true}">
                <i class="ph-bold ph-squares-four"></i><span>Dashboard</span>
            </a>
        </li>
        <li ui-sref-active="active">
            <a ui-sref="app.cylinders" ui-sref-opts="{reload: true}">
                <i class="ph-bold ph-jar"></i><span>Cylinders</span>
            </a>
        </li>
        <li ui-sref-active="active">
            <a ui-sref="app.customers" ui-sref-opts="{reload: true}">
                <i class="ph-bold ph-users"></i><span>Customers</span>
            </a>
        </li>
        <li ui-sref-active="active">
            <a ui-sref="app.maintenance" ui-sref-opts="{reload: true}">
                <i class="ph-bold ph-wrench"></i><span>Maintenance</span>
            </a>
        </li>
        <li ng-class="{active: state.includes('app.delivery')}">
            <a ui-sref="app.delivery.list" ui-sref-opts="{reload: true}">
                <i class="ph-bold ph-truck-trailer"></i><span>Delivery</span>
            </a>
        </li>
        <li ui-sref-active="active">
            <a ui-sref="app.reports" ui-sref-opts="{reload: true}">
                <i class="ph-bold ph-files"></i><span>Reports</span>
            </a>
        </li>

        <li ng-class="{active: state.includes('app.settings')}">
            <a ng-click="menu.settings = !menu.settings" class=" justify-content-between"
                data-bs-toggle="collapse" data-bs-target="#settingsCollapse" aria-expanded="false" aria-controls="transactionsCollapse">
                <span class="d-flex align-items-center" style="gap:10px">
                    <i class="ph-bold ph-gear-six"></i><span>Settings</span>
                </span>
                <div class="indicator">
                    <i class="ph-bold"
                        ng-class="{'ph-minus': menu.settings, 'ph-plus': !menu.settings}">
                    </i>
                </div>
            </a>
            <ul class="sub-menu collapse" id="settingsCollapse">
                <li ui-sref-active="active"><a ui-sref="app.settings.locations" ui-sref-opts="{reload: true}">Locations</a></li>
                <li ui-sref-active="active"><a ui-sref="app.settings.units" ui-sref-opts="{reload: true}">Units</a></li>
                <li ui-sref-active="active"><a ui-sref="app.settings.categories" ui-sref-opts="{reload: true}">Categories</a></li>
                <li ui-sref-active="active"><a ui-sref="app.settings.types" ui-sref-opts="{reload: true}">Types</a></li>
                <li ui-sref-active="active"><a ui-sref="app.settings.backup-restore" ui-sref-opts="{reload: true}">Backup/Restore</a></li>
            </ul>
        </li>

    </ul>
    <div class="profile">
        <button class="documentation">
            <i class="ph-bold ph-info"></i>Help & Information
        </button>
        <button class="logout" ng-click="handleLogout()">
            <i class="ph-bold ph-sign-out"></i>Sign out
        </button>
    </div>
</div>