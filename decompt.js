var toReach = new Date ("MARCH 20 , 2021 00:00:00");

function countdown(){
 var now = new Date();
 var diff = Math.floor( (toReach.getTime() - now.getTime()) / 1000 );
 if (diff > 0) {
  var days = Math.floor(diff / (60 * 60 * 24));
  var hours = Math.floor(diff%86400 / 3600);
  var minutes = Math.floor(diff%3600 / 60);
  var seconds = diff % 60;

  $("#d").html(days  );
  $("#h").html(hours );
  $("#m").html(minutes );
  $("#s").html(seconds );
 }else{
  $("#countdown").html(	"C'est l'heure !<img src='vin.gif' height=145px width=200px/>");
 }
}

$(document).ready(function(){
 window.setInterval(countdown, 1000);
 countdown();
});
