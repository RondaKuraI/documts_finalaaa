<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>
<div class="container-fluid position-relative d-flex p-0">

    <!-- Sidebar Start -->
    <?= $this->include("partials/sidebar"); ?>
    <!-- Sidebar End -->


    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <?= $this->include("partials/navbar"); ?>
        <!-- Navbar End -->

        <!-- Add Student Modal -->
        <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="studentModalLabel">Add Student</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Full Name</label><span id="error_name" class="text-danger ms-3"></span>
                            <input type="text" class="form-control name" placeholder="Enter your full name">
                        </div>
                        <div class="form-group">
                            <label>Email</label><span id="error_email" class="text-danger ms-3"></span>
                            <input type="text" class="form-control email" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label>Phone</label><span id="error_phone" class="text-danger ms-3"></span>
                            <input type="text" class="form-control phone" placeholder="Enter your phone number">
                        </div>
                        <div class="form-group">
                            <label>Course</label><span id="error_course" class="text-danger ms-3"></span>
                            <input type="text" class="form-control course" placeholder="Enter your course">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary ajaxfilename-save">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Student Modal -->
        <div class="modal fade" id="studentViewModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="studentModalLabel">Student View</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4> ID: <span class="id_view"></span> </h4>
                        <h4> Name: <span class="name_view"></span> </h4>
                        <h4> Email: <span class="email_view"></span> </h4>
                        <h4> Phone: <span class="phone_view"></span> </h4>
                        <h4> Course: <span class="course_view"></span> </h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary ajaxfilename-save">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Student Modal -->
        <div class="modal fade" id="studentEditModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="studentModalLabel">Edit Student</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <input type="hidden" id="stud_id">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" id="stud_name" class="form-control name" placeholder="Enter your full name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" id="stud_email" class="form-control email" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" id="stud_phone" class="form-control phone" placeholder="Enter your phone number">
                        </div>
                        <div class="form-group">
                            <label>Course</label>
                            <input type="text" id="stud_course" class="form-control course" placeholder="Enter your course">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary ajaxstudent-update">Update</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Student Modal -->
        <div class="modal fade" id="studentDeleteModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="studentModalLabel">Student Delete</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="student_delete_id">
                        <h4>Are you sure you want to delete this data?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger ajaxstudent-delete">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid pt-4 px-4">
            <div class="col-12 col-sm-12 text-center text-sm-start">
                <div class="card bg-secondary">
                    <div class="card-header">
                        <h4>jQuery Ajax CRUD
                            <a href="#" data-bs-toggle="modal" data-bs-target="#studentModal" class="btn btn-primary float-end">Add</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Course</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="studentdata">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script>

    $(document).ready(function () {
        loadstudent();

        $(document).on('click', '.view_btn', function () {
            var stud_id = $(this).closest('tr').find('.stud_id').text();
            // alert(stud_id);

            $.ajax({
                method: "POST",
                url: "ajax-student/view_student",
                data: {
                    'stud_id' : stud_id,
                },
                success: function (response) {
                    // console.log(response);
                    $.each(response, function (key, stud_view) { 
                        //  console.log(stud_view['name']);
                        $('.id_view').text(stud_view['id']);
                        $('.name_view').text(stud_view['name']);
                        $('.email_view').text(stud_view['email']);
                        $('.phone_view').text(stud_view['phone']);
                        $('.course_view').text(stud_view['course']);
                        $('#studentViewModal').modal('show');
                    });
                }
            });

        });

        $(document).on('click', '.edit_btn', function () {
            var stud_id = $(this).closest('tr').find('.stud_id').text();

            $.ajax({
                method: "POST",
                url: "ajax-student/edit",
                data: {
                    'stud_id' : stud_id
                },
                success: function (response) {
                    // console.log(response);
                    $.each(response, function (key, stud_value) { 
                         $('#stud_id').val(stud_value['id']);
                         $('#stud_name').val(stud_value['name']);
                         $('#stud_email').val(stud_value['email']);
                         $('#stud_phone').val(stud_value['phone']);
                         $('#stud_course').val(stud_value['course']);
                         $('#studentEditModal').modal('show');
                    });
                }
            });
        });

        $(document).on('click', '.ajaxstudent-update', function () {
            var data = {
                'stud_id' : $('#stud_id').val(),
                'name' : $('#stud_name').val(),
                'email' : $('#stud_email').val(),
                'phone' : $('#stud_phone').val(),
                'course' : $('#stud_course').val(),
            };

            $.ajax({
                method: "POST",
                url: "ajax-student/update",
                data: data,
                success: function (response) {
                    $('#studentEditModal').modal('hide');
                    $('.studentdata').html("");
                    loadstudent();
                    
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(response.status);
                }
            });
        });

        $(document).on('click', '.delete_btn', function () {
            var stud_id = $(this).closest('tr').find('.stud_id').text();
            // alert(stud_id);
            $('#student_delete_id').val(stud_id);
            $('#studentDeleteModal').modal('show');
        });

        $(document).on('click', '.ajaxstudent-delete', function () {
            var stud_id = $('#student_delete_id').val();

            $.ajax({
                method: "POST",
                url: "ajax-student/delete",
                data: {
                    'stud_id' : stud_id
                },
                success: function (response) {
                    $('#studentDeleteModal').modal('hide');
                    $('.studentdata').html("");
                    loadstudent();
                    
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(response.status);
                }
            });
        });

    });

    function loadstudent(){
        $.ajax({
            method: "GET",
            url: "/ajax-students/getdata",
            success: function (response) {
                // console.log(response.students);
                $.each(response.students, function (key, value) { 
                    // console.log(value['name']);
                    $('.studentdata').append('<tr>\
                        <td class="stud_id">'+value['id']+'</td>\
                        <td>'+value['name']+'</td>\
                        <td>'+value['email']+'</td>\
                        <td>'+value['phone']+'</td>\
                        <td>'+value['course']+'</td>\
                        <td>'+value['created_at']+'</td>\
                        <td>\
                            <a href="#" class="badge btn-success view_btn">View</a>\
                            <a href="#" class="badge btn-primary edit_btn">Edit</a>\
                            <a href="#" class="badge btn-danger delete_btn">Delete</a>\
                        </td>\
                    </tr>');
                });
            }
        });
    }

