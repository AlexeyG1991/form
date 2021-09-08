const validateAndClose = (input, min, max, func) => {
	if (!func(input, min, max)) {
		input.classList.remove("danger");
		if (input.previousElementSibling)
			input.previousElementSibling.style.display = "none";
	}

	if ($(input).parent().prev().hasClass("error-text")) {
		$(input).parent().prev()[0].style.display = "none";
	}
};

mainForm.firstname.addEventListener("input", () => {
	validateAndClose(mainForm.firstname, 2, 40, validateRequired);
});
mainForm.lastname.addEventListener("input", () => {
	validateAndClose(mainForm.lastname, 2, 40, validateRequired);
});
mainForm.userphone.addEventListener("input", () => {
	validateAndClose(mainForm.userphone, 2, 40, validatePhone);
});
mainForm.useremail.addEventListener("input", () => {
	validateAndClose(mainForm.useremail, 2, 40, validateEmail);
});

mainForm.area.addEventListener("change", () => {
	validateAndClose(mainForm.area, 2, 40, validateRequired);
});
mainForm.city.addEventListener("input", () => {
	validateAndClose(mainForm.city, 2, 40, validateRequired);
});
mainForm.index.addEventListener("input", () => {
	validateAndClose(mainForm.index, 2, 40, validateRequired);
});
mainForm.department.addEventListener("input", () => {
	validateAndClose(mainForm.department, 2, 40, validateRequired);
});
mainForm.instrument.addEventListener("change", () => {
	validateAndClose(mainForm.instrument, 2, 40, validateRequired);
});
mainForm.brand.addEventListener("change", () => {
	validateAndClose(mainForm.brand, 2, 40, validateRequired);

	mainForm.modelname.nextSibling.innerText = "Оберіть варіанти";
	mainForm.modelname.nextSibling.classList.remove("dirty");
	mainForm.modelname.value = "";
});
mainForm.modelname.addEventListener("change", () => {
	validateAndClose(mainForm.modelname, 2, 40, validateRequired);
	mainForm.nc12.previousElementSibling.style.display = "none";
});
mainForm.nc12.addEventListener("input", () => {
	validateAndClose(mainForm.nc12, 2, 40, validateRequired);
});
mainForm.serialnumber.addEventListener("input", () => {
	validateAndClose(mainForm.serialnumber, 12, 12, validateRequired);
});
mainForm.purchasedate.addEventListener("input", () => {
	validateAndClose(mainForm.purchasedate, 2, 40, validateDate);
});
mainForm.fiscalCheck.addEventListener("input", () => {
	validateAndClose(mainForm.fiscalCheck, 2, 40, validateRequired);
});
mainForm.shopname.addEventListener("change", () => {
	validateAndClose(mainForm.shopname, 2, 40, validateRequired);
});
mainForm.photodownload.addEventListener("input", () => {
	validateAndClose(mainForm.photodownload, 2, 256, validateRequired);
});
if (mainForm.cost) {
	mainForm.cost.addEventListener("input", () => {
		validateAndClose(mainForm.cost, 2, 100, validateRequired);
	});
}
if (mainForm.photodownload2) {
	mainForm.photodownload2.addEventListener("input", () => {
		validateAndClose(mainForm.photodownload2, 2, 100, validateRequired);
	});
}
