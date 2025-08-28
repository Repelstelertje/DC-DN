<?php
$base = __DIR__;
$pageTitle = '404 | Page not found - Dating Nebenan';
$metaRobots = 'noindex,follow';
include $base . '/includes/header.php';
?>

<div class="container">
	<div class="jumbotron my-4">
    	<div class="text-center" style="min-height: 400px;">
       		<h1>Hoppla!</h1>
       		<h2>Leider wurde die angeforderte Seite nicht gefunden.</h2>
          	<p>	Gründe dafür können sein:<br />1. Das Profil, auf das Sie zuzugreifen versuchen, existiert nicht mehr.<br />2. Die Webadresse ist nicht korrekt eingegeben worden.<br /><br />Verwenden Sie das Menü auf dieser Seite, um eine neue Auswahl zu treffen.</p>
        	<a href="index.php" class="btn btn-primary"> Startseite </a>
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
