$(function () {
    $(function () {

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        var url = $('#url').val();
        $('#employeeLogin').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }, 
                password: { required: true }
            },
            messages: {
                email: { required: "Email is required" },
                password: { required: "Password is required" }
            },
            submitHandler: function (form) {
                $('.message').empty();
                var formdata = new FormData(form);
                $.ajax({
                    url: url+'/employee-login',
                    type: 'POST',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (dataResult) {
                        console.log(dataResult);
                        if (dataResult == '1') {
                            $('.message').append('<div class="alert alert-success">Logged In Successfully</div>');
                            setTimeout(function () { window.location.href =  url+'/employee/home'; }, 1000);
                        }else if(dataResult != '1') {
                            $('.message').append('<div class="alert alert-danger ">'+dataResult+'</div>');
                        }else {
                            $.each(dataResult, function (i, error) {
                                var el = $(document).find('[name="' + i + '"]');
                                el.after($('<span class="error">' + error + '</span>'));
                            });
                        }
                    }
                });
            }
        });

        // ========================================
        // script for LeaveApplication module
        // ========================================

        $('#add_EmpLeave').validate({
            rules: { 
                from_date: { required: true},
                to_date: { required: true},
                leave: { required: true },
                reason: { required: true }
            },
            submitHandler: function (form) {
                var formdata = new FormData(form);
                $.ajax({
                    url: url+'/employee/employee-leave',
                    type: 'POST',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (dataResult) {
                        if (dataResult == '1') {
                            $('#modal-default').modal('hide');
                            Toast.fire({
                                icon: 'success',
                                title: 'Added Succesfully.'
                            });
                            setTimeout(function(){ window.location.reload(); },1000);
                        }
                    },
                    error: function (data) {
                        if (data.status == 422) {
                            $.each(data.responseJSON.errors, function (i, error) {
                                var el = $(document).find('[name="' + i + '"]');
                                el.after($('<span class="error">' + error[0] + '</span>'));
                            });
                        }
                    }
                });
            }
        });

    
    });
});