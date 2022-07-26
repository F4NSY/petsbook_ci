function calculateTime(data) {
	oldDate = new Date(data).getTime();
	newDate = new Date().getTime();
	differ = newDate - oldDate;
	days = Math.floor(differ / (1000 * 60 * 60 * 24));
	hours = Math.floor((differ % (1000 * 60 * 60 * 24)) / (60 * 60 * 1000));
	min = Math.floor((differ % (1000 * 60 * 60)) / (60 * 1000));
	sec = Math.floor((differ % (1000 * 60)) / 1000);
	var obj = {
		hours: hours,
		min: min,
		sec: sec,
	};
	return obj;
}
