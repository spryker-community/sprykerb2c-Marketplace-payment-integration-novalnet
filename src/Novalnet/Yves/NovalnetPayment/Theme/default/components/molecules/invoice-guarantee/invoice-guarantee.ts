import Component from 'ShopUi/models/component';

export default class InvoiceGuarantee extends Component {
    form: HTMLFormElement;

    protected submitButton: HTMLButtonElement[];

    protected readyCallback(): void {}

    init() {
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

            var birthdate = document.getElementById("paymentForm_novalnetInvoiceGuarantee_dob").value;

            if (checkedValue == 'novalnetInvoiceGuarantee') {
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
    }
}
