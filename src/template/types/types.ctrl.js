angular
  .module("app")
  .controller(
    "typesCrtl",
    function ($scope, $http, $state, $uibModal, SweetAlert2, AuthService) {
      let vm = $scope;
      let vs = $state;
      let loggedInUser = AuthService.getUser();

      // Equivalent to LOCATION_INFO, but for types
      const TYPE_INFO = () => ({
        id: 0,
        tags: "",
        descriptions: "",
      });

      Object.assign(vm, {
        typesList: [],
        loggedInUser: loggedInUser,
        isloading: false,
        itemsPerPage: 50,
        currentPage: 1,
        type_info: TYPE_INFO(),
        isInvalid: false,
        Math: window.Math,
      });

      // Fetch list of types
      vm.getTypesList = () => {
        $http
          .get("api/types/list")
          .then((response) => {
            vm.typesList = response.data;
          })
          .catch((error) => {
            console.error("Failed to fetch types list", error);
            vm.typesList = [];
          });
      };
      vm.getTypesList();

      // Add or update type
      vm.saveType = (t) => {
        const requiredFields = ["tags", "descriptions"];
        let isUpdate = !!t.id;
        let hasEmpty = requiredFields.some(
          (field) => !t[field] || t[field].toString().trim() === ""
        );
        if (hasEmpty) {
          vm.isInvalid = true;
          return;
        }
        vm.isloading = true;

        let data = {
          tags: t.tags,
          descriptions: t.descriptions,
        };

        if (isUpdate) data.id = t.id;

        let url = isUpdate ? "api/types/update" : "api/types/add";

        $http
          .post(url, data)
          .then(function (response) {
            if (!isUpdate && response.data && response.data.type_id) {
              vm.closeModal();
              vm.getTypesList();
              Toasty.showToast(
                "Added",
                "Type added successfully.",
                `<i class="ph-fill ph-check-circle"></i>`,
                3000
              );
            } else if (isUpdate && response.data && response.data.success) {
              vm.closeModal();
              vm.getTypesList();
              Toasty.showToast(
                "Updated",
                "Type updated successfully.",
                `<i class="ph-fill ph-check-circle"></i>`,
                3000
              );
            }
          })
          .catch(function (error) {
            console.error(
              isUpdate ? "Failed to update type" : "Failed to add type",
              error
            );
            Toasty.showToast(
              "Error",
              isUpdate ? "Failed to update type." : "Failed to add type.",
              `<i class="ph-fill ph-x-circle text-danger"></i>`,
              3000
            );
          })
          .finally(function () {
            vm.isloading = false;
          });
      };

      // Edit
      vm.editType = (item) => {
        vm.typeModal();
        vm.type_info = angular.copy(item);
      };

      // Delete
      vm.deleteType = (item) => {
        SweetAlert2.fire({
          title: "Delete?",
          text: "This will permanently delete this cylinder type.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#848CB1",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "Cancel",
        }).then((result) => {
          if (result.isConfirmed) {
            $http
              .post("api/types/delete", { id: item.id })
              .then((response) => {
                vm.getTypesList();
                Toasty.showToast(
                  "Deleted",
                  "Type deleted successfully.",
                  `<i class="ph-fill ph-check-circle"></i>`,
                  3000
                );
              })
              .catch((error) => {
                console.error("Failed to delete type", error);
                Toasty.showToast(
                  "Error",
                  "Failed to delete type.",
                  `<i class="ph-fill ph-x-circle text-danger"></i>`,
                  3000
                );
              });
          }
        });
      };

      vm.typeModal = function (id) {
        let $uibModalInstance = $uibModal.open({
          animation: true,
          templateUrl: "src/template/types/modal.tpl.php",
          scope: vm,
          backdrop: "static",
        });
        vm.closeModal = function () {
          vm.type_info = {
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
    }
  );
