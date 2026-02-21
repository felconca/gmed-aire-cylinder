angular.module("app").controller("unitsCrtl", function ($scope, $http, $state, $uibModal, SweetAlert2, AuthService) {
  let vm = $scope;
  let vs = $state;
  let loggedInUser = AuthService.getUser();

  // Unit Info model
  const UNIT_INFO = () => ({
    id: 0,
    tags: "",
    descriptions: "",
  });

  Object.assign(vm, {
    unitsList: [],
    loggedInUser: loggedInUser,
    isloading: false,
    itemsPerPage: 50,
    currentPage: 1,
    unit_info: UNIT_INFO(),
    isInvalid: false,
    Math: window.Math,
  });

  // Fetch list of units
  vm.getUnitsList = () => {
    $http
      .get("api/units/list")
      .then((response) => {
        vm.unitsList = response.data;
      })
      .catch((error) => {
        console.error("Failed to fetch units list", error);
        vm.unitsList = [];
      });
  };
  vm.getUnitsList();

  // Add or update unit
  vm.saveUnit = (u) => {
    const requiredFields = ["tags", "descriptions"];
    let isUpdate = !!u.id;
    let hasEmpty = requiredFields.some((field) => !u[field] || u[field].toString().trim() === "");
    if (hasEmpty) {
      vm.isInvalid = true;
      return;
    }
    vm.isloading = true;

    let data = {
      tags: u.tags,
      descriptions: u.descriptions,
    };

    if (isUpdate) data.id = u.id;

    let url = isUpdate ? "api/units/update" : "api/units/add";

    $http
      .post(url, data)
      .then(function (response) {
        if (!isUpdate && response.data && response.data.unit_id) {
          vm.closeModal();
          vm.getUnitsList();
          Toasty.showToast("Added", "Unit added successfully.", `<i class="ph-fill ph-check-circle"></i>`, 3000);
        } else if (isUpdate && response.data && response.data.success) {
          vm.closeModal();
          vm.getUnitsList();
          Toasty.showToast("Updated", "Unit updated successfully.", `<i class="ph-fill ph-check-circle"></i>`, 3000);
        }
      })
      .catch(function (error) {
        console.error(isUpdate ? "Failed to update unit" : "Failed to add unit", error);
        Toasty.showToast(
          "Error",
          isUpdate ? "Failed to update unit." : "Failed to add unit.",
          `<i class="ph-fill ph-x-circle text-danger"></i>`,
          3000
        );
      })
      .finally(function () {
        vm.isloading = false;
      });
  };

  // Edit
  vm.editUnit = (item) => {
    vm.unitModal();
    vm.unit_info = angular.copy(item);
  };

  // Delete
  vm.deleteUnit = (item) => {
    SweetAlert2.fire({
      title: "Delete?",
      text: "This will permanently delete this unit.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#848CB1",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        $http
          .post("api/units/delete", { id: item.id })
          .then((response) => {
            vm.getUnitsList();
            Toasty.showToast("Deleted", "Unit deleted successfully.", `<i class="ph-fill ph-check-circle"></i>`, 3000);
          })
          .catch((error) => {
            console.error("Failed to delete unit", error);
            Toasty.showToast(
              "Error",
              "Failed to delete unit.",
              `<i class="ph-fill ph-x-circle text-danger"></i>`,
              3000
            );
          });
      }
    });
  };

  vm.unitModal = function (id) {
    let $uibModalInstance = $uibModal.open({
      animation: true,
      templateUrl: "src/template/units/modal.tpl.php",
      scope: vm,
      backdrop: "static",
    });
    vm.closeModal = function () {
      vm.unit_info = {
        tags: "",
        descriptions: "",
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
});
