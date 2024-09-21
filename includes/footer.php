</div>
<p></p><br>

<footer>
<div class="copyright">
            &copy; 2024-2025 Your Website Name. All rights reserved.
        </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js
"></script>
<script>
        $(document).ready(function(){
            // Show body content on keydown event
            $(document).on('keydown', function(){
                $('body').show();
            });

            // Handle both keyup and submit events
            $('#searchForm').on('submit keyup', function(event){
                if (event.type === 'submit' || (event.type === 'keyup' && event.keyCode === 13)) {
                    event.preventDefault(); // Prevent form submission
                    var query = $('#searchQuery').val(); // Get search query
                    $.ajax({
                        type: 'POST',
                        url: 'search.php',
                        data: {query: query},
                        success: function(response){
                            $('#searchResults').html(response); // Display search results
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>