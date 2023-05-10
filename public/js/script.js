$(document).ready(function () {
    //all event listeners

    $(document.body).on("click", ".play-week", function (e) {
        playNextWeek(e.target.attributes["data-week"]["value"]);
    });

    $(".simulate-all-weeks").on("click", function () {
        $.get("/play-all-weeks", function () {
            refreshFixture();
        });
    });

    $(".reset-all").on("click", function () {
        $.get("reset-all", function () {
            refreshFixture();
        });
    });

    //functions to do each event task

    function refreshFixture() {
        $.get("/fixtures", function (data) {
            var showData = $("#table-body");

            showData.empty();
            showData.hide();
            $.each(data.weeks, function (i, week) {
                var html = "";
                html +=
                    "<tr><td colspan='3' class='fixtures-box_header'>" +
                    week.title +
                    " Week Matches</td></tr>";
                $.each(data.items[week.id], function (i, item) {
                    html += "<tr>";
                    html +=
                        "<td class='make-center'><img width='30' height='30' src='/images/home_team.png'>" +
                        item.home_team +
                        "</td>";
                    html +=
                        "<td class='make-center'>" +
                        item.home_team_goal +
                        " - " +
                        item.away_team_goal +
                        "</td>";
                    html +=
                        "<td class='make-center'><img width='30' height='30' src='/images/away_team.png'>" +
                        item.away_team +
                        "</td>";
                    html += "</tr>";
                });
                if (data.items[week.id][0].status == 0) {
                    html += "<tr>";
                    html +=
                        "<td colspan='5' class='weekly-simulate-button make-center'>";
                    html +=
                        "<button  data-week='" +
                        week.id +
                        "' class='btn btn-warning play-week'> Simulate " +
                        week.title +
                        " Week  </button>";
                    html += "</td>";
                    html += "</tr>";
                }
                showData.append(html);
            });

            showData.show("slow");
            refreshStanding();
            prediction();
        });
    }

    function refreshStanding() {
        $.get("standings", function (data) {
            var showData = $("#standings-table tbody");
            showData.empty();
            showData.hide();
            $.each(data, function (i, item) {
                var html = "";
                html += "<tr>";
                html += "<td>" + item.name + "</td>";
                html += "<td>" + item.played + "</td>";
                html += "<td>" + item.won + "</td>";
                html += "<td>" + item.draw + "</td>";
                html += "<td>" + item.lose + "</td>";
                html += "<td>" + item.goal_drawn + "</td>";
                html += "<td>" + item.points + "</td>";
                html += "</tr>";
                showData.append(html);
            });
            showData.show("slow");
        });
    }

    function playNextWeek(weekId) {
        $.get("/play-week/" + weekId, function (data) {
            var showData = $("#weekly-matches");
            showData.empty();
            showData.hide();

            $.each(data.matches, function (i, item) {
                var html = "";
                if (i == 0) {
                    html +=
                        "<tr>" +
                        '<td colspan="3">' +
                        item.name +
                        " Matches</td>" +
                        "</tr>";
                }
                html +=
                    "<tr>" +
                    "<td>" +
                    item.home_team +
                    "</td>" +
                    '<td><span id="home-goal" data-match-id="' +
                    item.id +
                    '">' +
                    item.home_goal +
                    '</span> - <span id="away-goal"  data-match-id="' +
                    item.id +
                    '">' +
                    item.away_goal +
                    "</span></td>" +
                    "<td>" +
                    item.away_team +
                    "</td>" +
                    "</tr>";
                showData.append(html);

                if (item.played == 1) $("#play-weekly").hide();
            });
            showData.show("slow");

            refreshFixture();
        });
    }

    function prediction() {
        $.get("/prediction", function (data) {
            var html = "";
            $.each(data.items, function (team, percent) {
                html += "<tr>";
                html += "<th scope='row'>" + team + "</th>";
                html += "<td>" + percent + " % </td>";
                html += "</tr>";
            });

            $(".prediction-wrapper tbody").empty().html(html);
        });
    }
});
