
var expanded = false;

//Use to display the expert to accept in the current project
function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }

}


//Display the limitationValue field function of the limitation mode choose
function displayLimitationValue() {

  var select = document.querySelector("#selectlimit");
  var labelValue = document.querySelector("#labelValue");


  if(select.selectedOptions[0].value == 1)
  {
      labelValue.innerText = "Value of the limitation (in Minute)"
  }else
  {
      labelValue.innerText = "Value of the limitation (in number of annotation)"
  }

};