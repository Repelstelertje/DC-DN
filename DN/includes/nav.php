<ul class="navbar-nav ml-auto">
    <!-- Land links -->
<?php foreach ($navCountries as $land) { ?>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $land['slug']; ?>"><?php echo $land['title']; ?></a>
        </li>
<?php } ?>
    <li class="nav-item">
        <a class="nav-link" href="/datingtips">Datingtipps</a>
    </li>
    <!-- Datingtips links -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle drpdwn" href="#" id="navbarDropdownTips" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Datingtipps</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownTips">
            <?php foreach ($datingtips as $slug => $tip) {
                    if (!empty($tip['name'])) {
                        echo "<a class=\"dropdown-item\" href=\"datingtips.php?tip=$slug\">{$tip['name']}</a>";
                    }
            } ?>
        </div>
    </li>
    <!-- Nieuwe sociale media links -->
    <li class="nav-item">
        <a class="nav-link" href="https://facebook.com/DateDeutschland" target="_blank"><img src="img/fb.png" alt="Facebook Date Deutschland"></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="https://instagram.com/shemaledeutschland" target="_blank"><img src="img/ig.png" alt="Instagram Shemale Deutschland"></a>
    </li>
</ul>
