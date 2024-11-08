<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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