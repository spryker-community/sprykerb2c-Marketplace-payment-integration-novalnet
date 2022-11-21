import Component from 'ShopUi/models/component';

export default class NnSepa extends Component {
    form: HTMLFormElement;

    protected submitButton: HTMLButtonElement[];

    protected readyCallback(): void {}

    init() {
        var element = document.getElementById('paymentForm_novalnetSepa_iban');
        ['click', 'paste', 'keydown', 'keyup'].forEach((evt) => {
            element.addEventListener(evt, (event) => {
                var result = event.target.value;
                if (result != undefined && result != '') {
                    result = result.toUpperCase();
                    if (result.match(/(?:CH|MC|SM|GB)/)) {
                        document.querySelector('#nn_sepa_bic').style.display = "block";
                    } else {
                        document.querySelector('#nn_sepa_bic').style.display = "none";
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

            if (checkedValue == 'novalnetSepa') {
                var iban = document.getElementById("paymentForm_novalnetSepa_iban").value;

                if (iban == '') {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    alert(document.getElementById("sepa_iban_invalid").value);
                    return false;
                }

                if (iban.match(/(?:CH|MC|SM|GB)/) && document.getElementById("paymentForm_novalnetSepa_bic").value == '') {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    alert(document.getElementById("sepa_bic_invalid").value);
                    return false;
                }
            }
        });

        var iban = document.getElementById("paymentForm_novalnetSepa_iban").value;
        if (iban.match(/(?:CH|MC|SM|GB)/)) {
            document.querySelector('#nn_sepa_bic').style.display = "block";
        }
    }
}
