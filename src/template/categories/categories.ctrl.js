angular
  .module("app")
  .controller(
    "categoriesCrtl",
    function ($scope, $http, $state, $uibModal, SweetAlert2, AuthService) {
      let vm = $scope;
      let vs = $state;
      let loggedInUser = AuthService.getUser();

      const CATEGORY_INFO = () => ({
        id: 0,
        tags: "",
        descriptions: "",
      });

      Object.assign(vm, {
        categoriesList: [],
        loggedInUser: loggedInUser,
        isloading: false,
        itemsPerPage: 50,
        currentPage: 1,
        category_info: CATEGORY_INFO(),
        isInvalid: false,
        Math: window.Math,
      });

      vm.getCategoriesList = () => {
        $http
          .get("api/categories/list")
          .then((response) => {
            vm.categoriesList = response.data;
          })
          .catch((error) => {
            console.error("Failed to fetch categories list", error);
            vm.categoriesList = [];
          });
      };
      vm.getCategoriesList();

      // Add or update category
      vm.saveCategory = (c) => {
        const requiredFields = ["tags", "descriptions"];
        let isUpdate = !!c.id;
        let hasEmpty = requiredFields.some(
          (field) => !c[field] || c[field].toString().trim() === ""
        );
        if (hasEmpty) {
          vm.isInvalid = true;
          return;
        }
        vm.isloading = true;

        let data = {
          tags: c.tags,
          descriptions: c.descriptions,
        };
        if (isUpdate) data.id = c.id;

        let url = isUpdate ? "api/categories/update" : "api/categories/add";

        $http
          .post(url, data)
          .then(function (response) {
            if (!isUpdate && response.data && response.data.categories_id) {
              vm.closeModal();
              vm.getCategoriesList();
              Toasty.showToast(
                "Added",
                "Category added successfully.",
                `<i class="ph-fill ph-check-circle"></i>`,
                3000
              );
            } else if (isUpdate && response.data && response.data.success) {
              vm.closeModal();
              vm.getCategoriesList();
              Toasty.showToast(
                "Updated",
                "Category updated successfully.",
                `<i class="ph-fill ph-check-circle"></i>`,
                3000
              );
            } else {
              Toasty.showToast(
                "Error",
                response.data && response.data.message
                  ? response.data.message
                  : isUpdate
                  ? "Failed to update category."
                  : "Failed to add category.",
                `<i class="ph-fill ph-x-circle text-danger"></i>`,
                3000
              );
            }
          })
          .catch(function (error) {
            console.error(
              isUpdate ? "Failed to update category" : "Failed to add category",
              error
            );
            Toasty.showToast(
              "Error",
              isUpdate
                ? "Failed to update category."
                : "Failed to add category.",
              `<i class="ph-fill ph-x-circle text-danger"></i>`,
              3000
            );
          })
          .finally(function () {
            vm.isloading = false;
          });
      };

      // Edit
      vm.editCategory = (item) => {
        vm.categoryModal();
        vm.category_info = angular.copy(item);
      };

      // Delete
      vm.deleteCategory = (item) => {
        SweetAlert2.fire({
          title: "Delete?",
          text: "This will permanently delete this category.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#848CB1",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "Cancel",
        }).then((result) => {
          if (result.isConfirmed) {
            $http
              .post("api/categories/delete", { id: item.id })
              .then((response) => {
                if (response.data && response.data.success) {
                  vm.getCategoriesList();
                  Toasty.showToast(
                    "Deleted",
                    "Category deleted successfully.",
                    `<i class="ph-fill ph-check-circle"></i>`,
                    3000
                  );
                } else {
                  Toasty.showToast(
                    "Error",
                    response.data && response.data.message
                      ? response.data.message
                      : "Failed to delete category.",
                    `<i class="ph-fill ph-x-circle text-danger"></i>`,
                    3000
                  );
                }
              })
              .catch((error) => {
                console.error("Failed to delete category", error);
                Toasty.showToast(
                  "Error",
                  "Failed to delete category.",
                  `<i class="ph-fill ph-x-circle text-danger"></i>`,
                  3000
                );
              });
          }
        });
      };

      vm.categoryModal = function () {
        let $uibModalInstance = $uibModal.open({
          animation: true,
          templateUrl: "src/template/categories/modal.tpl.php",
          scope: vm,
          backdrop: "static",
        });
        vm.closeModal = function () {
          vm.category_info = {
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
