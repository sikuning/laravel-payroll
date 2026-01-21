$(function () {
    var uRL = $('.demo').val();
   // console.log(uRL);

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.modal').on('hidden.bs.modal', function(e) {
        $(this).find('form')[0].reset();
      });

    $('.change-logo').click(function () {
        $('.change-com-img').click();
    });

    // delete data common function
    function destroy_data(name, url) {
        var el = name;
        var id = el.attr('data-id');
        var dltUrl = url + id;
        if (confirm('Are you Sure Want to Delete This')) {
            $.ajax({
                url: dltUrl,
                type: "DELETE",
                cache: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        el.parent().parent('tr').remove();
                    } else {
                        Toast.fire({
                            icon: 'danger',
                            title: dataResult
                        })
                    }
                }
            });
        }
    }

    function show_formAjax_error(data) {
        if (data.status == 422) {
            $('.error').remove();
            $.each(data.responseJSON.errors, function (i, error) {
                var el = $(document).find('[name="' + i + '"]');
                el.after($('<span class="error">' + error[0] + '</span>'));
            });
        }
    }

    // ========================================
    // script for Admin Logout
    // ========================================

    $('.admin-logout').click(function () {
        $.ajax({
            url: uRL + '/admin/logout',
            type: "GET",
            cache: false,
            success: function (dataResult) {
                if (dataResult == '1') {
                    setTimeout(function () {
                        window.location.href = uRL;
                    }, 500);
                    Toast.fire({
                        icon: 'success',
                        title: 'Logged Out Succesfully.'
                    })
                }
            }
        });
    });

     // ========================================
    // script for Employee module
    // ========================================

    // get department designations
    $('.select-department').change(function(){
        var id = $(this).val();
        $.ajax({
            url: uRL + '/get_designations',
            type: 'POST',
            data: {id:id},
            success: function (dataResult) {
                console.log(dataResult);
                $('.d-designation').html(dataResult);
            },
            error: function (error) {
                show_formAjax_error(error);
            }
        });
    });

    $('select[name=monthly_pay]').change(function(){
        $('select[name=hourly_pay]').prop('selectedIndex',0);
        // $('select[name=hourly_pay]').attr('readonly',true);
    });
    $('select[name=hourly_pay]').change(function(){
        $('select[name=monthly_pay]').prop('selectedIndex',0);
        // $('select[name=hourly_pay]').attr('readonly',true);
    });

    $('.add-education').click(function(){
        var html = `<div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Board / University <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="university[]" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Degree <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="degree[]" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Passing Year <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="pass_year[]" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>GPA / CGPA <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="cgpa[]" required>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12 mb-3 text-right">
                            <button type="button" class="btn btn-danger delete-education"><i class="fa fa-times"></i> Delete</button>
                        </div>
                    </div>`;
        $('.education-container').append(html);

    })

    $(document).on('click','.delete-education',function(){
        $(this).parent().parent().remove();
    })


    $('.add-experience').click(function(){
        var html = `<div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="form-group">
                <label>Organisation <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="organisation[]">
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="form-group">
                <label>Designation <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="exp_designation[]" required>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="form-group">
                <label>From Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="exp_from[]" required>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="form-group">
                <label>To Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="exp_to[]" required>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="form-group">
                <label>Responsibility <span class="text-danger">*</span></label>
                <textarea name="responsibility[]" class="form-control" required></textarea>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="form-group">
                <label>Skill <span class="text-danger">*</span></label>
                <textarea name="skill[]" class="form-control" required></textarea>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <button class="btn btn-danger mt-5 delete-experience"><i class="fa fa-times"></i> Delete</button>
        </div>
    </div>`;
        $('.experience-container').append(html);

    })

    $(document).on('click','.delete-experience',function(){
        $(this).parent().parent().remove();
    })

    $('#addEmployee').validate({
        rules: {
            f_name: { required: true },
            gender: { required: true },
            dob: { required: true },
            phone: { required: true },
            marital_status: { required: true },
            email: { required: true },
            password: { required: true },
            con_password: { required: true,equalTo: '#password' },
            department: { required: true },
            designation: { required: true },
            work_shift: { required: true },
            join_date: { required: true },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/employees',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/employees'; }, 1000)
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateEmployee').validate({
        rules: {
            f_name: { required: true },
            gender: { required: true },
            dob: { required: true },
            phone: { required: true },
            martial_status: { required: true },
            email: { required: true },
            department: { required: true },
            designation: { required: true },
            work_shift: { required: true },
            join_date: { required: true },
            status: { required: true },
        },
        
        submitHandler: function (form) {
            var id = $('.id').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL+'/admin/employees/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/employees'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-employee", function () {
        destroy_data($(this), 'employees/')
    });

    // ========================================
    // script for Department module
    // ========================================

    $('#add_department').validate({
        rules: { department: { required: true } },
        messages: { department: { required: "Please Enter Department Name" } },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/departments',
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
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_department', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'departments/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].department_id);
                $('#modal-info input[name=department]').val(dataResult[0].department_name);
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].department_id);
                $('#modal-info').modal('show');
            }
        });
    });

    $("#edit_department").validate({
        rules: { department: { required: true } },
        messages: { department: { required: "Please Enter Department Name" } },
        submitHandler: function (form) {
            var id = $('#modal-info input[name=id]').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/departments' + '/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                }
            });
        },
        error: function (error) {
            show_formAjax_error(error);
        }
    });

    $(document).on("click", ".delete-department", function () {
        destroy_data($(this), ' departments/')
    });

    // ========================================
    // script for Designation module
    // ========================================

    $('#add_designation').validate({
        rules: {
            designation: { required: true },
            department: { required: true }
        },
        messages: {
            designation: { required: "Please Enter Designation Name" },
            department: { required: "Please Enter Department Name" }
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/designations',
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
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_designation', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'designations/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].designation_id);
                $('#modal-info input[name=designation]').val(dataResult[0].designation_name);
                $('#modal-info input[name=department]').val(dataResult[0].department_id);
                $("#modal-info select[name=department] option").each(function () {
                    if ($(this).val() == dataResult[0].department_id) {
                        $(this).attr('selected', true);
                    }
                });
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].designation_id);
                $('#modal-info').modal('show');

            }
        });
    });

    $("#edit_designation").validate({
        rules: {
            designation: { required: true },
            department: { required: true }
        },
        messages: {
            designation: { required: "Please Enter Designation Name" },
            department: { required: "Please Enter Department Name" }
        },
        submitHandler: function (form) {
            var id = $('#modal-info input[name=id]').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/designations' + '/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                }
            });
        },
        error: function (error) {
            show_formAjax_error(error);
        }
    });

    $(document).on("click", ".delete-designation", function () {
        destroy_data($(this), ' designations/')
    });
    
    // ========================================
    // script for Work Shift module
    // ========================================
    $('#add_shift').validate({
        rules: { 
            shift: { required: true } ,
            start_time: { required: true }, 
            end_time: { required: true },
           // late_count_time: { required: true },
        },
        messages: { 
            shift: { required: "Please Enter Work Shift Name" }, 
            start_time: { required: "Please Enter Start Time Shift Name" },
            end_time: { required: "Please Enter End Time Shift Name" }, 
           // late_count_time: { required: "Please Enter Late Count Time Shift Name" }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/work_shift',
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
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_shift', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'work_shift/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].shift_id);
                $('#modal-info input[name=shift]').val(dataResult[0].work_shift);
                $('#modal-info input[name=start_time]').val(dataResult[0].start_time);
                $('#modal-info input[name=end_time]').val(dataResult[0].end_time);
                $('#modal-info input[name=late_count_time]').val(dataResult[0].late_count_time);
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].shift_id);
                $('#modal-info').modal('show');
            }
        });
    });

    $("#edit_shift").validate({
        rules: { 
            shift: { required: true } ,
            start_time: { required: true }, 
            end_time: { required: true },
            late_count_time: { required: true },
        },
        messages: { 
            shift: { required: "Please Enter Work Shift Name" }, 
            start_time: { required: "Please Enter Start Time Shift Name" },
            end_time: { required: "Please Enter End Time Shift Name" }, 
            late_count_time: { required: "Please Enter Late Count Time Shift Name" }, 
        },
        submitHandler: function (form) {
            var id = $('#modal-info input[name=id]').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/work_shift' + '/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                }
            });
        },
        error: function (error) {
            show_formAjax_error(error);
        }
    });

    $(document).on("click", ".delete-shift", function () {
        destroy_data($(this), 'work_shift/')
    });


    

     // ========================================
    // script for Tax Rule module
    // ========================================


    $(document).on("change",".tax",function(){
        var amount = $('.m_income').val();
        var percentage_of_tax = $('.m_tax').val();
        var taxableAmount = 0;
        taxableAmount = parseInt(amount) * parseInt(percentage_of_tax) /100;
       $('.taxable_amount').val(taxableAmount);
        $('body').find('.taxable_amount').attr('readonly', true);
    });

    $('#add_tax').validate({
        rules: { 
            income: { required: true},
            tax: { required: true },
         //   taxable_amount: { required: true }
        },
        messages: { 
            income: { required: "Please Enter Total Income" }, 
            tax: { required: "Please Enter Tax Rate" },
          //  taxable_amount: { required: "Please Enter Taxable Amount" } 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/tax_rule',
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
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_tax', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'tax_rule/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].tax_id);
                $('#modal-info input[name=income]').val(dataResult[0].total_income);
                $('#modal-info input[name=tax]').val(dataResult[0].tax_rate);
                $('#modal-info input[name=taxable_amount]').val(dataResult[0].taxable_amount);
                $("#modal-info select[name=gender] option").each(function () {
                    if ($(this).val() == dataResult[0].gender) {
                        $(this).attr('selected', true);
                    }
                });
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].tax_id);
                $('#modal-info').modal('show');
            }
        });
    });

    $("#edit_tax").validate({
        rules: { 
            income: { required: true},
            tax: { required: true },
          //  taxable_amount: { required: true }
        },
        messages: { 
            income: { required: "Please Enter Total Income" }, 
            tax: { required: "Please Enter Tax Rate" },
           // taxable_amount: { required: "Please Enter Taxable Amount" } 
        },
        submitHandler: function (form) {
            var id = $('#modal-info input[name=id]').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/tax_rule' + '/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                }
            });
        },
        error: function (error) {
            show_formAjax_error(error);
        }
    });
   
    // ========================================
    // script for Employee Attendance Mark module
    // ========================================
    $(document).on('click','.attendance-mark',function () {
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-url');
        var date = $(this).attr('data-date');
        if($('#attendance-status'+id).is(":checked")){
            var status = '1';
        }else{
            var status = '0';
        }
        var leaveType = '';
        var halfDay = '';
        var reason = '';
        if(status == '0'){
            var leaveType = $('#leaveform'+id+' .leave-type option:selected').val();
            if ($('#leaveform' + id + ' .half-day').is(":checked")) {
                var halfDay = '1';
            } else {
                var halfDay = '0';
            }
            var reason = $('#leaveform' + id + ' .reason').val();
        }
        var clockIn = $('#clock-in' + id).val();
        var clockOut = $('#clock-out' + id).val();
        if ($('#late' + id).is(":checked")) {
            var is_late = '1';
        } else {
            var is_late = '0';
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                id: id,date:date,status:status,leaveType:leaveType,halfDay:halfDay,reason:reason,clockIn:clockIn,clockOut:clockOut,is_late:is_late
            },
            success: function (dataResult) {
                console.log(dataResult);
                if (dataResult == '1') {
                    window.location.reload();
                    Toast.fire({
                        icon: 'success',
                        title: 'Marked Succesfully.'
                    })
                }
            }
        });
    })

    $('.save-all-attendance').click(function(){
        var data = [];
        var url = $(this).attr('data-url');
        $("input[name='employeeId[]']").each(function () {
            var id = $(this).val();
            
            if ($('#attendance-status' + id).is(":checked")) {
                var status = '1';
            } else {
                var status = '0';
            }
            var leaveType = '';
            var halfDay = '';
            var reason = '';
            if (status == '0') {
                var leaveType = $('#leaveform' + id + ' .leave-type option:selected').val();
                if ($('#leaveform' + id + ' .half-day').is(":checked")) {
                    var halfDay = '1';
                } else {
                    var halfDay = '0';
                }
                var reason = $('#leaveform' + id + ' .reason').val();
            }
            var clockIn = $('#clock-in' + id).val();
            var clockOut = $('#clock-out' + id).val();
            if ($('#late' + id).is(":checked")) {
                var is_late = '1';
            } else {
                var is_late = '0';
            }
            var obj = {
                employeeId: id,
                status: status,
                leaveType: leaveType,
                halfDay: halfDay,
                reason: reason,
                clock_in: clockIn,
                clock_out: clockOut,
                late: is_late
            };
            data[id] = obj;
        });
        //var data = JSON.stringify(data);
        console.log(data);
        
        $.ajax({
            url: url,
            type: 'PATCH',
            data: { data: JSON.stringify(data)},
            success: function (dataResult) {
                console.log(dataResult);
                if (dataResult == '1') {
                    window.location.reload();
                    Toast.fire({
                        icon: 'success',
                        title: 'Added Succesfully.'
                    })
                }
            }
        });
        
    });


    $(".date-attendance").change(function () {
        var val = $(this).val(); 
       var url = $('#editAttendance').attr('action');
        window.location.replace(url + '/' + val + '/edit');
    });

    function filterAttendance(){
        var employee = $('#attendance-employee option:selected').val();
        var month = $('#attendance-month option:selected').val();
        var year = $('#attendance-year option:selected').val();
        $.ajax({
            url: 'attendance-filter', 
            type: 'POST',
            data: {employee:employee,month:month,year:year},
            success: function (dataResult) {
                console.log(dataResult);
                var thead = '<tr><th>Employee</th>';
                for ($i = 1; $i <= dataResult.days_in_month;$i++){
                    thead += '<th class="pl-2 pr-2">' + $i + '</th>';
                }
                thead += '</tr>';
                $('#attendance-view thead').html(thead);
                var tbody = '';
                $.each(dataResult.employee, function (index, value) {
                    tbody += '<tr>';
                    tbody += '<td>'+index+'</td>';
                    $.each(value, function (j) {
                        tbody += '<td>' + value[j] + '</td>';
                    })
                    tbody += '</tr>';
                });
                $('#attendance-view tbody').html(tbody);
            }
        });
    }

    $('.filter-attendance').click(function(){
        filterAttendance(uRL + 'attendance-filter');
    })

    $('#attendance-view').ready(function(){
        filterAttendance(uRL + 'attendance-filter');
    })

    // ========================================
    // script for Public Holidays module
    // ========================================

    $('#add_public_holiday').validate({
        rules: {
            holiday: { required: true },
            from_date: { required: true },
            to_date: { required: true },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/public_holidays',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_public_holiday', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'public_holidays/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult.id);
                $('#modal-info input[name=holiday]').val(dataResult.name);
                $('#modal-info input[name=from_date]').val(dataResult.from_date);
                $('#modal-info input[name=to_date]').val(dataResult.to_date);
                $('#modal-info textarea[name=comment]').html(dataResult.comment);
                $('#modal-info').modal('show');
            }
        });
    });

    $("#edit_public_holiday").validate({
        rules: {
            holiday: { required: true },
            from_date: { required: true },
            to_date: { required: true },
        },
        submitHandler: function (form) {
            var id = $('#modal-info input[name=id]').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/public_holidays/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                }
            });
        },
        error: function (error) {
            show_formAjax_error(error);
        }
    });

    $(document).on("click", ".delete-public-holiday", function () {
        destroy_data($(this), ' public_holidays/')
    });

    // ========================================
    // script for Weekly Holidays module
    // ========================================

    $('#add_weekly_holiday').validate({
        rules: {
            day_name: { required: true },
            status: { required: true },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/weekly_holidays',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_weekly_holiday', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'weekly_holidays/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult.id);
                $("#modal-info select[name=day_name] option").each(function () {
                    if ($(this).val() == dataResult.day_name) {
                        $(this).attr('selected', true);
                    }
                });
                $("#modal-info select[name=status] option").each(function () {
                    if ($(this).val() == dataResult.status) {
                        $(this).attr('selected', true);
                    }
                });
                $('#modal-info').modal('show');
            }
        });
    });

    $("#edit_weekly_holiday").validate({
        rules: {
            day_name: { required: true },
            status: { required: true },
        },
        submitHandler: function (form) {
            var id = $('#modal-info input[name=id]').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/weekly_holidays/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                }
            });
        },
        error: function (error) {
            show_formAjax_error(error);
        }
    });

    $(document).on("click", ".delete-weekly-holiday", function () {
        destroy_data($(this), ' weekly_holidays/')
    });

    // ========================================
    // script for Leave Type module
    // ========================================
    $('#add_leave').validate({
        rules: {
            leave_type: { required: true },
        },
        submitHandler: function(form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    if(dataResult == '1'){
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

    $(document).on('click', '.edit_leave', function () {
        var id= $(this).attr('data-id');
        var dltUrl = 'leave_type/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function(dataResult){
                $('#modal-info input[name=id]').val(dataResult[0].id);
                $('#modal-info input[name=leave_type]').val(dataResult[0].leave_type);
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].id);
                $('#modal-info').modal('show');
            }
        });
    });

    $("#edit_leave").validate({
        rules: { leave_type: { required: true } },
        submitHandler: function(form) {
            var url = $('.u-url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success : function(dataResult){
                    if(dataResult == '1'){
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
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

    $(document).on("click", ".delete_leave_type", function() {
        destroy_data($(this),' leave_type/')
    });

    // ========================================
    // script for LeaveApplication module
    // ========================================

    $(document).on("click", ".view_leave", function () {
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-url');
        $.ajax({
            url: url+'/'+id,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                console.log(dataResult);
                $('#view-application #id').html(dataResult.id);
                if(dataResult.from_date == dataResult.to_date){
                    $('#view-application #date').html(dataResult.from_date);
                }else{
                    $('#view-application #date').html(dataResult.from_date+' - '+dataResult.to_date);
                }
                $('#view-application #leave_type').html(dataResult.leave_type);
                $('#view-application #reason').html(dataResult.reason);
                var status = dataResult.status;
                if(status == '0') {
                    $('#view-application #status').html('<span class="badge badge-warning">Pending</span>');
                }else if (status == '1') {
                    $('#view-application #status').html('<span class="badge  badge-success">Approved</span>');
                }else {
                    $('#view-application #status').html('<span class="badge badge-danger">Rejected</span>');
                }
                $('#view-application').modal('show');
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
    });

    $(document).on("click", ".change_status", function () {
        var id = $(this).attr('data-id');
        var  val = $(this).attr('data-value');
        var url = $(this).attr('data-url');
        $.ajax({
            url: url + '/change-leave-status',
            type: "POST",
            data: {leave_id:id,status:val},
            cache: false,
            success: function (dataResult) {
              window.location.reload();  
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
    });

    // ========================================
    // script for Allowance module
    // ========================================

    $(document).on("change",".allowance_type",function(){
        var allowance_type = $('.allowance_type').val();
        if(allowance_type == '0'){
            $('.percentage_of_basic').val('0');
            $('body').find('.percentage_of_basic').attr('disabled', true);
        }else{
            $('.percentage_of_basic').val('0');
            $('body').find('.percentage_of_basic').attr('disabled', false);
        }
    });

    $('#add_allowance').validate({
        rules: { 
           allowance: { required: true},
            allowance_type: { required: true },
         //  percentage: { required: true },
           limit_per_month: { required: true }
        },
        messages: { 
            allowance: { required: "Please Enter Allowance Name" }, 
            allowance_type: { required: "Please Enter Allowance Type" },
           // percentage: { required: "Please Enter Allowance Percentage" },
            limit_per_month: { required: "Please Enter Allowance Limit Per Month" } 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/allowance',
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
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_allowance', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'allowance/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].allowance_id);
                $('#modal-info input[name=allowance]').val(dataResult[0].allowance_name);
                $("#modal-info select[name=allowance_type] option").each(function () {
                    if ($(this).val() == dataResult[0].allowance_type) {
                        $(this).attr('selected', true);
                    }
                });
                $('#modal-info input[name=percentage]').val(dataResult[0].percentage_of_basic);
                $('#modal-info input[name=limit_per_month]').val(dataResult[0].limit_per_month);
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].allowance_id);
                $('#modal-info').modal('show');
            }
        });
    });

    $(document).on("change",".update_allowance_type",function(){
        var allowance_type = $('.update_allowance_type').val();
        if(allowance_type == '0'){
            $('.percentage_of_basic').val('0');
            $('body').find('.percentage_of_basic').attr('readonly', true);
        }else{
            $('.percentage_of_basic').val('0');
            $('body').find('.percentage_of_basic').attr('readonly', false);
        }
    });

    $("#edit_allowance").validate({
        rules: { 
            allowance: { required: true},
            allowance_type: { required: true },
          //  percentage: { required: true },
            limit_per_month: { required: true }
        },
        messages: { 
            allowance: { required: "Please Enter Allowance Name" }, 
            allowance_type: { required: "Please Enter Allowance Type" },
           // percentage: { required: "Please Enter Allowance Percentage" },
            limit_per_month: { required: "Please Enter Allowance Limit Per Month" } 
        },
        submitHandler: function (form) {
            var id = $('#modal-info input[name=id]').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/allowance' + '/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                }
            });
        },
        error: function (error) {
            show_formAjax_error(error);
        }
    });

    $(document).on("click", ".delete-allowance", function () {
        destroy_data($(this), 'allowance/')
    });

    // ========================================
    // script for Deduction module
    // ========================================

    $(document).on("change",".deduction_type",function(){
        var deduction_type = $('.deduction_type').val();
        if(deduction_type == '0'){
            $('.percentage_of_basic').val('0');
            $('body').find('.percentage_of_basic').attr('disabled', true);
        }else{
            $('.percentage_of_basic').val('0');
            $('body').find('.percentage_of_basic').attr('disabled', false);
        }
    });

    $('#add_deduction').validate({
        rules: { 
            deduction: { required: true},
            deduction_type: { required: true },
          // percentage: { required: true },
           limit_per_month: { required: true }
        },
        messages: { 
            deduction: { required: "Please Enter Deduction Name" }, 
            deduction_type: { required: "Please Enter Deduction Type" },
        //    percentage: { required: "Please Enter Deduction Percentage" },
            limit_per_month: { required: "Please Enter Deduction Limit Per Month" } 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/deduction',
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
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_deduction', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'deduction/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].deduction_id);
                $('#modal-info input[name=deduction]').val(dataResult[0].deduction_name);
                $("#modal-info select[name=deduction_type] option").each(function () {
                    if ($(this).val() == dataResult[0].deduction_type) {
                        $(this).attr('selected', true);
                    }
                });
                $('#modal-info input[name=percentage]').val(dataResult[0].percentage_of_basic);
                $('#modal-info input[name=limit_per_month]').val(dataResult[0].limit_per_month);
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].deduction_id);
                $('#modal-info').modal('show');
            }
        });
    });

    $(document).on("change",".update_deduction_type",function(){
        var deduction_type = $('.update_deduction_type').val();
        if(deduction_type == '0'){
            $('.percentage_of_basic').val('0');
            $('body').find('.percentage_of_basic').attr('readonly', true);
        }else{
            $('.percentage_of_basic').val('0');
            $('body').find('.percentage_of_basic').attr('readonly', false);
        }
    });

    $("#edit_deduction").validate({
        rules: { 
            deduction: { required: true},
            deduction_type: { required: true },
          //  percentage: { required: true },
            limit_per_month: { required: true }
        },
        messages: { 
            deduction: { required: "Please Enter Deduction Name" }, 
            deduction_type: { required: "Please Enter Deduction Type" },
           // percentage: { required: "Please Enter Deduction Percentage" },
            limit_per_month: { required: "Please Enter Deduction Limit Per Month" } 
        },
        submitHandler: function (form) {
            var id = $('#modal-info input[name=id]').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/deduction' + '/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    //console.log(dataResult);
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                }
            });
        },
        error: function (error) {
            show_formAjax_error(error);
        }
    });

    $(document).on("click", ".delete-deduction", function () {
        destroy_data($(this), 'deduction/')
    });
     
    // ========================================
    // script for Pay Grade module
    // ========================================

    $(document).on("change",".percentage_of_basic",function(){
       var gross_salary=  $('.gross_salary').val();
       var percentage_of_basic  =  $('.percentage_of_basic').val();
       basicSalary = 0;
       var basicSalary = parseInt(gross_salary) * parseInt(percentage_of_basic) /100;
       $('.basic_salary').val(basicSalary);
        $('body').find('.basic_salary').attr('readonly', true);
    });

    $(document).on("click",".all_allowance",function(){
        if($(this).prop('checked')==true){
            $('.singleAllowance').attr('disabled', true);
        }else{
           $('.singleAllowance').attr('disabled', false);
        }
    });

    $(document).on("click",".all_deduction",function(){
        if($(this).prop('checked')==true){
            $('.singleDeduction').attr('disabled', true);
        }else{
           $('.singleDeduction').attr('disabled', false);
        }
    });

    $('#addPay').validate({
        rules: {
            pay_grade: { required: true },
            //overtime_rate: { required: true },
            gross_salary: { required: true },
            percentage: { required: true },
           // basic_salary: { required: true },
           // allowance: { required: true },
           //deduction: { required: true },
        },
        messages: {
            pay_grade: { required: "Please Enter Pay Grade Name" },
           // overtime_rate: { required: "Please Enter overtime Rate" },
            gross_salary: { required: "Please Enter Gross Salary" },
            percentage: { required: "Please Enter Percentage of Basic" },
           // basic_salary: { required: "Please Enter Basic Salary" },
          //  allowance: { required: "Please Enter  allowance Name" },
           // deduction: { required: "Please Enter Deduction Name" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/pay_grade',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/pay_grade'; }, 1000)
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updatePay').validate({
        rules: {
            pay_grade: { required: true },
            //overtime_rate: { required: true },
            gross_salary: { required: true },
            percentage: { required: true },
           // basic_salary: { required: true },
            allowance: { required: true },
            deduction: { required: true },
        },
        messages: {
            pay_grade: { required: "Please Enter Pay Grade Name" },
           // overtime_rate: { required: "Please Enter overtime Rate" },
            gross_salary: { required: "Please Enter Gross Salary" },
            percentage: { required: "Please Enter Percentage of Basic" },
           // basic_salary: { required: "Please Enter Basic Salary" },
            allowance: { required: "Please Enter  allowance Name" },
            deduction: { required: "Please Enter Deduction Name" },
        },
        submitHandler: function (form) {
            var id = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                   // console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/pay_grade'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-pay", function () {
        destroy_data($(this), 'pay_grade/')
    });

     // ========================================
    // script for Hourly Pay Grade module
    // ========================================

    $('#addHourly').validate({
        rules: { 
                 hourly: { required: true }, 
            hourly_rate: { required: true }, 
        },
        messages: { 
            hourly: { required: "Please Enter Hourly Pay Grade Name" }, 
            hourly_rate: { required: "Please Enter Hourly Pay Grade Rate" }, 
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/hourly_pay_grade',
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
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_hourly', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'hourly_pay_grade/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].hourly_id);
                $('#modal-info input[name=hourly]').val(dataResult[0].hourly_pay_grade);
                $('#modal-info input[name=hourly_rate]').val(dataResult[0].hourly_rate);
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].hourly_id);
                $('#modal-info').modal('show');
            }
        });
    });

    $("#editHourly").validate({
        rules: { 
            hourly: { required: true }, 
        hourly_rate: { required: true }, 
        },
        messages: { 
            hourly: { required: "Please Enter Hourly Pay Grade Name" }, 
            hourly_rate: { required: "Please Enter Hourly Pay Grade Rate" }, 
        },
        submitHandler: function (form) {
            var id = $('#modal-info input[name=id]').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/hourly_pay_grade' + '/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                }
            });
        },
        error: function (error) {
            show_formAjax_error(error);
        }
    });

    $(document).on("click", ".delete-hourly", function () {
        destroy_data($(this), ' hourly_pay_grade/')
    });

    

    // ========================================
    // script for General Setting module
    // ========================================

    $('#updateGeneralSetting').validate({
        rules: {
            com_name: { required: true },
            com_email: { required: true },
            address: { required: true },
            phone: { required: true },
            c_text: { required: true },
            cur_format: { required: true },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/general-settings',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/general-settings'; }, 1000);
                    }else if (dataResult == '0') {
                        Toast.fire({
                            icon: 'info',
                            title: 'Already Updated.'
                        });
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    // ========================================
    // script for Admin  module
    // ========================================

    $('#updateProfileSetting').validate({
        rules: {
            admin_name: { required: true },
            email: { required: true },
            username: { required: true },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/profile-settings',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/profile-settings'; }, 1000);
                    }else if(dataResult == '0'){
                        Toast.fire({
                            icon: 'info',
                            title: 'Already Updated'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/profile-settings'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });


    $('#updatePassword').validate({
        rules: {
            password: { required: true },
            new: { required: true },
            new_confirm: { required: true,equalTo:'#password' },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/change-password',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/profile-settings'; }, 1000);
                    }else if(dataResult == '0'){
                        Toast.fire({
                            icon: 'info',
                            title: 'Already Updated'
                        });
                    }else{
                        Toast.fire({
                            icon: 'warning',
                            title: dataResult
                        });
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });



    $(document).on('click','.pay-salary',function(){
        var id = $(this).attr('data-id');
        $.ajax({
            url: uRL + '/admin/pay-employee-salary',
            type: 'POST',
            data: {id:id},
            success: function (dataResult) {
                console.log(dataResult);
                if (dataResult == '1') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Salary Sheet Updated Succesfully.'
                    });
                    setTimeout(function () { window.location.reload(); }, 1000);
                }else{
                    Toast.fire({
                        icon: 'warning',
                        title: dataResult
                    });
                }
            }
        });
    });
});