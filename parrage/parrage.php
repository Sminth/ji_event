<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parrainage</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>

    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script sr="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/5.0.0/css/font-awesome.min.css"> -->
</head>

<body>
    
    <style type="text/css">

        body{
          display: flex;
          height: 100vh;
          justify-content: center;
          align-items: center;
          background-image:url("12.png");
          background-size:cover;
          background-attachment:fixed;
          font-family: Open Sans, sans-serif;
        }
    
        .btn{
          display: inline-block;
          width: 220px;
          height: 60px;
          border: 2px solid #fff;
          color: #fff;
          font-size: 20px;
          font-weight: bold;
          text-transform: uppercase;
          text-align: center;
          text-decoration: none;
          line-height: 56px;
          box-sizing: border-box;
          border-radius: 50px;
          background-color: transparent;
          outline: none;
          transition: all ease 0.5s;
        }
    
        .loading{
          width: 150px;
          height: 150px;
          box-sizing: border-box;
          border-radius: 50%;
          border-top: 10px solid #f8cd22;
          position: relative; 
          animation: a1 2s linear infinite;   
        }
    
        .loading::before,.loading::after{
          content: '';
          width: 150px;
          height: 150px;
          position: absolute;
          left: 0;
          top: -10px;
          box-sizing: border-box;
          border-radius: 50%;
        }
    
        .loading::before{
          border-top: 10px solid #03224C;
          transform: rotate(120deg);
        }
    
        .loading::after{
          border-top: 10px solid #FFFFFF;
          transform: rotate(240deg);
        }
    
        .loading span{
          position: absolute;
          width: 150px;
          height: 150px;
          color: black;
          text-align: center;
          line-height: 150px;
          animation: a2 2s linear infinite;
        }
        
        @keyframes a1 {
          to{
            transform: rotate(360deg);
          }
        }
    
         @keyframes a2 {
          to{
            transform: rotate(-360deg);
          }
        }
    
        .success{
          width: 150px;
          height: 150px;
          box-sizing: border-box;
          border-radius: 50%;
          border-top: 10px solid #f8cd22;
          position: relative; 
          animation: a1 2s linear infinite; 
        }
    
        @keyframes bounce{
          0%{
            transform: scale(0.9);
          }
        }
        .success:before{
          content: '';
          position: absolute;
          background: url("ji.png") no-repeat;
          left: 0;
          right: 0;
          margin: 0 auto;
          width: 150px;
          height: 150px;
        }
    
        p{
          color: #fff;
        }
    </style>

    
    <div class="container" id="app">

        <figure class="card card--1" id="r1">
            <figcaption>
                <span class="info">
                    <h3>{{nom_parrain}}</h3>
                    <span>Parrain</span>
                </span>

            </figcaption>
        </figure>

        <figure class="card" style="background: transparent;height: 30px;margin-top: 200px;border:none">
            <center>
                <p> ↓ &nbsp;
                {{nom_filleul}}</p>

            </center>
        </figure>

        <figure class="card" style="background: transparent;height: 30px;border:none">
            <center>
                <p> ↑ &nbsp; {{nom_parrain}}</p>
            </center>
        </figure>

        <figure class="card card--4" id="r2">
            <figcaption>
                <span class="info">
                    <h3>{{nom_filleul}}</h3>
                    <span>filleul</span>
                </span>

            </figcaption>
        </figure>

        <button v-if="!terminer" v-on:click="parrainage"  class="btn btn-outline-dark" style="position:absolute;bottom:10%;left:30%">actualiser</button>

    </div>

     <script type="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        $(".btn").click(function(){
          $(this).addClass("loading");

          setTimeout(function(){
            $(".btn").addClass("success");
          }, 0);
          setTimeout(function(){
            $(".btn").removeClass("loading");
            $(".btn").removeClass("success");
          }, 5000);
        });
      });
    </script>


    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
    var app = new Vue({
      el: "#app",

      data() {
        return {

          etudiants_licence_1: [],
          etudiants_licence_3: [],

          etudiants_parraines: [],

          etudiant_l3_parrainer: [],

          nom_parrain: "nom du parrain",
          image_parrain : "n",
          image_filleul : "n",
          nom_filleul: "nom du filleul",
            terminer : false,
          message_fin:"",
          timer : null,
          // taille_p : etudiants_licence_3.length,
          // taille_f : etudiants_licence_1.length,
        };
      },
      methods: {
        getImgP(){
          return "../"+this.image_parrain ;
        },
        getImgF(){
          return "../"+this.image_filleul ;
        },
        parrainage() {
            console.log(this.terminer);
            if(!this.terminer){
          r1 = Math.floor(Math.random() * this.etudiants_licence_3.length);
          r2 = Math.floor(Math.random() * this.etudiants_licence_1.length);
          // console.log(this.etudiants_licence_3[r1]);
          parrain = this.etudiants_licence_3[r1];
          filleul = this.etudiants_licence_1[r2];
          this.nom_parrain = parrain['nom'];
          this.image_parrain = parrain['lien_photo'];
            div1 = document.getElementById('r1'); div2 = document.getElementById('r2');

          div1.style = "--image-src: url('../"+this.image_parrain + "')";
          div2.style = "--image-src: url('../"+this.image_filleul + "')";
          this.nom_filleul = filleul['nom'];
          this.image_filleul = filleul['lien_photo'];

          this.etudiants_parraines.push({
          "id_parrain": parrain['id'],
          "id_fillel": filleul['id']
          });
          this.etudiant_l3_parrainer.push(parrain);
          this.etudiants_licence_3 = this.etudiants_licence_3.filter(function(ele){ 
            return ele != parrain;
          });
          this.etudiants_licence_1 = this.etudiants_licence_1.filter(function(ele){ 
            return ele != filleul;
          });
          // console.log(this.etudiants_licence_3);
          if(this.etudiants_licence_3.length ==0 && this.etudiants_licence_1!=0) this.etudiants_licence_3 = this.etudiant_l3_parrainer;
          if(this.etudiants_licence_1==0){
            this.message_fin ="parrainage Terminé"; this.terminer =true;
          } 
        }
        },
        animation(){
            var output, started, duration, desired;
        duration = 5000; desired = '50';
        images = ['img1.jpg', 'img2.jpg', 'img3.jpg', 'img4.jpg', 'img5.jpg','img6.jpg' ];
        index = 0;
        // Initial
        output = $('#output');
        div1 = document.getElementById('r1'); div2 = document.getElementById('r2');

        started = new Date().getTime();
        // Animation!

        animationTimer = setInterval(function() {
            // Si la valeur est ce que nous voulons, arrêtez d’animer
            // ou si la durée a été dépassée, arrêtez d’animer
            if (new Date().getTime() - started > duration) {
                clearInterval(animationTimer);
                // console.log();
            } else {
                // console.log('animate');
                index2 = Math.floor(Math.random() * images.length);
                index = Math.floor(Math.random() * images.length);
                // alert(index+" "+ind  ex2)
                div1.style = "--image-src: url('../images/random/" + images[index] + "')";
                div2.style = "--image-src: url('../images/random/" + images[index2] + "')";
            }
        }, 800);
        },
        lance(){
            this.animation()

            started = new Date().getTime();duration=6000;
            timer = setInterval(()=> {

            if (new Date().getTime() - started > duration) {
                clearInterval(timer); 
            }
            else {this.parrainage()}
            }, 5000);
        }
      },
      
      mounted() {
        Promise.all([axios.get('https://yebay.ci/miage/api/?level=3'), axios.get('https://yebay.ci/miage/api/?level=1')])
          .then((allResults) => {
            this.etudiants_licence_3 = allResults[0].data,
              this.etudiants_licence_1 = allResults[1].data,
                this.lance()
            })
          .catch(function (error) {
                        console.log(error);
                    })

      }
    });
  </script>

    <script type="text/javascript">
        
        
    </script>
    <style>
        #output {
            margin: 20px;
            padding: 20px;
            background: gray;
            border-radius: 10px;
            font-size: 80px;
            width: 80px;
            color: white;
        }
    </style>
</body>

</html>