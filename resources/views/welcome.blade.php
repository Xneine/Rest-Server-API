<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <title>Xneine Portal</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Xneine Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="#">Search News By ID</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Latest News</h2>
        <div id="loading" class="text-center my-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div id="posts" class="row row-cols-1 row-cols-md-2 g-4"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'http://api-laravel.test/api/posts ',
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    // console.log('tararararara');
                    $('#loading').hide(); // Sembunyikan loading spinner
                    if (result.status) {
                        let posts = result.data;
                        $.each(posts, function(i, data) {
                            // Batasi news_content menjadi maksimal 100 karakter
                            let truncatedContent = data.news_content.length > 100 ?
                                data.news_content.substring(0, 100) + "..." :
                                data.news_content;

                            $('#posts').append(`
                                <div class="col">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body">
                                        <h5 class="card-title">${data.title}</h5>
                                        <p class="card-text">${truncatedContent}</p>
                                        </div>
                                        <div class="card-footer text-muted text-end">
                                        <small>by ${data.writer}</small>
                                    </div>
                                </div>
                                 </div>
                            `);
                        });

                    } else {
                        $('#posts').html(
                            '<p class="text-center text-danger">No posts available at the moment ✌️.</p>'
                        );
                    }
                },
                error: function() {
                    $('#loading').hide();
                    $('#posts').html(
                        '<p class="text-center text-danger">Failed to load posts. Please try again later.</p>'
                    );
                }
            });
        });
    </script>
</body>

</html>