</script>

<script>
    $(document).ready(function () {
        $(document).on('click','.ajaxfilename-save', function () {
            if($.trim($('.name').val()).length == 0){
                error_name = 'Please enter full name';
                $('#error_name').text(error_name);
            }
            else{
                error_name = '';
                $('#error_name').text(error_name);
            }

            if($.trim($('.email').val()).length == 0){
                error_email = 'Please enter email';
                $('#error_email').text(error_email);
            }
            else{
                error_email = '';
                $('#error_email').text(error_email);
            }

            if($.trim($('.phone').val()).length == 0){
                error_phone = 'Please enter phone';
                $('#error_phone').text(error_phone);
            }
            else{
                error_phone = '';
                $('#error_phone').text(error_phone);
            }

            if($.trim($('.course').val()).length == 0){
                error_course = 'Please enter course';
                $('#error_course').text(error_course);
            }
            else{
                error_course = '';
                $('#error_course').text(error_course);
            }

            if(error_name != '' || error_email != '' || error_phone != '' || error_course != ''){
                return false;
            }
            else{
                var data = {
                    'name' : $('.name').val(),
                    'email' : $('.email').val(),
                    'phone' : $('.phone').val(),
                    'course' : $('.course').val(),
                }

                $.ajax({
                    method: "POST",
                    url: "/ajax-student/store",
                    data: data,
                    success: function (response) {
                        $('#studentModal').modal('hide');
                        $('#studentModal').find('input').val('');

                        $('.studentdata').html("");
                        loadstudent();

                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(response.status);
                    }
                });
            }

        });
    });
</script>

<?= $this->endSection(); ?>