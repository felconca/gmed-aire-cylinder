angular
  .module("app")
  .controller(
    "locationsCrtl",
    function ($scope, $http, $state, $uibModal, SweetAlert2, AuthService) {
      let vm = $scope;
      let vs = $state;
      let loggedInUser = AuthService.getUser();

      const LOCATION_INFO = () => ({
        id: 0,
        tags: "",
        descriptions: "",
        default_1: 0,
      });

      Object.assign(vm, {
        locationsList: [],
        loggedInUser: loggedInUser,
        isloading: false,
        itemsPerPage: 50,
        currentPage: 1,
        location_info: LOCATION_INFO(),
        isInvalid: false,
        Math: window.Math,
      });

      vm.getLocationsList = () => {
        $http
          .get("api/locations/list")
          .then((response) => {
            vm.locationsList = response.data;
          })
          .catch((error) => {
            console.error("Failed to fetch locations list", error);
            vm.locationsList = [];
          });
      };
      vm.getLocationsList();

      // Add or update location
      vm.saveLocation = (l) => {
        const requiredFields = ["tags", "descriptions"];
        let isUpdate = !!l.id;
        let hasEmpty = requiredFields.some(
          (field) => !l[field] || l[field].toString().trim() === ""
        );
        if (hasEmpty) {
          vm.isInvalid = true;
          return;
        }
        vm.isloading = true;

        let data = {
          tags: l.tags,
          descriptions: l.descriptions,
          default_1: l.default_1,
        };

        if (isUpdate) data.id = l.id;

        let url = isUpdate ? "api/locations/update" : "api/locations/add";

        $http
          .post(url, data)
          .then(function (response) {
            if (!isUpdate && response.data && response.data.location_id) {
              vm.closeModal();
              vm.getLocationsList();
              Toasty.showToast(
                "Added",
                "Location added successfully.",
                `<i class="ph-fill ph-check-circle"></i>`,
                3000
              );
            } else if (isUpdate && response.data && response.data.success) {
              vm.closeModal();
              vm.getLocationsList();
              Toasty.showToast(
                "Updated",
                "Location updated successfully.",
                `<i class="ph-fill ph-check-circle"></i>`,
                3000
              );
            }
          })
          .catch(function (error) {
            console.error(
              isUpdate ? "Failed to update location" : "Failed to add location",
              error
            );
            Toasty.showToast(
              "Error",
              isUpdate
                ? "Failed to update location."
                : "Failed to add location.",
              `<i class="ph-fill ph-x-circle text-danger"></i>`,
              3000
            );
          })
          .finally(function () {
            vm.isloading = false;
          });
      };
      vm.checkDefault = () => {
        if (vm.location_info.default_1 === 1) {
          // Use SweetAlert2 from parameter
          SweetAlert2.fire({
            title: "Set to default?",
            text: "Setting this location as default will change the default location in settings. Continue?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#848CB1",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, set as default",
            cancelButtonText: "Cancel",
          }).then((result) => {
            if (result.isConfirmed) {
              vm.location_info.default_1 = 1;
            } else {
              vm.location_info.default_1 = 0;
            }
          });
        }
      };
      // Edit
      vm.editLocation = (item) => {
        vm.locationModal();
        vm.location_info = angular.copy(item);
      };
      // Delete
      vm.deleteLocation = (items) => {
        if (items.default_1 === 1) {
          Toasty.showToast(
            "Error",
            "Cannot delete the default location. Please unset it as default before deleting.",
            `<i class="ph-fill ph-x-circle text-danger"></i>`,
            3000
          );
          return;
        }
        SweetAlert2.fire({
          title: "Delete?",
          text: "This will permanently delete this location.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#848CB1",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "Cancel",
        }).then((result) => {
          if (result.isConfirmed) {
            $http
              .post("api/locations/delete", { id: items.id })
              .then((response) => {
                vm.getLocationsList();
                Toasty.showToast(
                  "Deleted",
                  "Location deleted successfully.",
                  `<i class="ph-fill ph-check-circle"></i>`,
                  3000
                );
              })
              .catch((error) => {
                console.error("Failed to delete location", error);
                Toasty.showToast(
                  "Deleted",
                  "Location deleted successfully.",
                  `<i class="ph-fill ph-x-circle text-danger"></i>`,
                  3000
                );
              });
          }
        });
      };

      vm.locationModal = function (id) {
        let $uibModalInstance = $uibModal.open({
          animation: true,
          templateUrl: "src/template/locations/modal.tpl.php",
          scope: vm,
          backdrop: "static",
        });
        vm.closeModal = function () {
          vm.location_info = {
            tags: "",
            descriptions: "",
            default_1: 0,
          };
          $uibModalInstance.close();
        };
      };

      vm.formatNumber = (n) => n.toLocaleString();
      vm.toISO = function (dateStr) {
        const d = new Date(dateStr);
        if (isNaN(d)) {
          console.warn("Invalid date:", dateStr);
          return null;
        }
        return d.toISOString();
      };
    }
  );
