//.ready() is a deprecated method that i mostly tried to not use but



if (!document.cookie.includes("style")) {
    document.cookie = "style=dark;"

} else {
    setStyle()
    $(".nav").load(location.href + " .nav>*", "");
}

//Used to fetch data from the api provided by the coursework assignment, calls getProbs, returns country name, code and probability strings, along with person's name.
function getNat2(name) {
    $.ajax(
        {
            url: "https://api.nationalize.io?name=" + name,
            type: "get",
            dataType: "json",
            async: false
        }
    ).done(function (response) {
        let result = getProbs(response, name)
        alert(result);

    })

}

//used to fetch the name of a given country based on code provided by nationalize api
//had to turn off async because the 2nd api call is slower than the first one, it often resulted in the alert being shown before the api call has been received
function getProbs(data, person) {
    let country_id = data['country']
    let country = "Name: " + person + " \n"
    for (let i = 0; i < country_id.length; i++) {
        $.ajax(
            {
                url: "https://restcountries.com/v2/alpha/" + country_id[i]['country_id'],
                type: "get",
                dataType: "json",
                async: false
            }
        ).done(function (response) {
            country += response['name'] + " (" + country_id[i]['country_id'] + ") " + country_id[i]['probability'] + "%" + "\n";
        })
    }
    return country
}
//The following 4 functions are all called on document load to pick the correct style based on cookie
// or are called to switch between styles on button press
function setLight() {
    $("#changeStyle")
        .removeClass("btn-dark").removeClass("dark-mode")
        .addClass("btn-light")
    $("#theme").attr("href", "css/style-light.css")

    $(".align-text-top").text("Dark mode")
    document.cookie = "style=; expires=Thu, 01 Jan 1970 00:00:00 UTC;"
    document.cookie = "style=light;"
}


function setDark() {
    $(".align-text-top").text("Light mode")
    $("#theme").attr("href", "css/style.css")
    $("#changeStyle").removeClass("btn-light")
        .addClass("btn-dark")
    document.cookie = "style=; expires=Thu, 01 Jan 1970 00:00:00 UTC;"
    document.cookie = "style=dark;"

}

function setStyle() {
    if (document.cookie.includes("dark")) {
        $(".align-text-top").text("Light mode")
        $("#theme").attr("href", "css/style.css")
        $("#changeStyle").removeClass("btn-light")
            .addClass("btn-dark")
    } else {
        $(".align-text-top").text("Dark mode")
        $("#changeStyle")
            .removeClass("btn-dark").removeClass("dark-mode")
            .addClass("btn-light")
        $("#theme").attr("href", "css/style-light.css")
    }
}
//the function that decides which function to choose for style change
function changeMode() {
    if (document.cookie.includes("dark")) {
        setLight()
    } else {
        setDark()
    }

}
//sets cookie for the sort needed on index.php
function setSort(element) {
    document.cookie = "sort=" + element.val() + "; path=/";
}
//on page  div load it will run an interval
$(".dynamic").ready(function () {
    getFunStuff()

    setInterval(function () {
        getFunStuff()
    }, 2000)
})

//ran at an interval, refreshed the content on the page by removing and appending a whole div full of the stylized query results
function getFunStuff() {

    let postIDs = [];
    $.getJSON("API.php").done(function (data) {
        $(".posts").remove();

        for (let index = 0; index < data.length; index++) {
            //data: Array(19)
            //value: Object(17)
            postIDs.push(data[index]['postid'])
            if (data[index]['uid'] === null) {
                data[index]['firstname'] = "Anonymous";
                data[index]['lastname'] = "";
            }

            if (data[index]['image'] === null) {
                $("#append").append(`<div class='posts col-xl-3 col-lg-4 col-sm-6'> <div class=\"card\"> <div id=\"${data[index]['postid']}\" class=\"card-body\"><p>${data[index]['title']}</p><p>${data[index]['firstname']} ${data[index]['lastname']}</p><p>${data[index]['created']}</p><p>${data[index]['content']}</p></div></div></div>`)
            } else {
                $("#append").append(` <div  class='posts col-xl-3 col-lg-4 col-sm-6'> <div class=\"card\"> <div id=\"${data[index]['postid']}\" class=\"card-body\"><img id=\"img\" src=\"${data[index]['image']}\" alt=\"${data[index]['image']}\"><p>${data[index]['title']}</p><p>${data[index]['firstname']} ${data[index]['lastname']}</p><p>${data[index]['created']}</p><p>${data[index]['content']}</p></div></div></div>`)
            }

        }
        if ($("#loggedIn").attr("value") === "admin")
            for (let i = 0; i < postIDs.length; i++) {
                let postid = postIDs[i]
                $(`#${postid}`).append(`<form name=\"uidUpdate\" method=\"POST\" action=\"update_post.php\">
                                 <button name=\"postidUpdate\" type=\"submit\"  value=\"${postid}\"  class=\"btn btn-primary\">Update</button>
                                 </form>
                                  <form  name=\"uidRemove\"  method=\"POST\" action=\"remove_post.php\">
                                 <button name=\"postidRemove\" type=\"submit\" value=\"${postid}\"  class=\"btn btn-danger\" >Remove</button>
                                 </form>`)
            }
    })

}

//used to submit the users form for editing in manage_users.php, making the whole "card" interactive, excuse the name but i love it.
function clicky(element) {
    element.submit();
}


function parentForm(element) {
    let form = $(element).parents('form:first');
    form.submit();
}

$("#form").mouseover(function () {
    $(this).css("cursor", "grab")
});
//updating the clock at regular invervals
document.addEventListener("DOMContentLoaded", function () {
    setInterval('updateClock()', 1000);
});

function nationalizeAPI(name) {
    console.log(name)
    alert(name)
}
//gets current date and time, adds it ot UTC-style string and pushed it to the page.
function updateClock() {
    let currentDateTime = new Date();
    let currentHours = currentDateTime.getHours();
    let currentMinutes = currentDateTime.getMinutes();
    let currentSeconds = currentDateTime.getSeconds();

    let currentDay = currentDateTime.getDay();
    let currentMonth = currentDateTime.getMonth();
    let currentYear = currentDateTime.getFullYear();
    currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
    currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;

    let timeOfDay = (currentHours < 12) ? "AM" : "PM";

    currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;

    currentHours = (currentHours == 0) ? 12 : currentHours;

    let currentDateTimeString = currentYear + "." + currentMonth + "." + currentDay + " " + currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

    let utcString = currentDateTimeString.toString("yyyy'-'MM'-'dd'T'HH':'mm':'ss'.'fff'Z'");

    document.getElementById("clock").innerHTML = utcString;
}

$(document).ready(function () {
    $('#sort').change(function () {
        if ($(this).find("option:selected")) {
            $("#title-ASC").submit();
        }
    });
});

