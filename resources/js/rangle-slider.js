(function ($) {
	"use strict";

	var rangeSalary = function () {
		if ($("#salary-val").length > 0) {
			var skipSlider = document.getElementById("salary-val");
			var skipValues = [
				document.getElementById("salary-val-lower"),
				document.getElementById("salary-val-upper"),
			];

			const chart = document.getElementById("salary-chart");
			const totalBars = 23;
			const minValue = 0;
			const maxValue = 116;
			const stepValue = (maxValue - minValue) / totalBars;

			chart.innerHTML = "";

			for (let i = 0; i < totalBars; i++) {
				const bar = document.createElement("span");

				const minHeight = 6;
				const maxHeight = 56;
				const mid = (totalBars - 1) / 2;
				const dist = Math.abs(i - mid);
				const ratio = 1 - dist / mid;
				const base = Math.pow(ratio, 1.6);

				const jitterMax = 24;
				const jitter = (Math.random() * 2 - 1) * jitterMax * (0.35 + 0.65 * base);
				const wave = Math.sin(i * 0.9) * 4 * base;

				let height = minHeight + base * (maxHeight - minHeight) + jitter + wave;
				height = Math.max(minHeight, Math.min(maxHeight, height));

				bar.style.height = `${Math.round(height)}%`;
				chart.appendChild(bar);
			}

			const bars = chart.querySelectorAll("span");

			if (skipSlider.noUiSlider) {
				skipSlider.noUiSlider.destroy();
			}

			noUiSlider.create(skipSlider, {
				start: [10, 100],
				connect: true,
				tooltips: false,
				step: 1,
				range: {
					min: 0,
					max: 110,
				},
			});

			skipSlider.noUiSlider.on("update", function (values) {
				const lower = Math.round(values[0]);
				const upper = Math.round(values[1]);

				if (skipValues[0]) skipValues[0].textContent = `$${lower}K`;
				if (skipValues[1]) skipValues[1].textContent = `$${upper}K`;

				bars.forEach((bar, i) => {
					const value = i * stepValue;
					if (value >= lower && value <= upper) {
						bar.classList.add("active");
					} else {
						bar.classList.remove("active");
					}
				});
			});
		}
	};

	$(function () {
		rangeSalary();
	});
})(jQuery);
