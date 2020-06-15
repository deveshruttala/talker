var jsSettingsBasicsFirstName = document.getElementById("formSettingsBasicsFirstName");
var jsSettingsBasicsLastName = document.getElementById("formSettingsBasicsLastName");
var jsSettingsBasicsNickName = document.getElementById("formSettingsBasicsNickName");
var jsSettingsBasicsAge = document.getElementById("formSettingsBasicsAge");
var jsSettingsBasicsSubmit = document.getElementById("formSettingsBasicsSubmit");
var jsSettingsBasicsRegexPatternName = /^[a-zA-Z]{3,15}$/;
var jsSettingsBasicsRegexPatternAge = /^[2-9]{1}[0-9]{1}$/;

jsSettingsBasicsSubmit.disabled = true;
jsSettingsBasicsSubmit.classList.remove("btn-success");
jsSettingsBasicsSubmit.classList.add("btn-danger");

var jsSettingsPasswordCurrent = document.getElementById("formSettingsPasswordCurrent");
var jsSettingsPasswordNew = document.getElementById("formSettingsPasswordNew");
var jsSettingsPasswordConf = document.getElementById("formSettingsPasswordConf");
var jsSettingsPasswordSubmit = document.getElementById("formSettingsPasswordSubmit");
var jsSettingsPasswordRegexPattern = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@*$#]).{8,16}/;

jsSettingsPasswordNew.disabled = true;
jsSettingsPasswordConf.disabled = true;
jsSettingsPasswordSubmit.disabled = true;
jsSettingsPasswordSubmit.classList.remove("btn-success");
jsSettingsPasswordSubmit.classList.add("btn-danger");


function jsSettingsBasicsSubmitEnable() {
    if (jsSettingsBasicsRegexPatternName.test(jsSettingsBasicsFirstName.value) ||
      jsSettingsBasicsRegexPatternName.test(jsSettingsBasicsLastName.value) ||
      jsSettingsBasicsRegexPatternName.test(jsSettingsBasicsNickName.value) || 
      jsSettingsBasicsRegexPatternAge.test(jsSettingsBasicsAge.value)) {
      jsSettingsBasicsSubmit.disabled = false;
      jsSettingsBasicsSubmit.classList.remove("btn-danger");
      jsSettingsBasicsSubmit.classList.add("btn-success");
    }else{
      jsSettingsBasicsSubmit.disabled = true;
      jsSettingsBasicsSubmit.classList.remove("btn-success");
      jsSettingsBasicsSubmit.classList.add("btn-danger");
    }
}

function jsSettingsPasswordSubmitEnable() {
	if (jsSettingsPasswordRegexPattern.test(jsSettingsPasswordCurrent.value) &&
		jsSettingsPasswordRegexPattern.test(jsSettingsPasswordNew.value) &&
		jsSettingsPasswordRegexPattern.test(jsSettingsPasswordConf.value) &&
		jsSettingsPasswordCurrent.value != jsSettingsPasswordNew.value &&
		jsSettingsPasswordNew.value == jsSettingsPasswordConf.value) {
		jsSettingsPasswordSubmit.disabled = false;
		jsSettingsPasswordSubmit.classList.remove("btn-danger");
		jsSettingsPasswordSubmit.classList.add("btn-success");
	}else{
		jsSettingsPasswordSubmit.disabled = true;
		jsSettingsPasswordSubmit.classList.remove("btn-success");
		jsSettingsPasswordSubmit.classList.add("btn-danger");
	}
}


  function jsSettingsValidateName(elementId) {
    jsSettingsBasicsSubmitEnable();
    var element =  document.getElementById(elementId);
  
  
    if(!jsSettingsBasicsRegexPatternName.test(element.value)) {
      if (!document.getElementById(elementId + "InvalidFeedback")) {
        element.classList.add("is-invalid");
        var newElement = document.createElement("div");
        newElement.setAttribute("id", elementId + "InvalidFeedback");
        newElement.classList.add("invalid-feedback");
        var newElementContent = document.createTextNode(jsShowInputFeedback(elementId));
        newElement.appendChild(newElementContent);
        element.parentNode.insertBefore(newElement, element.nextSibling);
      }
    }else{
      if (document.getElementById(elementId + "InvalidFeedback")) {
        document.getElementById(elementId + "InvalidFeedback").parentElement.removeChild(document.getElementById(elementId + "InvalidFeedback"));
      }
      element.classList.remove("is-invalid");
      element.classList.add("is-valid");
    }
  }

  function jsSettingsValidateAge(elementId) {
    jsSettingsBasicsSubmitEnable();
    var element =  document.getElementById(elementId);
  
  
    if(!jsSettingsBasicsRegexPatternAge.test(element.value)) {
      if (!document.getElementById(elementId + "InvalidFeedback")) {
        element.classList.add("is-invalid");
        var newElement = document.createElement("div");
        newElement.setAttribute("id", elementId + "InvalidFeedback");
        newElement.classList.add("invalid-feedback");
        var newElementContent = document.createTextNode(jsShowInputFeedback(elementId));
        newElement.appendChild(newElementContent);
        element.parentNode.insertBefore(newElement, element.nextSibling);
      }
    }else{
      if (document.getElementById(elementId + "InvalidFeedback")) {
        document.getElementById(elementId + "InvalidFeedback").parentElement.removeChild(document.getElementById(elementId + "InvalidFeedback"));
      }
      element.classList.remove("is-invalid");
      element.classList.add("is-valid");
    }
  }

