<div class="card mt-2 fixed-bottom">
    <div class="card-body text-center">
        &copy; 2024 Aplikasi UKK Kasir Kelompok 4
    </div>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include JS Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    text: 'Copy',
                    className: 'btn btn-secondary' // Kelas Bootstrap
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    className: 'btn btn-info' // Kelas Bootstrap
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    className: 'btn btn-success' // Kelas Bootstrap
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    className: 'btn btn-danger' // Kelas Bootstrap
                },
                {
                    extend: 'print',
                    text: 'Print',
                    className: 'btn btn-primary' // Kelas Bootstrap
                }
            ],
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            pageLength: 10,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/Indonesian.json'
            },
            initComplete: function() {
                // Mengubah kelas tombol setelah DataTable diinisialisasi
                $('.buttons-html5').removeClass('dt-button').addClass('btn-primary');
                $('.buttons-print').removeClass('dt-button').addClass('btn-primary');
            }
        });
    });

    function loadPage(url) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#content').html(response); // Update the content area with the response
            },
            error: function(xhr, status, error) {
                console.log('Error loading page: ' + error);
            }
        });
        return false; // Prevent default link behavior
    }
</script>
</body>

</html>