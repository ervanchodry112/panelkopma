/** @format */

const prevBtns = document.querySelectorAll(".btn-prev");
const nextBtns = document.querySelectorAll(".btn-next");
const progress = document.getElementById("progress");
const formSteps = document.querySelectorAll(".form-step");
const progressSteps = document.querySelectorAll(".progress-step");

let formStepsNum = 0;

nextBtns.forEach((btn) => {
	btn.addEventListener("click", () => {
		formStepsNum++;
		updateFormSteps();
		updateProgressBar();
	});
});

prevBtns.forEach((btn) => {
	btn.addEventListener("click", () => {
		formStepsNum--;
		updateFormSteps();
		updateProgressBar();
	});
});

function updateFormSteps() {
	formSteps.forEach((formStep) => {
		formStep.classList.contains("form-step-active") &&
			formStep.classList.remove("form-step-active");
	});

	formSteps[formStepsNum].classList.add("form-step-active");
}

function updateProgressBar() {
	progressSteps.forEach((step, idx) => {
		if (idx < formStepsNum + 1) {
			step.classList.add("progress-step-active");
		} else {
			step.classList.remove("progress-step-active");
		}
	});

	const progressActive = document.querySelectorAll(".progress-step-active");

	progress.style.width =
		((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
}

// Ajax Jurusan

const fak = document.getElementById("fakultas");
const jur = document.getElementById("jurusan");

fak.addEventListener("change", function () {
	let ajax = new XMLHttpRequest();
	console.log(fak.value);

	ajax.onreadystatechange = function () {
		if (ajax.readyState == 4 && ajax.status == 200) {
			jur.innerHTML = ajax.response;
		}
	};

	ajax.open("POST", "include/ajax/get_jurusan.php?id=" + fak.value, true);
	ajax.send();
});

const otherJurusan = document.getElementById("jurusan-lain");

jur.addEventListener("click", function () {
	if (jur.value == "lainnya") {
		otherJurusan.innerHTML =
			'<label for="jurusan-other">Jurusan Lainnya</label><div class="form-floating-sm text-muted"><input class="form-control" type="text" name="jurusan-lainnya" id="jurusan-other" placeholder="Lainnya"></div>';

		console.log("lainnya");
	} else {
		otherJurusan.innerHTML = " ";
	}
});

const npm = document.getElementById("npm");

npm.addEventListener("change", function () {
	let ajax = new XMLHttpRequest();

	ajax.onreadystatechange = function () {
		if (ajax.readyState == 4 && ajax.status == 200) {
			npm.innerHTML = ajax.response;
		}
	};

	ajax.open("POST", "include/ajax/get_npm.php?npm=" + npm.value, true);
	ajax.send();
});

function invalid() {
	npm.classList.add("invalid-feedback");
}

function valid() {
	npm.classList.add("valid-feedback");
	npm.classList.remove("invalid-feedback");
}
