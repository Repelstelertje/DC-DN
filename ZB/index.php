<?php
$base = __DIR__;
include $base . '/includes/array_prov.php';
$pageTitle = 'Home - Zoekertjes België';
include $base . '/includes/array_tips.php';
include $base . '/includes/header.php';
?>
<div class="container">
    <!-- Jumbotron Header -->
    <div class="jumbotron my-4 text-center">
        <h1>Zoekertjes België | De beste datingsite van België</h1>
        <hr>
        <p>Op deze gratis datingsite staan alle contactadvertenties België. Kijk snel tussen de zoekertjes om in contact te komen met vrouwen voor gratis dating. Hier kan jij jezelf anoniem en gratis inschrijven met een zelfgekozen profielnaam. Ook blijft jouw e-mailadres altijd geheim voor andere leden. Voor wie echt helemaal anoniem wil blijven, bestaat de mogelijkheid om geen foto op het profiel te tonen.</p>
        <h2>Zoek hier vrouwen bij jou in buurt!</h2>
        <?php
            foreach ($navItems as $item) {
                echo "<a class=\"btn btn-primary prov-btn\" href=\"$item[slug]\">$item[title]</a>";
            }
        ?>
    </div>
    <div id="top-banner"></div>
    <div class="jumbotron jumbotron-sm text-center">
        <h2>Nieuwste leden!</h2>
    </div>
    <div class="row" v-cloak>
        <div class="col-lg-3 col-md-6 mb-4 portfolio-item" id="Slankie" v-for="profile in filtered_profiles">
            <div class="card h-100">
                <a :href="'<?php echo $baseUrl; ?>/daten-met-' + slugify(profile.name) + '?id=' + profile.id"><img class="card-img-top" :src="profile.src.replace('150x150', '300x300')" :alt="profile.name + ' daten in België'" @error="imgError"></a>
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
                <a :href="'<?php echo $baseUrl; ?>/daten-met-' + slugify(profile.name) + '?id=' + profile.id" class="card-footer btn btn-primary">Bekijk profiel</a>
            </div>
        </div>
        <script>
            var api_url= "<?php echo $config['BANNER_ENDPOINT']; ?>";
        </script>
        <!-- Pagination -->
        <nav class="nav-pag" aria-label="Page navigation">
            <ul class="pagination flex-wrap justify-content-center">
                <li class="page-item">
                    <a class="page-link" aria-label="Vorige" v-on:click="set_page_number(page-1)" ><span aria-hidden="true">&laquo;</span><span class="sr-only">Vorige</span></a>
                </li>
                <li v-for="page_number in max_page_number" class="page-item" v-bind:class="{ active: page_number == page }" >
                  <a class="page-link" v-on:click="set_page_number(page_number)">{{ page_number }}</a>
                </li>
                <li class="page-item">
                  <a class="page-link" aria-label="Volgende" v-on:click="set_page_number(page+1)" ><span aria-hidden="true">&raquo;</span><span class="sr-only">Volgende</span></a>
                </li>
            </ul>
        </nav>
    </div><!-- /.row -->
    <?php echo related_profiles_links($provincies, function($slug) use ($baseUrl) { return $baseUrl . '/dating-' . $slug; }); ?>
    <div class="jumbotron">
        <h2>Gratis datingsite</h2>
        <hr>
        <p>Je hoort het weleens vaker, dat je collega, vriend een leuke internetdate heeft gehad. Meestal gebeurt dit op een gratis datingsite zoals deze. Tegenwoordig gebruiken bijna alle singels in Nederland op het internet gratis dating om afspraakjes te maken. Er zijn ook veel betaalde datingsites maar Zoekertjes België is 100% gratis. Daardoor zijn er duizenden leden die gratis chatten op zoek naar een date. Er is veel aanbod dus hoe zorg je er nu voor dat je met gratis daten via het internet succes hebt?</p>
        <h3>Succes met gratis dating</h3>
        <p><span>Val op met een profielfoto</span> op jouw profiel zodat iedereen kan zien hoe jij eruit ziet. Uit onderzoek bij onze leden blijkt dat singles met een foto veel meer kans op een date hebben. Zorg dat je een leuke profielfoto hebt waarmee jij opvalt tussen de andere vrijgezellen. Gratis dating trekt veel mensen aan dus het is belangrijk om op te vallen.</p>
        <p><span>Flirt erop los</span> zodat jij meer opvalt bij de vrouw waarmee jij wil daten. Stuur iemand die jij leuk vind een gratis flirt om haar aandacht te trekken. Wie weet krijg jij gelijk een reactie op jouw flirt en is het eerste contact gelegd. Bij een fijne klik is een afspraakje dan zo gemaakt! Hoe die wordt ingevuld? Dat laten we natuurlijk aan de tortelduifjes over, met een klein beetje hulp van Cupido.</p>
        <h2>Waarom een gratis datingsite werkt</h2>
        <hr>
        <p>Ben je op zoek naar een nieuwe liefde, of wil je zo nu en dan leuk afspraakje? Op Zoekertjes België vind je duizenden vrijgezellen die precies hetzelfde zoeken! En wat is er nou mooier dan één gratis dating plek waar al die singles bij elkaar komen? Zoek in jouw provincie naar een single dame waarmee jij wil daten. Stuur haar een gratis bericht en meld je aan om verder met haar te kunnen chatten.</p>
        <p>Je wilt toch wel wat te weten komen over degene waar je misschien snel tegenover zit in een leuk restaurant! Er zijn steeds meer vrijgezelle dames in Nederland en daarvan schrijven er zich veel in op deze gratis datingsite. De vaak gemaakte afspraakjes zorgen dus ook voor veel succesverhalen, en daar zijn wij als Zoekertjes België trots op! Voor degenen die wat zenuwachtig zijn? Samen kun je alle tijd nemen om eerst het ijs te breken, want dat maakt je eerste date immers een stuk ontspannender. Of misschien wel spannend ;)</p>
        <h3>Gratis chatten</h3>
        <p>Gratis dating zorgt ervoor dat er naar hartelust gratis gechat kan worden. Door eerst wat gratis berichten uit te wisselen kan je makkelijker uit jouw comfort-zone komen. Het is die welbekende comfort-zone waar de mensen soms wat moeite mee hebben om uit te komen. Daarom heeft Zoekertjes België een platform gecreëerd waar singles elkaar op hun eigen tempo kunnen toelaten in elkaars leven. Want met zijn tweetjes in die roze bubble, voelt vaak al fijn en vertrouwd aan. En wie weet is dat wel in dezelfde provincie, of zelfs de zelfde stad! Door contact te leggen op een gratis datingsite is de drempel voor een eerste berichtje veel lager. Daarom is Zoekertjes België ook zo een succes.</p>
        <p>Van zoeken naar jouw droompartner of spannende afspraakjes, liefde en geluk ligt om de hoek. Vaak zijn leden verbaasd over hoe dichtbij hun nieuwe liefde eigenlijk woont! En dat ene café of restaurant waar je altijd langskwam, is binnenkort misschien wel de plek voor de eerste echte afspraakjes! En omdat iedereen eigen voorkeuren heeft, is het bij Zoekertjes België volledig aan de leden om zelf in vrijheid te bepalen waar en hoe het eerste afspraakje gaat plaatsvinden.</p>
        <p><span>Je bent nooit meer alleen dus begin nu met gratis daten!</span></p>
    </div>
    <div class="jumbotron text-center">
        <h2>Datingtips</h2>
        <?php foreach ($datingtips as $tips => $item) {
            if (empty($tips)) {
                continue;
            }
        ?>
        <a href="datingtips-<?php echo $tips; ?>" class="btn btn-primary btn-tips"><?php echo $item['name']; ?></a>
        <?php } ?>
    </div>
    <div id="footer-banner"></div>
    <div class="jumbotron text-center">
        <a href="https://flirthonk.be" target="_blank" class="m-0" title="FlirtHonk.be - Ontdek Flirts & Contacten in België!">Flirthonk</a> - 
        <a href="https://localflirt.be" target="_blank" class="m-0" title="LocalFlirt.be - Jouw Perfecte Flirt Dichtbij Huis in België!">LocalFlirt</a> -
        <a href="https://65pluscontact.be" target="_blank" class="m-0" title="65PlusContact.be - 65+ Vriendschappen Vinden in België!">65Plus Contact</a> - 
        <a href="https://belgenchat.be" target="_blank" class="m-0" title="BelgenChat.be - Chatten met Landgenoten in België!">Belgen Chat</a> - 
        <a href="https://bechat.be" target="_blank" class="m-0" title="BeChat.be - Verbind met Belgen in Spannende Gesprekken">BEChat</a> - 
        <a href="https://anoniemecontacten.be" target="_blank" class="m-0" title="AnoniemeContacten.be - Discreet Verbinden met Belgen">Anonieme Contacten</a> - 
        <a href="https://casualflirten.be" target="_blank" class="m-0" title="CasualFlirten.be - Ontspannen flirten in heel België">Casual Flirten</a> - 
        <a href="https://geheimegesprekken.be" target="_blank" class="m-0" title="GeheimeGesprekken.be - Vertrouwelijke Chats in België">Geheime Gesprekken</a>
        <hr>
        <a href="https://buurtmilfs.be" target="_blank" class="m-0" title="BuurtMilfs.be - Vind Milfs in Jouw Buurt voor Contact!">BuurtMilfs</a> - 
        <a href="https://bd4xxx.be" target="_blank" class="m-0" title="BD4XXX.be - Ervaar Spanning en Sensualiteit in België!">BD4XXX</a> - 
        <a href="https://sletplaats.be" target="_blank" class="m-0" title="Sletplaats.be - Contacten en Volwassen Plezier in België!">Sletplaats</a> - 
        <a href="https://stout-contact.be" target="_blank" class="m-0" title="Stout-Contact.be - Stoute en Spannende Connecties in België!">Stout Contact</a> - 
        <a href="https://oudevrouwenchat.be" target="_blank" class="m-0" title="OudeVrouwenChat.be - Chat met Rijpe Dames in België">Oude Vrouwen Chat</a> - 
        <a href="https://rijpeomachat.be" target="_blank" class="m-0" title="RijpeOmaChat.be - Chat met Ervaren Dames in België">Rijpe Oma Chat</a> - 
        <a href="https://rijpemilfchat.be" target="_blank" class="m-0" title="RijpeMilfChat.be - Chat met Ervaren Milfs in België">Rijpe Milf Chat</a> - 
        <a href="https://rijpemilfmarkt.be" target="_blank" class="m-0" title="RijpeMilfMarkt.be - Markt voor Contact met Milfs in België">Rijpe Milf Markt</a> - 
        <a href="https://milfmarkt.be" target="_blank" class="m-0" title="MilfMarkt.be - Contactmarkt voor Geile Milfs in België">Milf Markt</a> - 
        <a href="https://hetebuurvrouwen.be" target="_blank" class="m-0" title="HeteBuurVrouwen.be - Chat met Hete Buurvrouwen in België">Hete Buurvrouwen</a> - 
        <a href="https://slettenchat.be" target="_blank" class="m-0" title="SlettenChat.be - Chatten met Geile Sletten in België">Sletten Chat</a> - 
        <a href="https://kinkycontacten.be" target="_blank" class="m-0" title="KinkyContacten.be - Ontdek Kinky Contacten in België">Kinky Contacten</a>    
        <hr>
        <a href="https://transgrinder.be" target="_blank" class="m-0" title="TransGrinder.be - Trans Contacten Vinden in België!">Transgrinder</a> - 
        <a href="https://trannyzoekt.com" target="_blank" class="m-0" title="TrannyZoekt.com - Shemales Zoeken Contact in België!">Tranny Zoekt</a> - 
        <a href="https://shemalemarkt.com" target="_blank" class="m-0" title="ShemaleMarkt.com - Markt voor Shemale Contacten in België!">Shemale Markt</a> - 
        <a href="https://trannycontacten.com" target="_blank" class="m-0" title="Trannycontacten.com - Shemale Contacten Ontdekken in België!">Tranny Contacten</a>
    </div>
</div><!-- container -->
<?php include $base . '/includes/footer.php'; ?>
