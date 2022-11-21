import Component from 'ShopUi/models/component';

export default class CreditCard extends Component {
	form: HTMLFormElement;

	protected submitButton: HTMLButtonElement[];

	protected readyCallback(): void {}

	init() {
		const element = document.getElementsByName('paymentForm');

		element[0].addEventListener('submit', event => {
			var checkedValue = null;
			var inputElements = document.getElementsByName("paymentForm[paymentSelection]");						
			for (var i = 0; inputElements[i]; ++i) {
				if (inputElements[i].checked) {
					checkedValue = inputElements[i].value;
					break;
				}
			}
			if (checkedValue == 'novalnetCreditCard' && document.getElementById("paymentForm_novalnetCreditCard_panHash").value == '') {
				event.preventDefault();
				event.stopImmediatePropagation();
				NovalnetUtility.getPanHash();
			}
		});
		document.getElementById("paymentForm_novalnetCreditCard_panHash").value = '';
		this.initiateIframe();		
	}	

	/**Initiate Iframe */
	initiateIframe() {
		var iframe = document.getElementById('novalnet_cc_iframe').contentWindow;
		if (document.getElementById("paymentForm_novalnetCreditCard_formClientKey").value === undefined ||
			document.getElementById("paymentForm_novalnetCreditCard_formClientKey").value == '') {
			return false;
		}
		NovalnetUtility.setClientKey(document.getElementById("paymentForm_novalnetCreditCard_formClientKey").value);
		var request_object = {
			callback: {
				on_success: function(data) {
					document.getElementById("paymentForm_novalnetCreditCard_panHash").value = data['hash'];
					document.getElementById("paymentForm_novalnetCreditCard_uniqueId").value = data['unique_id'];
					document.getElementById("paymentForm_novalnetCreditCard_doRedirect").value = data['do_redirect'];
					document.paymentForm.submit();
				},
				on_error: function on_error(data) {
					alert(data['error_message']);
					document.getElementById("nn_overlay").classList.remove("novalnet-challenge-window-overlay");
					document.getElementById("novalnet_cc_iframe").classList.remove("novalnet-challenge-window-overlay");
				},
				on_show_overlay: function on_show_overlay() {
					document.getElementById('novalnet_cc_iframe').classList.add("novalnet-challenge-window-overlay");
				},
				on_hide_overlay: function on_hide_overlay() {
					document.getElementById("novalnet_cc_iframe").classList.remove("novalnet-challenge-window-overlay");  
					document.getElementById("nn_overlay").classList.add("novalnet-challenge-window-overlay");
				},
				on_show_captcha: function on_show_captcha() { 
					window.scrollTo(0, 200);
				}
			},
			iframe: {
				id: 'novalnet_cc_iframe',
				inline: document.getElementById("paymentForm_novalnetCreditCard_formInline").value,
				style: {
					container: document.getElementById("paymentForm_novalnetCreditCard_formStyleContainer").value,
					input: document.getElementById("paymentForm_novalnetCreditCard_formStyleInput").value,
					label: document.getElementById("paymentForm_novalnetCreditCard_formStyleLabel").value,
				}
			},
			customer: {
				first_name: document.getElementById("paymentForm_novalnetCreditCard_firstName").value,
				last_name: document.getElementById("paymentForm_novalnetCreditCard_lastName").value,
				email: document.getElementById("paymentForm_novalnetCreditCard_email").value,
				billing: {
					street: document.getElementById("paymentForm_novalnetCreditCard_street").value + ',' + document.getElementById("paymentForm_novalnetCreditCard_houseNo").value,
					city: document.getElementById("paymentForm_novalnetCreditCard_city").value,
					zip: document.getElementById("paymentForm_novalnetCreditCard_zip").value,
					country_code: document.getElementById("paymentForm_novalnetCreditCard_countryCode").value,
				},
			},
			transaction: {
				amount: document.getElementById("paymentForm_novalnetCreditCard_amount").value,
				currency: document.getElementById("paymentForm_novalnetCreditCard_currency").value,
				test_mode: document.getElementById("paymentForm_novalnetCreditCard_testMode").value,
			},
			custom: {
				lang: document.getElementById("paymentForm_novalnetCreditCard_lang").value
			}
		};
		NovalnetUtility.createCreditCardForm(request_object);
	}
}
