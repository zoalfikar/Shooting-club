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

// function elementLoadFinished(temporaryHTML) {
//     $.when(temporaryHTML).then(async function(temporaryHTML) {
//         var result = await vueMountNow(temporaryHTML);
//         console.log(result);
//         if (!vueMounted) {
//             app1 = new Vue(vueAppOptions);
//             app1.$mount('.app-container');
//             vueMounted = true;
//             initJQuery();
//             // $('.app-container').css("visibility", "visible");
//             console.log("vue Mounted");
//         }

//     });
// }
// async function vueMountNow(temporaryHTML) {
//     return new Promise((resolve, reject) => {
//         setTimeout(() => {
//             let condition = true;
//             var startTime = Date.now();
//             try {
//                 while (condition) {
//                     if (Date.now() - startTime > 7000) {
//                         condition = false;
//                         throw new Error("something went rong!");
//                     }
//                     if ($('html').html() == temporaryHTML.innerHTML) {
//                         condition = false;
//                         resolve("vue mounted allowed");
//                     }
//                     console.log("not now!");
//                 }

//             } catch (error) {
//                 console.log(error);
//                 alert("حدث خطأ ما , استمرت العملية وقت اطول من المتوقع ")
//                 location.reload();
//             }
//         }, 100);
//     });
// }

// function vueReMounteElement(element) {
//     var temporaryHTML = document.createElement('html');
//     $(element).load(location.href + ' ' + element, '', function(response, status) {
//         temporaryHTML.innerHTML = response;
//         console.log(response);
//         console.log($(document).html());
//     });
//     elementLoadFinished(temporaryHTML);


// }
