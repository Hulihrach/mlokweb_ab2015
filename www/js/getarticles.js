function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
function nextFive() {
    if ((window.last_used == "prev") && (window.actual_id < 5)) {
        window.actual_id += 5;
    } else if (window.last_used == "prev") {
        window.actual_id += 10;
    }
    $.ajax({
        url: "/getdata.php",
        data: "type=next&data="+window.actual_id,
        cache: false,
        success: function(html) {
            if (html == " ") {
                alert("Error");
            } else {
                $( "#klik" ).html(html);
                $( "#klik" ).before(window.actual_id+"&emsp;");
                window.last_used = "next";
                window.actual_id += 5;
                if(window.actual_id > window.num_articles) {
                    window.actual_id = window.num_articles;
                }
            }
        },
        error: function () {
        }
    });
};
function prevFive() {
    if ((window.last_used == "next") && (window.actual_id <= window.num_articles)) {
        window.actual_id -= 5;
    } else if (window.last_used == "next") { 
        window.actual_id -= 10;
    } else if (window.last_used == undefined) {
        window.actual_id -= 5;
    }
    $.ajax({
        url: "/getdata.php",
        data: "type=prev&data="+window.actual_id,
        cache: false,
        success: function(html) {
            if (html == " ") {
                alert("Error");
            } else {
                $( "#klik" ).html(html);
                $( "#klik" ).before(window.actual_id+"&emsp;");
                window.last_used = "prev";
                window.actual_id -= 5;
                if(window.actual_id < 0) {
                    window.actual_id = 0;
                }
            }
        },
        error: function () {
        }
    });
};

$( "document" ).ready(function() {
    $.ajax({
        url: "/getdata.php",
        data: "type=getnum",
        cache: false,
        success: function(html) {
            if (html == " ") {
                alert("Error");
            } else {
                window.num_articles = html;
            }
            if(getParameterByName('id')) {
                window.actual_id = getParameterByName('id') - 1;
            } else {
                window.actual_id = window.num_articles;
            }
            $.ajax({
                url: "/getdata.php",
                data: "type=next&data="+window.actual_id,
                cache: false,
                success: function(html) {
                    if (html == " ") {
                        alert("Error");
                    } else {
                        $( "#klik" ).html(html);
                        window.actual_id;
                        $( "#klik" ).before(window.actual_id+"&emsp;");
                    }
                },
                error: function () {
                }
            });
        },
        error: function () {
        }
    });
});