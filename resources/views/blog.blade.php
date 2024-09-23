<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-4">
        <div class="grid grid-cols-3 gap-4">
            <!-- List All Posts -->
            <div class="col-span-1">
                <h2 class="text-xl font-bold">All Posts</h2>
                <!-- Search Bar -->
                <div class="mb-4">
                    <input type="text" id="search" class="border rounded p-2 w-full" placeholder="Search posts by title...">
                </div>
                <ul id="post-list" class="mt-4 space-y-2">
                    <!-- Post titles will be appended here by jQuery -->
                </ul>
            </div>

            <!-- Post Detail -->
            <div class="col-span-2">
                <h2 class="text-xl font-bold">Post Detail</h2>
                <div id="post-detail" class="mt-4">
                    <!-- Post detail will be loaded here via Ajax -->
                    <p class="text-gray-500">Click a post to see details.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let searchQuery = '';
    
            // Load posts on page load
            loadPosts(1);
    
            function loadPosts(page) {
                $.get(`/posts?page=${page}&search=${searchQuery}`, function (data) {
                    $('#post-list').empty();
                    data.data.forEach(post => {
                        $('#post-list').append(`<li class="cursor-pointer" data-id="${post.id}">${post.title}</li>`);
                    });
    
                    // Handle pagination links
                    let pagination = '';
                    for (let i = 1; i <= data.last_page; i++) {
                        pagination += `<button class="pagination-btn" data-page="${i}">${i}</button>`;
                    }
                    $('#pagination').html(pagination);
                });
            }
    
            // Click event to load post detail
            $('#post-list').on('click', 'li', function () {
                const postId = $(this).data('id');
                $.get(`/posts/${postId}`, function (post) {
                    $('#post-detail').html(`
                        <h3 class="text-2xl font-bold">${post.title}</h3>
                        <p class="mt-4">${post.content}</p>
                    `);
                });
            });
    
            // Click event for pagination buttons
            $('#pagination').on('click', '.pagination-btn', function () {
                const page = $(this).data('page');
                loadPosts(page);
            });
    
            // Search functionality
            $('#search').on('keyup', function () {
                searchQuery = $(this).val();
                loadPosts(1); // Reload posts with the search query
            });
        });
    </script>
    
    <div id="pagination" class="mt-4 space-x-2"></div>
    
</body>
</html>
