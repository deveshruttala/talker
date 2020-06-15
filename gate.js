  
  function jsShowInputFeedback(elementId) {

    switch (elementId) {
      case "formSettingsBasicsFirstName":
      var feedbackMessage = "First name must be between 3 and 15 characters long and can contain only letters."
      break;
  
      case "formSettingsBasicsLastName":
      var feedbackMessage = "Last name must be between 3 and 15 characters long and can contain only letters."
      break;
  
      case "formSettingsBasicsNickName":
      var feedbackMessage = "Nickname must be between 3 and 15 characters long and can contain only letters."
      break;

      case "formSettingsBasicsAge":
      var feedbackMessage = "Age must be between 20 and 99."
      break;

      case "formMessagingRecipient":
      var feedbackMessage = "Choose the email address of the recipient."
      break;

      case "formMessagingContent":
      var feedbackMessage = "Message can not be empty and can not contain '<' and '>' characters."
      break;

      case "formGroupName":
      var feedbackMessage = "Group name can not be empty and can not contain '<' and '>' characters."
      break;

      case "formPostsContent":
      var feedbackMessage = "Post can not be empty and can not contain '<' and '>' characters."
      break;
    }
  
    return feedbackMessage;
  }

  

  
  