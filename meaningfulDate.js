const meaningfulDate = function (dateString) {
    for (; ;) {
        dateString = dateString.split('-');
        var year = Number(dateString[0]),
            month = Number(dateString[1]),
            day = Number(dateString[2]);
        if (month > 12) {
            month -= 12;
            year += 1;
            dateString = year.toString() + '-' + month.toString() + '-' + day.toString();
        } else if ((month == 9 || month == 4 || month == 6 || month == 11) && day > 30) {
            day -= 30;
            month += 1;
            dateString = year.toString() + '-' + month.toString() + '-' + day.toString();
        } else if ((month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 9 || month == 10 || month == 12) && day > 31) {
            day -= 31;
            month += 1;
            dateString = year.toString() + '-' + month.toString() + '-' + day.toString();
        } else if ((month == 2) && leapYear(year) && day > 29) {
            day -= 29;
            month += 1;
            dateString = year.toString() + '-' + month.toString() + '-' + day.toString();
        } else if ((month == 2) && !leapYear(year) && day > 28) {
            day -= 28;
            month += 1;
            dateString = year.toString() + '-' + month.toString() + '-' + day.toString();
        } else {
            return year.toString() + '-' + month.toString().padStart(2, '0') + '-' + day.toString().padStart(2, '0');
        }
    }
}
const leapYear = function (year) {
    return (year % 100 === 0) ? (year % 400 === 0) : (year % 4 === 0);
}

console.log(meaningfulDate('2021-08-70'));