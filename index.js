var jsSignUpEmail = document.getElementById("formSignUpEmail");
var jsSignInEmail = document.getElementById("formSignInEmail");
var jsEmailRegexPattern = /^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$/;
var jsSignUpPassword = document.getElementById("formSignUpPassword");
var jsSignInPassword = document.getElementById("formSignInPassword");
var jsSignUpPasswordConf = document.getElementById("formSignUpPasswordConf");
var jsPasswordRegexPattern = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@*$#]).{8,16}/;

document.getElementById("formSignUpSubmit").disabled = true;
document.getElementById("formSignUpSubmit").classList.remove("btn-success");
document.getElementById("formSignUpSubmit").classList.add("btn-danger");
document.getElementById("formSignInSubmit").disabled = true;
document.getElementById("formSignInSubmit").classList.remove("btn-success");
document.getElementById("formSignInSubmit").classList.add("btn-danger");

function jsSignUpSubmitEnable() {
    if (jsEmailRegexPattern.test(jsSignUpEmail.value) && jsPasswordRegexPattern.test(jsSignUpPassword.value) && jsSignUpPassword.value == jsSignUpPasswordConf.value) {
        document.getElementById("formSignUpSubmit").disabled = false;
        document.getElementById("formSignUpSubmit").classList.remove("btn-danger");
        document.getElementById("formSignUpSubmit").classList.add("btn-success");
    }else{
        document.getElementById("formSignUpSubmit").disabled = true;
        document.getElementById("formSignUpSubmit").classList.remove("btn-success");
        document.getElementById("formSignUpSubmit").classList.add("btn-danger");
    }
}

function jsSignInSubmitEnable() {
    if (jsEmailRegexPattern.test(jsSignInEmail.value) && jsPasswordRegexPattern.test(jsSignInPassword.value)) {
        document.getElementById("formSignInSubmit").disabled = false;
        document.getElementById("formSignInSubmit").classList.remove("btn-danger");
        document.getElementById("formSignInSubmit").classList.add("btn-success");
    }else{
        document.getElementById("formSignInSubmit").disabled = true;
        document.getElementById("formSignInSubmit").classList.remove("btn-success");
        document.getElementById("formSignInSubmit").classList.add("btn-danger");
    }
}



function jsSignUpValidateEmail() {
    jsSignUpSubmitEnable();
    if(!jsEmailRegexPattern.test(jsSignUpEmail.value)) {
        if (!document.getElementById("formSignUpEmailInvalidFeedback")) {
            jsSignUpEmail.classList.add("is-invalid");
            var newElement = document.createElement("div");
            newElement.setAttribute("id", "formSignUpEmailInvalidFeedback");
            newElement.classList.add("invalid-feedback");
            var newElementContent = document.createTextNode("This is not a valid email address");
            newElement.appendChild(newElementContent);
            jsSignUpEmail.parentNode.insertBefore(newElement, jsSignUpEmail.nextSibling);
        }
    }else{
        if (document.getElementById("formSignUpEmailInvalidFeedback")) {
            document.getElementById("formSignUpEmailInvalidFeedback").parentElement.removeChild(document.getElementById("formSignUpEmailInvalidFeedback"));
        }
        jsSignUpEmail.classList.remove("is-invalid");
        jsSignUpEmail.classList.add("is-valid");
    }
}

function jsSignInValidateEmail() {
    jsSignInSubmitEnable();
    if(!jsEmailRegexPattern.test(jsSignInEmail.value)) {
        jsSignInEmail.classList.add("is-invalid");
    }else{
        jsSignInEmail.classList.remove("is-invalid");
        jsSignInEmail.classList.add("is-valid");
    }
}


function jsSignUpValidatePassword(){
    jsSignUpSubmitEnable();
    if(!jsPasswordRegexPattern.test(jsSignUpPassword.value)) {
        if (!document.getElementById("formSignUpPasswordInvalidFeedback")) {
            jsSignUpPassword.classList.add("is-invalid");
            var newElement = document.createElement("div");
            newElement.setAttribute("id", "formSignUpPasswordInvalidFeedback");
            newElement.classList.add("invalid-feedback");
            var newElementContent = document.createTextNode("Password must be between 8 and 16 characters long, with at least one uppercase and lowercase character, one number and one special character (@, *, $ or #).");
            newElement.appendChild(newElementContent);
            jsSignUpPassword.parentNode.insertBefore(newElement, jsSignUpPassword.nextSibling);
        }
    } else if(jsSignUpPassword.value != jsSignUpPasswordConf.value) {
		if (!document.getElementById("formSignUpPasswordConfInvalidFeedback")) {
            jsSignUpPasswordConf.classList.add("is-invalid");
            var newElement = document.createElement("div");
            newElement.setAttribute("id", "formSignUpPasswordConfInvalidFeedback");
            newElement.classList.add("invalid-feedback");
            var newElementContent = document.createTextNode("Passwords don't match!");
            newElement.appendChild(newElementContent);
            jsSignUpPasswordConf.parentNode.insertBefore(newElement, jsSignUpPasswordConf.nextSibling);
        }
        if (document.getElementById("formSignUpPasswordInvalidFeedback")) {
                document.getElementById("formSignUpPasswordInvalidFeedback").parentElement.removeChild(document.getElementById("formSignUpPasswordInvalidFeedback"));
        }
        jsSignUpPassword.classList.remove("is-invalid");
        jsSignUpPassword.classList.add("is-valid");
    } else {
		if (document.getElementById("formSignUpPasswordConfInvalidFeedback")) {
            document.getElementById("formSignUpPasswordConfInvalidFeedback").parentElement.removeChild(document.getElementById("formSignUpPasswordConfInvalidFeedback"));
        }
        jsSignUpPasswordConf.classList.remove("is-invalid");
        jsSignUpPasswordConf.classList.add("is-valid");
    }
}

function jsSignInValidatePassword() {
    jsSignInSubmitEnable();
    if(!jsPasswordRegexPattern.test(jsSignInPassword.value)) {
        jsSignInPassword.classList.add("is-invalid");
    }else{
        jsSignInPassword.classList.remove("is-invalid");
        jsSignInPassword.classList.add("is-valid");
    }
}