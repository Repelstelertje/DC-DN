<ul class="navbar-nav ml-auto">
    <!-- Provincie links -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle drpdwn" href="#" id="navbarDropdownProvinces" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Date in the UK</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownProvinces">
            <?php foreach ($navItems as $item) { echo "<a class=\"dropdown-item\" href=\"{$baseUrl}/{$item['slug']}\">{$item['title']}</a>"; } ?>
        </div>
    </li>
    <!-- Datingtips links -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle drpdwn" href="#" id="navbarDropdownTips" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dating Tips</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownTips">
            <?php foreach ($navItems2 as $item2) {echo "<a class=\"dropdown-item\" href=\"$baseUrl/$item2[slug]\">$item2[title]</a>";} ?>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo $baseUrl; ?>/members">Members</a>
    </li>
    <!-- Nieuwe sociale media links -->
    <li class="nav-item">
        <a class="nav-link" href="https://facebook.com/ukdate" target="_blank"><img src="img/fb.png" alt="Facebook UK Date"></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="https://instagram.com/shemaleunitedkingdom" target="_blank"><img src="img/ig.png" alt="Instagram UK Date"></a>
    </li>
</ul>
