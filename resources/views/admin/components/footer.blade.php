<div class="modal fade" id="view-application">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Leaves Application View</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span id="id"></span>
                        <strong>Date :</strong>
                        <span id="date"></span>
                        <hr>
                        <strong>Leave Type:</strong>
                        <span id="leave_type"></span>
                        <hr>
                        <strong>Reason:</strong>
                        <span id="reason"></span>
                        <hr>
                        <strong>Status:</strong>
                        <span id="status"></span>
                        <hr>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

<!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>{{$siteInfo->copyright_text}} <a href="https://github.com/sikuning" target="_blank">Sikuning</a></strong>
        </footer>
        <input type="hidden" class="demo" value="{{url('/')}}"></input>
    <!-- ./wrapper -->
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('public/assets/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('public/assets/js/moment.min.js')}}"></script>
    <script src="{{asset('public/assets/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- InputMask -->
    <script src="{{asset('public/assets/js/jquery.inputmask.bundle.min.js')}}"></script>
    <script src="{{asset('public/assets/js/bootstrap-iconpicker.bundle.min.js')}}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{asset('public/assets/js/bs-custom-file-input.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{asset('public/assets/js/daterangepicker.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('public/assets/js/adminlte.js')}}"></script>

    <!-- jquery-validation -->
    <script src="{{asset('public/assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('public/assets/js/additional-methods.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('public/assets/js/summernote-bs4.min.js')}}"></script>
    <!-- SweetAlert -->
    <script src="{{asset('public/assets/js/sweetalert2.min.js')}}"></script>
    <!-- Main_ajax.js -->
    <script src="{{asset('public/assets/js/main_ajax.js')}}"></script>

    <input type="hidden" class="demo" value="{{url('/')}}"></input>
    <script>
        $(function () {
            // $(document).on("click", '.att-check', function(event) {
            //     $(this).bind('change',showHideLeaveBox);
            // });
            function showHideLeaveBox(id){
                alert(id);
                if($('#attendance-status' + id + ':checked').val() == 'on'){
                    $('#leaveform' + id).addClass("d-none");
                }else{
                    $('#leaveform' + id).removeClass("d-none");
                }
            }

            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            $('#reservationdate_1').datetimepicker({
                format: 'L'
            });

            $('#reservationdate_2').datetimepicker({
                format: 'L'
            });

            $('#reservationdate_3').datetimepicker({
                format: 'L'
            });
            //Money Euro
            $('[data-mask]').inputmask()
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        $(function () {
            // Summernote
            $('.textarea').summernote()
        })
    </script>

    @yield('pageJsScripts')
</body>
</html>
