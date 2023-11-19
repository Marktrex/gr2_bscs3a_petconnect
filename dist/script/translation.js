// Translation maps
const translations = {
    'en': { //english language
        '':'',
        'hello': 'hello',
        'welcome': 'welcome',
        //LOGIN PAGE
        'Welcome back, some of our furry friends are looking for their forever home!': 'Welcome back, some of our furry friends are looking for their forever home!',
        'login': 'Login',
        'Remember me': 'Remember me',
        'Forgot Password?': 'Forgot Password?',
        "Don't have an account?": "Don't have an account?",
        'Sign up': 'Sign up',
        //REGISTER PAGE
        'Register': 'Register',
        "Let's Get Started! Create an account to login.": "Let's Get Started! Create an account to login.",
        'Already have an Account?': 'Already have an Account?',
        'Log in': 'Log in',
        //ADMIN PAGE
        'Logout': 'Logout',
        'Dashboard': 'Dashboard',
        'Add Pets': 'Add Pets',
        'Manage Pets': 'Manage Pets',
        'Modify Featured Image': 'Modify Featured Image',
        'Manage Users': 'Manage Users',
        'Add News': 'Add News',
        'Manage News': 'Manage News',
        'Chat': 'Chat',
        'Total Appointments': 'Total Appointments',
        'Adopt': 'Adopt',
        'Donate': 'Donate',
        'Visit': 'Visit',
        'Volunteer': 'Volunteer',
        'Morning Session': 'Morning Session',
        'Type': 'Type',
        'Name': 'Name',
        'Mobile #': 'Mobile #',
        'Address': 'Address',
        'Email': 'Email',
        'Status': 'Status',


        // Add more translations as needed
    },
    'es': { // spanish language
        '':'',
        'hello': 'hello',
        'welcome': 'welcome',
        //LOGIN PAGE
        'Welcome back, some of our furry friends are looking for their forever home!': '¡Bienvenido de nuevo, algunos de nuestros amigos peludos buscan su hogar para siempre!',
        'login': 'Iniciar sesión',
        'Remember me': 'Recuérdame',
        'Forgot Password?': '¿Olvidaste tu contraseña?',
        "Don't have an account?": "¿No tienes una cuenta?",
        'Sign up': 'Regístrate',
        //REGISTER PAGE
        'Register': 'Registro',
        "Let's Get Started! Create an account to login.": "¡Comencemos! Crea una cuenta para iniciar sesión.",
        'Already have an Account?': '¿Ya tienes una cuenta?',
        'Log in': 'Iniciar sesión',

        //ADMIN PAGE
        'Logout': 'Cerrar sesión',
        'Dashboard': 'Tablero',
        'Add Pets': 'Agregar mascotas',
        'Manage Pets': 'Gestionar mascotas',
        'Modify Featured Image': 'Modificar imagen destacada',
        'Manage Users': 'Gestionar usuarios',
        'Add News': 'Agregar noticias',
        'Manage News': 'Gestionar noticias',
        'Chat': 'Chat',
        'Total Appointments': 'Citas totales',
        'Adopt': 'Adoptar',
        'Donate': 'Donar',
        'Visit': 'Visitar',
        'Volunteer': 'Voluntariado',
        'Morning Session': 'Sesión de la mañana',
        'Type': 'Tipo',
        'Name': 'Nombre',
        'Mobile #': 'Número de móvil',
        'Address': 'Dirección',
        'Email': 'Correo electrónico',
        'Status': 'Estado',




        // Add more translations as needed
    },
    'fn':{ //filipino language   
        '':'',
        'hello': 'hello',
        'welcome': 'welcome',
        //LOGIN PAGE
        'Welcome back, some of our furry friends are looking for their forever home!': 'Maligayang pagbabalik, ilan sa aming mga kaibigang may balahibo ang naghahanap ng kanilang pang-forever na tahanan!',
        'login': 'Mag-login',
        'Remember me': 'Tandaan mo ako',
        'Forgot Password?': 'Nakalimutan ang password?',
        "Don't have an account?": "Wala pang account?",
        'Sign up': 'Mag-sign up',
        //REGISTER PAGE
        'Register': 'Magparehistro',
        "Let's Get Started! Create an account to login.": 'Magsimula tayo! Gumawa ng account para makapag-login.',
        'Already have an Account?': 'Mayroon ka na bang account?',
        'Log in': 'Mag-login',


        //ADMIN PAGE
        'Logout': 'Cerrar sesión',
        'Dashboard': 'Tablero',
        'Add Pets': 'Agregar mascotas',
        'Manage Pets': 'Gestionar mascotas',
        'Modify Featured Image': 'Modificar imagen destacada',
        'Manage Users': 'Gestionar usuarios',
        'Add News': 'Agregar noticias',
        'Manage News': 'Gestionar noticias',
        'Chat': 'Chat',
        'Total Appointments': 'Kabuuang mga Appointment',
        'Adopt': 'Mag-ampon',
        'Donate': 'Mag-donate',
        'Visit': 'Bisitahin',
        'Volunteer': 'Mag-volunteer',
        'Morning Session': 'Umaga Session',
        'Type': 'Uri',
        'Name': 'Pangalan',
        'Mobile #': 'Mobile #',
        'Address': 'Address',
        'Email': 'Email',
        'Status': 'Katayuan',





        // Add more translations as needed
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
