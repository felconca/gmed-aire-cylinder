angular
  .module("app")
  .controller(
    "customersCrtl",
    function ($scope, $http, $state, $uibModal, SweetAlert2, AuthService) {
      let vm = $scope;
      let vs = $state;
      let loggedInUser = AuthService.getUser();
      const CUSTOMER_INFO = () => ({
        id: 0,
        descriptions: "",
        address: "",
        city: "",
        state: "",
        contact_person: "",
        contact_no: "",
        email: "",
        is_what: "customer",
        zipcode: "",
      });
      Object.assign(vm, {
        customersList: [],
        loggedInUser: loggedInUser,
        isloading: false,
        itemsPerPage: 50,
        currentPage: 1,
        customer_info: CUSTOMER_INFO(),
        isInvalid: false,
        Math: window.Math,
        contactList: [],
      });
      vm.getCustomersList = () => {
        $http
          .get("api/customers/list?status=active")
          .then((response) => {
            vm.customersList = response.data;
          })
          .catch((error) => {
            console.error("Failed to fetch customers list", error);
            vm.customersList = [];
          });
      };
      vm.getCustomersList();
      // Combined add/update customer handler
      vm.saveCustomer = function (c) {
        // Check required fields (all except is_what, only for add)
        const requiredFields = [
          "descriptions",
          "address",
          "city",
          "state",
          "contact_person",
          "contact_no",
          "zipcode",
        ];
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
          descriptions: c.descriptions,
          contact_person: c.contact_person,
          contact_no: c.contact_no,
          address: c.address,
          city: c.city,
          state: c.state,
          zipcode: c.zipcode,
          email: c.email,
          is_what: c.is_what,
        };

        if (isUpdate) data.id = c.id;

        let url = isUpdate ? "api/customers/update" : "api/customers/add";

        $http
          .post(url, data)
          .then(function (response) {
            if (!isUpdate && response.data && response.data.customer_id) {
              // New add
              vm.closeCustomer();
              vm.getCustomersList();
              Toasty.showToast(
                "Added",
                "Customer added successfully.",
                `<i class="ph-fill ph-check-circle"></i>`,
                3000
              );
            } else if (isUpdate && response.data && response.data.success) {
              // Update
              vm.getCustomersList();
              Toasty.showToast(
                "Updated",
                "Customer updated successfully.",
                `<i class="ph-fill ph-check-circle"></i>`,
                3000
              );
              if (vm.closeCustomer) vm.closeCustomer();
            } else {
              Toasty.showToast(
                "Error",
                (response.data && response.data.message) ||
                  (isUpdate
                    ? "Failed to update customer."
                    : "Failed to add customer."),
                `<i class="ph-fill ph-x-circle text-danger"></i>`,
                3000
              );
            }
          })
          .catch(function (error) {
            console.error(
              isUpdate ? "Failed to update customer" : "Failed to add customer",
              error
            );
            Toasty.showToast(
              "Error",
              isUpdate
                ? "Failed to update customer."
                : "Failed to add customer.",
              `<i class="ph-fill ph-x-circle text-danger"></i>`,
              3000
            );
          })
          .finally(function () {
            if (!isUpdate) {
              // Reset only after add
              vm.customer_info = {
                descriptions: "",
                address: "",
                city: "",
                state: "",
                zipcode: "",
                contact_person: "",
                contact_no: "",
                email: "",
                is_what: "customer",
              };
            }
            vm.isInvalid = false;
            vm.isloading = false;
          });
      };
      //   edit customers
      vm.editCustomer = (c) => {
        if (c.id > 0) {
          vm.customerModal();
          vm.customer_info = c;
        }
      };
      // delete customer function
      vm.deleteCustomer = (id) => {
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
              .post("api/customers/delete", { id: id })
              .then((response) => {
                vm.getCustomersList();
                Toasty.showToast(
                  "Deleted",
                  "Customer deleted successfully.",
                  `<i class="ph-fill ph-check-circle"></i>`,
                  3000
                );
              })
              .catch((error) => {
                console.error("Failed to delete customer", error);
                Toasty.showToast(
                  "Error",
                  "Failed to delete customer.",
                  `<i class="ph-fill ph-x-circle text-danger"></i>`,
                  3000
                );
              })
              .finally(() => {
                vm.isloading = false;
              });
          }
        });
      };

      vm.customerModal = () => {
        let $uibModalInstance = $uibModal.open({
          templateUrl: "src/template/customers/modal.tpl.php",
          size: "lg",
          scope: vm,
          backdrop: "static",
        });
        vm.closeCustomer = function () {
          $uibModalInstance.close();
        };
      };

      vm.exportToExcel = function (tableId) {
        var table = document.getElementById(tableId);
        if (!table) {
          Toasty.showToast(
            "Error",
            "Table not found for export.",
            `<i class="ph-fill ph-x-circle text-danger"></i>`,
            3000
          );
          return;
        }
        try {
          var wb = XLSX.utils.book_new();
          var ws_data = [];

          // Build headers (removing "Actions" column)
          var headers = [];
          var ths = table.querySelectorAll("thead tr th");
          var actionsIndex = -1;
          ths.forEach(function (th, idx) {
            var txt = (th.textContent || "").trim();
            if (/^actions$/i.test(txt)) {
              actionsIndex = idx;
            } else {
              headers.push(txt);
            }
          });
          ws_data.push(headers);

          // Get body rows, skipping the "Actions" column if present
          var trs = table.querySelectorAll("tbody tr");
          trs.forEach(function (tr) {
            // Only export visible rows (skip ng-if rows like "No customers found.")
            if (tr.offsetParent === null) return;
            var row = [];
            var tds = tr.querySelectorAll("td");
            tds.forEach(function (td, tdIdx) {
              if (tdIdx === actionsIndex) return; // Skip "Actions" column
              var cellText = td.innerText || td.textContent || "";
              cellText = cellText.replace(/\s+/g, " ").trim();
              row.push(cellText);
            });
            // Push row if it matches header length
            if (row.length === headers.length) {
              ws_data.push(row);
            }
          });

          var ws = XLSX.utils.aoa_to_sheet(ws_data);

          // Optionally set column widths like table (skip actions column width)
          var colWidths = [];
          ths.forEach(function (th, idx) {
            if (idx === actionsIndex) return;
            var w = th.offsetWidth || 15;
            colWidths.push({ wch: Math.round(w / 7) + 2 });
          });
          ws["!cols"] = colWidths;

          XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

          var today = new Date();
          var yyyy = today.getFullYear();
          var mm = String(today.getMonth() + 1).padStart(2, "0");
          var dd = String(today.getDate()).padStart(2, "0");
          var filename = `customer_list_${yyyy}${mm}${dd}.xlsx`;

          XLSX.writeFile(wb, filename);
        } catch (err) {
          console.error("Failed to export to Excel", err);
          Toasty.showToast(
            "Error",
            "Failed to export to Excel. See console for details.",
            `<i class="ph-fill ph-x-circle text-danger"></i>`,
            3000
          );
        }
      };
      vm.printCustomer = function () {
        printJS({
          printable: vm.customersList,
          properties: [
            { field: "descriptions", displayName: "Customer Name" },
            { field: "address", displayName: "Address" },
            { field: "city", displayName: "City" },
            { field: "zipcode", displayName: "Zipcode" },
            { field: "contact_person", displayName: "Contact Person" },
            { field: "contact_no", displayName: "Contact No." },
          ],
          type: "json",
          header: "Customer List",
        });
      };

      // customer contacts
      vm.showContactModal = function (id) {
        let $uibModalInstance = $uibModal.open({
          animation: true,
          templateUrl: "src/template/customers/contacts.modal.tpl.php",
          size: "xl",
          scope: vm,
          backdrop: "static",
        });
        vm.getAllContact(id);
        vm.closeContact = function () {
          $uibModalInstance.close();
        };
      };
      vm.getAllContact = function (id) {
        $http
          .get("api/customers/contacts?id=" + id, { withCredentials: true })
          .then(function (res) {
            vm.contactList = res.data.map((c) => ({
              id: c.id,
              partner_id: c.partner_id,
              contact_person: c.contact_person,
              contact_no: c.contact_no,
              email: c.email,
              address: c.address,
              deleted: parseInt(c.deleted), // 0 or 1
            }));

            if (vm.contactList.length === 0) {
              vm.contactList = [
                {
                  id: 0,
                  partner_id: id,
                  contact_person: "",
                  contact_no: "",
                  email: "",
                  address: "",
                  deleted: 0,
                },
                {
                  id: 0,
                  partner_id: id,
                  contact_person: "",
                  contact_no: "",
                  email: "",
                  address: "",
                  deleted: 0,
                },
                {
                  id: 0,
                  partner_id: id,
                  contact_person: "",
                  contact_no: "",
                  email: "",
                  address: "",
                  deleted: 0,
                },
              ];
            } else {
              let last = vm.contactList[vm.contactList.length - 1];
              if (
                last.contact_person ||
                last.contact_no ||
                last.email ||
                last.address
              ) {
                vm.addLine(id);
              }
            }
          })
          .catch(function error(err) {
            console.error(err);
          });
      };
      vm.addLine = function (partner_id) {
        partner_id =
          partner_id || (vm.contactList[0] ? vm.contactList[0].partner_id : 0);
        vm.contactList.push({
          id: 0,
          partner_id: partner_id,
          contact_person: "",
          contact_no: "",
          email: "",
          address: "",
          deleted: 0,
        });
      };
      vm.deleteLine = function (index) {
        let row = vm.contactList[index];
        if (row.id > 0) {
          row.deleted = 1; // mark for soft-delete in DB
        } else {
          vm.contactList.splice(index, 1); // remove unsaved rows
        }
      };
      vm.saveContacts = function (contacts) {
        vm.isLoading = true;

        let cleanContacts = contacts.filter(
          (c) => c.contact_person || c.contact_no || c.email || c.address
        );
        $http
          .post("api/customers/contacts", cleanContacts, {
            withCredentials: true,
          })
          .then(function (res) {
            Toasty.showToast(
              "Saved",
              `Contacts saved successfully!`,
              `<i class="ph-fill ph-check-circle text-success"></i>`,
              3000
            );
            vm.getAllContact(contacts[0].partner_id); // reload fresh
            vm.isLoading = false;
          })
          .catch(function error(err) {
            console.error(err);
            vm.isLoading = false;
          });
      };
      vm.checkLastRow = function (index) {
        if (index === vm.contactList.length - 1) {
          let row = vm.contactList[index];
          if (
            row.contact_person ||
            row.contact_no ||
            row.email ||
            row.address
          ) {
            vm.addLine();
          }
        }
      };

      // Helpers
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
