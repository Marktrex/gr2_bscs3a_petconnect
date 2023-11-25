// Translation maps
const translations = {
    "en": {
        "Add News": "Add News",
        "Add Pets": "Add Pets",
        "Address": "Address",
        "Adopt": "Adopt",
        "Already have an Account?": "Already have an Account?",
        "Chat": "Chat",
        "Dashboard": "Dashboard",
        "Don't have an account?": "Don't have an account?",
        "Donate": "Donate",
        "Email": "Email",
        "Forgot Password?": "Forgot Password?",
        "Let's Get Started! Create an account to login.": "Let's Get Started! Create an account to login.",
        "Log in": "Log in",
        "Logout": "Logout",
        "Manage News": "Manage News",
        "Manage Pets": "Manage Pets",
        "Manage Users": "Manage Users",
        "Mobile #": "Mobile #",
        "Modify Featured Image": "Modify Featured Image",
        "Morning Session": "Morning Session",
        "Name": "Name",
        "Register": "Register",
        "Remember me": "Remember me",
        "Sign up": "Sign up",
        "Status": "Status",
        "Total Appointments": "Total Appointments",
        "Type": "Type",
        "Visit": "Visit",
        "Volunteer": "Volunteer",
        "Welcome back, some of our furry friends are looking for their forever home!": "Welcome back, some of our furry friends are looking for their forever home!",
        "login": "Login"
    },
    "es": {
        "Add News": "Agregar noticias",
        "Add Pets": "Agregar mascotas",
        "Address": "DirecciÃ³n",
        "Adopt": "Adoptar",
        "Already have an Account?": "Â¿Ya tienes una cuenta?",
        "Chat": "Chat",
        "Dashboard": "Tablero",
        "Don't have an account?": "Â¿No tienes una cuenta?",
        "Donate": "Donar",
        "Email": "Correo electrÃ³nico",
        "Forgot Password?": "Â¿Olvidaste tu contraseÃ±a?",
        "Let's Get Started! Create an account to login.": "Â¡Comencemos! Crea una cuenta para iniciar sesiÃ³n.",
        "Log in": "Iniciar sesiÃ³n",
        "Logout": "Cerrar sesiÃ³n",
        "Manage News": "Gestionar noticias",
        "Manage Pets": "Gestionar mascotas",
        "Manage Users": "Gestionar usuarios",
        "Mobile #": "NÃºmero de mÃ³vil",
        "Modify Featured Image": "Modificar imagen destacada",
        "Morning Session": "SesiÃ³n de la maÃ±ana",
        "Name": "Nombre",
        "Register": "Registro",
        "Remember me": "RecuÃ©rdame",
        "Sign up": "RegÃ­strate",
        "Status": "Estado",
        "Total Appointments": "Citas totales",
        "Type": "Tipo",
        "Visit": "Visitar",
        "Volunteer": "Voluntariado",
        "Welcome back, some of our furry friends are looking for their forever home!": "Â¡Bienvenido de nuevo, algunos de nuestros amigos peludos buscan su hogar para siempre!",
        "login": "Iniciar sesiÃ³n"
    },
    "fn": {
        "Add News": "Agregar noticias",
        "Add Pets": "Agregar mascotas",
        "Address": "Address",
        "Adopt": "Mag-ampon",
        "Already have an Account?": "Mayroon ka na bang account?",
        "Chat": "Chat",
        "Dashboard": "Tablero",
        "Don't have an account?": "Wala pang account?",
        "Donate": "Mag-donate",
        "Email": "Email",
        "Forgot Password?": "Nakalimutan ang password?",
        "Let's Get Started! Create an account to login.": "Magsimula tayo! Gumawa ng account para makapag-login.",
        "Log in": "Mag-login",
        "Logout": "Cerrar sesiÃ³n",
        "Manage News": "Gestionar noticias",
        "Manage Pets": "Gestionar mascotas",
        "Manage Users": "Gestionar usuarios",
        "Mobile #": "Mobile #",
        "Modify Featured Image": "Modificar imagen destacada",
        "Morning Session": "Umaga Session",
        "Name": "Pangalan",
        "Register": "Magparehistro",
        "Remember me": "Tandaan mo ako",
        "Sign up": "Mag-sign up",
        "Status": "Katayuan",
        "Total Appointments": "Kabuuang mga Appointment",
        "Type": "Uri",
        "Visit": "Bisitahin",
        "Volunteer": "Mag-volunteer",
        "Welcome back, some of our furry friends are looking for their forever home!": "Maligayang pagbabalik, ilan sa aming mga kaibigang may balahibo ang naghahanap ng kanilang pang-forever na tahanan!",
        "login": "Mag-login"
    }
};

//execute the function
updateLanguage(getCurrentLanguage());
eventForRadioLanguage();

// Function to translate text
function translateUsingJs(key) {
    const lang = getCurrentLanguage();
    return translations[lang][key] || "123";
}


// Function to update language
function updateLanguage(lang) {
    setCurrentLanguage(lang);

    // Translate content on the page
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

function eventForRadioLanguage(){
    // Get all radio buttons with the name 'language'
    let languageRadios = document.querySelectorAll('input[name="language"]');
    // Get the label of the checkbox
    let languageLabel = document.querySelector('.navbar .dropdown-btn');
    // Get the checkbox
    let languageCheckbox = document.querySelector('#languageDropdown');

    // Add event listener for each radio button
    languageRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.checked) {
                // Get the language from the data-language attribute
                let selectedLang = this.dataset.language;
                // Create a new span element
                let span = document.createElement('span');
                // Set the class of the span
                span.className = 'material-symbols-outlined';
                // Set the text content of the span
                span.textContent = 'language';
                // Clear the label's content
                languageLabel.innerHTML = '';
                // Append the span to the label
                languageLabel.appendChild(span);
                // Append the language to the label
                languageLabel.appendChild(document.createTextNode(' ' + radio.getAttribute('id')));
                // Update the language
                updateLanguage(selectedLang);
                // Uncheck the checkbox
                languageCheckbox.checked = false;
            }
        });
    });
}

