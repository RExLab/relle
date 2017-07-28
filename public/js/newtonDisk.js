/*
 | jQuery Newton Color Disc Plugin
 | Copyright Subin Siby 2014
 | http://subinsb.com/newton-color-disc
 */
;
Raphael.fn.pieChart = function (t, r, l, e) {
    var u = this, i = Math.PI / 180, s = this.set();
    function h(t, o, e, r, n, h) {
        var l = t + e * Math.cos(-r * i), c = t + e * Math.cos(-n * i), a = o + e * Math.sin(-r * i), s = o + e * Math.sin(-n * i);
        return u.path(["M", t, o, "L", l, a, "A", e, e, 0, +(n - r > 180), 0, c, s, "z"]).attr(h)
    };
    var o = 0, c = 0, a = 0;
    for (var n = 0, f = e.length; n < f; n++) {
        c += e[n].size;
    };
    $.each(e, function (i, e) {
        var p = e.color, f = e.size, n = 360 * f / c, m = o + (n / 2), v = 500, y = 30, d = Raphael.hsb(a, 1, 1), u = h(t, r, l, o, o + n, {fill: p, stroke: "none", "stroke-width": 0});
        o += n;
        s.push(u);
        a += .1
    });
    return s
};

jQuery.fn.colorDisc = function (t) {
    var i = {init: function (t) {
            if (typeof t == "undefined") {
                t = ["red", "green", "blue"]
            } ;
            sectorColors = [];
            sectorSize = parseInt(360 / t.length, 10);
            $.each(t, function (t, i) {
                sectorColors.push({size: sectorSize, color: i})
            });
            this.find("#colorDisc").remove();
            this.append("<div id='colorDisc'></div>");
            var l = $("#holder").width()*0.75;
            paper = Raphael(this.find("#colorDisc")[0], l , l).pieChart(l/2, l/2, l/2, sectorColors)
        }, remove: function () {
            this.find("#colorDisc").remove()
        }, speed: function (t) {
            var e = this.find("#colorDisc"), o = e.css("-webkit-animation-duration"), i = parseFloat(o) - 0.05, i = String(i).replace("-", "");
            if (t != null) {
                i = t
            };
            e.removeClass("active");
            e.attr("style", "-webkit-animation-duration:" + i + "s;-moz-animation-duration: " + i + "s;");
            setTimeout(function () {
                e.addClass("active")
            }, 10)
        }};
    if (typeof t == "object" || !t) {
        return i.init.apply(this, arguments)
    } else if (typeof t == "string" && i[t]) {
        return i[t].apply(this, Array.prototype.slice.call(arguments, 1))
    }
};