let elementTime = document.getElementById("elementTime");

let arrMonths = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
];

let arrDays = [
    "Ahad/Minggu",
    "Senin",
    "Selasa",
    "Rabu",
    "Kamis",
    "Jum'at",
    "Sabtu",
];

function today() {
    dateObj = useServerTime
        ? new Date(new Date().getTime() - differenceTime)
        : new Date();
    millisecond = dateObj.getMilliseconds();
    second = dateObj.getSeconds();
    minute = dateObj.getMinutes();
    hour = dateObj.getHours();
    day = dateObj.getDay();
    date = dateObj.getDate();
    month = dateObj.getMonth();
    year = dateObj.getFullYear();

    if (hour < 10) {
        hour = "0" + hour;
    }
    if (minute < 10) {
        minute = "0" + minute;
    }
    if (second < 10) {
        second = "0" + second;
    }

    elementTime.textContent = `${arrDays[day]}, ${date} ${arrMonths[month]} ${year} - ${hour}:${minute}:${second}`;
}

setInterval(today, 1000);
