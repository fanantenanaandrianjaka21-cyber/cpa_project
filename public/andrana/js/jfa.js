    function fonc(){
        var  a=$(".mots").val();
        //  alert(a);
        $(".lescateg").hide();
        $(".debut").hide();
        $(".non-select").hide();
        $(".cherche").show();
         mak(a);
    }
    function changeinput(mots){
        
        $(".mots").val(mots);
        $("#txt").hide(1000);
        
  }
    
    function change(){
        $("a").click(function(){
            $("#id").css("color","red");
      });
     mak(a);
}
function showHint(str) {
    $("#txt").show();
    if (str.length == 0) {
      document.getElementById("txt").innerHTML = "";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("txt").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "getmots.php?q=" + str, true);
      xmlhttp.send();
    }
  }

    function mak(str) {
    if (str == "") {
        document.getElementById("code").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("code").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getuser.php?q="+str,true);
        xmlhttp.send();
    }
}
function test(){
    alert('tonga');
}
// function Crud(table,type,id){
//     if(type=="delete"){
//     if (window.XMLHttpRequest) {
//             // code for IE7+, Firefox, Chrome, Opera, Safari
//             xmlhttp = new XMLHttpRequest();
//         } else {
//             // code for IE6, IE5
//             xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
//         }
//         xmlhttp.onreadystatechange = function() {
//             if (this.readyState == 4 && this.status == 200) {
//                 document.getElementById("crud").innerHTML = this.responseText;
//             }
//         };
//         xmlhttp.open("GET","Mysql.php?q="+table+"&&type="+type+"&&id="+id,true);
//         xmlhttp.send();}
//     }