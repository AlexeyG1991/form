const validateRequired = (input, min = 0, max = 256) => {
	if (!input.value) return input;
	const len = input.value.length;
	if (len < min || len > max) return input;
	return false;
};
const validateEmail = (input) => {
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
const validateDate = (input) => {
	if (!input.value) return input;
	const diff = getDifferenceInDays(new Date(input.value), new Date());

	return diff < 14 ? input : false;
};
function getDifferenceInDays(date1, date2) {
	const diffInMs = date2 - date1;
	return diffInMs / (1000 * 60 * 60 * 24);
}
const fillOptions = (options, target) => {
	options.forEach((e) => {
		const option = document.createElement("option");
		option.value = e;
		option.innerText = e;
		target.appendChild(option);
	});
};