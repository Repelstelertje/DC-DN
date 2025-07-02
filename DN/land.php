<?php
    include('includes/array_prov.php');
    include('includes/utils.php');

    $land = isset($_GET['land']) ? strip_bad_chars($_GET['land']) : '';
    switch ($land) {
        case 'de':
            $provArray = $de;
            $landInfo  = $deLand;
            $landTitle = 'Deutschland';
            break;
        case 'at':
            $provArray = $at;
            $landInfo  = $atLand;
            $landTitle = 'Österreich';
            break;
        case 'ch':
            $provArray = $ch;
            $landInfo  = $chLand;
            $landTitle = 'Schweiz';
            break;
        default:
            $provArray = [];
            $landInfo  = [];
            $landTitle = '';
    }
    if (empty($landTitle)) {
        header('Location: 404.php');
        exit;
    }

    $metaDescription = isset($landInfo['meta']) ? $landInfo['meta'] : '';

    define('TITLE', 'Dating ' . $landTitle);
    $base = __DIR__;
    include $base . '/includes/header.php';
?>
<div class="container">
    <div class="jumbotron my-4" >
        <h1 class="text-center"><?php echo $landInfo['title']; ?></h1>
        <hr>
        <p><?php echo $landInfo['intro']; ?></p>
    </div>
    <div class="row text-center" id="keuze">
    <?php
      foreach ($provArray as $slugKey => $item) {
          $slug = 'dating-' . $slugKey;
    ?>
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card h-100 text-left">
        <a href="<?php echo $slug; ?>"><img class="card-img-top" src="img/front/<?php echo $item['img']; ?>.jpeg" alt="Sexdate <?php echo $item['name']; ?>" @error="imgError"></a>
        <div class="card-body">
          <a href="<?php echo $slug; ?>"><h4 class="card-title"><?php echo $item['name']; ?></h4></a>
          <hr>
          <p class="card-text"><?php echo $item['meta']; ?></p>
        </div>
        <a href="<?php echo $slug; ?>" class="card-footer btn btn-primary">Dating <?php echo $item['name']; ?></a>
      </div>
    </div>
    <?php } ?>
    </div>
    <div class="jumbotron">
        <?php echo $landInfo['tekst']; ?>
    </div>
</div><!-- container -->
<?php include('includes/footer.php'); ?>

