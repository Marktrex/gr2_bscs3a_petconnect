document.querySelector('#registerForm').addEventListener('submit', function(event) {
    let password = document.querySelector('#password').value;
    let confirmPassword = document.querySelector('#confirmPassword').value;

    if (password !== confirmPassword) {
        alert("Password and confirm password must be same");
        event.preventDefault();
    }
});