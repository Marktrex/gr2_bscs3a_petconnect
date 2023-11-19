// Translation maps
const translations = {
    'en': {
        'hello': 'hello',
        'welcome': 'welcome',
        'Frequently Asked Questions' : 'Frequently Asked Questions',
        'Q: What is the purpose of rePaw City?' : 'Q: What is the purpose of rePaw City?'
        // Add more translations as needed
    },
    'es': {
        'hello': 'hola',
        'welcome': 'bienvenido',
        'Frequently Asked Questions' : 'Preguntas frecuentes',
        'Q: What is the purpose of rePaw City?' : 'Q: Cuál es el propósito de rePaw City??'
        // Add more translations as needed
    },
    'fn':
    {
        'hello': 'helow',
        'welcome': 'kumusta',
        'Frequently Asked Questions' : 'Mga Madalas Itanong',
        'Q: What is the purpose of rePaw City?' : 'Q: Ano ang layunin ng rePaw City??'
    }
};

// Function to translate text
function translateUsingJs(key) {
    return translations[getCurrentLanguage()][key] || key;
}

// Function to update language
function updateLanguage(lang) {
    setCurrentLanguage(lang);

    // Example: translate content on the page
    const elementsToTranslate = document.querySelectorAll('[data-translate]');
    elementsToTranslate.forEach(function (element) {
        const translationKey = element.getAttribute('data-translate');
        element.textContent = translateUsingJs(translationKey);
    });
}

// Function to get current language from local storage
function getCurrentLanguage() {
    return localStorage.getItem('language') || 'en';
}

// Function to set current language in local storage
function setCurrentLanguage(lang) {
    localStorage.setItem('language', lang);
}


updateLanguage(getCurrentLanguage());

// Change language on select change
document.querySelector('#languageSelector').addEventListener('change', function () {
    let selectedLang = this.value;
    updateLanguage(selectedLang);
});
