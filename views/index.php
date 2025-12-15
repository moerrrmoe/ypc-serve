<?php
require_once __DIR__ . '/../controller/comic-controller.php';
require_once __DIR__ . '/components/card.php';



$comics = (new comicController())->getAllComics();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<?php include __DIR__ . '/components/header.php'; ?>
<body>
    <div class="container p-2">
        <div class="row  row-cols-3 w-100 mx-auto row-cols-md-4 row-cols-lg-6 g-4">
            <?php
                foreach($comics as $comic){
                    $card = new Card($comic->id,$comic->title,$comic->poster);
                    $card->renderCard();
                }
            ?>
        </div>
    </div>
    <script>
            document.getElementById('back-btn').style.display = "none"
    </script>
</body>
<footer>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2025 Copyright:
            <a class="text-white" href="#">yotepyaclub.com</a>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</footer>
</html>