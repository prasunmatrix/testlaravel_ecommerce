<!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y'); ?></strong>
    All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('resources/assets/admin/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('resources/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('resources/assets/admin/dist/js/adminlte.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('resources/assets/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('resources/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('resources/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('resources/assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('resources/assets/admin/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('resources/assets/admin/dist/js/demo.js') }}"></script>
<script src="{{ asset('resources/assets/admin/dist/js/pages/dashboard3.js') }}"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>