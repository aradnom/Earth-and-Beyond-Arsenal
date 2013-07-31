var oTbo;
function showhide(tbo){
var nextS=tbo;
while(!nextS.nodeName||nextS.nodeName.toLowerCase()!='tbody'){
nextS=tbo.nextSibling;
}
nextS.style.display=nextS.style.display=='none'?'':'none';
}
function hideAll(){
for(var i=1;i<oTbo.length;i+=2){
oTbo[i].style.display='none';
}
}
onload=function(){
oTbo=document.getElementsByTagName('tbody');
hideAll();
}
function changeOverCursor() {
document.getElementById('boxImage').style.cursor='hand';
}
function changeOutCursor() {
document.getElementById('boxImage').style.cursor='default';
}