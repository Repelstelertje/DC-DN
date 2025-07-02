<?php
  $base = __DIR__;
  include $base . '/includes/array_prov.php';
  include $base . '/includes/utils.php';

  $zoek = null;
  if (isset($_GET['item'])) {
    $provincie = strip_bad_chars($_GET['item']);
    if (isset($provincies[$provincie])) {
      $zoek = $provincies[$provincie];
    }
  }

  if (!$zoek) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    include $base . '/404.php';
    exit;
  }

  $metaDescription = $zoek['meta'];

  include $base . '/includes/header.php';
?>
<div class="container">
  <div class="jumbotron my-4">
    <h1 class="text-center"><?php echo $zoek['title']; ?></h1>
    <hr>
		<p><?php echo $zoek['intro']; ?></p>
  </div>
  <div class="row" v-cloak>
    <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item" id="Slankie" v-for="profile in filtered_profiles">
      <div class="card h-100">
        <a :href="'<?php echo $baseUrl; ?>/daten-met-' + slugify(profile.name) + '?id=' + profile.id"><img class="card-img-top" :src="profile.src.replace('150x150', '300x300')" :alt="'Daten in ' + profile.province + ' met ' + profile.name" :title="'Bekijk het profiel van ' + profile.name + ' uit ' + profile.city" @error="imgError"></a>
        <div class="card-body">
          <div class="card-top">
            <h4 class="card-title">{{ profile.name }}</h4>  
          </div>
          <ul class="list-group">
            <li class="list-group-item">Leeftijd: {{ profile.age }}</li>
            <li class="list-group-item">Relatie: {{ profile.relationship }}</li>
            <li class="list-group-item">Stad: {{ profile.city }}</li>
            <li class="list-group-item">Provincie: {{ profile.province }}</li>
          </ul>
        </div>
        <a :href="'<?php echo $baseUrl; ?>/daten-met-' + slugify(profile.name) + '?id=' + profile.id" class="card-footer btn btn-primary">Bekijk profiel</a></div>
      </div>
    </div>
  </div><!-- /.row -->
  <script>
    var api_url = "<?php echo $config['PROVINCE_ENDPOINT'] . '/' . $zoek['name'] . '/120'; ?>";
  </script>
  <!-- Pagination -->
  <nav class="nav-pag" aria-label="Page navigation">
    <ul class="pagination flex-wrap justify-content-center">
      <li class="page-item">
        <a class="page-link" aria-label="Vorige" v-on:click="set_page_number(page-1)"><span aria-hidden="true">&laquo;</span><span class="sr-only">Vorige</span></a>
      </li>
      <li v-for="page_number in max_page_number" class="page-item" v-bind:class="{ active: page_number == page }">
        <a class="page-link" v-on:click="set_page_number(page_number)">{{ page_number }}</a>
      </li>
      <li class="page-item">
        <a class="page-link" aria-label="Volgende" v-on:click="set_page_number(page+1)"><span aria-hidden="true">&raquo;</span><span class="sr-only">Volgende</span></a>
      </li>
    </ul>
  </nav>
<div class="container">
  <div class="jumbotron">
    <?php echo $zoek['tekst']; ?>
  </div>
  <div class="jumbotron text-center">
    <a href="https://18date.net/sexdate-<?php echo $zoek['img']; ?>" class="btn btn-primary btn-tips" target="_blank">18+ Sexdate <?php echo $zoek['name']; ?></a>
    <a href="https://sex55.net/sexdate-<?php echo $zoek['img']; ?>" class="btn btn-primary btn-tips" target="_blank">55+ Sexdate <?php echo $zoek['name']; ?></a>
    <a href="https://shemaledaten.net/shemale-<?php echo $zoek['img']; ?>" class="btn btn-primary btn-tips" target="_blank">Shemale sexdate <?php echo $zoek['name']; ?></a>
  </div>
</div> <!-- container -->
<?php include $base . '/includes/footer.php'; ?>
