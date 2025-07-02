var router = new VueRouter({
    mode: 'history',
    routes: []
});

var profiel= new Vue({
    router,
    el: "#profiel",
    created: function(){
        if(1*this.$route.query.id > 0){
            this.profile_id= 1*this.$route.query.id;
            this.init();
        }
        
        
        // console.log(this.profile_id); // removed debugging statement
    },
    data: {
        profile_id: 0,
        profile: { name : '', 
                  city : '',
                  profile_image_big : '',
                  aboutme : '',
                  province : '',
                  relationship : '',
                  length : '',
                  url : '',
                 },

    },
    computed: {
    },
    methods:  {
        imgError: function(event){
            event.target.src = 'img/fallback.svg';
        },
        init: function(){
            if(this.profile_id <= 0){
                return;
            }
            let that= this;
            axios.get(api_url + this.profile_id)
                .then(function(response){
                    that.profile = response.data.profile;
                    if (that.profile.profile_image_big && that.profile.profile_image_big.indexOf('no_img_Vrouw.jpg') !== -1) {
                        that.profile.profile_image_big = 'img/fallback.svg';
                    }
                })
                .catch(function (error) {
                    // console.log(error); // removed debugging statement
                });
        },
    }
});

// Track clicks on the "Stuur gratis bericht" button and
// ensure the event is sent before navigating away
document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('send-msg-btn');
    if (!btn) return;

    btn.addEventListener('click', function(e) {
        if (window.gtag) {
            e.preventDefault(); // wacht met navigeren
            gtag('event', 'send_free_message_click', {
                'event_category': 'Profile',
                'event_label': 'Stuur gratis bericht',
                'event_callback': function() {
                    window.location.href = btn.href;
                }
            });
        }
    });
});
