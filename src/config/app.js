angular
  .module("app", [
    "ui.router",
    "ngAnimate",
    "ngSanitize",
    "ngIdle",
    "ui.bootstrap",
    "oc.lazyLoad",
    "angular.filter",
    "recepuncu.ngSweetAlert2",
  ])
  .config([
    "$compileProvider",
    "$stateProvider",
    "$urlRouterProvider",
    "$locationProvider",
    "$httpProvider",
    "IdleProvider",
    "KeepaliveProvider",
    function (
      $compileProvider,
      $stateProvider,
      $urlRouterProvider,
      $locationProvider,
      $httpProvider,
      IdleProvider,
      KeepaliveProvider
    ) {
      $locationProvider.hashPrefix("");
      $urlRouterProvider.otherwise("/404");
      $httpProvider.interceptors.push("loadingInterceptor");

      $compileProvider.debugInfoEnabled(false);
      // $httpProvider.interceptors.push("nprogressInterceptor");
      // Always include cookies with every request (for PHP sessions)
      $httpProvider.defaults.withCredentials = true;

      IdleProvider.idle(60 * 60); // 1hr inactive = sync in backend
      IdleProvider.timeout(45); // 45 sec warning before logout
      IdleProvider.autoResume("notIdle");
      KeepaliveProvider.interval(60); // ping every 1 minute

      KeepaliveProvider.http("api/verify");

      $stateProvider.state("login", {
        url: "/login",
        templateUrl: "src/template/auth/login.tpl.php",
        controller: "authCtrl",
        resolve: {
          loadCtrl: function ($ocLazyLoad) {
            return $ocLazyLoad.load("src/template/auth/auth.ctrl.js");
          },
        },
        data: { breadcrumb: "Login", pageTitle: "GMEDAIRE | Login" },
      });
      $stateProvider.state("notfound", {
        url: "/404",
        templateUrl: "src/template/errors/404.tpl.php",
        data: { breadcrumb: "NotFound", pageTitle: "GMEDAIRE | 404 NotFound" },
      });

      // main app
      $stateProvider.state("app", {
        abstract: true,
        views: {
          "": { templateUrl: "src/template/layout.tpl.php" },
          "header@app": {
            templateUrl: "src/template/components/header.tpl.php",
          },
          "sidebar@app": {
            templateUrl: "src/template/components/sidebar.tpl.php",
          },
        },
      });

      $stateProvider.state("app.dashboard", {
        url: "/dashboard",
        templateUrl: "src/template/home/home.tpl.php",
        data: {
          breadcrumb: "Home",
          pageTitle: "GMEDAIRE | Dashboard",
          home: true,
        },
      });
      $stateProvider.state("app.cylinders", {
        url: "/cylinders",
        templateUrl: "src/template/cylinder/list.tpl.php",
        controller: "cylinderCrtl",
        resolve: {
          loadCtrl: function ($ocLazyLoad) {
            return $ocLazyLoad.load("src/template/cylinder/cylinder.ctrl.js");
          },
        },
        data: {
          breadcrumb: "Cylinders",
          pageTitle: "GMEDAIRE | Cylinders",
        },
      });
      $stateProvider.state("app.customers", {
        url: "/customers",
        templateUrl: "src/template/customers/list.tpl.php",
        controller: "customersCrtl",
        resolve: {
          loadCtrl: function ($ocLazyLoad) {
            return $ocLazyLoad.load("src/template/customers/customers.ctrl.js");
          },
        },
        data: {
          breadcrumb: "Customers",
          pageTitle: "GMEDAIRE | Customers",
        },
      });
      $stateProvider.state("app.settings", {
        abstract: true,
        data: {
          breadcrumb: "Settings",
          pageTitle: "GMEDAIRE | Settings",
        },
      });
      $stateProvider.state("app.settings.locations", {
        url: "/locations",
        templateUrl: "src/template/locations/list.tpl.php",
        controller: "locationsCrtl",
        resolve: {
          loadCtrl: function ($ocLazyLoad) {
            return $ocLazyLoad.load("src/template/locations/locations.ctrl.js");
          },
        },
        data: {
          breadcrumb: "Locations",
          pageTitle: "GMEDAIRE | Locations",
        },
      });
      $stateProvider.state("app.settings.units", {
        url: "/units",
        templateUrl: "src/template/units/list.tpl.php",
        controller: "unitsCrtl",
        resolve: {
          loadCtrl: function ($ocLazyLoad) {
            return $ocLazyLoad.load("src/template/units/units.ctrl.js");
          },
        },
        data: {
          breadcrumb: "Units",
          pageTitle: "GMEDAIRE | Units",
        },
      });
      $stateProvider.state("app.settings.categories", {
        url: "/categories",
        templateUrl: "src/template/categories/list.tpl.php",
        controller: "categoriesCrtl",
        resolve: {
          loadCtrl: function ($ocLazyLoad) {
            return $ocLazyLoad.load(
              "src/template/categories/categories.ctrl.js"
            );
          },
        },
        data: {
          breadcrumb: "Categories",
          pageTitle: "GMEDAIRE | Categories",
        },
      });
      $stateProvider.state("app.settings.types", {
        url: "/types",
        templateUrl: "src/template/types/list.tpl.php",
        controller: "typesCrtl",
        resolve: {
          loadCtrl: function ($ocLazyLoad) {
            return $ocLazyLoad.load("src/template/types/types.ctrl.js");
          },
        },
        data: {
          breadcrumb: "Types Of Cylinder",
          pageTitle: "GMEDAIRE | Types Of Cylinder",
        },
      });

      // movement
      $stateProvider.state("app.delivery", {
        abstract: true,
        templateUrl: "src/template/delivery/layout.tpl.php",
        controller: "deliveryCtrl",
        resolve: {
          loadCtrl: function ($ocLazyLoad) {
            return $ocLazyLoad.load("src/template/delivery/delivery.ctrl.js");
          },
        },
        data: {
          breadcrumb: "Delivery",
          pageTitle: "GMEDAIRE | Delivery",
        },
      });
      $stateProvider.state("app.delivery.list", {
        url: "/delivery/list",
        templateUrl: "src/template/delivery/list.tpl.php",
        data: {
          breadcrumb: "List",
          pageTitle: "GMEDAIRE | Delivery-List",
        },
      });
      $stateProvider.state("app.delivery.edit", {
        url: "/delivery/:id/edit",
        templateUrl: "src/template/delivery/edit.tpl.php",
        data: {
          breadcrumb: "Edit",
          pageTitle: "GMEDAIRE | Delivery-Edit",
        },
      });

      // set to url to html5
      // $locationProvider.html5Mode(true);
    },
  ])
  .run(function (
    $transitions,
    $state,
    AuthService,
    Idle,
    Keepalive, // still injected, but revert to normal keepalive interval behavior
    $rootScope,
    SweetAlert2
  ) {
    // 🧱 Set page title on route change
    $transitions.onSuccess({}, function (trans) {
      const title = trans.to().data && trans.to().data.pageTitle;
      document.title = title || "GMEDAIRE";
    });

    // Route Guard: Protect all except login
    $transitions.onBefore({ to: (s) => s.name !== "login" }, function () {
      if (!AuthService.isLoggedIn()) {
        Idle.unwatch();
        Keepalive.stop();
        return $state.target("login");
      }
      return AuthService.verify()
        .then(() => {
          Idle.watch();
          Keepalive.start();
          return true;
        })
        .catch(() => {
          Idle.unwatch();
          Keepalive.stop();
          return $state.target("login");
        });
    });

    // Prevent logged-in users from accessing login page
    $transitions.onBefore({ to: "login" }, function () {
      if (AuthService.isLoggedIn()) {
        return AuthService.verify()
          .then(() => $state.target("app.dashboard"))
          .catch(() => true);
      }
      return true;
    });

    // ng-idle event listeners
    let idleWarningAlert = null;
    let idleTimeoutTriggered = false;

    $rootScope.$on("IdleStart", function () {
      console.warn("⏳ User is idle");
      idleTimeoutTriggered = false;
      idleWarningAlert = SweetAlert2.fire({
        title: "Inactive Warning",
        text: "You've been inactive for 1 hour. You will be automatically logged out in 45 seconds unless you continue.",
        icon: "warning",
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: "Continue",
        confirmButtonColor: "#848CB1",
        cancelButtonText: "Logout",
        timer: 45000,
        timerProgressBar: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
          // Optionally focus the alert or add a timer description
        },
        willClose: () => {
          idleWarningAlert = null;
        },
      }).then((result) => {
        if (idleTimeoutTriggered) return; // Timeout event already handled logout
        if (result.isConfirmed) {
          // User chose to continue. Reset idle watcher
          Idle.watch();
        } else if (result.isDismissed || result.isDenied || result.isCanceled) {
          // User chose to logout or dismissed
          Idle.unwatch();
          AuthService.logout().finally(() => {
            $state.go("login");
          });
        }
      });
    });

    $rootScope.$on("IdleEnd", function () {
      console.log("🟢 User active again");
      // Close SweetAlert2 warning if still open
      if (idleWarningAlert && typeof idleWarningAlert.close === "function") {
        idleWarningAlert.close();
        idleWarningAlert = null;
      } else if (
        window.Swal &&
        window.Swal.isVisible &&
        window.Swal.isVisible()
      ) {
        window.Swal.close(); // fallback in case
      }
    });

    $rootScope.$on("IdleTimeout", function () {
      console.warn("⛔ Idle timeout reached — logging out");
      idleTimeoutTriggered = true;
      // Close warning if still present
      if (idleWarningAlert && typeof idleWarningAlert.close === "function") {
        idleWarningAlert.close();
        idleWarningAlert = null;
      } else if (
        window.Swal &&
        window.Swal.isVisible &&
        window.Swal.isVisible()
      ) {
        window.Swal.close(); // fallback in case
      }
      Idle.unwatch();
      AuthService.logout().finally(() => {
        $state.go("login");
      });
    });

    $rootScope.$on("Keepalive", () => {
      // Keepalive pings will now fire every interval (by default, every 1 min; verifySession endpoint)
      // console.log("Keepalive ping");
    });

    // On app bootstrap: verify session and appropriately begin/stop ng-idle & keepalive
    if (AuthService.isLoggedIn()) {
      AuthService.verify()
        .then(() => {
          Idle.watch();
          Keepalive.start();
        })
        .catch(() => {
          Idle.unwatch();
          Keepalive.stop();
        });
    } else {
      Idle.unwatch();
      Keepalive.stop();
    }
  })
  .controller(
    "ctrl",
    function ($scope, AuthService, SweetAlert2, $http, $state) {
      let vm = $scope;
      vm.state = $state;
      vm.user = AuthService.getUser();
      vm.notifcount = 100;
      vm.handleLogout = function () {
        SweetAlert2.fire({
          title: "Continue to logout",
          text: `Your about to logout from the system!`,
          icon: "question",
          allowOutsideClick: true,
          showCancelButton: true,
          confirmButtonColor: "#e43333",
          cancelButtonColor: "#d6d8e5",
          cancelButtonClass: "text-dark",
          confirmButtonText: `Sign out`,
          position: "top",
        }).then((result) => {
          if (result.value) {
            AuthService.logout();
          }
        });
      };

      vm.randomColor = function (letter) {
        const char = letter.toUpperCase();

        // Use charCode as part of the seed
        const base = char.charCodeAt(0) * Math.random();

        // Randomize hue but keep it in a nice range (0–360)
        const hue = Math.floor((base * 137.5) % 360);
        // Keep saturation and lightness within nice, readable ranges
        const saturation = 60 + Math.floor(Math.random() * 20); // 60–80%
        const lightness = 45 + Math.floor(Math.random() * 15); // 45–60%

        return `hsl(${hue}, ${saturation}%, ${lightness}%)`;
      };
    }
  );
