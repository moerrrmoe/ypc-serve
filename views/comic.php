<?php
if ($comic) {
    include __DIR__ . '/components/modal.php';
?>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $comic->title ?></title>
        <style>
            .ep-btn:hover {
                /* Darker blue on hover */
                color: blue;
                /* White text on hover */
            }
        </style>
    </head>
    <?php include_once __DIR__ . '/components/header.php' ?>

    <body>
        <div style="max-width: 750px;" class="container p-3 w-100">
            <div class="card mb-3">
                <div class="row g-0">
                    <div style="width:100px; height:100%" class="col-4">
                        <img src="<?php echo $comic->poster ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $comic->title ?></h5>
                            <p class="card-text"><?php echo $comic->review ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-cols-2 row-cols-md-3 text-center">
                <?php
                $eps = [];
                foreach (array_reverse($comic->api) as $a) {
                    $trimmed = str_replace("&callback=epList", "", $a);
                    $raw = file_get_contents($trimmed);
                    $entries = (json_decode($raw, true))["feed"]["entry"];
                    foreach ($entries as $entry) {
                        array_push($eps, ["title" => $entry["title"]["\$t"],"link"=>$entry["link"][4]["href"]]);
                    }
                };

                foreach ($eps as $key=>$ep) {
                    echo "<div onclick='showIframe(this)' index='".$key."' uri='".$ep["link"]."' class='col ep-btn border bg-light p-2'>" . $ep["title"] . "</div>";
                };
                ?>
            </div>
        </div>
        <script>
            const episodes = <?php echo json_encode($eps) ?>

            console.log(episodes)
        </script>
    </body>
    <footer>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2025 Copyright:
            <a class="text-white" href="#">yotepyaclub.com</a>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="http://localhost/ypc%20server/views/js/comic.js"></script>
    </footer>

    </html>
<?php
} else {
    echo 'bad request';
    die();
}
?>