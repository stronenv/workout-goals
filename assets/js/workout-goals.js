//Set up charts
const avgPulseCtx = document.getElementById('avgPulseChart');
const maxPulseCtx = document.getElementById('maxPulseChart');
const weightCtx = document.getElementById('weightChart');

new Chart(avgPulseCtx, {
	type: 'line',
	data: avgPulseChartData,
});

new Chart(maxPulseCtx, {
	type: 'line',
	data: maxPulseChartData,
});

new Chart(weightCtx, {
	type: 'line',
	data: weightChartData,
});

//Set comment default text
if(document.body.classList.contains('single-workout_goals')) {
	const weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
	const d = new Date();
	let day = weekday[d.getDay()];
	document.getElementById('comment').value = day + " workout";
}
