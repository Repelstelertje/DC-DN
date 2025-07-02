<?php
$base = __DIR__;
define("TITLE", "Home");
include $base . '/includes/array_prov.php';
$pageTitle = 'Dating Nebenan – Finde Liebe Direkt Um Die Ecke';
include $base . '/includes/header.php';
?>
<div class="container">
    <!-- Jumbotron Header -->
    <div class="jumbotron my-4 text-center">
        <h1>Dating Nebenan – Finde Liebe Direkt Um Die Ecke</h1>
        <hr>
        <p>Entdecke deine nächste Liebe bei <a href="index.php">Dating Nebenan</a>, deinem vertrauenswürdigen Portal für kontaktanzeigen, wo die Suche nach der Liebe dich durch die Schönheit der Provinzen Deutschlands führt. Wir bringen Menschen zusammen, die nach echten Verbindungen und bedeutungsvollen Beziehungen in ihrer unmittelbaren Umgebung suchen. Von Bayern bis Schleswig-Holstein, Dating Nebenan macht es einfach, jemanden Besonderen in deiner Nähe zu finden.</p>
        <h2>Finde hier Frauen in deiner Nähe</h2>
        <div class="d-flex justify-content-center flex-wrap">
            <div class="dropdown d-inline-block prov-btn">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownDe" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $deLand['name']; ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownDe">
                    <?php foreach ($de as $slugKey => $prov) { $slug = 'dating-' . $slugKey; echo "<a class=\"dropdown-item\" href=\"$slug\">{$prov['name']}</a>"; } ?>
                </div>
            </div>
            <div class="dropdown d-inline-block prov-btn">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownAt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $atLand['name']; ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownAt">
                    <?php foreach ($at as $slugKey => $prov) { $slug = 'dating-' . $slugKey; echo "<a class=\"dropdown-item\" href=\"$slug\">{$prov['name']}</a>"; } ?>
                </div>
            </div>
            <div class="dropdown d-inline-block prov-btn">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownCh" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $chLand['name']; ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownCh">
                    <?php foreach ($ch as $slugKey => $prov) { $slug = 'dating-' . $slugKey; echo "<a class=\"dropdown-item\" href=\"$slug\">{$prov['name']}</a>"; } ?>
                </div>
            </div>
        </div>
    </div>
    <div id="top-banner"></div>
    <div class="jumbotron jumbotron-sm text-center">
        <h2>Neue Mitglieder</h2>
    </div>
    <div class="row" v-cloak>
        <div class="col-lg-3 col-md-6 mb-4 portfolio-item" id="Slankie" v-for="profile in filtered_profiles">
            <div class="card h-100">
                <a href="<?php echo $baseUrl; ?>/profile?id={{ profile.id }}" :href="'<?php echo $baseUrl; ?>date-mit-' + slugify(profile.name) + '?id=' + profile.id"><img class="card-img-top" :src="profile.src.replace('150x150', '300x300')" :alt="profile.name + ' daten in Flevoland'" @error="imgError"></a>
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
                <a href="<?php echo $baseUrl; ?>/profile?id={{ profile.id }}" :href="'<?php echo $baseUrl; ?>date-mit-' + slugify(profile.name) + '?id=' + profile.id" class="card-footer btn btn-primary">Profil ansehen</a>
            </div>
        </div>
        <script>
            var api_url= "<?php echo $config['BANNER_ENDPOINT']; ?>";
        </script>
        <!-- Pagination -->
        <nav class="nav-pag" aria-label="Page navigation">
            <ul class="pagination flex-wrap justify-content-center">
                <li class="page-item">
                    <a class="page-link" aria-label="Zurück" v-on:click="set_page_number(page-1)" ><span aria-hidden="true">&laquo;</span><span class="sr-only">Zurück</span></a>
                </li>
                <li v-for="page_number in max_page_number" class="page-item" v-bind:class="{ active: page_number == page }" >
                  <a class="page-link" v-on:click="set_page_number(page_number)">{{ page_number }}</a>
                </li>
                <li class="page-item">
                  <a class="page-link" aria-label="Nächste" v-on:click="set_page_number(page+1)"><span aria-hidden="true">&raquo;</span><span class="sr-only">Nächste</span></a>
                </li>
            </ul>
        </nav>
    </div><!-- /.row -->
    <div class="jumbotron">
        <h2  class="text-center">Was Wir Bieten</h2>
        <p>Unser Herzstück bei <a href="index.php">Dating Nebenan</a> ist die Verbindung von Singles über die Grenzen aller deutschen Provinzen hinweg – von der lebendigen Vielfalt Nordrhein-Westfalens bis zu den malerischen Landschaften Bayerns. Entdecke Liebe in jedem Winkel Deutschlands mit unseren speziell angepassten Features:</p>
        <ul>
            <li><b>Provinzbasierte Suche:</b> Mit unserer fortschrittlichen Suchfunktion kannst du gezielt nach Singles in spezifischen Provinzen suchen. Ob du die Nähe der Küsten von Schleswig-Holstein bevorzugst, die urbanen Zentren von Hessen erkunden möchtest oder die romantischen Straßen Sachsens durchwandern willst – finde den perfekten Partner in deiner gewünschten Region.</li>
            <li><b>Kostenloses Nachrichtenversenden:</b> Der Schlüssel zu einer beginnenden Verbindung sollte nicht hinter einer Paywall versteckt sein. Bei Dating Nebenan kannst du unbegrenzt Nachrichten versenden, ohne dafür bezahlen zu müssen. Wir glauben, dass die Liebe frei fließen sollte, wodurch du ungestört mit deinem potenziellen Partner kommunizieren kannst.</li>
        </ul>
        <p>Unsere Plattform ist darauf ausgerichtet, dir das Finden von tiefen, bedeutungsvollen Beziehungen zu erleichtern – und das alles, ohne dass du dein Zuhause verlassen musst. Die geografische Vielfalt Deutschlands spielt zu deinen Gunsten, indem sie dir ermöglicht, mit Menschen aus verschiedenen Provinzen in Kontakt zu treten, die alle dasselbe Ziel haben: Liebe und Verbundenheit.</p>
    </div>
    <div class="jumbotron">
        <h2 class="text-center">Dating-Erfahrungen</h2>
        <hr>
        <p><em>“Wir (Elisa und Wim) möchten Ihnen wirklich sehr danken!!! Kurz vor dem Sommer haben wir uns über Ihre Website Kleinanzeigen Belgien gefunden. Wir waren beide auf der Suche nach Gesellschaft, nicht unbedingt romantisch oder in einer festen Beziehung. Wir sind beide schon etwas älter und es ist nicht immer leicht, jemanden zu finden, mit dem man eine nette Freundschaft eingehen kann. In unserem Fall war es jedoch alles andere als schwierig. Wir lieben beide ein Spiel und einen netten Plausch zwischendurch und treffen uns wöchentlich, um die Gesellschaft des anderen zu genießen. Wir sind beide viel gereist, und das liegt nun hinter uns, so dass wir uns gegenseitig mit vielen Geschichten unterhalten können! Danke für eure netten Kontakte und dafür, dass ihr uns zusammengebracht habt! Dank der belgischen Kleinanzeigen haben wir einen Partner fürs Leben gefunden.”</em><br />
        <span class="stelletje"> - Elisa und Wim</span></p>
        <hr>
        <p><em>"Mein Name ist Peter und ich habe mich vor etwa 4 Wochen auf Ihrer Dating-Seite angemeldet. Am Anfang war ich etwas skeptisch, schließlich hört man so viele Geschichten über Online-Dating. Nach ein paar Tagen fing ich an, den Dreh raus zu haben und stieß auf Marias Profil. Eine unglaublich nette, spontane Frau mit einem noch netteren Lächeln. Wir kamen ins Gespräch und nach ein paar Wochen beschlossen wir schließlich, uns zu treffen. Es hat wirklich sofort Klick gemacht!!! Ich kann mich gar nicht erinnern, wann ich das letzte Mal mit einer Frau so viel gelacht habe. Sie hat eine Tochter und einen Sohn, für mich fühlt es sich so an, als wäre ich endlich der Vater, da Maria keinen Kontakt mehr zum Vater ihrer Kinder hat. Ich wollte mich also wirklich bei Ihnen bedanken, suchendes Belgien. Ohne Sie hätte ich sie vielleicht nie kennengelernt. Ich danke Ihnen!”</em><br />
        <span class="stelletje"> - Peter und Maria</span></p>
        <hr>
        <p><em>“Mein Name ist Jean. Ich habe vor über einem Jahr mit Online-Dating begonnen, weil es für mich aufgrund meiner Behinderung manchmal schwierig ist, Leute kennenzulernen. Ich bin nämlich seit meiner Geburt sehr schwerhörig. Obwohl das für mich nicht immer eine Hürde darstellt, ist es für manche doch eine ziemliche Herausforderung. Schließlich muss man die Gebärdensprache kennen oder lernen, was für viele eine schwierige Aufgabe ist, und sie entscheiden sich, keine Beziehung einzugehen. Über Ihre Website Zoekertjes België bin ich mit Juliette in Kontakt gekommen. Es stellte sich heraus, dass sie eine kleine Tochter hatte, die ebenfalls in jungen Jahren ihr Gehör verloren hatte. Das gab mir sofort ein Gefühl der Anerkennung. Wir sind nun schon seit Monaten zusammen, aber ich wollte ein Dankeschön an findertjes Belgien schicken. Es ist fantastisch, dass sich Menschen auf diese Weise erreichen können! Chapeau!”</em><br />
        <span class="stelletje"> - Jean und Juliette</span></p>
    </div>
    <div class="jumbotron text-center">
        <h2>Dating-Tipps</h2>
        <?php foreach ($datingtips as $slug => $item) {
            if (empty($slug) || empty($item['name'])) {
                continue;
            }
        ?>
        <a href="datingtips-<?php echo $slug; ?>" class="btn btn-primary btn-tips"><?php echo $item['name']; ?></a>
        <?php } ?>
    </div>
    <div id="footer-banner"></div>
    <div class="jumbotron text-center">
        <a href="https://flirtsuche.com" target="_blank" class="m-0" title="FlirtSuche.com - Finde Deinen perfekten Flirt heute online!">FlirtSuche</a> - 
        <a href="https://lokaltreffen.com" target="_blank" class="m-0" title="LokalTreffen - Finde Gleichgesinnte in Deiner Nähe heute!">LokalTreffen</a> -
        <a href="https://meinlokalflirt.com" target="_blank" class="m-0" title="MeinLokalFlirt - Finde heute Deinen Flirt in Deiner Stadt!">MeinLokalFlirt</a> - 
        <a href="https://meinlokalesingles.com" target="_blank" class="m-0" title="MeinLokaleSingles.com - Singles in Deiner Stadt heute!">MeinLokaleSingles</a> - 
        <a href="https://meinsingleschat.com" target="_blank" class="m-0" title="MeinSingleChat.com - Chat mit Singles in Deiner Nähe!">MeinSingleChat</a> - 
        <a href="https://hitzigesingles.com" target="_blank" class="m-0" title="HitzigeSingles.com - Heiße Singles in Deiner Nähe heute!">HitzigeSingles</a> - 
        <a href="https://lustigesingles.com" target="_blank" class="m-0" title="LustigeSingles.com - Spaß & Liebe in Deiner Nähe heute!">LustigeSingles</a>
        <hr>
        <a href="https://ficklokal.com" target="_blank" class="m-0" title="Ficklokal.com - Finde einen guten Fick in deiner Gegend">Ficklokal</a> - 
        <a href="https://hitzigemilfs.com" target="_blank" class="m-0" title="HitzigeMilfs.com - Finde heiße MILFs in Deiner Nähe heute!">HitzigeMilfs</a> - 
        <a href="https://lustigemilfs.com" target="_blank" class="m-0" title="LustigeMilfs.com - Spaß mit MILFs in Deiner Nähe heute!">LustigeMilfs</a> - 
        <a href="https://reifefrauenchat.com" target="_blank" class="m-0" title="ReifeFrauenChat.com - Chat mit reifen Frauen in Deiner Nähe!">ReifeFrauenChat</a> - 
        <a href="https://reifefrauenfinder.com" target="_blank" class="m-0" title="ReifeFrauenFinder.com - Finde reife Frauen in Deiner Nähe!">ReifeFrauenFinder</a> - 
        <a href="https://reifemilfkontakte.com" target="_blank" class="m-0" title="ReifeMilfKontakte.com - Reife MILFs in Deiner Nähe finden!">ReifeMilfKontakte</a> - 
        <a href="https://reifemilfchat.com" target="_blank" class="m-0" title="ReifeMilfChat.com - Chatte mit reifen MILFs in Deiner Nähe!">ReifeMilfChat</a> - 
        <a href="https://sexchatfinden.com" target="_blank" class="m-0" title="SexChatFinden.com - Finde Sex-Chats in Deiner Nähe heute!">SexChatFinden</a> - 
        <a href="https://ficksingles.com" target="_blank" class="m-0" title="FickSingles.com - Heiße Singles für Spaß in Deiner Nähe!">FickSingles</a> - 
        <a href="https://lustfinden.com" target="_blank" class="m-0" title="LustFinden.com - Finde Lust & Spaß in Deiner Nähe heute!">LustFinden</a> - 
        <a href="https://geheimesexchat.com" target="_blank" class="m-0" title="GeheimerSexChat.com - Diskreter Sex-Chat in Deiner Nähe!">GeheimerSexChat</a> - 
        <a href="https://geheimelustchat.com" target="_blank" class="m-0" title="GeheimeLustChat.com - Diskreter Lust-Chat in Deiner Nähe!">GeheimeLustChat</a>    
        <hr>
        <a href="https://meintranskontakt.com" target="_blank" class="m-0" title="Meintranskontakt.com - Transkontakte in Deutschland finden">Meintranskontakt</a> - 
        <a href="https://trannytreffen.com" target="_blank" class="m-0" title="Trannytreffen - Finde Trans-Kontakte in Ihrer Nähe heute!">Trannytreffen</a> - 
        <a href="https://transgenderkontakt.com" target="_blank" class="m-0" title="Transgenderkontakt - Finde lokale Trans in Deiner Nähe!">Transgenderkontakt</a> - 
        <a href="https://lokalshemale.com" target="_blank" class="m-0" title="Lokalshemale.com - Diskret Shemale Kontakt in Deiner Nähe">Lokalshemale</a>
    </div>
</div><!-- container -->
<?php include $base . '/includes/footer.php'; ?>
