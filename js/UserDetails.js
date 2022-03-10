function validateForm() {
  var firstname = document.forms["CreateUser"]["firstname"].value;
  var lastname = document.forms["CreateUser"]["lastname"].value;
  var gender = document.forms["CreateUser"]["gender"].value;
  var city = document.forms["CreateUser"]["city"].value;
  var img = document.forms["CreateUser"]["img"].value;
  var job = document.forms["CreateUser"]["job"].value;
  var hobbies = document.forms["CreateUser"]["hobbies"].value;
  var bio = document.forms["CreateUser"]["bio"].value;

  validateInput(firstname, "firstname");
  validateInput(lastname, "lastname");
  validateInput(city, "city");
  validateInput(img, "img");
  validateInput(job,"job");
  validateInput(hobbies,"hobbies");
  validateInput(bio, "bio");
  if(empty(firstname)){
    console.log("Firstname is empty");
  }

  if ( (firstname == null || empty(firstname)) || (lastname == null || empty(lastname)) 
    || (img == null || img == "") || (city == null || empty(city)) || (job == null || empty(job))
        || (hobbies == null || empty(hobbies)) || (bio == null || empty(bio))) {
    alert("Please Fill All Required Field");
    return false;
  }else{
    alert("User Created!");
    return true;
  }
}

function validateInput(input, inputName){
  if(input == null || empty(input)){
    inputError(inputName);
  }else{
    inputNormal(inputName);
  }
}

function inputError(input){
    document.getElementById(input).style.opacity = "1";          
    document.getElementById(input).style.boxShadow = "2px 2px 20px red";
}

function inputNormal(input){
  document.getElementById(input).style.opacity = ".7";          
  document.getElementById(input).style.boxShadow = "1px 1px 10px #323232";
}
//Input is empty or just space 
function empty(input){
  return input.trim().length === 0;
}
