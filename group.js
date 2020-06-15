var jsGroupName = document.getElementById("formGroupName");
var jsGroupSubmit = document.getElementById("formGroupSubmit");
var jsGroupRegexPatternName = /^[^<>]{1,}$/;

jsGroupSubmit.disabled = true;
jsGroupSubmit.classList.remove("btn-success");
jsGroupSubmit.classList.add("btn-danger");

function jsGroupSubmitEnable() {
	if (jsGroupRegexPatternName.test(jsGroupName.value)) {
		jsGroupSubmit.disabled = false;
		jsGroupSubmit.classList.remove("btn-danger");
		jsGroupSubmit.classList.add("btn-success");
	}else{
		jsGroupSubmit.disabled = true;
		jsGroupSubmit.classList.remove("btn-success");
		jsGroupSubmit.classList.add("btn-danger");
	}
}

function jsGroupValidateName(elementId) {
	jsGroupSubmitEnable();
	var element =  document.getElementById(elementId);


	if(!jsGroupRegexPatternName.test(element.value)) {
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
