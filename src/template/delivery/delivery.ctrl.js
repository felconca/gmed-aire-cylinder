angular
  .module("app")
  .controller(
    "deliveryCtrl",
    function (
      $scope,
      $state,
      $http,
      $uibModal,
      $filter,
      SweetAlert2,
      AuthService
    ) {
      let vm = $scope;
      let vs = $state;
      const DELIVERY_INFO = () => ({
        id: 0,
        delivery_no: "",
        location_id: 0,
        customer_id: 0,
        customer_address: 0,
        delivery_date: null,
        request_date: null,
        status: "",
        notes: "",
      });
      const FILTER_ITEM_STATUS = () => [
        { label: "Select Status", value: "all" },
        { label: "Delivered", value: "delivered" },
        { label: "Returned", value: "returned" },
        { label: "Pending", value: "pending" },
        { label: "Cancelled", value: "cancelled" },
      ];

      Object.assign(vm, {
        itemsPerPage: 50,
        currentPage: 1,
        Math: window.Math,
        filterItemStatus: FILTER_ITEM_STATUS(),
        fstatus: "all",
        loggedInUser: AuthService.getUser(),
        fcustomer: 0,
        flocation: 0,
        ftypes: 0,
        fcategory: 0,
        fdeliverFrom: new Date(),
        fdeliverTo: new Date(),
        isfiltering: false,
        selectAll: false,
        customersList: [],
        cylindersList: [],
        locationsList: [],
        categoryList: [],
        typesList: [],
        unitsList: [],
        deliveryList: [],
        customerAddresses: [],
        delivery_info: DELIVERY_INFO(),
        deliveryItemsList: [],
        selectedItems: [],
        selectedCylinders: [],
        itemsPerCylinderPage: 50,
        currentCylinderPage: 1,
      });

      vm.cylinderModal = () => {
        vm.getCylinders(vm.fcategory, vm.ftypes);
        let $uibModalInstance = $uibModal.open({
          animation: true,
          templateUrl: "src/template/delivery/cylinder.modal.php",
          scope: vm,
          size: "xl",
          backdrop: "static",
        });
        vm.closeCylinder = function () {
          $uibModalInstance.close();
          vm.selectCylinderAll = false;
          vm.selectedCylinders = [];
        };
      };
      vm.getDeliveryList = (fdeliverFrom, fdeliverTo, fstatus, fcustomer) => {
        vm.isfiltering = true;
        let from = $filter("date")(fdeliverFrom, "yyyy-MM-dd");
        let to = $filter("date")(fdeliverTo, "yyyy-MM-dd");
        $http
          .get(
            `api/delivery/list?customer=${fcustomer}&from=${from}&to=${to}&status=${fstatus}`
          )
          .then((response) => {
            vm.deliveryList = response.data;
          })
          .catch((err) => {
            console.error(err);
          })
          .finally(() => {
            vm.isfiltering = false;
          });
      };
      vm.getDeliveryList(
        vm.fdeliverFrom,
        vm.fdeliverTo,
        vm.fstatus,
        vm.fcustomer
      );
      // Function to fetch active customers and assign to customersList
      vm.getCustomersList = () => {
        vm.customersList = [];
        $http
          .get("api/customers/list?status=active")
          .then(function (response) {
            vm.customersList = response.data;
          })
          .catch(function (error) {
            console.error("Failed to fetch customers list", error);
            vm.customersList = [];
          });
      };
      vm.getCustomersList();
      // Function to fetch list of locations and assign to locationsList
      vm.getLocationsList = () => {
        $http
          .get("api/locations/list")
          .then(function (response) {
            vm.locationsList = response.data;
          })
          .catch(function (error) {
            console.error("Failed to fetch locations list", error);
            vm.locationsList = [];
          });
      };
      vm.getLocationsList();
      // Function to fetch list of categories and assign to categoryList
      vm.getCategoryList = () => {
        $http
          .get("api/categories/list")
          .then(function (response) {
            vm.categoryList = response.data;
          })
          .catch(function (error) {
            console.error("Failed to fetch categories list", error);
            vm.categoryList = [];
          });
      };
      vm.getCategoryList();
      // Function to fetch list of types and assign to typesList
      vm.getTypesList = () => {
        $http
          .get("api/types/list")
          .then(function (response) {
            vm.typesList = response.data;
          })
          .catch(function (error) {
            console.error("Failed to fetch categories list", error);
            vm.typesList = [];
          });
      };
      vm.getTypesList();
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
      vm.deliveryModal = () => {
        let $uibModalInstance = $uibModal.open({
          animation: true,
          templateUrl: "src/template/delivery/modal.tpl.php",
          scope: vm,
          size: "custom",
          backdrop: "static",
        });
        vm.closeModal = function () {
          vm.delivery_info = {
            id: 0,
            delivery_no: "",
            location_id: 0,
            customer_id: 0,
            customer_address: 0,
            delivery_date: null,
            request_date: null,
            status: "",
            notes: "",
          };
          $uibModalInstance.close();
        };
      };
      vm.getCylinders = (fcategory, ftypes) => {
        $http
          .get(
            `api/delivery/cylinders?status=available&category=${fcategory}&types=${ftypes}`
          )
          .then((res) => {
            vm.cylindersList = res.data;
            vm.selectedCylinders = [];
            vm.selectCylinderAll = false;
          })
          .catch((err) => {
            console.error(err);
          });
      };
      vm.getCustomerAddress = (id) => {
        $http
          .get("api/customers/contacts?id=" + id)
          .then((response) => {
            vm.customerAddresses = response.data;
          })
          .catch((err) => {
            console.error(err);
          });
      };
      vm.onChangeCustomer = (id) => {
        if (id > 0) {
          vm.delivery_info.customer_address = 0;
          vm.getCustomerAddress(id);
        }
      };

      vm.saveDelivery = (d) => {
        const requiredFields = ["customer_id", "delivery_date", "request_date"];
        // For selects/number fields, treat 0 or empty as not selected
        let hasEmpty = requiredFields.some((field) => {
          return (
            !d[field] || d[field] === 0 || d[field].toString().trim() === ""
          );
        });

        if (hasEmpty) {
          vm.isInvalid = true;
          return;
        }
        let data = {
          customer_id: d.customer_id,
          customer_address: d.customer_address,
          delivery_date: $filter("date")(d.delivery_date, "yyyy-MM-dd"),
          request_date: $filter("date")(d.request_date, "yyyy-MM-dd"),
          notes: d.notes,
          created_by: vm.loggedInUser.id,
        };
        vm.isInvalid = false;
        vm.isloading = false;
        $http
          .post("api/delivery/add", data)
          .then((response) => {
            Toasty.showToast(
              "Added",
              "Cylinder added successfully.",
              `<i class="ph-fill ph-check-circle"></i>`,
              3000
            );
            vm.getDeliveryList();
            vm.closeModal();
            vm.editDelivery(response.data.id);
          })
          .catch((error) => {
            console.error("Failed to add delivery", error);
            Toasty.showToast(
              "Error",
              "Could not save delivery. Please try again.",
              `<i class="ph-fill ph-x-circle text-danger"></i>`,
              3000
            );
          })
          .finally(() => {
            vm.isloading = false;
          });
        console.log(data);
      };
      vm.editDelivery = (id) => {
        if (id > 0) {
          $http
            .get(`api/delivery/edit?id=${id}`)
            .then((res) => {
              vm.delivery_info = res.data;
              vm.listItems(id);
              vm.getCustomerAddress(vm.delivery_info.customer_id);
              vs.go(
                "app.delivery.edit",
                { id: id }
                // { reload: true, inherit: false, notify: true }
              );
            })
            .catch((err) => {
              console.error(err);
              vs.go("app.delivery.list");
            });
        }
      };
      vm.deleteDelivery = (id) => {
        SweetAlert2.fire({
          title: "Delete?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#848CB1",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        }).then((result) => {
          if (result.isConfirmed) {
            $http
              .post("api/delivery/delete", { id: id })
              .then((response) => {
                vs.reload();
                Toasty.showToast(
                  "Deleted",
                  "Delivery deleted successfully.",
                  `<i class="ph-fill ph-check-circle"></i>`,
                  3000
                );
              })
              .catch((error) => {
                console.error("Failed to delete delivery", error);
                Toasty.showToast(
                  "Error",
                  "Failed to delete delivery.",
                  `<i class="ph-fill ph-x-circle text-danger"></i>`,
                  3000
                );
              })
              .finally(() => {
                vm.isfiltering = false;
                vm.isloading = false;
              });
          }
        });
      };
      vm.updateDelivery = (info, items) => {
        console.log(info, items);
        // Validation for required fields, similar to saveDelivery
        const requiredFields = [
          "id",
          "customer_id",
          "delivery_date",
          "request_date",
        ];
        let hasEmpty = requiredFields.some((field) => {
          return (
            !info[field] ||
            info[field] === 0 ||
            info[field].toString().trim() === ""
          );
        });

        if (hasEmpty) {
          vm.isInvalid = true;
          return;
        }

        // Compose data according to API update contract
        let data = {
          id: info.id,
          customer_id: info.customer_id,
          customer_address: info.customer_address,
          delivery_date: $filter("date")(info.delivery_date, "yyyy-MM-dd"),
          request_date: $filter("date")(info.request_date, "yyyy-MM-dd"),
          notes: info.notes,
        };

        vm.isInvalid = false;
        vm.isloading = true;
        $http
          .post("api/delivery/update", data)
          .then((response) => {
            Toasty.showToast(
              "Updated",
              "Delivery updated successfully.",
              `<i class="ph-fill ph-check-circle"></i>`,
              3000
            );
            vm.getDeliveryList();
            if (info.id) {
              vm.editDelivery(info.id); // Reload info and items
            }
          })
          .catch((error) => {
            console.error("Failed to update delivery", error);
            Toasty.showToast(
              "Error",
              "Could not update delivery. Please try again.",
              `<i class="ph-fill ph-x-circle text-danger"></i>`,
              3000
            );
          })
          .finally(() => {
            vm.isloading = false;
          });
      };
      vm.listItems = (id) => {
        $http
          .get(`api/delivery/items/list?id=${id}`)
          .then((res) => {
            vm.deliveryItemsList = res.data;
          })
          .catch((err) => {
            console.error(err);
          });
      };
      vm.addItems = (items) => {
        if (Array.isArray(items) && items.length > 0) {
          // Map to API contract expected by DeliveryController.php (delivery_id, cylinder_id, userid, status)
          let data = items.map((i) => ({
            delivery_id: vm.delivery_info.id || vs.params.id,
            cylinder_id: i.id,
            userid: vm.loggedInUser.id, // assumes you have vm.user set appropriately
            status: "reserved", // or i.status if variable, else default to reserved
          }));
          $http
            .post("api/delivery/items/add", { data: data })
            .then((res) => {
              // refresh items list after adding
              let curId =
                (vm.delivery_info && vm.delivery_info.id) || vs.params.id;
              vm.listItems(curId);
              vm.getCylinders();
              Toasty.showToast(
                "Added",
                "Item(s) added successfully.",
                `<i class="ph-fill ph-check-circle"></i>`,
                3000
              );
              vm.selectedCylinders = [];
              vm.selectCylinderAll = false;
            })
            .catch((err) => {
              console.error("Failed to add item(s)", err);
              Toasty.showToast(
                "Error",
                "Failed to add item(s).",
                `<i class="ph-fill ph-x-circle text-danger"></i>`,
                3000
              );
            });
          // console.log(items);
        }
      };
      vm.deleteItems = (items) => {
        if (Array.isArray(items) && items.length > 0) {
          let data = items.map((i) => ({
            id: i.id,
            cylinder_id: i.cylinder_id,
            delivery_id: vm.delivery_info.id || vs.params.id,
          }));
          $http
            .post("api/delivery/items/delete", { data: data })
            .then((res) => {
              // Try to use delivery_info.id if available, else fallback to vs.params.id
              let curId =
                (vm.delivery_info && vm.delivery_info.id) || vs.params.id;
              vm.listItems(curId);
              Toasty.showToast(
                "Deleted",
                "Item(s) deleted successfully.",
                `<i class="ph-fill ph-check-circle"></i>`,
                3000
              );
              vm.selectedItems = [];
              vm.selectAll = false;
            })
            .catch((err) => {
              console.error("Failed to delete item(s)", err);
              Toasty.showToast(
                "Error",
                "Failed to delete item(s).",
                `<i class="ph-fill ph-x-circle text-danger"></i>`,
                3000
              );
            });
        }
      };
      vm.selectItem = (items) => {
        const index = vm.selectedItems.indexOf(items);
        if (index > -1) {
          vm.selectedItems.splice(index, 1);
        } else {
          vm.selectedItems.push(items);
        }
      };
      vm.selectAllItems = (list) => {
        vm.selectAll = !vm.selectAll;
        const startIndex = (vm.currentPage - 1) * vm.itemsPerPage;
        const endIndex = Math.min(startIndex + vm.itemsPerPage, list.length);
        const itemsOnCurrentPage = list.slice(startIndex, endIndex);

        itemsOnCurrentPage.forEach((item) => {
          item.selected = vm.selectAll;
          vm.selectItem(item);
        });
      };
      vm.changePage = (list) => {
        const startIndex = (vm.currentPage - 1) * vm.itemsPerPage;
        const endIndex = Math.min(startIndex + vm.itemsPerPage, list.length);
        vm.selectAll = list
          .slice(startIndex, endIndex)
          .every((item) => item.selected);
      };

      // cylinder
      vm.selectCylinder = (items) => {
        const index = vm.selectedCylinders.indexOf(items);
        if (index > -1) {
          vm.selectedCylinders.splice(index, 1);
        } else {
          vm.selectedCylinders.push(items);
        }
      };
      vm.selectAllCylinders = (list) => {
        vm.selectCylinderAll = !vm.selectCylinderAll;
        const startIndex =
          (vm.currentCylinderPage - 1) * vm.itemsPerCylinderPage;
        const endIndex = Math.min(
          startIndex + vm.itemsPerCylinderPage,
          list.length
        );
        const itemsOnCurrentPage = list.slice(startIndex, endIndex);

        itemsOnCurrentPage.forEach((item) => {
          item.selected = vm.selectCylinderAll;
          vm.selectCylinder(item);
        });
      };
      vm.changeCylinderPage = (list) => {
        const startIndex =
          (vm.currentCylinderPage - 1) * vm.itemsPerCylinderPage;
        const endIndex = Math.min(
          startIndex + vm.itemsPerCylinderPage,
          list.length
        );
        vm.selectCylinderAll = list
          .slice(startIndex, endIndex)
          .every((item) => item.selected);
      };
      /**
       * Generates a unique delivery number based on the current delivery list count.
       * Format: "DLV-YYYYMMDD-XXXXXX"
       *   - DLV: prefix
       *   - YYYYMMDD: current date
       *   - XXXXXX: serial is (deliveryList.length + 1), zero-padded to 6 digits
       *
       * @param {Object} options - { prefix, length, date }
       *   - prefix: custom prefix (default: "DLV")
       *   - length: zero-padding length for serial (default: 6)
       *   - date: date string/Date object for DLV (default: today)
       *   - list: array to base the serial count on (default: vm.deliveryList)
       * @returns {string} e.g. "DLV-20240608-000101"
       */
      vm.generateDeliveryNo = function (options = {}) {
        const prefix = options.prefix || "DLV";
        const length = options.length || 6;
        const now = options.date ? new Date(options.date) : new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, "0");
        const day = String(now.getDate()).padStart(2, "0");
        const datePart = `${year}${month}${day}`;
        // Use options.list if provided, else fall back to vm.deliveryList or empty array
        const list = options.list || vm.deliveryList || [];
        const serial = String(list.length + 1).padStart(length, "0");
        return `${prefix}-${datePart}-${serial}`;
      };

      vm.formatNumber = (n) => n.toLocaleString();
      vm.setFilter = (f) => {
        vm.selectedFilter = f;
      };
      vm.filterStatus = (i) =>
        vm.selectedFilter === "all" || i.status === vm.selectedFilter;
      vm.toISO = function (dateStr) {
        const d = new Date(dateStr);
        if (isNaN(d)) {
          console.warn("Invalid date:", dateStr);
          return null;
        }
        return d.toISOString();
      };

      vm.statusLabelMap = {
        delivered: { label: "Delivered", class: "issued" },
        returned: { label: "Returned", class: "returned" },
        pending: { label: "Pending", class: "inspection" },
        cancelled: { label: "Cancelled", class: "maintenance" },
      };
      /**
       * Returns the status label (text only) for templates or logic
       */
      vm.deliveryStatus = (status) => vm.statusLabelMap[status]?.label || "";
      /**
       * Returns the status CSS class for ng-class binding in templates
       * Usage in template:
       * <span class="status-badge {{ vm.deliveryStatusClass(items.status) }}">{{ vm.deliveryStatus(items.status) }}</span>
       */
      vm.deliveryStatusClass = (status) =>
        vm.statusLabelMap[status]?.class || "";

      if (vs.current.name === "app.delivery.edit") {
        vm.editDelivery(vs.params.id);
      }
    }
  );
