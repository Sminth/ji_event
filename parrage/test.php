<html>

<head>
  <title>Parrainage</title>
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>

<link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .section {
      margin-top: 2em;
    }
  </style>
</head>

<body>
  <div class="container" id="app">
    <div class="row mt-5">
      <div class="col-4">
      <img :src="getImgP()" width="100" alt="">
      <p> {{nom_parrain}}</p>
      </div>
   
      <a class="col-4" href="#" v-on:click="parrainage">actualiser</a>
      <p class="col-4"> {{nom_filleul}}</p>
      <br>
      <h1>{{message_fin}}</h1> <br>
      <!-- {{etudiants_licence_3}} <br> <br> -->
      {{etudiants_parraines}}
    </div>

    <footer style="
          background-color: rgb(236, 236, 236);
          position: fixed;
          width: 100%;
          font-size: 80%;
          margin-top: 5em;
          padding-top: 5px;
          padding-bottom: 5px;
          bottom: 0;
        ">
      <div class="container"> <em>© JI 2021. </em> </div>
    </footer>
  </div>

  <script src="./content.vue.js"></script>
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

          message_fin:"",
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
          r1 = Math.floor(Math.random() * this.etudiants_licence_3.length);
          r2 = Math.floor(Math.random() * this.etudiants_licence_1.length);
          // console.log(this.etudiants_licence_3[r1]);
          parrain = this.etudiants_licence_3[r1];
          filleul = this.etudiants_licence_1[r2];
          this.nom_parrain = parrain['nom'];
          this.image_parrain = parrain['lien_photo'];

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
          if(this.etudiants_licence_1==0) this.message_fin ="parrainage Terminé";
        },
      },
      mounted() {
        Promise.all([axios.get('http://theevent.me/api/?level=3'), axios.get('http://theevent.me/api/?level=1')])
          .then((allResults) => {
            this.etudiants_licence_3 = allResults[0].data,
              this.etudiants_licence_1 = allResults[1].data,
              this.parrainage()
          })
          .catch(function (error) {
                        console.log(error);
                    })

      }
    });
  </script>


</body>

</html>