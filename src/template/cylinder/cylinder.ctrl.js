angular
  .module("app")
  .controller(
    "cylinderCrtl",
    function (
      $scope,
      $state,
      $http,
      $filter,
      SweetAlert2,
      AuthService,
      $uibModal
    ) {
      let vm = $scope;
      let vs = $state;

      const CYLINDER_INFO = () => ({
        id: 0,
        serial: "",
        barcode: "",
        types_id: 0,
        capacity: 0,
        category_id: 0,
        unit_id: 0,
        expiry_date: null,
        manufacture_date: null,
      });
      const FILTER_ITEM_STATUS = () => [
        { label: "Select Status", value: "all" },
        { label: "Available", value: "available" },
        { label: "In Used", value: "in used" },
        { label: "Maintenance", value: "under maintenance" },
        { label: "Inspection", value: "for inspection" },
      ];

      const dateThirtyDaysAgo = new Date();
      dateThirtyDaysAgo.setDate(dateThirtyDaysAgo.getDate() - 30);

      Object.assign(vm, {
        itemsPerPage: 50,
        currentPage: 1,
        Math: window.Math,
        cylinder_info: CYLINDER_INFO(),
        filterItemStatus: FILTER_ITEM_STATUS(),
        expiryDateFrom: null,
        expiryDateTo: null,
        manufactureDateFrom: null,
        manufactureDateTo: null,
        selectedFilter: "all",
        loggedInUser: AuthService.getUser(),
        fcustomer: 0,
        flocation: 0,
        ftypes: 0,
        fcategory: 0,
        isfiltering: false,
        customersList: [],
        cylindersList: [],
        locationsList: [],
        categoryList: [],
        typesList: [],
        unitsList: [],
      });

      vm.filterCylinders = () => {
        vm.isfiltering = true;
        // Use current filter state from the controller (vm)
        const params = {
          customer_id: vm.fcustomer || 0,
          status: vm.selectedFilter || "all",
          location: vm.flocation || 0,
          types: vm.ftypes || 0,
          category: vm.fcategory || 0,
          expiry_from: $filter("date")(vm.expiryDateFrom, "yyyy-MM-dd") || "",
          expiry_to: $filter("date")(vm.expiryDateTo, "yyyy-MM-dd") || "",
          manu_from:
            $filter("date")(vm.manufactureDateFrom, "yyyy-MM-dd") || "",
          manu_to: $filter("date")(vm.manufactureDateTo, "yyyy-MM-dd") || "",
        };
        const query = Object.keys(params)
          .map(
            (key) =>
              encodeURIComponent(key) + "=" + encodeURIComponent(params[key])
          )
          .join("&");

        $http
          .get(`api/cylinders/list?${query}`)
          .then((response) => {
            vm.cylindersList = response.data;
          })
          .catch((error) => {
            console.error("Failed to filter cylinders", error);
            // vm.isfiltering = false;
          })
          .finally(() => {
            vm.isfiltering = false;
          });
      };
      vm.filterCylinders();
      vm.saveCylinder = (c) => {
        // Validation - required fields
        const requiredFields = [
          "barcode",
          "serial",
          "types_id",
          "category_id",
          "capacity",
          "unit_id",
          "manufacture_date",
          "expiry_date",
        ];
        let isUpdate = !!c.id;
        let hasEmpty = requiredFields.some((field) => {
          // For selects/number fields, treat 0 or empty as not selected
          if (
            ["types_id", "category_id", "capacity", "unit_id"].indexOf(
              field
            ) !== -1
          ) {
            return (
              !c[field] || c[field] == 0 || c[field].toString().trim() === ""
            );
          }
          // For date/string fields
          return !c[field] || c[field].toString().trim() === "";
        });

        if (hasEmpty) {
          vm.isInvalid = true;
          return;
        }
        vm.isInvalid = false;
        vm.isloading = true;

        let data = {
          barcode: c.barcode,
          serial: String(c.serial),
          types: c.types_id,
          categories: c.category_id,
          capacity: c.capacity,
          units: c.unit_id,
          manufacture_date: $filter("date")(c.manufacture_date, "yyyy-MM-dd"),
          expiry_date: $filter("date")(c.expiry_date, "yyyy-MM-dd"),
        };
        if (isUpdate) data.id = c.id;

        let url = isUpdate ? "api/cylinders/update" : "api/cylinders/add";

        $http
          .post(url, data)
          .then(function (response) {
            if (!isUpdate && response.data && response.data.cylinder_id) {
              vm.closeModal();
              vm.filterCylinders();
              Toasty.showToast(
                "Added",
                "Cylinder added successfully.",
                `<i class="ph-fill ph-check-circle"></i>`,
                3000
              );
            } else if (isUpdate && response.data && response.data.success) {
              vm.closeModal();
              vm.filterCylinders();
              Toasty.showToast(
                "Updated",
                "Cylinder updated successfully.",
                `<i class="ph-fill ph-check-circle"></i>`,
                3000
              );
            }
          })
          .catch(function (error) {
            console.error(
              isUpdate ? "Failed to update cylinder" : "Failed to add cylinder",
              error
            );
            Toasty.showToast(
              "Error",
              error.data.details,
              `<i class="ph-fill ph-x-circle text-danger"></i>`,
              3000
            );
          })
          .finally(function () {
            vm.isloading = false;
          });
      };
      // Edit
      vm.editCylinder = (item) => {
        vm.cylinderModal();
        vm.cylinder_info = angular.copy(item);
      };
      vm.deleteCylinder = function (id) {
        SweetAlert2.fire({
          title: "Delete?",
          text: "This will permanently delete the cylinder.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#848CB1",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "Cancel",
        }).then((result) => {
          if (result.isConfirmed) {
            $http
              .post("api/cylinders/delete", { id: id })
              .then(function (response) {
                Toasty.showToast(
                  "Deleted",
                  "Cylinder deleted successfully.",
                  `<i class="ph-fill ph-check-circle"></i>`,
                  3000
                );
                // Optionally refresh the list after deletion
                vm.filterCylinders();
              })
              .catch(function (error) {
                console.error("Failed to delete cylinder", error);
                Toasty.showToast(
                  "Error",
                  "Failed to delete cylinder.",
                  `<i class="ph-fill ph-check-x text-danger"></i>`,
                  3000
                );
              });
          }
        });
      };
      vm.cylinderModal = () => {
        let $uibModalInstance = $uibModal.open({
          animation: true,
          templateUrl: "src/template/cylinder/modal.tpl.php",
          scope: vm,
          size: "custom",
          backdrop: "static",
        });
        vm.closeModal = function () {
          vm.cylinder_info = {
            id: 0,
            serial: "",
            barcode: "",
            types_id: 0,
            capacity: 0,
            category_id: 0,
            unit_id: 0,
            expiry_date: null,
            manufacture_date: null,
          };
          $uibModalInstance.close();
        };
      };
      vm.printCylinder = function () {
        printJS({
          printable: vm.cylindersList,
          properties: [
            { field: "barcode", displayName: "Barcode" },
            { field: "serial", displayName: "Serial No" },
            { field: "types", displayName: "Type" },
            { field: "capacity", displayName: "Capacity" },
            { field: "units", displayName: "Units" },
            { field: "expiry_date", displayName: "Expiry" },
            { field: "manufacture_date", displayName: "Manufactured." },
          ],
          gridHeaderStyle:
            "color: #2c2e3b;  border: 1px solid #dee2e6;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;",
          gridStyle:
            "border: 1px solid #dee2e6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;",
          type: "json",
          header: `
              <div style='display:flex; flex-direction:column; justify-content:center; align-items:center'>
                <img src="src//assets//images//logo.png" style='width:200px; margin-bottom:-20px'>
                <h1 class="custom-h3">Cylinders List</h1>
              </div>`,
          style:
            ".custom-h3{color:#2c2e3b;text-align: center;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;}",
        });
      };

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

      // Helpers
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
      /**
       * Generates a barcode string for a cylinder.
       *
       * @param {Object} options
       *   { prefix: string, length: number, serial: string|number, date: Date|string }
       *   All parameters are optional except 'length'.
       * @returns {string}
       *   e.g. "CYL-20240607-012345"
       */
      vm.generateBarcode = function (options = {}) {
        // Default options
        const prefix = options.prefix || "CYL";
        const length = options.length || 6;
        const now = options.date ? new Date(options.date) : new Date();

        // Format date as YYYYMMDD
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, "0");
        const day = String(now.getDate()).padStart(2, "0");
        const datePart = `${year}${month}${day}`;

        // Use serial if provided, else generate random number
        let serial = options.serial
          ? String(options.serial).padStart(length, "0")
          : String(Math.floor(Math.random() * Math.pow(10, length))).padStart(
              length,
              "0"
            );

        // Combine parts
        return `${prefix}-${datePart}-${serial}`;
      };
      /**
       * Generates a barcode and sets it to vm.cylinder_info.barcode.
       * Accepts optional options to customize barcode generation.
       * If no options are provided, uses serial from current cylinder_info if available.
       */
      vm.setGeneratedBarcode = function (options = {}) {
        // Use cylinder_info.serial as serial if not supplied
        if (!options.serial && vm.cylinder_info.serial) {
          options.serial = vm.cylinder_info.serial;
        }
        vm.cylinder_info.barcode = vm.generateBarcode(options);
      };

      vm.statusLabelMap = {
        available: { label: "Available", class: "available" },
        "in used": { label: "In Used", class: "issued" },
        "for inspection": { label: "For Inspection", class: "inspection" },
        "under maintenance": {
          label: "Under Maintenance",
          class: "maintenance",
        },
        returned: { label: "Returned", class: "returned" },
        reserved: { label: "Reserved", class: "reserved" },
      };
      /**
       * Returns the status label (text only) for templates or logic
       */
      vm.cylinderStatus = (status) => vm.statusLabelMap[status]?.label || "";
      /**
       * Returns the status CSS class for ng-class binding in templates
       * Usage in template:
       * <span class="status-badge {{ vm.cylinderStatusClass(items.status) }}">{{ vm.cylinderStatus(items.status) }}</span>
       */
      vm.cylinderStatusClass = (status) =>
        vm.statusLabelMap[status]?.class || "";
    }
  );
