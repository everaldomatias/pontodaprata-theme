window.addEventListener('DOMContentLoaded', (event) => {

    // <abbr class="required" title="obrigatório">*</abbr>
    let cepAbbr = document.createElement('abbr');
    cepAbbr.textContent = '*';
    cepAbbr.classList.add('required');
    cepAbbr.setAttribute('title', 'obrigatório');

    let cpf = document.querySelector('[for="cpf"]');
    cpf.append(cepAbbr);

    //
    let lastRow = document.querySelector('.woocommerce-form-row:last-child');
    messageError = document.createElement('div');
    messageError.classList.add('message-form-empty');
    messageError.textContent = 'Preencha todos os campos obrigatórios.';

    lastRow.insertBefore(messageError, lastRow.firstChild);

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
            messageError.classList.remove('show');
        } else {
            submitButton.disabled = true;
            messageError.classList.add('show');
        }
    }, 750);

})