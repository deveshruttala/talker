var jsPostsContent = document.getElementById("formPostsContent");
var jsPostsSubmit = document.getElementById("formPostsSubmit");
var jsPostsRegexPatternContent = /^[^<>]{1,}$/;

jsPostsSubmit.disabled = true;
jsPostsSubmit.classList.remove("btn-success");
jsPostsSubmit.classList.add("btn-danger");

function jsPostsSubmitEnable(elementId) {

    if (elementId == "formPostsContent") {
        var jsPostsContent = document.getElementById("formPostsContent");
        var jsPostsSubmit = document.getElementById("formPostsSubmit");
    } else {
        var jsPostsContent = document.getElementById("formPostsContentEdited" + elementId);
        var jsPostsSubmit = document.getElementById("formPostsSubmitButton" + elementId);
    }
    

	if (jsPostsRegexPatternContent.test(jsPostsContent.value)) {
		jsPostsSubmit.disabled = false;
		jsPostsSubmit.classList.remove("btn-danger");
		jsPostsSubmit.classList.add("btn-success");
	}else{
		jsPostsSubmit.disabled = true;
		jsPostsSubmit.classList.remove("btn-success");
		jsPostsSubmit.classList.add("btn-danger");
	}
}


function jsPostsValidateTextArea(elementId) {
    jsPostsSubmitEnable(elementId);
    
    if (elementId == "formPostsContent") {
        var element =  document.getElementById(elementId);
    }else{
        var element = document.getElementById("formPostsContentEdited" + elementId);
    }


	if(!jsPostsRegexPatternContent.test(element.value)) {
		if (!document.getElementById(elementId + "InvalidFeedback")) {
			element.classList.add("is-invalid");
			var newElement = document.createElement("div");
			newElement.setAttribute("id", elementId + "InvalidFeedback");
			newElement.classList.add("invalid-feedback");
			var newElementContent = document.createTextNode("Post can not be empty and can not contain '<' and '>' characters.");
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

function showTextAreaByPostId(elementId) {
    
    //store the original content before editing so you can restore it upon clicking Cancel button
    var originalContent = document.getElementById("databasePostsContent" + elementId).innerText;
    
    if (document.getElementById("formPostsContentEdited" + elementId).hidden == true) {

        //reset the content of the textarea to the original content from the database
        document.getElementById("formPostsContentEdited" + elementId).value = originalContent;

        document.getElementById("formPostsContentEdited" + elementId).hidden = false;
        document.getElementById("formPostsEditButton" + elementId).text = "Cancel";
        document.getElementById("formPostsEditButton" + elementId).classList.remove("btn-primary");
        document.getElementById("formPostsEditButton" + elementId).classList.add("btn-danger");

        //create the Save button
        var saveButton = document.createElement("button");
        saveButton.setAttribute("type", "submit");
        saveButton.setAttribute("id", "formPostsSubmitButton" + elementId);
        saveButton.setAttribute("name", "formPostsSubmitButton" + elementId);
        saveButton.classList.add("btn");
        saveButton.classList.add("btn-primary");
        saveButton.classList.add("btn-sm");
        saveButton.innerText = "Save";
        document.getElementById("formPostsContentEdited" + elementId).parentNode.parentNode.appendChild(saveButton);

        //hide the original post
        document.getElementById("databasePostsContent" + elementId).hidden = true;


    } else {
        document.getElementById("formPostsContentEdited" + elementId).hidden = true;
        document.getElementById("formPostsEditButton" + elementId).text = "Edit";
        document.getElementById("formPostsEditButton" + elementId).classList.remove("btn-danger");
        document.getElementById("formPostsEditButton" + elementId).classList.add("btn-primary");

        //reset the content of the textarea to the original content from the database
        document.getElementById("formPostsContentEdited" + elementId).value = originalContent;

        //check the validity of the content
        jsPostsValidateTextArea(elementId);

        
        //remove the Save button
        document.getElementById("formPostsContentEdited" + elementId).parentElement.parentElement.removeChild(document.getElementById("formPostsSubmitButton" + elementId));

        //show the original post
        document.getElementById("databasePostsContent" + elementId).hidden = false;

    }
}
