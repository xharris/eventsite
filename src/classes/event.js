var xhhEvent = function(info={}) {
    this.title = info.title || "";
    this.description = info.description || "";
    this.visibility = info.visibility || "public";
    this.score = info.score || 0;
    this.time_start = info.time_start || Date.now();
    this.time_end = info.time_end || Date.now();
    this.marker = info.marker;

    this.getStartStr = function() {
        var start_date = new Date(this.time_start);

        // 24 hr to 12 hr
        var hours = start_date.getHours();
        var minutes = start_date.getMinutes();
        var time_str = hours + ':' + minutes + ' AM';
        if (hours > 12) {
            time_str = (hours - 12) + ':' + minutes + ' PM';
        }

        return start_date.getMonth() + "/"
        + start_date.getDate()
        + "/" + start_date.getFullYear()
        + " @ " + time_str
    }
}
