import { translations } from "../script/compilationOfTranslate.js";
//execute the function
updateLanguage(getCurrentLanguage());
eventForRadioLanguage();

// Function to translate text
function translateUsingJs(key) {
  const lang = getCurrentLanguage();
  return translations[lang][key] || key;
}

// Function to update language
function updateLanguage(lang) {
    
  setCurrentLanguage(lang);

  //update the language dropdown
  // Get the label of the checkbox
  let languageLabel = document.querySelector(".navbar .language-item .dropdown-btn");
  let span = document.createElement("span");
  span.className = "material-symbols-outlined";
  span.textContent = "language";
  languageLabel.innerHTML = "";
  languageLabel.appendChild(span);
  let chosen;
  switch (lang) {
    case "en":
      chosen = "English";
      break;
    case "es":
      chosen = "Spanish";
      break;
    case "fn":
      chosen = "Filipino";
      break;
    default:
      break;
  }
  languageLabel.appendChild(document.createTextNode(" " + chosen));
  

  // Translate content on the page
  const elementsToTranslate = document.querySelectorAll("*");
  
  elementsToTranslate.forEach(function (element) {
    // Iterate over child nodes
    for (let i = 0; i < element.childNodes.length; i++) {
      const childNode = element.childNodes[i];

      // Check if the current child node is a direct text node
      if (
        childNode.nodeType === Node.TEXT_NODE
      ) {
        // If it is a direct text node, translate the text
        childNode.nodeValue = translateUsingJs(childNode.nodeValue.trim());
      }
    }
  });
}

// Function to get current language from local storage
function getCurrentLanguage() {
  return localStorage.getItem("language") || "en";
}

// Function to set current language in local storage
function setCurrentLanguage(lang) {
  localStorage.setItem("language", lang);
}

function eventForRadioLanguage() {
  // Get all radio buttons with the name 'language'
  let languageRadios = document.querySelectorAll('input[name="language"]');

  // Get the checkbox
  let languageCheckbox = document.querySelector("#languageDropdown");

  // Add event listener for each radio button
  languageRadios.forEach(function (radio) {
    radio.addEventListener("change", function () {
      if (this.checked) { 
        // Get the language from the data-language attribute
        let selectedLang = this.dataset.language;
        // Update the language
        updateLanguage(selectedLang);
        // Uncheck the checkbox
        languageCheckbox.checked = false;
        location.reload();
      }
    });
  });
}
