/*
24hr fmt to 12hr fmt
http://www.onlineconversion.com/date_12-24_hour.htm
*/

var CONTROLLER_LINK = "controller.php";

jq = $.noConflict();

function setup(param) {
    switch (param) {
        case "postevent":
            formdata = postEventData();
            jq.ajax({
                type: "POST",
                url: CONTROLLER_LINK,
                data: formdata,
                processData: false,
                contentType: false,
                success: postEvent,
                error: function(errResponse) {
                    console.log(errResponse);
                }
            });
            break;

        case "loadevents":
            jq.get(CONTROLLER_LINK + "?action=getevents", loadEvents);
            break;
    }
}

function postEvent(res) 
{
    if (res)
    {
        jq("#promptmsg")
        .addClass("text-success")
        .text("Posted SuccessFully");

        setup('loadevents');
    }
    else
        jq("#promptmsg")
        .addClass("text-danger")
        .text("Please enter correct Data");
}

function postEventData() {

    file = document.getElementById("upload").files[0];
    formdata = new FormData();
    formdata.append("action", "uploadevent");
    formdata.append("title", jq("#title").val());
    formdata.append("sdate", jq("#startdate").val());
    formdata.append("stime", jq("#starttime").val());
    formdata.append("samorpm", jq("#startampm").val());
    formdata.append("edate", jq("#enddate").val());
    formdata.append("etime", jq("#endtime").val());
    formdata.append("eamorpm", jq("#endampm").val());
    formdata.append("description", jq("#description").val());
    formdata.append("img", file);

    return formdata;
}

function loadEvents(data, status) 
{
    if (status === "success")
    {
        data = JSON.parse(data);
        row = jq("#eventcontent .row");
        row.empty();
        createEle = (class_) => 
        {
            return jq("<div></div>").addClass(class_);
        };
        if (data.length == 0) 
        {
            div = createEle("text-center col p-3");
            ack = jq("<h3></h3>").addClass("text-muted font-italic").text("No active Events");
            div.append(ack);
            row.append(div);
        }
        else
        {
            for (eve of data)
            {
                media = createEle("media col-12").attr({
                    "data-aos": "zoom-in",
                    "data-aos-duration": "2000",
                });
                a = jq("<a></a>").addClass("d-flex align-self-center");
                img = jq("<img/>")
                    .addClass("img-fluid ml-4 mr-4")
                    .attr({
                        "src": eve.image_url,
                    });

                a.append(img);
                mediaBody = createEle("media-body m-2");
                title = jq("<h1></h1>").text(eve.title).addClass("mt-5");

                mediaBody.append(title);
                // if sdate == edate then show a single date with timings
                // else show start and end date with respec time

                sdate = new Date(eve.start_date);
                edate = new Date(eve.end_date);

                // fun to cvt 24hr fmt to 12hr ampm fmt 
                var timeConv_12_to_24 = (date) => 
                {
                    hr = date.getHours();
                    min = date.getMinutes();

                    if(hr <=11) //its am
                    {
                        hr_12_fmt = (hr == 0)?hr+12:hr;
                        return ("0"+hr_12_fmt).slice(-2) + ":"+("0"+min).slice(-2)+" am";
                    }
                    else //if hr>=12 it's pm i.e., subtract 12 from hr except for 12pm
                    {
                        hr_12_fmt = (hr == 12)?hr:hr-12;
                        return ("0"+hr_12_fmt).slice(-2) + ":"+("0"+min).slice(-2)+" pm";
                    }
                }

                //fun to cvt yyyy-mm-dd to dd-mm-yyyy
                var processDate = (date) => 
                {
                    return ("0"+date.getDate()).slice(-2) + "-" + ("0"+(date.getMonth()+1)).slice(-2) + "-" + date.getFullYear();
                }

                from = timeConv_12_to_24(sdate);
                to = timeConv_12_to_24(edate);

                if (sdate.getDate() - edate.getDate() == 0) 
                {
                    timing = jq("<h6></h6>");
                    timing.text(`Timings ${from} to ${to}`);
                    event_date = jq("<h6></h6>");
                    event_date.text(`Date ${processDate(sdate)}`);

                    mediaBody.append(timing, event_date);
                }
                else
                {
                    start_date = jq("<h6></h6>");
                    end_date = jq("<h6></h6>");
                    // start: 10-12-2020 6:30 pm  End: 10-12-2020 9:30 pm 
                    start_date.text("Start Date " + processDate(sdate) + " " + from);
                    end_date.text("End Date " + processDate(edate) + " " + to);

                    mediaBody.append(start_date, end_date);
                }

                delbut = jq("<button></button>")
                        
                        .attr({"class":"btn btn-danger btn-lg mb-5 pull-right","data-gov":`${eve.event_id}`
                    })
                        .text("Delete")
                        .click(function(){
                            deleve(this);
                        });
                desc = jq("<h5></h5>").text(eve.description);
                mediaBody.append(desc, delbut);

                media.append(a, mediaBody);
                row.append(media);
            }
        }
    }
}

function deleve(e)
{
    jq.post(
        CONTROLLER_LINK,
        {
            action: "deleteevent",
            event_id:jq(e).attr("data-gov")
        },
        deleteEvent
    )
}
function deleteEvent(data, status)
{
    if(data)
        setup('loadevents');
}