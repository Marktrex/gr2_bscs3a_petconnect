// for showing of password
    
// const showPassword = document.querySelector("#show-password");
// const passwordField = document.querySelector("#password");

// showPassword.addEventListener("click", function(){
//     this.classList.toggle("fa-eye-slash");
//     const type = passwordField.getAttribute("type") 
//     === "password" ? "text" : "password";
//     passwordField.setAttribute("type", type);
// })

// end showing of password

document.addEventListener("DOMContentLoaded", function(event) {
        
    detectColorScheme();
    //determines if the user has a set theme
    function detectColorScheme(){
        let theme="light";    //default to light

        //local storage is used to override OS theme settings
        if(localStorage.getItem("theme")){
            if(localStorage.getItem("theme") == "dark"){
                theme = "dark";
            }
        } else if(!window.matchMedia) {
            //matchMedia method not supported
            return false;
        } else if(window.matchMedia("(prefers-color-scheme: dark)").matches) {
            //OS theme setting detected as dark
            theme = "dark";
        }

        //dark theme preferred, set document with a `data-theme` attribute
        if (theme=="dark") {
            document.documentElement.setAttribute("data-theme", "dark");
            setLogo(true);
        }
        else
        {
            setLogo(false);
        }


    }



    // for manual switching

    const toggleSwitch = document.querySelector('#switch-button-theme');

    //function that changes the theme, and sets a localStorage variable to track the theme between page loads
    function switchTheme(e) {
        

        if (e.target.checked) {
            localStorage.setItem('theme', 'dark');
            document.documentElement.setAttribute('data-theme', 'dark');
            toggleSwitch.checked = true;
            setLogo(true);
        } else {
            localStorage.setItem('theme', 'light');
            document.documentElement.setAttribute('data-theme', 'light');
            toggleSwitch.checked = false;
            setLogo(false);
        }

        window.scrollTo(0, 1);
    }

    //listener for changing themes
    toggleSwitch.addEventListener('change', switchTheme, false);

    //pre-check the dark-theme checkbox if dark-theme is set
    if (document.documentElement.getAttribute("data-theme") == "dark"){
        toggleSwitch.checked = true;
    }


    function setLogo(isDark) {
        const icon = document.querySelector('#logIcon');

        // Check if #logIcon exists
        if (!icon) {
            console.error("#logIcon not found");
            return; // Exit the function if #logIcon does not exist
        }

        const darkIcon = "logo-dark.png";
        const lightIcon = "logo.png";

        let iconValue = icon.getAttribute('src');
        let parts = iconValue.split('/');
        if (isDark) {
            parts[parts.length - 1] = darkIcon;
        } else {
            parts[parts.length - 1] = lightIcon;
        }

        iconValue = parts.join('/');
        icon.setAttribute('src', iconValue);
    }

});