<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="login-card">
        <form ng-submit="login(users)">
            <div class="title mb-3">
                <div><img src="src/assets/images/logo.png" alt="" width="200"></div>
                Cylinder's Inventory System
            </div>
            <div class="form-floating mb-3">
                <input type="text" ng-disabled="isloading" class="form-control" id="floatingEmail" placeholder="name@example.com"
                    ng-model="username">
                <label for="floatingEmail">Enter username/email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" ng-disabled="isloading" class="form-control" id="floatingPassword" placeholder="Password"
                    ng-model="password">
                <label for="floatingPassword">Enter password</label>
            </div>
            <div class="d-flex align-items-center justify-content-end mb-2">
                <a href="">Forgot password?</a>
            </div>
            <button class="btn btn-light-blue py-3 w-100 mt-2" ng-disabled="isloading">
                <div ng-if="isloading">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <!-- <span role="status">Signing In...</span> -->
                </div>
                <div class="text-white" ng-if="!isloading">Sign In</div>
            </button>
        </form>
    </div>
</div>