window.addEventListener('DOMContentLoaded', (event) => {

    // Disable submit button
    let submitButton = document.querySelector('.woocommerce-form-register__submit');
    submitButton.disabled = true;

    // Get register type (PF or PJ)
    let registerTypeField = document.querySelectorAll('[name="tipo_de_cadastro"]');
    let registerType = document.querySelector('[name="tipo_de_cadastro"]:checked').value;

    // Add listener in register type
    registerTypeField.forEach(e => {
        e.addEventListener('change', (el) => {
            registerType = el.target.value;
        });
    });

    // Get form fields
    let form = document.querySelector('.woocommerce-form.woocommerce-form-register.register');
    const fields = form.querySelectorAll('#nome_completo, #cep, #logradouro, #numero, #bairro, #cidade, #celular, #instagram, #reg_email, #reg_password');
    let validInputs = '';

    let type = '';

    // Check fields is empty
    setInterval( () => {
        validInputs = Array.from(fields).filter( input => input.value === "");

        if (registerType == 'pf') {
            type = document.querySelector("#cpf");
        } else {
            type = document.querySelector("#cnpj");
        }

        if (validInputs.length === 0 && type.value.length > 0) {
            submitButton.removeAttribute('disabled');
        } else {
            submitButton.disabled = true;
        }
    }, 750);

})