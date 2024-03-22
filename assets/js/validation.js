$(document).ready(function(){
    $.validator.addMethod("decimal_or_numbers", function (value) {
        if (/^[+-]?\d*\.?\d+$/.test(value)) {
            return true;
        } else {
            return false;
        }
    }, "The Enter Valid Number");

    $.validator.addMethod("alphabets_space", function (value, element) {
        if (this.optional(element) || /^[a-zA-Z\s]+$/.test(value))
        {
            return true;
        } else {
            return false;
        }
    }, "Enter only alphabets or space");
    
    $("#commission_master").validate({
        rules: {
            group_name: {
                required: true,
                maxlength: 50,
            },
            booking_commission: {
                required: true,
                decimal_or_numbers: true,
                maxlength: 50,
            },
            pickup_charges: {
                required: true,
                decimal_or_numbers: true,
                maxlength: 50,
            },
            delivery_commission: {
                required: true,
                decimal_or_numbers: true,
                maxlength: 50,
            },
            door_delivery: {
                required: true,
                decimal_or_numbers: true,
                maxlength: 50,
            },
            
        },
        messages: {
            group_name: {
                required: "Enter Group Name",
                maxlength: "Maxlength is 50 character",
                
            },

            booking_commission: {
                required: "Enter Booking Commission Percentage",
                maxlength: "Maxlength is 50 character",
                
            },
            pickup_charges: {
                required: "Enter Pickup Charges",
                maxlength: "Maxlength is 50 character",
               
            },
            delivery_commission: {
                required: "Enter Delivery Commission",
                maxlength: "Maxlength is 50 character",
                
            },
            door_delivery: {
                required: "Enter Door Delivery Charges",
                maxlength: "Maxlength is 50 character",
               
            },
            
        },
        submitHandler: function (form) {
            var formData = new FormData(form);
            var groupId = 0;
            url = 'admin/commission-master-add/' + groupId;  
            $.ajax({
                method: "POST",
                url: 'admin/commission-master-add/' + groupId,
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    console.log("eawf");
                    if (response.success == true) {
                        swal('Success!', response.msg, response.status)
                    }  else
                    {
                        if (response.error_no == '1')
                        {
                            swal('Oops!', response.msg, response.status)
                        }else if(response.error_no == '2')
                        {
                            swal('Oops!', response.msg, response.status)
                        }else if(response.error_no == '3')
                        {
                            swal('Oops!', response.msg, response.status)
                        }else{
                            swal('Oops...', 'Something went wrong with ajax !', 'error');
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    console.log("XHR:", xhr);
                }
            });
        }
    });

    $("#commission_master_edit").validate({
        rules: {
            booking_commission: {
                required: true,
                decimal_or_numbers: true,
                maxlength: 50,
            },
            pickup_charges: {
                required: true,
                decimal_or_numbers: true,
                maxlength: 50,
            },
            delivery_commission: {
                required: true,
                decimal_or_numbers: true,
                maxlength: 50,
            },
            door_delivery: {
                required: true,
                decimal_or_numbers: true,
                maxlength: 50,
            },
            
        },
        messages: {
            booking_commission: {
                required: "Enter Booking Commission Percentage",
                maxlength: "Maxlength is 50 character",
                
            },
            pickup_charges: {
                required: "Enter Pickup Charges",
                maxlength: "Maxlength is 50 character",
               
            },
            delivery_commission: {
                required: "Enter Delivery Commission",
                maxlength: "Maxlength is 50 character",
                
            },
            door_delivery: {
                required: "Enter Door Delivery Charges",
                maxlength: "Maxlength is 50 character",
               
            },
            
        },
        submitHandler: function (form) {
            var formData = new FormData(form);
            //var groupIdValue = document.getElementById('group_id').value;
            var urlParts = window.location.pathname.split('/');
            var groupId = urlParts.pop() || urlParts.pop();
            console.log(groupId);
            $.ajax({
                method: "POST",
                url: 'admin/commission-master-add/'+groupId,
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    console.log("eawf");
                    if (response.success == true) {
                        swal('Success!', response.msg, response.status)
                    } else
                    {
                        if (response.error_no == '1')
                        {
                            swal('Oops!', response.msg, response.status)
                        }else if(response.error_no == '2')
                        {
                            swal('Oops!', response.msg, response.status)
                        }else if(response.error_no == '3')
                        {
                            swal('Oops!', response.msg, response.status)
                        }else{
                            swal('Oops...', 'Something went wrong with ajax !', 'error');
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    console.log("XHR:", xhr);
                }
            });
        }
    });
});