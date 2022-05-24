maxSize = 25
logLevel = "ALL";
function getLogLevelNum(level) {
    if(level == "TESTING")  return 0;
    if(level == "GENERIC")  return 1;
    if(level == "ERROR")    return 2;
    if(level == "DEBUG")    return 3;
    if(level == "VERBOSE")    return 4;
    if(level == "ALL")      return 6;
    log("Unsure what log level " + level + " belongs to.", "GENERIC");
    return 4;

}
function log(message, type = "DEBUG") {
    if(getLogLevelNum(type) > getLogLevelNum(logLevel)) {
        return;
    }

    time = getDateTime();

    StartMessage = (`[${time}] - [` + type + `] `);

    left = maxSize - StartMessage.length;
    function balence() {
        tmp = "";
        space = " ";
        while(left >= 0) {
            left = left-1;
            tmp = tmp + space;
        }
        return tmp;
    }
    console.log(StartMessage + balence(StartMessage) +  "-> " + message);
}
function char_count(str, letter)  {
    var letter_Count = 0;
    for (var position = 0; position < str.length; position++) {
        if (str.charAt(position) == letter) {
            letter_Count += 1;
        }
    }
    return letter_Count;
}
function getDateTime() {

    var date = new Date();

    var hour = date.getHours();
    hour = (hour < 10 ? "0" : "") + hour;

    var min  = date.getMinutes();
    min = (min < 10 ? "0" : "") + min;

    var sec  = date.getSeconds();
    sec = (sec < 10 ? "0" : "") + sec;

    var year = date.getFullYear();

    var month = date.getMonth() + 1;
    month = (month < 10 ? "0" : "") + month;

    var day  = date.getDate();
    day = (day < 10 ? "0" : "") + day;

    var output = year + ":" + month + ":" + day + " - " + hour + ":" + min + ":" + sec;
    return output;
}
log("Loaded. logging_html.js")