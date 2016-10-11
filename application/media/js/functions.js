// JavaScript Document
function mask(e,src,mask) {
        if(window.event) { _TXT = e.keyCode; } 
        else if(e.which) { _TXT = e.which; }
        if(_TXT > 47 && _TXT < 58) { 
  var i = src.value.length; var saida = mask.substring(0,1); var texto = mask.substring(i)
  if (texto.substring(0,1) != saida) { src.value += texto.substring(0,1); } 
     return true; } else { if (_TXT != 8) { return false; } 
  else { return true; }
        }
}

function askDelete(id)
{		
	$("#ask_"+id).toggle();
	$("#confirm_"+id).toggle();
	$("#cancel_"+id).toggle();
}
/*
Object.prototype.brToFloat = function(){
   var ret=0;
  try{
    var arr = this.value.split(",");
    ret = parseFloat(arr.join("."));
  }catch(err){
    alert(err.message);
  }
    return ret;
}

Number.prototype.floatToBr = function(){
   var ret=0;
  try{
    if (parseFloat(this)){
      var value = ""+this;
      var arr = value.split(".");
      ret = arr.join(",");
    }
  }catch(err){
    alert(err.message);
  }
    return ret;
}*/

function moeda2float(moeda){

   moeda = moeda.replace(".","");

   moeda = moeda.replace(",",".");

   return parseFloat(moeda);

}

function limitarTamanho(tamanho,Campo) {
  
    var ta = document.getElementById(Campo);
    if(ta.value.length > tamanho)
        ta.value = ta.value.substring(0, tamanho);
    timer = setTimeout("limitarTamanho(" + tamanho + ",'"+Campo+"')", 100);
    return;
}

function contar(Campo,size,id){
var qtd = size-Campo.value.length;
document.getElementById(id).innerHTML = "<b>"+qtd+" Caracteres Restantes</b>";
}