<?php
$base = __DIR__;
$pageTitle = '404 | Page not found - Dating Contact';
$metaRobots = 'noindex,follow';
include $base . '/includes/header.php';
?>

<div class="container">
	<div class="jumbotron my-4">
    	<div class="text-center" style="min-height: 400px;">
       		<h1>Oops!</h1>
       		<h2>Unfortunately, the requested page was not found.</h2>
          	<p>Reasons may include:<br />1. The profile you are trying to access no longer exists.<br />2. The web address has not been entered correctly.<br /><br />Use the menu on this page to make a new selection.</p>
            <a href="index.php" class="btn btn-primary"> Homepage </a>
			<?php
				foreach ($navItems as $item) {
				echo "<a class=\"btn btn-primary\" href=\"$item[slug]\" style=\"margin: 1px;\">$item[title]</a>";
				}
			?>
        </div>
	</div>
</div>
<?php
	include $base . '/includes/footer.php';
?>
