<?php
$base = __DIR__;
define("TITLE", "Home");
include $base . '/includes/header.php';
?>
<div class="container">
    <!-- Jumbotron Header -->
    <div class="jumbotron my-4 text-center">
        <h1>Dating Contact | UK's best dating site</h1>
        <hr>
        <p>Welcome to <a href="index.php">Dating Contact</a>, the UK's premier dating site, where countless singles find love and companionship across the nation. From the bustling streets of London to the scenic views of the Scottish Highlands, Dating Contact offers a vast network of singles ready to meet that special someone. Whether you're seeking a casual chat or a serious relationship, our platform provides the tools and community to support your journey. Join Dating Contact and start your adventure in the rich and diverse dating landscape of the UK.</p>
        <h2>Find women near you!</h2>
        <?php
            foreach ($navItems as $item) {
                echo "<a class=\"btn btn-primary prov-btn\" href=\"$item[slug]\">$item[title]</a>";
            }
        ?>
    </div>
    <div id="top-banner"></div>
    <div class="jumbotron jumbotron-sm text-center">
        <h2>Newest members!</h2>
    </div>
    <div class="row" v-cloak>
        <div class="col-lg-3 col-md-6 mb-4 portfolio-item" id="Slankie" v-for="profile in filtered_profiles">
            <div class="card h-100">
                <a :href="'<?php echo $baseUrl; ?>/date-with-' + slugify(profile.name) + '?id=' + profile.id"><img class="card-img-top" :src="profile.src.replace('150x150', '300x300')" :alt="profile.name + ' in the UK'" @error="imgError"></a>
                <div class="card-body">
                    <div class="card-top">
                        <h4 class="card-title">{{ profile.name }}</h4>  
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item">Age: {{ profile.age }}</li>
                        <li class="list-group-item">Relationship: {{ profile.relationship }}</li>
                        <li class="list-group-item">City: {{ profile.city }}</li>
                        <li class="list-group-item">Province: {{ profile.province }}</li>
                    </ul>
                </div>
                <a :href="'<?php echo $baseUrl; ?>/date-with-' + slugify(profile.name) + '?id=' + profile.id" class="card-footer btn btn-primary">View profile</a>
            </div>
        </div>
        <script>
            var api_url= "<?php echo $config['BANNER_ENDPOINT']; ?>";
        </script>
        <!-- Pagination -->
        <nav class="nav-pag" aria-label="Page navigation">
            <ul class="pagination flex-wrap justify-content-center">
                <li class="page-item">
                    <a class="page-link" aria-label="Previous" v-on:click="set_page_number(page-1)" ><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a>
                </li>
                <li v-for="page_number in max_page_number" class="page-item" v-bind:class="{ active: page_number == page }" >
                  <a class="page-link" v-on:click="set_page_number(page_number)">{{ page_number }}</a>
                </li>
                <li class="page-item">
                  <a class="page-link" aria-label="Next" v-on:click="set_page_number(page+1)" ><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a>
                </li>
            </ul>
        </nav>
    </div><!-- /.row -->
    <div class="jumbotron">
        <h2  class="text-center">Our Features</h2>
        <p>At <a href="index.php">Dating Contact</a>, we pride ourselves on connecting singles throughout all regions of the UK — from the vibrant atmosphere of England's cities to the tranquil beauty of Welsh valleys and the historic charm of Scotland's towns. Our tailored features include:</p>
        <ul>
            <li><b>Regional-Based Search:</b> Our advanced search tool allows you to find singles based on specific regions. Whether you're interested in meeting someone from your local area or are curious to explore relationships in other parts of the UK, our platform helps you find your perfect match.</li>
            <li><b>Free Messaging:</b> We believe that initiating a connection shouldn't come at a cost. On Dating Contact, you can send messages for free, facilitating open and uninterrupted communication with potential matches. This feature ensures that all our members have the opportunity to spark conversations without financial barriers.</li>
        </ul>
        <p>Embrace the opportunity to connect with singles across the UK without the usual constraints. Our platform is designed to make it easy to find meaningful relationships by leveraging the geographic diversity of the UK to your advantage.</p>
    </div>
    <div class="jumbotron">
        <h2 class="text-center">Date experiences</h2>
        <hr>
        <p><em>"We (Elisa and Wim) really want to thank you very much!!! Just before the summer we found each other through your website Dating Contact. We were both looking for companionship, actually not necessarily romantic or in a steady relationship. We are both a bit older and it is not always easy to find someone with whom you can make a nice friendship. In our case, however, it was anything but difficult. We both love a game and a nice chat at times and meet weekly to enjoy each other's company. We have both travelled a lot and that is now behind us, so plenty of stories to entertain each other with! Thanks for your nice contacts and for bringing us together! Thanks to Dating Contact, we have found a partner for life."</em><br />
        <span class="stelletje"> - Elisa and Wim</span></p>
        <hr>
        <p><em>"My name is Peter and I joined your dating site about 4 weeks ago. I was a bit sceptical at first, after all, you hear so many stories about online dating. After a few days I started to get the hang of it and came across Maria's profile. Incredibly nice spontaneous lady, with an even nicer smile. We got talking and after a few weeks finally decided to meet. There really was an instant click!!! I can't even remember the last time I laughed so much with a woman. She has a daughter and son, actually for me it feels like I am finally the father since Maria has no contact with the father of her children anymore. So I really wanted to thank you, Dating Contact. Without you I might never have met her. Thank you!"</em><br />
        <span class="stelletje"> - Peter and Maria</span></p>
        <hr>
        <p><em>"My name is Jean. I started online dating over a year ago because it is sometimes difficult for me to meet people because of my disabilities. Namely, I have been very hard of hearing since birth. Although it is not always a hurdle for me, it still proves quite a challenge for some. After all, one has to know or learn sign language, for many this is a difficult task and they choose not to enter into a relationship. Through your website Dating Contact I came into contact with Juliette. It turned out she had a little daughter who also lost her hearing at a young age. This immediately gave me a feeling of recognition. We've been together for months now, but I wanted to send a thank-you note to Dating Contact. Fantastic that people can reach each other this way! Chapeau!"</em><br />
        <span class="stelletje"> - Jean en Juliette</span></p>
    </div>
    <div class="jumbotron text-center">
        <h2>Dating Tips</h2>
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
        <a href="https://mylocalflirt.com" target="_blank" class="m-0" title="MyLocalFlirt.com - Find Your Flirt in Your Area Today!">MyLocalFlirt</a> - 
        <a href="https://myflings.co.uk" target="_blank" class="m-0" title="MyFlings.co.uk - Discover Exciting Connections in the UK!">MyFlings</a> -
        <a href="https://myaffairs.co.uk" target="_blank" class="m-0" title="MyAffairs.co.uk - Explore Discreet Affairs in the UK!">MyAffairs</a> - 
        <a href="https://ukflirt.co.uk" target="_blank" class="m-0" title="UKFlirt.co.uk - Find Flirts and Connections in the UK!">UKFlirt</a> - 
        <a href="https://uktease.co.uk" target="_blank" class="m-0" title="UKTease.co.uk - Tease and Connect in the United Kingdom!">UKTease</a> - 
        <a href="https://ukdesire.co.uk" target="_blank" class="m-0" title="UKDesire.co.uk - Explore Your Desires in the United Kingdom!!">UKDesire</a> - 
        <a href="https://discreetfling.co.uk" target="_blank" class="m-0" title="DiscreetFling.co.uk - Explore Private Flings in the UK!">DiscreetFling</a>
        <hr>
        <a href="https://mymilfmatch.com" target="_blank" class="m-0" title="MyMilfMatch.com - Discover Your Ideal Connection with MILF!">MyMilfMatch</a> - 
        <a href="https://mymatureflirt.com" target="_blank" class="m-0" title="MyMatureFlirt.com - Connect with Mature Singles Flirt Today!">MyMatureFlirt</a> - 
        <a href="https://secretsexchat.com" target="_blank" class="m-0" title="SecretsexChat.com - Private Chats in a Discreet Setting!">SecretsexChat</a> - 
        <a href="https://milfsexchat.co.uk" target="_blank" class="m-0" title="MilfSexChat.co.uk - Engage in Milf Chats in the UK!">MilfSexChat</a> - 
        <a href="https://maturesexchat.co.uk" target="_blank" class="m-0" title="MatureSexChat.co.uk - Explore Mature Chat in the UK!">MatureSexChat</a> - 
        <a href="https://maturetemptations.co.uk" target="_blank" class="m-0" title="MatureTemptations.co.uk - Tempting Encounters in the UK!">MatureTemptations</a> - 
        <a href="https://secrethookups.co.uk" target="_blank" class="m-0" title="SecretHookupsUK.co.uk - Find Discreet Connections in the UK">SecretHookupsUK</a> - 
        <a href="https://discreethookups.co.uk" target="_blank" class="m-0" title="DiscreetHookupsUK.co.uk - Private Connections in the UK">DiscreetHookupsUK</a> - 
        <a href="https://myhookups.co.uk" target="_blank" class="m-0" title="MyHookupsUK.co.uk - Connecting for Hookups in the UK!">MyHookupsUK</a> - 
        <a href="https://discreetsexfinder.co.uk" target="_blank" class="m-0" title="DiscreetSexFinder.co.uk - Find Private Encounters in the UK">DiscreetSexFinder</a> - 
        <a href="https://milftemptations.co.uk" target="_blank" class="m-0" title="MilfTemptations.co.uk - Satisfying Temptations in the UK!">MilfTemptations</a> - 
        <a href="https://secretsexfinder.co.uk" target="_blank" class="m-0" title="SecretSexFinder.co.uk - Find Discreet Connections in the UK">SecretSexFinder</a>
        <hr>
        <a href="https://myshemalecontact.com" target="_blank" class="m-0" title="MySheMaleContact.com - Connect with Shemale Singles, Today!">MySheMaleContact</a> - 
        <a href="https://contactshemale.com" target="_blank" class="m-0" title="ContactShemale.com - Connect with Transgenders in Your Area!">ContactShemale</a> - 
        <a href="https://matchshemale.com" target="_blank" class="m-0" title="MatchShemale.com - Match and Discover Shemales Near You!">MatchShemale</a> - 
        <a href="https://eroticshemales.com" target="_blank" class="m-0" title="EroticShemales.com - Explore Shemale Contacts in the UK!">EroticShemales</a>
    </div>
</div><!-- container -->
<?php include $base . '/includes/footer.php'; ?>
