<?php
  $base = __DIR__;
  include $base . '/includes/array_prov.php';
  include $base . '/includes/utils.php';

        $country = '';
        if(isset($_GET['item'])) {
                $provincie = strip_bad_chars($_GET['item']);
                if (isset($de[$provincie])) {
                        $zoek = $de[$provincie];
                        $country = 'de';
                } elseif (isset($at[$provincie])) {
                        $zoek = $at[$provincie];
                        $country = 'at';
                } elseif (isset($ch[$provincie])) {
                        $zoek = $ch[$provincie];
                        $country = 'ch';
                } else {
                        header('Location: 404.php');
                        exit;
                }
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
    <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item" id="Slankie" v-for="profile in filtered_profiles" >
      <div class="card h-100">
          <a href="<?php echo $baseUrl; ?>/profile?id={{ profile.id }}" :href="'<?php echo $baseUrl; ?>/date-mit-' + slugify(profile.name) + '?id=' + profile.id"><img class="card-img-top" :src="profile.src.replace('150x150', '300x300')" :alt="'Dating in ' + profile.province + ' mit ' + profile.name" :title="'Siehe das Profil von ' + profile.name + ' aus ' + profile.city" @error="imgError"></a>
          <div class="card-body">
            <div class="card-top">
                <h4 class="card-title">{{ profile.name }}</h4>  
            </div>
            <ul class="list-group">
              <li class="list-group-item">Alter: {{ profile.age }}</li>
              <li class="list-group-item">Familienstand: {{ profile.relationship }}</li>
              <li class="list-group-item">Stadt: {{ profile.city }}</li>
              <li class="list-group-item">Bundesland: {{ profile.province }}</li>
            </ul>
          </div>
          <a href="<?php echo $baseUrl; ?>/profile?id={{ profile.id }}" :href="'<?php echo $baseUrl; ?>/date-mit-' + slugify(profile.name) + '?id=' + profile.id" class="card-footer btn btn-primary">Profil ansehen</a></div>
      </div>
    </div>
  </div><!-- /.row -->
  <script>
    var api_url = "<?php echo $config['PROVINCE_ENDPOINT'] . '/' . rawurlencode($zoek['name']) . '/120'; ?>";
  </script>
  <!-- Pagination -->
  <nav class="nav-pag" aria-label="Page navigation">
    <ul class="pagination flex-wrap justify-content-center">
      <li class="page-item">
        <a class="page-link" aria-label="Zurück" v-on:click="set_page_number(page-1)"><span aria-hidden="true">&laquo;</span><span class="sr-only">Zurück</span></a>
      </li>
      <li v-for="page_number in max_page_number" class="page-item" v-bind:class="{ active: page_number == page }">
        <a class="page-link" v-on:click="set_page_number(page_number)">{{ page_number }}</a>
      </li>
      <li class="page-item">
        <a class="page-link" aria-label="Nächste" v-on:click="set_page_number(page+1)"><span aria-hidden="true">&raquo;</span><span class="sr-only">Nächste</span></a>
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
  </div>
</div> <!-- container -->
<?php include $base . '/includes/footer.php'; ?>
