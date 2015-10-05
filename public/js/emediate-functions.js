function EAS_uuid() {
    return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function(e) {
        var t = 16 * Math.random() | 0,
            n = "x" == e ? t : 3 & t | 8;
        return n.toString(16)
    })
}
function EAS_load(e) {
    document.write('<script type="text/javascript" src="' + e + '"></script>')
}
function EAS_load_script(e, t, n) {
    n = n || document;
    var i = n.getElementsByTagName("head")[0],
        r = n.createElement("script");
    r.type = "text/javascript", r.src = e, r.onreadystatechange = function() {
        "complete" == r.readyState && t()
    }, r.onload = t, i.appendChild(r)
}
function EAS_init(e, t) {
    var n = (new Date).getTime(),
        i = EAS_server + "/eas?target=_blank&EASformat=jsvars&EAScus=" + e + "&ord=" + n;
    EAS_detect_flash(), i += "&EASflash=" + EAS_flash, t && (i += "&" + t), - 1 == i.indexOf("pageviewid") && (i += "&pageviewid=" + EAS_pageviewid), i += eas.hlp.getCxProfileCookieData(), EAS_load(i)
}
function EAS_detect_flash() {
    if (!(EAS_flash > 1)) {
        var e = 11,
            t = -1 != navigator.userAgent.indexOf("Opera") ? !0 : !1,
            n = -1 != navigator.appVersion.indexOf("MSIE") ? !0 : !1,
            i = -1 != navigator.appVersion.indexOf("Windows") ? !0 : !1;
        if (n && i && !t) {
            document.write('<SCRIPT LANGUAGE="VBScript"> \n'), document.write("on error resume next \nDim eas_flobj(" + e + ") \n");
            for (var r = 2; e >= r; r++) document.write("Set eas_flobj(" + r + ') = CreateObject("ShockwaveFlash.ShockwaveFlash.' + r + '") \n'), document.write("if(IsObject(eas_flobj(" + r + "))) Then EAS_flash=" + r + " \n");
            document.write("</SCRIPT> \n")
        } else if (navigator.plugins && (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"])) {
            var a = navigator.plugins["Shockwave Flash 2.0"] ? " 2.0" : "",
                o = navigator.plugins["Shockwave Flash" + a].description,
                s = parseInt(o.substr(o.indexOf(".") - 2, 2), 10);
            s > 1 && (EAS_flash = s)
        }
    }
}
function EAS_embed_flash(e, t, n, i, r, a, o, s) {
    var l, d = "",
        c = "",
        u = [],
        h = "eas_" + (new Date).getTime() + Math.floor(11 * Math.random()),
        p = -1 != navigator.appVersion.indexOf("MSIE") && -1 == navigator.userAgent.indexOf("Opera");
    if (i) {
        var f, g, m;
        for (u = i.split(","), l = 0; l < u.length; l++) f = u[l].indexOf("="), g = u[l].substring(0, f), m = u[l].substring(f + 1, u[l].length), "flashvars" == g.toLowerCase() ? "undefined" == typeof r ? r = m : r += "&" + m : d += '<param name="' + g + '" value="' + m + '" />'
    }
    if (a && o) for (u = a.split(","), l = 0; l < u.length; l++) r += (r ? "&" : "") + u[l] + "=" + o + u[l];
    return r && (d += '<param name="FlashVars" value="' + r + '" />'), p ? (c = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' + e + '" height="' + t + '" id="' + h + '" name="' + h + '"><param name="movie" value="' + n + '" />', c += d, c += "</object>") : (c += '<object type="application/x-shockwave-flash" data="' + n + '" width="' + e + '" height="' + t + '" id="' + h + '" name="' + h + '">', c += d, c += "</object>"), s ? (container = document.createElement("div"), container.innerHTML = c, container.firstChild) : (document.write(c), h)
}
function EAS_show_flash(e, t, n, i) {
    EAS_embed_flash(e, t, n, i)
}
function EAS_statistics() {
    "undefined" != typeof EAS_cu && document.write('<img width="1" height="1" src="' + EAS_server + "/eas?cu=" + EAS_cu + ";ord=" + (new Date).getTime() + '">')
}
function EAS_load_fif(e) {
    "object" != typeof e && (e = {
        divId: arguments[0],
        fifSrc: arguments[1],
        easSrc: arguments[2],
        width: arguments[3],
        height: arguments[4],
        fixedSrc: arguments[5],
        adjustSize: arguments[6]
    });
    var t = document.createElement("iframe"),
        n = document.getElementById(e.divId);
    t.src = e.fifSrc, t.style.width = e.width + "px", t.style.height = e.height + "px", t.style.margin = 0, t.style.borderWidth = 0, t.style.padding = 0, t.scrolling = "no", t.frameBorder = 0, t.allowTransparency = "true";
    var i = e.fixedSrc ? e.easSrc : e.easSrc + ";fif=y";
    if (i += eas.hlp.getCxProfileCookieData(), t.EAS_src = i, e.adjustSize) {
        var r = 200,
            a = 15,
            o = 0,
            s = function l() {
                for (var e, i, s, d, c = t.contentDocument || t.contentWindow.document, u = c.getElementsByTagName("a"), h = null, p = c.body.clientWidth, f = c.body.clientHeight, g = u.length - 1; g >= 0; g--) s = u[g], h = s.getElementsByTagName("*"), d = h[0], 1 === h.length && "img" === d.tagName.toLowerCase() && (d.style.display = "block", s.style.display = "inline-block", e = d.clientWidth, i = d.clientHeight, e > p && (c.body.style.minWidth = e + "px"), i > f && (c.body.style.minHeight = i + "px"));
                p && f && (p != t.clientWidth || f != t.clientHeight) && (t.style.width = p + "px", t.style.height = f + "px", n.style.width = t.style.width, n.style.height = t.style.height), o++ < a && setTimeout(l, r)
            };
        t.onload = s
    }
    n.appendChild(t)
}
function EAS_create_iframe(e, t, n, i) {
    var r = document.createElement("iframe"),
        i = i || "javascript:false";
    return r.src = i, r.style.width = t + "px", r.style.height = n + "px", r.style.margin = "0px", r.style.borderWidth = "0px", r.style.padding = "0px", r.scrolling = "no", r.frameBorder = "0", r.allowTransparency = "true", e.appendChild(r), r
}
function EAS_resize_fif(e, t, n) {
    if ("undefined" != typeof inDapIF) {
        var i = window.frameElement,
            r = i.parentNode;
        e ? (i._width = i.style.width, i._height = i.style.height, i.style.width = t + "px", i.style.height = n + "px") : (i.style.width = i._width, i.style.height = i._height), r.style.width = i.style.width, r.style.height = i.style.height
    }
}
function EAS_ism(e, t, n, i, r, a, o, s, l, d, c) {
    this.elementId = e, this.width = t, this.height = n, this.minVisibleRatio = i, this.logUrl = r, this.interval = a, this.logInterval = 0, this.maxLogInterval = o, this.activeTimeout = s, this.maxDuration = l, this.isActive = !0, this.activeDuration = 0, this.loggedDuration = 0, this.totalDuration = 0, this.lastActive = 0, this.lastLogged = 0, this.logEnabled = !0, this.debugEnabled = this.getDebug(), this.impTime = d, this.date = c, this.updateLogInterval = function() {
        var e = 1,
            t = 1;
        return function() {
            var n = e + t;
            e = t, t = n, this.logInterval = Math.min(e * this.interval, this.maxLogInterval)
        }
    }();
    var u = this,
        h = window,
        p = document;
    "undefined" != typeof inDapIF && (h = window.top, p = parent.document), this.addEventHandler(h, "focus", function() {
        u.setActive()
    }), this.addEventHandler(h, "blur", function() {
        u.setInactive()
    }), this.addEventHandler(h, "scroll", function() {
        u.setActive()
    }), this.addEventHandler(h, "resize", function() {
        u.setActive()
    }), this.intervalInstance = setInterval(function() {
        u.update()
    }, u.interval), this.debugEnabled && (ismElem = document.getElementById(this.elementId), debugWidth = this.width - 2, debugWidth < 100 && (debugWidth = 100), this.debugDiv = document.createElement("div"), this.debugDiv.style.background = "#20AA4F", this.debugDiv.style.position = "absolute", this.debugDiv.style.top = "0px", this.debugDiv.style.left = "0px", this.debugDiv.style.width = debugWidth + "px", this.debugDiv.style.fontSize = "10px", this.debugDiv.style.fontFamily = "Verdana", this.debugDiv.style.color = "#000", this.debugDiv.style.border = "1px solid white", this.debugDiv.style.zIndex = "1000", ismElem.appendChild(this.debugDiv))
}
EAS_flash = 1, EAS_proto = "http:", "https:" == location.protocol && (EAS_proto = "https:"), EAS_server = EAS_proto + "//eas4.emediate.eu";
try {
    "undefined" != typeof parent.EAS_pageviewid ? EAS_pageviewid = parent.EAS_pageviewid : (EAS_pageviewid = EAS_uuid(), "undefined" != typeof window.frameElement.EAS_src && (parent.EAS_pageviewid = EAS_pageviewid)), - 1 == window.frameElement.EAS_src.indexOf("pageviewid") && (window.frameElement.EAS_src += ";pageviewid=" + EAS_pageviewid)
} catch (e) {
    "undefined" == typeof EAS_pageviewid && (EAS_pageviewid = EAS_uuid())
}! function(e) {
    if ("undefined" == typeof e.eas_debug_mode) try {
        var t = e.top.location.href.split("?")[1];
        if (t) {
            t = t.split("#")[0].split("&");
            for (var n in t) t[n] && "eas_debug_mode" == t[n].split("=")[0] && (e.eas_debug_mode = "true" == t[n].split("=")[1])
        }
    } catch (i) {}
}(window), EAS_ism.prototype.addEventHandler = function(e, t, n) {
    e.addEventListener ? e.addEventListener(t, n, !1) : e.attachEvent && e.attachEvent("on" + t, n)
}, EAS_ism.prototype.setActive = function() {
    this.isActive = !0, this.lastActive = this.activeDuration
}, EAS_ism.prototype.setInactive = function() {
    this.isActive = !1
}, EAS_ism.prototype.getPosition = function(e) {
    var t = document.getElementById(e);
    "undefined" != typeof inDapIF && (t = window.frameElement.parentNode);
    var n = t.getBoundingClientRect();
    return {
        top: n.top,
        right: n.left + this.width,
        bottom: n.top + this.height,
        left: n.left
    }
}, EAS_ism.prototype.getWindowSize = function() {
    var e = {
            width: 0,
            height: 0
        }, t = window,
        n = document;
    return "undefined" != typeof inDapIF && (t = window.top, n = parent.document), "number" == typeof t.top.innerWidth ? (e.width = t.top.innerWidth, e.height = t.top.innerHeight) : n.documentElement && (n.documentElement.clientWidth || n.documentElement.clientHeight) ? (e.width = n.documentElement.clientWidth, e.height = n.documentElement.clientHeight) : n.body && (n.body.clientWidth || n.body.clientHeight) && (e.width = n.body.clientWidth, e.height = n.body.clientHeight), e
}, EAS_ism.prototype.isHidden = function(e, t) {
    function n(e) {
        return (e.right - e.left) * (e.bottom - e.top)
    }
    var i = n(t);
    return t.left = Math.max(0, t.left), t.right = Math.min(t.right, e.width), t.top = Math.max(0, t.top), t.bottom = Math.min(t.bottom, e.height), n(t) / i < this.minVisibleRatio
}, EAS_ism.prototype.log = function(e) {
    if (!(0 >= e)) {
        var t = this.logUrl + "&time=" + e + "&impTime=" + this.impTime + "&date=" + this.date;
        0 == this.lastLogged && (t += "&first");
        var n = document.getElementById("EAS_ism"),
            i = document.createElement("script");
        i.setAttribute("type", "text/javascript"), i.setAttribute("id", "EAS_ism"), i.setAttribute("src", t), null == n ? document.getElementsByTagName("head")[0].appendChild(i) : document.getElementsByTagName("head")[0].replaceChild(i, n), this.logEnabled = !1, this.lastLogged = this.totalDuration, this.updateLogInterval()
    }
}, EAS_ism.prototype.parseResponse = function(e) {
    "stop" in e && !e.stop && (this.loggedDuration = this.activeDuration, this.logEnabled = !0)
}, EAS_ism.prototype.update = function() {
    var e = !1;
    if (this.isActive) if (this.activeDuration >= this.maxDuration || this.activeDuration - this.lastActive >= this.activeTimeout) this.setInactive();
    else {
        var t = document.getElementById(this.elementId);
        if (!t) return void this.clearInstance();
        var n = this.getPosition(this.elementId),
            i = this.getWindowSize();
        this.isHidden(i, n) || (this.activeDuration += this.interval, e = !0)
    }
    this.logEnabled && this.lastLogged < this.maxDuration && (this.totalDuration += this.interval, this.totalDuration - this.lastLogged >= this.logInterval && this.log(this.activeDuration - this.loggedDuration)), this.debugEnabled && this.debug(e)
}, EAS_ism.prototype.clearInstance = function() {
    var e = this.elementId + "_fun";
    clearInterval(this.intervalInstance), window[e] && delete window[e]
}, EAS_ism.prototype.getDebug = function() {
    if ("undefined" != typeof EAS_debug_ism) return EAS_debug_ism;
    var e = "",
        t = document;
    return "undefined" != typeof inDapIF && (t = parent.document), "undefined" != typeof t.cookie && (e = (e = t.cookie.match(new RegExp("(^|;|\\s)eas_debug_ism=([^;]+);?"))) ? e[2] : ""), "" == e ? !1 : !0
}, EAS_ism.prototype.debug = function(e) {
    this.debugEnabled && "undefined" != typeof this.debugDiv && (pos = this.getPosition(this.elementId), pos.top < 0 && pos.bottom > 0 ? this.debugDiv.style.top = -pos.top + "px" : this.debugDiv.style.top = "0px", this.debugDiv.innerHTML = " " + (this.isActive ? "Active" : "Idle") + (this.isActive ? " and " + (e ? "visible" : "hidden") : "") + "<br/> In-screen time: " + this.activeDuration / 1e3 + (this.logInterval ? ", Log interval: " + this.logInterval / 1e3 : ""))
}, window.eas && window.eas.hlp || (window.eas = window.eas || {}, window.eas.hlp = {
    version: "1.2.4",
    isIE: -1 != navigator.appVersion.indexOf("MSIE"),
    win: window.top,
    doc: function() {
        try {
            return window.top.document
        } catch (e) {
            return window.console && window.console.error && console.error("File EAS_tag.1.0.js is included inside regular iframe."), document
        }
    }(),
    handleError: function(e) {
        "undefined" != typeof eas_debug_mode && eas_debug_mode && (eas.hlp.isIE ? eas.hlp.error(e.name + ": " + e.description) : eas.hlp.error({
            name: e.name,
            stack: e.stack
        }))
    },
    handleWarn: function(e) {
        "undefined" != typeof eas_debug_mode && eas_debug_mode && (eas.hlp.isIE ? eas.hlp.log(e.name + ": " + e.description) : eas.hlp.log({
            name: e.name,
            stack: e.stack
        }))
    },
    log: function(e) {
        "undefined" != typeof eas_debug_mode && eas_debug_mode && (eas.hlp.isIE ? "undefined" != typeof console && console.dir ? console.dir(e) : "undefined" != typeof console && console.log && "undefined" != typeof JSON && console.log(JSON.stringify(e)) : console.log(e))
    },
    error: function(e) {
        "undefined" != typeof eas_debug_mode && eas_debug_mode && ("undefined" != typeof console && console.error ? console.error(e) : eas.hlp.log(e))
    },
    getScrollX: function() {
        return window.top.document.body.scrollLeft || window.top.document.documentElement.scrollLeft
    },
    getScrollY: function() {
        return window.top.document.body.scrollTop || window.top.document.documentElement.scrollTop
    },
    getScreenWidth: function() {
        return window.top.innerWidth || parent.document.documentElement.clientWidth || parent.document.documentElement.getElementsByTagName("body")[0].clientWidth
    },
    getScreenHeight: function() {
        return window.top.innerHeight || parent.document.documentElement.clientHeight || parent.document.documentElement.getElementsByTagName("body")[0].clientHeight
    },
    getDocumentHeight: function() {
        return parent.document.documentElement.offsetHeight
    },
    getDocumentWidth: function() {
        return parent.document.documentElement.offsetWidth
    },
    getFlash: function(e) {
        return eas.hlp.isIE ? (window.top || window)[e] || window[e] : (parent.document || document)[e] || document[e]
    },
    contains: function(e, t) {
        return e.contains ? e.contains(t) : !! (16 & e.compareDocumentPosition(t))
    },
    addEvent: function(e, t, n) {
        if (e && t && n) if (e.window || !e.length) if (t.indexOf(" ") > 0) for (var i = t.split(" "), r = i.length - 1; r >= 0; r--) eas.hlp.addEvent(e, i[r], n);
        else {
            if (("mouseenter" === t || "mouseleave" === t) && "function" == typeof n) {
                var a = "mouseenter" === t,
                    o = a ? "fromElement" : "toElement",
                    s = function(t) {
                        t = t || window.event;
                        var i = t.target || t.srcElement,
                            r = t.relatedTarget || t[o];
                        e !== i && !eas.hlp.contains(e, i) || eas.hlp.contains(e, r) || n.call(this, t)
                    };
                return t = a ? "mouseover" : "mouseout", eas.hlp.addEvent(e, t, s), s
            }
            e.addEventListener ? e.addEventListener(t, n, !1) : e != window.top && e.attachEvent ? e.attachEvent("on" + t, n) : e["on" + t] = n
        } else for (var r = e.length - 1; r >= 0; r--) eas.hlp.addEvent(e[r], t, n)
    },
    removeEvent: function(e, t, n) {
        if (e && t) if (e.window || !e.length) if (t.indexOf(" ") > 0) for (var i = t.split(" "), r = i.length - 1; r >= 0; r--) eas.hlp.removeEvent(e, i[r], n);
        else try {
                "mouseenter" === t ? t = "mouseover" : "mouseleave" === t && (t = "mouseout"), e.addEventListener && n ? e.removeEventListener(t, n, !1) : e != window.top && e.attachEvent && n ? e.detachEvent("on" + t, n) : e["on" + t] = null
            } catch (a) {} else for (var r = e.length - 1; r >= 0; r--) eas.hlp.removeEvent(e[r], t, n)
    },
    triggerEvent: function(e, t, n) {
        var i;
        try {
            document.createEvent ? (i = document.createEvent("Event"), i.initEvent(t, !0, !0)) : (i = document.createEventObject(), i.eventType = t), i.eventName = t, i.customParams = n, document.createEvent ? e.dispatchEvent(i) : e.fireEvent("on" + i.eventType, i)
        } catch (r) {
            eas.hlp.handleError(r)
        }
    },
    preventDefault: function(e, t) {
        try {
            t = t || window, e = e || t.event, e.preventDefault ? e.preventDefault() : e.returnValue = !1
        } catch (n) {}
    },
    addFlashListener: function(e, t) {
        try {
            t = t || window, eas.hlp.win.eas_flashListeners || (eas.hlp.win.eas_flashListeners = []);
            var n = {
                func: e,
                context: t
            };
            eas.hlp.win.eas_flashListeners.push(n), t.eas_recieveFromFlash || (t.eas_recieveFromFlash = eas.hlp.recieveFromFlash, t === eas.hlp.win || eas.hlp.win.eas_recieveFromFlash || (eas.hlp.win.eas_recieveFromFlash = eas.hlp.recieveFromFlash))
        } catch (i) {
            eas.hlp.handleError(i)
        }
    },
    removeFlashListener: function(e) {
        try {
            if (!eas.hlp.win.eas_flashListeners) return !1;
            var t = eas.hlp.win.eas_flashListeners;
            for (var n in t) t[n] && t[n].func == e && delete t[n]
        } catch (i) {
            eas.hlp.handleError(i)
        }
    },
    recieveFromFlash: function(e, t, n) {
        try {
            eas.hlp.log({
                msg: "Recieved from flash",
                name: e,
                command: t,
                cu_id: n
            });
            var i = eas.hlp.win.eas_flashListeners;
            if (i && i.length) for (var r in i) i[r].func.call(i[r].context, e, t, n);
            else eas.hlp.log("No flash listeners registered")
        } catch (a) {
            eas.hlp.handleError(a)
        }
    },
    getPos: function(e, t) {
        var n, i, r = window;
        try {
            if (i = e.getBoundingClientRect(), n = {
                    left: i.left + eas.hlp.getScrollX(),
                    right: i.right + eas.hlp.getScrollX(),
                    top: i.top + eas.hlp.getScrollY(),
                    bottom: i.bottom + eas.hlp.getScrollY()
                }, t) for (; r != window.top;) e = r.frameElement, r = parent.window, i = e.getBoundingClientRect(), n.left += i.left, n.right += i.left, n.top += i.top, n.bottom += i.top
        } catch (a) {
            eas.hlp.handleError(a)
        }
        return n
    },
    createDelegate: function(e, t) {
        var n = Array.prototype.slice.call(arguments, 2);
        return function() {
            return t.apply(e, n.length > 0 ? Array.prototype.slice.call(arguments, 0).concat(n) : arguments)
        }
    },
    setCookie: function(e, t, n, i, r, a) {
        document.cookie = e + "=" + escape(t) + (n ? ";expires=" + new Date((new Date).getTime() + 1e3 * n * 60 * 60 * 24).toUTCString() : "") + (i ? ";path=" + i : "") + (r ? ";domain=" + r : "") + (a ? ";secure" : "")
    },
    getCookie: function(e) {
        for (var t = document.cookie.split(";"), n = "", i = "", r = "", a = !1, o = 0; o < t.length; o++) {
            if (n = t[o].split("="), i = n[0].replace(/^\s+|\s+$/g, ""), i == e) return a = !0, n.length > 1 && (r = unescape(n[1].replace(/^\s+|\s+$/g, ""))), r;
            n = null, i = ""
        }
        return a ? void 0 : null
    },
    getScrollbarWidth: function(e) {
        e = e || document;
        var t = e.createElement("div");
        t.style.visibility = "hidden", t.style.width = "100px", e.body.appendChild(t);
        var n = t.offsetWidth;
        t.style.overflow = "scroll";
        var i = e.createElement("div");
        i.style.width = "100%", t.appendChild(i);
        var r = i.offsetWidth;
        return t.parentNode.removeChild(t), n - r
    },
    lockScroll: function(e) {
        e = e || window;
        var t = e.document,
            n = t.documentElement,
            i = t.body,
            r = [e.pageXOffset || n.scrollLeft || i.scrollLeft, e.pageYOffset || n.scrollTop || i.scrollTop];
        n.setAttribute("data-scroll-position", r), n.setAttribute("data-previous-padding-right", n.style.paddingRight), n.setAttribute("data-previous-overflow", n.style.overflow), n.setAttribute("data-previous-height", n.style.height), i.setAttribute("data-previous-overflow", i.style.overflow), i.setAttribute("data-previous-height", i.style.height), n.style.height = i.style.height = "100%", n.style.overflow = i.style.overflow = "hidden", n.style.paddingRight = eas.hlp.getScrollbarWidth(t) + "px", e.scrollTo(r[0], r[1])
    },
    unlockScroll: function(e) {
        e = e || window;
        var t = e.document,
            n = t.documentElement,
            i = t.body,
            r = n.getAttribute("data-scroll-position").split(",");
        n.style.overflow = n.getAttribute("data-previous-overflow"), n.style.height = n.getAttribute("data-previous-height"), n.style.paddingRight = n.getAttribute("data-previous-padding-right"), i.style.overflow = i.getAttribute("data-previous-overflow"), i.style.height = i.getAttribute("data-previous-height"), n.removeAttribute("data-scroll-position"), n.removeAttribute("data-previous-overflow"), n.removeAttribute("data-previous-height"), n.removeAttribute("data-previous-padding-right"), i.removeAttribute("data-previous-overflow"), i.removeAttribute("data-previous-height"), e.scrollTo(r[0], r[1])
    },
    textNodesUnder: function(e) {
        e = e || document.documentElement;
        var t = [];
        if (document.createTreeWalker) for (var n, i = document.createTreeWalker(e, NodeFilter.SHOW_TEXT, null, !1); n = i.nextNode();) t.push(n);
        else for (e = e.firstChild; e; e = e.nextSibling) 3 == e.nodeType ? t.push(e) : t = t.concat(eas.hlp.textNodesUnder(e));
        return t
    },
    loadStyle: function(e, t) {
        t = t || document;
        var n = document.createElement("link");
        n.setAttribute("rel", "stylesheet"), n.setAttribute("type", "text/css"), n.setAttribute("href", e), t.getElementsByTagName("head")[0].appendChild(n)
    },
    addStyle: function(e, t, n) {
        if (e && t) {
            n = n || document;
            var i = n.createElement("style"),
                r = e + "{" + t + "}";
            if (i.setAttribute("type", "text/css"), i.styleSheet) i.styleSheet.cssText = r;
            else {
                var a = n.createTextNode(r);
                i.appendChild(a)
            }
            n.getElementsByTagName("head")[0].appendChild(i)
        }
    },
    addLinks: function(e, t, n, i, r) {
        if (e) try {
            String.prototype.trim || (String.prototype.trim = function() {
                return this.replace(/^\s+|\s+$/g, "")
            }), Array.prototype.indexOf || (Array.prototype.indexOf = function(e, t) {
                var n;
                if (null == this) throw new TypeError('"this" is null or not defined');
                var i = Object(this),
                    r = i.length >>> 0;
                if (0 === r) return -1;
                var a = +t || 0;
                if (Math.abs(a) === 1 / 0 && (a = 0), a >= r) return -1;
                for (n = Math.max(a >= 0 ? a : r - Math.abs(a), 0); r > n;) {
                    if (n in i && i[n] === e) return n;
                    n++
                }
                return -1
            });
            for (var a = e.length - 1; a >= 0; a--) e[a] = e[a].trim();
            r = r || eas.hlp.doc.body;
            for (var o = eas.hlp.textNodesUnder(r), s = [], a = o.length - 1; a >= 0; a--) for (var l = e.length - 1; l >= 0; l--) if (o[a].nodeValue.indexOf(e[l]) >= 0) {
                for (var d = !0, c = o[a]; c; c = c.parentNode) if (t.indexOf(c.tagName && c.tagName.toLowerCase()) >= 0) {
                    d = !1;
                    break
                }
                if (d) {
                    for (var u = !0, h = s.length - 1; h >= 0; h--) if (s[h] == o[a]) {
                        u = !1;
                        break
                    }
                    u && s.push(o[a])
                }
            }
            for (var p = [], a = s.length - 1; a >= 0; a--) {
                for (var f = [], l = e.length - 1; l >= 0; l--) {
                    var g = new RegExp("\\b" + e[l] + "\\b", "ig");
                    s[a].nodeValue.replace(g, function(e, t) {
                        f.push({
                            offset: t,
                            length: e.length
                        })
                    })
                }
                f.sort(function(e, t) {
                    return e.offset - t.offset
                });
                for (var m = s[a], v = 0, l = 0; l < f.length; l++) {
                    var u = m.splitText(f[l].offset - v),
                        y = u.splitText(f[l].length),
                        w = document.createElement("a");
                    w.target = "_blank", w.href = n, w.className = i, m.parentNode.insertBefore(w, u), w.appendChild(u.parentNode.removeChild(u)), m.parentNode.normalize(), m = y, v += f[l].offset - v + f[l].length, p.push(w)
                }
            }
            return p
        } catch (b) {
            eas.hlp.handleError(b)
        }
    },
    getCxProfileCookieData: function() {
        var e, t = "",
            n = eas.hlp.getCookie("cx_profile_data");
        if (n && "undefined" != n) {
            try {
                e = JSON.parse(n)
            } catch (i) {
                eas.hlp.error("EAS_tag: cannot parse cx_profile_data"), eas.hlp.log(n)
            }
            for (var r in e) t += "&EAST" + r + "=" + e[r].join("|")
        }
        try {
            window.cX && cX.library && (t += "&prnd=" + encodeURIComponent(cX.library.m_rnd), t += "&sid=" + encodeURIComponent(cX.library.m_siteId), t += "&usi=" + encodeURIComponent(cX.getUserId()), cX.Array.forEach(cX.library.m_externalUserIds.slice(0, 5), function(e, n) {
                t += "&eid" + n + "=" + encodeURIComponent(e.id), t += "&eit" + n + "=" + encodeURIComponent(e.type)
            }))
        } catch (i) {}
        return t
    },
    trackEvent: function(e, t, n, i) {
        try {
            var r = EAS_server + "/eas?cu=" + e + "&camp=" + t + "&no=" + n + "&ord=" + (new Date).getTime() + "&EASevent=" + i,
                a = new Image;
            a.src = r
        } catch (o) {
            eas.hlp.handleError(o)
        }
    },
    createSwipeSymbol: function(e) {
        var t = e.parentWidth || 200,
            n = e.parentHeight || 100,
            i = document.createElement("div"),
            r = "swipe",
            a = document.createElement("div"),
            o = document.createElement("div"),
            s = document.createElement("div"),
            l = document.createElement("div"),
            d = document.createElement("style");
        document.head.appendChild(d);
        var c, u = d.sheet,
            h = document.body.textContent ? "textContent" : "innerText";
        i.style.position = "relative", i.style.maxWidth = "170px", i.style.minWidth = "130px", i.style.width = t / 1.4 + "px", i.style.height = "36px", i.style.margin = "0 auto 40px", i.style.overflow = "visible", i.style.paddingTop = "22px", i.style.zIndex = 1e3, i.style.color = "#fefefe", i.style.fontWeight = "bold", i.style.textTransform = "uppercase", i.style.fontFamily = "Arial, sans-serif", i.style.border = "2px solid #fefefe", i.style.borderRadius = s.style.borderRadius = n / 2 + "px/" + n / 2 + "px", s.style.width = "100%", s.style.height = "100%", s.style.position = "absolute", s.style.background = "#000000", s.style.opacity = "0.3", s.style.textAlign = l.style.textAlign = "center", s.style.top = 0, l[h] = r, l.style.zIndex = 100, l.style.position = "relative", a.className = "eas_swipe_left_arrow", o.className = "eas_swipe_right_arrow", c = [".eas_swipe_left_arrow, .eas_swipe_right_arrow { position: absolute; top: 50%; background-color: #fefefe; text-align: left; width: 1em; height: 1em; border-top-right-radius: 30%; z-index: 100; } ", ".eas_swipe_left_arrow:before, .eas_swipe_left_arrow:after, .eas_swipe_right_arrow:before, .eas_swipe_right_arrow:after { content: ''; position: absolute; background-color: inherit; width: 1em; height: 1em; border-top-right-radius: 30%; } ", ".eas_swipe_left_arrow { right: 74%; margin-top: -0.7em;-webkit-transform: rotate(-30deg) skewX(-30deg) scale(1,.866); transform: rotate(-30deg) skewX(-30deg) scale(1,.866); } ", ".eas_swipe_right_arrow { left: 80%; margin-top: -0.4em;-webkit-transform: rotate(30deg) skewX(-30deg) scale(1,.866); transform: rotate(30deg) skewX(-30deg) scale(1,.866); } ", ".eas_swipe_left_arrow:before, .eas_swipe_right_arrow:before { -webkit-transform: rotate(-135deg) skewX(-45deg) scale(1.414,.707) translate(0,-50%); transform: rotate(-135deg) skewX(-45deg) scale(1.414,.707) translate(0,-50%); } ", ".eas_swipe_left_arrow:after, .eas_swipe_right_arrow:after { -webkit-transform: rotate(135deg) skewY(-45deg) scale(.707,1.414) translate(50%); transform: rotate(135deg) skewY(-45deg) scale(.707,1.414) translate(50%); }"];
        for (var p = 0, f = c.length; f > p; p++) u.insertRule(c[p], 0);
        return i.appendChild(a), i.appendChild(o), i.appendChild(s), i.appendChild(l), i
    }
})