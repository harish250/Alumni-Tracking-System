var CONTROLLER_LINK = "controller.php";

jq = $.noConflict();

function setup(param) {
  switch (param) {
    case "postevent":
      formdata = postEventData();
      console.log(formdata);
      jq.ajax({
        type: "POST",
        url: CONTROLLER_LINK,
        data: formdata,
        processData: false,
        contentType: false,
        success: function (res) {
          if (res)
            jq("#promptmsg")
              .addClass("text-success text-center")
              .text("Posted SuccessFully");
          else
            jq("#promptmsg")
              .addClass("text-danger text-center")
              .text("Please enter correct Data");

          //  successupdate(res);
        },
        error: function (errResponse) {
          console.log(errResponse);
        },
      });
      break;

    case "loadevents":
      jq.get(CONTROLLER_LINK + "?action=getevents", loadEvents);
      break;
  }
}

function postEventData() {
  edate = jq("#enddate").val();
  etime = jq("#endtime").val();
  eamorpm = jq("#endampm").val();
  desc = jq("#description").val();
  file = document.getElementById("upload").files[0];
  console.log(file);
  formdata = new FormData();
  formdata.append("action", "uploadevent");
  formdata.append("title", jq("#title").val());
  formdata.append("sdate", jq("#startdate").val());
  formdata.append("stime", jq("#starttime").val());
  formdata.append("samorpm", jq("#startampm").val());
  formdata.append("edate", edate);
  formdata.append("etime", etime);
  formdata.append("eamorpm", eamorpm);
  formdata.append("description", desc);
  formdata.append("img", file);

  return formdata;
}

function loadEvents(data, status) {
  if (status === "success") {
    data = JSON.parse(data);
    row = jq("#eventcontent .row");
    row.empty();
    createEle = (class_) => {
      return jq("<div></div>").addClass(class_);
    };
    if (data.length == 0) {
      //
    } 
    else
    {
      for (eve of data) {
          console.log(eve);
        media = createEle("media col").attr({
          "data-aos": "zoom-in",
          "data-aos-duration": "2000",
        });
        a = jq("<a></a>").addClass("d-flex align-self-center");
        img = jq("<img/>")
          .addClass("img-fluid ml-4 mr-4")
          .attr({"src":eve.image_url,
          "width":"300",
          "height":"300"
                });

               
        a.append(img);
        mediaBody = createEle("media-body m-2");
        title = jq("<h1></h1>").text(eve.title).addClass("mt-5");
        
        mediaBody.append(title);
        // if sdate == edate then show a single date with timings
        // else show start and end date with respec time
        
        sdate = new Date(eve.start_date);
        edate = new Date(eve.end_date);
        console.log(sdate);
        // options = {
        //     year: 'numeric', month: 'numeric', day: 'numeric',
        //     hour: 'numeric', minute: 'numeric', second: 'numeric',
        //     hour12: true,
        //     timeZone: 'In/IST' 
        //   };
        //   console.log(new Intl.DateTimeFormat('en-US', options).format(sdate));


        // fun to cvt 24hr fmt to 12hr ampm fmt
        var processTime = (date)=>
        {
            info = (date.getHours()>12)?[-12,'pm']:[0,'am'];
            return date.getHours()+info[0] + ":" + date.getMinutes()+" "+ info[1];
        }

        //fun to cvt yyyy-mm-dd to dd-mm-yyyy
        var processDate = (date)=>
        {
           
            return date.getDate()+"-"+date.getMonth()+"-"+date.getFullYear();
        }
        
        from = processTime(sdate);
        to = processTime(edate);

        if(sdate.getDate() - edate.getDate() == 0)
        {
            timing = jq("<h6></h6>");
            timing.text(`Timings ${from} to ${to}`);
            event_date = jq("<h6></h6>");
            event_date.text(`Date ${processDate(sdate)}`);

            mediaBody.append(timing,event_date);
        }
        else
        {
            start_date = jq("<h6></h6>");
            end_date = jq("<h6></h6>");
            // start: 10-12-2020 6:30 pm  End: 10-12-2020 9:30 pm 
            start_date.text("Start Date "+processDate(sdate)+" "+from);
            end_date.text("End Date "+processDate(edate)+" "+to);

            mediaBody.append(start_date, end_date);
        }

        delbut = jq("<button></button>").addClass("btn btn-danger btn-lg mb-5 pull-right ").text("Delete");
        desc = jq("<h5></h5>").text(eve.description);
        mediaBody.append(desc,delbut);

        media.append(a,mediaBody);
        row.append(media);
      }
    }
  }
}
