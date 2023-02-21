if (sessionStorage.expanded === 'true') {
    document.getElementById('sidebar').style.width = 'var(--sidebar-width)';
} else {
    document.getElementById('sidebar').style.width = 'calc(2rem + 32px)'
}
document.addEventListener('sidebarStatusChanged', (e) => {
    if (sessionStorage.expanded === 'true') {
        document.getElementById('sidebar').style.width = 'var(--sidebar-width)';
    } else {
        document.getElementById('sidebar').style.width = 'calc(2rem + 32px)'
    }
});
///// navigation with vue js and jquery
function initJQueryGlobaly() {

}
var global_app1;
var global_currentLink = null;
var global_vueMounted = true;
var global_extendedScripts = null;
var global_extendedStyles = null;
var global_divEl = document.createElement('div');
global_divEl.innerHTML = "<h1>wait a second!</h1>";

function resetNavVar() {
    global_extendedScripts = null;
    global_extendedStyles = null;
    global_divEl.innerHTML = "<h1>wait a second!</h1>";
}

function resetNavigationVars() {
    global_extendedScripts = null;
    global_extendedStyles = null;
    global_divEl.innerHTML = "<h1>wait a second!</h1>";
}

function GlobalAppContainerLoadFinished() {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            let condition = true;
            var startTime = Date.now();
            try {
                while (condition) {
                    if (Date.now() - startTime > 7000) {
                        condition = false;
                        throw new Error("something went rong!");
                    }
                    if ($('.app-container').html() == global_divEl.innerHTML) {
                        condition = false;
                        resolve("vue mounted allowed");
                    }
                    console.log("not now!");
                }

            } catch (error) {
                console.log(error);
                alert("حدث خطأ ما , استمرت العملية وقت اطول من المتوقع ")
                location.reload();
            }
        }, 100);
    });
}
async function vueMountGlobaly() {
    var result = await GlobalAppContainerLoadFinished();
    console.log(result);
    if (!global_vueMounted) {
        global_app1 = new Vue(vueAppOptions);
        global_app1.$mount('.app-container');
        global_vueMounted = true;
        initJQueryGlobaly();
        $('.extendedStyles').html(global_extendedStyles);
        $('.extendedScripts').html(global_extendedScripts);
        $('.app-container').css("visibility", "visible");
        console.log("vue Mounted");
    }
}

function navigatTo(e, el) {
    e.preventDefault();
    global_currentLink = el;
    history.pushState("", "", $(el).attr("href"));
    $('.app-container').css("visibility", "hidden");
    global_vueMounted = false;
    resetNavigationVars();
    $.ajax({
            type: "get",
            url: $(el).attr("href"),
            success: function(response) {
                if (response.title != null) {
                    document.title = response.title
                }
                global_extendedStyles = response.extendedStyles != null ? response.extendedStyles : null;
                global_extendedScripts = response.extendedScripts != null ? response.extendedScripts : null;
                global_divEl.innerHTML = response.content != null ? response.content : null;
                $('.app-container').html(response.content != null ? response.content : null);
            }
        })
        .then(() => {
            vueMountGlobaly();
        });
}