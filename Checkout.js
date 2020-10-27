function IsEmpty() {
   if(document.getElementById("nome").value == ""){
       alert("nome vuoto");
       return false;
   }else if(document.getElementById("cognome").value == ""){
       alert("cognome vuoto");
       return false;
   }else if(document.getElementById("indirizzo").value == ""){
        alert("indirizzo vuoto");
       return false;
   }else if(document.getElementById("città").value == ""){
        alert("città vuoto");
       return false;
   }else if(document.getElementById("stato").value == ""){
        alert("stato vuoto");
       return false;
   }else if(document.getElementById("zip").value == ""){
        alert("zip vuoto");
       return false;
   }else if(document.getElementById("telefono").value == ""){
        alert("telefono vuoto");
       return false;
   }else if(document.getElementById("email").value == ""){
        alert("email vuoto");
       return false;
   }else{
       return true;
   }
}
