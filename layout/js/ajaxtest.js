function loadDoc(page,usern) {
  
    var myRequest;
    if(window.XMLHttpRequest){
            myRequest = new XMLHttpRequest();
    }else{
       myRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
     
   myRequest.onreadystatechange = loaddata;
    
  myRequest.open("POST", page, true);
  myRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  myRequest.send("username="+usern,"type=username");
}

function loaddata() {
    
       var fdata=document.getElementById("username");
       
    if (this.readyState == 4 && this.status == 200) {
               fdata.innerHTML = this.responseText;
        
    }else if ( this.readyState < 4 && this.readyState > 0 ){

             fdata.innerHTML = "<img  class='loading' src='layout/images/Reload.gif'> please wait.......<br>";
     }else{
         
          fdata.innerHTML = "<h1>there is some thing wrong in this reqwest</h1>";
     }
  };
//=================================================================================================================================

function loadmail(page,usern) {
  
    var myRequest;
    if(window.XMLHttpRequest){
            myRequest = new XMLHttpRequest();
    }else{
       myRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
     
   myRequest.onreadystatechange = loadmaildata;
    
  myRequest.open("POST", page, true);
  myRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  myRequest.send("mail="+usern,"type=Email");
}

function loadmaildata() {
    
       var fdata=document.getElementById("mail");
       
    if (this.readyState == 4 && this.status == 200) {
               fdata.innerHTML = this.responseText;
        
    }else if ( this.readyState < 4 && this.readyState > 0 ){

             fdata.innerHTML = "<img  class='loading' src='layout/images/Reload.gif'> please wait.......<br>";
     }else{
         
          fdata.innerHTML = "<h1>there is some thing wrong in this reqwest</h1>";
     }
  };
//=================================================================================================================================


    function loadcart(page,itemn,user) {
  
    var myRequest;
    if(window.XMLHttpRequest){
            myRequest = new XMLHttpRequest();
    }else{
       myRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
     
   myRequest.onreadystatechange = loadmaildata;
    
  myRequest.open("POST", page, true);
  myRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  myRequest.send("itemn="+itemn+"&user="+user+"&num=4");
     
}

function loadmaildata() {
    
       var fdata=document.getElementById("cartcount");
       
    if (this.readyState == 4 && this.status == 200) {
               fdata.innerHTML = this.responseText;
        
    }else if ( this.readyState < 4 && this.readyState > 0 ){

             fdata.innerHTML = "<img  class='loading' src='layout/images/Reload.gif'> please wait.......<br>";
     }else{
         
          fdata.innerHTML = "<h1>there is some thing wrong in this reqwest</h1>";
     }
  };
