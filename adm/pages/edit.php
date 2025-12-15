<?php
    include_once __DIR__.'/../../controller/comic-controller.php';
    $controller = new comicController();
    
    if(!isset($_GET['id'])){
        die("error");
    }
    $comic = $controller->getComicById($_GET['id']);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comic</title>
</head>
<?php
    include_once __DIR__.'/../components/header.php';
?>
<body>
    <div class="container">
        <h1>Edit Comic: <?php echo $comic->title; ?></h1>

    
    <form action="">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input onchange="comic.title = this.value" type="text" value="<?php echo $comic->title; ?>" class="form-control" id="title" aria-describedby="titleHelp">
            <div id="titleHelp" class="form-text">Enter the title of the comic.</div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="img-upload">Img upload</label>
            <div class="input-group">
                <input name="img-upload" class="form-control" type="file" id="img-upload" accept="image/*">
                <button type="button" onclick="uploadImg()" class="btn btn-primary">Upload</button>
                
            </div>
            <div class="form-text mb-3">upload img via this</div>
            
            <label for="poster" class="form-label">Poster URL</label>
            <input onchange="comic.poster = this.value" type="text" value="<?php echo $comic->poster; ?>" class="form-control" id="poster">
        </div>
        <div>
            <label for="api" class="form-label">API URLS</label>
            <div id="api-wrapper">
            <?php
            foreach($comic->api as $i => $api){
                echo '<div class="mb-3 api-input-group input-group" index="'.$i.'" id="api_'.$i.'">
                        <input onchange="onChangeApi('.$i.',this)" type="text" value="'.$api.'" class="form-control api-input" >
                        <button onclick="removeApi('.$i.')" type="button" class="btn btn-danger">remove</button>
                    </div>';
            }
            ?>
            </div>
            <button onclick="addApi()" class="btn btn-primary" type="button">Add New</button>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input onchange="comic.status = this.value" type="text" value="<?php echo $comic->status; ?>" class="form-control" id="status">
        </div>
        <div class="mb-3">
            <label for="review" class="form-label">Review</label>
            <textarea onchange="comic.review = this.value" class="form-control" id="review" rows="3"><?php echo $comic->review; ?></textarea>
        </div>
        <label for="vip_last" class="form-label">VIP Last</label>
        <div class="mb-3 input-group">

            <input onchange="comic.vip_last = this.value" type="text" value="<?php echo $comic->vip_last; ?>" class="form-control" id="vip_last">
            <button class="btn btn-primary" type="button">Update</button>
        </div>
        <label for="free_last" class="form-label">Free Last</label>
        <div class="mb-3 input-group">
            <input onchange="comic.free_last = this.value" type="text" value="<?php echo $comic->free_last; ?>" class="form-control" id="free_last">
            <button class="btn btn-primary" type="button">Update</button>
        </div>
        <div class="mb-3">
            
            <input name="rc" class="form-check-input" id="rc-check" type="checkbox">
            <label class="form-check-label" for="rc">Recommend</label>
        </div>
        <button id="submit" type="button" class="btn btn-primary">Submit</button>
    </form>
    </div>
    <script>
        const comic = <?php echo json_encode($comic); ?>;
    </script>
    <script src="../js/edit.js"></script>
</body>
<?php
    include_once __DIR__.'/../components/footer.php';
?>
</html>