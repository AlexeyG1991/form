const mainForm = document.forms["register_form"];

const validateRequired = (input, min = 0, max = 256) => {
	console.log(input.value);
	const len = input.value.length;
	if (len < min || len > max) return input;
	return false;
};
const validateEmail = (input) => {
	console.log("here");
	const re =
		/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

	if (!re.test(String(input.value).toLowerCase())) return input;
	return false;
};
const validatePhone = (input) => {
	const value = input.value;
	if (value.length !== 10 || !value.match("^[0-9]{10}")) return input;
	return false;
};
const validateRepeat = (input, value) => {
	if (input.value !== value) return input;
	return false;
};

const validate = (form) => {
	const invalid = [];
	if (validateRequired(form.firstname, 2, 40)) invalid.push(form.firstname);
	if (validateRequired(form.lastname, 2, 40)) invalid.push(form.lastname);
	if (validatePhone(form.userphone)) invalid.push(form.userphone);
	if (validateRepeat(form.userphonerepeat, form.userphonerepeat.value))
		invalid.push(form.userphonerepeat);
	if (validateEmail(form.useremail)) invalid.push(form.useremail);
	if (validateRepeat(form.emailrepeat, form.useremail.value))
		invalid.push(form.emailrepeat);
	if (validateRequired(form.area)) invalid.push(form.area);
	if (validateRequired(form.city, 2, 40)) invalid.push(form.city);

	return invalid.length === 0 ? true : invalid;
};
