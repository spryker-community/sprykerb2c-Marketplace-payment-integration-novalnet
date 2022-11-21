import Component from 'ShopUi/models/component';

export default class SepaGuarantee extends Component {
    form: HTMLFormElement;

    protected submitButton: HTMLButtonElement[];

    protected readyCallback(): void {}

    init() {
        var element = document.getElementById('paymentForm_novalnetSepaGuarantee_iban');
        ['click', 'paste', 'keydown', 'keyup'].forEach((evt) => {
            element.addEventListener(evt, (event) => {
                var result = event.target.value;
                if (result != undefined && result != '') {
                    result = result.toUpperCase();
                    if (result.match(/(?:CH|MC|SM|GB)/)) {
                        document.querySelector('#nn_sepa_guarantee_bic').style.display = "block";
                    } else {
                        document.querySelector('#nn_sepa_guarantee_bic').style.display = "none";
                    }
                }
            });
        });

        var element = document.getElementsByName('paymentForm');

        element[0].addEventListener('submit', event => {
            var checkedValue = null;
            var inputElements = document.getElementsByName("paymentForm[paymentSelection]");
            for (var i = 0; inputElements[i]; ++i) {
                if (inputElements[i].checked) {
                    checkedValue = inputElements[i].value;
                    break;
                }
            }

            var birthdate = document.getElementById("paymentForm_novalnetSepaGuarantee_dob").value;

            if (checkedValue == 'novalnetSepaGuarantee') {
                var iban = document.getElementById("paymentForm_novalnetSepaGuarantee_iban").value;

                if (iban == '') {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    alert(document.getElementById("sepa_guarantee_iban_invalid").value);
                    return false;
                }

                if (iban.match(/(?:CH|MC|SM|GB)/) && document.getElementById("paymentForm_novalnetSepaGuarantee_bic").value == '') {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    alert(document.getElementById("sepa_guarantee_bic_invalid").value);
                    return false;
                }

                if (birthdate == undefined || birthdate == '' ) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    alert(document.getElementById("birthdate_missing").value);
                } else {
                    var isValid = true;
                    if (!NovalnetUtility.validateDateFormat(birthdate)) {
                        isValid = false;
                    } else {
                        var dateOfBirth = birthdate.split('.');
                        var formatedDob = new Date(dateOfBirth[2], (dateOfBirth[1] - 1), dateOfBirth[0]);
                        // calculate month difference from current date in time
                        var monthDiff = Date.now() - formatedDob.getTime();

                        // convert the calculated difference in date format
                        var dateDiff = new Date(monthDiff);

                        // extract year from date
                        var year = dateDiff.getUTCFullYear();

                        // now calculate the age of the user
                        var age = Math.abs(year - 1970);

                        if (age < 18) {
                            isValid = false;
                        }
                    }

                    if (isValid == false) {
                        event.preventDefault();
                        event.stopImmediatePropagation();
                        alert(document.getElementById("birthdate_invalid").value);
                    }
                }
            }
        });

        var iban = document.getElementById("paymentForm_novalnetSepaGuarantee_iban").value;
        if (iban.match(/(?:CH|MC|SM|GB)/)) {
            document.querySelector('#nn_sepa_guarantee_bic').style.display = "block";
        }
    }
}
