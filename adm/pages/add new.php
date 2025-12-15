<?php
    include_once __DIR__.'/../../controller/comic-controller.php';
    require_once __DIR__.'/../../models/comic.php';
    $controller = new comicController();
    $comic = new Comic();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New</title>
</head>
<?php
    include_once __DIR__.'/../components/header.php';
?>
<body>
    <div class="container">
        <h1>Add New: <?php echo $comic->title; ?></h1>

    
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
            <label for="poster" class="form-label">Poster URL</label>
            <input onchange="comic.poster = this.value" type="text" value="<?php echo $comic->poster; ?>" class="form-control" id="poster">
        </div>
        <div>
            <label for="api" class="form-label">API URLS</label>
            <div id="api-wrapper">
            <div class="mb-3 api-input-group input-group" index="0" id="api_0">
                <input onchange="onChangeApi(0,this)" type="text" value="" class="form-control api-input" id="api_0">
                <button onclick="removeApi(0)" type="button" class="btn btn-danger">remove</button>
            </div>
            </div>
            <button class="btn btn-primary" type="button" onclick="addApi()">Add New</button>
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
        <button id="submit" type="button" class="btn btn-primary">Submit</button>
    </form>
    </div>
    <script>
        const comic = <?php echo json_encode($comic); ?>;
        comic.api.push(null);
    </script>
    <script src="../js/add.js"></script>
</body>
<?php
    include_once __DIR__.'/../components/footer.php';
?>
</html>