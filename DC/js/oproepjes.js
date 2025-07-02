var oproepjes= new Vue({
    el: "#oproepjes",
    created: function(){
        this.init();
    },
    data: {
        profiles: [],
        page: 1,
        ppp: 20,    //profiles per page
    },
    computed: {
        filtered_profiles: function(){
            //afhankelijk van pagina nummer, een deel vd profielen tonen
            //alleen hier tellen we vanaf 0
            var i0= (this.page - 1) * this.ppp;
            var i1= i0 + this.ppp;
            return this.profiles.slice(i0, i1);
        },
        max_page_number: function(){
            return Math.ceil(this.profiles.length / this.ppp);  
        },
    },
    methods:  {
        init: function(){
            if (typeof api_url === 'undefined' || !api_url) {
                return;
            }
            axios.get(api_url)
                .then(function(response){
                    var profs = response.data.profiles;
                    profs.forEach(function(p){
                        if(p.src && p.src.indexOf('no_img_Vrouw.jpg') !== -1){
                            p.src = 'img/fallback.svg';
                        }
                        if(p.profile_image_big && p.profile_image_big.indexOf('no_img_Vrouw.jpg') !== -1){
                            p.profile_image_big = 'img/fallback.svg';
                        }
                    });
                    oproepjes.profiles = profs;
                })
                .catch(function (error) {
                    // console.log(error); // removed debugging statement
                });
        },
        imgError: function(event){
            event.target.src = 'img/fallback.svg';
        },
        slugify: function(text){
            return text.toString().toLowerCase()
                .replace(/\s+/g,'-')
                .replace(/[^a-z0-9-]/g,'')
                .replace(/--+/g,'-')
                .replace(/^-+|-+$/g,'');
        },
        set_page_number: function(page){
            if(page <= 1){
                this.page= 1;
            } else if(page >= this.max_page_number){
                this.page= this.max_page_number;
            } else {
                this.page= page;
            }
            
            
        }
    }
});
