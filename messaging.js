var jsMessagingRecipient = document.getElementById("formMessagingRecipient");
var jsMessagingContent = document.getElementById("formMessagingContent");
var jsMessagingSubmit = document.getElementById("formMessagingSubmit");
var jsMessagingRegexPatternContent = /^[^<>]{1,}$/;

jsMessagingSubmit.disabled = true;
jsMessagingSubmit.classList.remove("btn-success");
jsMessagingSubmit.classList.add("btn-danger");

function jsMessagingSubmitEnable() {
	if (jsMessagingRecipient.options[jsMessagingRecipient.selectedIndex].value != "default" && jsMessagingRegexPatternContent.test(jsMessagingContent.value)) {
		jsMessagingSubmit.disabled = false;
		jsMessagingSubmit.classList.remove("btn-danger");
		jsMessagingSubmit.classList.add("btn-success");
	}else{
		jsMessagingSubmit.disabled = true;
		jsMessagingSubmit.classList.remove("btn-success");
		jsMessagingSubmit.classList.add("btn-danger");
	}
}

function jsMessagingValidateSelect(elementId) {
	jsMessagingSubmitEnable();
	var element =  document.getElementById(elementId);

	if(element.options[element.selectedIndex].value == "default") {
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

function jsMessagingValidateTextArea(elementId) {
	jsMessagingSubmitEnable();
	var element =  document.getElementById(elementId);


	if(!jsMessagingRegexPatternContent.test(element.value)) {
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
