var Requisita = (function() {
function Requisita(){}
function inprivate(){
$.post('../resources/beans.php',{scope:"request"},
function(returnedData){
try{
var beansindex=returnedData.indexOf('{"');
var getbeans=returnedData.substr(beansindex);
returnedData=returnedData.replace(getbeans,"");
console.log(returnedData);
var jsona = JSON.stringify(eval("("+getbeans+")"));
var objeto = JSON.parse(jsona);
Object.classtam=function(objeto){var tam=0;for(var key in objeto){if(objeto.hasOwnProperty(key)){tam++;}}return tam;};
Object.classnames=function(objeto){var name=[];var i=0;for(var key in objeto){if(objeto.hasOwnProperty(key)){name[i]=key;i++;}}return name;};
Object.proptam=function(objeto){var tam=0;for(var key in objeto){if(objeto.hasOwnProperty(key)){tam++;}}return tam;};
Object.propnames=function(objeto){var name=[];var i=0;for(var key in objeto){if(objeto.hasOwnProperty(key)){name[i]=key;i++;}}return name;};
Object.arrays=function(objeto){var name=[];var i=0;for(var key in objeto){if(objeto.hasOwnProperty(key)){name[i]=key;i++;}}return name;};
var openbody="#{";
var scope="request@";
var classestam = Object.classtam(objeto);
var classesnames = Object.classnames(objeto);
var access=".";
var closebody="}";
var managedarrays;
for(i=0;i<classestam;i++){
var proptam = Object.proptam(objeto[classesnames[i]]);
for(j=0;j<proptam;j++){
var mount=null;
var replacement=null;
var instring=Object.propnames(objeto[classesnames[i]])[j];
var metadata=objeto[classesnames[i]][instring];
if(typeof metadata === 'object'){
managedarrays=Object.arrays(metadata);
bidimenarrays=Object.arrays(metadata[managedarrays]);
}
if(managedarrays!==""){
for(var key in managedarrays){
if(managedarrays[key]!==null){
mount=new RegExp(openbody+scope+classesnames[i]+access+instring+access+managedarrays[key]+closebody,"gi");
replacement=objeto[classesnames[i]][instring][managedarrays[key]];
document.body.innerHTML=document.body.innerHTML.replace(mount,replacement);
var managedarraysind=key;
if(bidimenarrays!==""){
for(var bid in bidimenarrays){
if(bidimenarrays[bid]!==null){
mount=new RegExp(openbody+scope+classesnames[i]+access+instring+access+managedarrays[managedarraysind]+access+bidimenarrays[bid]+closebody,"gi");
replacement=objeto[classesnames[i]][instring][managedarrays[managedarraysind]][bidimenarrays[bid]];
document.body.innerHTML=document.body.innerHTML.replace(mount,replacement);
}
}
}
}
}
}
mount=new RegExp(openbody+scope+classesnames[i]+access+instring+closebody,"gi");
replacement=objeto[classesnames[i]][instring];
document.body.innerHTML=document.body.innerHTML.replace(mount,replacement);
managedarrays="";
bidimenarrays="";
}
}
}
catch(e){
console.log(returnedData);
$("#msgtext").html(returnedData);
}
});
}
Requisita.prototype.inpublic = function (){
return inprivate.call(this);
};
return Requisita;
})();
var req = new Requisita();
req.inpublic();