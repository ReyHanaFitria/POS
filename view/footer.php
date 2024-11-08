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
<script>
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