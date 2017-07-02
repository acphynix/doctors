<?php
  ob_start();
  session_start();
?>
<script>
  var searchquery={'symptoms':[],'specialities':[]};
  function goto(newpage){
    window.location.href = newpage
  }
  function suggest(type,text){
    if(text.length != 0){
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        var oldsuggestions = document.getElementById(type+"_list");
        var contr = document.getElementById(type+"_list_container");
        if (this.readyState == 4 && this.status == 200) {
          // alert(this.responseText);
          var newsuggestions = document.createElement("datalist");
          // var symptoms = ["acne","anxiety","arrhythmia","foot pain","headache","nausea"];
          var suggestions=JSON.parse(this.responseText);
          // alert(oldsuggestions);
          // alert(newsuggestions);
          for(var i=0;i<suggestions.length; i++){
            var newitem = document.createElement("option");
            newitem.setAttribute("value",suggestions[i]);
            newsuggestions.appendChild(newitem);
          }
          newsuggestions.setAttribute("id",type+"_list");
          // alert(oldsuggestions.outerHTML);
          // newsuggestions = oldsuggestions;
          contr.replaceChild(newsuggestions,oldsuggestions);
        }
        else{

        }
      };
      xmlhttp.open("GET", "ajax/suggest_"+type+".php?q=" + text, true);
      xmlhttp.send();
    }
  }

$(function () {
  $('#isymptoms_form').on('submit',function (e) {
      // alert('hi');
      var input = $('#isymptoms_field').val();
      var id = ("ient_symptom_"+input).replace(/\W+/g, '');
      // id=id.replace('.','');
      // alert(id);

      if(input != ""){
        $("#ientered_symptoms").append(
          "<div class=\"crystal_term\" id=\""+id+"\">"+input
           +"<span class=\"clickme\""
           +"style=\"float:right\""
           +"onclick=\"$( '#"+id+"' ).remove()\">"
           +"&#10006;</span></div>");
        $('#isymptoms_field').val("");
        searchquery.symptoms.push(input)
      }
      e.preventDefault();
  });
});
$(function () {
  $('#ispecialities_form').on('submit',function (e) {
      // alert('hi');
      var input = $('#ispecialities_field').val();
      var id = ("ient_speciality_"+input).replace(/\W+/g, '');
      // id=id.replace('.','');
      // alert(id);

      if(input != ""){
        $("#ientered_specialities").append(
          "<div class=\"crystal_term\" id=\""+id+"\">"+input
           +"<span class=\"clickme\""
           +"style=\"float:right\""
           +"onclick=\"$( '#"+id+"' ).remove()\">"
           +"&#10006;</span></div>");
        $('#ispecialities_field').val("");
        searchquery.specialities.push(input)
      }
      e.preventDefault();
  });
});
$(function () {
  $("#isubmit_search").on('submit',function(e) {
    // alert(searchquery);
    $("#isearch_results").text(JSON.stringify(searchquery));
    e.preventDefault();
  });
});
</script>


<span id= "symptoms_list_container">
    <datalist id="symptoms_list"></datalist>
  </span>
  <span id= "specialities_list_container">
    <datalist id="specialities_list"></datalist>
</span>

<h2>Are you looking for a doctor?</h2>

<br><br>
  
<div style="font-weight:bold">
  Find me a specialist who can help me with:
</div>

<form id="isymptoms_form">
  <input id="isymptoms_field" type="text" list="symptoms_list" placeholder="headache, nausea, foot pain, etc." onkeyup="suggest('symptoms',this.value)" autocomplete="off">
</form>
<div id="ientered_symptoms" style="padding-right:30px"></div> <!-- list of current symptoms -->
<div style="font-size:12px;color:blue;text-decoration:underline">
  Need suggestions for symptoms?
</div>
<br /> 

<div style="font-weight:bold">
  or who specializes in:
</div>

<form id="ispecialities_form">
  <input id="ispecialities_field" type="text" list="specialities_list" placeholder="skin, feet, cardiology, rheumatology, etc." onkeyup="suggest('specialities',this.value)" autocomplete="off">
</form>
<div id="ientered_specialities" style="padding-right:30px"></div> <!-- list of current specialities -->
<br />
<form id="isubmit_search">
  <input type="submit" value="SEARCH" />
</form>
<br />
<div id = "isearch_results">  
</div>