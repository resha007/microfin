

$(document).ready(function () {//alert("test123");
    $("#update").prop("disabled", false);
    $("#delete").prop("disabled", false);
    var action, data = '';

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    //alert("test123");

    // update-loan tbl & save-repayment
    $("#update").click(function () {//alert(getIdSelections());
        Swal.fire({
            width: '400px',
            padding: null,
            title: 'Are you sure?',
            position: 'top-end',
            text: "You won't be able to revert this!",
            allowEnterKey: true,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Update it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "loanApproval/update",
                    dataType: 'json',
                    async: true,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    data: $('form').serialize(),
                    success: function (data) { //alert (data);
                        $.ajax({
                            type: "POST",
                            url: "loanApproval/save_repayment_data",
                            dataType: 'json',
                            async: true,
                            headers: { 'X-Requested-With': 'XMLHttpRequest' },
                            data: $('form').serialize(),
                            success: function (data) { //alert(data);
                                if (data) {
                                    Toast.fire({
                                        type: 'success',
                                        title: 'Successfully added'
                                    });
                                    $("#dataTable").bootstrapTable('refresh');
                                    $("#dataTablenew").bootstrapTable('refresh');
                                    $("#reset").click();

                                    $("#update").prop("disabled", false);
                                    $("#delete").prop("disabled", false);
                                    //$("#show").prop("disabled",false);
                                } else {
                                    Toast.fire({
                                        type: 'error',
                                        title: 'Something went wrong. Please try again.'
                                    });
                                }
                            }
                        });
                    }
                });
            }

        })

    });


    $("#delete").click(function () {
        Swal.fire({
            width: '400px',
            padding: null,
            title: 'Are you sure?',
            position: 'top-end',
            text: "You won't be able to revert this!",
            allowEnterKey: true,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "loan/delete",
                    dataType: 'json',
                    async: true,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    data: $('form').serialize(),
                    success: function (data) {//alert(data["status"]);
                        if (data) {
                            Toast.fire({
                                type: 'success',
                                title: 'Successfully deleted'
                            });
                            $table.bootstrapTable('refresh');
                            $("#reset").click();

                            $("#update").prop("disabled", false);
                            $("#delete").prop("disabled", false);
                            // $("#add").prop("disabled",false);
                        } else {
                            Toast.fire({
                                type: 'error',
                                title: 'Something went wrong. Please try again.'
                            });
                        }
                    }
                });
            }
            //$("#reset").click();
        })

    });


    $("#dataTable").click(function () {
        var id = getIdSelections();

        $("#update").prop("disabled", false);
        $("#delete").prop("disabled", false);
        // $("#add").prop("disabled", true);

        $.ajax({
            type: "POST",
            url: "loan/loan_by_id",
            dataType: 'json',
            async: true,
            data: { id: id },
            success: function (data) {//alert(data["data"]["guarantor_1_id"]);
                if (data) {
                    $("#id").val(data["data"]["id"]);
                    $("#customer_id").val(data["data"]["customer_id"]);
                    $("#customer_name").val(data["data"]["customer"]);
                    $("#reason").val(data["data"]["reason"]);
                    $("#guarantor_1_id").val(data["data"]["guarantor_1_id"]);
                    $("#guarantor_1").val(data["data"]["guarantor_1"]);
                    $("#guarantor_2_id").val(data["data"]["guarantor_2_id"]);
                    $("#guarantor_2").val(data["data"]["guarantor_2"]);
                    $("#loan_amount").val(data["data"]["loan_amount"]);
                    $("#loan_period").val(data["data"]["loan_period"]);
                    $("#loan_interest").val(data["data"]["loan_interest"]);
                    $("#created_date").val(data["data"]["created_date"]);
                    $("#created_by").val(data["data"]["username"]);
                    $("#status").val(data["data"]["status"]);
                } else {
                    Toast.fire({
                        type: 'error',
                        title: 'Something went wrong. Please try again.'
                    });
                }
            }
        });
        //alert(id);
    });

    // //validations
    function validate() {
        var err = 0;

        var elem = document.getElementById('dataForm').elements;
        for (var i = 0; i < elem.length; i++) {
            if (elem[i].type != "button" && elem[i].type != "reset" && elem[i].id != "id") {
                if (elem[i].value == '' || elem[i].value == '0') {
                    Toast.fire({
                        type: 'warning',
                        title: 'This field is required'
                    });
                    $("#" + elem[i].id).focus();
                    err = 1;
                    return err;
                }
            }
        }
    }


});