function jsSettingsValidatePassword(){
	jsSettingsPasswordSubmitEnable();

	//*** FIRST CASE ***
	//CURRENT MATCHES REGEX: NO
	if (!jsSettingsPasswordRegexPattern.test(jsSettingsPasswordCurrent.value)) {
        //console.log("FIRST CASE: current matches regex: no");

        //NEW NOT DISABLED -> DISABLE
        if (!jsSettingsPasswordNew.disabled) {
            jsSettingsPasswordNew.disabled = true;
            jsSettingsPasswordNew.classList.remove("is-invalid");
            jsSettingsPasswordNew.classList.remove("is-valid");
        }

        //CONF NOT DISABLED -> DISABLE
        if (!jsSettingsPasswordConf.disabled) {
            jsSettingsPasswordConf.disabled = true;
            jsSettingsPasswordConf.classList.remove("is-invalid");
            jsSettingsPasswordConf.classList.remove("is-valid");
        }
  

        //NEW INVALID FEEDBACK EXISTS: YES -> REMOVE IT
        if (document.getElementById("formSettingsPasswordNewInvalidFeedback")) {
            document.getElementById("formSettingsPasswordNewInvalidFeedback").parentElement.removeChild(document.getElementById("formSettingsPasswordNewInvalidFeedback"));
        }
  
        //CONF INVALID FEEDBACK EXISTS: YES -> REMOVE IT
        if (document.getElementById("formSettingsPasswordConfInvalidFeedback")) {
            document.getElementById("formSettingsPasswordConfInvalidFeedback").parentElement.removeChild(document.getElementById("formSettingsPasswordConfInvalidFeedback"));
        }
  
        
        //CURRENT INVALID FEEDBACK EXISTS: NO -> CREATE IT
        if (!document.getElementById("formSettingsPasswordCurrentInvalidFeedback")) {
            jsSettingsPasswordCurrent.classList.remove("is-valid");
            jsSettingsPasswordCurrent.classList.add("is-invalid");
            var newElement = document.createElement("div");
            newElement.setAttribute("id", "formSettingsPasswordCurrentInvalidFeedback");
            newElement.classList.add("invalid-feedback");
            var newElementContent = document.createTextNode("Password must be between 8 and 16 characters long, with at least one uppercase and lowercase character, one number and one special character (@, *, $ or #).");
            newElement.appendChild(newElementContent);
            jsSettingsPasswordCurrent.parentNode.insertBefore(newElement, jsSettingsPasswordCurrent.nextSibling);
        }



	//*** SECOND CASE ***
	//CURRENT MATCHES REGEX: YES
	//NEW MATCHES REGEX: NO
	} else if(!jsSettingsPasswordRegexPattern.test(jsSettingsPasswordNew.value)) {
        //console.log("SECOND CASE: current matches regex: yes | new matches regex: no");

        //CONF NOT DISABLED -> DISABLE
        if (!jsSettingsPasswordConf.disabled) {
            jsSettingsPasswordConf.disabled = true;
            jsSettingsPasswordConf.classList.remove("is-invalid");
            jsSettingsPasswordConf.classList.remove("is-valid");
        }

        
        //CURRENT INPUT BORDER -> GREEN
        jsSettingsPasswordCurrent.classList.remove("is-invalid");
        jsSettingsPasswordCurrent.classList.add("is-valid");

        //CURRENT INVALID FEEDBACK EXISTS: YES -> REMOVE IT
        if (document.getElementById("formSettingsPasswordCurrentInvalidFeedback")) {
        document.getElementById("formSettingsPasswordCurrentInvalidFeedback").parentElement.removeChild(document.getElementById("formSettingsPasswordCurrentInvalidFeedback"));
        }

        //NEW INVALID FEEDBACK EXISTS: YES -> REMOVE IT
        if (document.getElementById("formSettingsPasswordNewInvalidFeedback")) {
            document.getElementById("formSettingsPasswordNewInvalidFeedback").parentElement.removeChild(document.getElementById("formSettingsPasswordNewInvalidFeedback"));
        }
  
        //CONF INVALID FEEDBACK EXISTS: YES -> REMOVE IT
        if (document.getElementById("formSettingsPasswordConfInvalidFeedback")) {
            document.getElementById("formSettingsPasswordConfInvalidFeedback").parentElement.removeChild(document.getElementById("formSettingsPasswordConfInvalidFeedback"));
        }
  

        //NEW DISABLED -> ENABLE
        if (jsSettingsPasswordNew.disabled) {
            jsSettingsPasswordNew.disabled = false;
        }

        //NEW INVALID FEEDBACK EXISTS: NO -> CREATE IT
        if (!document.getElementById("formSettingsPasswordNewInvalidFeedback")) {
            jsSettingsPasswordNew.classList.remove("is-valid");
            jsSettingsPasswordNew.classList.add("is-invalid");
            var newElement = document.createElement("div");
            newElement.setAttribute("id", "formSettingsPasswordNewInvalidFeedback");
            newElement.classList.add("invalid-feedback");
            var newElementContent = document.createTextNode("Password must be between 8 and 16 characters long, with at least one uppercase and lowercase character, one number and one special character (@, *, $ or #).");
            newElement.appendChild(newElementContent);
            jsSettingsPasswordNew.parentNode.insertBefore(newElement, jsSettingsPasswordNew.nextSibling);
        }




	//*** THIRD CASE ***
	//CURRENT MATCHES REGEX: YES
	//NEW MATCHES REGEX: YES
	//CURRENT DIFFERS NEW: NO
	} else if(jsSettingsPasswordCurrent.value == jsSettingsPasswordNew.value) {
        //console.log("THIRD CASE: current matches regex: yes | new matches regex: yes | current differs new: no");

        //NEW DISABLED -> ENABLE
        if (jsSettingsPasswordNew.disabled) {
            jsSettingsPasswordNew.disabled = false;
        }


        //CONF NOT DISABLED -> DISABLE
        if (!jsSettingsPasswordConf.disabled) {
            jsSettingsPasswordConf.disabled = true;
            jsSettingsPasswordConf.classList.remove("is-invalid");
            jsSettingsPasswordConf.classList.remove("is-valid");
        }

        //CURRENT INVALID FEEDBACK EXISTS: YES -> REMOVE IT
        if (document.getElementById("formSettingsPasswordCurrentInvalidFeedback")) {
            document.getElementById("formSettingsPasswordCurrentInvalidFeedback").parentElement.removeChild(document.getElementById("formSettingsPasswordCurrentInvalidFeedback"));
        }
  

        
        //NEW INVALID FEEDBACK EXISTS: YES -> REMOVE IT
        if (document.getElementById("formSettingsPasswordNewInvalidFeedback")) {
            document.getElementById("formSettingsPasswordNewInvalidFeedback").parentElement.removeChild(document.getElementById("formSettingsPasswordNewInvalidFeedback"));
        }

        //CONF INVALID FEEDBACK EXISTS: YES -> REMOVE IT
        if (document.getElementById("formSettingsPasswordConfInvalidFeedback")) {
            document.getElementById("formSettingsPasswordConfInvalidFeedback").parentElement.removeChild(document.getElementById("formSettingsPasswordConfInvalidFeedback"));
        }

        //CURRENT INPUT BORDER -> GREEN
        jsSettingsPasswordCurrent.classList.remove("is-invalid");
        jsSettingsPasswordCurrent.classList.add("is-valid");

  
        
        //NEW INVALID FEEDBACK EXISTS: NO -> CREATE IT
        if (!document.getElementById("formSettingsPasswordNewInvalidFeedback")) {
            jsSettingsPasswordNew.classList.remove("is-valid");
            jsSettingsPasswordNew.classList.add("is-invalid");
            var newElement = document.createElement("div");
            newElement.setAttribute("id", "formSettingsPasswordNewInvalidFeedback");
            newElement.classList.add("invalid-feedback");
            var newElementContent = document.createTextNode("New password must be different from the current password");
            newElement.appendChild(newElementContent);
            jsSettingsPasswordNew.parentNode.insertBefore(newElement, jsSettingsPasswordNew.nextSibling);
        }
  


	//*** FOURTH CASE ***
	//CURRENT MATCHES REGEX: YES
	//NEW MATCHES REGEX: YES
	//CURRENT DIFFERS NEW: YES
	//NEW MATCHES CONF: NO
	} else if(jsSettingsPasswordNew.value != jsSettingsPasswordConf.value) {
        //console.log("FOURTH CASE: current matches regex: yes | new matches regex: yes | current differs new: yes | new matches conf: no");

        //NEW DISABLED -> ENABLE
        if (jsSettingsPasswordNew.disabled) {
            jsSettingsPasswordNew.disabled = false;
        }

        
        //CONF DISABLED -> ENABLE
        if (jsSettingsPasswordConf.disabled) {
            jsSettingsPasswordConf.disabled = false;
        }

        //CURRENT INVALID FEEDBACK EXISTS: YES -> REMOVE IT
        if (document.getElementById("formSettingsPasswordCurrentInvalidFeedback")) {
            document.getElementById("formSettingsPasswordCurrentInvalidFeedback").parentElement.removeChild(document.getElementById("formSettingsPasswordCurrentInvalidFeedback"));
        }
  

        //NEW INVALID FEEDBACK EXISTS: YES -> REMOVE IT
        if (document.getElementById("formSettingsPasswordNewInvalidFeedback")) {
        document.getElementById("formSettingsPasswordNewInvalidFeedback").parentElement.removeChild(document.getElementById("formSettingsPasswordNewInvalidFeedback"));
        }

        //CURRENT INPUT BORDER -> GREEN
        jsSettingsPasswordCurrent.classList.remove("is-invalid");
        jsSettingsPasswordCurrent.classList.add("is-valid");


        //NEW INPUT BORDER -> GREEN
        jsSettingsPasswordNew.classList.remove("is-invalid");
        jsSettingsPasswordNew.classList.add("is-valid");

        //CONF INVALID FEEDBACK EXISTS: NO -> CREATE IT
        if (!document.getElementById("formSettingsPasswordConfInvalidFeedback")) {
            jsSettingsPasswordConf.classList.remove("is-valid");
            jsSettingsPasswordConf.classList.add("is-invalid");
            var newElement = document.createElement("div");
            newElement.setAttribute("id", "formSettingsPasswordConfInvalidFeedback");
            newElement.classList.add("invalid-feedback");
            var newElementContent = document.createTextNode("Passwords don't match");
            newElement.appendChild(newElementContent);
            jsSettingsPasswordConf.parentNode.insertBefore(newElement, jsSettingsPasswordConf.nextSibling);
        }



	//*** FIFTH CASE ***
	//CURRENT MATCHES REGEX: YES
	//NEW MATCHES REGEX: YES
	//CURRENT DIFFERS NEW: YES
	//NEW MATCHES CONF: YES
	} else {
        //console.log("FIFTH CASE: current matches regex: yes | new matches regex: yes | current differs new: yes | new matches conf: yes");

        //NEW DISABLED -> ENABLE
        if (jsSettingsPasswordNew.disabled) {
            jsSettingsPasswordNew.disabled = false;
        }


        //CONF DISABLED -> ENABLE
        if (jsSettingsPasswordConf.disabled) {
            jsSettingsPasswordConf.disabled = false;
        }

        //CURRENT INVALID FEEDBACK EXISTS: YES -> REMOVE IT
        if (document.getElementById("formSettingsPasswordCurrentInvalidFeedback")) {
            document.getElementById("formSettingsPasswordCurrentInvalidFeedback").parentElement.removeChild(document.getElementById("formSettingsPasswordCurrentInvalidFeedback"));
        }
  

        //NEW INVALID FEEDBACK EXISTS: YES -> REMOVE IT
        if (document.getElementById("formSettingsPasswordNewInvalidFeedback")) {
        document.getElementById("formSettingsPasswordNewInvalidFeedback").parentElement.removeChild(document.getElementById("formSettingsPasswordNewInvalidFeedback"));
        }

        
        //CONF INVALID FEEDBACK EXISTS: YES -> REMOVE IT
        if (document.getElementById("formSettingsPasswordConfInvalidFeedback")) {
            document.getElementById("formSettingsPasswordConfInvalidFeedback").parentElement.removeChild(document.getElementById("formSettingsPasswordConfInvalidFeedback"));
        }

        //CURRENT INPUT BORDER -> GREEN
        jsSettingsPasswordCurrent.classList.remove("is-invalid");
        jsSettingsPasswordCurrent.classList.add("is-valid");


        //NEW INPUT BORDER -> GREEN
        jsSettingsPasswordNew.classList.remove("is-invalid");
        jsSettingsPasswordNew.classList.add("is-valid");

        
        //CONF INPUT BORDER -> GREEN
        jsSettingsPasswordConf.classList.remove("is-invalid");
        jsSettingsPasswordConf.classList.add("is-valid"); 
  


	}
}

  
  