var CONTROLLER_LINK = "controller.php";

jq = $.noConflict();

function setup(param)
{
    switch(param)
    {
        case 'load':
            jq.get(CONTROLLER_LINK+"?action=loadevents", loadEvents);
    }
}

var getFormatedDate = (date)=>{
    curr_date = new Date();
    days_ago = (date.getMonth() - curr_date.getMonth())*30 +  date.getDate() - curr_date.getDate();
    
    var divide = (days, val, append)=>{
        temp = Math.floor(days/val);
        console.log(temp,append);
        return (temp)?temp+""+append+" ":"";
    }

    custom = "";
    custom += divide(days_ago,30,"m");
    days_ago %= 30;
    custom += divide(days_ago,7,"w");
    days_ago %= 7;
    custom += divide(days_ago,1,"d");
    
    return (custom)?`${custom} to go..!`:"Today";
}

function loadEvents(data, status) 
{
    if (status === "success")
    {
        data = JSON.parse(data);
        row = jq("#events-content .row");
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
                media = createEle("media col-12 mb-2").attr({
                    "data-aos": "zoom-in",
                    "data-aos-duration": "2000",
                });
                a = jq("<a></a>").addClass("d-flex align-self-center");
                img = jq("<img/>")
                    .addClass("img-fluid mr-4")
                    .attr({
                        "src": eve.image_url,
                    });

                a.append(img);
                mediaBody = createEle("media-body m-2");

                // if sdate == edate then show a single date with timings
                // else show start and end date with respec time

                sdate = new Date(eve.start_date);
                edate = new Date(eve.end_date);
                
                days_to_go = getFormatedDate(sdate);
                div = createEle("text-right")
                div.append(jq("<h4></h4>").text(days_to_go).addClass("text-muted"));
                title = jq("<h3></h3>").text(eve.title)
                // title.append(div);
                mediaBody.append(div,title);
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

                desc = jq("<h6></h6>").text(eve.description);
                mediaBody.append(desc);

                media.append(a, mediaBody);
                row.append(media);
            }
        }
    }
}
