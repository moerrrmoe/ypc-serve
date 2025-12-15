<?php
    include_once __DIR__.'/../../controller/comic-controller.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<?php
    include_once __DIR__.'/../components/header.php';
    ?>
<body>
    
    <div class="container">
    <button onclick="location.href = './pages/add new.php'" type="button" class="btn btn-primary mb-3">Add New</button>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Actions</th>
            </tr>
            <tr>
                <?php
                    $controller = new comicController();
                    $comics = $controller->getAllComics();
                    foreach($comics as $comic){
                        echo '<tr>
                                <td>'.$comic->id.'</td>
                                <td>'.$comic->title.'</td>
                                <td>
                                    <a href="/ypc%20server/adm/pages/edit.php?id='.$comic->id.'" class="btn btn-primary">Edit</a>
                                    <a href="delete-comic.php?id='.$comic->id.'" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>';
                    }
                ?>
            </tr>
        </thead>
    </table>
    </div>
</body>
<?php
    include_once __DIR__.'/../components/footer.php';
?>
</html>
